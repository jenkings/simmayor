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
			
			<div id="leftpanel">
				<p>Veškeré novinky a informace o updatech naleznete v našem <a href="./forum/showthread.php?topicid=16">fóru</a></p>
				<hr>
				<p>Založte si účet a hned začněte hrát</p><button><a href="./registrace.php">Registrovat</a></button>
				<hr>
				<img src="http://img19.imageshack.us/img19/1060/48mz.jpg" alt="centrum">
				<img src="http://imageshack.us/a/img811/752/3qcz.jpg" alt="Náhled">
				<img src="http://img827.imageshack.us/img827/8894/2e13.jpg" alt="chatky">
				<img src="http://imageshack.us/a/img96/1413/mobx.jpg" alt="Přístav">
			</div>
			
			
			<div class="tip">
				<img src="./ind3.png" alt="náhled" width="220">
				<p>Můžete vyzkoušet své štěstí v loterii, a pokusit se tak vylepšit svůj rozpočet</p>
			</div>
			
			<div class="tip">
				<img src="./ind1.png" alt="náhled" width="220">
				<p>Poradce vám napoví co děláte špatně, a jak můžete zvýšit zisky svého ostrova</p>
			</div>
			
			<div class="tip">
				<img src="./ind2.png" alt="náhled" width="380">
				<p style="width:300px;">Vybudujte si ostrov přesně podle vašich představ a staňte se jeho starostou.Je jen na vás jakou strategii zvolíte, a kolik peněz si vyděláte.</p>
			</div>
			
			<?php
			function __autoload($class_name) {include './classes/'.$class_name . '.class.php';}
	
			$db = new Database('localhost','root','unsupportedpassword','simmayor');
			$reklamy = new Reklama($db);
			echo $reklamy->Bannery();

			?>
			
	<div style="clear: left;"></div>
</div>
</div>

<footer>Copyright Jan "Jenkings" Škoda | Code by <a href="http://jenkings.eu">Jenkings</a> | Design by <a href="#">Ex_0</footer>
<?php include "analytics.php";?>
</body>
</html>
