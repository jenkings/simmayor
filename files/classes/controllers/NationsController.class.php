<?php
class NationsController implements Controller{
	private $session;
	private $get;
	private $post;
	
	public function NationsController($get,$post,$session){
		$this->session = $session;
		$this->get = $get;
		$this->post = $post;
	}
	
	public function __toString(){
		LoginChecker::check($this->session);
		$tpl = new Template();
		$menu = new Menu();
		$tpl->setContent("menu",$menu);
		// konec default parametrů
		$db = new Database(DB_HOST,DB_USER,DB_PASS,DB_NAME);
		$player = new Player($db,array("*",$this->session['prihlasen']));
		$nationCreator = new NationCreator($db);
		$nation = new Nation($db,$player->getVar("innation"));
		$obsah = "";		
		//*********Zpracování požadavků*//
		if(isset($this->post['nazev']) && !empty($this->post['nazev'])){
			try{
				$nationCreator->createNewNation($player,$this->post['nazev']);
				$obsah .= "<div class='succes'>Nový stát s názvem \"".$this->post['nazev']."\" byl vytvořen</div>";
			}catch(Exception $e){
				$obsah .= "<div class='error'>" . $e->getMessage() . "</div>";
			}
		}
		//*****************************//
        $obsah .= new Template("nation_search_form");
		$obsah .= NationCreator::creationForm();
		$obsah .= $nation->overview();
		//******************Zpracování dle čeho řadit****************************//
		$nl = new NationsList($db);
		if(empty($this->get['s'])) $this->get['s'] = 0;
		$polozky = $nl->listOrderedBy(intval($this->get['s']));
		//*******************Výpis států**************************//
		$obsah .= "<h1 style='text-align:center;'>Seznam Národů</h1>";
		$obsah .= "<form class='nat-order'><input type='hidden' name='pid' value='nations'><input type='hidden' name='s' value='0'><input type='submit' value='Abecedně'></form>";
		$obsah .= "<form class='nat-order'><input type='hidden' name='pid' value='nations'><input type='hidden' name='s' value='1'><input type='submit' value='Nejbohatší'></form>";
		$obsah .= "<form class='nat-order'><input type='hidden' name='pid' value='nations'><input type='hidden' name='s' value='2'><input type='submit' value='Nejvíce členů'></form>";
		$obsah .= "<form class='nat-order'><input type='hidden' name='pid' value='nations'><input type='hidden' name='s' value='3'><input type='submit' value='Nejnižší vstupní poplatek'></form>";
		$te = new Template("nation_item_in_list");
		$obsah .= "<ul id='nations'>";
		foreach($polozky as $polozka){
			$te->setContent("nazev",$polozka['nazev']);$te->setContent("majitel",$polozka['majitel']);
			$te->setContent("penize",NumberFormat::moneyOutput($polozka['penize']));
			$te->setContent("id",$polozka['id']);
			$te->setContent("clenu",$polozka['clenu']);$obsah .= $te;
		}
		$obsah .= "</ul>";
		//*****************************//
		$tpl->setContent("content",$obsah);
		return $tpl->__toString();
	}	
}
?>
