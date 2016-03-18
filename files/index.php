<?php
	session_start();
	
	require_once "./classes/Autoloader.class.php";
	require_once "./cfg/game-limits.php";
	require_once "./cfg/host.php";
	
	spl_autoload_register(array(new autoloader('./classes'), 'autoload'));
    spl_autoload_register(array(new autoloader('./classes/controllers'), 'autoload'));
    spl_autoload_register(array(new autoloader('./classes/layout'), 'autoload'));
	spl_autoload_register(array(new autoloader('./classes/nations'), 'autoload'));
	
	
	if(!isset($_GET['pid']) || empty($_GET['pid']))
		header("Location: ./index.php?pid=title");
		
	$router = new Router($_GET['pid'],$_GET,$_POST,$_SESSION);
	echo $router;
?>

