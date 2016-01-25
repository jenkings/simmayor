<?php
class Top{
  private $seznam;
  private $db;

  function  __construct($spojeni){
    $this->db=$spojeni;
  }

  public function topMoney() 
  {
	$this->seznam=$this->db->queryAll("SELECT jmeno,penize,vipdo FROM accounts ORDER BY penize DESC LIMIT 8");
    $rows=array();
    foreach($this->seznam as $row){	
		$cas = $row['vipdo'];
		$comparedate=date("Y-m-d H:i:s",strtotime($cas));
		if(date("Y-m-d H:i:s") < $comparedate)
		{
			$rows[]="<tr><td style='color:yellow'>".$row['jmeno']."</td><td>$".number_format($row['penize'], 0, ',', ' ')."</td></tr>";
		}else{
			$rows[]="<tr><td>".$row['jmeno']."</td><td>$".number_format($row['penize'], 0, ',', ' ')."</td></tr>";
		}
    }
    $table=implode("\n",$rows);
    return "
	<table class='toptable'><caption>Top peníze</caption><tr class='box'><th>Jméno</th><th>Peníze</th></tr>$table</table>
	";
  }
  
  public function topOblibenost() 
  {
	$this->seznam=$this->db->queryAll("SELECT jmeno,sum(oblibenost),vipdo FROM islands JOIN accounts ON islands.idmajitele = accounts.id GROUP BY accounts.id ORDER BY sum(oblibenost) DESC LIMIT 8");
    $rows=array();
    foreach($this->seznam as $row){
		$cas = $row['vipdo'];
		$comparedate=date("Y-m-d H:i:s",strtotime($cas));
		if(date("Y-m-d H:i:s") < $comparedate)
		{
			$rows[]="<tr><td style='color:yellow'>".$row['jmeno']."</td><td>".$row['sum(oblibenost)']."</td></tr>";
		}else{
			$rows[]="<tr><td>".$row['jmeno']."</td><td>".$row['sum(oblibenost)']."</td></tr>";
		}
    }
    $table=implode("\n",$rows);
    return "
	<table class='toptable'><caption>Top oblíbenost</caption><tr><th>Jméno</th><th>Oblíbenost ostrova</th></tr>$table</table>
	";
  }
  
  public function topPopulace() 
  {
	$this->seznam=$this->db->queryAll("SELECT jmeno,sum(soucasnapopulace),vipdo FROM islands JOIN accounts ON islands.idmajitele = accounts.id GROUP BY accounts.id ORDER BY sum(soucasnapopulace) DESC LIMIT 8");
    $rows=array();
    foreach($this->seznam as $row){
      	$cas = $row['vipdo'];
		$comparedate=date("Y-m-d H:i:s",strtotime($cas));
		if(date("Y-m-d H:i:s") < $comparedate)
		{
			$rows[]="<tr><td style='color:yellow'>".$row['jmeno']."</td><td>".$row['sum(soucasnapopulace)']."</td></tr>";
		}else{
			$rows[]="<tr><td>".$row['jmeno']."</td><td>".$row['sum(soucasnapopulace)']."</td></tr>";
		}
    }
    $table=implode("\n",$rows);
    return "
	<table class='toptable'><caption>Top populace</caption><tr><th>Jméno</th><th>Populace ostrova</th></tr>$table</table>
	";
  }
  
  public function topRubiny() 
  {
	$this->seznam=$this->db->queryAll("SELECT jmeno,rubin,vipdo FROM  accounts ORDER BY rubin DESC LIMIT 8");
    $rows=array();
    foreach($this->seznam as $row){
      $cas = $row['vipdo'];
		$comparedate=date("Y-m-d H:i:s",strtotime($cas));
		if(date("Y-m-d H:i:s") < $comparedate)
		{
			$rows[]="<tr><td style='color:yellow'>".$row['jmeno']."</td><td>".$row['rubin']."</td></tr>";
		}else{
			$rows[]="<tr><td>".$row['jmeno']."</td><td>".$row['rubin']."</td></tr>";
		}
    }
    $table=implode("\n",$rows);
    return "
	<table class='toptable'><caption>Top rubíny</caption><tr><th>Jméno</th><th>Rubínů</th></tr>$table</table>
	";
  }

}
