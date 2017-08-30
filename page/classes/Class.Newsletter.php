<?php

class Newsletter
{

	public function __construct() { }
	
	public function trackNewsletterItem($id){
		$sql = "INSERT INTO `tzgz`.`newsletter_track` (`itemID`, `date`, `ip`) VALUES ( '".$id."', NOW(), '".$_SERVER['REMOTE_ADDR']."' )";
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();
	}

}

?>