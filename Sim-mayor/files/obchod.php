<?php
session_start();
?>
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

<?php
function getjednotka($x)
{
		if($x == "uhli")
			return "tun";
		else if($x == "ropa")
			return "barelů";
		else if($x == "rubin")
			return "drahokamů";
}

?>

<div id="page">
	
	<div id="content">
		
		<?php 
			if(!isset($_SESSION['prihlasen']) || $_SESSION['prihlasen'] == "")
			{
				header('Location: index.php');
			}else{
				
				include "connect.php";
				
				
				if(isset($_POST['polozka']))
				{
						$usermoney = mysql_result(mysql_query("SELECT penize FROM accounts WHERE id='".intval($_SESSION['prihlasen'])."'"),0);
						$polozkadata = mysql_fetch_assoc(mysql_query("SELECT * FROM prodejna WHERE id='".intval($_POST['polozka'])."'"));
						
						if($usermoney < $polozkadata['cena'])
						{
							echo "<div id='error'>Nemáte dostatek peněz</div>";
						}
						else
						{
							mysql_query("UPDATE accounts SET ".mysql_real_escape_string($polozkadata['predmet'])." = ".mysql_real_escape_string($polozkadata['predmet'])." + ".intval($polozkadata['pocet']).",penize = '".($usermoney -= $polozkadata['cena'])."' WHERE id=".intval($_SESSION['prihlasen']))or die(mysql_error());
							mysql_query("UPDATE accounts SET penize = penize + ".intval($polozkadata['cena'])." WHERE id=".intval($polozkadata['idprodavajiciho']))or die(mysql_error());
							mysql_query("DELETE FROM prodejna WHERE id='".$polozkadata['id']."'")or die(mysql_error());
						}
				}
				
				
				if(isset($_POST['smenit']))
				{
					$info = mysql_fetch_assoc(mysql_query("SELECT ropa FROM accounts WHERE id = ".intval($_SESSION['prihlasen']).""));
					
					if($info['ropa'] >= 200000)
					{
							mysql_query("UPDATE accounts SET ropa=ropa-200000,rubin=rubin+1 WHERE id=".intval($_SESSION['prihlasen']));
					}
				}
				?>
				
				<div id="roparubin">
					200000<img id='mini' src='./ropa.png' alt='ropa'> ->
					<img id='mini' src='./rubin.png' alt='rubin'>1
				
					<form action="obchod.php" method="post">
						<input type="hidden" name="smenit" value="">
						<input type="submit" value="Směnit">
					</form>
				</div>
				
				<?php
				echo"<table id='shop'>";
				
				$q = mysql_query("SELECT * FROM prodejna ORDER BY id DESC")or die(mysql_error());
				
				$stridacka = 0;
				while($z = mysql_fetch_assoc($q))
				{	
					$stridacka ++;
					
					if($stridacka % 2 == 0)
					{
						echo "<tr class='x1'><td  class='first'><img id='mini' src='./".$z['predmet'].".png' alt='".$z['predmet']."'>".$z['pocet']." ".getjednotka($z['predmet']) ."</td>    <td  class='second'>$".number_format($z['cena'], 0, ',', ' ')."</td>     <td><form action='obchod.php' method='post'><input type='hidden' name='polozka' value='".$z['id']."'><input type='submit' value='koupit'></form></td>   </tr>";
					}
					else
					{
						echo "<tr class='x2'><td class='first'><img id='mini' src='./".$z['predmet'].".png' alt='".$z['predmet']."'>".$z['pocet']." ".getjednotka($z['predmet']) ."</td>    <td  class='second'>$".number_format($z['cena'], 0, ',', ' ')."</td>      <td><form action='obchod.php' method='post'><input type='hidden' name='polozka' value='".$z['id']."'><input type='submit' value='koupit'></form></td>    </tr>";
					}
				}
				
				echo"</table>";
			}
		?>
	</div>
</div>

<footer>Copyright Jan "Jenkings" Škoda | Code by <a href="http://jenkings.eu">Jenkings</a> | Design by <a href="#">Ex_0</footer>
<?php include "analytics.php";?>
</body>
</html>
