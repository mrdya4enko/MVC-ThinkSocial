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
        $name = false;
        $email = false;
        $password = false;
        $result = false;
        $errors = false;

        if (isset($_POST['submit'])) {

            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];


            if (!User::checkName($name)) {
                $errors['name'] = 'Имя не должно быть короче 2-х символов';
            }
            if (!User::checkEmail($email)) {
                $errors['email'] = 'Неправильный email';
            }
            if (!User::checkPassword($password)) {
                $errors['password'] = 'Пароль не должен быть короче 6-ти символов';
            }
            if (User::checkEmailExists($email)) {
                $errors['email'] = 'Такой email уже используется';
            }

            if ($errors == false) {

                $result = User::register($name, $email, $password);

                if($result){
                	$to = substr(htmlspecialchars(trim($email)), 0, 1000);
                    $subject = 'Регистрация на портале';
              $message = '
                <html>
                    <head>
                        <title>'.$subject.'</title>
                    </head>
                    <body>
                        <strong>'.$name.' </strong>'.'<br>
                        Спасибо за регистрацию на нашем портале                    
                    </body>
                </html>'; 
  
           $headers  = 'MIME-Version: 1.0' . "\r\n";
           $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
          
                     mail($to, $subject, $message, $headers);
				}

               $userId = User::checkUserData($email, $password);

                if ($userId == false) {
                    $errors['password'] = 'Неправильные данные для входа на сайт';
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

            if ($userId == false) {
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