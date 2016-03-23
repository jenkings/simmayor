<?php

/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 23. 3. 2016
 * Time: 20:16
 */
class AdminStatusy
{
    private $seznam;
    private $db;

    function  __construct($spojeni)
    {
        $this->db=$spojeni;
    }

    /**
     * @return string vrátí tabulku se všemi funkcemi ve hře
     */
    public function vypisStatusu(){
        $vra = "";

        $vra.="<div style='width: 80%;margin-right: auto;margin-left: auto;margin-top: 15px;'>";
        $vra.="<table width='100%' border='1px'>";
        $vra.="<tr align='center'><th width='5%'>ID:</th><th width='20%'>Název:</th><th width='20%'>Barva:</th><th width='30%'>Možné akce:</th>";
            $this->seznam=$this->db->queryOne("SELECT COUNT(*) FROM statusy WHERE sta_aktivni=?",array(1));
            if($this->seznam['COUNT(*)']>=1){

                $this->seznam=$this->db->queryAll("SELECT * FROM statusy WHERE sta_aktivni=?",array(1));
                $vysledek = array();
                foreach($this->seznam as $promena){
                    $vysledna = "<tr align='center'><td>".$promena['pid_status']."</td><td>".$promena['sta_nazev']."</td><td><span style='color:".$promena['sta_barva'].";'>".$promena['sta_barva']."</span></td><td><a href='index.php?page=statusy&pravomoce=".$promena['pid_status']."'>Pravomoce</a> | <a href='index.php?page=statusy&smazatpravomoc=".$promena['pid_status']."'>Smazat</a></td></tr>";
                    $vysledek[] = $vysledna;
                }
                $vra.= implode("\n",$vysledek);

            }else{

                $vra.="<div class='chyba'>Nebyl nalezen žádný status k vypsání...</div>";
            }
        $vra.= "</table>";
        $vra.= "</div>";
        return $vra;
    }

    public function editacePravooce($idPravomoce,$post){
        $vra = "";
        $idPravomoce = intval($idPravomoce);

        if(isset($post['zmenit'])){
            //print_r($post);
            //echo $post['skrtatko_moderovani'];
            $this->db->query("UPDATE `statusy` SET `sta_nazev` = ?, `sta_barva` = ?, `sta_vstup` = ?, `sta_fora` = ?, `sta_posta` = ?, `sta_postah` = ?, `sta_moderovani` = ?, `sta_mazani` = ? WHERE `statusy`.`pid_status` = ?;",array(
                $post['sta_nazev'],$post['sta_barva'],$post['skrtatko_vstup'],$post['skrtatko_fora'],$post['skrtatko_posta'],$post['skrtatko_postah'],$post['skrtatko_moderovani'],$post['skrtatko_mazani'],$idPravomoce));
        }

            $this->seznam=$this->db->queryOne("SELECT COUNT(*) FROM statusy WHERE pid_status=? AND sta_aktivni=?",array($idPravomoce,1));
            if($this->seznam['COUNT(*)']>=1){

                $promena=$this->db->queryOne("SELECT * FROM statusy WHERE pid_status=?",array($idPravomoce));

                $vra.="<form method='post'><div style='border: solid green 3px;width: calc(80% - 6px);margin-left: auto;margin-right: auto;margin-top: 15px'>";
                $vra.="<div style='padding: 15px'><table border='1px' width='100%'>";
                    $vra.="<tr align='center'><th width='30%' colspan='2'>Co</th><th width='50%' colspan='2'>Změna</th></tr>";
                    $vra.="<tr align='center'><td colspan='2'>Název</td><td colspan='2'><input type='text' name='sta_nazev' placeholder='Název statusu' value='".$promena['sta_nazev']."'></td></tr>";
                    $vra.="<tr align='center'><td colspan='2'>Barva</td><td colspan='2'><input type='text' name='sta_barva' placeholder='Barva statusu' value='".$promena['sta_barva']."'></td></tr>";
                    $vra.="<tr align='center'><td colspan='4'><b>Hráči</b></td></tr>";

                if($promena['sta_vstup']>=1){
                    $skrtatko_vstup = "checked";
                }else{
                    $skrtatko_vstup = "";
                }

                if($promena['sta_fora']>=1){
                    $skrtatko_fora = "checked";
                }else{
                    $skrtatko_fora = "";
                }

                if($promena['sta_posta']>=1){
                    $skrtatko_posta = "checked";
                }else{
                    $skrtatko_posta = "";
                }

                if($promena['sta_postah']>=1){
                    $skrtatko_postah = "checked";
                }else{
                    $skrtatko_postah = "";
                }

                if($promena['sta_moderovani']>=1){
                    $skrtatko_moderovani = "checked";
                }else{
                    $skrtatko_moderovani = "";
                }

                if($promena['sta_mazani']>=1){
                    $skrtatko_mazani = "checked";
                }else{
                    $skrtatko_mazani = "";
                }



                    $vra.="<tr align='center'><td width='25%'>Vstup do hry:</td><td width='25%'><input type='checkbox' value='1' name='skrtatko_vstup' ".$skrtatko_vstup."></td><td width='25%'>Vstup na fóra:</td><td width='25%'><input type='checkbox' value='1' name='skrtatko_fora' ".$skrtatko_fora."></td></tr>";
                    $vra.="<tr align='center'><td>Pošta:</td><td><input type='checkbox' value='1' name='skrtatko_posta' ".$skrtatko_posta."></td><td>Hromadná pošta:</td><td><input type='checkbox' value='1' name='skrtatko_postah' ".$skrtatko_postah."></td></tr>";
                    $vra.="<tr align='center'><td colspan='4'><b>Fóra</b></td></tr>";
                    $vra.="<tr align='center'><td>Moderování:</td><td><input type='checkbox' value='1' name='skrtatko_moderovani' ".$skrtatko_moderovani."></td><td>Mazání příspěvků:</td><td><input type='checkbox' value='1' name='skrtatko_mazani' ".$skrtatko_mazani."></td></tr>";
                    $vra.="<tr align='center'><td colspan='4'><input type='submit' name='zmenit' value='..: Změnit nastavení :..'></td></tr>";
                $vra.="</table></div>";
                $vra.="</div></form>";

            }else{
                $vra.="<div class='chyba'>Požadovaný status nebyl nalezen</div>";
            }

        return $vra;
    }
}