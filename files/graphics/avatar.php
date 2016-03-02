<?php
	session_start();
	
	require_once "../classes/Autoloader.class.php";
	require_once "../cfg/avatars.php";
	require_once "../cfg/host.php";
	
	spl_autoload_register(array(new autoloader('../classes'), 'autoload'));
    spl_autoload_register(array(new autoloader('../classes/controllers'), 'autoload'));
    spl_autoload_register(array(new autoloader('../classes/layout'), 'autoload'));
	
    if(isset($_GET['key']) && !empty($_GET['key'])){
        $avatar = new AvatarGenerator($_GET['key']);
        $avatar->render();
    }
	
?>