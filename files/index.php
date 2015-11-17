<?php
	require_once "./classes/Router.class.php";

	if(!isset($_GET['pid']));
		$_GET['pid'] = "title";
		
	$router = new Router($_GET['pid'],$_GET,$_POST);
	echo $router;

	/*

	include_once "./cfg/host.php";
	include_once "./classes/Database.class.php";
	include_once "./classes/Reklama.class.php";
	include_once "./classes/layout/Template.class.php";
	include_once "./classes/Menu.class.php";
			
	$tpl = new Template();
	$db = new Database(DB_HOST,DB_USER,DB_PASS,DB_NAME);
	
	$reklamy = new Reklama($db);
	$obsah = new Template("title_page");
	$obsah->setContent("bannery",$reklamy->Bannery());
	
	$menu = new Menu();
	$tpl->setContent("menu",$menu);
	
	
	$tpl->setContent("content",$obsah);
	
	echo $tpl;
	*/
?>

