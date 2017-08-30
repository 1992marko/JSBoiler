<?php 

require_once("classes/Class.Media.php");

class BaseController
{ 	

	public $page;
	public $TP;

	// public function __construct($_page = null){
	// 	$this->page = $_page;
	// 	$this->object = $_object;
	// 	$this->template = ($_object!=null)?$_object->Template:$_page->filename;
	// 	$this->page->template = $this->page->filename;
	// 	$this->page->filename = $this->template;

	// 	if($this->page->TemplateParametars){
	// 		$this->page->TemplateParametars = json_decode( htmlspecialchars_decode( $this->page->TemplateParametars ));
	// 	}
	// }

	public function render($template, $params){

		foreach ($params as $key => $value){
			${$key} = $value;
		}

		ob_start();
		require($template);
		$output = ob_get_clean();
		return $output;

	}


	public function getPersons(){

		
		$name = isset($_GET["name"]) ? $_GET["name"] : "";

		$sql = "select * from persons where Name like '%".$name."%' or Surname like '%".$name."%' or PhoneNumber like '%".$name."%' order by name asc";
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

		echo json_encode($results);
	}


	public function getPerson($request, $response, $args){

		$sql = "select * from persons where id = ".$args["id"]." order by name asc";
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();
		$result = $stmt->fetchObject();

		echo json_encode($result);

	}

	public function updatePerson($request, $response, $args){

		$vars = $request->getParsedBody();
		$queryParams = $request->getQueryParams();

		$sql = "update persons set Name = '".$vars["Name"]."', Surname = '".$vars["Surname"]."', PhoneNumber = '".$vars["PhoneNumber"]."' where id = ".$args["id"];
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();

		echo json_encode($vars);

	}

	public function addPerson($request, $response, $args){

		$vars = $request->getParsedBody();
		$queryParams = $request->getQueryParams();

		$sql = "insert into persons set Name = '".$vars["Name"]."', Surname = '".$vars["Surname"]."', PhoneNumber = '".$vars["PhoneNumber"]."'";
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();

		$lastId = $db->lastInsertId();
		$vars["id"] = $lastId;

		echo json_encode($vars);

	}


	public function deletePerson($request, $response, $args){

		$vars = $request->getParsedBody();
		$queryParams = $request->getQueryParams();

		$sql = "delete from persons where id = ".$args["id"];
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();

		return true;

	}



























	public function getMovies(){

		$name = isset($_GET["name"]) ? $_GET["name"] : "";

		$sql = "
			select m.*, r.state, ifnull(max(state), '0') as state from movies m
			left join rents r on m.id = r.movie
			where name like '%".$name."%' 
			group by m.id
			order by m.name asc
		";
		// $sql = "select * from movies where name like '%".$name."%' order by name asc";
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

		echo json_encode($results);
	}


	public function getMovie($request, $response, $args){

		$sql = "select * from movies where id = ".$args["id"];
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();
		$result = $stmt->fetchObject();

		echo json_encode($result);

	}

	public function updateMovie($request, $response, $args){

		$vars = $request->getParsedBody();
		$queryParams = $request->getQueryParams();

		$sql = "update movies set name = '".$vars["name"]."', genre = '".$vars["genre"]."', year = '".$vars["year"]."', description = '".$vars["description"]."' where id = ".$args["id"];
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();

		echo json_encode($vars);

	}

	public function addMovie($request, $response, $args){

		$vars = $request->getParsedBody();
		$queryParams = $request->getQueryParams();

		$sql = "insert into movies set name = '".$vars["name"]."', genre = '".$vars["genre"]."', year = '".$vars["year"]."', description = '".$vars["description"]."'";
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();

		$lastId = $db->lastInsertId();
		$vars["id"] = $lastId;

		echo json_encode($vars);

	}


	public function deleteMovie($request, $response, $args){

		$vars = $request->getParsedBody();
		$queryParams = $request->getQueryParams();

		$sql = "delete from movies where id = ".$args["id"];
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();

		return true;

	}

















	public function getRents(){

		$sql = "
			select r.*, p.Name, p.Surname, m.name, max(r.state) as state from rents r 
			left join persons p on r.user = p.id
			left join movies m on r.movie = m.id
			group by concat(r.user,'.',r.movie)
			order by r.id desc
		";
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$output = array();
		foreach($results as $result){
			if($result["state"] == 1) $output[] = $result;
		}

		echo json_encode($output);
	}


	public function getRent($request, $response, $args){

		$sql = "
			select r.*, p.Name, p.Surname, m.name from rents r
			left join persons p on r.user = p.id
			left join movies m on r.movie = m.id
			where r.id = ".$args["id"]."
		";
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();
		$result = $stmt->fetchObject();

		echo json_encode($result);

	}

	public function updateRent($request, $response, $args){

		$vars = $request->getParsedBody();
		$queryParams = $request->getQueryParams();

		$sql = "insert into rents set user = '".$vars["user"]."', movie = '".$vars["movie"]."', state = '".$vars["state"]."', date = NOW() ";
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();

		echo json_encode($vars);

	}

	public function addRent($request, $response, $args){

		$vars = $request->getParsedBody();
		$queryParams = $request->getQueryParams();

		$sql = "insert into rents set user = '".$vars["user"]."', movie = '".$vars["movie"]."', state = '".$vars["state"]."', date = NOW() ";
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();

		$lastId = $db->lastInsertId();
		$vars["id"] = $lastId;

		echo json_encode($vars);

	}


	public function deleteRent($request, $response, $args){

		$vars = $request->getParsedBody();
		$queryParams = $request->getQueryParams();

		$sql = "delete from rents where id = ".$args["id"];
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();

		return true;

	}



	
} 
?>