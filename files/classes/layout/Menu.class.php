<?php
class Menu{
	
	public function __toString(){
		$out = "";
		if (!isset($_SESSION)) session_start();
			$out.="<ul id='menu'>";
			$out.="<li><a href='./index.php?pid=title'>Domů</a></li>";
			$out.="<li><a href='./index.php?pid=game'>Hra</a></li>";
			$out.="<li><a href='./index.php?pid=forum'>Fórum</a></li>";
			$out.="<li><a href='./index.php?pid=top'>Top</a></li>";
			
			if(isset($_SESSION['prihlasen'])){
				$out.="<li><a href='./index.php?pid=shop'>Obchod</a></li>";
				$out.="<li><a href='./index.php?pid=bank'>Banka</a></li>";
				$out.="<li><a href='./index.php?pid=finance'>Finance</a></li>";
				$out.="<li><a href='./index.php?pid=nations'>Národy</a></li>";
				$out.="<li><a href='./index.php?pid=messages'>Zprávy</a></li>";
				$out.="<li><a href='./index.php?pid=showme'>Profil</a></li>";
				$out.="<li><a href='./index.php?pid=logout'>Odhlásit</a></li>";
			}
			$out.="</ul>";
		return $out;
	}	
}
?>
