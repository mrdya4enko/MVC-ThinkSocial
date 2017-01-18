<?php
namespace App\Components;
/**
 * Class Db
 * Component for working with database
 */
class Db
{
	protected static $db;
	
	private function __construct(){
	}

    /**
     * Establishes a connection to the database
     * @return \PDO <p>Object of class PDO for working with DB</p>
     */
    public static function getConnection()
    {
    	if(self::$db === null) {
        // Get the connection parameters from a file
        $paramsPath = ROOT . '/App/Config/db_params.php';
        $params =
            include($paramsPath);

        // Set the connection
        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
        self::$db = new \PDO($dsn, $params['user'], $params['password']);

        // Specify the encoding
        self::$db->exec('set names utf8');
		}
		
		return self::$db;
    }

}

