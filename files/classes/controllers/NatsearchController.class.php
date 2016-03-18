<?php
class NatsearchController implements Controller{
	private $session;
	private $get;
	private $post;
	
	public function NatsearchController($get,$post,$session){
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
        
            $obsah .= "<h3>Ve vývoji</h3>";
        
		//*****************************//
		$tpl->setContent("content",$obsah);
		return $tpl->__toString();
		
	}	
}
?>
