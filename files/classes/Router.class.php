<?php
class Router{
	private $kontroler;
	
	
	public function Router($controller,$get,$post){
		$controllerName = ucfirst($controller) . "Controller";
		
		if(!file_exists("./classes/controllers/".$controllerName.".class.php")){
			$controllerName = "UnknownController";
		}
		require_once "./classes/controllers/".$controllerName.".class.php";
		$this->kontroler = new $controllerName;
	}
	
	public function __toString(){
		return $this->kontroler->__toString();
	}
	
}
?>
