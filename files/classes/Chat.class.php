<?php
class Chat{
	private $seznam;
	private $db;

	function  __construct($spojeni){
		$this->db=$spojeni;
	}
	
	public function lastmessages($pocet){
		$prispevky = $this->db->queryAll("SELECT jmeno,text FROM chat ch JOIN accounts a ON ch.iduzivatele = a.id ORDER BY ch.id DESC LIMIT ".$pocet);
		$vystup = "";
		foreach($prispevky as $radek)
			$vystup .= "<li><span id='nick'>".$radek['jmeno'].":</span> ".$radek['text']."</li>";
		return $vystup;
	}
	
	public function vypischat(){
		$chat = "<div id='chat'><ul id='chatlist'>";
		$chat .= $this->lastmessages(6);
		$chat .= "</ul></div>";
		$chat .= "<form id='chatform'><input id='chattext' type='text' placeholder='Váš text'><input type='button' value='Odeslat' onclick='sendchat(document.getElementById(\"chattext\").value);document.getElementById(\"chattext\").value=\"\"'><input type='button' value='Obnovit' onclick='refresh()'></form>";
		return $chat;
	}
	
	public function sendmessage($zprava,$id){
		$this->db->query("INSERT INTO chat (iduzivatele,text) VALUES (?,?)",array($id,$zprava));
	}
}
