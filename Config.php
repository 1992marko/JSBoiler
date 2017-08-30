<?php

	class SiteConfig
	{
		// ********************* API SETTINGS
		CONST API = "/api";

		// ********************* DB SETTINGS
		CONST DBHOST 						= "localhost";
		CONST DBUSER 						= "root";
		CONST DBPASS 						= "borming";
		CONST DBNAME 						= "jsboiler";

		// ********************* CMS DIRECTORY SETTINGS
		CONST APPHOST    = "/";
		CONST COPYHOST    = "";
		CONST UPLOADDIR   = "../../";
		
		//DEGUB
		CONST DEBUG 						= true;
		
		// CORVUS
		CONST CORVUS_URL 					= "";
		CONST CORVUS_CART_DESCRIPTION 		= "";
		CONST CORVUS_STORE_ID 				= 0;
		CONST CORVUS_SHA_KEY 				= "";
		
		// CURRENCIES
		CONST CURRENCIES 					= array("HRK", "EUR");
		CONST DEFAULTCURRENCY				= "EUR";
		CONST TIMEZONE       				= "GMT+1";
  		CONST THOUSANDSSEPARATOR   			= '.';
  		CONST DECIMALSEPARATOR    			= ',';
  		CONST DATEFORMAT     				= 'd.m.Y';

	} 
	
?>