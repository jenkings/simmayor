<?php
session_start();

require "connect.php";
require "newmap.php";


if(isset($_POST['nick']) && isset($_POST['password']))
{
		$row = mysql_fetch_assoc(mysql_query("SELECT * FROM accounts WHERE jmeno = '" . mysql_real_escape_string($_POST['nick']) . "' AND heslo = '" . md5($_POST['password']) . "'"));
		if ($row) {
			$_SESSION['prihlasen'] = $row['id'];
			header('Location: game.php');
		}else{
			header('Location: index.php');
			}
		
}else if(isset($_POST['nick']) && $_POST['nick'] != "Jméno" && $_POST['nick'] != "" && isset($_POST['password1']) && isset($_POST['password2']) && $_POST['password1'] != "" &&  $_POST['password2'] == $_POST['password1'] && isset($_POST['password3']) && $_POST['password3'] == "heslo3")
		{
			
			if(empty($_SESSION['6_letters_code'] ) || strcasecmp($_SESSION['6_letters_code'], $_POST['6_letters_code']) != 0)
			{  
				header('Location: ./game.php');
				exit;
			}else
			{
				$x = mysql_result(mysql_query("SELECT COUNT(*) FROM accounts WHERE jmeno='".mysql_real_escape_string(htmlspecialchars($_POST['nick']))."'"),0);
				
				if($x == 0)
				{
					mysql_query("INSERT INTO accounts (jmeno,heslo,penize,avatar) VALUES ('".mysql_real_escape_string(htmlspecialchars($_POST['nick']))."','".md5($_POST['password1'])."','50000','".rand(1,10)."')");
					
					$row = mysql_fetch_assoc(mysql_query("SELECT * FROM accounts WHERE jmeno = '" . mysql_real_escape_string($_POST['nick']) . "' AND heslo = '" . md5($_POST['password1']) . "'"));			
					
					mysql_query("INSERT INTO islands (idmajitele,mapa) VALUES ('".$row['id']."','".newMap()."')");
					
					
					$row2 = mysql_fetch_assoc(mysql_query("SELECT id FROM islands WHERE idmajitele=".intval($row['id'])));			
					
					
					mysql_query("INSERT INTO bankvypisy (idostrova,pocatecnistav,prijmy,vydaje,shrnuti) VALUES ('".$row2['id']."','50000',' ',' ','50000')");
				
					$_SESSION['prihlasen'] = $row['id'];
					header('Location: ./showinfo.php');
					exit;
				}
				else
				{
					echo "Tento nick už je zabraný";
				}
			}
		}
?>
