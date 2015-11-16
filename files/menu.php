<?php
if (!isset($_SESSION)) session_start();
?>
	<ul id="menu">
		<li><a href="index.php">Domů</a></li>
		<li><a href="game.php">Hra</a></li>
		<li><a href="./forum/index.php">Fórum</a></li>
		<li><a href="top.php">Top</a></li>
		
		<?php
			if(isset($_SESSION['prihlasen']))
			{
				?>
				<li><a href="obchod.php">Obchod</a></li>
				<li><a href="banka.php">Banka</a></li>
				<li><a href="islandset.php">Poplatky</a></li>
				<li><a href="showme.php">Profil</a></li>
				<li><a href="logout.php">Odhlásit</a></li>
				<?php
			}
		?>
	</ul>
