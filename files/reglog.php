<?php
session_start();

include_once "./cfg/host.php";
include_once "./cfg/game-limits.php";


require "./classes/Database.class.php";
require "./classes/Login.class.php";
require "./classes/Register.class.php";


if(isset($_POST['nick']) && isset($_POST['password'])){
	$db = new Database(DB_HOST,DB_USER,DB_PASS,DB_NAME);
	$login = new Login($db);
	$res = $login->auth($_POST['nick'],$_POST['password']);
	
	echo $res;
	
		
		
}else if(isset($_POST['nick']) && $_POST['nick'] != "Jméno" && $_POST['nick'] != "" && isset($_POST['password1']) && isset($_POST['password2']) && $_POST['password1'] != "" &&  $_POST['password2'] == $_POST['password1'] && isset($_POST['password3']) && $_POST['password3'] == "heslo3")
		{
			//Captcha
			if(empty($_SESSION['6_letters_code'] ) || strcasecmp($_SESSION['6_letters_code'], $_POST['6_letters_code']) != 0)
			{  
				header('Location: ./game.php');
				exit;
			}else{
				
				$db = new Database(DB_HOST,DB_USER,DB_PASS,DB_NAME);
				$register = new Register($db);
				$volnyNick = $register->isAvailableName($_POST['nick']);
				if($volnyNick)
				{
					require "newmap.php"; //přeobjektovat
					$register->createAccount($_POST['nick'],$_POST['password1']);
					exit;
				}else{
					echo "Tento nick už je zabraný";
				}
			}
		}
?>
