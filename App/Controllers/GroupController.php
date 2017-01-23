<?php

namespace App\Controllers;

use App\Models\UserGroup;
use App\Models\Groups\Butler;

/**
 * Class GroupController
 *
 * @package App\Controllers
 */
class GroupController extends PageController
{
    /**
     * Returns Page with your groups and groups user is subscribed.
     *
     * @Route="groups"
     */

    public function actionIndex()
    {
        $response = parent::actionIndex();
        $response['templateNames'] = [
            'head', 'navbar', 'leftcolumn', 'groups/mi_groups', 'rightcolumn', 'footer',
        ];
        $response['title'] = 'Группы';
        UserGroup::clearJoins();
        UserGroup::clearJoinsDB();
        UserGroup::join('groupId', 'App\Models\Group', 'id');
        UserGroup::join('groupId', 'App\Models\GroupsAvatars', 'groupId', " AND status='active'");
        $response['myGroups'] = UserGroup::getByCondition(['userId' => $this->userId, 'roleId' => 4]);
        $response['Groups'] = UserGroup::getByCondition(['userId' => $this->userId, 'roleId' => 5]);
        return $response;
    }


    /**
     * @return array
     */
    public function actionFind()
    {
        $response = parent::actionIndex();
        $response['templateNames'] = [
            'head', 'navbar', 'leftcolumn', 'groups/find', 'rightcolumn', 'footer',
        ];
        $response['title'] = 'Группы';
        UserGroup::clearJoins();
        UserGroup::clearJoinsDB();
        UserGroup::join('groupId', 'App\Models\Group', 'id');
        UserGroup::join('groupId', 'App\Models\GroupsAvatars', 'groupId', " AND status='active'");
        $response['findGroups'] = UserGroup::getByCondition(['userId' => $this->userId.'/<>']);
        return $response;
    }

    /**
     * Subscribe to the group
     */

    public function actionSubscribe()
    {
        $butler = new Butler(func_get_args());
        if ($_SERVER['REQUEST_METHOD'] !== "POST") {
            $butler['Messenger']->setHeader('Allow: POST');
            $butler['Messenger']->send405Response();
        } else {
            if (!$butler['GroupValidator']->isExists()) {
                $butler['Messenger']->setHeader('X-COMMENT-RESPONSE: Group in not Exists');
                $butler['Messenger']->send404Response();
            } else {
                if ($butler['UserValidator']->isOwner()) {
                    $butler['Messenger']->setHeader('X-COMMENT-RESPONSE: You are group owner');
                    $butler['Messenger']->send406Response();
                } else {
                    if ($butler['UserValidator']->isSubscriber()) {
                        $butler['Messenger']->setHeader('X-COMMENT-RESPONSE: You are already Subscribed');
                        $butler['Messenger']->send406Response();
                    } else {
                        $result = $butler['GroupManager']->subscribe();
                        if (!$result) {
                            $butler['Messenger']->send503Response();
                        } else {
                            $butler['Messenger']->send204Response();
                        }
                    }
                }
            }
        }
    }

    /**
     * Unsubscribe from the group
     */
    public function actionUnSubscribe()
    {
        $butler = new Butler(func_get_args());
        if ($_SERVER['REQUEST_METHOD'] !== "POST") {
            $butler['Messenger']->setHeader('Allow: POST');
            $butler['Messenger']->send405Response();
        } else {
            if (!$butler['GroupValidator']->isExists()) {
                $butler['Messenger']->setHeader('X-COMMENT-RESPONSE: Group in not Exists');
                $butler['Messenger']->send404Response();
            } else {
                if ($butler['UserValidator']->isOwner()) {
                    $butler['Messenger']
                        ->setHeader('X-COMMENT-RESPONSE: Group Owner has no possibility to Unsubscribe');
                    $butler['Messenger']->send406Response();
                } else {
                    if (!$butler['UserValidator']->isSubscriber()) {
                        $butler['Messenger']->setHeader('X-COMMENT-RESPONSE: You are not Subscribed');
                        $butler['Messenger']->send406Response();
                    } else {
                        $result = $butler['GroupManager']->unSubscribe();
                        if ($result) {
                            $butler['Messenger']->send204Response();
                        } else {
                            $butler['Messenger']->send503Response();
                        }
                    }
                }
            }
        }
    }

    /**
     * Returns JSON from search bar on index group page
     */
    public function actionMyGroupsJSON()
    {
        $butler = new Butler();
        if (!$_SERVER['REQUEST_METHOD'] !== "POST") {
            $butler['Messenger']->setHeader('Allow: POST');
            $butler['Messenger']->send405Response();
        } else {
            if (empty($_POST['search'])) {
                $butler['Messenger']->setHeader('X-COMMENT-RESPONSE: No search property set');
                $butler['Messenger']->send406Response();
            } else {
                $response = $butler['GroupManager']->userGroupsSearch();
                $butler['Messenger']->sendNewJSONResponse($response);
            }
        }
    }

    /**
     * Return JSON with foreign groups
     */

    public function actionFindGroupsJSON()
    {
        $butler = new Butler();
        if (!$_SERVER['REQUEST_METHOD'] !== "POST") {
            $butler['Messenger']->setHeader('Allow: POST');
            $butler['Messenger']->send405Response();
        } else {
            if (empty($_POST['search'])) {
                $butler['Messenger']->setHeader('X-COMMENT-RESPONSE: No search property set');
                $butler['Messenger']->send406Response();
            } else {
                $response = $butler['GroupManager']->groupsSearch();
                $butler['Messenger']->sendNewJSONResponse($response);
            }
        }
    }

    /**
     * Create Group action
     */
    public function actionMyGroupCreateJSON()
    {
        $butler = new Butler();
        if ($_SERVER['REQUEST_METHOD'] !== "POST") {
            $butler['Messenger']->setHeader('Allow: POST');
            $butler['Messenger']->send405Response();
        } else {
            if (empty($_POST['group-name'])) {
                $butler['Messenger']->setHeader('X-COMMENT-RESPONSE: Group name can\'t be empty');
                $butler['Messenger']->send406Response();
            } else {
                $group = $butler['GroupManager']->addGroup();
                if (!$group) {
                    $butler['Messenger']->send503Response();
                } else {
                    $url = "/groups/page/id" . $group->id;
                    $butler['Messenger']->setHeader("Location: $url");
                    $butler['Messenger']->setHeader('X-COMMENT-RESPONSE: Group has been successfully created');
                    $butler['Messenger']->send201Response();
                }
            }
        }
    }

    /**
     * Get group page action
     *
     * @Route="group/page/id"
     */

    public function actionGroupPage()
    {
        $butler = new Butler(func_get_args());
        if ($butler['GetController']->methodCheck()) {
             return $butler['GetController']->handleRequest();
        } elseif ($butler['PostController']->methodCheck()) {
             $butler['PostController']->handleRequest();
        } else {
             $butler['Messenger']->send405Response();
        }
    }
}
