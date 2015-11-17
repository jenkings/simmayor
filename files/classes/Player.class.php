<?php
require_once "./classes/Map.class.php";
class Player{
	private $udaje;
	private $db;
	private $tosel;

	function  __construct($spojeni,$sel=Array()){
		$this->db=$spojeni;
		$this->tosel=$sel;
		$this->udaje=$this->db->queryPlayer("SELECT ".$sel[0]." FROM accounts WHERE id = :id",$sel);
	}
	
	public function isVIP(){
		$cas = $this->udaje['vipdo'];
		$comparedate=date("Y-m-d H:i:s",strtotime($cas));
		if(date("Y-m-d H:i:s") < $comparedate)
			return true;
		else
			return false;
	}
	
	public function refresh(){
		$this->udaje=$this->db->queryPlayer("SELECT ".$this->tosel[0]." FROM accounts WHERE id = :id",$this->tosel);
	}

	public function getAvatar() 
	{
		return "<img src='./avatars/".$this->udaje['avatar'].".jpg'  class='usershow-obrazek'>";
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
				$rows[]= "<tr><td>Ostrov id ".$row['id']."</td><td><form action='./index.php?pid=showme' method='post'><input type='hidden' name='ostrov' value='".$row['id']."'><input type='submit' value='Přepnout'></form></td><td><form action='./index.php?pid=showme' method='post'><input type='hidden' name='delostrov' value='".$row['id']."'><input type='submit' value='Zbourat'></form></td></tr>";
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
			$x=$this->db->queryOne("SELECT COUNT(*) FROM islands WHERE idmajitele=?",array($_SESSION['prihlasen']));
			if($x['COUNT(*)'] != MINIMUM_ISLANDS)
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
						$this->db->query("UPDATE accounts SET penize=penize+".SUM_ISLAND_PAYBACK." WHERE id=?",array($_SESSION['prihlasen']));
						return "<div id='succes'>Ostrov smazán, jako VIP dostáváš zpět $ ".number_format(SUM_ISLAND_PAYBACK, 0, ',', ' ')."</div>";
					}else
					{
						//NENI VIP
						$this->db->query("DELETE FROM islands WHERE id=?",array($_POST['delostrov']));
						return "<div id='succes'>Ostrov úspěšně vymazán</div>";
					}
				}else{
					return "<div id='error'>Při mazání ostrova nastala chyba</div>";
				}
			}else{
			return "<div id='error'>Nemůžete opustit poslední ostrov, který máš</div>";
			}
		}
		
	}
	

	public function KoupeOstrova()
	{
		$x=$this->db->queryOne("SELECT COUNT(*) FROM islands WHERE idmajitele=?",array($_SESSION['prihlasen']));
		$cena = (1 + ($x['COUNT(*)'] * ISLAND_COEFICIENT))* ISLAND_BASE_VALUE;
		if($x['COUNT(*)'] >= MAXIMUM_ISLANDS)
		{
			$str = "Již vlastníte maximální počet ostrovů";
		}else
		{
			$str = "<input type='hidden' name='newostrov' value='".$cena."'>";
			$str .= "<input type='submit' value='Koupit další ostrov za $".number_format($cena, 0, ',', ' ')."'></p>";
		}			
		return "<form action='./index.php?pid=showme' method='post'><p align='center'><legend>Koupit nový ostrov:</legend>   $str   </form>";
	}
	
	public function KongresForm()
	{
		$cas = $this->udaje['kongresmando'];
		$comparedate=date("Y-m-d H:i:s",strtotime($cas));
		if(date("Y-m-d H:i:s") < $comparedate)
		{
			return "<div id='congr' align='center'><a href='../kongres/'>Přesunout se do kongresu</a></div>";
		}else
		{
			$text = "<form action='./index.php?pid=showme' method='post'><input type='hidden' name='jitdokongresu' value=''>";
			$text .= "<p align='center'><input type='submit' value='Stát se kongresmanem'>Cena: 50 <img width='25px;' src='./rubin.png' alt='rubin' class='obrazek'><br>";
			$text .= "Do: " . date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s") . "+1 months")) . "</p></form>";
			return $text;
		}
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
			$cena = (1 + ($y['COUNT(*)'] * ISLAND_COEFICIENT))* ISLAND_BASE_VALUE;
			if($this->udaje['penize'] < $cena)
			{
				return "Nemáš dostatek peněz";
			}
			else if($x['COUNT(*)'] >= MAXIMUM_ISLANDS)
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
