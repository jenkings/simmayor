<?php
if(isset($_GET['ha']) && isset($_GET['hb']) && isset($_GET['hc']) && isset($_GET['hd']) && isset($_GET['he']) && isset($_GET['hf']))
{
	$vyska = 250;
	$sirka = 250;
	$image = imageCreateFromJpeg("graph.jpg");
	$cerna = ImageColorAllocate ($image, 0,0, 0);
	imagesetthickness($image, 3);
	imageline($image, 5, 245, 245, 245, $cerna);
	imageline($image, 5, 5, 5, 245, $cerna);
	imageline($image, 5, 5, 10, 5, $cerna);
	imageline($image, 5, 65, 10, 65, $cerna);
	imageline($image, 5, 125, 10, 125, $cerna);
	imageline($image, 5, 185, 10, 185, $cerna);
	$max = bigest(array($_GET['ha'],$_GET['hb'],$_GET['hc'],$_GET['hd'],$_GET['he'],$_GET['hf']));
	$meritko = 230 / $max;
	$u = 240 - ($_GET['ha'] * $meritko);
	$v = 240 - ($_GET['hb'] * $meritko);
	$w = 240 - ($_GET['hc'] * $meritko);
	$x = 240 - ($_GET['hd'] * $meritko);
	$y = 240 - ($_GET['he'] * $meritko);
	$z = 240 - ($_GET['hf'] * $meritko);
	$cerna = ImageColorAllocate ($image, 255,0, 0);
	imageline($image, 5, $u, 55, $v, $cerna);
	imageline($image, 55, $v, 105, $w, $cerna);
	imageline($image, 105, $w, 155, $x, $cerna);
	imageline($image, 155, $x, 205, $y, $cerna);
	imageline($image, 205, $y, 245, $z, $cerna);
	$cerna = ImageColorAllocate ($image, 50,50, 50);
	imagettftext($image, 10, 0, 12, 13, $cerna, "./arial.ttf", "$" . $max);
	imagettftext($image, 10, 0, 12, 73, $cerna, "./arial.ttf", "$" . ($max/4)*3);
	imagettftext($image, 10, 0, 12, 133, $cerna, "./arial.ttf", "$" . $max/2);
	imagettftext($image, 10, 0, 12, 193, $cerna, "./arial.ttf", "$" . $max/4);
	header('Content-type: image/png');
	ImageJpeg ($image);
	ImageDestroy($image);
}
function bigest($s)
{
	sort($s);
	return $s[5];
}
?>
