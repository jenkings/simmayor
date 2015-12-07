<?php
require_once "./cfg/game-limits.php";
class IslandSettings{
	private $islandData;
	private $playerID;
	private $db;
	
	public function IslandSettings($db,$islandID,$playerID){
		if(empty($playerID) || !is_int($playerID))throw new Exception("Nelze měnit nastavení ostrova, pokud uživatel není přihlášen!");
		if(!is_int($islandID))throw new Exception("ID ostrova musí být číslo!");
		$this->db = $db;
		$this->playerID = $playerID;
		$this->islandData = $this->db->queryOne("SELECT * FROM islands WHERE id=?",array($islandID));
	}
	
	public function getCheckout(){
		$row = $this->db->queryOne("SELECT * FROM bankvypisy WHERE idostrova = ?",array($this->islandData['id']));
		$out = "<table id='vypis'>";
		$prijmy = explode("|", $row['prijmy']);
		$vydaje = explode("|", $row['vydaje']);
		$balance = 0;
		if(count($prijmy) > 1){
			for($f=0;$f<count($prijmy);$f++){
				$u = explode(":", $prijmy[$f]);
				$out .= "<tr><td>".$u[0]."</td><td><span class='".($u[1] >= 0 ? "prijem" : "vydaj")."'>".$u[1]."</span></td></tr>";
				$balance += $u[1];
			}
				for($f=0;$f<count($vydaje);$f++){
				$u = explode(":", $vydaje[$f]);
				$out .= "<tr><td>".$u[0]."</td><td><span class='".($u[1] >= 0 ? "prijem" : "vydaj")."'>".$u[1]."</span></td></tr>";
				$balance += $u[1];
			}
		}
		$out .= "<tr id='".($balance < 0 ? "red" : "green")."'><td>Úhrn</td><td>".$balance."</td></tr>";
		$out .=  "</table>";
		return $out;
	}
	
	public static function setTax($db,$islandID,$playerID,$tax){
		if(!is_int($islandID)) throw new Exception("ID ostrova musí být číslo!");
		if(!is_int($playerID)) throw new Exception("id hráče musí být číslo!");
		if(!is_int($tax)) throw new Exception("Výše daně musí být číslo!");
		if($tax > MAX_TAXES || $tax < MIN_TAXES) throw new Exception("Neočekáváná hodnota daní");
		
		$res = $db->queryOne("SELECT id FROM islands WHERE id=? AND idmajitele = ?",array($islandID,$playerID));
		if($res == false) throw new Exception("Ostrov není vlastněn hráčem, který chce změnit jeho nastavení");
		$db->query("UPDATE islands SET dane=? WHERE id=?",array($tax,$islandID));
		
	}
	
}
?>
