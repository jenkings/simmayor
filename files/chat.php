<?php
session_start();

include_once "./cfg/host.php";
$db = new Database(DB_HOST,DB_USER,DB_PASS,DB_NAME);
function __autoload($class_name) {include './classes/'.$class_name . '.class.php';}

if($_SERVER['HTTP_REFERER'] != WEB_ROOT . "/game.php")
{
	exit;
}
if(isset($_SESSION['prihlasen']) || $_SESSION['prihlasen'] == "")
{
	if(isset($_POST['message'])){
		$chat = new Chat($db);	
		$chat->sendmessage($_POST['message'],intval($_SESSION['prihlasen']));
		$bot = new Chatbot($db);
		$bot -> odpovez($_POST['message']);
		echo $chat->lastmessages(8);
	}
	
	if(isset($_POST['refresh'])){	
		$chat= new Chat($db);	
		echo $chat->lastmessages(8);
	}
}
?>
