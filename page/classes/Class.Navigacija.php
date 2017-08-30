<?php 

require_once(__DIR__."/DB.php"); 
require_once(__DIR__."/Class.Language.php");

class Navigacija 
{ 

	var $mycontent;
	var $counter = 0;
	var $arr = array();
	var $selectedItem;
	var $selectedID;
	var $htaccess = true;
	var $selID;
	private $url;

    public function setupURL(){
   		
   		//HTACCESS REPLACEMENT
		$_GET["path"] = $_SERVER['REQUEST_URI'];
		$_GET["path"] = str_replace("/page", "", $_GET["path"]);
		$_GET["path"] = strtok($_GET["path"], '?');
		$_GET["path"] = strtok($_GET["path"], '&');

		if(strlen( $_GET["path"] ) > 1){
			$_GET["path"] = $queryString = rtrim($_GET["path"], '/');
		}

		//$_GET["path"] = $queryString = ltrim($_GET["path"], '/');
		$_GET["paths"] = array_filter( explode("/", $_GET["path"]) );


		//CREATE FULL PATHS
		$buffer;
		$_GET["FullPaths"] = array();

		for ($i = 0; $i < count($_GET["paths"]) + 1; $i++) {
			
			if($i > 0) $slash = "/";
			$buffer .= $slash.$_GET["paths"][$i];
			$_GET["FullPaths"][$i] = $buffer;

		}
	
		array_shift($_GET["FullPaths"]);
    
    }


    public function getSelectedLinkTemplate($path = false){

		//Gleda session
    	if ($_GET["path"] == '/' && !isset($_SESSION['lang'])){
			$append = " and lang='" . Language::getDefaultLanguage() . "'";
			$_SESSION['lang'] = Language::getDefaultLanguage();	
			//echo "prvi lang".$_SESSION['lang'] ;
			
		} 

		if ($_GET["path"] <> '/' && !isset($_SESSION['lang'])){
			$append = "";
		} 

		
		if(!isset($_SESSION['lang'])) {
			$append = "";
			
		}
			
		if(isset($_SESSION['lang'])) {
			$append = " AND lang='" . $_SESSION['lang'] . "'"; 
			
		}
			

		$path = ($path != false) ? "/".$path : $_GET["path"];
		
		//LOOK FOR THE LINK IN Pages TABLE
		$sql = "select templates.filename, pages.name, pages.heading, pages.lang, pages.ID, pages.content, pages.SEO_title,pages.SEO_metaDescription, pages.SEO_metaKeywords, pages.link, pages.TemplateParametars, ModuleSettings.MediaFilePath, media.FileName from templates, pages 
				LEFT JOIN media ON pages.ID = media.ForeignID and media.ForeignType = 2 and media.MediaGroup = 'heading'
				LEFT JOIN ModuleSettings ON ModuleSettings.MediaForeignType = 2
				where pages.link = '".strtolower( $path )."' and pages.ID_template = templates.ID $append LIMIT 1";

		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();
		$page = $stmt->fetchObject();

		$template = $page->filename;
		$templateLang = $page->lang;
		$link = $page->link;
		$TP = json_decode( htmlspecialchars_decode( $page->TemplateParametars ));
		$_GET["page"] = $page;

		//IN LINK IS NOT FOUND IN Pages TABLE
		if(!$page){

			//CUT THE LAST LINK OUT AND LOOK IN Pages TABLE AGAIN
			$paths = $_GET["paths"];
			array_pop($paths);
			$_GET["PagesPath"] = "/".rtrim( implode("/", $paths) , '/');

			$sql = "select templates.filename, pages.name, pages.SEO_title, pages.SEO_title, SEO_metaDescription, pages.lang, pages.ID, pages.content, pages.link, pages.TemplateParametars, ModuleSettings.MediaFilePath, media.FileName as Image from templates, pages 
					LEFT JOIN media ON pages.ID = media.ForeignID and media.ForeignType = 2 and media.MediaGroup = 'heading'
					LEFT JOIN ModuleSettings ON ModuleSettings.MediaForeignType = 2
					where pages.link = '".strtolower( $_GET["PagesPath"] )."' and pages.ID_template = templates.ID";

			$stmt = $db->prepare($sql);  
			$stmt->execute();
			$page = $stmt->fetchObject();
			$_GET["page"] = $page;
			$link = $page->link;
			$templateLang = $page->lang;
			$TP = json_decode( htmlspecialchars_decode( $page->TemplateParametars ));

			if(!$TP->moduleTemplateID){
			
				//TAKE THE LAST LINK AND LOOK WHICH MODULE USES IT AND LOAD THE TEMPLATE
				$sql = "select p.ID as ObjectID, t.filename as Template, lang, link as Link, ms.ModuleName as Module, naziv as Naziv, heading as Heading, media.FileName as Image, ms.MediaFilePath from places p 
						LEFT JOIN templates t on p.TemplateID = t.ID
						LEFT JOIN ModuleSettings ms ON ms.ModuleSettingsID = 3
						LEFT JOIN media ON p.ID = media.ForeignID and media.ForeignType = 3 and media.MediaGroup = 'heading'
						where p.lang = '".$templateLang."' and p.ID = (select ID from places where places.link = '".$_GET["paths"][count($_GET["paths"])]."' LIMIT 1)
						union all

						select p.ID as ObjectID, t.filename as Template, lang, link as Link, ms.ModuleName as Module, naslov as Naziv, heading as Heading, media.FileName as Image, ms.MediaFilePath from events p 
						LEFT JOIN templates t on p.TemplateID = t.ID
						LEFT JOIN ModuleSettings ms ON ms.ModuleSettingsID = 4
						LEFT JOIN media ON p.ID = media.ForeignID and media.ForeignType = 4 and media.MediaGroup = 'heading'
						where p.lang = '".$templateLang."' and p.ID = (select ID from events where events.link = '".$_GET["paths"][count($_GET["paths"])]."' LIMIT 1)
						union all

						select p.ID as ObjectID, t.filename as Template, lang, link as Link, ms.ModuleName as Module, naslov as Naziv, heading as Heading, media.FileName as Image, ms.MediaFilePath from novosti p 
						LEFT JOIN templates t on p.TemplateID = t.ID
						LEFT JOIN ModuleSettings ms ON ms.ModuleSettingsID = 1
						LEFT JOIN media ON p.ID = media.ForeignID and media.ForeignType = 1 and media.MediaGroup = 'heading'
						where p.lang = '".$templateLang."' and p.ID = (select ID from novosti where novosti.link = '".$_GET["paths"][count($_GET["paths"])]."' LIMIT 1)";

				$stmt = $db->prepare($sql);  
				$stmt->execute();
				$object = $stmt->fetchObject();
			}

			$template = $TP->moduleTemplateID?$TP->moduleTemplateID:$object->Template;
			
			$_GET["object"] = $object;
			$_GET["objectID"] = $object->ObjectID;
			$_GET["moduleLink"] = $object->Link;
			$_GET["module"] = $object->Module;

		}

		//$page->links = $this->getMultiLanguageLinks($page->link);
		if (!isset($_SESSION['lang'])){
			$_SESSION['lang'] = $_GET["page"]->lang;
		}

		return $template;

    }

    public function Link($ID){
    	
    	$sql = "select p1.link, p1.useHash from pages p1 WHERE p1.ID = :ID ".language::getLang('p1.')."";
		
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam(':ID', $ID );
		$stmt->execute();
		$row = $stmt->fetchObject();
	
		if($row->useHash){
			$row->link = substr_replace($row->link, '#', strrpos($row->link, "/"), 1);
		}

		return $row->link;
	}
	
    public function Heading($ID){
    	
    	$sql = "select p1.heading from pages p1 WHERE p1.ID = :ID ".language::getLang('p1.')."";
		
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam(':ID', $ID );
		$stmt->execute();
		$row = $stmt->fetchObject();

		return $row->heading;
    }
	
	public function BuildURL($key, $value){
	
		/*This function builds a new url with a new key value parametars */

		$url = urldecode($_SERVER['REQUEST_URI']);

		if (preg_match('/[?&]('.$key.')=[^&]*/', $url)) {
			
	        // parameter is already defined in the URL, so
	        // replace the parameter value, rather than
	        // append it to the end.
	        $url = preg_replace('/(?:&|(\?))' . $key . '=[^&]*(?(1)&|)?/i', "&".$key."=".$value."", $url);
	        
	    } else {
	        // can simply append to the end of the URL, once
	        // we know whether this is the only parameter inf
	        // there or not.
	        $url .= '&'.$key . '=' . $value;
	    }

	
	    if($value < 0){
	    	$url = preg_replace('/(?:&|(\?))' . $key . '=[^&]*(?(1)&|)?/i', "", $url);
	    }
	    
	    return $url ;

		
	}


	public function createFilter($PagesID){
		
		$sql = "select * from pages p1
				LEFT JOIN media on p1.ID = media.ForeignID and media.ForeignType = 2 and media.MediaGroup = 'heading'
				WHERE p1.id_rod = :PagesID ".language::getLang('p1.')." ORDER BY p1.rbr";
		
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam(':PagesID', $PagesID );
		$stmt->execute();

		return $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
	}


    public function getTitle($ID){
    	
		$sql = "select p.name from pages p WHERE p.ID = :ID ".language::getLang('p.')."";
		
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam(':ID', $ID );
		$stmt->execute();
		$row = $stmt->fetchObject();
	
		return $row->name;
	}
	

	public function getPage($ID){
		
		$sql = "select * from pages where ID = :ID ".language::getLang("")."";
		
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam('ID', $ID );
		$stmt->execute();
		$row = $stmt->fetchObject();
		return $row;
		
	}

	public function getTemplateId($name){

		$sql = "select ID from templates where ime = :NAME ";
		
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam(':NAME', $name );
		$stmt->execute();
		$row = $stmt->fetchObject();
		return $row->ID;
	}

public function getPageSections($ID, $section){
		$templateID = $this->getTemplateId($section);
		
		//$sql = "select * from pages where id_rod = :ID and ID_template = :tplID ".language::getLang("")." order by rbr asc";

		$sql = "select * from pages p1
				LEFT JOIN media on p1.ID = media.ForeignID and media.ForeignType = 2 and media.MediaGroup = 'heading'
				WHERE p1.id_rod = :ID and p1.ID_template = :tplID ".language::getLang('p1.')." ORDER BY p1.rbr";
		
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam('ID', $ID );
		$stmt->bindParam('tplID', $templateID);
		$stmt->execute();
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $row;
		
	}

	public function getSubPages($ID){
		
		$sql = "select * from pages where id_rod = :ID ".language::getLang("")." order by rbr asc";
		
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam('ID', $ID );
		$stmt->execute();
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		return $row;
		
	}

	public function linkToID($link){
		$sql = "select * from pages where link = '".$link."' ".language::getLang("")."";
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();
		$row = $stmt->fetchObject();

		return $row->ID;
	}

	public function getLangFromPath($link){
		$sql = "select lang from pages where link = '".$link."'";
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();
		$row = $stmt->fetchObject();

		return $row->lang;
	}

	public function getPathOnLang($link, $lang){
		$sql = "select p2.link from pages p JOIN pages p2 on p.ID = p2.ID and p2.lang = '".$lang."' where p.link = '".$link."' ";
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();
		$row = $stmt->fetchObject();

		return $row->link;
	}

	public function getPageContentByID($ID){
		$sql2 = "select * from pages where ID = ".$ID." ".language::getLang("")."";
		$res = mysql_query($sql2);

		$content = mysql_fetch_assoc($res);

		return $content;
	}

	/*public function getPageOnAllLanguages($PageID){
		
		if(Language::$multyLanguageSupport){
			
			$sql = "SELECT lang.name, lang.tag, pages.link FROM lang 
			LEFT JOIN pages ON lang.tag = pages.lang 
			WHERE pages.ID = ".$PageID."";

			$db = Website::getConnection();
			$stmt = $db->prepare($sql);  
			$stmt->execute();
			return $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		}
	
	}*/

	public function hasExtra($id_rod){
		$sql2 = "select * from pages where id_rod = $id_rod and isExtra = 1";
		$res2 = mysql_query($sql2);
		$nr = @mysql_num_rows($res2);
		if($nr > 0) return true;
		else return false;
	}
	
	/*public function getPagesSelectedGallery($ID = 0){
		
		if($ID){
			$getPage = $ID;	
		}
		
		else {
			$getPage =	$this->selectedID;
		}
		
		$sql_content = "select * from pages_slike where id_page = ".$getPage." ORDER BY rbr";
		$res_content = mysql_query($sql_content);
		
		
		if(@mysql_num_rows($res_content) > 0){
			
			echo '<ul class="pages-gallery">';
			
			while($items = @mysql_fetch_array($res_content)){
				
				echo '<li>
				<a href="galleries/pages/'.$items['slika'].'" rel="lightbox['.$items[id_page].']" title="'.$items[opis].'"><img src="galleries/pages/tb_'.$items['slika'].'" /></a>
				<p>'.$items[opis].'</p>
				</li>';	
				
			}
			
			echo '</ul>';
			
			
		}
		
	}*/


	public function generatePaging($_total, $_perpage){

		//ako ima više od jedne stranice generiraj
		$pagesLimit = 6;
		$offset = 3;
		$total = $_total;
		$perPage = $_perpage;
		
		if($total > $perPage){
			
			$totalPages = ceil($total / $perPage);			

			$url = $_GET["path"];
			
			if(isset($_GET[str])){
				
				if($_GET[str] < $totalPages){
					$next = $_GET[str]+1;
				} 

				else{
					$next = $totalPages;
				}

				if($_GET[str] > 1){
					$prev = $_GET[str]-1;
				} 

				else{
					$prev = 1;
				}

			}

			else{
				$next = 2;
				$prev = 1;
				$_GET[str] = 1;
			}


			if( ($_GET[str] - $offset) < 1){
				$start = 1;
			}

			else{
				$start = $_GET[str] - $offset;
			}

			if($totalPages > $pagesLimit + $start){
				$generate = $pagesLimit + $start;
			}

			else{
				$generate = $totalPages;
			}

			echo '<div ID="paging"><div class="outer"><div class="inner">';
				
				echo '<li class="first '.($prev!=$_GET["str"]?"":"hidden").' " data-str="'.$prev.'"><a href="'.$url.'&str='.$prev.'">'.Language::$translations["prethodna"].'</a></li>';
			
			for($page = $start; $page <= $generate; $page++){
				echo '<li data-str="'.$page.'"'; if( $page == $_GET[str] ){ echo ' class="active"';} echo'><a '; echo' href="'.$url.'&str='.$page.'">'.$page.'</a></li>';	
			}

			
				echo '<li class="last '.($next!=$_GET["str"]?"":"hidden").'" data-str="'.$next.'"><a href="'.$url.'&str='.$next.'">'.Language::$translations["sljedeca"].'</a></li>';
		
			echo '</div></div></div>';
			
		}
		
	}


	
	//Recurse 
	//Ignore dropdown

	public function glavniMeni( $ID_menu, $flatMenu, $recurse = true, $returnJson = false ){

		$sql = "select t1.ID, t1.isDropdown, t1.link, t1.hreflink, t1.name, t1.ClassName, (select count(*) from pages t2 WHERE t2.id_rod = t1.ID and t2.published = 1 and t2.ID_menu = $ID_menu) as ima from pages t1 where t1.id_rod = 0 and t1.ID_menu = $ID_menu and t1.published = 1 ".language::getLang("")." ORDER BY t1.rbr";


		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();

		$data = "";
		$json = [];
			
		while($pages = $stmt->fetch(PDO::FETCH_ASSOC) ){

			$data .= '<li class="'.$pages['ClassName'].'';

			if(strlen(trim($_GET['path'])) && strlen(trim($pages['link']))){

				$selected = strpos($_GET['path'].'/', $pages['link'].'/');

				if( $selected !== false ){
					
					if($selected == 0) $data .= $pos.' active';
				}
			}

			//Početna is selected
			if(trim($_GET['path']) == "" && trim($pages['link']) == ""){
				$data .= " active";
			}

			$data .= '">';

			$data .='<a class="menu'.$pages['ID'].'" href="'.$pages["link"].''.$pages["hreflink"].'" title="'.$pages["name"].'">'.$pages["name"].'</a>';

			

			if( $pages["ima"] && $recurse && $pages['isDropdown']){

				$data .= '<ul class="" data-show="0" data-item-id-rod="'.$pages["ID"].'">';
				$this->url = "";
				//$data .= $this->defaultSideMeni( $pages["ID"], true, true );
				$pages["nodes"] = $this->defaultSideMeni( $pages["ID"], $flatMenu, $recurse, $returnJson );
				$data .= "</ul>";
			
			}

			'</li>'; 

			$json[] = $pages;
			
		}

		if($returnJson) {
			return $json;
		} else {
			return $data;
		}
	
	}


	public function getMenuNaslov($link){
		$sql_content = "select name from pages where link = '".$link."' LIMIT 1";
		$res_content = mysql_query($sql_content);
		$page = mysql_fetch_array($res_content, MYSQL_ASSOC);

		return $page['name'];
	}

	public function getNaslov(){
		$sql_content = "select name from pages where link = '".$_GET[path]."' LIMIT 1";
		
		$res_content = mysql_query($sql_content);
		$page = mysql_fetch_array($res_content, MYSQL_ASSOC);

		return $page['name'];
	}


	public function getCategories($categoryArray){
		
		$sql = "select * from pages p1
				WHERE p1.ID IN (".$categoryArray.") ".language::getLang('p1.')."";
		
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);
		//$stmt->bindParam(':cat', $categoryArray );
		$stmt->execute();

		return $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
	}


	public function getPages($ID){
		
		$db = Website::getConnection();

		$sql = "select * from pages p1
				LEFT JOIN media on p1.ID = media.ForeignID and media.ForeignType = 2 and media.MediaGroup = 'heading'
				WHERE p1.id_rod = :ID ".language::getLang('p1.')." and p1.Published = 1 ORDER BY p1.rbr";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':ID', $ID );
		$stmt->execute();
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach($row as $key => $value){
			$sql = "select * from media where ForeignType = 2 and MediaType = 'IMAGE' and Published = 1 and MediaGroup = 'gallery and ForeignID = ".$value["ID"]." order by PrimaryMedia desc,OrderNum";
			$stmt = $db->prepare($sql);
			$stmt->execute();
			$row[$key][media] = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}

		return $row;

	}	



	public function sideMenu($ID, $flatMenu, $recurse = false ){
		
		$this->url = "";
		return $this->defaultSideMeni($ID, $flatMenu, $recurse);

	}
	
	
	public function defaultSideMeni($ID, $flatMenu, $recurse, $returnJson = false){

		$sql = "select t1.ID, t1.isDropdown, t1.link, t1.hreflink, t1.name, t1.ClassName, t1.UseHash, (select count(*) from pages t2 WHERE t2.id_rod = t1.ID and t2.published = 1) as ima from pages t1 where t1.ID_rod = $ID ".language::getLang('t1.')." and t1.published = 1  ORDER BY t1.rbr ";

		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();

		$json = [];
		
		while($pages = $stmt->fetch(PDO::FETCH_ASSOC) ){

			//selektirani URL
			if( strpos($_GET['path'].'/', $pages['link'].'/') === false ){
				$class = "";
			} else {
				$this->selectedKategoryID = $pages["ID"];
				$class = " active ";
			}

			if($pages["UseHash"]){
				$pos = strrpos($pages["link"], "/");
				$pages["link"] = substr_replace($pages["link"], '#', $pos, 1);
			}
			
			$this->url .= '<li class="'.$class.'">'; 

			$this->url .= '<a data-id="'.$pages["ID"].'" class="'.$pages['ClassName'].''.$class.'" href="'.$pages["link"].''.$pages["hreflink"].'">'.$pages["name"].'</a>'; 
			


			if( ( @strpos($_GET['path'], $pages['link']) !== false && $recurse ) || $flatMenu ){
				
				if($pages["ima"] && $pages['isDropdown']){
					$this->url .= '<ul data-item-id-rod="'.$pages["ID"].'">';
					$pages["nodes"] = $this->defaultSideMeni($pages["ID"], $flatMenu, $recurse, $returnJson);
					$this->url .= '</ul>';
				}
				
			} 
			
			$this->url .= '</li>';
			$json[] = $pages;
		}

		if($returnJson) {
			return $json;
		} else {
			return $this->url;
		}
		
	}
		
	
} 
?>