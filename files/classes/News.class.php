<?php
class News{
	private $db;

	function  __construct($spojeni){
		$this->db=$spojeni;
	}

	public function getNews()
	{
			$udaje = $this->db->queryAll("SELECT sekce,zprava FROM news ORDER BY RAND() LIMIT 3");
			$rows=array();
			foreach($udaje as $row){	
					$rows[]= $row['sekce']."@".$row['zprava'];
			}
			$r=implode("|",$rows);
			return $r;
	}
}
