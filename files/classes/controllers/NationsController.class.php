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
		
		
		
		$nl = new NationsList($db);
		$polozky = $nl->listOrderedBy(SortTypes::BY_NAME);
		$te = new Template("nation_item_in_list");
	
		$obsah .= "<ul>";
		foreach($polozky as $polozka){
			$te->setContent("nazev",$polozka['nazev']);
			$te->setContent("majitel",$polozka['majitel']);
			$te->setContent("penize",$polozka['penize']);
			$obsah .= $te;
		}
		$obsah .= "</ul>";
		
		//*****************************//
		$tpl->setContent("content",$obsah);
		return $tpl->__toString();
		
	}	
}
?>
