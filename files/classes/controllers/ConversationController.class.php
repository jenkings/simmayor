<?php
class ConversationController implements Controller{
	private $session;
	private $get;
	private $post;
	
	public function ConversationController($get,$post,$session){
		$this->session = $session;
		$this->get = $get;
		$this->post = $post;
	}
	
	public function __toString(){

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
		if(empty($this->get['id'])){
			$tpl->setContent("content","<div id='error'>Konversace neexistuje</div>");
			
			return $tpl->__toString();
		}
		
		//formulář na odepsání
		$convForm = new Template("conversation_form");
		$res = $db->queryOne("SELECT jmeno FROM accounts WHERE id=?",array($this->get['id']));
		$convForm->setContent("jmenoprijemce",$res['jmeno']);
		$obsah .= $convForm;
		
		//vyhodnocení formu
		if(!empty($this->post['prijemce']) && !empty($this->post['text'])){
			try{
				$obsah .= $msg->writeMessage($this->post['text'],$this->post['prijemce']);
			}catch(Exception $e){
				$obsah .= "<div id='error'>".$e->getMessage()."</div>";
			}
		}
		
		//zobrazení konverzace s daným uživatelem
		try{
			$zpravy = $msg->getAllMessages($this->get['id']);
			$obsah .= "<ul id='konverzace'>";
			$t = new Template("message_list_item");
			foreach($zpravy as $zprava){
				$t->setContent("odesilatel",$zprava['jmeno']);
				$t->setContent("datum",$zprava['datum']);
				$t->setContent("text",$zprava['text']);
				
				if($zprava['od'] == $player->getVar('id'))
					$t->setContent("class",'fromme');
				else
					$t->setContent("class",'tome');
				
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
