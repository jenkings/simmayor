<?php
session_start();

if($_SERVER['HTTP_REFERER'] != "http://game.jenkings.eu/game.php")
{
	exit;
}

if(isset($_SESSION['prihlasen']) || $_SESSION['prihlasen'] == "")
{
	function __autoload($class_name) {include './classes/'.$class_name . '.class.php';}

	if(isset($_POST['message'])){
		$db = new Database('localhost','root','unsupportedpassword','simmayor');
		$chat = new Chat($db);	
		$chat->sendmessage($_POST['message'],intval($_SESSION['prihlasen']));
		$bot = new Chatbot($db);
		$bot -> odpovez($_POST['message']);
		echo $chat->lastmessages(8);
	}
	
	if(isset($_POST['refresh'])){	
		$db = new Database('localhost','root','unsupportedpassword','simmayor');
		$chat= new Chat($db);	
		echo $chat->lastmessages(8);
	}
}
?>
