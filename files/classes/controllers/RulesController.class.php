<?php
require_once "./classes/controllers/Controller.class.php";
class RulesController implements Controller{
	
	public function RulesController($get,$post,$session){
	}
	
	public function __toString(){
		require_once "./classes/layout/Template.class.php";
		require_once "./classes/Menu.class.php";
				
		$tpl = new Template();

		$menu = new Menu();
		$tpl->setContent("menu",$menu);
		// konec default parametrů
		
		$obsah = new Template("podminky");		

		
		$tpl->setContent("content",$obsah);
		
		return $tpl->__toString();
		
	}	
}
?>
