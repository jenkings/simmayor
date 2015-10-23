<?php
class Reklama{
	private $seznam;
	private $db;

	function  __construct($spojeni)
	{
		$this->db=$spojeni;
	}
	
	public function Pozadavky($hodnoty){
		if(isset($hodnoty['delid']))
		{
			$result = $this->db->query("DELETE FROM reklamy WHERE id = ?",array($hodnoty['delid']));
			
			if($result)
				return "Smazána položka id: " . $hodnoty['delid'];
			else
				return "Vyskytla se chyba při mazání položky";
		}
		
		if(isset($hodnoty['nazev']) && isset($hodnoty['odkaz']) && isset($hodnoty['obrazek']))
		{
			if($hodnoty['odkaz'] != "" && $hodnoty['obrazek'] != "")
			{
				$this->db->query("INSERT INTO reklamy (typ,nazev,odkaz,obrazek) VALUES (?,?,?,?)",array($hodnoty['typ'],$hodnoty['nazev'],$hodnoty['odkaz'],$hodnoty['obrazek']));
				return "přidáno";
			}
		}
	}
	
	public function Bannery(){
		$rekl = $this->db->queryAll("SELECT nazev,odkaz,obrazek FROM reklamy WHERE typ = 1 ORDER BY RAND()");
		
		$script = "
		var nazvy = new Array();
		var odkazy = new Array();
		var obrazky = new Array();
		";
		
		foreach($rekl as $r){
			$script .= "nazvy.push('".$r['nazev']."');odkazy.push('".$r['odkaz']."');obrazky.push('".$r['obrazek']."');";
		}

		
		$script .="
		function paint(){
			var x = Math.floor(Math.random()*nazvy.length);
			
			
			document.getElementById('ob').src = obrazky[x];
			document.getElementById('ob').alt = nazvy[x];
			document.getElementById('odkaz').href = odkazy[x];
		}
		paint();
		setInterval(function(){paint()},6000);
		";
		
		return "
		<a id='odkaz' href='' target='_blank'><img alt='' id='ob' src=''></a>
		<script>
			$script
		</script>
		";
	}
	
	private function typ($x){
		if($x == 1)
			return "banner";
		else if($x == 2)
			return "ikonka";
	}

	public function Prehled(){
		$ads = $this->db->queryAll("SELECT * FROM reklamy ORDER BY typ ASC");
		$navrat = "<table id='adstable'>";
		foreach($ads as $radek)
			$navrat .= "<tr><td>".$this->typ($radek['typ'])."</td><td>".$radek['nazev']."</td><td>".$radek['odkaz']."</td><td><img src='".$radek['obrazek']."'></td><td><a href='./reklama.php?delid=".$radek['id']."'>Smazat</a></td></tr>";
		$navrat .= "</table>";
		
		

		$navrat .="
		<form method='GET' action='reklama.php'>
			<input type='text' name='nazev' placeholder='Název'>
			<input type='text' name='odkaz' placeholder='Odkaz'>
			<input type='text' name='obrazek' placeholder='Obrázek(link)'>
			
			<select name='typ'>
			  <option value='1'>Banner</option>
			  <option value='2'>Ikonka</option>
			</select>
			
			<input type='submit' value='odeslat'>
		</form>
		";


		return $navrat;
	}
	
}
