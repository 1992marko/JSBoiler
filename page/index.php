<?php 
error_reporting(E_ALL & ~E_NOTICE);
session_start();

require_once __DIR__."/vendor/autoload.php";
require_once('classes/DB.php'); 
require_once('classes/Class.Language.php');
require_once("controllers/BaseController.php");
require_once("controllers/SettingsController.php");
require_once("controllers/PagesController.php");
require_once("controllers/PlacesController.php");
require_once("controllers/NewsController.php");
require_once("controllers/CreateMailController.php");

$navigacija = new Navigacija();
$navigacija->setupURL();
$template = $navigacija->getSelectedLinkTemplate();

//CALL THE CONTROLLER FUNCTION
$temp = explode("#", $template);

//AKO IMA TEMPLATE IZ BAZE
if(!empty($template)){	
	
	//Get link on all languages
	//$allLanguages = Language::getModuleOnAllLanguages( $_GET["module"] );

	//Get all words from langwords in translations session
	// Language::PrepareWords();
	$controller = new $temp[0]($_GET["page"], $_GET["object"]);
	$controller->{$temp[1]}();
	exit;

} 


//AKO NEMA IMA TEMPLATE POGLEDAJ CUSTOM RUTE
else {

	//$container = new \Slim\Container();
	$container = new \Slim\Container(['settings' => ['displayErrorDetails' => true]]);
	$app = new \Slim\App($container);

	//DEFINE ROUTES HERE
	$app->get('/settings', 'SettingsController:get');
	$app->post('/login', 'SettingsController:login');
	$app->post('/contactMail', 'CreateMailController:contactMail');
	$app->post('/partnerMail', 'CreateMailController:partnerMail');
	$app->post('/privatniFormularMail', 'CreateMailController:privatniFormularMail');
	$app->post('/tourMail', 'CreateMailController:tourMailRequest');
	$app->post('/objectOnRequest', 'CreateMailController:objectOnRequest');
	$app->post('/putovanjaPoMjeriMail', 'CreateMailController:putovanjaPoMjeri');
	

	$app->get('/persons', 'BaseController:getPersons');
	$app->post('/person', 'BaseController:addPerson');
	$app->get('/person/{id}', 'BaseController:getPerson');
	$app->put('/person/{id}', 'BaseController:updatePerson');
	$app->delete('/person/{id}', 'BaseController:deletePerson');



	$app->get('/movies', 'BaseController:getMovies');
	$app->post('/movie', 'BaseController:addMovie');
	$app->get('/movie/{id}', 'BaseController:getMovie');
	$app->put('/movie/{id}', 'BaseController:updateMovie');
	$app->delete('/movie/{id}', 'BaseController:deleteMovie');

	$app->get('/rents', 'BaseController:getRents');
	$app->post('/rent', 'BaseController:addrent');
	$app->get('/rent/{id}', 'BaseController:getRent');
	$app->put('/rent/{id}', 'BaseController:updateRent');
	$app->delete('/rent/{id}', 'BaseController:deleteRent');

	//END

	

	//SLIM NO ROUTE IS FOUND
	$container['notFoundHandler'] = function ($c) { 
		return function ($request, $response) use ($c) { 
			return $response->withStatus(404);
			//return null; //CAN RETURN 404
		}; 
	};

	$app->run();

}


?>