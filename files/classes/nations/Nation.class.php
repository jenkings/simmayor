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
            
    }
    
    public function overview(){
        if(empty($this->data))  return"<div class='box' id='nat_creator'><h4>Nejste členem žádneho státu</h4></div>";
        
        return"
        <div class='box' id='nat_creator'>
            jsi člen
        </div>
        ";
    }
    
}