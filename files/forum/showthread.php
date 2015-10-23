<?php
session_start();
if(!isset($_GET['topicid']))
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
			
			$db = new Database('localhost','root','unsupportedpassword','simmayor');
			
			$forum= new Forum($db);
			echo $forum->getTopic($_GET['topicid']);
			echo $forum->PostForm($_GET['topicid'])
		?>

	</div>

</div>
<footer>Copyright Jan "Jenkings" Škoda | Code by <a href="http://jenkings.eu">Jenkings</a> | Design by <a href="#">Ex_0</footer>
<?php include "../analytics.php";?>
</body>
</html>

