<?php
include "./economy/objectdata.php";
include "./connect.php";

if(isset($_SESSION['aktivniostrov']))
{
$result = mysql_fetch_array(mysql_query("SELECT id,idmajitele,mapa,oblibenost,soucasnapopulace,dane FROM islands WHERE id='".(int)$_SESSION['aktivniostrov']."'"));
}
else
{
$result = mysql_fetch_array(mysql_query("SELECT id,idmajitele,mapa,oblibenost,soucasnapopulace,dane FROM islands WHERE idmajitele='".(int)$_SESSION['prihlasen']."'"));
}



$silnic = 0;
$domu = 0;
$ubytovacimista = 0;
$maxpopulace = 0;
$pocettovaren = 0;
$nemocnic = 0;
$zabavniprumysl = 0;
 
$policka = explode("|", $result['mapa']);
for($f=0;$f<(sizeof($policka) - 1);$f++)
{
		$detail = explode(",", $policka[$f]);
		$item = $detail['0'];
		$type = $detail['1'];	
		//---------POVRCHY------------//
		if($type == 0)
		{
			if($item >=3 && $item <= 8)
			{
				$silnic ++;
			}
			else if($item ==10)
			{
				$silnic ++;
			}
		}
		//-----------------BUDOVY-----------------------//
		else if($type == 1)
		{
			$domu++;
			$ubytovacimista += $kapacita[$item];
			
			if($item == 0)
			{
				$maxpopulace += 200;
			}
		}
		//---------------------------TOVÁRNY--------------------------//
		else if($type == 2)
		{
			if($item == 0)
			{
				$pocettovaren++;
			}
			if($item == 1)
			{
				$pocettovaren++;
			}
			if($item == 2)
			{
				$maxpopulace += 1000;
			}
			if($item == 3)
			{
				$nemocnic ++;
			}
			if($item == 4)
			{
				$pocettovaren++;
			}
			if($item == 5)
			{
				$zabavniprumysl ++;
			}
			if($item == 6)
			{
				$ubytovacimista += 384;
			}
		}
}
echo "<script>";
echo "var zpravy = new Array();\n";

if($pocettovaren > 2)
{
	echo "zpravy.push(\"Pokud chcete na ostrově id:" . $result['id'] . " zvýšit \\n oblíbenost, budete muset zbourat\\nněkteré továrny.\")\n";
}

if(($ubytovacimista - $maxpopulace) > 50)
{
	echo "zpravy.push(\"Na ostrově id:" . $result['id'] . " Máte víc\\nubytovacích míst,než kolik jste schopen\\n na ostrov dopravit lidí.\")\n";
}
if($nemocnic < 2)
{
	echo "zpravy.push(\"Pokud chcete na ostrově id:" . $result['id'] . " zvýšit \\noblíbenost, budete muset postavit\\nnemocnici.\")\n";
}
echo "</script>";


?>
<canvas id="platno" width="400" height="250" onload="start()"></canvas>

<script>
	
	
radce = new Image();
radce.src = "radce.png";
var faze = 0;

function newtip()
{
var canvas = document.getElementById('platno');
var context = canvas.getContext('2d');	

context.fillStyle="#FFFFFF";
context.fillRect(0,0,400,250);


context.drawImage(radce,0,55);

context.fillStyle="#FF0000";
roundRect(context, 150, 60, 250, 80, 10, true, true);



	
context.fillStyle="#000000";
var n=zpravy[faze].split("\n");
		
for(var s=0;s<n.length;s++)
{
	context.fillStyle="#000000";
	context.fillText(n[s],160,80+(s*20));
}


if(faze == (zpravy.length-1))
	faze = 0;
else
	faze++;


setTimeout(function(){newtip()},6000);
}








function roundRect(ctx, x, y, width, height, radius, fill, stroke) {
  if (typeof stroke == "undefined" ) {
    stroke = true;
  }
  if (typeof radius === "undefined") {
    radius = 5;
  }
  ctx.beginPath();
  ctx.moveTo(x + radius, y);
  ctx.lineTo(x + width - radius, y);
  ctx.quadraticCurveTo(x + width, y, x + width, y + radius);
  ctx.lineTo(x + width, y + height - radius);
  ctx.quadraticCurveTo(x + width, y + height, x + width - radius, y + height);
  ctx.lineTo(x + radius, y + height);
  ctx.quadraticCurveTo(x, y + height, x, y + height - radius);
  ctx.lineTo(x, y + radius);
  ctx.quadraticCurveTo(x, y, x + radius, y);
  ctx.closePath();
  if (stroke) {
    ctx.stroke();
  }
}

</script>
