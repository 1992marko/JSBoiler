<?php 
	error_reporting(1);
	session_start();
	require_once ("Config.php"); 
	require_once ("./page/classes/Class.Navigacija.php"); 

	//For SEO
	$navigacija = new Navigacija();
	$navigacija->setupURL();
	$template = $navigacija->getSelectedLinkTemplate();
	
?>
<!DOCTYPE html>
<html lang="<?=$_SESSION["lang"]?>">
<head>
	
	<title>Template</title>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta name="author" content="borming.hr">
	<meta http-equiv="Cache-control" content="NO-CACHE">

	<meta name="description" content="">
	<meta name="keywords" content="">

	<meta property="og:title" content="<?=$_GET['object']?$_GET['object']->Naziv:($_GET['page']->SEO_title?$_GET['page']->SEO_title:$_GET['page']->name)?>" >
	<meta property="og:description" content="<?=$_GET["object"]?$_GET["object"]->Heading:($_GET["page"]->SEO_metaDescription?$_GET["page"]->SEO_metaDescription:$_GET["page"]->heading)?>" >
	<meta property="og:image" content="http://<?=$_SERVER["HTTP_HOST"]?>/<?=$_GET["object"]?$_GET["object"]->MediaFilePath.'medium_'.$_GET["object"]->Image:$_GET["page"]->MediaFilePath.'medium_'.$_GET["page"]->FileName?>" >
	
	<link rel="icon" type="image/png" href="/assets/favicon.png" />

</head>
<body>
	<?php include_once("./assets/icons.svg"); ?>
	<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400|Roboto:600,400,300,100&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="/css/main.all.css">
	
	<script src="/libs.min.js"></script>
 	<script src="/app.js"></script>
</body>
</html>