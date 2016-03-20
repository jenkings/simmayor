<?php
class Nation{
    private $db;
    private $data;
    /**
     * @param Database $db předání instance databáze
     * @param int $id id požadovaného státu
    **/
    public function __construct($db,$id){
        $this->db = $db;
        if($id != null)
            $this->data = $db->queryOne("SELECT * FROM nations WHERE id=?",array($id));
    }
    
    /**
     * @return Array pole obsahující základní údaje o státu
    **/
    public function sumarize(){
        $return = Array();
        $return['nazev'] = $this->data['nazev'];
        $return['rozpocet'] = $this->data['penize'];
        $return['majitel'] = $this->db->queryOne("SELECT jmeno FROM accounts WHERE id=?",array($this->data['majitel']))['jmeno'];
        $return['clenu'] = $this->db->queryOne("SELECT COUNT(*) as c FROM accounts WHERE innation = ?",array($this->data['id']))['c'];
        return $return;
    }
    
    public function overview(){
        if(empty($this->data))  return"<div class='box' id='nat_creator'><h4>Nejste členem žádneho státu</h4></div>";
        
        $d = $this->sumarize();
        return"
        <div class='box' id='nat_creator'>
            ".implode($d,"/")."
        </div>
        ";
    }
    
}