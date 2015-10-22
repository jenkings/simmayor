<?php
class Parser
{
	static function parse($x)
	{
	$text = preg_replace("#\[b\](.+?)\[/b\]#is", "<b>\\1</b>", $x);
	$text = preg_replace("#\[img\](.+?)\[/img\]#is", "<img src='\\1' style='max-width:500px;'>", $text);	
	$text = preg_replace("#\[i\](.+?)\[/i\]#is", "<i>\\1</i>", $text);	
	$text = preg_replace("#\[color\=(.+?)\\](.+?)\[/color\]#is", "<span style='color:\\1;'>\\2</span>", $text);	
	$text = preg_replace("#\:D#is", "<img src='../smiles/1.gif' alt='smile'>", $text);
	$text = preg_replace("#\:P#is", "<img src='../smiles/2.gif' alt='smile'>", $text);
	$text = preg_replace("#\:\)#is", "<img src='../smiles/3.gif' alt='smile'>", $text);
	$text = preg_replace("#\;\)#is", "<img src='../smiles/4.gif' alt='smile'>", $text);
	$text = preg_replace("#O\.o#is", "<img src='../smiles/5.gif' alt='smile'>", $text);
	$text = preg_replace("#\:BEER\:#is", "<img src='../smiles/6.gif' alt='smile'>", $text);
	$text = preg_replace("#\:\(#is", "<img src='../smiles/7.gif' alt='smile'>", $text);
	$text = preg_replace("#\:\/#is", "<img src='../smiles/8.gif' alt='smile'>", $text);

	$text = preg_replace("/\n/", "<br>", $text);
	return $text;
	}
	
	
}
?>
