<?php
require_once "./cfg/game-limits.php";
class Bank{
	private $player;
	private $db;
	
	public function Bank($db,$player){
		$this->player = $player;
		$this->db = $db;
	}
	
	public function summary(){
		$out = "<div id='prehled'>";				
		$out .= "<h2>Zůstatek: $ " . number_format($this->player->getVar("penize"), 2, ',', ' ') . "</h2>";
		$out .= "<h3>Dluh: $ " . number_format($this->player->getVar("dluh"), 2, ',', ' ') . "</h3>";
		$out .=  "</div>";
		return $out;
	}
	
	public function bankBox(){
		return "
		<div class='bankbox'>		
					<h3>Dluhy</h3>					
					<form action='./index.php?pid=bank' method='post'>
						Operace:
						<select name='operace'>							
							<option value='vrat' selected='selected'>Vrátit</option>
							<option value='pujc'>Půjčit</option>
						</select>
						Částka:
						<select name='castka'>
							<option value='5000'  selected='selected'>5 000</option>
							<option value='10000'>10 000</option>
							<option value='20000'>20 000</option>
							<option value='50000'>50 000</option>
							<option value='100000'>100 000</option>
						</select>
						<input type='submit' value='Proveď'>
					</form>
				</div>
				";
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
