<?php
class Bank{
	private $player;
	private $db;
	
	public function Bank($db,$player){
		$this->player = $player;
		$this->db = $db;
	}
	
	public function summary(){
		$out = "<div id='prehled' class='box'>";				
		$out .= "<h3>Zůstatek: $ " . number_format($this->player->getVar("penize"), 2, ',', ' ') . "</h3>";
		$out .= "<h3>Dluh: $ " . number_format($this->player->getVar("dluh"), 2, ',', ' ') . "</h3>";
		$out .=  "</div>";
		return $out;
	}
	
	public function operations($values){
		if(isset($values['operace']) && isset($values['castka']))
		{
			if($values['castka'] <= 0){
					exit;
			}
			// půjčka
			if($values['operace'] == "pujc")
			{
				if(($this->player->getVar('dluh') + $_values['castka']) <= MAX_DLUH)
				{
					$this->db->query("UPDATE accounts SET penize=?,dluh=? WHERE id = ?",array($this->player->getVar('penize') + $values['castka'],$this->player->getVar('dluh') + $values['castka'],$this->player->getVar("id")));
					header("Refresh:0");
				}
			}
			//vracení
			else{
				if($values['castka'] < $this->player->getVar('penize') && ($this->player->getVar('dluh') - $values['castka']) >= 0){
					$this->db->query("UPDATE accounts SET penize=?,dluh=? WHERE id =?",array($this->player->getVar('penize') - $values['castka'],$this->player->getVar('dluh') - $values['castka'],$this->player->getVar("id")));
					header("Refresh:0");
				}
			}
		}
	}
		
}
?>
