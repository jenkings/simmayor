<?php
require_once "./classes/controllers/Controller.class.php";
class TitleController implements Controller{
	public function Controller($get,$post){}
	
	public function __toString(){
		require_once "./cfg/host.php";
		require_once "./classes/Database.class.php";
		require_once "./classes/Reklama.class.php";
		require_once "./classes/layout/Template.class.php";
		require_once "./classes/Menu.class.php";
				
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
