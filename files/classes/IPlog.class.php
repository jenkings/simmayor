<?php
class IPlog{

	public function IPEntry(){
	}
	
	/**
	 * @param int $id id hráče
	 * @param string $ip současná IP adresa
	*/ 
	public function record($id,$ip){
		$db = new Database(DB_HOST,DB_USER,DB_PASS,DB_NAME);
		$res = $db->queryOne("SELECT id FROM ipzaznamy WHERE iduzivatele = ? AND ip = ?",array($id,$ip));
		if(!$res){
			$db->query("INSERT INTO ipzaznamy (iduzivatele,ip) VALUES (?,?)",array($id,$ip));
		}
	}
}
?>
