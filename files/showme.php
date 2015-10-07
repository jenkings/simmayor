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
			}else{
				function __autoload($class_name) {include './classes/'.$class_name . '.class.php';}	
				$db = new Database('localhost','root','unsupportedpassword','simmayor');
				$player = new Player($db,array("*",$_SESSION['prihlasen']));

				// ************* VYHODNOCENÍ DOTAZŮ  ****************//
				echo $player->PrepniOstrov();
				echo $player->VymazOstrov();
				$player->KupOstrov();
				$player->setKongresman();
				@Obchod::giveToShop($db,$player);
				//*****************************//
				
				// ************* FORMULÁŘE A VÝPISY  ****************//
				echo "<div id='usershow'>";
				echo $player->getAvatar();	
				echo $player->getName();	
				echo $player->statsTable();
				echo $player->VolbaOstrova();
				echo $player->KoupeOstrova();
				echo @Obchod::sellForm($player->getComodities());
				echo $player->KongresForm();
				echo "</div>";
				//*****************************//
			}
			?>
			
			



	<div style="clear: left;"></div>
</div>
</div>
<footer>Copyright Jan "Jenkings" Škoda | Code by <a href="http://jenkings.eu">Jenkings</a> | Design by <a href="#">Ex_0</footer>
<?php include "analytics.php";?>
</body>
</html>

