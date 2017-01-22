<?php

namespace App\Controllers;

use App\Models\Groups\Tools\InputFilter;
use App\Models\User;
use App\Models\Group;
use App\Models\UserGroup;
use App\Models\Groups\Validators\GroupValidator;
use App\Models\Groups\Validators\UserValidator;
use App\Models\Groups\Managers\GroupManager;

/**
 * Class GroupController
 *
 * @package App\Controllers
 */
class GroupController extends PageController
{
    /**
     * Contains array
     * In cases with standard response should implements array with properties:
     * templateName Array of views files to be rendered from App/Templates,
     * title Page title,
     * Other data for template rendering
     * In cases with JSON response contains array with properties to response.
     *
     * @var array Should contain a response array.
     */

    private $response;

    /**
     * @var array Bag with validators
     */

    private $validator;

    /**
     * @var integer Id of current group
     */

    private $id;

    /**
     * Returns Page with your groups and groups user is subscribed.
     *
     * @Route="groups"
     */

    public function actionIndex()
    {
        $this->response = parent::actionIndex();
        $this->response['templateNames'] = [
            'head', 'navbar', 'leftcolumn', 'groups/mi_groups', 'rightcolumn', 'footer',
        ];
        $this->response['title'] = 'Группы';
        UserGroup::clearJoins();
        UserGroup::clearJoinsDB();
        UserGroup::join('groupId', 'App\Models\Group', 'id');
        UserGroup::join('groupId', 'App\Models\GroupsAvatars', 'groupId', " AND status='active'");
        $this->response['myGroups'] = UserGroup::getByCondition([
            'userId' => $this->userId, 
            'roleId' => UserGroup::USER_GROUP_OWNER]);
        $this->response['Groups'] = UserGroup::getByCondition([
            'userId' => $this->userId, 
            'roleId' => UserGroup::USER_GROUP_SUBSCRIBER]);
        return $this->response;
    }


    /**
     * @return array
     */
    public function actionFind()
    {
        $this->response = parent::actionIndex();
        $this->response['templateNames'] = [
            'head', 'navbar', 'leftcolumn', 'groups/find', 'rightcolumn', 'footer',
        ];
        $this->response['title'] = 'Группы';
        UserGroup::clearJoins();
        UserGroup::clearJoinsDB();
        UserGroup::join('groupId', 'App\Models\Group', 'id');
        UserGroup::join('groupId', 'App\Models\GroupsAvatars', 'groupId', " AND status='active'");
        $this->response['findGroups'] = UserGroup::getByDirectSQL(
            ['userId' => $this->userId],
            'SELECT distinct group_id as groupId FROM users_groups 
                    WHERE user_id <> :userId AND group_id NOT IN 
                          (SELECT group_id FROM users_groups WHERE user_id = :userId)'
            );
        return $this->response;
    }

    /**
     * Subscribe to the group
     */

    public function actionSubscribe()
    {
    }

    /**
     * Unsubscribe from the group
     */
    public function actionUnsubscribe()
    {
    }

    /**
     * Returns JSON from search bar on index group page
     */
    public function actionMyGroupsJSON()
    {
    }

    /**
     * Return JSON with foreign groups
     */

    public function actionFindGroupsJSON()
    {
    }

    /**
     * On success creates a new group and returns JSON string with message of response
     * and url of group page, if request was unsuccessful returns headers with error message.
     * Allowed Method is POST.
     *
     * @uses   GroupManager::addGroup() To add new Group in Database.
     * @uses   GroupController::sendNewJSONResponse() To send response to the client.
     * @return string JSON representation of GroupController::$response array.
     * @see    GroupController::$response Content of response described.
     * @see    GroupManager::class
     */
    public function actionMyGroupCreateJSON()
    {
        if ($_SERVER['REQUEST_METHOD'] !== "POST") {
            header("HTTP/1.1 405 Method is not allowed");
            header("Allow: POST");
            header("Refresh:1; url=/groups");
            exit;
        } else {
            if (empty($_POST['group-name'])) {
                header("HTTP/1.1 406 Not Acceptable");
                header("X-COMMENT-RESPONSE: Group name can't be empty");
                exit;
            } else {
                $groupManager = new GroupManager();
                $group = $groupManager->addGroup();
                if (!$group) {
                    header("HTTP/1.1 503 Service Unavailable");
                    header("Rerty-After: 15 minutes");
                    exit;
                } else {
                    $url = "http://ts.local/groups/page/id" . $group->id;
                    header("HTTP/1.1 201 Created");
                    header('Content-type: application/json; charset=utf-8');
                    $this->response = [
                        'message' => 'Group has been successfully created',
                        'url' => $url,
                    ];
                    $this->sendNewJSONResponse();
                    exit;
                }
            }
        }
    }

    /**
     * Get group page action
     *
     * @Route="group/page/id"
     */

    public function actionGetGroupPage()
    {
        try {
            $args = func_get_args();
            $this->groupPageInit($args);
            $this->response = $this->pageMicroController();
            return $this->response;
        } catch (\Exception $ex) {
            return $this->actionGroupIsNotExists();
        }
    }


    /**
     * @param $args
     * @throws \Exception
     */
    private function groupPageInit($args)
    {
        $filter = new InputFilter();
        $this->id = $filter->idPrepare($args);
        if (!empty($this->id)) {
            $this->validator['group'] = new GroupValidator($this->id);
            $this->validator['user'] = new UserValidator($this->id);
        } else {
            throw new \Exception("ID user has passed to URL is empty");
        }
    }

    /**
     * @return array
     * @throws \Exception
     */
    private function pageMicroController()
    {
        if ($this->validator['group']->isExists()) {
            $group = Group::getByID($this->id);
            if ($this->validator['user']->IsOwner()) {
                return $this->actionGroupOwner($group);
            } elseif ($this->validator['user']->IsSubscriber()) {
                return $this->actionGroupSubscriber($group);
            } else {
                return $this->actionGroupGuest($group);
            }
        } else {
            throw new \Exception("Group is not Exists");
        }
    }

    /**
     * Action of group owner
     *
     * @param  $group
     * @return array
     */
    private function actionGroupOwner(Group $group)
    {
        $this->response = parent::actionIndex();
        $this->response['templateNames'] = ['head',
            'navbar',
            'leftcolumn',
            'groups/management/groupPageContent',
            'groups/management/groupPageInfo'];
        $this->response['title'] = $group->name;
        return $this->response;
    }


    /**
     * @param Group $group
     * @return array
     */
    private function actionGroupSubscriber(Group $group)
    {
        $this->response = parent::actionIndex();
        $this->response['templateNames'] = ['head',
            'navbar',
            'leftcolumn'
        ];
        $this->response['title'] = $group->name;
        return $this->response;
    }


    /**
     * @param Group $group
     * @return array
     */
    private function actionGroupGuest(Group $group)
    {
        $this->response = parent::actionIndex();
        $this->response['templateNames'] = ['head',
            'navbar',
            'leftcolumn'
        ];
        $this->response['title'] = $group->name;
        return $this->response;
    }

    /**
     * @return array
     */
    private function actionGroupIsNotExists()
    {
        $this->response = parent::actionIndex();
        $this->response['templateNames'] = ['head',
            'navbar',
            'leftcolumn'
        ];
        $this->response['title'] = "Group NoT Found";
        return $this->response;
    }

    /**
     * Returns to the client new JSON string.
     */

    private function sendNewJSONResponse()
    {
        if (is_array($this->response)) {
            header("Content-Type: application/json");
            echo json_encode($this->response);
        }
    }
}
