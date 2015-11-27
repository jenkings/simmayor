<?php
require_once "./classes/layout/Template.class.php";
require_once "./classes/Goods.class.php";
class ObchodPrehled{
	private $db;

	function  __construct($spojeni){
		$this->db=$spojeni;
	}
	
	
	function printOffers(){
		$out = "";
		
		$out .= "<table id='shop'>";
				
		$q = $this->db->queryAll("SELECT * FROM prodejna ORDER BY id DESC");
		
		$tpl = new Template("shop_piece");
		foreach($q as $zaznam){
			$tpl->setContent("cena",number_format($zaznam['cena'], 0, ',', ' '));
			$tpl->setContent("nazevpredmetu",$zaznam['predmet']);
			$tpl->setContent("pocet_kusu",$zaznam['pocet']);
			$tpl->setContent("jednotky",Goods::getUnit($zaznam['predmet']));
			$tpl->setContent("id_polozky",$zaznam['id']);
			$out .= $tpl;
		}
		
		$out .="</table>";
		return $out;
	}

	
	
	
}
