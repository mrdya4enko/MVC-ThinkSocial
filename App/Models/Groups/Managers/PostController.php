<?php
namespace App\Models\Groups\Managers;

use App\Models\Groups\Butler;

class PostController implements GroupPageMethodController
{
    private $butler;

    public function __construct(Butler $butler)
    {
        $this->butler = $butler;
    }

    public function handleRequest()
    {
        if (!$this->butler['GroupValidator']->isExists()) {
            $this->butler['Messenger']->setHeader("X-COMMENT-RESPONSE: Group is not Exists");
            $this->butler['Messenger']->send406Response();
        } else {
            if (!$this->butler['UserValidator']->isOwner()) {
                $this->butler['Messenger']->setHeader("X-COMMENT-RESPONSE: You have no access to this place!");
                $this->butler['Messenger']->send403Response();
            } else {
                $this->checkAction();
            }
        }
    }

    private function checkAction()
    {
        switch ($_SERVER['HTTP_X_PAGE_ACTION']) {
            case "avatar_upload":
                $this->updateAvatar();
                break;
            default:
                $this->butler['Messenger']->send400Response();
        }
    }

    private function updateAvatar()
    {
        if (!$this->butler['InputFilter']->isValidPicture($_FILES['avatar'])) {
            $msg = "X-COMMENT-RESPONSE:" . $this->butler['InputFilter']->getReason();
            $this->butler['Messenger']->setHeader($msg);
            $this->butler['Messenger']->send406Response();
        } else {
            $result = $this->butler['GroupManager']->saveAvatar();
            if (!$result) {
                $this->butler['Messenger']->send503Response();
            } else {
                $this->butler['Messenger']->setHeader("Location: $result");
                $this->butler['Messenger']->send201Response();
            }
        }
    }

    public function methodCheck()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            return true;
        } else {
            return false;
        }
    }
}
