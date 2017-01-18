<?php
namespace App\Controllers;
use App\Models\{User, Phone};

/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:31
 */

Class ProfileController Extends PageController
{


    public function actionShow()
    {
        $result = parent::actionIndex();
        $result['templateNames'] = [
            'head', 'navbar', 'leftcolumn', 'middleprofile', 'rightcolumn', 'footer',
        ];
        $result['title'] = 'Профиль';
        $result['submitAction'] = 'edit';
        $result['submitValue'] = 'Редактировать';
        $result['submitPhoneAction'] = 'input';
        $result['submitPhoneValue'] = 'Добавить';
        $result['allowEdit'] = 'disabled';
        $result['userPhones'] = Phone::getByCondition(['userId' => $this->userId]);

        return $result;
    }


    public function actionEdit()
    {
        $result = parent::actionIndex();
        $result['templateNames'] = [
            'head', 'navbar', 'leftcolumn', 'middleprofile', 'rightcolumn', 'footer',
        ];
        $result['title'] = 'Редактирование профиля';
        $result['submitAction'] = 'update';
        $result['submitValue'] = 'Подтвердить';
        $result['submitPhoneAction'] = 'input';
        $result['submitPhoneValue'] = 'Добавить';
        $result['allowEdit'] = 'enabled';
        $result['userPhones'] = Phone::getByCondition(['userId' => $this->userId]);

        return $result;
    }


    public function actionInput()
    {
        $result = parent::actionIndex();
        $result['templateNames'] = [
            'head', 'navbar', 'leftcolumn', 'middleprofile', 'rightcolumn', 'footer',
        ];
        $result['title'] = 'Добавление телефона';
        $result['submitAction'] = 'edit';
        $result['submitValue'] = 'Редактировать';
        $result['submitPhoneAction'] = 'insert';
        $result['submitPhoneValue'] = 'OK';
        $result['allowEdit'] = 'disabled';
        $result['userPhones'] = Phone::getByCondition(['userId' => $this->userId]);

        return $result;
    }


    public function actionUpdate()
    {
        $this->userId = User::checkLogged();

        $user = User::getByID($this->userId);
        foreach ($_POST as $field => $value) {
            $user->{$field} = $value;
        }
        $user->update();
        header('Location: http://ts.local/profile/show/');
    }


    public function actionInsert()
    {
        $this->userId = User::checkLogged();

        $newPhone = new Phone();
        $newPhone->userId = $this->userId;
        $newPhone->phone = $_POST['newPhone'];
        $newPhone->insert();
        header('Location: http://ts.local/profile/show/');
    }


    public function actionDelete()
    {
        Phone::delete($_POST['phoneID']);
        header('Location: http://ts.local/profile/show/');
    }
}
