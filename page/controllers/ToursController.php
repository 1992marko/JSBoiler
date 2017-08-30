<?php 

require_once("classes/Class.Navigacija.php");
require_once("BaseController.php");
require_once("classes/Class.Language.php");
require_once("classes/Class.News.php");
require_once("classes/Class.Places.php");

class ToursController extends BaseController
{ 	

	public function __construct($_page = null){
		parent::__construct( $_page );
	}

	public function TourSearchResults(){
		
		$navigacija = new Navigacija();
		$sideNav = $navigacija->sideMenu( $navigacija->linkToID( $_GET["FullPaths"][ $this->TP->StartMenuLevel ? $this->TP->StartMenuLevel : 0 ] ), false, true );
		$this->page->allLang = Language::getModuleOnAllLanguages( $_GET["module"] );

		$rootPage = $navigacija->getPage( $navigacija->linkToID( $_GET["FullPaths"][ $this->TP->StartMenuLevel ? $this->TP->StartMenuLevel : 0 ] ));

		$this->page->filters = $navigacija->defaultSideMeni(452, true, true, true);

		echo json_encode( $this->page );
	
	}

} 
?>