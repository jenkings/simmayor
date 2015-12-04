<?php
require_once "./classes/controllers/Controller.class.php";
class GameController implements Controller{
	private $session;
	private $get;
	private $post;
	
	public function GameController($get,$post,$session){
		$this->session = $session;
		$this->get = $get;
		$this->post = $post;
	}
	
	public function __toString(){
		require_once "./classes/layout/Template.class.php";
		require_once "./classes/Menu.class.php";
		require_once "./classes/Database.class.php";
		require_once "./classes/Player.class.php";
		require_once "./classes/Obchod.class.php";
		require_once "./cfg/host.php";
		require_once "./classes/LoginChecker.class.php";
		require_once "./classes/Chat.class.php";

		LoginChecker::check($this->session);
				
		$tpl = new Template("game-page");

		$menu = new Menu();
		$tpl->setContent("menu",$menu);
		// konec default parametrů
		
		$db = new Database(DB_HOST,DB_USER,DB_PASS,DB_NAME);
		$player = new Player($db,array("*",$this->session['prihlasen']));
		
		$obsah = "";		
		// ************* VYHODNOCENÍ DOTAZŮ  ****************//
				//require "./game/index.php";	
				//include_once "./cfg/host.php";
				$db = new Database(DB_HOST,DB_USER,DB_PASS,DB_NAME);
				$chat= new Chat($db);	
				$obsah .= new Template("game-box");
				$obsah .= $chat->vypischat();
		//*****************************//
		
		$tpl->setContent("content",$obsah);
		
		return $tpl->__toString();
		
	}	
}
?>
