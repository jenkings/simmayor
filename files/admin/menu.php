<ul id="menu">
	<li><a href="index.php">Domů</a></li>
	<li><a href="ukoly.php">Úkoly</a></li>
	
	
	<?php
		if(intval($player->getVar('admin')) >= 20)
		{
			echo "<li><a href='novyukol.php' style='color:yellow;'>Nový úkol</a></li>";
			echo "<li><a href='reklama.php' style='color:yellow;'>Reklamní systém</a></li>";
		}
	?>
	
</ul>
 
