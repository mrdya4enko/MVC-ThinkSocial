<?php
namespace App\Models;

use App\Components\ActiveRecord;

/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:29
 */

class User extends ActiveRecord
{
    protected static $tableName = 'users';
    protected static $tableFields = [
                                     'id' => 'id',
                                     'first_name' => 'firstName',
                                     'middle_name' => 'middleName',
                                     'last_name' => 'lastName',
                                     'email' => 'email',
                                     'birthday' => 'birthday',
                                     'sex' => 'sex',
                                     'status' => 'status',
                                    ];

        /**
         * User Register
         * @param string $name <p>Name</p>
         * @param string $email <p>E-mail</p>
         * @param string $password <p>Password</p>
         * @return boolean <p>The result of method execution</p>
         */
        public static function register($options)
    {
        $user = new User();
        $user->firstName = $options['firstName'];
        $user->middleName = $options['middleName'];
        $user->lastName = $options['lastName'];
        $user->sex = $options['gender'];
        $user->email = $options['email'];
        $user->insert();

        $userPassword = new Password();
        $userPassword->userId = $user->id;
        $userPassword->password = $options['password'];
        $userPassword->insert();
    }

        /**
         * Check if a user already exists with the specified $email and $password
         * @param string $email <p>E-mail</p>
         * @param string $password <p>Password</p>
         * @return mixed : integer user id or false
         */
        public static function checkUserData($email, $password)
    {
        $user = User::getByCondition(['email' => $email]);
        if (! $user) {
            return false;
        }
        $userPassword = Password::getByCondition(['userId' => $user[0]->id, 'password' => $password]);
        return $userPassword? $user[0]->id : false;

    }

        /**
         * Remember user
         * @param integer $userId <p>id users</p>
         */
        public static function auth($userId)
    {
        $_SESSION['user'] = $userId;
    }

        /**
         * Returns the ID of the user if it is authorized.<br/>
         * Otherwise redirects to the login page
         * @return string <p>User ID</p>
         */
        public static function checkLogged()
    {
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }

        header('Location: /user/login');
        exit;
    }

        /**
         * Checks if the user is a guest
         * @return boolean <p>Result</p>
         */
        public static function isGuest()
    {
        if (isset($_SESSION['user'])) {
            return false;
        }
        return true;
    }


        /**
         * Checks the name: correct name
         * @param string $name <p>Name</p>
         * @return boolean <p>Result</p>
         */
        public static function checkName($name)
    {
        if(preg_match('/^[a-zA-Zа-яёА-ЯЁ\s\-]+$/u', $name))
            return true;
        return false;
    }

        /**
         * Check the phone: not less than 10 characters
         * @param string $phone <p>Phone</p>
         * @return boolean <p>Result</p>
         */
        public static function checkPhone($phone)
    {
        if (strlen($phone) >= 10) {
            return true;
        }
        return false;
    }

        /**
         * Checks the name: no less than 6 characters
         * @param string $password <p>Password</p>
         * @return boolean <p>Result</p>
         */
        public static function checkPassword($password)
    {
        if (strlen($password) >= 6) {
            return true;
        }
        return false;
    }

        /**
         * Checks email
         * @param string $email <p>E-mail</p>
         * @return boolean <p>Result</p>
         */
        public static function checkEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

        /**
         * Checks whether the email is not occupied by another user
         * @param type $email <p>E-mail</p>
         * @return boolean <p>Result</p>
         */
        public static function checkEmailExists($email)
    {
        return User::count(['email' => $email]);
    }

        /**
         * Returns user with the specified id
         * @param integer $id <p>id users</p>
         * @return array <p>An array containing information about the user</p>
         */
        public static function getUserById($id)
    {
        return User::getByID($id);
    }


    /**
     * Send mail to user
     * @param $mail
     * @param $name
     */
    public static function sendMailToUser($mail, $name)
    {
        $to = substr(htmlspecialchars(trim($mail)), 0, 1000);
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

    /**
     * Check user register fields
     * @param $options
     * @return bool
     */
    public static function checkUserDataFieldsRegister($options)
    {
        $errors = false;

        if (!self::checkName($options['firstName'])) {
            $errors['firstName'] = 'Incorrect First Name';
        }
        if (!self::checkName($options['middleName'])) {
            $errors['middleName'] = 'Incorrect Middle Name';
        }
        if (!self::checkName($options['lastName'])) {
            $errors['lastName'] = 'Incorrect Last Name';
        }
        if (!self::checkEmail($options['email'])) {
            $errors['email'] = 'Incorrect email';
        }

        if (self::checkEmailExists($options['email'])) {
            $errors['email'] = 'This email is already in use';
        }

        if (!self::checkPassword($options['password'])) {
            $errors['password'] = 'The password must not be shorter than 6 characters';
        }

        return $errors;
    }


}