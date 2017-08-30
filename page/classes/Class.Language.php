<?php
class Language 
{ 
	
	public static $multyLanguageSupport = true;
	public static $translations;
	
	public function __construct() {

	} 
	
	public static function getLang($prefix = ""){
		
		if(self::$multyLanguageSupport){
			return " and ".$prefix."lang = '".$_SESSION['lang']."'";
		}
	
	}

	public static function getTag(){
		
		if(self::$multyLanguageSupport){
			return $_SESSION['lang'];
		}
	
	}

	public static function getName(){
		
		if(self::$multyLanguageSupport){

			$sql = "select name from lang where tag = '".$_SESSION['lang']."'";
			$db = Website::getConnection();
			$stmt = $db->prepare($sql);  
			$stmt->execute();
			$lang = $stmt->fetchObject();
			
			return $lang->name;

		}
	
	}

	public static function getAll(){
		
		if(self::$multyLanguageSupport){

			$sql = "select * from lang";
			$db = Website::getConnection();
			$stmt = $db->prepare($sql);  
			$stmt->execute();			
			return $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
	
	}

	public static function getModuleOnAllLanguages($ModuleName){
		
		if(Language::$multyLanguageSupport){

			if($ModuleName){
				$append = "LEFT JOIN $ModuleName ON lang.tag = $ModuleName.lang and $ModuleName.ID = ".$_GET["objectID"]."";
				$prepend = "concat(pages.link, ifnull( concat('/', $ModuleName.link), '')) link";
			} else {
				$prepend = "pages.link";
			}
			
			$sql = "SELECT lang.name, lang.tag, $prepend
			FROM lang 
			LEFT JOIN pages ON pages.lang = lang.tag and pages.ID = ".$_GET["page"]->ID."
			$append
			";
			
			$db = Website::getConnection();
			$stmt = $db->prepare($sql);  
			$stmt->execute();
			return $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		}
	
	}

	public static function getModuleOnLang($obj, $lang){
		
		$sql = "select p2.link from $obj->Module p JOIN $obj->Module p2 on p.ID = p2.ID and p2.lang = '".$lang."' where p.link = '".$obj->Link."' ";
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();
		$row = $stmt->fetchObject();

		return $row->link;
	}

	
	public static function getDefaultLanguage(){
		
		$sql = "select * from lang where def = 1";
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();
		$lang = $stmt->fetchObject();
		
		return $lang->tag;
	
	}


	public static function PrepareWords(){
		
		$sql = "SELECT lg.key, lg.".$_SESSION['lang']." FROM dictionary lg";
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);
		$stmt->execute();  
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		Language::$translations = array();

		foreach ($rows as $row) {
			Language::$translations[$row['key']] = $row[$_SESSION['lang']];
		}

		return Language::$translations;
		
	}

	public static function getLangWords(){
		
		$sql = "SELECT * FROM langWords";
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);
		$stmt->execute();  
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		$temp = array();
		foreach($rows as $row){
			$key = $row["key"];
			unset($row["key"]);
			$temp[$key] = $row;
		}
		return $temp;
		
		
	}

	public static function getLinkOnLanguage($link, $language){
		
		if($ModuleName){
			$append = "LEFT JOIN $ModuleName ON lang.tag = $ModuleName.lang and $ModuleName.ID = ".$_GET["objectID"]."";
			$prepend = "concat(pages.link, ifnull( concat('/', $ModuleName.link), '')) link";
		} else {
			$prepend = "pages.link";
		}
		
		$sql = "SELECT lang.name, lang.tag, $prepend
		FROM lang 
		LEFT JOIN pages ON pages.lang = lang.tag and pages.ID = ".$_GET["pageID"]."
		$append
		";

		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();
		return $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		
		
	}
		
	
}
?>