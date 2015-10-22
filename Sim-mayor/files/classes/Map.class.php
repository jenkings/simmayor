<?php
class Map
{
	public function newMap()
	{
		$map = "";
		$s = 0;

		for($x=0;$x<20;$x++)
		{
			for($y=0;$y<20;$y++)
			{
				$s = rand(0,2);
				$map .= $s .",0|";
			}
		}
		return $map;
	}
}
?>
