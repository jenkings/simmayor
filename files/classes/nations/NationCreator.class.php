<?php
class NationCreator{
    private $db;
    /**
     * @param Database $db předání instance databáze
     **/
    function __construct($db){
        $this->db = $db;
    }
    
    /**
     *  @return String formulář pro vytvoření nového státu
    */
    public static function creationForm(){
        return"
        <div class='box' id='nat_creator'>
            <form method='post'>
                <h4>Založit nový</h4>
                <input type='text' name='nazev' placeholder='Název nového státu'>
                <input type='submit' value='Založit'>
            </form>
        </div>
        ";
    }
    /**
     * @param Player $player předání instance hráče který chce založit stát
     * @param String $name název nového ostrova
     */
    public function createNewNation($player,$name){
        if($player->getVar("innation") != NULL)
            throw new Exception("Už jsi členem jiného státu");
        if($player->getVar("penize") < NEW_NATION_PRICE)
            throw new Exception("Nemáš potřebných $" . NumberFormat::moneyOutput(NEW_NATION_PRICE));
        if($this->db->queryOne("SELECT COUNT(*) AS c FROM nations WHERE majitel=?",array($player->getVar("id")))['c'] > 0)
            throw new Exception("Nemůžeš ovládat více než jeden stát");            
        $this->db->query("INSERT INTO nations (nazev,majitel) VALUES (?,?)",array($name,$player->getVar("id")));
        $this->db->query("UPDATE accounts SET penize = penize-?, innation=(SELECT id FROM nations WHERE majitel=?) WHERE id=?",array(NEW_NATION_PRICE,$player->getVar("id"),$player->getVar("id")));
    }
}