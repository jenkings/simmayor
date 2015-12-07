<?php
class LoginChecker{
	public static function check($session){
		if(!isset($session['prihlasen']) || $session['prihlasen'] == ""){
			header('Location: index.php?pid=register');
			exit;
		}
	}
}

?>
