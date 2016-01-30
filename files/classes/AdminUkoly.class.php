<?php
class AdminUkoly{
	private $seznam;
	private $db;

	function  __construct($spojeni)
	{
		$this->db=$spojeni;
	}

	public function Vypis() 
	{
		$this->seznam=$this->db->queryAll("SELECT ukoly.id,jmeno,zadani,status FROM ukoly JOIN accounts ON ukoly.idvykonavatele = accounts.id ORDER BY status ASC,id DESC");
		$rtrn = "";
		foreach($this->seznam as $row)
		{	
			if($row['status'] == 0)
				$rtrn.="<li class='ukol_zadan'><p>".$row['zadani']."</p><h5>".$row['jmeno']."</h5><br><div class='ukol_akce'><a href='index.php?page=ukoly&ukolid=".$row['id']."&ukolst=1'>Změnit barvu</a> | <a href='index.php?page=ukoly&ukolid=".$row['id']."&ukolsm=1'>Smazat úkol</a></div></li>";
			else if($row['status'] == 1)
				$rtrn.="<li class='ukol_resen'><p>".$row['zadani']."</p><h5>".$row['jmeno']."</h5><div class='ukol_akce'><a href='index.php?page=ukoly&ukolid=".$row['id']."&ukolst=2'>Změnit barvu</a> | <a href='index.php?page=ukoly&ukolid=".$row['id']."&ukolsm=1'>Smazat úkol</a></div></li>";
			else
				$rtrn.="<li class='ukol_vyresen'><p>".$row['zadani']."</p><h5>".$row['jmeno']."</h5><div class='ukol_akce'><a href='index.php?page=ukoly&ukolid=".$row['id']."&ukolst=0'>Změnit barvu</a> | <a href='index.php?page=ukoly&ukolid=".$row['id']."&ukolsm=1'>Smazat úkol</a></div></li>";
		}
		return "<ul id='ukoly'>$rtrn</ul>";
	}
	
	public function AddForm() 
	{
		$this->seznam=$this->db->queryAll("SELECT id,jmeno FROM accounts WHERE admin>0");
		$txt = "";
		foreach($this->seznam as $row)
		{	
				$txt.="<option value='".$row['id']."'>".$row['jmeno']."</option>";
		}
		$form = "<textarea name='sdeleni' cols='40' rows='3'></textarea>";
		$form .= "<br><select name='admin'>$txt</select>";
		$form .= "<input type='submit' value='Přidat úkol'>";
		return "<form method='post'>$form</form>";
	}
	
	public function NewUkol($obsah,$idadmina)
	{
			if($obsah != "" && $idadmina != "")
			{
					$this->db->query("INSERT INTO ukoly (idvykonavatele,zadani) VALUES (?,?)",array(intval($idadmina),$obsah));
			}
	}

	public function ResUkol($idUkolu,$status)
	{
		$vra = "";
		$idUkolu = intval($idUkolu);

		$x = $this->db->queryOne("SELECT COUNT(*) FROM ukoly WHERE id = ?",array($idUkolu));
		if($x['COUNT(*)']==1)
		{
			if($status <= 2 AND $status >= 0)
			{
				if($idUkolu != "" && $status != "")
				{
					$this->db->query("UPDATE ukoly SET status = ? WHERE id = ?;",array($status,$idUkolu));
				}
			}else{
				$vra.="<div class='chyba'>Neplatný stav úkolu</div>";
			}
		}else{
			$vra.="<div class='chyba'>Tento úkol neexistuje</div>";
		}
		return $vra;
	}

	public function SmazUkol($idUkolu,$smazat,$post)
	{
		$vra = "";

		if(isset($post['smazat_ukol'])){
			$this->db->query("DELETE FROM ukoly WHERE id = ?",array($idUkolu));
			$vra.= "<div class='uspech'>Úkol byl smazán</div>";
		}

		$idUkolu = intval($idUkolu);
		$x = $this->db->queryOne("SELECT COUNT(*) FROM ukoly WHERE id = ?",array($idUkolu));
		if($x['COUNT(*)']==1)
		{

				if($idUkolu != "" && $smazat != "")
				{
					$vra.= "<fieldset style='width:60%;margin-left:auto;margin-right:auto;text-align: center;padding-bottom: 5px'><form method='post'><b>Opravdu mažeme úkol?</b><br><input type='submit' name='smazat_ukol' value='..: Smazat úkol :..'></form></fieldset>";
				}
		}else{
			$vra.="<div class='chyba'>Tento úkol neexistuje</div>";
		}
		return $vra;
	}
}
