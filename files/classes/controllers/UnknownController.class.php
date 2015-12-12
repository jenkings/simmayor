<?php
class UnknownController implements Controller{
	public function UnknownController($get,$post){}
	
	public function __toString(){

		$tpl = new Template();
		$menu = new Menu();
		$tpl->setContent("menu",$menu);
		
		$obsah = new Template("unknown_page");
		$tpl->setContent("content",$obsah);
		
		return $tpl->__toString();
		
	}	
}
?>
