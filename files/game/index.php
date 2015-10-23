
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="game/style.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>


<div id="pozadi">
	
	
	<div id="tutbox">
		<img src="./game/img/tut/1.jpg" id="timg">
		<img src="./game/img/miniatury/next.png" id="nex" onclick="nexttut()" title="next">
	</div>
	
	<div id="ctrl">
		
		<div id="populace">
			<img src="./game/img/neutral.png" alt="oblibenost" id="favsmi">
			<div id="oblibenost">0</div>
		</div>
		
		<div id="money"></div>
		<div id="people"></div>
		<div id="transport"></div>
		
		<ul id="polozky">
			<li><img onClick="newmenu(1);" src="./game/img/miniatury/track.png" title="Silnice"></li>
			<li><img onClick="newmenu(2);" src="./game/img/miniatury/ground.png"  title="Povrchy"></li>
			<li><img onClick="newmenu(3);" src="./game/img/miniatury/transport.png"  title="Doprava"></li>
			<li><img onClick="newmenu(4);" src="./game/img/miniatury/small-houses.png" title="Ubytování"></li>
			<li><img onClick="newmenu(5);" src="./game/img/miniatury/factory.png" title="Prumysl"></li>
			<li><img onClick="newmenu(6);" src="./game/img/miniatury/health.png" title="Zdravotnictvi"></li>
			<li><img onClick='activeitem=0;activetype=50;' src="./game/img/miniatury/destroy.png" title="Demolice $500"></li>
		</ul>
		<br>
		<ul id="secondmenu">
		</ul>


		<div id="controll">
			<img id="nahoru" src="./game/img/arrow.png" onclick="moveB('down')" style="transform: rotate(90deg);-ms-transform: rotate(90deg);-webkit-transform: rotate(90deg);-o-transform: rotate(90deg);-moz-transform: rotate(90deg);"/>
			<img id="doleva" src="./game/img/arrow.png" onclick="moveB('right')" />
			<img id="dolu" src="./game/img/arrow.png" onclick="moveB('up')" style="transform: rotate(270deg);-ms-transform: rotate(270deg);-webkit-transform: rotate(270deg);-o-transform: rotate(270deg);-moz-transform: rotate(270deg);"/>
			<img id="doprava" src="./game/img/arrow.png" onclick="moveB('left')" style="transform: rotate(180deg);-ms-transform: rotate(180deg);-webkit-transform: rotate(180deg);-o-transform: rotate(180deg);-moz-transform: rotate(180deg);"/>
		</div>
		
		
		<img src="./game/img/miniatury/help.png" alt="help" id="hlp" onclick="document.getElementById('tutbox').style.display = 'block'">
		<img src="./game/img/miniatury/photo.png" alt="help" id="photo" onclick="var image = platno.toDataURL('image/png').replace('image/png', 'image/octet-stream');window.open(image);">
		
	</div>

	<canvas width="800" height="500" id="platno" oncontextmenu="return false;">
	   Váš prohlížeč nepodporuje tag canvas.
	</canvas>
	<div id="news">
		<div id="time"></div>
		<div id="tema"></div>
		<div id="zpr"></div>
	</div>

</div>

<?php
include "connect.php";
if(isset($_SESSION['aktivniostrov']))
{
	$x = mysql_fetch_array(mysql_query("SELECT * FROM islands WHERE id = '".intval($_SESSION['aktivniostrov'])."'"));
}
else
{
	$x = mysql_fetch_array(mysql_query("SELECT * FROM islands WHERE idmajitele = '".$_SESSION['prihlasen']."'"));
}
$ma = $x['mapa'];
$idmesta = $x['id'];


function __autoload($class_name) {include './classes/'.$class_name . '.class.php';}
include_once "./cfg/host.php";
$db = new Database(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$news= new News($db);
?>
<script>
var map = "<?php echo $ma?>";
var idmesta = "<?php echo $idmesta?>";

var maxpopulace = "<?php echo $x['maxpopulace']?>";
var soucasnapopulace = "<?php echo $x['soucasnapopulace']?>";
var celkovakapacita = "<?php echo $x['kapacita']?>";
var oblibenost = 1 * <?php echo $x['oblibenost']?>;

var de = "<?php echo $news->getNews();?>";
var newss = de.split("|");
</script>

<script type="text/javascript">
        window.onbeforeunload = Call;
        function Call() {
            save();
            return "Hra bude před odchoem uložena";
        }
        
        var document_root = "<?php echo WEB_ROOT ?>"; //předání docmentrootu pro ochranu serveru
 </script>

<?php
$x = mysql_fetch_array(mysql_query("SELECT * FROM accounts WHERE id = '".$_SESSION['prihlasen']."'"));
$mat = $x['penize'];
?>
<script>
var penizeX = <?php echo $mat?>;
</script>

<script src="game/itemy.js"></script>
<script src="game/player.js"></script>
<script src="game/Plane.js"></script>
<script src="game/funkce.js"></script>
<script src="game/core.js"></script>
<script src="game/mapa.js"></script>
<script src="game/images.js"></script>

<script>
setInterval(function(){renews()},1000);
</script>
