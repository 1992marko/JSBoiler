<?php 

require_once("classes/Class.Navigacija.php");
require_once("BaseController.php");
require_once("classes/Class.Language.php");
require_once("classes/Class.News.php");
require_once("classes/Class.Places.php");

class NewsController extends BaseController
{ 	

	public function __construct($_page = null){
		parent::__construct( $_page );
	}

	public function listArticles(){
		error_reporting(1);
		$navigacija = new Navigacija();
		$news = new News();
		
		$placesData = $news->getForCategory( $navigacija->linkToID( $_GET["path"] ) );
		$rootPage = $navigacija->getPage( $navigacija->linkToID( $_GET["FullPaths"][ $this->TP->StartMenuLevel ? $this->TP->StartMenuLevel : 0 ] ));

		//***RENDER ON SERVER***//
		$this->page->content = $this->render("./views/News/listArticles.php", [ "nav" => $sideNav, "places" => $placesData, "rootPage" => $rootPage ] );
		$this->page->filename = false;
		
		echo json_encode( $this->page );
	}

	public function listBlog(){
		
		$navigacija = new Navigacija();
		$news = new News();
		
		$placesData = $news->getForCategory( $navigacija->linkToID( $_GET["path"] ), false, true );
		$rootPage = $navigacija->getPage( $navigacija->linkToID( $_GET["FullPaths"][ $this->TP->StartMenuLevel ? $this->TP->StartMenuLevel : 0 ] ));

		//***RENDER ON SERVER***//
		$this->page->content = $this->render("./views/News/listBlog.php", [ "nav" => $sideNav, "places" => $placesData, "rootPage" => $rootPage ] );
		$this->page->filename = false;
		
		echo json_encode( $this->page );
	}


	public function defaultArticle(){
		
		$navigacija = new Navigacija();
		$sideNav = $navigacija->sideMenu( $navigacija->linkToID( $_GET["FullPaths"][ $this->TP->StartMenuLevel ? $this->TP->StartMenuLevel : 0 ] ), false, true );
		$this->page->allLang = Language::getModuleOnAllLanguages( $_GET["module"] );

		$this->page->headingImage = Media::get( MyModules::PAGES, $this->page->ID, mediaTypes::image, true, true )[0]; 

		$news = new News();
		$article = $news->getNovost( $_GET["objectID"] );

		$latestArticles = $news->getNajnovije( $navigacija->linkToID( $_GET["FullPaths"][0] ), 5 );

		//***RENDER ON SERVER***//
		$this->page->content = $this->render("./views/News/defaultArticle.php", [ 
			"nav" => $sideNav, 
			"article" => $article, 
			
			"articles" => $latestArticles 
		]);

		$this->page->filename = false;
		echo json_encode( $this->page );
	}

	public function defaultBlog(){
		
		$navigacija = new Navigacija();
		$sideNav = $navigacija->sideMenu( $navigacija->linkToID( $_GET["FullPaths"][ $this->TP->StartMenuLevel ? $this->TP->StartMenuLevel : 0 ] ), false, true );
		//$this->page->allLang = Language::getModuleOnAllLanguages( $_GET["module"] );

		$this->page->headingImage = Media::get( MyModules::PAGES, $this->page->ID, mediaTypes::image, true, true )[0]; 

		$news = new News();
		$article = $news->getNovost( $_GET["objectID"] );

		$latestArticles = $news->getNajnovije( $navigacija->linkToID( $_GET["FullPaths"][0] ), 5 );

		//***RENDER ON SERVER***//
		$this->page->content = $this->render("./views/News/defaultBlog.php", [ 
			"nav" => $sideNav, 
			"article" => $article, 
			
			"articles" => $latestArticles 
		]);

		$this->page->filename = false;
		echo json_encode( $this->page );
	}


} 
?>