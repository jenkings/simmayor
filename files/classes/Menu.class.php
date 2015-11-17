<?php
class Menu{
	
	public function __toString(){
		$out = "";
		if (!isset($_SESSION)) session_start();
			$out.="<ul id='menu'>";
			$out.="<li><a href='index.php?pid=title'>Domů</a></li>";
			$out.="<li><a href='game.php'>Hra</a></li>";
			$out.="<li><a href='./forum/index.php'>Fórum</a></li>";
			$out.="<li><a href='top.php'>Top</a></li>";
			
			if(isset($_SESSION['prihlasen'])){
				$out.="<li><a href='obchod.php'>Obchod</a></li>";
				$out.="<li><a href='banka.php'>Banka</a></li>";
				$out.="<li><a href='islandset.php'>Poplatky</a></li>";
				$out.="<li><a href='showme.php'>Profil</a></li>";
				$out.="<li><a href='logout.php'>Odhlásit</a></li>";
			}
			$out.="</ul>";
		return $out;
	}	
}
?>
