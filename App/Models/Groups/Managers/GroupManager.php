<?php

namespace App\Models\Groups\Managers;

use App\Models\User;
use App\Models\Group;
use App\Models\UserGroup;
use App\Models\GroupsAvatars;
use App\Models\Groups\Butler;

/**
 * Class GroupManager
 * @package App\Models\Groups\Managers
 */

class GroupManager
{
    private $butler;

    /**
     * GroupManager constructor.
     * @param Butler $butler
     */
    public function __construct(Butler $butler)
    {
        $this->butler = $butler;
    }

    /**
     * On success returns new Group Instance else returns false
     * @return Group|bool
     */
    public function addGroup()
    {
        try {
            $userGroup = new UserGroup();
            $avatar = new GroupsAvatars();
            $userGroup->userId = $this->butler['CurrentUser'];
            $group = new Group();
            $group->name = $this->butler['InputFilter']->clearStr($_POST['group-name']);
            $group->description = $this->butler['InputFilter']->clearStr($_POST['description']);
            $userGroup->roleId = 4;
            $group->insert();
            if (empty($group->id)) {
                return false;
            } else {
                $userGroup->groupId = $group->id;
                $avatar->groupId = $group->id;
                $avatar->fileName = GroupsAvatars::DEFAULT_AVATAR_PIC;
                $userGroup->insert();
                $avatar->insert();
                return $group;
            }
        } catch (\Throwable $ex) {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function subscribe()
    {
        $userGroup = new UserGroup();
        $userGroup->userId = $this->butler['CurrentUser'];
        $userGroup->groupId = $this->butler['CurrentGroup']->id;
        $userGroup->roleId = UserGroup::USER_GROUP_SUBSCRIBER;
        $userGroup->insert();
        if ($userGroup->id) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function unSubscribe()
    {
        $userGroup = $this->butler['UserGroup'];
        $userGroup->delete($userGroup->id);
        $this->butler['UserGroup'] = null;
        return true;
    }

    public function saveAvatar()
    {
        $path = "avatars";
        $id = $this->butler['CurrentGroup']->id;
        $name = str_replace(" ", "_", $this->butler['CurrentGroup']->name);
        $ext = $this->butler['InputFilter']->getFileExtension();
        $imageName =  $id . "_" . $name . "_" . "Avatar" . "." . $ext;
        $fullPath = $path . DIRECTORY_SEPARATOR . $imageName;
        if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $fullPath)) {
            return false;
        } else {
            $avatar = GroupsAvatars::getByCondition(['groupId' => $id])[0];
            $avatar->fileName = $imageName;
            if (true) {
                $avatar->update();
                return $fullPath;
            } else {
                return false;
            }
        }
    }
}
