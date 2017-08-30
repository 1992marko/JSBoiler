<?php

class News 
{ 
	
	public $selectedKategoryID;
	
	private $unionSelect;
	private $arr = array();
	private $counter;
	public $perPage = 8;
	private $htaccess = true;
	private $rootMenuID;
	public $lastResultTotal;
	public $IDs;
	
	
	public function __construct() { } 
	
	
	public function getForCategory($ID, $paging = false, $content = false){	

		$time = time();
		$currenttime = date ('Y-m-d H:i', $time - ($time % 300));

		if(isset($_GET[str])){
			$offset = ($_GET[str] - 1) * $this->perPage;
			$append = " LIMIT $offset, ".$this->perPage."";	
		}

		else{
			$append = " LIMIT 0, ".$this->perPage."";
		}

		if($content){
			$sqlAppend = ",result.novost";
			$sqlAppend2 =",v.novost";
		}
		
		$sql = "select 
				result.ID, result.IDKat, result.naslov, result.link, result.heading, IFNULL(media.FileName, 'noimage.jpg') as FileName, p.link as PagesLink, result.datum_od ".$sqlAppend.", ms.MediaFilePath from ( select 
				v.ID, v.link, v.naslov, v.heading, v.DateCreated, vez.IDKat, termini.datum_od ".$sqlAppend2." from
			    novosti v 
			    JOIN novostiKat_vezna vez on vez.IDNovosti = v.ID and vez.IDKat in ('".$ID."'".$this->getSubIDs($ID).")
			    JOIN termini ON v.ID = termini.ForeignID and termini.ForeignType = 1 and 
			    CASE 
			    WHEN termini.datum_od IS NOT NULL AND termini.datum_do IS NULL THEN
			    	termini.datum_od <= NOW()
			    WHEN termini.datum_od IS NOT NULL AND termini.datum_do IS NOT NULL THEN
			    	termini.datum_od <= NOW() AND termini.datum_do >= NOW()
			    
			    END
			    WHERE v.published = 1 ".Language::getLang('v.')." 
				ORDER BY termini.datum_od DESC $append ) 
				as result
				JOIN pages p on p.ID = result.IDKat ".language::getLang('p.')." 
				LEFT JOIN media ON result.ID = media.ForeignID and media.ForeignType = 1 and media.MediaGroup = 'heading'
				LEFT JOIN ModuleSettings ms on ms.MediaForeignType = 1
				
				";

		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();

		if($paging){

			$sql = "select 
				result.ID, result.IDKat from ( select 
				v.ID, vez.IDKat from
			    novosti v 
			    JOIN novostiKat_vezna vez on vez.IDNovosti = v.ID and vez.IDKat in ('".$ID."'".$this->getSubIDs($ID).")
			    WHERE v.published = 1 ".Language::getLang('v.')." 
				 ) 
				as result
				JOIN pages p on p.ID = result.IDKat ".language::getLang('p.')." 
				";

			$this->lastResultTotal = $this->getCountForQuery($sql);

		}
		
		
		
		return $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
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

	public function linkToID($link){

		$sql = "SELECT ID FROM novostiKat WHERE link = ".$link." LIMIT 1";
		$res = mysql_query($sql);
		$row = mysql_fetch_array($res, MYSQL_ASSOC);

		return $row[ID];

	}

	public function Link($ID, $navigacija){

		$sql = "select n.link from novosti n WHERE n.ID = :ID ".language::getLang('n.')."";

		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam(':ID', $ID );
		$stmt->execute();
		$row = $stmt->fetchObject();

		return $navigacija->Link(132)."/".$row->link;

	}
	
	
	public function getNajnovije($ID, $limit, $content = false, $random = false){

		$time = time();
		$currenttime = date ('Y-m-d H:i', $time - ($time % 300));

		if($limit){
			$append = " LIMIT $limit ";	
		}

		if($content){
			$sqlAppend = ",result.novost";
			$sqlAppend2 =",v.novost";
		}
		
		if($random){
			$orderAppend = " ORDER BY RAND() ";
		} else {
			$orderAppend = " ORDER BY termini.datum_od DESC";
		}
		
		$sql = "select 
				result.ID, result.IDKat, result.naslov, result.link, result.heading, media.FileName, p.link as PagesLink, result.datum_od ".$sqlAppend.", ms.MediaFilePath, result.CustomFieldsValues ".$sqlAppend."  from ( select 
				v.ID, v.link, v.naslov, v.heading, v.DateCreated, termini.datum_od, vez.IDKat, v.CustomFieldsValues ".$sqlAppend2." from
			    novosti v 
			    JOIN novostiKat_vezna vez on vez.IDNovosti = v.ID and vez.IDKat in ('".$ID."'".$this->getSubIDs($ID).")
			    JOIN termini ON v.ID = termini.ForeignID and termini.ForeignType = 1 and 
			    
			    CASE 
			    WHEN termini.datum_od IS NOT NULL AND termini.datum_do IS NULL THEN
			    	termini.datum_od <= NOW()
			    WHEN termini.datum_od IS NOT NULL AND termini.datum_do IS NOT NULL THEN
			    	termini.datum_od <= NOW() AND termini.datum_do >= NOW()
			    
			    END
			    
			    WHERE v.published = 1  ".Language::getLang('v.')." 
				$orderAppend $append ) 
				as result
				JOIN pages p on p.ID = result.IDKat ".language::getLang('p.')." 
				LEFT JOIN media ON result.ID = media.ForeignID and media.ForeignType = 1 and media.MediaGroup = 'heading'
				LEFT JOIN ModuleSettings ms on ms.MediaForeignType = media.ForeignType 
				
			";

		//echo $sql;
		//echo "<hr>";
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();
		
		return $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
	}


	public function getPopularno($link, $offset, $limit, $paging = false){

		if(strlen($link) > 0){
			$res = mysql_query("SELECT ID FROM novostiKat where link = '".$link."'");
			$id_kat = mysql_result($res, 0, 'ID');
		}
		

		if(isset($_GET[str])){
			$offset = ($_GET[str] - 1) * $this->perPage;
			$append = " LIMIT $offset, ".$this->perPage."";	
		}

		else{
			$append = " LIMIT 0, ".$this->perPage."";
		}
		

		$time = time();
		$currenttime = date ('Y-m-d H:i', $time - ($time % 300));

		$sql2 = "select a.link, a.naslov,  a.heading, a.headingImage, a.datum, a.novost, a.objavi_na_datum, ag.ime_agencije, media.FileName from (select 
			    n.id,
			    n.link, 
			    n.naslov, 
			    n.ID_user,
			    n.heading, 
			    n.headingImage, 
			    n.datum, 
			    n.novost, 
			    n.objavi_na_datum
			from
			    novosti n 
			join 
			    novostiKat_vezna vez on vez.IDNovosti = n.ID and n.objavi_na_datum <= '".$currenttime."' and n.published = 1 ".language::getLang('n.')." and vez.IDKat in ('".$id_kat."'".$this->getSubIDs($id_kat).")
			    
			GROUP BY n.ID ORDER BY n.pogledano DESC LIMIT $offset, $limit) as a
			LEFT JOIN users u on a.ID_user = u.ID 
			LEFT JOIN agencije ag ON u.agencija_id = ag.id
			LEFT JOIN media on a.ID = media.ForeignID and media.ForeignType = 2 and media.MediaGroup = 'heading'";

		$result = mysql_query($sql2);
		
		return $result;
		
	}

	public function search($string){

		if(isset($_GET[str])){
			$offset = ($_GET[str] - 1) * $this->perPage;
			$append = " LIMIT $offset, ".$this->perPage."";	
		}

		else{
			$append = " LIMIT 0, ".$this->perPage."";
		}

		$time = time();
		$currenttime = date ('Y-m-d H:i', $time );

		$sql2 = "select a.link, a.naslov,  a.heading, a.headingImage, a.datum, a.novost, a.objavi_na_datum, ag.ime_agencije, media.FileName from (select 
			    n.id,
			    n.link, 
			    n.naslov, 
			    n.ID_user,
			    n.heading, 
			    n.headingImage, 
			    n.datum, 
			    n.novost, 
			    n.objavi_na_datum
			from
			    novosti n 
			WHERE n.objavi_na_datum <= '".$currenttime."' and n.published = 1 ".language::getLang('n.')." and n.naslov LIKE '%".$string."%'
			    
			GROUP BY n.ID ORDER BY n.objavi_na_datum DESC $append) as a
			LEFT JOIN users u on a.ID_user = u.ID 
			LEFT JOIN agencije ag ON u.agencija_id = ag.id
			LEFT JOIN media on a.ID = media.ForeignID and media.ForeignType = 2 and media.MediaGroup = 'heading'";

			
		$sql_count = "select n.id from novosti n 
join novostiKat_vezna vez on vez.IDNovosti = n.ID and n.objavi_na_datum <= '".$currenttime."' and n.published = 1 ".language::getLang('n.')." and n.naslov LIKE '%".$string."%'
 LIMIT 0, 200";


			$rexx = mysql_query($sql_count);
			$this->lastResultTotal = mysql_num_rows($rexx);

		$result = mysql_query($sql2);
		return $result;

	}

	public function getForAgencija($id_agencije, $paging = false){
		
		$sql = "SELECT * from novosti LEFT JOIN media on novosti.ID = media.ForeignID and media.ForeignType = 2 and media.MediaGroup = 'heading' WHERE novosti.published=1 and novosti.ID_agencija = $id_agencije ".language::getLang('novosti.')." ORDER BY novosti.objavi_na_datum DESC LIMIT 5";

		

		$result = mysql_query($sql.''.$append);
		

		return $result;	
	}

	public function getVezano($novost){

		$sql = "SELECT n.ID, n.naslov, n.heading, n.link, n.headingImage, n.objavi_na_datum, m.FileName FROM novosti n LEFT JOIN media m on n.ID = m.ForeignID and m.ForeignType = 2 and m.MediaGroup = 'heading' WHERE n.ID != ".$novost[ID]." ".language::getLang('n.')." and n.published = 1 and m.FileName <> '' and MATCH (n.tags) AGAINST ('".$novost[tags]."' IN BOOLEAN MODE) LIMIT 4";
		$result = mysql_query($sql);

		if(mysql_num_rows($result) > 0){
			return $result;
		} else {
			return false;
		}
		
	}

	
	public function getNaslov(){

		if(!isset($_GET['item0'])){
			$string = $_GET['page0'];
		} else {
			$string = $_GET['item0'];
		}

		$sql_content = "select naziv from novostiKat where link = '".$string."' ".language::getLang()." LIMIT 1";
		$res_content = mysql_query($sql_content);
		$page = mysql_fetch_array($res_content, MYSQL_ASSOC);

		return $page['naziv'];
	}
	
	public function getNovost($ID){		

		$sql = "SELECT n.ID, n.naslov, n.link, n.heading, n.novost, n.tags, media.FileName, nk.IDKat, ms.MediaFilePath, date_format(t.datum_od, '%d.%m.%Y') as datum_od, date_format(t.datum_do, '%d.%m.%Y') as datum_do from novosti n
				LEFT JOIN novostiKat_vezna nk ON nk.IDNovosti = n.ID 
				LEFT JOIN media on n.ID = media.ForeignID and media.ForeignType = 1 and media.MediaGroup = 'heading' 
				LEFT JOIN ModuleSettings ms on ms.MediaForeignType = 1
				LEFT JOIN termini t ON n.`ID` = t.ForeignID AND t.ForeignType = 1
				WHERE n.ID = '".$ID."' ".language::getLang('n.')." LIMIT 1";
		    
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();

		return $row = $stmt->fetchObject();

		//UPDATE POGLEDANO
		//mysql_query("UPDATE novosti SET pogledano = pogledano + 1 WHERE link = '".$link."' ".language::getLang()."");
		
	}

	public function getGallery($ID_novosti){
		$sql = "SELECT * from media WHERE ForeignType = 2 and ForeignID = $ID_novosti and MediaGroup = 'gallery";
		$res = mysql_query($sql);
		
		return $res;
	
	}

	
	public function getChild($ID_rod){
		
		$sql2 = "select * from novostiKat where ID = $ID_rod ".language::getLang()." ";
		$res2 = @mysql_query($sql2);
		
			while($pages2 = @mysql_fetch_array($res2)){
				$this->arr[] = $pages2[link];
				$this->counter ++;
				$this->getChild($pages2[ID_rod]);
			}
		
	}
	
	
	public function imakat($id_rod){
		$sql2 = "select * from novostiKat where id_rod = $id_rod ";
		$res2 = mysql_query($sql2);
		$nr = mysql_num_rows($res2);
		if($nr > 0) return true;
		else return false;
	}
	


	public function sideMeni($link){
		$sql1 = "select * from novostiKat where link = '$link' ".language::getLang()." ";
		$res1 = mysql_query($sql1);
		$object = mysql_fetch_assoc($res1);

		if(!$object){ $ID = 1; } else{ $ID = $object[ID]; }

		$this->generateSideMeni($ID);
	}
	
	public function generateSideMeni($ID, $recurse = true){
		

		if(!isset($this->rootMenuID)){
			$this->rootMenuID = $ID;
		}


		$sql = "select * from novostiKat where id_rod = $ID ".language::getLang()." ORDER BY rbr ";
		
		$res = mysql_query($sql);
		
			while($pages2 = mysql_fetch_array($res)){
		
				//reset and load array with URL
				$counter = 0;
				$this->arr = array();
				$this->arr[] = $pages2[link].$pages2[hreflink];
				$this->getChild($pages2[id_rod]);
				$result = array_reverse($this->arr);
				
				

				//selektirani URL
				$tmp = "item".$counter;
				$selectedItem = $_GET[$tmp];
				
				
				$url = "";
				
				$url = '<li'; 
				
				if(trim($selectedItem) == trim($pages2[link])){
					$url.=' class="active"';
				}
				
				$url.='><a';
				
				if($_GET[item0] == trim($pages2[link])){
					$url.=' class="active"';
				}
				
				else if(trim($selectedItem) == trim($pages2[link]))
				{
					$url.=' class="SubActive"';
				}

				$url.= ' href="/';
				
					foreach($result as $key => $value){
						if($key > 0){
							$url .= '/'.$value;
						}
						
						else{
							$url .= $value;
						}
						
					}
				
				$url .= '">'.$pages2[naziv].'</a>'; 
				
				
				echo $url;
				
				
				if(trim($selectedItem) == trim($pages2[link])){
				
					$selID = $pages2[ID];
					
					if($this->imakat($pages2[ID]) && $recurse ){
						
						echo '<ul>';
						$this->generateSideMeni($pages2[ID]);
						echo '</ul>';
					}
					
					
				}
				
				echo '</li>';
				
			}
	}


	
}
?>