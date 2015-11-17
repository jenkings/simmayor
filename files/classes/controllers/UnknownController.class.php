<?php
require_once "./classes/controllers/Controller.class.php";
class UnknownController implements Controller{
	public function Controller($get,$post){}
	
	public function __toString(){
		require_once "./classes/layout/Template.class.php";
		require_once "./classes/Menu.class.php";
				
		$tpl = new Template();

		$menu = new Menu();
		$tpl->setContent("menu",$menu);
		
		$obsah = new Template("unknown_page");
		$tpl->setContent("content",$obsah);
		
		return $tpl->__toString();
		
	}	
}
?>
