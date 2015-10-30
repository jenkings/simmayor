<?php
session_start();

require "connect.php";	

if(isset($_POST['idostrova']))
{
	if($_POST['dane'] >= 1 && $_POST['dane'] <= 35)
	mysql_query("UPDATE islands SET dane='".intval($_POST['dane'])."' WHERE id='".intval($_POST['idostrova'])."'");
}
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

<div id="page">
	
	
	<div id="content">
		<?php 
			if(!isset($_SESSION['prihlasen']) || $_SESSION['prihlasen'] == "")
			{
				header('Location: index.php');
			}else{
			
				if(isset($_SESSION['aktivniostrov']))
				{
					$x = mysql_fetch_array(mysql_query("SELECT id,dane FROM islands WHERE id = '".intval($_SESSION['aktivniostrov'])."'"));
				}else{
					$x = mysql_fetch_array(mysql_query("SELECT id,dane FROM islands WHERE idmajitele = '".$_SESSION['prihlasen']."' ORDER BY id ASC LIMIT 1"));
				}
			
			
			?>	
				
			
				
				<form action="islandset.php" method="post">
							Výše daně:<input type="number" name="dane" value="<?php echo intval($x['dane']) ?>" min="1" max="35"><br>
							<input type="hidden" name="idostrova" value="<?php echo $x['id'] ?>">
							<input type='submit' value='Uložit'>
				</form>
				
				
				<?php 
		if(!isset($_SESSION['prihlasen']) || $_SESSION['prihlasen'] == "")
		{
			header('Location: index.php');
		}
		
		include "connect.php";

		$row = mysql_fetch_assoc(mysql_query("SELECT * FROM bankvypisy WHERE idostrova = '" . mysql_real_escape_string($x['id']) . "'"));
		
		
		
		echo"<table id='vypis'>";
		if($row['pocatecnistav'] >= 0)
			echo"<tr id='green'><td>Počáteční stav</td><td>".$row['pocatecnistav']."</td></tr>";
		else
			echo"<tr id='red'><td>Počáteční stav</td><td>".$row['pocatecnistav']."</td></tr>";
		
		
		$prijmy = explode("|", $row['prijmy']);
		$vydaje = explode("|", $row['vydaje']);
		
		
		for($f=0;$f<count($prijmy);$f++)
		{
			$u = explode(":", $prijmy[$f]);
			echo"<tr><td>".$u[0]."</td><td><span class='prijem'>".$u[1]."</span></td></tr>";
		}
			
		for($f=0;$f<count($vydaje);$f++)
		{
			$u = explode(":", $vydaje[$f]);
			echo"<tr><td>".$u[0]."</td><td><span class='vydaj'>".$u[1]."</span></td></tr>";
		}

		if($row['shrnuti'] >= 0)
			echo"<tr id='green'><td>Zůstatek</td><td>".$row['shrnuti']."</td></tr>";
		else
			echo"<tr id='red'><td>Zůstatek</td><td>".$row['shrnuti']."</td></tr>";
		
		
		echo "</table>";
		
		
		
		?>
					
			<?php
			}
		?>

	</div>

</div>
<footer>Copyright Jan "Jenkings" Škoda | Code by <a href="http://jenkings.eu">Jenkings</a> | Design by <a href="#">Ex_0</footer>
<?php include "analytics.php";?>
</body>
</html>
