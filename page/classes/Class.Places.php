<?php

header('Access-Control-Allow-Origin: *'); 
error_reporting(1);

//require_once('Class.Users.php');
require_once('Class.Modules.php');
require_once('Class.Navigacija.php');
require_once('Class.Language.php');

class Places 
{ 
	
	public $selectedKategoryID;
	private $unionSelect;
	private $arr = array();
	private $counter;
	public $perPage = 27;
	private $htaccess = true;
	private $rootMenuID;
	public $lastResultTotal;
	public $IDs;
	
	
	public function __construct() { } 


	public function getForCategory($ID, $paging = false, $filters = array(), $getSubCategorys = true, $orderBy = null, $type = null){

		if(isset($_GET["str"])){
			$offset = ($_GET["str"] - 1) * $this->perPage;
			$append = " LIMIT $offset, ".$this->perPage."";	
		}

		else{
			if($paging){
				$append = " LIMIT 0, ".$this->perPage."";
			} else {
				$append = " LIMIT 0, 1000";
			}
			
		}

		if(!isset($orderBy)){
			$orderBy = "p.naziv";
		}

		if($type){
			$type = " and p.type = ".$type;

		}

		foreach ($filters as $key => $value){
			if($value){
				$filtersString .= " JOIN places_katv vez".$key." on vez".$key.".ID_place = p.ID and vez".$key.".ID_kat = ".$value."";
			}
		}

		if($getSubCategorys){
			$subCats = $this->getSubIDs($ID);
		}
		
		$sql = "
			SELECT 
				result.ID, 
				result.naziv, 
				result.adresa, 
				result.tel, 
				result.place_rbr, 
				result.email, 
				result.web, 
				result.heading, 
				result.opis, 
				IFNULL(media.FileName, 'noimage.jpg') as FileName, 
				result.PagesLink, 
				result.KategoryName, 
				result.KategoryID, 
				result.link, 
				result.ID_kat, 
				result.lat, 
				result.lng, 
				result.rbr, 
				result.CustomFieldsValues, 
				result.price,
				ms.MediaFilePath
			FROM (
					SELECT 
						p.ID, 
						p.link, 
						p.rbr as place_rbr, 
						p.naziv, 
						p.heading,
						p.opis, 
						p.adresa, 
						p.tel, 
						p.email, 
						p.web, 
						vez.ID_kat, 
						pg.lat, pg.lng, 
						pa.ID as KategoryID, 
						pa.rbr, 
						pa.link as PagesLink, 
						pa.name as KategoryName, 
						p.CustomFieldsValues, 
						p.price 
					FROM  places p 
					JOIN places_katv vez ON vez.ID_place = p.ID AND vez.ID_kat IN ('".$ID."'".$subCats.") 
					JOIN places_katv vez2 ON vez2.ID_place = p.ID AND vez2.MainKategory = 1 
					LEFT JOIN pages pa ON pa.ID = vez2.ID_kat ".language::getLang('pa.')." 
					LEFT JOIN places_gmap pg on p.ID = pg.ID_Place
					$filtersString
					WHERE p.published = 1 ".Language::getLang('p.')." $type
					GROUP BY p.ID ORDER BY $orderBy $append
			) as result
			LEFT JOIN media ON result.ID = media.ForeignID AND media.ForeignType = 3 AND media.MediaGroup = 'heading'
			LEFT JOIN ModuleSettings ms on ms.MediaForeignType = media.ForeignType 
			ORDER BY result.place_rbr ASC
		";
				
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();

		if($paging){

			$sql = "select 
				result.ID from ( select 
				p.ID from
			    places p 
			    JOIN places_katv vez on vez.ID_place = p.ID and vez.ID_kat in ('".$ID."'".$subCats.")
			    $filtersString
			    WHERE p.published = 1 ".Language::getLang('p.')." ) as result ";

			$this->lastResultTotal = $this->getCountForQuery($sql);
			

		}
		
		return $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

	}


	public function getInteractions( $UsersInteractionsType, $paging = false ){

		if(isset($_GET["str"])){
			$offset = ($_GET["str"] - 1) * $this->perPage;
			$append = " LIMIT $offset, ".$this->perPage."";	
		}

		else{
			$append = " LIMIT 0, ".$this->perPage."";
		}

		$sql = "
				SELECT * FROM UsersInteractions ui 
				JOIN videos v on ui.ForeignID = v.ID and v.isDraft = 0 and v.lang = 'hr' 
				LEFT JOIN media on ui.ForeignID = media.ForeignID and media.ForeignType = ".MyModules::VIDEOS." and media.MediaGroup = 'heading' 
				WHERE ui.UsersID=:UsersID and ui.UsersInteractionsType = :UsersInteractionsType and ui.ForeignType = ".MyModules::VIDEOS." ORDER BY ui.DateCreated DESC $append ";

		

		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam(':UsersID', $_SESSION["USER"]["ID"]);
		$stmt->bindParam(':UsersInteractionsType', $UsersInteractionsType );
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		if($paging){
			$sql = "
				SELECT * FROM UsersInteractions ui 
				JOIN videos v on ui.ForeignID = v.ID and v.isDraft = 0 and v.lang = 'hr' 
				WHERE ui.UsersID=".$_SESSION["USER"]["ID"]." and ui.UsersInteractionsType = ".$UsersInteractionsType." and ui.ForeignType = ".MyModules::VIDEOS." ORDER BY ui.DateCreated LIMIT 1000 ";


			$this->lastResultTotal = $this->getCountForQuery($sql);
		}

		return $rows;
	}


	public function getCountForQuery($sql){
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);
		$stmt->execute();
		return $count = $stmt->rowCount();
	}
	

	public function getSubIDs($id){
		$this->IDs = "";
		return $this->subIDsRecurse($id);
	}


	public function subIDsRecurse($id){
		
		$sql = "select ID from pages WHERE id_rod = $id ".Language::getLang()."";
		
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();

		while($link = $stmt->fetch(PDO::FETCH_ASSOC) ){
			$this->IDs .= ","."'".$link[ID]."'";
			$this->subIDsRecurse($link[ID]);
		}

		return $this->IDs;

	}


	
	
	public function buildQuery( $Categories, $Fieldname ){

		$categories = array(
			'OR' => '',
			'AND' => '',
		);

		foreach ($Categories as $key) {

			switch ($key["SearchOperator"]) {
				case 'OR':
					$categories["OR"] .= $Fieldname." = ".$key["ID"]." or ";
					break;
				
				case 'AND':
					$categories["AND"] .= $Fieldname." = ".$key["ID"]." and ";
					break;
			}
			
		}

		$categories["OR"] = substr($categories["OR"],0, -4);
		$categories["AND"] = substr($categories["AND"],0, -4);

		$categories["OR"] = trim($categories["OR"]) != "" ? "(".$categories["OR"].")" : "";
		$categories["AND"] = trim($categories["AND"]) != "" ?  "(".$categories["AND"].")" : "";

		$retVal = $categories["OR"] .( trim($categories["OR"]) != "" && trim($categories["AND"]) != "" ? " and " : "") .$categories["AND"];
		return trim($retVal) == "" ? "" : "and ".$retVal;

	}

	public function search($_keyword, $duration = "", $category = ""){
		
		$keyword = "%".$_keyword."%";
		$append = "";
		if(strlen($duration)) $append .= "JOIN places_katv vez1 on vez1.ID_place = p.ID and vez1.ID_kat IN(".$duration.")";
		if(strlen($category)) $append .= "JOIN places_katv vez2 on vez2.ID_place = p.ID and vez2.ID_kat IN(".$category.")";
		
		$sql = "select 
					result.ID, 
					result.naziv, 
					result.adresa, 
					result.tel, 
					result.email, 
					result.web, 
					result.heading, 
					IFNULL(media.FileName, 'noimage.jpg') as FileName, 
					result.PagesLink, 
					result.KategoryName, 
					result.KategoryID, 
					result.link, 
					result.ID_kat, 
					result.lat, 
					result.lng, 
					result.rbr, 
					result.CustomFieldsValues, 
					result.price,
					result.lang
					FROM 
				( 
				select 
					p.ID, 
					p.link, 
					p.naziv, 
					p.heading, 
					p.adresa, 
					p.tel, 
					p.email, 
					p.web, 
					vez.ID_kat, 
					p.lat, 
					p.lng, 
					pa.ID as KategoryID, 
					pa.rbr, 
					pa.link as PagesLink, 
					pa.name as KategoryName, 
					CustomFieldsValues, 
					price,
					p.lang
				FROM places p
				JOIN places_katv vez on vez.ID_place = p.ID and vez.MainKategory = 1
			    LEFT JOIN pages pa on pa.ID = vez.ID_kat ".language::getLang('pa.')." 
			    $append
			    WHERE p.published = 1 AND ( p.naziv like :keyword or p.tags like :keyword ) ".Language::getLang('p.')." 
				GROUP BY p.ID
				) 
				AS result
				LEFT JOIN media on result.ID = media.ForeignID and media.ForeignType = 3 and media.MediaGroup = 'heading'";


		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam(':keyword', $keyword);
		$stmt->execute();
		return $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getReated($KatID, $PlaceID){

		$sql = "select 
				result.ID, result.naziv, result.heading, media.FileName, ms.MediaFilePath from ( select 
				v.ID, v.link, v.naziv, v.heading from
			    videos v 
			    JOIN videosKat_v vez on vez.VideoID = v.ID and vez.KatID in ('".$KatID."'".$this->getSubIDs($KatID).")
			    WHERE v.published = 1 and v.ID != ".$PlaceID." ".Language::getLang('v.')." 
				LIMIT 3 ) 
				as result
				LEFT JOIN media on result.ID = media.ForeignID and media.ForeignType = 6 and media.MediaGroup = 'heading'
				LEFT JOIN ModuleSettings ms on ms.MediaForeignType = media.ForeignType 
				ORDER BY result.ID DESC";

		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();
		
		return $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

	}


	public function getGallery($VideosID){
		
		$sql = "SELECT * from media WHERE ForeignType = 6 and ForeignID = :VideosID and MediaGroup = 'gallery";
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam(':VideosID', $VideosID);
		$stmt->execute();
		return $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	}
	
	public function getLatLon($placeID){
		$sql = "SELECT naziv, lat, lng from places WHERE ID = :placeID ".Language::getLang()." ";
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam(':placeID', $placeID);
		$stmt->execute();
		return $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getPlace($ID){
		// echo $ID." - ".$_SESSION["USER"]["ID"]."<hr>";

		$db = Website::getConnection();

		$sql = "
				select 
				pa.link as PagesLink, p.ID, p.link, p.naziv,p.naziv as name, p.heading, p.opis, p.DateCreated, p.adresa, p.tel, p.fax, p.email, p.web, p.lat, p.lng, media.FileName, ms.MediaFilePath, vez.ID_kat, ui1.UsersInteractionsType as Liked, p.price,p.CustomFieldsValues, p.TravelinkID, p.TravelinkProductCode
				from places p 
			    JOIN places_katv vez on vez.ID_place = p.ID and vez.MainKategory = 1
				LEFT JOIN pages pa on pa.ID = vez.ID_kat ".language::getLang('pa.')." 
			    LEFT JOIN media on p.ID = media.ForeignID and media.ForeignType = 3 and media.MediaGroup = 'heading'
			    LEFT JOIN ModuleSettings ms on ms.MediaForeignType = media.ForeignType 
			    LEFT JOIN UsersInteractions ui1 ON ui1.ForeignID = p.ID and ui1.ForeignType = media.ForeignType and ui1.UsersID = :UsersID and ui1.UsersInteractionsType = ".UsersInteractionsTypes::Like."
			    WHERE p.published = 1 and p.ID = :ID ".Language::getLang('p.')."
			";

		$stmt = $db->prepare($sql);  
		$stmt->bindParam(':ID', $ID);
		$stmt->bindParam(':UsersID', $_SESSION["USER"]["ID"]);
		$stmt->execute();
		$object = $stmt->fetchObject();

     	$gmaps = array();
		$sql = "select * from places_gmap where ID_place = ".$object->ID." order by sort asc";
		$stmt = $db->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$object->gmaps = $res;

		foreach ($res as $k => $v) {
			$sql = "select * from places_gmap_description where idPlaces_gmap = ".$v['idPlaces_gmap'];
			$stmt = $db->prepare($sql);
			$stmt->execute();
			$r = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$gDesc = [];
			for ($i = 0; $i < count($r); $i ++) {
    			$gDesc[$r[$i]['lang']] = $r[$i];
			}
			$object->gmaps[$k][description] = $gDesc;
		}

		return $object;
	}

	public function getStatic($_keyword){

		$keyword = "%".$_keyword."%";
		$rlike = '[[:<:]]'.$_keyword.'';
		/*$sql = "
		select CONCAT(UCASE(LEFT(result.name, 1)),SUBSTRING(result.name, 2)) as name from (
			SELECT 
				CASE 
					WHEN p.naziv like :keyword THEN p.naziv
					WHEN p.tags like :keyword THEN SUBSTRING_INDEX(SUBSTR(p.tags, LOCATE('$_keyword', p.tags) ), ',', 1)
				END as name, 
				lat, lng from places p
			JOIN places_katv pkv ON pkv.ID_place = p.ID and pkv.ID_kat = 1
			WHERE p.naziv like :keyword OR p.tags RLIKE '[[:<:]]$_keyword' ".Language::getLang("p.")."
			
			UNION ALL 

			SELECT pl.naziv as name, null, null from placesCitys pl 
			JOIN places p ON p.CitysID = pl.PlacesCitysID 
			WHERE pl.naziv like :keyword ) 
		as result
		GROUP by result.name
		";*/

		$sql = "
		select CONCAT(UCASE(LEFT(result.name, 1)),SUBSTRING(result.name, 2)) as name from (
			SELECT 
				CASE 
					WHEN p.naziv like :keyword THEN p.naziv
					WHEN p.tags like :keyword THEN SUBSTRING_INDEX(SUBSTR(p.tags, LOCATE('$_keyword', p.tags) ), ',', 1)
				END as name, 
				lat, lng from places p
			
			WHERE p.naziv like :keyword OR p.tags RLIKE '[[:<:]]$_keyword' ".Language::getLang("p.")." and p.published = 1 and p.type = 2
			
			 ) 
		as result
		GROUP by result.name
		";

		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam(':keyword', $keyword);
		//$stmt->bindParam(':rlike', $rlike);
		$stmt->execute();
		return $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getTermini($Place_ID){

		$sql = "SELECT DATE_FORMAT(datum_od,'%d.%m.%Y') as datum_od from termini WHERE ForeignType = :ForeignType and ForeignID = :ForeignID and datum_od > NOW()";
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindValue(':ForeignType', MyModules::PLACES);
		$stmt->bindValue(':ForeignID', $Place_ID);
		$stmt->execute();
		return $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

	}



}



//AJAX CALL
$mode = $_GET["mode"];


if(isset($_GET["mode"])){
	session_start();
	require_once("DB.php");
	$db = Website::getConnection();
	$places = new Places();

	switch($mode){
		case "getStatic":
		$result = $places->getStatic( $_GET["name"] );
		echo json_encode($result);
		break;

		case "search":
		$result = $places->search( $_GET["keyword"], $_GET["duration"], $_GET["category"] );
		echo json_encode($result);
		break;

		case "getPlace":
		$result = $places->getPlace( $_GET["ID"] );
		echo json_encode($result);
		break;

		case "all":
		$result = $places->getForCategory( $_GET["ID"] );
		echo json_encode($result);
		break;
	}


}

?>