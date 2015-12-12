<?php
class ThreadController implements Controller{
	private $session;
	private $get;
	private $post;
	
	public function ThreadController($get,$post,$session){
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
		//************************************************************//
		$forum= new Forum($db);
		$obsah .= $forum->getTopic($_GET['topicid']);
		$obsah .= $forum->PostForm($_GET['topicid']);
		//************************************************************//
		$tpl->setContent("content",$obsah);
		
		return $tpl->__toString();
		
	}	
}
?>
