o<?php
		
		if($_SERVER['HTTP_REFERER'] != "http://game.jenkings.eu/game.php")
		{
			exit;
		}
		
		if(isset($_POST['String']) && isset($_POST['idmesta']) && isset($_POST['prachy']))
		{
			session_start();
			include "../connect.php";
	
			$x = mysql_fetch_assoc(mysql_query("SELECT penize FROM accounts WHERE id='".$_SESSION['prihlasen']."'"));
			
			if(($_POST['prachy'] - 50000) > $x['penize'])
			{
					exit;
			}
			
			mysql_query("UPDATE islands SET mapa='".$_POST['String']."' WHERE id='".$_POST['idmesta']."'");
			mysql_query("UPDATE accounts SET penize='".intval($_POST['prachy'])."' WHERE id='".$_SESSION['prihlasen']."'");
		}
?>
