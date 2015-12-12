<?php
class ForumController implements Controller{
	private $session;
	private $get;
	private $post;
	
	public function ForumController($get,$post,$session){
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
		
		$tpl->setContent("content",new Template("forum_index"));
		
		return $tpl->__toString();
		
	}	
}
?>
