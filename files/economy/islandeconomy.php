<?php
session_start();
mb_internal_encoding("UTF-8");
require_once "../classes/Database.class.php";
require_once "../cfg/host.php";
include "./objectdata.php";

$db = new Database(DB_HOST,DB_USER,DB_PASS,DB_NAME);

if(isset($_POST['idmesta']) && isset($_SESSION['prihlasen']))
{
$y = $db->queryOne("SELECT lastsave FROM accounts WHERE id=?",array(intval($_SESSION['prihlasen'])));
					
$cas = $y['lastsave'];
$comparedate=date("Y-m-d H:i:s",strtotime(" $cas +1 minutes "));

if(date("Y-m-d H:i:s") < $comparedate)
{
		exit;
}

if($_SERVER['HTTP_REFERER'] != WEB_ROOT . "/index.php?pid=game"){
	echo $_SERVER['HTTP_REFERER'];
	exit;
}
		
$Vinfrastruktura = 0;
$Vubytovani = 0;
$Vhotely = 0;
$Vostatni = 0;
$Vprumysl = 0;
$ubytovacimista = 0;
$soucetnajem = 0;
$maxpopulace = 0;
$soucasnapopulace = 0;
$pocatecnistav = 0;
$silnic = 0;
$budov = 0;
$Vzabavniprumysl = 0;

$pocettovaren = 0;
$Elektrifikovanomist = 0;
$nemocnic = 0;
$zabavniprumysl = 0;


//---------------------VYBRÁNÍ ÚDAJŮ O DANÉM OSTROVĚ------------------//
$result = $db->queryOne("SELECT id,idmajitele,mapa,oblibenost,soucasnapopulace,dane FROM islands WHERE id=?",array($_POST['idmesta']));

$vysedani = $result['dane'];
$soucasnapopulace = $result['soucasnapopulace'];
$oblibenost = $result['oblibenost'];
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////

//------------------------UDAJE O MAJITELI----------------------------//
$result2 = $db->queryOne("SELECT penize,uhli,ropa,dluh FROM accounts WHERE id=?",array($result['idmajitele']));

$pocatecnistav = $result2['penize'];
$vlastnik = $result['idmajitele'];
$uhli = $result2['uhli'];
$ropa = $result2['ropa'];
$dluh = $result2['dluh'];
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
$result3 = $db->queryOne("SELECT hodnota FROM sazby WHERE nazev='uroky'");
$uroky = $result3['hodnota'];
////////////////////////////////////////////////////////////////////////

//-------------------------ANALÝZA MAPY-------------------------------//
$policka = explode("|", $result['mapa']);
$domu = 0;
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
				$Vinfrastruktura -= $udrzba[$type][$item];
				$silnic ++;
			}
			else if($item ==10)
			{
				$Vinfrastruktura -= $udrzba[$type][$item];
				$silnic ++;
			}else{
				$Vostatni -= $udrzba[$type][$item];
			}
		}
		//-----------------BUDOVY-----------------------//
		else if($type == 1)
		{
			$domu++;
			$ubytovacimista += $kapacita[$item];
			$soucetnajem += $najem[$item] * $kapacita[$item];
			
			if($item == 0)
			{
				$Vinfrastruktura -= $udrzba[$type][$item];
				$maxpopulace += 200;
			}
			else if($item == 1 || $item == 2 || $item == 3)
			{
				$Vubytovani -= $udrzba[$type][$item];
			}
			else if($item == 4 || $item == 5)
			{
				$Vhotely -= $udrzba[$type][$item];
			}else{
				$Vostatni -= $udrzba[$type][$item];
			}
		}
		//---------------------------TOVÁRNY--------------------------//
		else if($type == 2)
		{
			if($item == 0)
			{
				$uhli += 50 + rand(0,40);
				$Vprumysl -= $udrzba[2][0]; 
				$pocettovaren++;
			}
			if($item == 1)
			{
				$Vprumysl -= $udrzba[2][1]; 
				
				if($uhli >= 70)
				{
					$Elektrifikovanomist += 1000;
					$uhli -= 65;
				}
				$pocettovaren++;
			}
			if($item == 2)
			{
				$maxpopulace += 1000;
				$Vinfrastruktura -= $udrzba[$type][$item];
			}
			if($item == 3)
			{
				$Vostatni -= $udrzba[$type][$item];
				$nemocnic ++;
			}
			if($item == 4)
			{
				$ropa += 25 + rand(0,10);
				$Vprumysl -= $udrzba[2][4]; 
				$pocettovaren++;
			}
			if($item == 5)
			{
				$Vzabavniprumysl -= $udrzba[2][5]; 
				$zabavniprumysl ++;
			}
			if($item == 6)
			{
				$domu ++;
				$Vhotely -= $udrzba[2][6]; 
				$ubytovacimista += 384;
				$soucetnajem += 15 * 384;
			}
		}
}


//-----------------------VÝPOČET PRŮMERU NÁJMŮ------------------------//
if($ubytovacimista != 0)
{
$prumernynajem =  $soucetnajem/$ubytovacimista;
}else{
$prumernynajem = 0;
}
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////

//-----------------------PŘÍJMY Z UBYTOVACÍCH ZAŘÍZENÍ----------------//
$Pubytovani = $soucasnapopulace * $prumernynajem;

////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////


//-----------------------PŘÍJMY Z DANÍ--------------------------------//
$Pdane = (($soucasnapopulace * (40 + rand(-5,5))) / 100) * $vysedani;

////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////






//----------------------ZMĚNA OBYVATELSTVA----------------------------//
$prirustek = 7;

if($oblibenost > 0)
	$prirustek ++;
if($oblibenost >= 10)
	$prirustek ++;
if($oblibenost >= 20)
	$prirustek ++;
if($oblibenost >= 40)
	$prirustek ++;
if($oblibenost >= 60)
	$prirustek ++;
	

if($vysedani > 19)
{
	$prirustek -= 2 * ($vysedani - 19);
}

if($vysedani < 15)
{
    $prirustek += $vysedani;	
}


if(($soucasnapopulace + $prirustek) > $ubytovacimista)
{
$soucasnapopulace = $ubytovacimista;
}else if($soucasnapopulace + $prirustek < 0)
{
	$soucasnapopulace = 0;
}
else{
$soucasnapopulace += $prirustek;
}
if($soucasnapopulace > $maxpopulace)
{
		$soucasnapopulace = $maxpopulace;
}

////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////

//---------------------MANIPULACE S OBLÍBENOSTÍ-----------------------//
$rn = rand(0,10);
if($rn == 0 && $vysedani < 15)
{
			$oblibenost ++;
}
else if($rn == 0 && $vysedani > 20)
{
			$oblibenost --;
}
else if($rn == 1 && (($soucasnapopulace - $Elektrifikovanomist) < 0))
{
			$oblibenost += 4;
}
else if($rn == 2 && $pocettovaren > 2)
{
				$oblibenost -= $pocettovaren;
}
else if($rn == 3 && $nemocnic > 1)
{
				$oblibenost += $nemocnic;
}
else if($rn == 4)
{
	if($zabavniprumysl > 4)
		$oblibenost += ($zabavniprumysl - 4);
	else if($zabavniprumysl < 2)
		$oblibenost -= 3;
}

////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////


//------------------------ÚROKY Z PŮJČKY------------------------------//
$Vuroky = -1 * (($dluh / 1000) * $uroky);
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////


$prijmy = "Ubytování:" . $Pubytovani  . "|DPH:" . $Pdane;
$vydaje = "Infrastruktura:" . $Vinfrastruktura . "|Ubytovny:" . round($Vubytovani,1) . "|Hotely:" . $Vhotely . "|Průmysl:" . $Vprumysl . "|Ostatní:" . $Vostatni . "|Úroky:" . $Vuroky . "|Zábavní průmysl:" . $Vzabavniprumysl; 
$zustatek = $pocatecnistav + $Vinfrastruktura + $Vubytovani + $Vhotely + $Pubytovani + $Pdane + $Vuroky - $Vzabavniprumysl;


//------------------------POKUTA ZA MALO INFRASTRUKTURY---------------//
if(($silnic * 4) < $domu)
{
		$Vmaloinfrastruktury = -1 * (($domu - ($silnic*4)) * 40);
		$vydaje .= "|Nedostatečná infrastruktura:" . $Vmaloinfrastruktury;
		$zustatek += $Vmaloinfrastruktury;
}
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////

if($pocatecnistav < 10000)
{
$queryy = $db->queryOne("SELECT hodnota FROM sazby WHERE nazev LIKE 'prispevekchudym'");	
$zustatek += $queryy['hodnota'];
$prijmy .= "|Příspěvek chudým:" . $queryy['hodnota'];
$db->query("UPDATE sazby SET hodnota=hodnota-? WHERE nazev LIKE 'stavrozpoctu'",array(intval($queryy['hodnota'])));
}


else if($pocatecnistav > 50000000)
{
$queryy = $db->queryOne("SELECT hodnota FROM sazby WHERE nazev LIKE 'danebohatych'");	
$zustatek -= $queryy['hodnota'];
$vydaje .= "|Daně pro zbohatlíky: -" . $queryy['hodnota'];
$db->query("UPDATE sazby SET hodnota =hodnota+".intval($queryy['hodnota'])." WHERE nazev LIKE 'stavrozpoctu'");
}

$db->query("UPDATE islands SET maxpopulace='".$maxpopulace."',soucasnapopulace='".$soucasnapopulace."',kapacita='".$ubytovacimista."',oblibenost='".$oblibenost."' WHERE id='".$_POST['idmesta']."'");
$db->query("UPDATE accounts SET penize='".$zustatek."',uhli='".$uhli."',ropa='".$ropa."',lastsave='".date("Y-m-d H:i:s")."' WHERE id='".$vlastnik."'");

if($db->queryOne("SELECT * FROM bankvypisy WHERE idostrova='".(int)$_POST['idmesta']."'") != false){
	$db->query("UPDATE bankvypisy SET pocatecnistav='".$pocatecnistav."',prijmy='".$prijmy."',vydaje='".$vydaje."',shrnuti='".$zustatek."' WHERE idostrova='".(int)$_POST['idmesta']."'");		
}else{
	$db->query("INSERT into bankvypisy (idostrova) VALUES ('".(int)$_POST['idmesta']."')");
	$db->query("UPDATE bankvypisy SET pocatecnistav='".$pocatecnistav."',prijmy='".$prijmy."',vydaje='".$vydaje."',shrnuti='".$zustatek."' WHERE idostrova='".(int)$_POST['idmesta']."'");		
}
//echo "Současná populace: " .$soucasnapopulace . "<br>";
//echo "Maximální populace: " .$maxpopulace . "<br>";
//echo "Ubytovací místa: " .$ubytovacimista . "<br>";
//echo "Průměrný nájem: " .$prumernynajem . "<br>";
//echo "poměr silnic/domů  " . $silnic . "/". $domu . "<br>";

echo $zustatek . "|" . $maxpopulace . "|" . $soucasnapopulace . "|" . $ubytovacimista . "|" . $oblibenost;
}
?>
