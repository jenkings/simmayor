<?php
session_start();

include "connect.php";

if(!isset($_SESSION['prihlasen']) || $_SESSION['prihlasen'] == "")
{
	header('Location: index.php');
	exit;
}


if(isset($_POST['operace']) && isset($_POST['castka']))
{
	$row = mysql_fetch_assoc(mysql_query("SELECT penize,dluh FROM accounts WHERE id = '" . mysql_real_escape_string($_SESSION['prihlasen']) . "'"));
	
	if($_POST['castka'] <= 0)
	{
			exit;
	}
	
	
	if($_POST['operace'] == "pujc")
	{
		if(($row['dluh'] + $_POST['castka']) <= 100000)
		{
			mysql_query("UPDATE accounts SET penize='".($row['penize'] + $_POST['castka'])."',dluh='".($row['dluh'] + $_POST['castka']) ."' WHERE id = '" . mysql_real_escape_string($_SESSION['prihlasen']) . "'");
		}
	}
	
	
	else
	{
		if($_POST['castka'] < $row['penize'] && ($row['dluh'] - $_POST['castka']) >= 0)
		{
			mysql_query("UPDATE accounts SET penize='".($row['penize'] - $_POST['castka'])."',dluh='".($row['dluh'] - $_POST['castka'])."' WHERE id = '" . mysql_real_escape_string($_SESSION['prihlasen']) . "'");
		}
	}
	header('Location: banka.php');
}

?>
