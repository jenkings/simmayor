<?php
class Register{
	private $db;
	
	public function Register($db){
		$this->db = $db;
	}
	
	public function isAvailableName($nick){
		$x = $this->db->queryAll("SELECT COUNT(*) FROM accounts WHERE jmeno = ?",array($nick));
		if($x == false)
			return true;
		else
			return false;
		
	}
}

?>
