<div id="menu">
<ul>
	<li><h2>Administrace:</h2></li>
	<li><a href="index.php">Domů</a></li>
	<li><a href="ukoly.php">Úkoly</a></li>
	<hr>
	<li><a href="">Uživatelé</a></li>
	<li><a href="">Firmy</a></li>
	<li><a href="">Ostrovy</a></li>
	<hr>
	
	
	<?php
		if(intval($player->getVar('admin')) >= 20)
		{
			echo "<li><a href='novyukol.php' style='color:yellow;'>Nový úkol</a></li>";
			echo "<li><a href='reklama.php' style='color:yellow;'>Reklamní systém</a></li>";
		}
	?>
	<li><a href="../game.php">...Návrat do hry...</a></li>
</ul>
</div>
 
