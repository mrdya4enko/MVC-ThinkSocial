<?php
namespace App\Controllers;

use App\Models\{Friend, User};

class FriendController extends PageController
{


    public function actionAccept()
    {
        $this->userId = User::checkLogged();

        if (isset($_POST['friendRequestId'])) {
            $friendReqId = $_POST['friendRequestId'];
            Friend::setStatus($friendReqId, 'applied');
        }
        header('Location: /');
    }


    public function actionDecline()
    {
        $this->userId = User::checkLogged();

        if (isset($_POST['friendRequestId'])) {
            $friendReqId = $_POST['friendRequestId'];
            Friend::setStatus($friendReqId, 'declined');
        }
        header('Location: /');
    }


    public function actionIncoming()
    {
        $result = parent::actionIndex();
        $result['templateNames'] = [
            'head', 'navbar', 'leftcolumn', 'middlefriends', 'rightcolumn', 'footer',
        ];
        $result['title'] = 'Incoming friend requess';

        return $result;
    }
}
