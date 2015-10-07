<?php
function __autoload($class_name) {include './classes/'.$class_name . '.class.php';}	
$db = new Database('localhost','root','unsupportedpassword','simmayor');
			
$loterie = new Loterie($db);
$loterie->novytah();
$loterie->vyhodnotLosy();
$loterie->DeleteTickets();
?>
