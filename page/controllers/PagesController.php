<?php 

require_once("classes/Class.Navigacija.php");
require_once("BaseController.php");
require_once("classes/Class.Language.php");
require_once("classes/Class.News.php");
require_once("classes/Class.Places.php");

class PagesController extends BaseController
{ 	

	public function __construct($_page = null){
		parent::__construct( $_page );
	}

	public function defaultPage(){
		
		$navigacija = new Navigacija();
		$sideNav = $navigacija->sideMenu( $navigacija->linkToID( $_GET["FullPaths"][ $this->TP->StartMenuLevel ? $this->TP->StartMenuLevel : 0 ] ), false, true );
		$this->page->allLang = Language::getModuleOnAllLanguages( $_GET["module"] );

		$rootPage = $navigacija->getPage( $navigacija->linkToID( $_GET["FullPaths"][ $this->TP->StartMenuLevel ? $this->TP->StartMenuLevel : 0 ] ));
		
		//*RENDER ON SERVER*//
		$this->page->filename = false;
		$this->page->content = $this->render("./views/default.php", [ "nav" => $sideNav, "rootPage" => $rootPage ] );
		
		echo json_encode( $this->page );
	}

	public function defaultWidePage(){
		
		$navigacija = new Navigacija();
		$sideNav = $navigacija->sideMenu( $navigacija->linkToID( $_GET["FullPaths"][ $this->TP->StartMenuLevel ? $this->TP->StartMenuLevel : 0 ] ), false, true );
		$this->page->allLang = Language::getModuleOnAllLanguages( $_GET["module"] );

		$rootPage = $navigacija->getPage( $navigacija->linkToID( $_GET["FullPaths"][ $this->TP->StartMenuLevel ? $this->TP->StartMenuLevel : 0 ] ));
		
		//*RENDER ON SERVER*//
		$this->page->filename = false;
		$this->page->content = $this->render("./views/defaultWide.php", [ "nav" => $sideNav, "rootPage" => $rootPage ] );
		
		echo json_encode( $this->page );
	}

	public function pageWithSubpagesSkijalista(){
	
		$navigacija = new Navigacija();
		$places = new Places();

		$pageID = $navigacija->linkToID( $_GET["FullPaths"][ $this->TP->StartMenuLevel ? $this->TP->StartMenuLevel : 0 ] );
		$sideNav = $navigacija->sideMenu( $pageID, false, true );
		$this->page->allLang = Language::getModuleOnAllLanguages( $_GET["module"] );
		$rootPage = $navigacija->getPage( $navigacija->linkToID( $_GET["FullPaths"][ $this->TP->StartMenuLevel ? $this->TP->StartMenuLevel : 0 ] ));

		$subPages = $navigacija->defaultSideMeni( $navigacija->linkToID($_GET["path"]), false, true, true );

		$this->page->headingImage = Media::get( MyModules::PAGES, $this->page->ID, mediaTypes::image, true, true )[0]; 
		
		//*RENDER ON SERVER*//
		$this->page->filename = false;
		$this->page->content = $this->render("./views/pageWithSubpagesSkijalista.php", [ "nav" => $sideNav, "subPages" => $subPages, "rootPage" => $rootPage ] );
		
		echo json_encode( $this->page );
	}

	public function pageWithSubpages(){
	
		$navigacija = new Navigacija();
		
		$pageID = $navigacija->linkToID( $_GET["FullPaths"][ $this->TP->StartMenuLevel ? $this->TP->StartMenuLevel : 0 ] );
		$sideNav = $navigacija->sideMenu( $pageID, false, true );
		
		$rootPage = $navigacija->getPage( $navigacija->linkToID( $_GET["FullPaths"][ $this->TP->StartMenuLevel ? $this->TP->StartMenuLevel : 0 ] ));

		$subPages = $navigacija->defaultSideMeni( $navigacija->linkToID($_GET["path"]), false, true, true );

		$this->page->headingImage = Media::get( MyModules::PAGES, $this->page->ID, mediaTypes::image, true, true )[0]; 
		
		//*RENDER ON SERVER*//
		$this->page->filename = false;
		$this->page->content = $this->render("./views/pageWithSubpages.php", [ "nav" => $sideNav, "subPages" => $subPages, "rootPage" => $rootPage ] );
		
		echo json_encode( $this->page );
	}

	public function index(){
		
		$news = new News();

		$this->page->news = $news->getNajnovije(497, 3);
		$this->page->blogPost = $news->getNajnovije(498, 1)[0];
		$this->page->allLang = Language::getModuleOnAllLanguages( $_GET["module"] );
		
		$places = new Places();
		$specialTours = $places->getForCategory(25);

		/*ADD EXTRA FIELDS*/
		foreach ($specialTours as $key => $tour) {
			$specialTours[$key]["CustomFieldsValues"] = json_decode($specialTours[$key]["CustomFieldsValues"]);
		}

		$this->page->specialTours = $specialTours;

		//GET TABS 
		$navigacija = new Navigacija();
		$tabs = $navigacija->defaultSideMeni( 532, true, true, true );

		foreach ($tabs as $key => &$tab) {
			
			$specialTours = $places->getForCategory( $tab["ID"] );
			foreach ($specialTours as $key => $tour) {
				$specialTours[$key]["CustomFieldsValues"] = json_decode($specialTours[$key]["CustomFieldsValues"]);
			}
			$tab["tours"] = $specialTours;

 		}

 		$this->page->tabs = $tabs;
		
		/*ADD CLASS TO BODY*/
		$this->page->bodyClass = "index";

		echo json_encode( $this->page );
	}

	public function partnerFormular(){
		$navigacija = new Navigacija();
		
		$pageID = $navigacija->linkToID( $_GET["FullPaths"][ $this->TP->StartMenuLevel ? $this->TP->StartMenuLevel : 0 ] );
		$this->page->sideNav = $navigacija->sideMenu( $pageID, false, true );
		$this->page->rootPage = $navigacija->getPage( $navigacija->linkToID( $_GET["FullPaths"][ $this->TP->StartMenuLevel ? $this->TP->StartMenuLevel : 0 ] ));
		
		echo json_encode( $this->page );
	}

	public function privatniFormular(){
		$navigacija = new Navigacija();
		
		$pageID = $navigacija->linkToID( $_GET["FullPaths"][ $this->TP->StartMenuLevel ? $this->TP->StartMenuLevel : 0 ] );
		$this->page->sideNav = $navigacija->sideMenu( $pageID, false, true );
		$this->page->rootPage = $navigacija->getPage( $navigacija->linkToID( $_GET["FullPaths"][ $this->TP->StartMenuLevel ? $this->TP->StartMenuLevel : 0 ] ));
		
		echo json_encode( $this->page );
	}

	public function kontaktFormular(){
		$navigacija = new Navigacija();
		
		$pageID = $navigacija->linkToID( $_GET["FullPaths"][ $this->TP->StartMenuLevel ? $this->TP->StartMenuLevel : 0 ] );
		$this->page->sideNav = $navigacija->sideMenu( $pageID, false, true );
		$this->page->rootPage = $navigacija->getPage( $navigacija->linkToID( $_GET["FullPaths"][ $this->TP->StartMenuLevel ? $this->TP->StartMenuLevel : 0 ] ));
		
		echo json_encode( $this->page );
	}

	public function putovanjaPoMjeri(){
		$navigacija = new Navigacija();
		
		$pageID = $navigacija->linkToID( $_GET["FullPaths"][ $this->TP->StartMenuLevel ? $this->TP->StartMenuLevel : 0 ] );
		$this->page->sideNav = $navigacija->sideMenu( $pageID, false, true );
		$this->page->rootPage = $navigacija->getPage( $navigacija->linkToID( $_GET["FullPaths"][ $this->TP->StartMenuLevel ? $this->TP->StartMenuLevel : 0 ] ));
		
		echo json_encode( $this->page );
	}
	
} 
?>