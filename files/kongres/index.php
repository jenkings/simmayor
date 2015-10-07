<?php session_start();?>
<!DOCTYPE html>
<html>
	<head>	
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>
			Beta-SimMayor
		</title>
		<?php
		include "../connect.php";
		?>
		<script><?php include "getdata.php"?></script>
	</head>
	<body>
		<div id="content">
			
			<header>
				<div id="back">
					<a href="../showme.php"><span>zpět</span></a>
				</div>
			</header>
			<?php
			
			$y = mysql_fetch_assoc(mysql_query("SELECT kongresmando FROM accounts WHERE id='".intval($_SESSION['prihlasen'])."'"));
			$cas = $y['kongresmando'];
			$comparedate=date("Y-m-d H:i:s",strtotime($cas));
			if(!isset($_SESSION['prihlasen']) || date("Y-m-d H:i:s") > $comparedate)
			{
					header('Location: ../index.php');
					exit;
			}
			////////////////////////////////////////////////////////////
			if(isset($_POST['uroky']) && isset($_POST['danebohatych']) && isset($_POST['prispevekchudym']))
			{
				$dates = Array();
				$hodnoty = Array();
				$query = mysql_query("SELECT * FROM sazby") or die(mysql_error());
					
				while($z = mysql_fetch_assoc($query))
				{	
					$dates[$z['nazev']] = $z['changed'];
					$hodnoty[$z['nazev']] = $z['hodnota'];
				}
				
				
				$chyby = "";
				
				if($_POST['uroky'] != $hodnoty['uroky'])
				{
					$pujdezmenit=date("Y-m-d H:i:s",strtotime($dates['uroky']." + 12 hours"));
					if(date("Y-m-d H:i:s") > $pujdezmenit)
					{
							if($_POST['uroky'] >= 1 && $_POST['uroky'] <= 10)
							{
									mysql_query("UPDATE sazby SET hodnota = ".intval($_POST['uroky'])." WHERE nazev LIKE 'uroky'")or die(mysql_error());
							}
					}else{
						$chyby .= "Hodnota úroků jde změnit až ".$pujdezmenit. "<br>";
					}
				}
				
				
				if($_POST['danebohatych'] != $hodnoty['danebohatych'])
				{
					$pujdezmenit=date("Y-m-d H:i:s",strtotime($dates['danebohatych']." + 12 hours"));
					if(date("Y-m-d H:i:s") > $pujdezmenit)
					{
							if($_POST['danebohatych'] >= 500 && $_POST['danebohatych'] <= 6000)
							{
									mysql_query("UPDATE sazby SET hodnota = ".intval($_POST['danebohatych'])." WHERE nazev LIKE 'danebohatych'")or die(mysql_error());
							}	
					}else{
						$chyby .= "Hodnota daní pro zbohatlíky jde změnit až ".$pujdezmenit."<br>";
					}
				}
				
				
				if($_POST['prispevekchudym'] != $hodnoty['prispevekchudym'])
				{
					$pujdezmenit=date("Y-m-d H:i:s",strtotime($dates['prispevekchudym']." + 12 hours"));
					if(date("Y-m-d H:i:s") > $pujdezmenit)
					{
							if($_POST['prispevekchudym'] >= 500 && $_POST['prispevekchudym'] <= 12000)
							{
									mysql_query("UPDATE sazby SET hodnota = ".intval($_POST['prispevekchudym'])." WHERE nazev LIKE 'prispevekchudym'")or die(mysql_error());
							}	
					}else{
						$chyby .= "Hodnota příspěvků chudým jde změnit až ".$pujdezmenit."";
					}
				}
			}
			
			echo "<div id='error'>" . $chyby . "</div>";
			
			////////////////////////////////////////////////////////////
			$data = Array();
			$query = mysql_query("SELECT * FROM sazby") or die(mysql_error());	
			while($z = mysql_fetch_assoc($query))
			{	
				$data[$z['nazev']] = $z['hodnota'];
			}
			?>
			<form action="index.php" method="post">
			
				<table id="t1">
					<caption>
						Nastavení sazeb
					</caption>	
					
					<tr class="nadpis">
						<td>Název položky</td>
						<td>Hodnota položky</td>
					</tr>

					<tr>
						<td>Úroky z půjčky </td>
						<td>$ <input type="number" name="uroky" value="<?php echo $data['uroky'];?>" min="1" max='10'></td>
					</tr>
					
					<tr class="second">
						<td>Daně pro zbohatlíky </td>
						<td>$ <input type="number" name="danebohatych" value="<?php echo $data['danebohatych'];?>" min="500" max='6000'></td>
					</tr>
					
					<tr>
						<td>Příspěvek chudým </td>
						<td>$ <input type="number" name="prispevekchudym" value="<?php echo $data['prispevekchudym'];?>" min="500" max='12000'></td>
					</tr>
					<tr>
						<td></td>
						<td><input type="submit" value="Změnit"></td>
					</tr>
				</table>
			</form>
				
			
			
			<div id="graf">
				<h2>Přehled sociálních vrstev</h2>
				<canvas width="390" height="140" id="platno">
				   Váš prohlížeč nepodporuje tag canvas.
				</canvas>
				<script src="./drawgraph.js"></script>
			</div>
			
			<div id="stavrozpoctu">
				<h2>Stav rozpočtu</h2>
				<?php echo "$" . number_format($data['stavrozpoctu'], 0, ',', ' ') ?>
			</div>
			
		
		</div>
	</body>
</html>
