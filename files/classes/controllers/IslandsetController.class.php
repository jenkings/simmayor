<?php
require_once "./classes/controllers/Controller.class.php";
class IslandsetController implements Controller{
	private $session;
	private $get;
	private $post;
	
	public function IslandsetController($get,$post,$session){
		$this->session = $session;
		$this->get = $get;
		$this->post = $post;
	}
	
	public function __toString(){
		require_once "./classes/layout/Template.class.php";
		require_once "./classes/Menu.class.php";
		require_once "./classes/Database.class.php";
		require_once "./classes/Player.class.php";
		require_once "./cfg/host.php";
		require_once "./cfg/game-limits.php";
		require_once "./classes/LoginChecker.class.php";
		require_once "./classes/IslandSettings.class.php";
		LoginChecker::check($this->session);
				
		$tpl = new Template();

		$menu = new Menu();
		$tpl->setContent("menu",$menu);
		// konec default parametrů
		
		$db = new Database(DB_HOST,DB_USER,DB_PASS,DB_NAME);
		$player = new Player($db,array("*",$this->session['prihlasen']));
		
		$obsah = "";		
		//*****************************//
		if(!empty($this->post['idostrova']) && !empty($this->post['dane'])){
			IslandSettings::setTax($db,intval($this->post['idostrova']),intval($this->session['prihlasen']),intval($this->post['dane']));
		}
		
		$hracovyOstrovy = $player->getPlayerIslands();
		foreach ($hracovyOstrovy as $ostrov){
			$vypisOstrova = "";
			
			$formularDani = new Template("dane_form");
			$dane = $db->queryOne("SELECT dane FROM islands WHERE id = ?",array($ostrov));
			$formularDani->setContent("aktualniDane",$dane['dane']);
			$formularDani->setContent("idOstrova",$ostrov);
			$formularDani->setContent("minsazba",MIN_TAXES);
			$formularDani->setContent("maxsazba",MAX_TAXES);
			
			$IslSet = new IslandSettings($db,intval($ostrov),intval($this->session['prihlasen']));
		
			$vypisOstrova .= "<div class='islandreview'>";
			$vypisOstrova .= "<h3>Ostrov ID: ".$ostrov."</h3>";
			$vypisOstrova .= $formularDani;
			$vypisOstrova .= $IslSet->getCheckout();
			$vypisOstrova .= "</div>";
			/*  */
			$obsah .= $vypisOstrova;
		}
		
		//*****************************//
		
		$tpl->setContent("content",$obsah);
		
		return $tpl->__toString();
		
	}	
}
?>
