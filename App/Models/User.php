<?php
namespace App\Models;
use App\Config\Db;
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:29
 */

class User extends ActiveRecord
{
    protected static $tableName = 'users';
    protected static $tableFields = ["id" => "id",
                                    "first_name" => "firstName",
                                    "middle_name" => "middleName",
                                    "last_name" => "lastName",
                                    "email" => "email",
                                    "birthday" => "birthday",
                                    "sex" => "sex",
                                    "status" => "status",
    ];

        /**
         * User Register
         * @param string $name <p>Name</p>
         * @param string $email <p>E-mail</p>
         * @param string $password <p>Password</p>
         * @return boolean <p>The result of method execution</p>
         */
        public static function register($name, $email, $password)
    {
        $user = new User();
        $user->first_name = $name;
        $user->middle_name = "";
        $user->last_name = "";
        $user->birthday = "1900-01-01";
        $user->sex = "male";
        $user->email = $email;
        $user->insert();

        $userPassword = new Password();
        $userPassword->user_id = $user->id;
        $userPassword->password = $password;
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
        $user = User::getByCondition(["email" => $email]);
        if (! $user) {
            return false;
        }
        $userPassword = Password::getByCondition(["userId" => $user[0]->id, "password" => $password]);
        return $userPassword? $user[0]->id : false;

/*        $db = Db::getConnection();

        $sql = 'SELECT u.id, first_name, middle_name, last_name, email, birthday, sex, status 
                 FROM users u
                     INNER JOIN passwords p
                        ON u.id = p.user_id
                           WHERE u.email = :email AND p.password = :password';

        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, \PDO::PARAM_INT);
        $result->bindParam(':password', $password, \PDO::PARAM_INT);
        $result->execute();

        $user = $result->fetch();

        if ($user) {
            return $user['id'];
        }
        return false;*/
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

        header("Location: /user/login");
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
         * Checks the name: no less than 2 characters
         * @param string $name <p>Name</p>
         * @return boolean <p>Result</p>
         */
        public static function checkName($name)
    {
        if (strlen($name) >= 2) {
            return true;
        }
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
        return User::count(["email" => $email]);
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


        public static function getUserName()
    {
        $userId = self::checkLogged();
        $user = self::getUserById($userId);

        return $user['firstName'];
    }


}