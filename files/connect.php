<?php
	$c_username = "root";
	$c_password = "unsupportedpassword";
	$c_host = "localhost";
	$c_database = "simmayor";

	
	$connection = mysql_connect($c_host, $c_username, $c_password)
	or die ("Problém s připojením k databázi.");

	mysql_select_db($c_database)
	or die ("Problém s připojením k databázi.");
	
	mysql_query("SET CHARACTER SET utf8");
	
?>
