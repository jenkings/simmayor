<?php
session_start();
include "../connect.php";

if(isset($_POST['nadpis']) && isset($_POST['obsah']) && isset($_POST['sekce']))
{
		mysql_query("INSERT INTO topics (idsekce,idzakladatele,datum,nazev,text) VALUES ('".$_POST['sekce']."','".intval($_SESSION['prihlasen'])."','".date('Y-m-d H:i:s')."','".mysql_real_escape_string(htmlspecialchars($_POST['nadpis']))."','".mysql_real_escape_string(htmlspecialchars($_POST['obsah']))."')");
}else if(isset($_POST['text']) && isset($_POST['idtopicu']))
{
		mysql_query("INSERT INTO posts (idtematu,idodepisovatele,text) VALUES ('".intval($_POST['idtopicu'])."','".intval($_SESSION['prihlasen'])."','".mysql_real_escape_string(htmlspecialchars($_POST['text']))."')");
		mysql_query("UPDATE topics SET datum='".date('Y-m-d H:i:s')."' WHERE id='".intval($_POST['idtopicu'])."'");
}



header('Location:' . $_SERVER['HTTP_REFERER']);
?>
