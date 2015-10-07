<!DOCTYPE html>
<html>
<head>	
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="regstyle.css">
<title>SimMayor</title>

<script>
var reg = "<form action='reglog.php' method='post' id='f1'><div class='popisek'>Jméno</div><input type='text' size='10' name='nick' value='Jméno' onclick='if(!this.__click) {this.__click = true;this.value = \"\"}'><div class='popisek'>Heslo</div><input type='password' size='10' name='password1' value='heslo1' onclick='if(!this.__click) {this.__click = true;this.value = \"\"}'><div class='popisek'>Heslo znovu</div><input type='password' size='10' name='password2' value='heslo2' onclick='if(!this.__click) {this.__click = true;this.value = \"\"}'><img style='float:left;' src='./captcha/captcha_code_file.php?rand=\".rand()' id='captchaimg'><br><br><br><br><div class='popisek'>Opiš kód</div><input size='10' id='6_letters_code' name='6_letters_code' value='KÓD' type='text'><br><input type='hidden' name='password3' value='heslo3'><input type='submit' id='send' value='Registrovat'></form><p>registrací souhlasíte s <a href='./podminky.php'>podmínkami</a>.</p>";
var log = "<form action='reglog.php' method='post' id='f2'><div class='popisek'>Jméno</div><input type='text' size='10' name='nick' value='Jméno' onclick='if(!this.__click) {this.__click = true;this.value = \"\"}'><div class='popisek'>Heslo</div><input type='password' size='10' name='password' value='heslo' onclick='if(!this.__click) {this.__click = true;this.value = \"\"}'><input type='submit' id='send' value='Přihlásit'></form>	";



function switchto(x)
{
		if(x == 0)
		{
				document.getElementById("reglog").innerHTML = reg;
				document.getElementById("reg").style.backgroundColor="#FFFFFF";
				document.getElementById("log").style.backgroundColor="transparent";
				document.getElementById("reg").style.color="#241d03";
				document.getElementById("log").style.color="#FFFFFF";	
		}
		else{
				document.getElementById("reglog").innerHTML = log;
				document.getElementById("reg").style.backgroundColor="transparent";
				document.getElementById("log").style.backgroundColor="#FFFFFF";
				document.getElementById("reg").style.color="#FFFFFF";
				document.getElementById("log").style.color="#241d03";
		}
}

</script>

</head>

<body>

<header>
	<img src="logo2.png" alt="logo">
</header>

<div id="page">

	
	<div id="content">
		
		<div id='switches'><div class='prepinac' id='reg' onclick='switchto(0)'>Registrace</div><div class='prepinac' id='log' onclick='switchto(1)'>Přihlášení</div></div>

		<div id='reglog'>	
					<script>switchto(0)</script>
		</div>
		

	</div>

</div>

<footer>Copyright Jan "Jenkings" Škoda | Code by <a href="http://jenkings.eu">Jenkings</a> | Design by <a href="#">Ex_0</footer>
<?php include "analytics.php";?>
</body>
</html>



