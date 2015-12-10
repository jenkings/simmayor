<?php
class Messages{
	
	private $db;
	private $player;
	
	public function Messages($db,$player){
		$this->db = $db;
		$this->player = $player;
	}
	
	public function writeMessage($text,$targetName){
		$res = $this->db->queryOne("SELECT id FROM accounts WHERE jmeno=?",array($targetName));
		if($res == false) throw new Exception("Uživatel neexistuje");
		if($res['id'] == $this->player->getVar("id")) throw new Exception("Nemůžete poslat zprávu sám sobě");
		$this->db->query("INSERT INTO messages (od,pro,text) VALUES (?,?,?)",array($this->player->getVar("id"),$res['id'],$text));
		return "<div id='succes'>Zpráva byla odeslána</div>";
	}
	
	
	
}

?>
