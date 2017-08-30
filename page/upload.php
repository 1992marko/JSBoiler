<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set("display_errors", 1);
ini_set('memory_limit', '256M');
header("access-control-allow-origin: *");
session_start();

Class ModuleSettings{
	public static function getModuleSettingImgDef($MSID){
		$pdo = Website::getConnection();
		$sql = "SELECT JSON_values, MediaFilePath FROM ModuleSettings WHERE ModuleSettingsID = $MSID";
		$stmt = $pdo->prepare($sql); 
		$stmt->execute();
		$res = $stmt->fetchObject();
		return $res;
	}
}

if(file_exists(__DIR__."/classes/DB.php")){
	require_once(__DIR__."/classes/DB.php");
} elseif(file_exists(__DIR__."/../CMS/API/Class.DB.php")){
	require_once(__DIR__."/../CMS/API/Class.DB.php");
} elseif(file_exists(__DIR__."/../API/Class.DB.php")){
	require_once(__DIR__."/../API/Class.DB.php");
} else {
	echo '{"Error":"Greška prilikom spajanja na bazu! (ne postoji DB klasa!)"}';
	exit;
}

if(file_exists(__DIR__."/classes/Class.Media.php")){
	require_once(__DIR__."/classes/Class.Media.php");
} elseif(file_exists(__DIR__."/../CMS/API/Class.Media.php")){
	require_once(__DIR__."/../CMS/API/Class.Media.php");	
} elseif(file_exists(__DIR__."/../API/Class.Media.php")){
	require_once(__DIR__."/../API/Class.Media.php");	
} else {
	echo '{"Error":"Greška prilikom spajanja na media tablicu! (ne postoji media klasa!)"}';
	exit;
}

if(file_exists(__DIR__."/Config.php")){
	require_once(__DIR__."/Config.php");
} elseif(file_exists(__DIR__."/../CMS/Config.php")){
	require_once(__DIR__."/../CMS/Config.php");
} elseif(file_exists(__DIR__."/../Config.php")){
	require_once(__DIR__."/../Config.php");
} else { }


$udir = !defined("SiteConfig::UPLOADDIR") ? "../" : SiteConfig::UPLOADDIR;
$basePath = __DIR__."/".$udir;

define('KB', 1024);
define('MB', 1048576);
define('GB', 1073741824);
define('TB', 1099511627776);

$allowedTypes = array("image/jpeg", "image/jpg", "image/png");
$upload_max_size = str_replace("M", "", ini_get('upload_max_filesize'));

if(isset($_FILES["File"])){
	if($_FILES["File"]["size"] > $upload_max_size*MB){
		echo '{"Error":"Vaš server ne podržava uploadanje slika većih od '.$upload_max_size.' MB"}';
		exit;
	} 
}

if(isset($_POST) && $_POST["name"] || $_POST["images"]){
	if($_POST["images"]){
		foreach ($_POST["images"] as $image) {
			$filesize = filesize("../".$image["name"]);
			if($filesize > $upload_max_size*MB){
				echo '{"Error":"Vaš server ne podržava uploadanje slika većih od '.$upload_max_size.' MB"}';
				exit;
			}
		}
	} else {
		$filesize = filesize($_POST["name"]);
		if($filesize > $upload_max_size*MB){
			echo '{"Error":"Vaš server ne podržava uploadanje slika većih od '.$upload_max_size.' MB"}';
			exit;
		}
	}
}

if($_POST){

	$imgDef = ModuleSettings::getModuleSettingImgDef($_POST["MSID"]);
	if (!file_exists($basePath.$imgDef->MediaFilePath)) { mkdir($basePath.$imgDef->MediaFilePath, 0777, true); }
	$thumbDefinitions = json_decode($imgDef->JSON_values);

	if($_POST["mode"] == "heading"){

		if(empty($thumbDefinitions->images->heading)){
			echo '{"Error":"Nisu upisane definicije za \'heading\' slike za ovaj modul!"}';
			exit;
		}

		$sourceFile = $_POST["name"];
		$copyTo = $basePath.$imgDef->MediaFilePath;
		$fileName = pathinfo($sourceFile, PATHINFO_FILENAME).'.'.pathinfo($sourceFile, PATHINFO_EXTENSION);
		if(isset($_FILES["File"])){
			move_uploaded_file( $_FILES["File"]["tmp_name"], $copyTo."/".$_FILES["File"]["name"]); 
			$sourceFile = $copyTo."/".$_FILES["File"]["name"];
			$toDelete = $sourceFile;
			$fileName = $_FILES["File"]["name"];
		}
		$newFileName = generateUniqueName($fileName);

		if (in_array($_FILES["File"]["type"], $allowedTypes) || !empty($_POST["name"])){
			foreach ($thumbDefinitions->images->heading as $thumbDefinition) {
				createThumbnail( $sourceFile, $thumbDefinition->prefix, $thumbDefinition->width, $thumbDefinition->height, $thumbDefinition->resize, $copyTo, $newFileName );
			}
			if($toDelete) unlink($toDelete);
		} else {
			rename( $copyTo."/".$_FILES["File"]["name"], $copyTo."/".$newFileName);
			copy( $copyTo."/".$newFileName, $copyTo."/small_".$newFileName);
		}

		$image = Media::Insert( $_POST["MSID"], $_POST["ForeignID"], $newFileName, true, mediaTypes::image, null , 0, true );
		echo json_encode($image);
	}

	if($_POST["mode"] == "gallery"){

		if(empty($thumbDefinitions->images->gallery)){
			echo '{"Error":"Nisu upisane definicije za \'gallery\' slike za ovaj modul!"}';
			exit;
		}

		$copyTo = $basePath.$imgDef->MediaFilePath;
		// $images = array();

		if(isset($_FILES["File"])){
			move_uploaded_file( $_FILES["File"]["tmp_name"], $copyTo."/".$_FILES["File"]["name"]); 
			$sourceFile = $copyTo."/".$_FILES["File"]["name"];
			$fileName = $_FILES["File"]["name"];
			$newFileName = generateUniqueName($fileName);
			foreach ($thumbDefinitions->images->gallery as $thumbDefinition) {
				createThumbnail( $sourceFile, $thumbDefinition->prefix, $thumbDefinition->width, $thumbDefinition->height, $thumbDefinition->resize, $copyTo, $newFileName );
			}
			unlink($sourceFile);
			$image = Media::Insert( $_POST["MSID"], $_POST["ForeignID"], $newFileName, false, mediaTypes::image, null , 0, true );
			// array_push($images, $image);
		} else {
			// for($i = 0; $i < count($_POST['images']); $i++){
				$sourceFile = "../".$_POST['image'];
				$fileName = pathinfo($sourceFile, PATHINFO_FILENAME).'.'.pathinfo($sourceFile, PATHINFO_EXTENSION);
				$newFileName = generateUniqueName($fileName);
				foreach ($thumbDefinitions->images->gallery as $thumbDefinition) {
					createThumbnail( $sourceFile, $thumbDefinition->prefix, $thumbDefinition->width, $thumbDefinition->height, $thumbDefinition->resize, $copyTo, $newFileName );
				}
				$image = Media::Insert( $_POST["MSID"], $_POST["ForeignID"], $newFileName, false, mediaTypes::image, null , 0, true );
				// array_push($images, $image);
			// }
		}
		echo json_encode($image);
	}

} else {
	echo '{"Error":"Došlo je do greške prilikom uploadanja slike/a. Molimo da kontaktirate administratora!"}';
	exit;
}

function generateUniqueName($fileName){
	$ext = pathinfo($fileName, PATHINFO_EXTENSION);
	$name = pathinfo($fileName, PATHINFO_FILENAME);

	$name = strtolower($name);									// LOWER CASE EVERYTHING 
	$name = preg_replace("/[^a-z0-9_\s-]/", "", $name);			// MAKE ALPHANUMERIC (REMOVES ALL OTHER CHARACTERS)
	$name = preg_replace("/[\s-]+/", " ", $name);				// CLEAN UP MULTIPLE DASHES OR WHITESPACES
	$name = preg_replace("/[\s_]/", "-", $name);				// CONVERT WHITESPACES AND UNDERSCORE TO DASH

	$newFileName = $name.'-'.uniqid().'.'.$ext;
	return $newFileName;
}

function createThumbnail($sourceFile, $prefix, $_width, $_height, $mode, $copyTo = null, $newFileName){

		$image_mime = image_type_to_mime_type(exif_imagetype($sourceFile));
		if($image_mime == "image/jpeg") 	$img = imagecreatefromjpeg($sourceFile);
		if($image_mime == "image/png") 		$img = imagecreatefrompng($sourceFile);
		
		$width = imagesx($img);
		$height = imagesy($img);

		if($mode == "fit"){

			$tumb_w = $_width;					///////////////////////
			$aspect = $width / $height;			/////// RESIZE TO WIDTH 
			$tumb_h = $_width / $aspect;		///////////////////////

			if($tumb_h < $_height){				///////////////////////
				$tumb_h = $_height;				////// RESIZE TO HEIGHT
				$aspect = $width / $height;		///////////////////////
				$tumb_w = $_height * $aspect;	///////////////////////
			}

			$tmp_img = imagecreatetruecolor($_width, $_height);
		}

		if($mode == "toWidth"){
			
			if($width < $_width) $_width = $width;

			$tumb_w = $_width;					///////////////////////
			$aspect = $width / $height;			/////// RESIZE TO WIDTH 
			$tumb_h = $_width / $aspect;		///////////////////////
			$_height = $tumb_h;					///////////////////////

			$tmp_img = imagecreatetruecolor($tumb_w, $tumb_h);
		}

		if($mode == "scale"){

			$aspect = $width / $height;

			if ($aspect >= 1){
				$factor = $_width / $width;
				$tumb_w = $_width;
				$tumb_h = $height * $factor;
				$_height = $tumb_h;				/////// DA NE CENTRIRA
			} else {
				$factor = $_height / $height;
				$tumb_h = $_height;
				$tumb_w = $width * $factor;
				$_width = $tumb_w;				/////// DA NE CENTRIRA
			}

		 	$tmp_img = imagecreatetruecolor($tumb_w, $tumb_h);
		}

		if($mode == "original"){
			$tumb_w = $width;
			$tumb_h = $height;
			$_height = $height;
			$_width = $width;
			$tmp_img = imagecreatetruecolor($width, $height);
		}

		imagecolortransparent($tmp_img, $background);

	    // turning off alpha blending (to ensure alpha channel information 
	    // is preserved, rather than removed (blending with the rest of the 
	    // image in the form of black))
	    imagealphablending($tmp_img, false);

	    // turning on alpha channel information saving (to ensure the full range 
	    // of transparency is preserved)
	    imagesavealpha($tmp_img, true);

		imagecopyresampled($tmp_img,$img, ($_width - $tumb_w) / 2 ,($_height - $tumb_h) / 2 ,0,0,$tumb_w,$tumb_h,$width,$height);

		if($image_mime == "image/jpeg") 	imagejpeg($tmp_img, $copyTo."/".$prefix.$newFileName, 90);
		if($image_mime == "image/png") 		imagepng($tmp_img, $copyTo."/".$prefix.$newFileName);

}


?>