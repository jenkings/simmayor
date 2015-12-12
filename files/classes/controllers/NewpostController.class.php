<?php
class NewpostController implements Controller{
	private $session;
	private $get;
	private $post;
	
	public function NewpostController($get,$post,$session){
		$this->session = $session;
		$this->get = $get;
		$this->post = $post;
	}
	
	public function __toString(){
				
		$tpl = new Template();
		$menu = new Menu();
		$tpl->setContent("menu",$menu);
		$tpl->setContent("content","");
		// konec default parametrů
		
		$db = new Database(DB_HOST,DB_USER,DB_PASS,DB_NAME);
		$forum = new Forum($db);
		
		//Vytvoření topicu
		if(!empty($this->post['nadpis']) && !empty($this->post['obsah']) && !empty($this->post['sekce'])){
			$forum->createTopic($this->post['nadpis'],$this->post['obsah'],$this->post['sekce'],$_SESSION['prihlasen']);
			header('Location:' . $_SERVER['HTTP_REFERER']);
		}else if(!empty($this->post['text']) && !empty($this->post['idtopicu'])){
			$forum->createPost($this->post['text'],$this->post['idtopicu'],$_SESSION['prihlasen']);
			header('Location:' . $_SERVER['HTTP_REFERER']);
		}else{
			header('Location: ./index.php/pid=unknown');
		}
		return $tpl->__toString();
		
	}	
}
?>
