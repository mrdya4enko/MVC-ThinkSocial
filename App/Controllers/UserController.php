<?php
namespace App\Controllers;

use App\Models\User;

class UserController
{
    /**
     * Action for page "Registration"
     */
    public function actionRegister()
    {
        $result = false;
        $errors = false;

        if (isset($_POST['submit'])) {

            $options['firstName'] = $_POST['firstName'];
            $options['middleName'] = $_POST['middleName'];
            $options['lastName'] = $_POST['lastName'];
            $options['email'] = $_POST['email'];
            $options['password'] = $_POST['password'];
            $options['gender'] = $_POST['gender'];

            $errors = User::checkUserDataFieldsRegister($options);

            if (!$errors) {

                $result = User::register($options);

                if($result){
                    User::sendMailToUser($options['email'],$options['firstName']);
                }

               $userId = User::checkUserData($options['email'], $options['password']);

                if (!$userId) {
                    $errors['password'] = 'Incorrect information to access the site';
                } else {
                    User::auth($userId);
                }
                header('Location: /');
            }
        }

        return ['templateNames' => ['/user/register'],
            'errors' => $errors];

    }

    /**
     * Action for page "Login"
     */
    public function actionLogin()
    {
        $email = false;
        $password = false;
        $errors = false;

        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            if (!User::checkEmail($email)) {
                $errors['email'] = 'Неправильный email';
            }
            if (!User::checkPassword($password)) {
                $errors['password'] = 'Пароль не должен быть короче 6-ти символов';
            }

            $userId = User::checkUserData($email, $password);

            if (!$userId) {
                $errors['password'] = 'Неправильные данные для входа на сайт';
            } else {
                User::auth($userId);

                header('Location: /');
            }
        }

        return ['templateNames' => ['/user/login'],
            'errors' => $errors];
    }

    /**
     * Delete user information from the session
     */
    public function actionLogout()
    {
        session_start();
        unset($_SESSION['user']);
        header('Location: /');
    }

}