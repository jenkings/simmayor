<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>	
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="../style.css">
<title>SimMayor</title>
</head>

<body>


<header>
	<img src="../logo.png" alt="logo">	
	<?php include "menu.php";?>
</header>

<div id="page">

	
	<div id="content">
		
		<div id="forum">
			<ul id="forum_kategorie">
				<li><a href="./forum.php?section=0"><h3>Návody/dotazy</h3></a></li>
				<li><a href="./forum.php?section=1"><h3>Videa a obrázky</h3></a></li>
				<li><a href="./forum.php?section=2"><h3>Volná diskuse</h3></a></li>
			</ul>
		</div>



	</div>

</div>
<footer>Copyright Jan "Jenkings" Škoda | Code by <a href="http://jenkings.eu">Jenkings</a> | Design by <a href="#">Ex_0</footer>
<?php include "../analytics.php";?>
</body>
</html>

