<?php

header('Access-Control-Allow-Origin: *'); 

class Events 
{ 
	
	public $selectedKategoryID;
	
	private $unionSelect;
	private $arr = array();
	private $counter;
	private $perPage = 5000;
	private $htaccess = true;
	private $rootMenuID;
	public $lastResultTotal;
	public $IDs;
	
	
	public function __construct() { } 
	
	
	public function getEvents($ID, $paging = false ){	

		$time = time();
		$currenttime = date ('Y-m-d H:i', $time - ($time % 300));

		if(isset($_GET[str])){
			$offset = ($_GET[str] - 1) * $this->perPage;
			$append = " LIMIT $offset, ".$this->perPage."";	
		}

		else{
			$append = " LIMIT 0, ".$this->perPage."";
		}

		/*$sql = "select 
				result.ID, result.KatID, result.naslov, result.link, result.heading, ModuleSettings.MediaFilePath, media.FileName, p.link as PagesLink, termini.datum_od, termini.datum_do, datediff(termini.datum_od, now()) as daysLeft from ( select 
				v.ID, v.link, v.naslov, v.heading, v.DateCreated, vez.KatID  from
			    events v 
			    JOIN eventsKat_v vez on vez.EventID = v.ID and vez.KatID in ('".$ID."'".$this->getSubIDs($ID).")
			    WHERE v.published = 1 ".Language::getLang('v.')." 
				GROUP BY v.ID $append ) 
				as result
				JOIN pages p on p.ID = result.KatID ".language::getLang('p.')." 
				LEFT JOIN media ON result.ID = media.ForeignID and media.ForeignType = 4 and media.MediaGroup = 'heading'
				LEFT JOIN ModuleSettings ON ModuleSettings.MediaForeignType = 4
				LEFT JOIN termini ON result.ID = termini.ForeignID and termini.ForeignType = 4
				ORDER BY result.ID DESC";*/

		/*$sql = "select 
				result.ID, result.KatID, result.naslov, result.link, result.heading, ModuleSettings.MediaFilePath, media.FileName, p.link as PagesLink, result.datum_od, result.datum_do, datediff(result.datum_od, now()) as daysLeft from ( select 
				v.ID, v.link, v.naslov, v.heading, v.DateCreated, vez.KatID , t.datum_od, t.datum_do from
			    events v 
			    JOIN eventsKat_v vez on vez.EventID = v.ID and vez.KatID in ('".$ID."'".$this->getSubIDs($ID).") and v.lang = 'hr' and v.published = 1
			    JOIN termini t ON v.ID = t.ForeignID and t.ForeignType = 4
				ORDER BY t.datum_od DESC LIMIT $limit) 
				as result
				
				JOIN pages p on p.ID = result.KatID ".language::getLang('p.')." 
				LEFT JOIN media ON result.ID = media.ForeignID and media.ForeignType = 4 and media.MediaGroup = 'heading'
				LEFT JOIN ModuleSettings ON ModuleSettings.MediaForeignType = 4
				";*/


		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();

		if($paging){

		}
		
		return $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
	}


	public function getLatestEvents($ID, $limit, $rand = false){	

		$time = time();
		$currenttime = date ('Y-m-d H:i', $time - ($time % 300));

		$DateAppend = " and (t.datum_od >= CURDATE() or (t.datum_do IS NOT NULL and t.datum_do >= CURDATE() ))";

		if($rand){
			$rand = ",RAND()";
		}

		$sql = "select 
				result.ID, result.KatID, result.naslov, result.link, result.web, result.ImeLokacije, result.LokacijaID, result.LokacijaLat, result.LokacijaLng, result.heading, ModuleSettings.MediaFilePath, media.FileName, p.link as PagesLink, result.datum_od, result.datum_do, datediff(result.datum_od, now()) as daysLeft from ( 

				select 
				v.ID, v.link, v.web, v.naslov, v.heading, v.DateCreated, vez.KatID , t.datum_od, t.datum_do, pl.naziv as ImeLokacije, pl.ID as LokacijaID, pl.lat as LokacijaLat, pl.lng as LokacijaLng, v.priority from
			    events v 
			    JOIN eventsKat_v vez on vez.EventID = v.ID and vez.KatID in  ('".$ID."'".$this->getSubIDs($ID).")  
			    JOIN termini t ON v.ID = t.ForeignID and t.ForeignType = 4 $DateAppend 
			    LEFT JOIN eventsPlaces_v epv ON epv.EventID = v.ID
				LEFT JOIN places pl ON pl.ID = epv.PlaceID ".language::getLang('pl.')."
			    WHERE v.published = 1 ".language::getLang('v.')." and v.isDraft = 0
				group BY v.ID ORDER BY v.priority DESC, t.datum_od ASC LIMIT 25) 
				as result
				
				JOIN pages p on p.ID = result.KatID ".language::getLang('p.')." 
				LEFT JOIN media ON result.ID = media.ForeignID and media.ForeignType = 4 and media.MediaGroup = 'heading'
				LEFT JOIN ModuleSettings ON ModuleSettings.MediaForeignType = 4
				ORDER BY result.priority DESC $rand LIMIT $limit
				";

		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();
		
		return $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
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

	public function linkToID($link){

		$sql = "SELECT ID FROM novostiKat WHERE link = ".$link." LIMIT 1";
		$res = mysql_query($sql);
		$row = mysql_fetch_array($res, MYSQL_ASSOC);

		return $row[ID];

	}
	
	



	public function search( $SearchString, $CategorysID, $DateFrom, $DateTo ){

		if(isset($_GET[str])){
			$offset = ($_GET[str] - 1) * $this->perPage;
			$append = " LIMIT $offset, ".$this->perPage."";	
		}

		else{
			$append = " LIMIT 0, ".$this->perPage."";
		}

		$time = time();
		$currenttime = date ('Y-m-d H:i', $time );

		if(strlen($DateFrom)){

			$DateFrom = date("Y-m-d", strtotime($DateFrom));
			//$DateAppend = " and (t.datum_od >= '".date("Y-m-d", strtotime($DateFrom))."' or (t.datum_do IS NOT NULL and t.datum_do >= '".date("Y-m-d", strtotime($DateFrom))."'))";
		}

		if(strlen($DateFrom) && strlen($DateTo)){
			//$DateAppend = " and (t.datum_od >= '".date("Y-m-d", strtotime($DateFrom))."' or (t.datum_do IS NOT NULL and t.datum_do >= '".date("Y-m-d", strtotime($DateFrom))."'))";
		}

		if(strlen($_GET["MenuID"])){
			$joinAppend = "JOIN eventsKat_v vez2 on vez2.EventID = v.ID and vez2.KatID = ".$_GET["MenuID"]."";
			//$CategorysID = $_GET["MenuID"];
		}

		if( strlen($DateTo) ){
			$DateTo = "'".date("Y-m-d", strtotime($DateTo))."'";
		}

		else {
			$DateTo = 'NULL';
		}

		/*$sql = "select 
				result.ID, result.KatID, result.naslov, result.link, result.heading, ModuleSettings.MediaFilePath, media.FileName, p.link as PagesLink, result.datum_od, result.datum_do, result.daysLeft from ( select 
				v.ID, v.link, v.naslov, v.heading, v.DateCreated, vez.KatID, termini.datum_od,  termini.datum_do, datediff(termini.datum_od, now()) as daysLeft  from
			    events v 
			    JOIN eventsKat_v vez on vez.EventID = v.ID and vez.KatID in ('".$CategorysID."'".$this->getSubIDs($CategorysID).")
			    JOIN termini ON v.ID = termini.ForeignID and termini.ForeignType = 4 $DateAppend
			    WHERE v.published = 1 ".Language::getLang('v.')." 
				GROUP BY v.ID $append  ) 
				as result
				JOIN pages p on p.ID = result.KatID ".language::getLang('p.')." 
				LEFT JOIN media ON result.ID = media.ForeignID and media.ForeignType = 4 and media.MediaGroup = 'heading'
				LEFT JOIN ModuleSettings ON ModuleSettings.MediaForeignType = 4
				ORDER BY result.datum_od
				";*/

			


		

		$sql = "select 
				result.ID, result.KatID, result.naslov, result.link, result.heading, result.ImeLokacije, ModuleSettings.MediaFilePath, IFNULL(media.FileName, 'noimage.jpg') as FileName, p.link as PagesLink, result.datum_od, result.datum_do, datediff(result.datum_od, now()) as daysLeft 
				from ( 

				SELECT
				    v.ID,
				    v.link,
				    v.naslov,
				    v.heading,
				    v.DateCreated,
				    vez.KatID,
				    t.datum_od,
				    t.datum_do,
				    pl.naziv as ImeLokacije,
				    v.priority
				FROM
				    events v
				        JOIN
				    eventsKat_v vez ON vez.EventID = v.ID
				        AND vez.KatID IN ('".$CategorysID."'".$this->getSubIDs($CategorysID).")
				        ".language::getLang('v.')."
				        AND v.published = 1 and v.isDraft = 0
				        $joinAppend
				        JOIN
				    termini t ON v.ID = t.ForeignID AND t.ForeignType = 4
				        AND NOT ( DATE(IFNULL(t.datum_do, t.datum_od)) < DATE(IFNULL('".$DateFrom."', CURDATE()))
				        OR DATE(IFNULL(".$DateTo.", '9999-12-31')) < DATE(t.datum_od))
					LEFT JOIN eventsPlaces_v epv ON epv.EventID = v.ID
					LEFT JOIN places pl ON pl.ID = epv.PlaceID ".language::getLang('pl.')." and pl.published = 1
			   
				group BY v.ID ORDER BY v.priority DESC, t.datum_od ASC $append) 
				as result
				
				JOIN pages p on p.ID = result.KatID ".language::getLang('p.')." 
				LEFT JOIN media ON result.ID = media.ForeignID and media.ForeignType = 4 and media.MediaGroup = 'heading'
				LEFT JOIN ModuleSettings ON ModuleSettings.MediaForeignType = 4
				
				";

		
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();

		if($paging){

		}
		
		return $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

	}

	public function getEvent($ID){		

		$sql = "SELECT n.ID, n.naslov, n.link, n.heading, n.opis, n.tags, IFNULL(media.FileName, 'noimage.jpg') as FileName, p.link as PagesLink, ModuleSettings.MediaFilePath, epv.PlaceID, n.tel, n.web, n.email, t.termini, pl.naziv as ImeLokacije, pl.adresa as AdresaLokacije, pl.tel as pTel, pl.web as pWeb, pl.email as pEmail, n.CustomFieldsValues
				from events n
				LEFT JOIN eventsKat_v vez on vez.EventID = n.ID
				LEFT JOIN (select ForeignID, ForeignType, GROUP_CONCAT(CONCAT( datum_od, ';', ifnull(datum_do, 'NULL')) separator '#' ) as termini from termini group by ForeignID,ForeignType) as t ON t.ForeignID = n.ID and t.ForeignType = 4
				LEFT JOIN eventsPlaces_v epv ON n.ID = epv.EventID
				LEFT JOIN places pl ON pl.ID = epv.PlaceID
				LEFT JOIN media on n.ID = media.ForeignID and media.ForeignType = 4 and media.MediaGroup = 'heading' 
				LEFT JOIN ModuleSettings ON ModuleSettings.MediaForeignType = 4
				JOIN pages p on p.ID = vez.KatID ".language::getLang('p.')." 
				WHERE n.ID = '".$ID."' ".language::getLang('n.')." LIMIT 1";


		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();

		return $row = $stmt->fetchObject();

		//UPDATE POGLEDANO
		//mysql_query("UPDATE novosti SET pogledano = pogledano + 1 WHERE link = '".$link."' ".language::getLang()."");
		
	}


	public function getEvent2($ID){		

		$sql = "SELECT n.ID, n.naslov, n.link, n.heading, n.opis, n.tags, IFNULL(media.FileName, 'noimage.jpg') as FileName, p.link as PagesLink, ModuleSettings.MediaFilePath, epv.PlaceID, n.tel, n.web, n.email, t.termini, pl.naziv as ImeLokacije, pl.adresa as AdresaLokacije, pl.tel as pTel, pl.web as pWeb, pl.email as pEmail, pl.lat as pLat, pl.lng as pLng, ttt.datum_od as ClosestDate from events n
				LEFT JOIN eventsKat_v vez on vez.EventID = n.ID
				LEFT JOIN (select ForeignID, ForeignType, GROUP_CONCAT(CONCAT( datum_od, ';', ifnull(datum_do, 'NULL')) separator '#' ) as termini from termini group by ForeignID,ForeignType) as t ON t.ForeignID = n.ID and t.ForeignType = 4
				LEFT JOIN eventsPlaces_v epv ON n.ID = epv.EventID
				LEFT JOIN places pl ON pl.ID = epv.PlaceID ".language::getLang('pl.')." 
				LEFT JOIN media on n.ID = media.ForeignID and media.ForeignType = 4 and media.MediaGroup = 'heading' 
				LEFT JOIN ModuleSettings ON ModuleSettings.MediaForeignType = 4
				JOIN pages p on p.ID = vez.KatID ".language::getLang('p.')." 

				LEFT JOIN (
					SELECT datum_od, datum_do, ForeignID, ForeignType FROM termini WHERE 
			    
				NOT ( DATE(IFNULL(datum_do, datum_od)) < CURDATE()
				OR DATE('9999-12-31') < DATE(datum_od))

				and ForeignID = $ID
				ORDER BY datum_od LIMIT 1) as ttt ON n.ID = ttt.ForeignID and ttt.ForeignType = 4

				WHERE n.ID = '".$ID."' ".language::getLang('n.')." LIMIT 1";


		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();

		$event = $stmt->fetchObject();

		$termini = explode("#", $event->termini);
		$terminiParsed = array();
		$closestDate = date("d.m.Y", strtotime($event->ClosestDate));

		for( $i = 0 ; $i < count( $termini ); $i++){
			$termin = explode(";", $termini[$i]);

			$datum_od = date("d.m.Y", strtotime($termin[0]));
			$datum_do = date("d.m.Y", strtotime($termin[1]));
			$vrijeme_od = date("H:i", strtotime($termin[0]));
			$vrijeme_do = date("H:i", strtotime($termin[1]));
			$vrijeme_od = ($vrijeme_od === "00:00" ? "" : $vrijeme_od);
			$vrijeme_do = ($vrijeme_do === "00:00" ? "" : $vrijeme_do);

			if($closestDate == $datum_od){
				$datum_od = "!".$datum_od;
			}

			if( $termin[1] != "NULL" && $datum_od !== $datum_do ) {
			  $datum_od .= ". - ".$datum_do;
			}

			if( $termin[1] != "NULL" && $vrijeme_do ){
			  $vrijeme_od .= "h - ".$vrijeme_do;
			}

			if($vrijeme_od) $vrijeme_od = ", ".$vrijeme_od."h";



			array_push($terminiParsed, $datum_od.".".$vrijeme_od);

		}

		$event->termini = implode( "#", $terminiParsed );

		return $event;

		//UPDATE POGLEDANO
		//mysql_query("UPDATE novosti SET pogledano = pogledano + 1 WHERE link = '".$link."' ".language::getLang()."");
		
	}



	
}

//AJAX CALL
$mode = $_GET["mode"];

if(isset($_GET["mode"])){
	
	require_once('Class.Language.php');
	require_once('../inc/DB.php');
	session_start();
	$events = new Events;

	if(!$_SESSION['lang']) $_SESSION['lang'] = $_GET["Lang"];

	switch($mode){
		case "search":

			if(!$_GET["CategorysID"]) $_GET["CategorysID"] = 87;

			$res = $events->search( $_GET["SearchString"], $_GET["CategorysID"], $_GET["DateFrom"], $_GET["DateTo"] );
			
			$arr;
			
			foreach ($res as $row) {
				
				$datum_od = date("d.m.Y", strtotime($row['datum_od']));
				$datum_do = date("d.m.Y", strtotime($row['datum_do']));
				$vrijeme_od = date("H:i", strtotime($row['datum_od']));
				$vrijeme_do = date("H:i", strtotime($row['datum_do']));
				$vrijeme_od = ($vrijeme_od === "00:00" ? "" : $vrijeme_od);
				$vrijeme_do = ($vrijeme_do === "00:00" ? "" : $vrijeme_do);

				if( $row['datum_do'] && $datum_od !== $datum_do ) {
					$datum_od .= " - ".$datum_do;
				}

				if( $row['datum_do'] && $vrijeme_do ){
					$vrijeme_od .= " - ".$vrijeme_do;
				}

				$row["datum_od"] = $datum_od;
				$row["vrijeme"] = $vrijeme_od;
				$arr[] = $row;
			}

			echo json_encode($arr);

		break;

		case "getEvent":
			$res = $events->getEvent2( $_GET["ID"] );
			echo json_encode($res);
		break;

		
	}
}

?>