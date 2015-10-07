<?php

$zbohatlici = mysql_result(mysql_query("SELECT COUNT(*) FROM accounts WHERE penize > 50000000"),0) or die(mysql_error());	
$strednitrida = mysql_result(mysql_query("SELECT COUNT(*) FROM accounts WHERE penize > 10000 AND penize < 50000000"),0) or die(mysql_error());
$chudi = mysql_result(mysql_query("SELECT COUNT(*) FROM accounts WHERE penize < 10000"),0) or die(mysql_error());

echo "var tridy = new Array()\n";
echo "tridy[0] = " . $zbohatlici .";\n";
echo "tridy[1] = " . $strednitrida .";\n";
echo "tridy[2] = " . $chudi .";\n";


?>
