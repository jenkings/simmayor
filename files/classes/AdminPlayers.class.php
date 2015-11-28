<?php

/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 20. 11. 2015
 * Time: 21:28
 * TO: Přepsat funkce na xxxA();
 * TO: Předávání parametrů
 * TO: Udělat vše tak aby šlo spustit odevšaď
 */
class AdminPlayers
{
    private $seznam;
    private $db;

    public function  AdminPlayers($spojeni){
        $this->db=$spojeni;
    }

    public function uzivatelePrehled(){
        $this->seznam=$this->db->queryOne("SELECT COUNT(*),SUM(penize),SUM(uhli),SUM(ropa),SUM(rubin) FROM accounts");
        $hracu = $this->seznam['COUNT(*)'];
        $rubin= $this->seznam['SUM(rubin)'];
        $rtrn = "<div class='miniinfo'><h1>".$this->seznam['COUNT(*)']."</h1><span>Lidí ve hře</span></div>";
        $rtrn .= "<div class='miniinfo'><h1>$".number_format($this->seznam['SUM(penize)'], 0, ',', ' ')."</h1><span>Peněz v oběhu</span></div>";
        /****************************************************************/
        $this->seznam=$this->db->queryOne("SELECT COUNT(*) FROM accounts WHERE kongresmando>=? ",array(Cas::DB_DatumCas()));
        $kongresmani = $this->seznam['COUNT(*)'];
        $this->seznam=$this->db->queryOne("SELECT COUNT(*) FROM accounts WHERE vipdo>=? ",array(Cas::DB_DatumCas()));
        $vip = $this->seznam['COUNT(*)'];
        $this->seznam=$this->db->queryOne("SELECT COUNT(*) FROM islands");
        $ostrohra = round($this->seznam['COUNT(*)'] / $hracu,2);
        $rtrn .= "<div class='miniinfo'><h1>".$ostrohra."</h1><span>Ostrovů na hráče</span></div>";
        $rtrn .= "<div class='miniinfo'><h1>".$rubin."</h1><span>Rubínů ve hře</span></div>";
        $rtrn .= "<div class='miniinfo'><h1>".$kongresmani."</h1><span>Kongresmanů</span></div>";
        $rtrn .= "<div class='miniinfo'><h1>".$vip."</h1><span>VIP</span></div>";
        return $rtrn;
    }

    public function uzivateleMenu(){
        $rtrn = "<div class='podmenu-1'><span><a href='index.php?page=uzivatele&sekce=1'>Přehled sekce</a></span></div>";
        $rtrn .= "<div class='podmenu-1'><span><a href='index.php?page=uzivatele&sekce=2'>Tabulka uživatelů</a></span></div>";
        $rtrn .= "<div class='podmenu-1'><span><a href='index.php?page=uzivatele&sekce=3'>VIP a Kongres</a></span></div>";
        $rtrn .= "<div class='podmenu-1'><span><a href='index.php?page=uzivatele&sekce=4'>Odměny hráčům</a></span></div>";
        $rtrn .= "<div class='podmenu-1'><span><a href='index.php?page=uzivatele&sekce=5'>Tresty</a></span></div>";
        return $rtrn;
    }

    public function uzivateleSekce($ParametrGet,$FormularePost,$Sesion){
        $vraceni = "";

        if($ParametrGet['sekce']==1){

        }elseif($ParametrGet['sekce']==2){

            $vraceni.="<h3>Vyhledej uživatele:</h3>";

            $vraceni.=$this->uzivateleHledani($ParametrGet,$FormularePost,"index.php?page=uzivatele&sekce=2&editace=");

            $vraceni.=$this->uzivateleSmaz();

            $vraceni.=$this->uzivateleEditace($ParametrGet['editace'],$FormularePost);

            $vraceni.= "<h3>Tabulka uživatelů:</h3>";


            $vraceni.=$this->uzivatelePaginace($ParametrGet,20);

            $vraceni.=$this->uzivateleTabulka($ParametrGet,20);

            $vraceni.=$this->uzivatelePaginace($ParametrGet,20);

        }elseif($ParametrGet['sekce']==3){

            $vraceni.= "<h3>Vyhledej uživatele:</h3>";

            $vraceni.=$this->uzivateleHledani($ParametrGet,$FormularePost,"index.php?page=uzivatele&sekce=3&editace=");

            $vraceni.=$this->uzivateleVip($ParametrGet['editace'],$FormularePost);

            $vraceni.=$this->uzivateleKongres($ParametrGet['editace'],$FormularePost);

        }elseif($ParametrGet['sekce']==4){

            $vraceni.=$this->uzivateleOdmena($FormularePost);

        }elseif($ParametrGet['sekce']==5){

            $vraceni.= "Sekce tresty zatím nefunguje...";

        }

        return $vraceni;
    }

    /**
     * @param $parametrGet - zavolam si get kvůli stránkování
     * , které uvádí od kolikátého řádku se počítá
     * @param $radku - Kolik řádků chci vypsat na jednu stránku
     * @return string - vrací tabulku uživatelů
     */
    public function uzivateleTabulka($parametrGet,$radku){
        $minimum=$parametrGet['paginace'];


        $this->seznam=$this->db->queryAll("SELECT * FROM accounts ORDER BY id LIMIT ".$minimum.",".$radku." ");
        $vysledek = array();
        $vysledna = 0;
        foreach($this->seznam as $promena){
            $vysledna = "<tr align='center'><td>".$promena['jmeno']."</td><td>". number_format($promena['penize'],1, ',',' ')."</td><td>".$promena['rubin']."</td><td>".$promena['vipdo']."</td><td>".$promena['admin']."</td><td><a href='/admin/index.php?page=uzivatele&sekce=2&editace=".$promena['id']."'>Editovat</a> / <a href='/admin/index.php?page=uzivatele&sekce=2&smazat=".$promena['id']."'>Smazat</a></td></tr>";
            $vysledek[] = $vysledna;
        }
        $vraceni = implode("\n",$vysledek);
        $hlavicka = "<tr align='center'><th>Jméno uživatele:</th><th>Peněz:</th><th>Rubínů:</th><th>VIP do:</th><th>Admin level:</th><th>Možné akce:</th></tr>";

        return "<table width='98%' border='1px'>".$hlavicka . $vraceni."</table>";
    }

    /**
     * @param $idUzivatele - IDuživatele, kterého chceme změnit
     * @param $post - Post předávající to co se odešle v editačním formuláři
     * @return string - Vypíše buď tabulku s editací / Chybu, že uživatel neexistuje
     * a v případě odeslání to napíše, že údaje byly změněny
     */
    public function uzivateleEditace($idUzivatele,$post){
        $vraceni = "";
        if(isset($post['zmenitudaje'])){
            $this->db->query("UPDATE accounts SET jmeno = ?, heslo = ?, avatar = ?, penize = ?, dluh = ?, uhli = ?, ropa = ?, rubin = ?, maxprodej = ?, kongresmando = ?, vipdo = ?, admin = ? WHERE id =?", array($post['jmeno'],$post['heslo'],$post['avatar'],$post['penize'],$post['dluh'],$post['uhli'],$post['ropa'], $post['rubin'],$post['maxprodej'],$post['kongresmando'],$post['vipdo'],$post['admin'],$idUzivatele));
            $vraceni.= "<div class='uspech'>Povedlo se, údaje změněny</div>";
        }

        if(isset($idUzivatele) AND $idUzivatele >= 1){
            $radku=$this->db->queryOne("SELECT COUNT(*) FROM accounts WHERE id=?", array($idUzivatele));
            if($radku['COUNT(*)']=="1"){
                $hrac=$this->db->queryOne("SELECT * FROM accounts WHERE id=?", array($idUzivatele));
                $vraceni.= "<div class='editace'>";
                $vraceni.= "<form method='post'>";
                $vraceni.= "Editace uživatele: ".$hrac['id'];
                $vraceni.= "<table width='100%' border='1px'>";
                $vraceni.= "<tr align='center'><td>Uživatel jméno:</td><td>".$hrac['jmeno']."</td><td><input type='text' name='jmeno' value='".$hrac['jmeno']."'></td></tr>";
                $vraceni.= "<tr align='center'><td>Uživatel heslo:</td><td>".$hrac['heslo']."</td><td><input type='text' name='heslo' value='".$hrac['heslo']."'></td></tr>";
                $vraceni.= "<tr align='center'><td>Uživatel avatar:</td><td>".$hrac['avatar']."</td><td><input type='text' name='avatar' value='".$hrac['avatar']."'></td></tr>";
                $vraceni.= "<tr align='center'><td>Uživatel peněz:</td><td>".number_format($hrac['penize'],1, ',',' ')."</td><td><input type='text' name='penize' value='".$hrac['penize']."'></td></tr>";
                $vraceni.= "<tr align='center'><td>Uživatel dluh:</td><td>".$hrac['dluh']."</td><td><input type='text' name='dluh' value='".$hrac['dluh']."'></td></tr>";
                $vraceni.= "<tr align='center'><td>Uživatel uhlí:</td><td>".$hrac['uhli']."</td><td><input type='text' name='uhli' value='".$hrac['uhli']."'></td></tr>";
                $vraceni.= "<tr align='center'><td>Uživatel ropy:</td><td>".$hrac['ropa']."</td><td><input type='text' name='ropa' value='".$hrac['ropa']."'></td></tr>";
                $vraceni.= "<tr align='center'><td>Uživatel rubínů:</td><td>".$hrac['rubin']."</td><td><input type='text' name='rubin' value='".$hrac['rubin']."'></td></tr>";
                $vraceni.= "<tr align='center'><td>Uživatel maxprodej:</td><td>".$hrac['maxprodej']."</td><td><input type='text' name='maxprodej' value='".$hrac['maxprodej']."'></td></tr>";
                $vraceni.= "<tr align='center'><td>LastSave:</td><td>".$hrac['lastsave']."</td><td>--Nelze editovat--</td></tr>";
                $vraceni.= "<tr align='center'><td>Kongres:</td><td>".$hrac['kongresmando']."</td><td><input type='text' name='kongresmando' value='".$hrac['kongresmando']."'></td></tr>";
                $vraceni.= "<tr align='center'><td>VIP do:</td><td>".$hrac['vipdo']."</td><td><input type='text' name='vipdo' value='".$hrac['vipdo']."'></td></tr>";
                $vraceni.= "<tr align='center'><td>Admin levl:</td><td>".$hrac['admin']."</td><td><input type='text' name='admin' value='".$hrac['admin']."'></td></tr>";
                $vraceni.= "<tr align='center'><td colspan='3'><input type='submit' name='zmenitudaje' value='..: Změnit údaje :..'></td></tr>";
                $vraceni.= "</table>";
                $vraceni.= "</form>";
                $vraceni.= "</div>";
                return $vraceni;
            }else{
                return "<div class='chyba'>Hledaný uživatel neexistuje</div>";
            }
        }
    }

    /*Forular vyndat a udělat vlastní na form a vlastní na mazání uživatele.
     *
     */

    public function uzivateleSmaz(){
        if(isset($_POST['smaz_hrace'])){
            $this->db->query("DELETE FROM `accounts` WHERE `id` = '".$_GET['smazat']."'");
            echo "<div class='centruj'><h3>Hráč byl smazán</h3></div>";
        }

        if(isset($_GET['smazat'])){
            $radku=$this->db->queryOne("SELECT COUNT(*) FROM accounts WHERE id='".$_GET['smazat']."'");
            if($radku['COUNT(*)']=="1"){
                $id = $_GET['smazat'];
                $hrac=$this->db->queryOne("SELECT * FROM accounts WHERE id='".$_GET['smazat']."'");
                echo "<form method='post'>";
                echo "<div class='centruj'>";
                echo "<fieldset class='okenko'>";
                echo "Opravdu chcete smazat tohoto hráče: <b>".$hrac['jmeno']."</b><br>";
                echo "<input type='submit' name='smaz_hrace' value='..:Smazat uživatele:..'>";
                echo "</fieldset>";
                echo "</div>";
                echo "</form>";
            }else{
                echo "<div class='chyba'>Nelze smazat hráče, který neexistuje</div>";
            }
        }
    }

    /**
     * @param $parametrGet - Není potřeba, ovšem při rozšíření by se to mohlo hodit
     * @param $post - Post z formuláře na hledání
     * @param $ciloveUrl - okno do kterého se otevře URL a doplní ID uživatele
     * @return string - Vyhledávací formulář
     */
    public function uzivateleHledani($parametrGet,$post,$ciloveUrl){
        if(isset($post['hledej_hrace'])){
            $hrac = $post['nickname'];
            $id = $post['id'];

            if(!empty($hrac)){
                $hrac=$this->db->queryOne("SELECT * FROM accounts WHERE jmeno=?",array($hrac));
                $nastav = $hrac['id'];
                $id = $hrac['id'];
            }

            header('Location: '.$ciloveUrl.$id.'');

        }

        $vraceni = "";
        $vraceni.= "<form method='post'>";
        $vraceni.= "<div class='centruj'>";
        $vraceni.= "<fieldset class='okenko'>";
        $vraceni.= "<table>";
        $vraceni.= "<tr><td>Jméno:</td><td><input type='text' name='nickname'></td></tr>";
        $vraceni.= "<tr><td>ID:</td><td><input type='text' name='id' value=''></td></tr>";
        $vraceni.= "<tr><td colspan='2'><input type='submit' name='hledej_hrace' value='..:Hledat uživatele:..'></td></tr>";
        $vraceni.= "</table>";
        $vraceni.= "</fieldset>";
        $vraceni.= "</div>";
        $vraceni.= "</form>";
        return $vraceni;

    }

    /**
     * @param $parametrGet - ['paginace'] aneb od jakého řádku zobrazujem
     * @param $radku - o kolik se má "šoupat" začátek další stránky
     * @return string - vratí dvě klikací šipky doleva(mínus) doprva(plus)
     */
    public function uzivatelePaginace($parametrGet,$radku){
        $minimum=$parametrGet['paginace']-$radku;
        $maximum=$parametrGet['paginace']+$radku;
        return "<div class='centruj'><a href='index.php?page=uzivatele&sekce=2&paginace=$minimum'><<< Posunout o ".$radku." záznamů</a> / <a href='index.php?page=uzivatele&sekce=2&paginace=$maximum'>Posunout o ".$radku." záznamů >>></a></div>";

    }

    /**
     * @param $idUzivatele - id uživatele, kterému budeme přidělovat VIP
     * @param $post - kvůli formuláři, kde určujeme čas na kterou dobu se to přiděluje
     * @return string - vrátí formulář, kde se přiděluje VIP
     */
    public function uzivateleVip($idUzivatele,$post){
        $vraceni = "";
        $vraceni.= "<h4>Přiděl VIP:</h4>";
        if($idUzivatele>=1){
            if(isset($post['udel_vip'])){
                $dokdy = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s") . "+".$post['doba']." days"));
                $this->db->query("UPDATE accounts SET vipdo = ? WHERE id = ?;",array($dokdy,$idUzivatele));
                $vraceni.= "<div class='uspech'>VIP bylo přiděleno hráči s ID: ".$idUzivatele." do: ".$dokdy."</div>";
            }
            $vraceni.= "<form method='post'>";
            $vraceni.= "<div class='centruj'>";
            $vraceni.= "<fieldset class='okenko'>";
            $vraceni.= "<table width='100%'>";
            $vraceni.= "<tr><td>ID:</td><td>".$idUzivatele."</td></tr>";
            $vraceni.= "<tr><td>Doba:</td><td><select name='doba'><option value='30'  selected='selected'>30 dní</option><option value='60'>60 dní</option><option value='120'>120 dní</option><option value='365'>365 dní</option></select></td></tr>";
            $vraceni.= "<tr><td colspan='2'><input type='submit' name='udel_vip' value='..:Udělit VIP:..'></td></tr>";
            $vraceni.= "</table>";
            $vraceni.= "</fieldset>";
            $vraceni.= "</div>";
            $vraceni.= "</form>";
            return $vraceni;
        }
    }

    /**
     * @param $idUzivatele - ID uživatele, kterému budeme chtít přidávat křeslo kongresmena
     * @param $post - Kvůli formuláři, kde volíme dobu jeho křesla
     * @return string - vrací formulář, kde se přiděluje křeslo
     */

    public function uzivateleKongres($idUzivatele,$post){
        $vraceni = "";
        $vraceni.= "<h4>Přiděl křeslo kongresmana:</h4>";
        if($idUzivatele){
            if(isset($post['udel_kongres'])){
                $dokdy = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s") . "+".$post['doba']." days"));
                $this->db->query("UPDATE accounts SET kongresmando = ? WHERE id = ?;",array($dokdy,$idUzivatele));
                $vraceni.= "<div class='uspech'>Křeslo bylo přiděleno hráči s ID: ".$idUzivatele." do: ".$dokdy."</div>";
            }
            $vraceni.= "<form method='post'>";
            $vraceni.= "<div class='centruj'>";
            $vraceni.= "<fieldset class='okenko'>";
            $vraceni.= "<table width='100%'>";
            $vraceni.= "<tr><td>ID:</td><td>".$idUzivatele."</td></tr>";
            $vraceni.= "<tr><td>Doba:</td><td><select name='doba'><option value='30' selected='selected'>30 dní</option><option value='60'>60 dní</option><option value='120'>120 dní</option><option value='365'>365 dní</option></select></td></tr>";
            $vraceni.= "<tr><td colspan='2'><input type='submit' name='udel_kongres' value='..:Udělit kongres..'></td></tr>";
            $vraceni.= "</table>";
            $vraceni.= "</fieldset>";
            $vraceni.= "</div>";
            $vraceni.= "</form>";
            return $vraceni;
        }
    }

    public function uzivateleOdmena($post){
        $vraceni = "";
        if(isset($post['udel_odmenu'])){
            $hrac = $_POST['jmeno'];
            $id = $_POST['idcko'];
            $typodmeny =$_POST['odmenatyp'];
            $pocet =$_POST['pocet'];

            if(!empty($hrac)){
                $hrac2=$this->db->queryOne("SELECT * FROM accounts WHERE jmeno=?",array($hrac));
                $id = $hrac2['id'];
                $jmeno = $hrac2['jmeno'];
            }
            $x=$this->db->queryOne("SELECT COUNT(*) FROM accounts WHERE id=?",array($id));
            $hracu =$x['COUNT(*)'];
            if($hracu == 1){
                if($typodmeny == "rub") {
                    $this->db->query("UPDATE accounts SET rubin =rubin + ? WHERE id = ?;",array($pocet,$id));
                    $patvar = "rubínů";
                }elseif($typodmeny == "rop"){
                    $this->db->query("UPDATE accounts SET ropa =ropa + ? WHERE id = ?;",array($pocet,$id));
                    $patvar = "ropy";
                }elseif($typodmeny == "uhli"){
                    $this->db->query("UPDATE accounts SET uhli =uhli + ? WHERE id = ?;",array($pocet,$id));
                    $patvar = "uhlí";
                }
                $vraceni.= "<div class='uspech'>Povedlo se...<br>Přidal jste hráči: ".$pocet." ".$patvar." </div>";
            }else{
                $vraceni.= "<div class='chyba'>Bohužel tento uživatel neexisuje</div>";
            }
        }
        $vraceni.= "<form method='post'>";
        $vraceni.= "<div class='centruj'>";
        $vraceni.= "<fieldset class='okenko'>";
        $vraceni.= "<table width='100%'>";
        $vraceni.= "<tr><td>ID:</td><td><input type='text' name='idcko' value=''></td></tr>";
        $vraceni.= "<tr><td>Jméno:</td><td><input type='text' name='jmeno' value=''></td></tr>";
        $vraceni.= "<tr><td>Typ odměny:</td><td><select name='odmenatyp'><option value='rub'>Rubíny</option><option value='rop'>Ropa</option><option value='uhli'>Uhlí</option></select></td></tr>";
        $vraceni.= "<tr><td>Počet:</td><td><input type='text' name='pocet'></td></tr>";
        $vraceni.= "<tr><td colspan='2'><input type='submit' name='udel_odmenu' value='..:Udělit odměnu..'></td></tr>";
        $vraceni.= "</table>";
        $vraceni.= "</fieldset>";
        $vraceni.= "</div>";
        $vraceni.= "</form>";
        return $vraceni;
    }

}