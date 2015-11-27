<?php
require_once "./classes/controllers/Controller.class.php";
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
		require_once "./cfg/host.php";
		require_once "./classes/layout/Template.class.php";
		require_once "./classes/Menu.class.php";
		require_once "./classes/Database.class.php";
		require_once "./classes/Player.class.php";
				
		$tpl = new Template();
		$menu = new Menu();
		$tpl->setContent("menu",$menu);
		// konec default parametrů
		
		$db = new Database(DB_HOST,DB_USER,DB_PASS,DB_NAME);
		$player = new Player($db,array("id,penize,dluh,ropa",$this->session['prihlasen']));
		
		$tpl->setContent("content",new Template("forum_index"));
		
		return $tpl->__toString();
		
	}	
}
?>
