<?php
	
	class MyModules {
		CONST NOVOSTI = 1;
		CONST PAGES = 2;
		CONST PLACES = 3;
		CONST EVENTS = 4;
		CONST GALLERY = 5;
		CONST VIDEOS = 6;
	}

	class UsersTransactionTypes {
		CONST Withdraw = 1;
		CONST Deposit = 2;
	}

	class UsersInteractionsTypes {
		CONST Like = 1;
		CONST Favorites = 2;
	}

	class ModuleSettings {
		
		public static function getTemplateID( $ModuleSettingsID ) {
			
			$sql = "SELECT * FROM ModuleSettings WHERE ModuleSettingsID=:ID";
		    $pdo = getConnection();
		    $stmt = $pdo->prepare($sql); 
		    $stmt->bindParam("ID", $ModuleSettingsID);
		    $stmt->execute();
		    
		    $obj = $stmt->fetchObject(); 
		    return $obj->TemplateID;
		
		}

	}

?>