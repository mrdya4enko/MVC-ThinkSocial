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
        $strFriends = '';
        if (!empty($result['friend'])) {
            $strFriends = implode(',', $result['friend']);
        }


        $result['myFriend'] = User::getByDirectSQL(
            ['userId' => $this->userId],
            "SELECT first_name as firstName, last_name as lastName, id 
             FROM users
             WHERE id IN ($strFriends)"
        );

        $avatar = User::getByDirectSQL(
            ['userId' => $this->userId],
            "SELECT user_id as userId, file_name as fileName, status as status
             FROM users_avatars
             WHERE user_id IN ($strFriends)"
        );

        $avatarUserId = [];
        $countAvatar = count($avatar);
        for ($i = 0; $i < $countAvatar; $i++) {
            $avatarUserId[] = $avatar[$i]->userId;
        }
        
        for ($i = 0; $i < $countFriends; $i++) {
            if (!empty($result['friend']) || !empty($avatarUserId)) {

                $searchAvatarFriend = in_array($result['friend'][$i], $avatarUserId);

                if (!$searchAvatarFriend) {
                    $result['myFriend'][$i]->avatarFileName = 'default.jpeg';
                } else {
                    for ($k = 0; $k < $countFriends; $k++) {
                        for ($j = 0; $j < $countAvatar; $j++) {
                            if ($result['myFriend'][$k]->id == $avatar[$j]->userId) {
                                $result['myFriend'][$k]->avatarFileName = $avatar[$j]->fileName;
                            }
                        }
                    }
                }
            }
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
            "SELECT first_name as firstName, last_name as lastName, id 
             FROM users 
             WHERE status = 'active' 
             AND id != $this->userId"
        );

        $avatar = User::getByDirectSQL(
            ['userId' => $this->userId],
            "SELECT user_id as userId, file_name as fileName, status as status
             FROM users_avatars
             WHERE user_id != $this->userId"
        );
        $countAvatar = count($avatar);
        for ($i = 0; $i < $countAvatar; $i++) {
            $avatarUserId[] = $avatar[$i]->userId;
        }
        
        $countPeople = count($result['people']);

        for ($i = 0; $i < $countPeople; $i++) {

            $peopleId[] = $result['people'][$i]->id;

            if (!empty($result['people'])) {

                $searchAvatarPeople = in_array($result['people'][$i]->id, $avatarUserId);
                
                if (!empty($result['friend'])) {

                    $searchFriend = in_array($peopleId[$i], $result['friend']);

                    if ($searchFriend) {
                        $result['people'][$i]->checkFriend = 'friend';
                    } else {
                        $result['people'][$i]->checkFriend = 'unFriend';
                    }
                } else {
                    $result['people'][$i]->checkFriend = 'unFriend';
                }

                if (!$searchAvatarPeople) {
                    $result['people'][$i]->avatarFileName = 'default.jpeg';
                } else {
                    for ($k = 0; $k < $countPeople; $k++) {
                        for ($j = 0; $j < $countAvatar; $j++) {
                            if ($result['people'][$k]->id == $avatar[$j]->userId) {
                                $result['people'][$k]->avatarFileName = $avatar[$j]->fileName;
                            }
                        }
                    }
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
