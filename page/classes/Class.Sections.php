<?php 
class Sections 
{ 
	
	
	
	public function getSection($link){
		
		$sql = "select * from sections where link = '".$link."' ".language::getLang()."";
		$res = mysql_query($sql);
		
		$content = @mysql_result($res,0,'content');
		
		echo $content;
		
	}
	
	
} 

//AJAX CALL
$mode = $_GET[mode];

if(isset($_GET[mode])){
	
	include('../classes/site_settings.php'); 
	$web = new site_defaults; 
	$web->DBConnect();	
	
	$sections = new Sections; 
	
	switch($mode){
		
		case "getSection":
		$sections->getSection($_POST['link']);
		break;
		
	}
}
?>