<?php

namespace App\Controllers;

use App\Models;

class GroupController extends PageController
{
    /**
     * Returns Page with your groups and groups user is subscribed.
     * @Route="groups"
     */
    public function actionIndex()
    {
        $result = parent::actionIndex();
        $result['templateNames'] = [
            'head', 'navbar', 'leftcolumn', 'group/mi_groups', 'rightcolumn', 'footer',
        ];
        $result['title'] = 'Группы';
        Models\UserGroup::join('groupId', 'App\Models\GroupsAvatars', 'groupId', " AND status='active'");
        $result['myGroups'] = Models\UserGroup::getByCondition(['userId' => $this->userId, 'roleId' => 1]);
        $result['Groups'] = Models\UserGroup::getByCondition(['userId' => $this->userId, 'roleId' => 2]);
        return $result;
    }

    /**
     * Returns Page with all groups.
     */
    public function actionFind()
    {
        $result = parent::actionIndex();
        $result['templateNames'] = [
            'head', 'navbar', 'leftcolumn', 'group/find', 'rightcolumn', 'footer',
        ];
        $result['title'] = 'Группы';
        Models\UserGroup::join('groupId', 'App\Models\GroupsAvatars', 'groupId', " AND status='active'");
        $result['findGroups'] = Models\UserGroup::getByCondition(['userId' => $this->userId.'/<>']);
        return $result;
    }

    /**
     * Subscribe to the group
     */
    public function actionSubsribe()
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
     * @Route="Не важно"
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
     * Returns warning or redirect to new group
     */
    public function actionMyGroupCreateJSON()
    {

    }

    /**
     * Returns created group by actionMyGroupCreateJSON
     * @Route="group/edit/id
     */
    public function actionEdit()
    {

    }

    /**
     * Returns group Page
     * @param $id
     * @Route="group/id"
     */
    public function actionShow($id)
    {

    }

}