<?php
require_once "../classes/Autoloader.class.php";
require_once "../cfg/game-limits.php";
require_once "../cfg/host.php";
spl_autoload_register(array(new autoloader('../classes'), 'autoload'));
spl_autoload_register(array(new autoloader('../classes/controllers'), 'autoload'));
spl_autoload_register(array(new autoloader('../classes/layout'), 'autoload'));

		if($_SERVER['HTTP_REFERER'] != WEB_ROOT . "/index.php?pid=game"){
			exit;
		}
		
		if(isset($_POST['String']) && isset($_POST['idmesta']) && isset($_POST['prachy']))
		{
			session_start();
			$db = new Database(DB_HOST,DB_USER,DB_PASS,DB_NAME);
			$x = $db->queryOne("SELECT penize FROM accounts WHERE id=?",array($_SESSION['prihlasen']));
			
			if(($_POST['prachy'] - 50000) > $x['penize']){
					exit;
			}
			$db->query("UPDATE islands SET mapa=? WHERE id=?",array($_POST['String'],$_POST['idmesta']));
			$db->query("UPDATE accounts SET penize=? WHERE id=?",array(intval($_POST['prachy']),$_SESSION['prihlasen']));
		}
?>
