<?php
require_once "./classes/Mapgen.class.php";
class Register{
	private $db;
	
	public function Register($db){
		$this->db = $db;
	}
	
	public function isAvailableName($nick){
		$x = $this->db->queryAll("SELECT id FROM accounts WHERE jmeno = ?",array($nick));
		if($x == false)
			return true;
		else
			return false;
	}
	
	public function createAccount($name,$pass){
		$mapGen = new Mapgen();
		$penize = STARTING_MONEY;
		$avatar = rand(1,10); // jeden z 10 avatarů náhodně
		$this->db->query("INSERT INTO accounts (jmeno,heslo,penize,avatar) VALUES (?,md5(?),?,?)"   , array($name,$pass,$penize,$avatar));
		
		$row = $this->db->queryOne("SELECT * FROM accounts WHERE jmeno = ? AND heslo = md5(?)",array($name,$pass) );			
		
		$this->db->query("INSERT INTO islands (idmajitele,mapa) VALUES (?,?)",array($row['id'],$mapGen->createMap()));
		
		$row2 = $this->db->queryOne("SELECT id FROM islands WHERE idmajitele=?",array(intval($row['id'])));			
		
		$this->db->query("INSERT INTO bankvypisy (idostrova,pocatecnistav,prijmy,vydaje,shrnuti) VALUES (?,'50000',' ',' ','50000')",array($row2['id']));
				
		$_SESSION['prihlasen'] = $row['id'];
		
		header('Location: ./index.php?pid=showinfo');
	}
}

?>
