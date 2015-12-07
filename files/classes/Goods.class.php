<?php
class Goods{
	CONST N_COAL = "uhli";
	CONST P_COAL = "tun";
	
	CONST N_OIL = "ropa";
	CONST P_OIL = "barelů";
	
	CONST N_RUBY = "rubín";
	CONST P_RUBY = "rubínů";
	
	static function getUnit($x){
			if($x == self::N_COAL)
				return self::P_COAL;
			else if($x == self::N_OIL)
				return self::P_OIL;
			else if($x == self::N_RUBY)
				return self::P_RUBY;
	}
		
}

?>
