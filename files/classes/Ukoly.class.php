<?php
class Ukoly{
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
				$rtrn.="<li style='background-color:#EF8186;border:solid red 2px;'><p>".$row['zadani']."</p><h5>".$row['jmeno']."</h5></li>";
			else if($row['status'] == 1)
				$rtrn.="<li style='background-color:#F7F98B;border:solid #F5EE00 2px;'><p>".$row['zadani']."</p><h5>".$row['jmeno']."</h5></li>";
			else
				$rtrn.="<li style='background-color:#B0EF81;border:solid green 2px;'><p>".$row['zadani']."</p><h5>".$row['jmeno']."</h5></li>";
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
}
