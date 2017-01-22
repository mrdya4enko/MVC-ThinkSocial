<?php
namespace App\Models\Groups;

use App\Models\Groups\Managers\Messenger;
use App\Models\Groups\Managers\GroupManager;
use App\Models\Groups\Managers\PageManager;
use App\Models\Groups\Validators\UserValidator;
use App\Models\Groups\Validators\GroupValidator;
use App\Models\Groups\Tools\InputFilter;
use App\Models\User;

/**
 * Class Butler
 * @package App\Models\Groups
 */
class Butler implements \ArrayAccess
{
    private $container = [];

    /**
     * Butler constructor.
     * @param array $input
     */

    public function __construct(array $input = [])
    {
        $this->container['CurrentUser'] = User::checkLogged();
        $this->container['Messenger'] = new Messenger();
        $this->container['InputFilter'] = new InputFilter();
        $this->container['GroupManager'] = new GroupManager($this);
        $this->container['GroupValidator'] = new GroupValidator($this);
        $this->container['UserValidator'] = new UserValidator($this);
        $this->container['CurrentGroup'] = null;
        $this->container['UserGroup'] = null;
        $this->container['GroupAvatars'] = null;
        $id = $this->container['InputFilter']->idPrepare($input);
        if (!empty($id)) {
            $this->container['GroupKey'] = $id;
        } else {
            $this->container['GroupKey'] = 0;
        }
    }

    /**
     * @return PageManager
     */
    public function getPageManager()
    {
        return new PageManager($this);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * @param mixed $offset
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }
}
