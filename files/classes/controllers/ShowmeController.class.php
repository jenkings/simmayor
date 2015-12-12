<?php
class ShowmeController implements Controller{
	private $session;
	private $get;
	private $post;
	
	public function ShowmeController($get,$post,$session){
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
		
		$obsah = "";		
		// ************* VYHODNOCENÍ DOTAZŮ  ****************//
		$obsah.= $player->PrepniOstrov();
		$obsah.= $player->VymazOstrov();
		$player->KupOstrov();
		$player->setKongresman();
		@Obchod::giveToShop($db,$player);
		//*****************************//
		// ************* FORMULÁŘE A VÝPISY  ****************//
		$obsah.= "<div id='usershow'>";
		$obsah.= "<table width='100%'>";
		$obsah.= "<tr><td>".$player->getAvatar()."</td><td>".$player->getName()."</td></tr>";
		$obsah.= "<tr><td rowspan='2'>".$player->KoupeOstrova()."<br>".@Obchod::sellForm($player->getComodities())."<br>".$player->KongresForm()."</td><td>".$player->statsTable()."</td></tr>";
		$obsah.= "<tr><td>".$player->VolbaOstrova()."</td></tr>";
		$obsah.= "</table>";
		$obsah.= "</div>";
		//*****************************//
		
		$tpl->setContent("content",$obsah);
		
		return $tpl->__toString();
		
	}	
}
?>
