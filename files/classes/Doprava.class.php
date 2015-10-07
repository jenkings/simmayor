<?php
class Doprava{
	private $seznam;
	private $db;
	private $pocetslotu = 0;
	private $iduzivatele;

	function  __construct($spojeni,$userid){
		$this->db=$spojeni;
		$this->iduzivatele = $userid;
		$query = $this->db->queryOne("SELECT garaz FROM accounts WHERE id=?",array($userid));
		$this->pocetslotu = $query['garaz'];
	}
	
	function prehled(){
		if($this->pocetslotu == 0)
			return "<div id='error'>Nemáte žádnou garáž</div><a>Koupit slot pro auto</a>";
	}
}
?>
