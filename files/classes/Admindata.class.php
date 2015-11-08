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

	public function uzivatele_prehled(){
		$this->seznam=$this->db->queryOne("SELECT COUNT(*),SUM(penize),SUM(uhli),SUM(ropa),SUM(rubin) FROM accounts");
		$hracu = $this->seznam['COUNT(*)'];
		$rubin= $this->seznam['SUM(rubin)'];
		$rtrn = "<div class='miniinfo'><h1>".$this->seznam['COUNT(*)']."</h1><span>Lidí ve hře</span></div>";
		$rtrn .= "<div class='miniinfo'><h1>$".number_format($this->seznam['SUM(penize)'], 0, ',', ' ')."</h1><span>Peněz v oběhu</span></div>";
		/****************************************************************/
		$this->seznam=$this->db->queryOne("SELECT COUNT(*) FROM accounts WHERE kongresmando>='".Cas::DB_DatumCas()."'");
		$kongresmani = $this->seznam['COUNT(*)'];
		$this->seznam=$this->db->queryOne("SELECT COUNT(*) FROM accounts WHERE vipdo>='".Cas::DB_DatumCas()."'");
		$vip = $this->seznam['COUNT(*)'];
		$this->seznam=$this->db->queryOne("SELECT COUNT(*) FROM islands");
		$ostrohra = round($this->seznam['COUNT(*)'] / $hracu,2);
		$rtrn .= "<div class='miniinfo'><h1>".$ostrohra."</h1><span>Ostrovů na hráče</span></div>";
		$rtrn .= "<div class='miniinfo'><h1>".$rubin."</h1><span>Rubínů ve hře</span></div>";
		$rtrn .= "<div class='miniinfo'><h1>".$kongresmani."</h1><span>Kongresmanů</span></div>";
		$rtrn .= "<div class='miniinfo'><h1>".$vip."</h1><span>VIP</span></div>";
		return $rtrn;
	}
	public function uzivatele_menu(){
		$rtrn = "<div class='podmenu-1'><span><a href='index.php?page=uzivatele&sekce=1'>Přehled sekce</a></span></div>";
		$rtrn .= "<div class='podmenu-1'><span><a href='index.php?page=uzivatele&sekce=2'>Tabulka uživatelů</a></span></div>";
		$rtrn .= "<div class='podmenu-1'><span><a href='index.php?page=uzivatele&sekce=3'>VIP a Kongres</a></span></div>";
		$rtrn .= "<div class='podmenu-1'><span><a href='index.php?page=uzivatele&sekce=4'>Odměny hráčům</a></span></div>";
		$rtrn .= "<div class='podmenu-1'><span><a href='index.php?page=uzivatele&sekce=5'>Tresty</a></span></div>";
		return $rtrn;
	}

}
