<!--
File Name: database.php
File Author: Alissa Myers
Purpose: Holds all database functions
-->
<?php
class Database 
{
	private static $dbName = 'xxx' ; 
	private static $dbHost = 'xxx' ;
	private static $dbUsername = 'xxxx';
	private static $dbUserPassword = 'xxx';
	
	private static $cont  = null;
	
	public function __construct() {
		exit('Init function is not allowed');
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
	
	public function login() {
		
		echo '<!DOCTYPE HTML><html><head><title>Log In</title><meta charset="utf-8"/><meta name="viewport" content="width=device-width, initial-scale=1"/><link rel="stylesheet" href="assets/css/main.css"/></head><body><div id="page-wrapper"><header id="header"><h1><a href="index.html">Book Reviews</a></h1><nav><a href="#menu">Menu</a></nav></header><nav id="menu"><div class="inner"><h2>Menu</h2><ul class="links"><li><a href="home.php">Home</a></li><li><a href="books.ph[">Books</a></li><li><a href="read_readers.php">Readers</a></li><li><a href="profile.php">Profile</a></li><li><a href="logout_reader.php">Log Out</a></li></ul><a href="#" class="close">Close</a></div></nav><section id="wrapper"><header><div class="inner"><h2>Log In</h2></div></header><div class="wrapper"><div class="inner"><form action="login_reader.php" method="POST"><div class="field"><label>Username</label><input type="text" name="username"></div><div class="field"><label>Password</label><input type="password" name="password"></div><input type="submit" value="Log In"><a href="create_reader.php" class="button special">Sign Up</a></div></div></section></div><script src="assets/js/skel.min.js"></script><script src="assets/js/jquery.min.js"></script><script src="assets/js/jquery.scrollex.min.js"></script><script src="assets/js/util.js"></script><script src="assets/js/main.js"></script></body></html>';

	}
	
	public function mainMenu() {
		echo '<header id="header"><h1><a href="home.php">Book Reviews</a></h1><nav><a href="#menu">Menu</a></nav></header><nav id="menu"><div class="inner"><h2>Menu</h2><ul class="links"><li><a href="home.php">Home</a></li><li><a href="books.php">Books</a></li><li><a href="read_readers.php">Readers</a></li><li><a href="profile.html">Profile</a></li><li><a href="logout_reader.php">Log Out</a></li></ul><a href="#" class="close">Close</a></div></nav>';
	}

}
?>
