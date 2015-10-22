<?php
class Player{
	private $udaje;
	private $db;
	private $tosel;

	function  __construct($spojeni,$sel=Array()){
		$this->db=$spojeni;
		$this->tosel=$sel;
		$this->udaje=$this->db->queryPlayer("SELECT ".$sel[0]." FROM accounts WHERE id = :id",$sel);
	}
	
	public function refresh(){
		$this->udaje=$this->db->queryPlayer("SELECT ".$this->tosel[0]." FROM accounts WHERE id = :id",$this->tosel);
	}

	public function getAvatar() 
	{
		return "<img src='./avatars/".$this->udaje['avatar'].".jpg'>";
	}
	
	public function getVar($x)
	{
		return $this->udaje[$x];
	}
	
	public function getComodities() 
	{
		$x['uhli'] = $this->udaje['uhli'];
		$x['ropa'] = $this->udaje['ropa'];
		$x['rubin'] = $this->udaje['rubin'];
		return $x;
	}


	public function statsTable() 
	{
		$x = "<td><h3>Peníze:</h3></td><td>$" . number_format($this->udaje['penize'], 2, ',', ' ') . "</td></tr>";
		$x .= "<tr><td><h3>Dluh:</h3></td><td>$" . number_format($this->udaje['dluh'], 2, ',', ' ') . "</td></tr>";
		$x .= "<tr><td><h3><img id='mini' src='./uhli.png' alt='uhli'></h3></td><td>" . $this->udaje['uhli'] . " tun</td></tr>";
		$x .= "<tr><td><h3><img id='mini' src='./ropa.png' alt='ropa'></h3></td><td>" . $this->udaje['ropa'] . " barelů</td></tr>";
		$x .= "<tr><td><h3><img id='mini' src='./rubin.png' alt='rubin'></h3></td><td>" . $this->udaje['rubin'] . " drahokamů</td>";		
		return "<table id='info'><tr> $x </tr></table>";
	}
	  
	public function getName() 
	{
		$cas = $this->udaje['vipdo'];
		$comparedate=date("Y-m-d H:i:s",strtotime($cas));
		if(date("Y-m-d H:i:s") < $comparedate)
		{
			return "<h2>[VIP]" . $this->udaje['jmeno'] . "</h2>";
		}
		else
		{
			return "<h2>" . $this->udaje['jmeno'] . "</h2>";
		}
	}

	public function VolbaOstrova()
	{
		$q=$this->db->queryAll("SELECT id FROM islands WHERE idmajitele=?",array($_SESSION['prihlasen']));
		foreach($q as $row){					
				$rows[]= "<tr><td>Ostrov id ".$row['id']."</td><td><form action='showme.php' method='post'><input type='hidden' name='ostrov' value='".$row['id']."'><input type='submit' value='Přepnout'></form></td><td><form action='showme.php' method='post'><input type='hidden' name='delostrov' value='".$row['id']."'><input type='submit' value='Zbourat'></form></td></tr>";
		}
		$x=implode("",$rows);	
		$vr="<table id='volbaostrova'>$x</table>";
		return $vr;
	}
	
	public function PrepniOstrov()
	{
		if(isset($_POST['ostrov']))
		{		
			$q=$this->db->queryOne("SELECT idmajitele FROM islands WHERE id= ?",array($_POST['ostrov']));					
			if($q['idmajitele'] == $_SESSION['prihlasen'])
			{
				$_SESSION['aktivniostrov'] = $_POST['ostrov'];	
				return "<div id='succes'>Aktivní ostrov úspěšně změněn</div>";	
			}else{
			return "<div id='succes'>Nastala chyba při nastavování aktivního ostrova</div>";			
			}			
		}
		
	}
	
	
	public function VymazOstrov()
	{
		if(isset($_POST['delostrov']))
		{		
			$q=$this->db->queryOne("SELECT idmajitele FROM islands WHERE id= ?",array($_POST['delostrov']));					
			if($q['idmajitele'] == $_SESSION['prihlasen'])
			{
				$time=$this->db->queryOne("SELECT vipdo FROM accounts WHERE id=?",array($_SESSION['prihlasen']));
				
				$cas = $time['vipdo'];
				$comparedate=date("Y-m-d H:i:s",strtotime($cas));
				if(date("Y-m-d H:i:s") < $comparedate)
				{
					//JE VIP
					$this->db->query("DELETE FROM islands WHERE id=?",array($_POST['delostrov']));
					$this->db->query("UPDATE accounts SET penize=penize+300000 WHERE id=?",array($_SESSION['prihlasen']));
					return "<div id='succes'>Ostrov smazán, jako VIP dostáváš zpět $300 000</div>";	
				}else
				{
					//NENI VIP
					$this->db->query("DELETE FROM islands WHERE id=?",array($_POST['delostrov']));
					return "<div id='succes'>Ostrov úspěšně vymazán</div>";	
				}
			}else{
				return "<div id='error'>Při mazání ostrova nastala chyba</div>";			
			}			
		}
		
	}
	

	public function KoupeOstrova()
	{
		$x=$this->db->queryOne("SELECT COUNT(*) FROM islands WHERE idmajitele=?",array($_SESSION['prihlasen']));						
		$cena = 0;
		switch ($x['COUNT(*)']) {
			case 1:
				$cena = 4000000;
				break;
			case 2:
				$cena = 15000000;
				break;
			case 3:
				$cena = 50000000;
				break;
		}	
		if($cena == 0)
		{
			$str = "Již vlastníte maximální počet ostrovů";
		}else
		{
			$str = "<input type='hidden' name='newostrov' value='".$cena."'>";
			$str .= "<input type='submit' value='Koupit další ostrov za $".number_format($cena, 0, ',', ' ')."'>";
		}			
		return "<form action='showme.php' method='post'><legend>Koupit nový ostrov</legend>   $str   </form>";
	}
	
	public function KongresForm()
	{
		$cas = $this->udaje['kongresmando'];
		$comparedate=date("Y-m-d H:i:s",strtotime($cas));
		if(date("Y-m-d H:i:s") < $comparedate)
		{
			return "<div id='congr'><a href='../kongres/'>Přesunout se do kongresu</a></div>";
		}else
		{
			$text = "<form action='showme.php' method='post'><input type='hidden' name='jitdokongresu' value=''>";
			$text .= "<input type='submit' value='Stát se kongresmanem'>50 <img width='30px;' src='./rubin.png' alt='rubin'><br>";
			$text .= "&nbsp &nbsp &nbsp &nbsp do" . date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s") . "+1 months")) . "</form>";
			return $text;
		}
	}
	
	public function kupakcie($idfirmy,$kupprodej)
	{
		$fir=$this->db->queryOne("SELECT pocetakcii,hodnotaakcii FROM firmy WHERE id=?",array($idfirmy));
		$hodnota = explode("|", $fir['hodnotaakcii']);
		if($fir['pocetakcii'] < 5 && $kupprodej == 1){
			return "Nejsou žádné volné akcie ke koupi";
		}
		else if($this->getVar('penize') < (5 * $hodnota[5]) && $kupprodej == 1){
			return "Nemáš dostatek financí ke koupi akcií";
		}
		else if($this->maakcie($idfirmy) == false  && $kupprodej == 0){
			return "Nemáš dostatek akcií k prodeji";
		}
		else{
			//$kupprodej   0 prodat   1 koupit
			if($kupprodej == 0){
				$this->db->query("UPDATE accounts SET akcie=?,penize=penize+? WHERE id=?",array($this->playerakcie($idfirmy,-5),5*$hodnota[5],$_SESSION['prihlasen']));
				$this->db->query("UPDATE firmy SET pocetakcii=pocetakcii+5 WHERE id=?",array($idfirmy));
				return "Prodal jsi 5 akcií";
			}
			else if($kupprodej == 1){
				$this->db->query("UPDATE accounts SET akcie=?,penize=penize-? WHERE id=?",array($this->playerakcie($idfirmy,5),5*$hodnota[5],$_SESSION['prihlasen']));
				$this->db->query("UPDATE firmy SET pocetakcii=pocetakcii-5 WHERE id=?",array($idfirmy));
				return "Koupil jsi 5 akcií";
			}
		}
	}
	
	private function maakcie($firma)
	{
		$akcie = explode("|", $this->udaje['akcie']);
		
		foreach ($akcie as $index => $hodnota){
			$udaje = explode(",", $hodnota);
			if($udaje[0] == $firma && $udaje[1] >= 5){
					return true;
			}
		}
		return false;
	}
	
	private function playerakcie($firma,$kakcie){
		$akcie = explode("|", $this->udaje['akcie']);
		$inlist = false;
		
		foreach ($akcie as $index => $hodnota){
			$udaje = explode(",", $hodnota);
			if($udaje[0] == $firma){
					$inlist = true;
					$akcie[$index] = $udaje[0] . "," . ($udaje[1] + $kakcie);
			}
		}
		
		$vrat = implode("|",$akcie);
		/*
		$vrat = "";
		foreach ($akcie as $index => $hodnota){
			$vrat .= $hodnota . "|";
		}
		*/
		if($inlist == false)
			return ($vrat . "|". $firma . ",5");
		else
			return $vrat;
	}
	
	
	
	public function setKongresman()
	{
		if(isset($_POST['jitdokongresu']))
		{
			if($this->udaje['rubin'] >= 50)
			{
					$dokdy = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s") . "+1 months"));						
					$this->db->query("UPDATE accounts SET kongresmando='".$dokdy."',rubin=rubin-50 WHERE id =?",array($_SESSION['prihlasen']));
			}
		}
	}
	

	public function KupOstrov()
	{
		if(isset($_POST['newostrov']))
		{				
			$y=$this->db->queryOne("SELECT COUNT(*) FROM islands WHERE idmajitele=?",array($_SESSION['prihlasen']));		
			$cena = 0;
			switch ($y['COUNT(*)']) {
				case 1:
					$cena = 4000000;
					break;
				case 2:
					$cena = 15000000;
					break;
				case 3:
					$cena = 50000000;
					break;
			}			
			if($this->udaje['penize'] < $cena)
			{
				return "Nemáš dostatek peněz";
			}
			else if($cena == 0)
			{
				return "Už nemůžeš mít víc ostrovů";	
			}
			else
			{
				$this->db->query("UPDATE accounts SET penize = penize-? WHERE id= ?",array(intval($cena),$_SESSION['prihlasen']));
				$this->db->query("INSERT INTO islands (idmajitele,mapa) VALUES (?,'".Map::newMap()."')",array(intval($_SESSION['prihlasen'])));
				return "";
			}
		}
	}
}