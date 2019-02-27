<?php
class Database
{
    private static $dbName = 'conich6_linehaul_consulting' ;
    private static $dbHost = 'conichost.com' ;
    private static $dbUsername = 'conich6_linehaul_admin';
    private static $dbUserPassword = 'FedEx2310@#!';
     
    private static $cont  = null;
     
    public function __construct() {
        die('Init function is not allowed');
    }
     
    public static function connect()
    {
       // One connection through whole application
       if ( null == self::$cont )
       {     
        try
        {
          self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword); 
        }
        catch(PDOException $e)
        {
          die($e->getMessage()); 
        }
       }
       return self::$cont;
    }
     
    public static function disconnect()
    {
        self::$cont = null;
    }
}
?>