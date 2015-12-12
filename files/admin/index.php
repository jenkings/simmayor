<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 7. 11. 2015
 * Time: 13:06
 */


        session_start();
        function __autoload($class_name) {include '../classes/'.$class_name . '.class.php';}
        if(!isset($_SESSION['prihlasen']) || $_SESSION['prihlasen'] == "")
        {
            header('Location: ../index.php');
        }

        include_once "../cfg/host.php";

        $db = new Database(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        $cas = new Cas();
        $player = new Player($db,array("admin,jmeno",$_SESSION['prihlasen']));
		$ukoly = new Ukoly($db);
        $reklama = new Reklama($db);
        $administrace = new Admindata($db);
        $adminplayers = new AdminPlayers($db);

        if(intval($player->getVar('admin')) < 1)
        {
            header('Location: ../index.php');
        }


    include "vzhled/hlavicka.php";

        if(!isset($_GET['page']) OR $_GET['page'] == ""){
            $_GET['page'] = "index";
        }

        $stranka = $_GET['page'];

        if(file_exists("stranky/$stranka.php")){

            include("stranky/$stranka.php");

        }else{

            echo "<div id='text' align='center'>Stránka $stranka.php je zatím prázdná, pokuď si myslíte, že by zde něco mělo býti kontaktujte programátory</div>";
        }


    include "vzhled/paticka.php";