<?php
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
	
	function processRequests($player,$array){
		
		
		if(isset($array['polozka']) && !empty($array['polozka'])){
			$usermoney = $player->getVar("penize");
			$polozkadata = $this->db->queryOne("SELECT * FROM prodejna WHERE id=?",array(intval($array['polozka'])));
			if($usermoney < $polozkadata['cena']){
				return "<div id='error'>Nemáte dostatek peněz</div>";
			}
			else{		
				$predmet = $polozkadata['predmet'];
				try{
				$this->db->query("UPDATE accounts SET ".$predmet." = ".$predmet." + ".intval($polozkadata['pocet']).",penize = '".($usermoney -= $polozkadata['cena'])."' WHERE id=".intval($_SESSION['prihlasen']));}catch(Exception $e) {echo $e->getMessage();}

				$this->db->query("UPDATE accounts SET penize = penize + ? WHERE id=?",array(intval($polozkadata['cena']),intval($polozkadata['idprodavajiciho'])));

				$this->db->query("DELETE FROM prodejna WHERE id=?",array($polozkadata['id']));

			}
		}
		
		if(isset($array['smenit']) && !empty($array['smenit'])){
			if($player->getVar('ropa') >= 200000)
			{
				$this->db->query("UPDATE accounts SET ropa=ropa-200000,rubin=rubin+1 WHERE id=?",array($player->getVar("id")));
				return "<div id='succes'>Směnil jsi jeden rubín</div>";
			}else{
				return "<div id='error'>Nedostatek ropy</div>";
			}
		}
	}

	
	
	
}
