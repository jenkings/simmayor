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
    
    public function createNewNation($player,$name){
        //No yet finished
        //No yet finished
        //No yet finished
        //No yet finished
        //No yet finished
        //No yet finished
        //No yet finished
    }
}