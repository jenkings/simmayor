<?php
class RulesController implements Controller{
	
	public function RulesController($get,$post,$session){
	}
	
	public function __toString(){
				
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
