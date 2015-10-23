<?php
	if(file_exists("./cfg/host.php")){
		include_once "./cfg/host.php";
	}else{
		include_once "../cfg/host.php";
	}
	$c_username = DB_USER;
	$c_password = DB_PASS;
	$c_host = DB_HOST;
	$c_database = DB_NAME;

	
	$connection = mysql_connect($c_host, $c_username, $c_password)
	or die ("Problém s připojením k databázi.");

	mysql_select_db($c_database)
	or die ("Problém s připojením k databázi.");
	
	mysql_query("SET CHARACTER SET utf8");
	
?>
