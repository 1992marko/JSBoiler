<?php 

require_once(__DIR__."/../../Config.php");
require_once(__DIR__."/../../api/classes/Class.DB.php");
require_once(__DIR__."/../../api/classes/Class.Authentication.php");
require_once(__DIR__."/../../api/travelink/ClientManagement.php");

class Users 
{ 
	
	public function __construct() {
		$this->registerSession();	
	}
	
	//Registriraj session ako nije napravljen
	public function registerSession(){
		session_start();
	}
	
	
	public function registerUser($ime, $prezime, $adresa, $title, $grad, $postanski, $email, $password){
	
		if(!$this->checkEmail($email)){

			$ucime = ucfirst($ime);
			$ucprezime = ucfirst($prezime);
			
			$client = new Client();
		    $client->firstName = $ucime;
		    $client->lastName = $ucprezime;
		    $client->title = $title;
		    $client->email = $email;
	    	//$client->dateOfBirth = DateTime::createFromFormat('d.m.Y', $dob)->format("Y-m-d");

			$cm = new ClientManagement();
			$tlUser = $cm->CreateClient($client);
		
			$sql = "INSERT INTO users SET ime = :ime, prezime = :prezime, title = :title, adresa=:adresa, grad = :grad, postanski = :postanski, email = :email, password = :password, ExternalReferenceID = :ExternalReferenceID,  aktivan = 1";
			$db = Website::getConnection();
			$stmt = $db->prepare($sql);

			$MD5Password = md5($password);

			$stmt->bindParam(":ExternalReferenceID", $client->id);
			$stmt->bindParam(':ime', $ucime);
			$stmt->bindParam(':prezime', $ucprezime);
			$stmt->bindParam(':title', $title);
			$stmt->bindParam(':adresa', $adresa);
			$stmt->bindParam(':grad', $grad);
			$stmt->bindParam(':postanski', $postanski);
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':password', $MD5Password);
			$stmt->execute();

			$user = $this->login($email, $password);
			return $user;

		}
		
		else{
			http_response_code(401);
		}
	}

	public function checkEmail($email){
		
		$sql = "SELECT email FROM users where email = :email";
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':email', $email);
		$stmt->execute();
		$user = $stmt->fetchObject();
		
		if($user) {		
			return true;
		} else {
			return false;
		}

		

		
	}

	
	public function getUser($id){
	
		$res = mysql_query("SELECT * FROM users where ID = $id");

		if($res){
			$user = mysql_fetch_array($res, MYSQL_ASSOC);
			return $user;
		}
	
	}

	
	public function isUserLogedIn(){
		
		
		if( strlen($_SESSION["user_id"]) > 0 ){
			return true;
		}
	}

	
	public function checkSession(){
		
		if(!$this->isUserLogedIn()){
			header("Location: /login");
		}
	}

	
	public function login($email, $password){
		
		$sql = "SELECT ime, prezime, email FROM users where email = '$email' and password = '".md5($password)."' LIMIT 1";
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();
		$user = $stmt->fetchObject();

		if($user) {		

			DB::InitEloquent();
			$authPass = Authentication::Login($email, $password);

			if($authPass){
				//$_SESSION["user"] = $user;
				return $user;
			} else {
				$this->logout();
				http_response_code(401);
			}

			
		}

		else{
			$this->logout();
			http_response_code(401);
		
		}

		
	}

	
	public function logout(){
		unset($_SESSION["user"]);
	}
	
} 

//AJAX CALL
$mode = $_POST["mode"];

if(isset($_POST["mode"])){
	
	require_once("DB.php");
	$db = Website::getConnection();
	
	$users = new Users; 
	
	switch($mode){
		
		case "register":
		$user = $users->registerUser($_POST['ime'], $_POST['prezime'], $_POST['adresa'], $_POST['title'], $_POST['grad'], $_POST['postanski'], $_POST['email'], $_POST['password']);
		echo json_encode($user);
		break;
		
		case "login":
		$user = $users->login($_POST['email'], $_POST['password']);
		echo json_encode($user);
		break;
		
		case "logout":
		$users->logout();
		break;
		
	}
}
?>