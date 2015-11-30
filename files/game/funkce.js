function isInTrojuhelnik(sx,sy,ax,ay,bx,by,cx,cy)
{
    var as_x = sx-ax;
    var as_y = sy-ay;

    var s_ab = (bx-ax)*as_y-(by-ay)*as_x > 0;

    if((cx-ax)*as_y-(cy-ay)*as_x > 0 == s_ab) return false;

    if((cx-bx)*(sy-by)-(cy-by)*(sx-bx) > 0 != s_ab) return false;

    return true;
}

function renews()
{
	var d=new Date();
	var t=d.toLocaleTimeString();
	document.getElementById("time").innerHTML=t;

	if(d.getSeconds() == 10 || d.getSeconds() == 40)
	{
		var or = Math.floor((Math.random()*(newss.length)));
		var prac = newss[or].split("@");
		
		if(prac[0] == 1)
		{
				document.getElementById("tema").style.backgroundColor="red";
				document.getElementById("tema").innerHTML="Ekonomika";
		}
		if(prac[0] == 2)
		{
				document.getElementById("tema").style.backgroundColor="grey";
				document.getElementById("tema").innerHTML="Technika";
		}
		if(prac[0] == 3)
		{
				document.getElementById("tema").style.backgroundColor="green";
				document.getElementById("tema").innerHTML="SPORT";
		}
		if(prac[0] == 4)
		{
				document.getElementById("tema").style.backgroundColor="brown";
				document.getElementById("tema").innerHTML="Svět";
		}
		if(prac[0] == 5)
		{
				document.getElementById("tema").style.backgroundColor="purple";
				document.getElementById("tema").innerHTML="Z domova";
		}
		
		document.getElementById("zpr").innerHTML=prac[1];
	}
}

function newplane()
{
	switch (Math.floor((Math.random()*3)+1))
	{
	case 1:
	  plane = new Plane(-500,100,4,2);	
	  break;
	case 2:
	  plane = new Plane(900,1000,-4,-2);	
	  break;
	case 3:
	  plane = new Plane(-500,500,3,1);		
	  break;
	}
	
}


function nexttut()
{
	if(tutstatus == 1)
	{
		document.getElementById("timg").src = "./game/img/tut/2.jpg";
		tutstatus ++;
	}
	else if(tutstatus == 2)
	{
		document.getElementById("timg").src = "./game/img/tut/3.jpg";
		tutstatus ++;
	}
	else if(tutstatus == 3)
	{
		document.getElementById("timg").src = "./game/img/tut/4.jpg";
		tutstatus ++;
	}
	else if(tutstatus == 4)
	{
		document.getElementById("timg").src = "./game/img/tut/5.jpg";
		tutstatus ++;
	}
	else if(tutstatus == 5)
	{
		document.getElementById("timg").src = "./game/img/tut/6.jpg";
		tutstatus ++;
	}
	else if(tutstatus == 6)
	{
			document.getElementById("timg").src = "./game/img/tut/1.jpg";
			document.getElementById('tutbox').style.display = 'none';
			tutstatus = 1;
	}

}



function getsmile(x)
{
		if(x > 50)
			return "good";
		else if(x < -50)
			return "bad";
		else
			return "neutral";
}

function formatDollar(num) {
    var p = num.toFixed(2).split(".");
    return "$" + p[0].split("").reverse().reduce(function(acc, num, i, orig) {
        return  num + (i && !(i % 3) ? " " : "") + acc;
    }, "") + "." + p[1];
}

function formatMoney(num) {
    var p = num.toFixed(2).split(".");
    return  p[0].split("").reverse().reduce(function(acc, num, i, orig) {
        return  num + (i && !(i % 3) ? " " : "") + acc;
    }, "") + "." + p[1];
}


function getMousePos(canvas, evt) {
        var rect = canvas.getBoundingClientRect();
        return {
          x: evt.clientX - rect.left,
          y: evt.clientY - rect.top
        };
      }
      
function moveView(x)
{
		if(x == "up")
		{
			zY-=20;
		}
		else if(x == "down")
		{
			zY+=20;
		}
		else if(x == "left")
		{
			zX-=20;
		}
		else if(x == "right")
		{
			zX+=20;
		}
}

function moveB(x)
{
		if(x == "up")
		{
			zY-=20;
		}
		else if(x == "down")
		{
			zY+=20;
		}
		else if(x == "left")
		{
			zX-=20;
		}
		else if(x == "right")
		{
			zX+=20;
		}
}

function drawRotatedImage(image, x, y, angle,ID,type) { 
	context.save(); 
	context.translate(x, y);
	context.rotate(angle * (Math.PI/180));
	
	if(type == 0)
		context.drawImage(image,0,ID*40,40,40, -(20), -(20),40,40);
	else if(type == 1)
		context.drawImage(image,0,ID*80,80,80, -(40), -(40),80,80);	

	else if(type == 21)
		context.drawImage(image,0,(ID*120)+80,120,40, -(59), 19,120,40);
	else if(type == 22)
		context.drawImage(image,0,ID*120,120,80, -(60), -(20),120,80);
	
	
	context.restore(); 
}

function drawVehicle(image, x, y, angle) { 
	context.save(); 
	context.translate(x, y);
	context.rotate(angle);
	context.drawImage(image, -(image.width/2), -(image.height/2));
	context.restore(); 
}

function checkKey(e) {
	e = e || window.event;
	if (e.keyCode == '38') {
		moveView("down");
		return false;
	}
	else if (e.keyCode == '40') {
		moveView("up");
		return false;
	}
	else if (e.keyCode == '39') {
		moveView("left");
		return false;
	}
	else if (e.keyCode == '37') {
		moveView("right");
		return false;
	}
}

function aktivniPolozka(active) {
    $("#polozky").find("img").css("opacity", "1");
    $("#secondmenu").find("img").css("opacity", "1");
    $(active).css("opacity", "0.5");
}
$(document).ready(function() {
    $("#polozky").find("img").click(function() {
        aktivniPolozka(this);
	$("#secondmenu").find("img").click(function() {
	    aktivniPolozka(this);
	});
    });
    $("#secondmenu").find("img").click(function() {
        aktivniPolozka(this);
    });
});

function build(xx,yy,ai,at)
{
		if(hrac.getMoney() >= ceny[at][ai])
		{
			if(canbuild(xx,yy,ai,at))
			{
				if(at == 0)
				{
					mapa[xx][yy] = new Item(ai,at);
					hrac.GiveMoney(-ceny[at][ai]);
				}else if (at == 1){	
						mapa[xx][yy] = new Item(9,0);
						hrac.GiveMoney(-ceny[at][ai]);	
						setTimeout(function(){construct(xx,yy,0,ai,at)},1000);
				}else if (at == 2){	
						mapa[xx][yy] = new Item(9,0);
						mapa[xx-1][yy] = new Item(9,0);
						mapa[xx][yy-1] = new Item(9,0);
						mapa[xx-1][yy-1] = new Item(9,0);
						hrac.GiveMoney(-ceny[at][ai]);	
						setTimeout(function(){construct(xx,yy,0,ai,at)},1000);
				}
			}
		}		
}

function construct(xx,yy,progress,building,type)
{
		if(progress == 7)
		{
			if(mapa[xx][yy].getType() == 0 && mapa[xx][yy].getItem() == 9)
			{
				mapa[xx][yy] = new Item(building,type);
				if(type == 2)
				{
						mapa[xx-1][yy] = new Item(0,0)
						mapa[xx][yy-1] = new Item(0,0)
						mapa[xx-1][yy-1] = new Item(0,0)
				}
				
			}
				
		}else{
		setTimeout(function(){construct(xx,yy,progress+1,building,type)},1000);
		}
}


function newmenu(ktere)
{
	var string = "";
	switch(ktere)
	{
		case 1:
			string += "<li><img onClick='activeitem=3;activetype=0;' src=\"./game/img/miniatury/rovina1.png\"title='"+ nazvy[0][3] + " $" + ceny[0][3] +"'></li>";
			string += "<li><img onClick='activeitem=4;activetype=0;' src=\"./game/img/miniatury/rovina2.png\" title='"+ nazvy[0][4] + " $" + ceny[0][4] +"'></li>";
			string += "<li><img onClick='activeitem=5;activetype=0;' src=\"./game/img/miniatury/zatacka.png\" style=\"-webkit-transform: rotate(320deg); -moz-transform: rotate(320deg); -o-transform: rotate(320deg);-ms-transform: rotate(320deg); \" title='"+ nazvy[0][5] + " $" + ceny[0][5] +"'></li>";
			string += "<li><img onClick='activeitem=6;activetype=0;' src=\"./game/img/miniatury/zatacka.png\" style=\"-webkit-transform: rotate(30deg); -moz-transform: rotate(30deg); -o-transform: rotate(30deg);-ms-transform: rotate(30deg); \" title='"+ nazvy[0][6] + " $" + ceny[0][6] +"'></li>";
			string += "<li><img onClick='activeitem=7;activetype=0;' src=\"./game/img/miniatury/zatacka.png\" style=\"-webkit-transform: rotate(120deg); -moz-transform: rotate(120deg); -o-transform: rotate(120deg);-ms-transform: rotate(120deg); \" title='"+ nazvy[0][7] + " $" + ceny[0][7] +"'></li>";
			string += "<li><img onClick='activeitem=8;activetype=0;' src=\"./game/img/miniatury/zatacka.png\" style=\"-webkit-transform: rotate(210deg); -moz-transform: rotate(210deg); -o-transform: rotate(210deg);-ms-transform: rotate(210deg); \" title='"+ nazvy[0][8] + " $" + ceny[0][8] +"'></li>";
			string += "<li><img onClick='activeitem=10;activetype=0;' src=\"./game/img/miniatury/krizovatka.png\" title='"+ nazvy[0][10] + " $" + ceny[0][10] +"'></li>";

			document.getElementById("secondmenu").innerHTML = string;
		break;
		case 2:
			string += "<li><img onClick='activeitem=0;activetype=0;' src=\"./game/img/miniatury/grass.png\" title='"+ nazvy[0][0] + " $" + ceny[0][0] +"'></li>";
			string += "<li><img onClick='activeitem=1;activetype=0;' src=\"./game/img/miniatury/dirt.png\" title='"+ nazvy[0][1] + " $" + ceny[0][1] +"'></li>";
			string += "<li><img onClick='activeitem=2;activetype=0;' src=\"./game/img/miniatury/snow.png\" title='"+ nazvy[0][2] + " $" + ceny[0][2] +"'></li>";
			document.getElementById("secondmenu").innerHTML = string;
		break;
		
		case 3:
			string += "<li><img onClick='activeitem=0;activetype=1;' src=\"./game/img/miniatury/pristav.png\" title='"+ nazvy[1][0] + " $" + ceny[1][0] +"'></li>";
			string += "<li><img onClick='activeitem=2;activetype=2;' src=\"./game/img/miniatury/letiste.png\" title='"+ nazvy[2][2] + " $" + ceny[2][2] +"'></li>";		
			document.getElementById("secondmenu").innerHTML = string;
		break;
		
		
		case 4:
			string += "<li><img onClick='activeitem=2;activetype=1;' src=\"./game/img/miniatury/stany.png\" title='"+ nazvy[1][2] + " $" + ceny[1][2] +"'></li>";
			string += "<li><img onClick='activeitem=1;activetype=1;' src=\"./game/img/miniatury/chatky.png\" title='"+ nazvy[1][1] + " $" + ceny[1][1] +"'></li>";
			string += "<li><img onClick='activeitem=3;activetype=1;' src=\"./game/img/miniatury/domek.png\" title='"+ nazvy[1][3] + " $" + ceny[1][3] +"'></li>";
			string += "<li><img onClick='activeitem=4;activetype=1;' src=\"./game/img/miniatury/hotylek.png\" title='"+ nazvy[1][4] + " $" + ceny[1][4] +"'></li>";
			string += "<li><img onClick='activeitem=5;activetype=1;' src=\"./game/img/miniatury/hotel.png\" title='"+ nazvy[1][4] + " $" + ceny[1][4] +"'></li>";
			string += "<li><img onClick='activeitem=6;activetype=2;' src=\"./game/img/miniatury/luxhotel.png\" title='"+ nazvy[2][6] + " $" + ceny[2][6] +"'></li>";		
			document.getElementById("secondmenu").innerHTML = string;
		break;
		
		case 5:
			string += "<li><img onClick='activeitem=0;activetype=2;' src=\"./game/img/miniatury/dul.png\" title='"+ nazvy[2][0] + " $" + ceny[2][0] +"'></li>";
			string += "<li><img onClick='activeitem=1;activetype=2;' src=\"./game/img/miniatury/elektrarna.png\" title='"+ nazvy[2][1] + " $" + ceny[2][1] +"'></li>";
			string += "<li><img onClick='activeitem=4;activetype=2;' src=\"./game/img/miniatury/ropnepole.png\" title='"+ nazvy[2][4] + " $" + ceny[2][4] +"'></li>";
			document.getElementById("secondmenu").innerHTML = string;
		break;
		
		case 6:
			string += "<li><img onClick='activeitem=3;activetype=2;' src=\"./game/img/miniatury/nemocnice.png\" title='"+ nazvy[2][3] + " $" + ceny[2][3] +"'></li>";		
			string += "<li><img onClick='activeitem=5;activetype=2;' src=\"./game/img/miniatury/stadion.png\" title='"+ nazvy[2][5] + " $" + ceny[2][5] +"'></li>";		
			document.getElementById("secondmenu").innerHTML = string;
		break;
	}
}

function canbuild(xx,yy,ai,at)
{
	if(ai == 0 && at == 1 && yy != 0)
	{
		return false;
	}
	else if(mapa[xx][yy].getType() == 1 || mapa[xx][yy].getType() == 2)
	{
		return false;
	}
	else if(mapa[xx][yy].getItem() > 2)
	{
		return false;
	}	
	else if(at == 2 && xx == 0)
	{
		return false
	}
	else if(at == 2 && yy == 0)
	{
		return false
	}
	else if(at == 2 && (mapa[xx][yy].getType() > 0 || mapa[xx-1][yy].getType() > 0 || mapa[xx][yy-1].getType() > 0 || mapa[xx-1][yy-1].getType() > 0))
	{
			return false
	}
	else if(at == 2 && (mapa[xx][yy].getItem() > 2 || mapa[xx-1][yy].getItem() > 2 || mapa[xx][yy-1].getItem() > 2 || mapa[xx-1][yy-1].getItem() > 2))
	{
			return false
	}
	
	// tyto musi byt posledni
	else if(xx == (MAPSIZE_X-1) || yy == (MAPSIZE_Y-1))
	{
		return true;
	}
	else if(mapa[xx+1][yy+1].getType() == 2 || mapa[xx][yy+1].getType() == 2 || mapa[xx+1][yy].getType() == 2)
	{
			return false;
	}
	else
		return true;
}

function destroy(xx,yy)
{
	if(hrac.getMoney() >= 500)
	{
		mapa[xx][yy] = new Item(0,0);
		hrac.GiveMoney(-500);
	}
}

function save()
{
	var String = "";
	var prachy = hrac.getMoney();
	for(var x=0;x<MAPSIZE_X;x++)
	{
		for(var y=0;y<MAPSIZE_Y;y++)
		{
			String += mapa[x][y].getItem() + "," + mapa[x][y].getType() + "|";
		}
	}

	$.ajax ({
	   type: "POST",
	   url:document_root+"/game/save.php",
	   data: {String:String,idmesta:idmesta,prachy:prachy},
	   success: function() {
		  //console.log("save");
	   }
	});
	
}

function economics()
{
		save();
		var prachy = hrac.getMoney();
		$.ajax ({
		type: "POST",
		url:document_root+"/economy/islandeconomy.php",
		data: {idmesta:idmesta},
		success: function(data) {	  
			var n=data.split("|");
				hrac.SetMoney(parseInt(n[0]));
				maxpopulace = parseInt(n[1]);
				soucasnapopulace = parseInt(n[2]);
				celkovakapacita = parseInt(n[3]);
				oblibenost = 1 * parseInt(n[4]);
          
	   }
	});
}
