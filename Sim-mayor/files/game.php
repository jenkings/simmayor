<!DOCTYPE html>
<html>
<head>	
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="style.css">
<title>SimMayor</title>
<script>
function sendchat(message)
{
		
	$.ajax ({
	type: "POST",
	url:"./chat.php",
	data: {message:message},
	success: function(data) {
		document.getElementById("chatlist").innerHTML = data;
	}
	});
}
function refresh()
{
		$.ajax ({
		type: "POST",
		url:"./chat.php",
		data: {refresh:"test"},
		success: function(data) {
			document.getElementById("chatlist").innerHTML = data;
	   }
	});
}
</script>

</head>

<?php
session_start();
if(!isset($_SESSION['prihlasen']) || $_SESSION['prihlasen'] == "")
{
header('Location: registrace.php');
}else{
?>
<body onunload="save();" onload="setInterval(function(){vykresli();},50);setInterval(function(){economics();},60000);">
<?php
}
?>

	<header>
	<img src="logo.png" alt="logo">
	
	<?php include "menu.php";?>
</header>

<div id="page">
	
	
	<div id="content">
		<?php 
				require "./game/index.php";	
				
				
				//function __autoload($class_name) {include './classes/'.$class_name . '.class.php';}
				$db = new Database('localhost','root','unsupportedpassword','simmayor');
				$chat= new Chat($db);	
				echo $chat->vypischat();
		?>

	</div>

	<div style="clear: left;"></div>
</div>
<footer>Copyright Jan "Jenkings" Škoda | Code by <a href="http://jenkings.eu">Jenkings</a> | Design by <a href="#">Ex_0</footer>
<?php include "analytics.php";?>
</body>
</html>