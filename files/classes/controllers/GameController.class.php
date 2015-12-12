<?php
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
