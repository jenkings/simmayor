<!DOCTYPE html>
<html>
<head>	
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="style.css">
<title>Sim Mayor administrace  - NEW</title>
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

include "menu.php";
?>

<div id="data">
	
	<?php
	$administrace = new Admindata($db);
	echo $administrace->prehled();
	?>
	
</div>

	

</body>
</html>
