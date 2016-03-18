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
		
		$obsah = "";		
		//*****************************//
        $obsah .= new Template("nation_search_form");
		//*****************************//
		$tpl->setContent("content",$obsah);
		return $tpl->__toString();
		
	}	
}
?>
