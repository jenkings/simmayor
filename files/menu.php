<?php
if (!isset($_SESSION)) session_start();
?>
	<ul id="menu">
		<li><a href="./index.php?pid=title">Domů</a></li>
		<li><a href="game.php">Hra</a></li>
		<li><a href="./index.php?pid=forum">Fórum</a></li>
		<li><a href="./index.php?pid=top">Top</a></li>
		
		<?php
			if(isset($_SESSION['prihlasen']))
			{
				?>
				<li><a href="./index.php?pid=shop">Obchod</a></li>
				<li><a href="./index.php?pid=bank">Banka</a></li>
				<li><a href="./index.php?pid=islandset">Poplatky</a></li>
				<li><a href="./index.php?pid=showme">Profil</a></li>
				<li><a href="./index.php?pid=logout">Odhlásit</a></li>
				<?php
			}
		?>
	</ul>
