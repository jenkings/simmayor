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
			if(!isset($_SESSION['prihlasen']) || $_SESSION['prihlasen'] == "")
			{
				header('Location: index.php');
			}
			else
			{
				function __autoload($class_name) {include './classes/'.$class_name . '.class.php';}
				
				include_once "./cfg/host.php";
				$db = new Database(DB_HOST,DB_USER,DB_PASS,DB_NAME);
				$hrac = new Player($db,array("penize",$_SESSION['prihlasen']));
				$firmy = new Firmy($db);
				
				
				echo $firmy->kupfirmu($_SESSION['prihlasen'],$hrac->getVar("penize"));
				
				echo $firmy->vypis();
			}
			?>
	</div>
	<div style="clear: left;"></div>
</div>

<footer>Copyright Jan "Jenkings" Škoda | Code by <a href="http://jenkings.eu">Jenkings</a> | Design by <a href="#">Ex_0</footer>
<?php include "analytics.php";?>
</body>
</html>
