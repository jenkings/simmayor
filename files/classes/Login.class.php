<?php
class Login{

		private $db;
	
		public function Login($db){
			$this->db = $db;
		}
		
		public function auth($nick,$pass){
			$row = $this->db->queryOne("SELECT * FROM accounts WHERE jmeno = ? AND heslo = md5(?)",array($nick,$pass));
			if ($row) {
				$_SESSION['prihlasen'] = $row['id'];
				header('Location: game.php');
			}else{
				header('Location: index.php');
			}
		}
}
?>
