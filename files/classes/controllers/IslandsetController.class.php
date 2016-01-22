<?php
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
		$ostrovy = array();
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
			//array_push($ostrovy,$vypisOstrova);
			$ostrovy[$ostrov] = $vypisOstrova;
		}
		$obsah .= "
		<div id='ostrovinfo'></div>
		<script>
		var ostrovy = ". json_encode($ostrovy, JSON_UNESCAPED_SLASHES) . ";
		klice = Object.keys(ostrovy);
		
		prepni(klice[0]);
		
		function prepni(y){
			document.getElementById('ostrovinfo').innerHTML = '';
			for(var x =0;x<klice.length;x++){
				document.getElementById('ostrovinfo').innerHTML += \"<button onclick='prepni(\"+klice[x]+\")'>Ostrov \"+klice[x]+\"</button>\";
			}
			document.getElementById('ostrovinfo').innerHTML += ostrovy[y];
		}
		
		
		</script>";
		
		//*****************************//
		
		$obsah .= "<div style='clear: left;'></div>";
		$tpl->setContent("content",$obsah);
		
		return $tpl->__toString();
		
	}	
}
?>
