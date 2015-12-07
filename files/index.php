<?php
	session_start();
	require_once "./classes/Router.class.php";

	if(!isset($_GET['pid']) || empty($_GET['pid']))
		header("Location: ./index.php?pid=title");
		
	$router = new Router($_GET['pid'],$_GET,$_POST,$_SESSION);
	echo $router;
?>

