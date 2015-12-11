<?php
class Messages{
	
	private $db;
	private $player;
	
	const SYMBOL_ODESLANA = "&#8683";
	const SYMBOL_PRIJATA = "&#8680";
	
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
	
	public function getMessagesOverview(){
		$res = $this->db->queryAll("SELECT precteno,pro,text,datum,od,a.jmeno AS od_name,a2.jmeno AS pro_name FROM messages m JOIN accounts a ON m.od = a.id JOIN accounts a2 ON m.pro = a2.id WHERE m.id IN (SELECT MAX(id) FROM messages WHERE (od=? OR pro=?) GROUP BY CONCAT(GREATEST(od,pro), '-', LEAST(od,pro))) ORDER BY m.id DESC",array($this->player->getVar("id"),$this->player->getVar("id")));
		if(!$res) throw new Exception("Nemáte žádné zprávy");
		foreach($res as $key=>$zaznam){
			$res[$key]['text'] = ($res[$key]['pro'] == $this->player->getVar("id") ? self::SYMBOL_PRIJATA : self::SYMBOL_ODESLANA) ." " . $res[$key]['text'];
			$res[$key]['jmeno'] = ($res[$key]['od'] == $this->player->getVar("id") ? $res[$key]['pro_name'] : $res[$key]['od_name']);
			$res[$key]['chat_with'] = ($res[$key]['od'] == $this->player->getVar("id") ? $res[$key]['pro'] : $res[$key]['od']);
		}
		return $res;
	}
	
	
	public function getAllMessages($id){
		$res = $this->db->queryAll("SELECT precteno,pro,text,datum,jmeno FROM messages m JOIN accounts a ON m.od = a.id WHERE (od=? OR pro=?) AND (od=? OR pro=?) ORDER BY m.id DESC",array($this->player->getVar("id"),$this->player->getVar("id"),$id,$id));
		if(!$res) throw new Exception("Tato konversace neexistuje");
		$this->db->query("UPDATE messages SET precteno = 1 WHERE od=? AND pro = ?",array($id,$this->player->getVar("id")));
		return $res;
	}
	
	
	
}

?>
