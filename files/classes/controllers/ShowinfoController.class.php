<?php
require_once "./classes/controllers/Controller.class.php";
class ShowinfoController implements Controller{
	
	public function ShowinfoController($get,$post,$session){
	}
	
	public function __toString(){
		require_once "./classes/layout/Template.class.php";
		require_once "./classes/Menu.class.php";
				
		$tpl = new Template();

		$menu = new Menu();
		$tpl->setContent("menu",$menu);
		// konec default parametrů
		
		$obsah = new Template("tutorial");		

		
		$tpl->setContent("content",$obsah);
		
		return $tpl->__toString();
		
	}	
}
?>

