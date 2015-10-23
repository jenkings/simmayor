<?php
include "../connect.php";
		
		if($_SERVER['HTTP_REFERER'] != WEB_ROOT . "/game.php")
		{
			exit;
		}
		
		if(isset($_POST['String']) && isset($_POST['idmesta']) && isset($_POST['prachy']))
		{
			session_start();
			
	
			$x = mysql_fetch_assoc(mysql_query("SELECT penize FROM accounts WHERE id='".$_SESSION['prihlasen']."'"));
			
			if(($_POST['prachy'] - 50000) > $x['penize'])
			{
					exit;
			}
			
			mysql_query("UPDATE islands SET mapa='".$_POST['String']."' WHERE id='".$_POST['idmesta']."'");
			mysql_query("UPDATE accounts SET penize='".intval($_POST['prachy'])."' WHERE id='".$_SESSION['prihlasen']."'");
		}
?>
