<!DOCTYPE html>
<html>
<head>	
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="style.css">
<title>Sim Mayor administrace</title>
</head>
<body>
	
<?php
session_start();
function __autoload($class_name) {include '../classes/'.$class_name . '.class.php';}	
if(!isset($_SESSION['prihlasen']) || $_SESSION['prihlasen'] == "")
{
	header('Location: ../index.php');
}

include_once "../cfg/host.php";
$db = new Database(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$player = new Player($db,array("admin,jmeno",$_SESSION['prihlasen']));

if(intval($player->getVar('admin')) < 1)
{
	header('Location: ../index.php');
}
?>
<div id="page">
	<?php
include "menu.php";
?>

<div id="text">
	<h4> Zadejte úkol:</h4>
	<?php
	$ukoly = new Ukoly($db);
	
	if(isset($_GET['sdeleni']) && isset ($_GET['admin']))
		$ukoly->NewUkol($_GET['sdeleni'],$_GET['admin']);
	
	echo $ukoly->AddForm();
	?>
	
</div>
	<hr class="cleaner">
	<div id="footer">
		Administrace hry - SimMayor.cz - 2015 / 2016
	</div>
</div>
	</div>

	

</body>
</html>
