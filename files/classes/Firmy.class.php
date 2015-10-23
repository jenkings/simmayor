<?php
class Firmy{
  private $seznam;
  private $db;

  function  __construct($spojeni){
    $this->db=$spojeni;
  }

  public function vypis()
  {
	$this->seznam=$this->db->queryAll("SELECT firmy.id,firmy.nazev,firmy.cena,accounts.jmeno FROM firmy LEFT JOIN accounts ON firmy.idmajitele = accounts.id"); 
    $rows=array();
    $cnt = 0;
    foreach($this->seznam as $row){
		if($row['jmeno'] == "")
			$cntnt = "<img src='./firemniloga/".$row['id'].".jpg'> <h2><a href='./firmadetail.php?id=".$row['id']."'>".$row['nazev']."</a></h2><h3>Stát</h3><h4>$".number_format($row['cena'], 0, ',', ' ')."</h4><a href='./firmy.php?cid=".$row['id']."'>BUY!</a>";
		else
			$cntnt = "<img src='./firemniloga/".$row['id'].".jpg'> <h2><a href='./firmadetail.php?id=".$row['id']."'>".$row['nazev']."</a></h2><h3>".$row['jmeno']."</h3><h4>$".number_format($row['cena'], 0, ',', ' ')."</h4>";	
		if($cnt % 2 != 0)
		$rows[]="<li class='nj'>$cntnt</li>";
		else
		$rows[]="<li class='nd'>$cntnt</li>";
		$cnt ++;	
    }
    $firmy=implode("\n",$rows);
    return "<ul id='firmy'>$firmy</ul>";
  }
  
  public function kupfirmu($pid,$pmoney)
  {
		if(isset($_GET['cid']))
		{
			$data=$this->db->queryOne("SELECT cena,idmajitele FROM firmy WHERE id = ?",array($_GET['cid'])); 
			if($data['idmajitele'] != 0){
				return "Tuto firmu již vlastní jiný hráč";
			}
			else if($data['idmajitele'] == $pid){
				return "Tuto firmu již vlastníte";
			}
			else if($pmoney < $data['cena']){
				return "Nemáte dostatek peněz";
			}
			else{
				$this->db->query("UPDATE accounts SET penize = penize-? WHERE id= ?",array($data['cena'],$pid));
				$this->db->query("UPDATE firmy SET idmajitele = ? WHERE id= ?",array($pid,$_GET['cid']));
				return "Úspěšně jste zakoupil tuto firmu";
			}
		}
	}
	
	public function firmadetail($id)
	{
			$this->seznam=$this->db->queryOne("SELECT firmy.pocetakcii,firmy.hodnotaakcii,firmy.id,firmy.nazev,firmy.cena,accounts.jmeno FROM firmy LEFT JOIN accounts ON firmy.idmajitele = accounts.id WHERE firmy.id = ?",array($id)); 		
			$n = explode("|", $this->seznam['hodnotaakcii']);
			$vypis ="
			<div id='firmadetail'>
			<img id='flogo' src='./firemniloga/".$id.".jpg'> 
			<img id='graf' src='./graph.php?ha=".$n[0]."&hb=".$n[1]."&hc=".$n[2]."&hd=".$n[3]."&he=".$n[4]."&hf=".$n[5]."'>
			
			<ul>
			<li id='nazev'>".$this->seznam['nazev']."</li>
			<li id='hodnota'>Hodnota: $".number_format($this->seznam['cena'], 0, ',', ' ')."</li>
			<li id='papiry'>Cenné papíry: ".$this->seznam['pocetakcii']."</li>
			";		
			if($this->seznam['jmeno'] == "")
				$vypis .= "<li id='majitel'>Vlastník: Město</li>";
			else
				$vypis .= "<li id='majitel'>Vlastník: ".$this->seznam['jmeno']."</li>";
				
			$vypis .="
			<li id='papirykup'><a href='./firmadetail.php?id=$id&cnt=1'>Koupit 5 akcií za $".$n[5]."</a></li>
			<li id='papiryprodej'><a href='./firmadetail.php?id=$id&cnt=0'>Prodat 5 akcií za $".$n[5]."</a></li>
			";
			$vypis .= "</ul></div>";
			return $vypis;
	}
}
