<?php 

require_once("classes/Class.Navigacija.php");
require_once("BaseController.php");
require_once("classes/Class.Language.php");
require_once("classes/Class.News.php");
require_once("classes/Class.Places.php");

class PlacesController extends BaseController
{ 	

	public function __construct($_page = null){
		parent::__construct( $_page );
	}

	public function listajSmjestaj(){
		
		$navigacija = new Navigacija();
		$sideNav = $navigacija->sideMenu( $navigacija->linkToID( $_GET["FullPaths"][ $this->TP->StartMenuLevel ? $this->TP->StartMenuLevel : 0 ] ), false, true );
		//$this->page->allLang = Language::getModuleOnAllLanguages( $_GET["module"] );

		$this->page->headingImage = Media::get( MyModules::PAGES, $this->page->ID, mediaTypes::image, true, true )[0]; 

		$places = new Places();
		$placesData = $places->getForCategory( $navigacija->linkToID( $_GET["path"] ) );

		$rootPage = $navigacija->getPage( $navigacija->linkToID( $_GET["FullPaths"][ $this->TP->StartMenuLevel ? $this->TP->StartMenuLevel : 0 ] ));

		//***RENDER ON SERVER***//
		$this->page->content = $this->render("./views/Places/listajSmjestaj.php", [ "nav" => $sideNav, "placesData" => $placesData, "rootPage" => $rootPage ] );
		$this->page->filename = false;
		
		echo json_encode( $this->page );
	}

	public function listajTure(){
		
		$navigacija = new Navigacija();
		$sideNav = $navigacija->sideMenu( $navigacija->linkToID( $_GET["FullPaths"][ $this->TP->StartMenuLevel ? $this->TP->StartMenuLevel : 0 ] ), false, true );
		$this->page->allLang = Language::getModuleOnAllLanguages( $_GET["module"] );

		$this->page->headingImage = Media::get( MyModules::PAGES, $this->page->ID, mediaTypes::image, true, true )[0]; 

		$places = new Places();
		$placesData = $places->getForCategory( $navigacija->linkToID( $_GET["path"] ) );

		$rootPage = $navigacija->getPage( $navigacija->linkToID( $_GET["FullPaths"][ $this->TP->StartMenuLevel ? $this->TP->StartMenuLevel : 0 ] ));

		//***RENDER ON SERVER***//
		$this->page->content = $this->render("./views/Places/listajTure.php", [ "nav" => $sideNav, "places" => $placesData, "rootPage" => $rootPage ] );
		$this->page->filename = false;
		
		echo json_encode( $this->page );
	}

	public function WideWithoutMenu(){
		
		$navigacija = new Navigacija();

		$this->page->allLang = Language::getModuleOnAllLanguages( $_GET["module"] );

		$places = new Places();
		$placesData = $places->getForCategory( $navigacija->linkToID( $_GET["path"] ) );

		//***RENDER ON SERVER***//
		$this->page->content = $this->render("./views/Places/WideWithoutMenu.php", [ "places" => $placesData ] );
		$this->page->filename = false;
		
		echo json_encode( $this->page );
	}

	public function skijaliste(){

		$navigacija = new Navigacija();
		$this->page->allLang = Language::getModuleOnAllLanguages( $_GET["module"] );
		
		$places = new Places();
		$skijaliste = $places->getForCategory( $navigacija->linkToID( $_GET["path"] ), false, [], true, null, 4 );

		$skijaliste = $places->getPlace( $skijaliste[0]["ID"] );

		$objekti = $places->getForCategory( $navigacija->linkToID( $_GET["path"] ), false, [], true, null, 1 );

		$filters = $place->filters = $places->getSelectedFilters( $skijaliste->ID );
		
		//***RENDER ON SERVER***//
		$this->page->content = $this->render("./views/Places/skijaliste.php", [ "skijaliste" => $skijaliste, "objekti" => $objekti, "filters" => $filters ] );
		$this->page->filename = false;

		echo json_encode( $this->page );
	}

	public function defaultTour(){
		
		$places = new Places();

		$place = $places->getPlace( $_GET["objectID"] );
		
		$place->filename = $_GET["object"]->Template;
		$place->allLang = Language::getModuleOnAllLanguages( $_GET["module"] );
		$place->media = Media::get( MyModules::PLACES, $place->ID, mediaTypes::image, true ); 
		$place->CustomFieldsValues = json_decode($place->CustomFieldsValues);
		$place->page = $this->page;
		echo json_encode( $place );
		
	}

	public function defaultAccomodation(){
		
		$places = new Places();
		$place = $places->getPlace( $_GET["objectID"] );

		$place->filename = $_GET["object"]->Template;
		//$place->allLang = Language::getModuleOnAllLanguages( $_GET["module"] );
		$place->CustomFieldsValues = json_decode($place->CustomFieldsValues);
		$place->media = Media::get( MyModules::PLACES, $place->ID, mediaTypes::image, true ); 
		$place->filters = $places->getSelectedFilters($_GET["objectID"]);
		$place->page = $this->page;
		
		echo json_encode( $place );
	}

} 
?>