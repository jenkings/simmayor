<?php
abstract class SortTypes extends BasicEnum{
    const BY_NAME = 0;
    const BY_TOP_MONEY = 1;
    const BY_MEMBERS = 2;
    const BY_ENTRY_FEE = 3;
}

class NationsList{
  private $db;
  
  /**
   * @param Database $db předání instance databáze
   */
  public function __construct($db){
      $this->db = $db;
  }
  /**
   * @param prvek z enumu SortTypes
   */
  public function listOrderedBy($orderer){
    if(!SortTypes::isValidValue($orderer)) Throw new Exception("Neznámý typ řazení");
    
    if($orderer == SortTypes::BY_NAME)
      return $this->db->queryALL("SELECT nazev,(SELECT jmeno FROM accounts WHERE id = n.majitel) as majitel,penize,vstupne,(SELECT COUNT(*) FROM accounts WHERE innation= n.id) as clenu FROM nations n ORDER BY nazev");
    else if($orderer == SortTypes::BY_TOP_MONEY)
      return $this->db->queryALL("SELECT nazev,(SELECT jmeno FROM accounts WHERE id = n.majitel) as majitel,penize,vstupne,(SELECT COUNT(*) FROM accounts WHERE innation= n.id) as clenu FROM nations n ORDER BY penize DESC");
    else if($orderer == SortTypes::BY_MEMBERS)
      return $this->db->queryALL("SELECT nazev,(SELECT jmeno FROM accounts WHERE id = n.majitel) as majitel,penize,vstupne,(SELECT COUNT(*) FROM accounts WHERE innation= n.id) as clenu FROM nations n ORDER BY clenu DESC");
    else if($orderer == SortTypes::BY_ENTRY_FEE)
      return $this->db->queryALL("SELECT nazev,(SELECT jmeno FROM accounts WHERE id = n.majitel) as majitel,penize,vstupne,(SELECT COUNT(*) FROM accounts WHERE innation= n.id) as clenu FROM nations n ORDER BY vstupne");
  }
  

}