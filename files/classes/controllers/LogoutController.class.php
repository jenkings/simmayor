<?php
require_once "./classes/controllers/Controller.class.php";
class LogoutController implements Controller{
	private $session;
	private $get;
	private $post;
	
	public function LogoutController($get,$post,$session){
		$this->session = $session;
		$this->get = $get;
		$this->post = $post;
	}
	
	public function __toString(){
		require_once "./classes/Database.class.php";
		require_once "./classes/Top.class.php";
		require_once "./classes/layout/Template.class.php";
		require_once "./classes/Menu.class.php";
		require_once "./cfg/host.php";
		session_destroy(); 
		$tpl = new Template();

		$menu = new Menu();
		$tpl->setContent("menu",$menu);
		// konec default parametrů
		
		$db = new Database(DB_HOST,DB_USER,DB_PASS,DB_NAME);
		$obsah = "";
		$obsah .= "<dib id='succes'>Byl jste úspěšně odhlášen</dib>";
		$tpl->setContent("content",$obsah);
		
		return $tpl->__toString();
		
	}	
}
?>

