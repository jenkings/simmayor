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

<body onload="newtip();">
	
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
				include "connect.php";
				

					$row = mysql_fetch_assoc(mysql_query("SELECT * FROM accounts WHERE id = '" . $_SESSION['prihlasen'] . "'"));
									
					echo "<div id='prehled'>";				
						
					echo "<h2>Zůstatek: $ " . number_format($row['penize'], 2, ',', ' ') . "</h2>";
					
					echo "<h3>Dluh: $ " . number_format($row['dluh'], 2, ',', ' ') . "</h3>";
					
					echo  "</div>";
					?>
					
				<div class='bankbox'>
								
					<H3>
						Dluhy			
					</H3>			
									
					<form action="banktrans.php" method="post">
						
						Operace:
						<select name="operace">							
							<option value="vrat" selected="selected">Vrátit</option>
							<option value="pujc">Půjčit</option>
						</select>
						
						Částka:
						<select name="castka">
							<option value="5000"  selected="selected">5 000</option>
							<option value="10000">10 000</option>
							<option value="20000">20 000</option>
							<option value="50000">50 000</option>
							<option value="100000">100 000</option>
						</select>
						
						<input type="submit" value="Proveď">
						
					</form>
				</div>
				
				<?php
				include "poradce.php";
			}
		?>
	</div>

</div>

<footer>Copyright Jan "Jenkings" Škoda | Code by <a href="http://jenkings.eu">Jenkings</a> | Design by <a href="#">Ex_0</footer>
<?php include "analytics.php";?>
</body>
</html>
