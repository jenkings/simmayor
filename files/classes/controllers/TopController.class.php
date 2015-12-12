<?php
class TopController implements Controller{
	private $session;
	private $get;
	private $post;
	
	public function TopController($get,$post,$session){
		$this->session = $session;
		$this->get = $get;
		$this->post = $post;
	}
	
	public function __toString(){

		$tpl = new Template();

		$menu = new Menu();
		$tpl->setContent("menu",$menu);
		// konec default parametrů
		
		$db = new Database(DB_HOST,DB_USER,DB_PASS,DB_NAME);
		$obsah = "";
		$top= new Top($db);
		$obsah.= $top->topMoney();
		$obsah.= $top->topOblibenost();
		$obsah.= $top->topPopulace();
		$obsah.= $top->topRubiny();		

		
		$tpl->setContent("content",$obsah);
		
		return $tpl->__toString();
		
	}	
}
?>

