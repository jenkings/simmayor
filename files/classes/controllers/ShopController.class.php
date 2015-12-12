<?php
class ShopController implements Controller{
	private $session;
	private $get;
	private $post;
	
	public function ShopController($get,$post,$session){
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
		$player = new Player($db,array("id,penize,dluh,ropa",$this->session['prihlasen']));
		
		$obsah = "";		
		//************************************************************//
		$obchod = new ObchodPrehled($db);
		$obsah .= $obchod->processRequests($player,$this->post);
		$obsah .= new Template("oil_to_ruby");
		$obsah .= $obchod->printOffers();
		//************************************************************//
		$tpl->setContent("content",$obsah);
		
		return $tpl->__toString();
		
	}	
}
?>
