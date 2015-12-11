<?php
require_once "./classes/controllers/Controller.class.php";
class MessagesController implements Controller{
	private $session;
	private $get;
	private $post;
	
	public function MessagesController($get,$post,$session){
		$this->session = $session;
		$this->get = $get;
		$this->post = $post;
	}
	
	public function __toString(){
		require_once "./classes/layout/Template.class.php";
		require_once "./classes/Menu.class.php";
		require_once "./classes/Database.class.php";
		require_once "./classes/Player.class.php";
		require_once "./classes/Messages.class.php";
		require_once "./cfg/host.php";
		require_once "./classes/LoginChecker.class.php";

		LoginChecker::check($this->session);
				
		$tpl = new Template();

		$menu = new Menu();
		$tpl->setContent("menu",$menu);
		// konec default parametrů
		
		$db = new Database(DB_HOST,DB_USER,DB_PASS,DB_NAME);
		$player = new Player($db,array("*",$this->session['prihlasen']));
		$msg = new Messages($db,$player);
		
		$obsah = "";		
		//*****************************//
		$obsah .= new Template("message_form");
		
		//Odesílací formulář zpráv
		if(!empty($this->post['prijemce']) && !empty($this->post['text'])){
			try{
				$obsah .= $msg->writeMessage($this->post['text'],$this->post['prijemce']);
			}catch(Exception $e){
				$obsah .= "<div id='error'>".$e->getMessage()."</div>";
			}
		}
		
		try{
			$zpravy = $msg->getMessagesOverview();
			$obsah .= "<ul id='seznam-prijatych-zprav'>";
			$t = new Template("conversation_list_item");
			foreach($zpravy as $zprava){
				$t->setContent("odesilatel",$zprava['jmeno']);
				$t->setContent("datum",$zprava['datum']);
				$t->setContent("text",$zprava['text']);
				$t->setContent("precteno",($zprava['precteno'] ? "precteno" : "neprecteno"));
				$t->setContent("konverzace",$zprava['chat_with']);
				$obsah .= $t;
			}
			$obsah .= "</ul>";
		}catch(Exception $e){
			$obsah .= "<div id='error'>".$e->getMessage()."</div>";
		}
		//*****************************//
		
		$tpl->setContent("content",$obsah);
		
		return $tpl->__toString();
		
	}	
}
?>
