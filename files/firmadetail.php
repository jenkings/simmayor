<!DOCTYPE html>
<html>
<head>	
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="style.css">
<title>SimMayor</title>
</head>

<body>
	
	<header>
	<img src="logo.png" alt="logo">
	
	<?php include "menu.php";?>
</header>

<div id="page">

	
	<div id="content">
			<?php
			if(!isset($_SESSION['prihlasen']) || !isset($_GET['id']) || $_SESSION['prihlasen'] == "")
			{
				header('Location: index.php');
			}
			else
			{
				function __autoload($class_name) {include './classes/'.$class_name . '.class.php';}
				
				$db = new Database('localhost','root','unsupportedpassword','simmayor');
				
				$hrac = new Player($db,array("penize,akcie",$_SESSION['prihlasen']));
				
				$firmy = new Firmy($db);
				
				if(isset($_GET['cnt']))
				{
					echo $hrac->kupakcie(intval($_GET['id']),intval($_GET['cnt']));
				}
				
				echo $firmy->firmadetail(intval($_GET['id']));

			}
			?>
	</div>
	<div style="clear: left;"></div>
</div>

<footer>Copyright Jan "Jenkings" Škoda | Code by <a href="http://jenkings.eu">Jenkings</a> | Design by <a href="#">Ex_0</footer>
<?php include "analytics.php";?>
</body>
</html>
