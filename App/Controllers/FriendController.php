<?php
namespace App\Controllers;

use App\Models\{
    Friend, User
};

class FriendController extends PageController
{
    public function actionIndex()
    {
        $result = parent::actionIndex();

        $result['friends'] = User::getByDirectSQL(
            ['userId' => $this->userId],
            "SELECT user_sender as userSender, user_receiver as userReceiver 
             FROM friends 
             WHERE (user_sender = $this->userId 
             OR user_receiver = $this->userId)
             AND status = 'applied'"
        );

        $countFriends = count($result['friends']);

        for ($i = 0; $i < $countFriends; $i++) {
            if ($result['friends'][$i]->userSender === $this->userId) {
                $result['friend'][] = $result['friends'][$i]->userReceiver;
            } else {
                $result['friend'][] = $result['friends'][$i]->userSender;
            }
        }

        User::joinDB('users.id', 'users_avatars', 'user_id', ['id' => 'userAvatarId', 'file_name' => 'avatarFileName'],
            true, " AND users_avatars.status = 'active'");

        for ($i = 0; $i < $countFriends; $i++) {
            $showFriend = $result['friend'][$i];
            $var = User::getByDirectSQL(
               ['userId' => $this->userId],
               "SELECT distinct first_name as firstName, last_name as lastName, id FROM users WHERE id = $showFriend"
           );
            $friends[$i] = User::getByID($result['friend'][$i]);
            $var[0]->avatarFileName = $friends[$i]->avatarFileName ?? 'default.jpeg';
            $result['myFriend'][$i] = $var[0];
        }

        $result['templateNames'] = [
            'head',
            'navbar',
            'leftcolumn',
            'middlefriends',
            'rightcolumn',
            'footer',
        ];
        $result['title'] = 'Friends';
        return $result;
    }

    public function actionAll()
    {
        $result = parent::actionIndex();

        $result['request'] = User::getByDirectSQL(
            ['userId' => $this->userId],
            "SELECT distinct user_sender as userSender, user_receiver as userReceiver 
             FROM friends 
             WHERE (user_sender = $this->userId 
             OR user_receiver = $this->userId)
             AND status = 'applied'"
        );
        $countFriends = count($result['request']);
        for ($i = 0; $i < $countFriends; $i++) {
            if ($result['request'][$i]->userSender === $this->userId) {
                $result['friend'][] = $result['request'][$i]->userReceiver;
            } else {
                $result['friend'][] = $result['request'][$i]->userSender;
            }
        }

        $result['people'] = User::getByDirectSQL(
            ['userId' => $this->userId],
            "SELECT distinct first_name as firstName, last_name as lastName, id 
             FROM users 
             WHERE status = 'active' 
             AND id != $this->userId"
        );

        $countPeople = count($result['people']);
        for ($i = 0; $i < $countPeople; $i++) {
            $peoplesId[] = $result['people'][$i]->id;
        }

        for ($i = 0; $i < $countPeople; $i++) {
            if (!empty($result['friend'])) {
                $searchFriend = in_array($peoplesId[$i], $result['friend']);
                if ($searchFriend) {
                    $result['people'][$i]->checkFriend = 'friend';
                } else {
                $result['people'][$i]->checkFriend = 'unFriend';
                }
            }
        }

        $result['templateNames'] = [
            'head',
            'navbar',
            'leftcolumn',
            'middlepeoples',
            'rightcolumn',
            'footer',
        ];
        $result['title'] = 'All people';
        return $result;
    }

    public function actionDelete($id)
    {
        $this->userId = User::checkLogged();
        User::getByDirectSQL(
            ['userId' => $this->userId],
            "UPDATE friends
             SET status = 'unapplied'
             WHERE (user_sender = $this->userId AND user_receiver = $id)
             OR (user_sender = $id AND user_receiver = $this->userId)"
        );
        header('Location: /friend/');
    }

    public function actionAdd($id)
    {
        $this->userId = User::checkLogged();
        $user = User::getByID($id);
        if (!$user || $user->id == $this->userId) {
            throw new \Exception('Wrong user id');
        }
        $users = User::getByDirectSQL(
            ['userId' => $this->userId],
            "SELECT distinct user_sender as userSender, user_receiver as userReceiver 
             FROM friends 
             WHERE (user_sender = $this->userId AND user_receiver = $id)
             OR (user_sender = $id AND user_receiver = $this->userId)
             AND (status = 'applied' OR status = 'unapplied')"
        );
        if (empty($users)) {
            $newFrend = new Friend();
            $newFrend->userSender = $this->userId;
            $newFrend->userReceiver = $id;
            $newFrend->status = 'applied';
            $newFrend->insert();
        } else {
            User::getByDirectSQL(
                ['userId' => $this->userId],
                "UPDATE friends
                 SET status = 'applied'
                 WHERE (user_sender = $this->userId AND user_receiver = $id)
                 OR (user_sender = $id AND user_receiver = $this->userId)"
            );
        }
        header('Location: /friend/all');
    }

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
