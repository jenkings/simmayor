<?php
session_start();
Header("content-type: application/x-javascript");
require_once "../classes/Database.class.php";
require_once "../classes/News.class.php";
require_once "../cfg/host.php";

$db = new Database(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$news= new News($db);
if(isset($_SESSION['aktivniostrov'])){
	$x = $db->queryOne("SELECT * FROM islands WHERE id = ?",array(intval($_SESSION['aktivniostrov'])));
}
else{
	$x =  $db->queryOne("SELECT * FROM islands WHERE idmajitele = ?",array($_SESSION['prihlasen']));
}
$ma = $x['mapa'];
$idmesta = $x['id'];
?>

var map = "<?php echo $ma?>";
var idmesta = "<?php echo $idmesta?>";

var maxpopulace = "<?php echo $x['maxpopulace']?>";
var soucasnapopulace = "<?php echo $x['soucasnapopulace']?>";
var celkovakapacita = "<?php echo $x['kapacita']?>";
var oblibenost = 1 * <?php echo $x['oblibenost']?>;

var de = "<?php echo $news->getNews();?>";
var newss = de.split("|");



window.onbeforeunload = Call;
function Call() {
	save();
	return "Hra bude před odchoem uložena";
}
        
var document_root = "<?php echo WEB_ROOT ?>"; //předání docmentrootu pro ochranu serveru


<?php
$x = $db->queryOne("SELECT * FROM accounts WHERE id = ?",array($_SESSION['prihlasen']));
$mat = $x['penize'];
?>
var penizeX = <?php echo $mat?>;
