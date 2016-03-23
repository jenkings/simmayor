<div id="menu">
<ul>
	<li><h2>Administrace:</h2></li>
	<li><a href="index.php?page=index">Domů</a></li>
	<li><a href="index.php?page=ukoly">Úkoly</a></li>
	<hr>
	<li><a href="index.php?page=uzivatele">Uživatelé</a>
		<ul style="margin-left:15px"><li><a href="index.php?page=statusy">Statusy</a></li></ul>
	</li>
	<li><a href="index.php?page=firmy">Firmy</a></li>
	<li><a href="index.php?page=ostrovy">Ostrovy</a></li>
	<hr>
	
	
	<?php
		if(intval($player->getVar('admin')) >= 20)
		{
			echo "<li><a href='index.php?page=novyukol' style='color:yellow;'>Nový úkol</a></li>";
			echo "<li><a href='index.php?page=reklama' style='color:yellow;'>Reklamní systém</a></li>";
		}
	?>
	<li><a href="../index.php?pid=showme">...Návrat do hry...</a></li>
</ul>
</div>
 
