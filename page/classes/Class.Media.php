<?php

class foreignTypes
{
	
	const Novosti = 1;
	const Pages = 2;
	const Places = 3;
	const Events = 4;
	
	
}

class mediaTypes
{
	const unknown = null;
	const image = "IMAGE";
	const video = "VIDEO";
	const pdf = "PDF";
}

class fileTypes
{
	public static $imageTypes = array("jpg", "jpeg", "png");
	public static $pdfTypes = array("pdf");
}

class Media
{

	// path - source file path
	// fileName - source file name
	// returns:
	// if file exists - hour + minute + sec + "-" + original filename,
	// else original filename
	public static function checkFileName($path, $fileName)
	{
		if (file_exists($path . $fileName))
			return date("hms") . "-" . $fileName;
		return $fileName;
	}
	
	public static function isImage($fileName)
	{
		$ext = pathinfo($fileName, PATHINFO_EXTENSION);
		return in_array($ext, fileTypes::$imageTypes);
	}
	
	public static function isPNG($fileName)
	{
		$ext = pathinfo($fileName, PATHINFO_EXTENSION);
		return in_array($ext, array("PNG", "png"));
	}
	
	public static function isPDF($fileName)
	{
		$ext = pathinfo($fileName, PATHINFO_EXTENSION);
		return in_array($ext, fileTypes::$pdfTypes);
	}
	
	public static function getMediaType($fileName)
	{
		if (media::isImage($fileName))
			return mediaTypes::image;
		if (media::isPDF($fileName))
			return mediaTypes::pdf;
		
		return mediaTypes::unknown;
	}


	public static function Insert( $foreignType, $foreignID, $fileName, $primaryMedia, $mediaType, $externalSite, $orderNum, $active, $deactivateOld = false, $published = true) 
	{
	
		// only one primary media possible
		if ($primaryMedia)
		{
			media::removePrimaryMediaByForeignIDForeignTypeMediaType($foreignID, $foreignType, $mediaType);
		}
		
		// deacitate active media instead of delete
		if ($deactivateOld)
		{
			media::deactivateByForeignIDForeignTypeMediaType($foreignID, $foreignType, $mediaType);
		}
		
		$sql = "INSERT INTO media (ForeignType, ForeignID, FileName, PrimaryMedia, MediaType, ExternalLink, OrderNum, Active, Published) VALUES ( :foreignType, :foreignID, :fileName, :primaryMedia, :mediaType, :externalLink, :orderNum, :active, :published )";
			
		try 
		{
			$db = Website::getConnection();
			$stmt = $db->prepare($sql); 
			
			$stmt->bindParam("foreignType", $foreignType, PDO::PARAM_INT);
			$stmt->bindParam("foreignID", $foreignID,  PDO::PARAM_INT);
			$stmt->bindParam("fileName", $fileName,  PDO::PARAM_STR, 200);
			$stmt->bindParam("primaryMedia", $primaryMedia, PDO::PARAM_BOOL);
			$stmt->bindParam("mediaType", $mediaType, PDO::PARAM_STR, 10 );
			$stmt->bindParam("externalLink", $externalLink, PDO::PARAM_STR, 10);
			$stmt->bindParam("orderNum", $orderNum, PDO::PARAM_INT);
			$stmt->bindParam("active", $active, PDO::PARAM_BOOL);
			$stmt->bindParam("published", $published, PDO::PARAM_BOOL);		
			
			$stmt->execute();	
			$lastID = $db->lastInsertId();

			$stmt2 = $db->prepare("SELECT * from media m JOIN ModuleSettings ms ON m.ForeignType = ms.MediaForeignType WHERE MediaID=:ID");
			$stmt2->bindParam("ID", $lastID);
			$stmt2->execute();	
			$image = $stmt2->fetch(PDO::FETCH_OBJ);
			
			return $image;

			
		} 
		catch(PDOException $e) 
		{
			echo '{"error":{"text":'. $e->getMessage() .'}}'; 
		}
	}
	
	
	
	
	
	public static function updateByID($id)
	{
		$request = Slim::getInstance()->request();
		$body = $request->getBody();
	
		$media = json_decode($body);
		
		$sql = "UPDATE media SET Description = :description, Published = :published WHERE MediaID=:id";// and lang = :lang";
		try {
			$db = Website::getConnection();
			$stmt = $db->prepare($sql);
	
			$stmt->bindParam("id", $id); 
			$stmt->bindParam("description", $media->Description);
			$stmt->bindParam("published", $media->Published);
			
			
			$stmt->execute();
			
			$db = null;
			
			echo json_encode($media); 
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}'; 
		}
	}
	
	public static function get( $foreignType, $foreignID, $mediaType, $noEcho = false, $getPrimary = false )
	{


		$sql = "SELECT m.MediaID, m.ForeignType, m.ForeignID, m.FileName, m.PrimaryMedia, m.MediaType, m.ExternalLink, m.OrderNum, m.Active, m.Description, m.Published FROM media m";
		
		if ($foreignType == foreignTypes::Places)
			$sql .= " join places i on m.ForeignID = i.id and i.lang = 'hr' and m.ForeignType = ".foreignTypes::Places;
		
		if ($foreignType == foreignTypes::Novosti)
			$sql .= " join novosti n on m.ForeignID = n.ID and n.lang = 'hr' and m.ForeignType = ".foreignTypes::Novosti;
				
		if(!$getPrimary){
			$sql .= " where m.Active = 1 and m.Published = 1 and m.MediaGroup = 'gallery and m.ForeignID = :foreignID";
		} else {
			$sql .= " where m.Active = 1 and m.Published = 1 and m.MediaGroup = 'heading' and m.ForeignID = :foreignID";
		}
		
		
		if ($mediaType != null)
			$sql .= " and m.MediaType = :mediaType";
			
		$sql .= " order by m.PrimaryMedia desc";
		
		try 
		{
			$db = Website::getConnection();
			$stmt = $db->prepare($sql); 
			
			$stmt->bindParam("foreignID", $foreignID,  PDO::PARAM_INT);
			$stmt->bindParam("mediaType", $mediaType, PDO::PARAM_STR, 10 );
			
			$stmt->execute();
			 
			$media = $stmt->fetchAll(PDO::FETCH_OBJ);
				
			$retVal = array('media'=>$media);
			$db = null;
			
			if ($noEcho)
				return $media;
			
			echo json_encode($media);

		} 
		catch(PDOException $e) 
		{
			echo '{"error":{"text":'. $e->getMessage() .'}}'; 
		}
		
	}
	
	public static function getByID( $mediaID, $noEcho = false)
	{
		$sql = "SELECT m.MediaID, m.ForeignType, m.ForeignID, m.FileName, m.PrimaryMedia, m.MediaType, m.ExternalLink, m.OrderNum, m.Active, m.Description, m.Published FROM media m";
			
		$sql .= " where m.MediaID = :mediaID";
		
					
		try 
		{
			$db = Website::getConnection();
			$stmt = $db->prepare($sql); 
			
			$stmt->bindParam("mediaID", $mediaID,  PDO::PARAM_INT);

			$stmt->execute();
			 
			$media = $stmt->fetchAll(PDO::FETCH_OBJ);
				
			$retVal = array('media'=>$media);
			$db = null;
			
			if ($noEcho)
				return $media;
			
			echo json_encode($media);

		} 
		catch(PDOException $e) 
		{
			echo '{"error":{"text":'. $e->getMessage() .'}}'; 
		}
		
	}
	
	public static function deactivate ($mediaID)
	{
		$sql = "update media set Active = 0 WHERE MediaID=:id and Active = 1";
		try {
			$db = Website::getConnection();
			$stmt = $db->prepare($sql);  
			$stmt->bindParam("id", $mediaID);
			$stmt->execute();
			$db = null;
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}'; 
		}
	}
	
	public static function deactivateByForeignIDForeignTypeMediaType ($foreignID, $foreignType, $mediaType)
	{
		
		$sql = "update media set Active = 0 WHERE ForeignID=:foreignID and ForeignType=:foreignType and MediaType=:mediaType and Active = 1";
		try {
			$db = Website::getConnection();
			$stmt = $db->prepare($sql);  
			$stmt->bindParam("foreignID", $foreignID,  PDO::PARAM_INT);
			$stmt->bindParam("foreignType", $foreignType,  PDO::PARAM_INT);
			$stmt->bindParam("mediaType", $mediaType, PDO::PARAM_STR, 10 );
			$stmt->execute();
			$db = null;
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}'; 
		}
	}
	
	public static function removePrimaryMediaByForeignIDForeignTypeMediaType ($foreignID, $foreignType, $mediaType)
	{
		
		$sql = "DELETE from media WHERE ForeignID=:foreignID and ForeignType=:foreignType and MediaType=:mediaType and MediaGroup = 'heading'";
		try {

			Media::deletePrimaryMediaImage($foreignID, $foreignType);

			$db = Website::getConnection();
			$stmt = $db->prepare($sql);  
			$stmt->bindParam("foreignID", $foreignID,  PDO::PARAM_INT);
			$stmt->bindParam("foreignType", $foreignType,  PDO::PARAM_INT);
			$stmt->bindParam("mediaType", $mediaType, PDO::PARAM_STR, 10 );
			$stmt->execute();
			$db = null;
		} catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}'; 
		}
	}


	public  static function deletePrimaryMediaImage($ForeignID, $ForeignType){
        
        $sql = "SELECT FileName, MediaFilePath from media JOIN ModuleSettings ON media.ForeignType = ModuleSettings.MediaForeignType WHERE media.ForeignID=:ForeignID and media.ForeignType = :ForeignType and media.primaryMedia = true";
        $pdo = Website::getConnection();
        $stmt = $pdo->prepare($sql); 
        $stmt->bindParam("ForeignID", $ForeignID);
        $stmt->bindParam("ForeignType", $ForeignType);
        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            
            @unlink("../../".$row["MediaFilePath"]."".$row["FileName"]);
            @unlink("../../".$row["MediaFilePath"]."tb_".$row["FileName"]);

            @unlink("../../".$row["MediaFilePath"]."preview_".$row["FileName"]);
            @unlink("../../".$row["MediaFilePath"]."xsmall_".$row["FileName"]);
            @unlink("../../".$row["MediaFilePath"]."small_".$row["FileName"]);
            @unlink("../../".$row["MediaFilePath"]."medium_".$row["FileName"]);
            @unlink("../../".$row["MediaFilePath"]."large_".$row["FileName"]);
            

        }
    }


	public static function deleteMediaImage($MediaID){
        
        $sql = "SELECT FileName, MediaFilePath from media JOIN ModuleSettings ON media.ForeignType = ModuleSettings.MediaForeignType WHERE media.MediaID = :MediaID";
        $pdo = Website::getConnection();
        $stmt = $pdo->prepare($sql); 
        $stmt->bindParam("MediaID", $MediaID);
        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            
            @unlink("../../".$row["MediaFilePath"]."".$row["FileName"]);
            @unlink("../../".$row["MediaFilePath"]."tb_".$row["FileName"]);

            @unlink("../../".$row["MediaFilePath"]."preview_".$row["FileName"]);
            @unlink("../../".$row["MediaFilePath"]."xsmall_".$row["FileName"]);
            @unlink("../../".$row["MediaFilePath"]."small_".$row["FileName"]);
            @unlink("../../".$row["MediaFilePath"]."medium_".$row["FileName"]);
            @unlink("../../".$row["MediaFilePath"]."large_".$row["FileName"]);
            
        }
    }

    public static function deleteMediaImages($ForeignID, $ForeignType){
        
        $sql = "SELECT FileName, MediaFilePath from media JOIN ModuleSettings ON media.ForeignType = ModuleSettings.MediaForeignType WHERE media.ForeignID=:ForeignID and media.ForeignType = :ForeignType";
        $pdo = Website::getConnection();
        $stmt = $pdo->prepare($sql); 
        $stmt->bindParam("ForeignID", $ForeignID);
        $stmt->bindParam("ForeignType", $ForeignType);
        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            
            @unlink("../../".$row["MediaFilePath"]."".$row["FileName"]);
            @unlink("../../".$row["MediaFilePath"]."tb_".$row["FileName"]);

            @unlink("../../".$row["MediaFilePath"]."preview_".$row["FileName"]);
            @unlink("../../".$row["MediaFilePath"]."xsmall_".$row["FileName"]);
            @unlink("../../".$row["MediaFilePath"]."small_".$row["FileName"]);
            @unlink("../../".$row["MediaFilePath"]."medium_".$row["FileName"]);
            @unlink("../../".$row["MediaFilePath"]."large_".$row["FileName"]);
            

        }
    }
	
}

?>