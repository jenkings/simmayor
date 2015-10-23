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
		<?php require "./forum/index.php"; ?>		
	</div>

</div>
<footer>Copyright Jan "Jenkings" Škoda | Code by <a href="http://jenkings.eu">Jenkings</a> | Design by <a href="#">Ex_0</footer>
<?php include "analytics.php";?>
</body>
</html>
