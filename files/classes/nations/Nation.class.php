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
        $this->data = $data;
    }
    
    /**
     * @return Array pole obsahující základní údaje o státu
    **/
    public function sumarize(){
            
    }
    
    
}