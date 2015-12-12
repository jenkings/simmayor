<?php
class TitleController implements Controller{
	public function TitleController($get,$post){}
	
	public function __toString(){

		$tpl = new Template();
		$db = new Database(DB_HOST,DB_USER,DB_PASS,DB_NAME);
		
		$reklamy = new Reklama($db);
		$obsah = new Template("title_page");
		$obsah->setContent("bannery",$reklamy->Bannery());
		
		$menu = new Menu();
		$tpl->setContent("menu",$menu);
		$tpl->setContent("content",$obsah);
		
		return $tpl->__toString();
	}	
}
?>
