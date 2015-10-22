<?php
class Obchod{
	private $udaje;
	private $db;

	function  __construct($spojeni,$sel=Array()){
		$this->db=$spojeni;
		$this->udaje=$this->db->queryPlayer("SELECT ".$sel[0]." FROM accounts WHERE id = :id",$sel);
	}
	
	public function sellForm($userdata=Array())
	{
		$vrat ="";
		if($userdata['uhli'] > 0)
			$data .= "<option value='uhli'>uhlí</option>";
		if($userdata['ropa'] > 0)
			$data .= "<option value='ropa'>ropa</option>";
		if($userdata['rubin'] > 0)
			$data .= "<option value='rubin'>rubíny</option>";
		$vrat = "<form action='showme.php' method='post'><table id='sell'><tr><td>Předmět prodeje:</td><td>Počet:</td><td>Cena:</td>";
		$vrat .= "</tr><tr><td><select name='predmet'>  $data  </select></td><td><input type='number' name='pocet' min='1' max='20000'></td>";
		$vrat .= "<td><input type='number' name='cena' min='1' max='8000000'></td></tr></table><input type='submit' value='Prodat'></form>";
		return $vrat;
	}
	
	public function giveToShop($db,$hrac)
	{
		$maxprodej = $hrac->getVar("maxprodej");
		$userdata = $hrac->getComodities();
		if(isset($_POST['predmet']) && isset($_POST['pocet']) && isset($_POST['cena']))
		{
			if($_SERVER['HTTP_REFERER'] != "http://game.jenkings.eu/showme.php"){exit;}
			if($_POST['pocet'] <= 0 || $_POST['cena'] <=0 || $_POST['cena'] >8000000){exit;}	
			$x=$db->queryOne("SELECT COUNT(id) FROM prodejna WHERE idprodavajiciho = ?",array($_SESSION['prihlasen']));	
			$pocet = $x['COUNT(id)'];
			
			
			if($pocet >= $maxprodej){echo "Nemůžeš umístit na trh více než ".$maxprodej." položek zároveň";}
			
			else
			{			
				if($_POST['pocet'] <= $userdata[$_POST['predmet']])
				{
					if($_POST['predmet'] == "uhli" || $_POST['predmet'] == "ropa" || $_POST['predmet'] == "rubin")
					{
						$db->query("INSERT INTO prodejna (idprodavajiciho,predmet,pocet,cena) VALUES (?,?,?,?)",array($_SESSION['prihlasen'],$_POST['predmet'],$_POST['pocet'],$_POST['cena']));
						$db->query("UPDATE accounts SET ".$_POST['predmet']."=".$_POST['predmet']."-? WHERE id= ?",array($_POST['pocet'],$_SESSION['prihlasen']));
						$hrac->refresh();
					}
				}
				else
				{
					echo "nemáš dostatek " . $_POST['predmet'];
				}
			}
		}
	}
}