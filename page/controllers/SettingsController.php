<?php 

require_once __DIR__."/../classes/Class.Navigacija.php";
require_once __DIR__."/../../Config.php";

class SettingsController 
{ 	

	public function __construct($_page = null){
		
	}

	public function get(){

		$nav = new Navigacija();
		$headerNav = $nav->glavniMeni(1, true, true, true);
		$footer = $nav->glavniMeni(4, false, true, true);
		
		$settings = new stdClass();
		$settings->text = "App Settings";
		$settings->version = "1.0";
		$settings->headerNav = $headerNav;
		$settings->footerNav = $footer;
		$settings->API = SiteConfig::API;
		$settings->lang = $_SESSION["lang"];
		
		$user = new stdClass();
		
		if (isset($_SESSION["user"]))
		{	
			$u = new stdClass();
			$u->ime = $_SESSION["user"]->ime;
			$u->email = $_SESSION["user"]->email;
			$u->prezime = $_SESSION["user"]->prezime;
			$u->title = $_SESSION["user"]->title;
			$u->loggedIn = $_SESSION["user"]->loggedIn;

			$user = $_SESSION["user"];	
			$user->loggedIn = 1;
			
		}
		else
		{
			$user->loggedIn = 0;
		}

		$settings->user = $user;
		echo json_encode( $settings );

	}
	
} 
?>