<?php
if (!isset($_SESSION)) session_start();
?>
	<ul id="menu">
		<li><a href="index.php?pid=title">Domů</a></li>
		<li><a href="game.php">Hra</a></li>
		<li><a href="./forum/index.php">Fórum</a></li>
		<li><a href="index.php?pid=top">Top</a></li>
		
		<?php
			if(isset($_SESSION['prihlasen']))
			{
				?>
				<li><a href="./index.php?pid=shop">Obchod</a></li>
				<li><a href="index.php?pid=bank">Banka</a></li>
				<li><a href="islandset.php">Poplatky</a></li>
				<li><a href="index.php?pid=showme">Profil</a></li>
				<li><a href="logout.php">Odhlásit</a></li>
				<?php
			}
		?>
	</ul>
