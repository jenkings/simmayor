<?php
class ShowinfoController implements Controller{
	
	public function ShowinfoController($get,$post,$session){
	}
	
	public function __toString(){

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

