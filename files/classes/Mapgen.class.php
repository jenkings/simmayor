<?php
require_once "./cfg/game-limits.php";
class Mapgen{
	public function createMap(){
		$map = "";
		$s = 0;

		for($x=0;$x<ISLAND_SIZE;$x++)
		{
			for($y=0;$y<ISLAND_SIZE;$y++)
			{
				$s = rand(0,2);
				$map .= $s .",0|";
			}
		}
		return $map;
	}
}

?>
