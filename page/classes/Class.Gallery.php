<?php 
class Gallery 
{ 

    public function getTitle($ID){
    	
    	$sql = "select naziv from galerije WHERE ID = :ID ".language::getLang()."";
		
		$db = Website::getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam(':ID', $ID );
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_OBJ);
		
		return $row->naziv;
    }

	
} 
?>