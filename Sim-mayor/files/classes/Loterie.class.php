<?php
class Loterie{
	private $seznam;
	private $db;

	function  __construct($spojeni){
		$this->db=$spojeni;
	}
	
	public function aktivniLosyHrace($playerid){
		$info=$this->db->queryAll("SELECT datum,cisla FROM tikety WHERE idhrace=?",array($playerid));
		$x = "";
		foreach($info as $row){
				$x.="<tr><td>".$row['datum']."</td><td><div class='lotocislo'>".implode("</div><div class='lotocislo'>",$this->vratcisla($row['cisla']))."</div></td></tr>";
		}
		return "<table id='tickettable'><caption>Vaše losy</caption>$x</table>";
	}
	
	public function vyhodnotLosy()
	{
		$x=$this->db->queryOne("SELECT cisla FROM loterie ORDER BY datum DESC LIMIT 1");
		$cisla = explode("|",$x['cisla']); //pole tažených čísel
		
		$tikety=$this->db->queryAll("SELECT idhrace,cisla FROM tikety WHERE datum=?",array(date('Y-m-d', strtotime(date("Y-m-d"). ' - 0 days'))));
		
		foreach($tikety as $row){
			$pocetshod = 0;
			
			$usercisla = $this->vratcisla($row['cisla']);
			if(in_array($usercisla[0],$cisla))
				$pocetshod ++;
			if(in_array($usercisla[1],$cisla))
				$pocetshod ++;
			if(in_array($usercisla[2],$cisla))
				$pocetshod ++;
			if(in_array($usercisla[3],$cisla))
				$pocetshod ++;
			if(in_array($usercisla[4],$cisla))
				$pocetshod ++;
			if(in_array($usercisla[5],$cisla))
				$pocetshod ++;
			if(in_array($usercisla[6],$cisla))
				$pocetshod ++;
			if(in_array($usercisla[7],$cisla))
				$pocetshod ++;

			$vyhra = 5000*($pocetshod*5);
			$this->db->query("UPDATE accounts SET penize=penize+? WHERE id=?",array($vyhra,$row['idhrace']));
		}
	}
	
	
	public function novytah()
	{
			$cisla = array();
			while(count($cisla) < 8)
			{
					$x = rand(1,80);
					if(!in_array($x, $cisla))
						array_push($cisla,$x);
			}			
			$this->db->query("INSERT INTO loterie(datum,cisla) VALUES(NOW(),?)",array(implode("|",$cisla)));
			echo "vygenerovano";
	}

	public function saveticket($array,$hrac)
	{
		$array = array_values($array);
		if(count($array) == 0)
			return NULL;
		else if(count($array) < 8)
			return "<div id='error'>Málo vybraných čísel! Musíte vybrat 8 čísel</div>";
		else if(count($array) >8)
			return "<div id='error'>Vybral jste příliš mnoho čísel. Můžete zvolit jen 8</div>";
		else
		{
			foreach ($array as &$val) {
				if($val <= 0 || $val > 80)
					return "<div id='error'>Číslo musí být v intervalu 1-80</div>";
			}
			
			if($array[0] != $array[1] && $array[1] != $array[2] && $array[2] != $array[3] && $array[3] != $array[4] && $array[4] != $array[5] && $array[5] != $array[6] && $array[6] != $array[7])
			{
				$prachy = $this->db->queryOne("SELECT penize FROM accounts WHERE id=?",array($hrac));
				if($prachy['penize'] < 5000){
					return "<div id='error'>Nemáš dost peněz! Na tiket potřebuješ alespoň $5000</div>";	
				}else{
					$this->db->query("UPDATE accounts SET penize=penize-5000 WHERE id=?",array($hrac));
					$this->db->query("INSERT INTO tikety (idhrace,datum,cisla) VALUES(?,?,?)",array($hrac,date('Y-m-d', strtotime(date("Y-m-d"). ' + 1 days')),implode("|",$array)));
					return "<div id='succes'>Vsadil jste $5000 na čísla:".implode(",",$array)."</div>";
				}
			}else{
				return "<div id='error'>Nelze vsadit jedno číslo vícekrát</div>";	
			}
			
			
		}
	}
	
	function DeleteTickets(){
		$this->db->query("DELETE FROM tikety WHERE DATE_ADD(DATE(datum), INTERVAL 3 DAY) < DATE(CURDATE())");
	}
	
	
	private function vratcisla($string)
	{
		$pieces = explode("|", $string);
		$polecisel = array();
		foreach($pieces as $cislo){
				array_push($polecisel,$cislo);
		}
		sort($polecisel);
		return $polecisel;
	}
  
	public function poslednicisla() 
	{
		$this->seznam=$this->db->queryAll("SELECT datum,cisla FROM loterie ORDER BY datum DESC LIMIT 3");
		$x = "";
		foreach($this->seznam as $row){
				$x.="<tr><td>".$row['datum']."</td><td><div class='lotocislo'>".implode("</div><div class='lotocislo'>",$this->vratcisla($row['cisla']))."</div></td></tr>";
		}
		return "<table id='lototable'>$x</table>";
	}
	
	public function tiket()
	{
		$obsahformu = "";
		for($x=1;$x<=80;$x++)
		{
			$obsahformu .= "<div>$x<input type='checkbox' name='$x' value='$x'></div>";
		}
		return "
		<form action='lotto.php' method='post' id='tiketform'>
		<h2>Vyplňte tiket a vyhrajte</h2>
		$obsahformu
		<input type='submit' value='odeslat'>
		</form>
		";
	}

}
