<?php
require_once "./classes/controllers/Controller.class.php";
class RegisterController implements Controller{
	private $get;
	private $post;
	private $session;
	
	public function RegisterController($get,$post,$session){
		$this->get = $get;
		$this->post = $post;
		$this->session = $session;
	}
	
	public function __toString(){
		require_once "./cfg/host.php";
		require_once "./classes/Database.class.php";
		require_once "./classes/layout/Template.class.php";
		require_once "./classes/Menu.class.php";
		require_once "./classes/Login.class.php";
		require_once "./classes/Register.class.php";
				
		$tpl = new Template("registrace-login");
		$db = new Database(DB_HOST,DB_USER,DB_PASS,DB_NAME);
		
		if(isset($_POST['nick']) && isset($_POST['password'])){
			$login = new Login($db);
			$login->auth($_POST['nick'],$_POST['password']);
		}
		else if(isset($this->post['nick']) && $_POST['nick'] != "Jméno" && $this->post['nick'] != "" && isset($this->post['password1']) && isset($this->post['password2']) && $this->post['password1'] != "" &&  $this->post['password2'] == $this->post['password1'] && isset($this->post['password3']) && $this->post['password3'] == "heslo3")
		{
			//Captcha
			if(empty($this->session['6_letters_code'] ) || strcasecmp($this->session['6_letters_code'], $this->session['6_letters_code']) != 0){  
				header('Location: ./game.php');exit;
			}else{
				$register = new Register($db);
				$volnyNick = $register->isAvailableName($_POST['nick']);
				if($volnyNick)
				{
					require "newmap.php"; //přeobjektovat
					$register->createAccount($_POST['nick'],$_POST['password1']);
					exit;
				}else{
					echo "Tento nick už je zabraný";
				}
			}
		}

		return $tpl->__toString();
	}	
}
?>
