<?php
class Chatbot{
	private $seznam;
	private $db;
	private $pozdravy = array();
	private $osloveni = array();
	private $vulgarismy = array();

	function  __construct($spojeni){
		$this->db=$spojeni;
		$this->pozdravy = array("ahoj","cau","zdar","cus");
		$this->osloveni = array("melisa","meliso","melizo");
		$this->vulgarismy = array("prdel","kokot","kkt","debil","curak","mrd","pica","pico","zmrd","krenten","srat","srac","sere","vysrat","kurva","hajzl");
	}
	
	public function odpovez($zprava){
		$zprava = strtolower($zprava);
		$zprava = $this->OdstranDiakritiku($zprava);
		
		if($this->jePozdrav($zprava))
			$this->sendmessage(array("Zdravím tě","Nazdar","Ahojky","Čauky"));
		else if($this->jeOsloveni($zprava))
			$this->sendmessage(array("Ano prosím?","Jsem tu ;)","Poslouchám"));
		else if($this->dotazNaCas($zprava))
			$this->sendmessage(array("Je ".StrFTime("%H:%M", Time()),"Přesně ".StrFTime("%H:%M", Time())));
		else if($this->dotazNaNaladu($zprava))
			$this->sendmessage(array("Pohoda","Mám se fajn","Je mi skvěle","Cítím se super"));
		else if($this->jeVulgarni($zprava))
			$this->sendmessage(array("Nech si ty sprosťárny","Nemluv sprostě!","No tak! žádné sprosťárny","Mluv slušně !","Bez těch sprosťáren prosím","Uklidni se"));
	}
		
	private function dotazNaCas($zprava){
		if(strpos($zprava, "kolik") !== false && strpos($zprava, "hodin") !== false)
			return true;
		else
			return false;
	}
	
	
	private function dotazNaNaladu($zprava){
		if(strpos($zprava, "jak") !== false && (strpos($zprava, "mas") !== false || strpos($zprava, "je") !== false) && strpos($zprava, "?") !== false)
			return true;
		else
			return false;
	}
	
	private function jeOsloveni($zprava){
		foreach($this->osloveni as $osloveni)
			if(strpos($zprava, $osloveni) !== false)
				return true;
		return false;
	}
	
	private function jePozdrav($zprava){
		foreach($this->pozdravy as $pozdrav)
			if(strpos($zprava, $pozdrav) !== false)
				return true;
		return false;
	}
	
	private function jeVulgarni($zprava){
		foreach($this->vulgarismy as $vulgarismus)
			if(strpos($zprava, $vulgarismus) !== false)
				return true;
		return false;
	}
	
	public static function OdstranDiakritiku($s){
		$s = preg_replace('#[^\x09\x0A\x0D\x20-\x7E\xA0-\x{2FF}\x{370}-\x{10FFFF}]#u', '', $s);
		$s = strtr($s, '`\'"^~', "\x01\x02\x03\x04\x05");
			if (ICONV_IMPL === 'glibc') {
				$s = @iconv('UTF-8', 'WINDOWS-1250//TRANSLIT', $s);
				$s = strtr($s, "\xa5\xa3\xbc\x8c\xa7\x8a\xaa\x8d\x8f\x8e\xaf\xb9\xb3\xbe\x9c\x9a\xba\x9d\x9f\x9e"
				. "\xbf\xc0\xc1\xc2\xc3\xc4\xc5\xc6\xc7\xc8\xc9\xca\xcb\xcc\xcd\xce\xcf\xd0\xd1\xd2\xd3"
				. "\xd4\xd5\xd6\xd7\xd8\xd9\xda\xdb\xdc\xdd\xde\xdf\xe0\xe1\xe2\xe3\xe4\xe5\xe6\xe7\xe8"
				. "\xe9\xea\xeb\xec\xed\xee\xef\xf0\xf1\xf2\xf3\xf4\xf5\xf6\xf8\xf9\xfa\xfb\xfc\xfd\xfe\x96",
                "ALLSSSSTZZZallssstzzzRAAAALCCCEEEEIIDDNNOOOOxRUUUUYTsraaaalccceeeeiiddnnooooruuuuyt-");
        } else {
         $s = @iconv('UTF-8', 'ASCII//TRANSLIT', $s);
         }
         $s = str_replace(array('`', "'", '"', '^', '~'), '', $s);
         return strtr($s, "\x01\x02\x03\x04\x05", '`\'"^~');
     }
	
	
	private function sendmessage(array $zprava){
		$msg = $zprava[array_rand($zprava)];
		$this->db->query("INSERT INTO chat (iduzivatele,text) VALUES (166,?)",array($msg));
	}
}
