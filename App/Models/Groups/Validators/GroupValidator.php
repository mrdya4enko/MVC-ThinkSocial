<?php
namespace App\Models\Groups\Validators;

use App\Models\Group;
use App\Models\Groups\Butler;

/**
 * Class GroupValidator
 * @package App\Models\Groups\Validators
 */
class GroupValidator
{
    private $butler;

    /**
     * GroupValidator constructor.
     * @param Butler $butler
     */
    public function __construct(Butler $butler)
    {
        $this->butler = $butler;
    }

    /**
     * @return bool
     */
    public function isExists()
    {
        if (!$this->butler['GroupKey']) {
            return false;
        } else {
            $group = Group::getByCondition(['id' => $this->butler['GroupKey']]);
            if (!$group) {
                return false;
            } else {
                $this->butler['CurrentGroup'] = $group[0];
                return true;
            }
        }
    }
}
