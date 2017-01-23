<?php
namespace App\Models\Groups\Validators;

use App\Models\Groups\Butler;
use App\Models\UserGroup;

/**
 * Class UserValidator
 * @package App\Models\Groups\Validators
 */
class UserValidator
{
    private $butler;

    /**
     * UserValidator constructor.
     * @param Butler $butler
     */
    public function __construct(Butler $butler)
    {
        $this->butler = $butler;
    }

    /**
     * @return bool
     */
    private function check()
    {
        if (!$this->butler["UserGroup"]) {
              $select = UserGroup::getByCondition(['groupId' => $this->butler['CurrentGroup']->id,
                    'userId' => $this->butler['CurrentUser']]);
            if (!empty($select)) {
                $this->butler['UserGroup'] =  $select[0];
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    /**
     * @return bool
     */
    public function isOwner()
    {
        if (!$this->check()) {
            return false;
        } else {
            if ($this->butler['UserGroup']->roleId == UserGroup::USER_GROUP_OWNER) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * @return bool
     */
    public function isSubscriber()
    {
        if (!$this->check()) {
            return false;
        } else {
            if ($this->butler['UserGroup']->roleId == UserGroup::USER_GROUP_SUBSCRIBER) {
                return true;
            } else {
                return false;
            }
        }
    }
}
