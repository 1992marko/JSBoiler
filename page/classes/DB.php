<?php 

require_once __DIR__."/../../Config.php";

class Website
{ 

	public static $connected = false;
	public static $dbh;

	
	public static function PDODBConnect(){
		
		$dbhost="localhost";
		$dbuser= SiteConfig::DBUSER;
		$dbpass=SiteConfig::DBPASS;
		$dbname=SiteConfig::DBNAME;
		$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $dbuser, $dbpass);	
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->exec("set names utf8");
		return $dbh;
	
	}

	public static function getConnection() {
		
		if(!self::$connected){
			self::$dbh = self::PDODBConnect();
		} 

		return self::$dbh;
	
	}

} 
?>