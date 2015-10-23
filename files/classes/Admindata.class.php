<?php
class Admindata{
  private $seznam;
  private $db;

  function  __construct($spojeni){
    $this->db=$spojeni;
  }

  public function prehled() 
  {
	$this->seznam=$this->db->queryOne("SELECT COUNT(*),SUM(penize) FROM accounts");
	$rtrn = "<div class='miniinfo'><h1>".$this->seznam['COUNT(*)']."</h1><span>uživatelů registrováno</span></div>";
	$rtrn .= "<div class='miniinfo'><h1>$".number_format($this->seznam['SUM(penize)'], 0, ',', ' ')."</h1><span>peněz v oběhu</span></div>";
	$this->seznam=$this->db->queryOne("SELECT COUNT(*) FROM islands");
	$rtrn .= "<div class='miniinfo'><h1>".$this->seznam['COUNT(*)']."</h1><span>Ostrovů</span></div>";
	$this->seznam=$this->db->queryOne("SELECT COUNT(*) FROM prodejna");
	$rtrn .= "<div class='miniinfo'><h1>".$this->seznam['COUNT(*)']."</h1><span>Položek v obchodě</span></div>";
	$this->seznam=$this->db->queryOne("SELECT COUNT(*) FROM topics");
	$rtrn .= "<div class='miniinfo'><h1>".$this->seznam['COUNT(*)']."</h1><span>Témat ve fóru</span></div>";
	return $rtrn;
  }


}
