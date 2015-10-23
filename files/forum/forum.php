<?php
session_start();
if(!isset($_GET['section']))
{
	header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>
<head>	
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="../style.css">
<title>SimMayor</title>
</head>

<body>


<header>
	<img src="../logo.png" alt="logo">	
	<?php include "menu.php";?>
</header>

<div id="page">

	
	<div id="content">
		<?php
		function __autoload($class_name) {include '../classes/'.$class_name . '.class.php';}

		include_once "../cfg/host.php";
		$db = new Database(DB_HOST,DB_USER,DB_PASS,DB_NAME);
		$forum= new Forum($db);
		echo $forum->getThreads($_GET['section']);
		echo $forum->TopicForm($_GET['section']);
		?>
	</div>

</div>
<footer>Copyright Jan "Jenkings" Škoda | Code by <a href="http://jenkings.eu">Jenkings</a> | Design by <a href="#">Ex_0</footer>
<?php include "../analytics.php";?>
</body>
</html>
