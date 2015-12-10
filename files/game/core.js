var canvas = document.getElementById("platno");
var context = canvas.getContext("2d");
var zX = 300;
var zY = -300; 
var moving = 0;
var active = new Array(2);
var tutstatus = 1;
var activeitem = 0;
var activetype = 0;

var plane = null;

var hrac = new Player(1 * penizeX);

var x = 0;

function vykresli()
{
context.fillStyle = "#115577";
context.fillRect(0, 0, 800, 500);

	for(var y=0;y<MAPSIZE_Y;y++)
	{
		for(var x=0;x<MAPSIZE_X;x++)
		{
			if(active[0] == x && active[1] == y)
				context.globalAlpha = 0.6;
			else
				context.globalAlpha = 1;
			
			if(mapa[x][y].getType() == 0)
			{
				if(y != (MAPSIZE_Y - 1) && mapa[x][y+1].getType() == 2)
				{
					drawRotatedImage(bigbudovy, ((x*55) + 50) - (x*28) - (y*27) + zX, ((y*55)+55) + (x*27) - (y*28) + zY - 56, 45,mapa[x][y+1].getItem(),22);
				}
				
				else if(x != (MAPSIZE_X - 1) && mapa[x+1][y].getType() != 2)
				{
				drawRotatedImage(povrchy, ((x*55) + 50) - (x*28) - (y*27) + zX, ((y*55)+55) + (x*27) - (y*28) + zY , 45,mapa[x][y].getItem(),mapa[x][y].getType());
				}else{
				drawRotatedImage(povrchy, ((x*55) + 50) - (x*28) - (y*27) + zX, ((y*55)+55) + (x*27) - (y*28) + zY , 45,mapa[x][y].getItem(),mapa[x][y].getType());	
				}
			}
			
			
			else if(mapa[x][y].getType() == 1){
				drawRotatedImage(budovy, ((x*55) + 50) - (x*28) - (y*27) + zX, ((y*55)+55) + (x*27) - (y*28) + zY - 29, 45,mapa[x][y].getItem(),mapa[x][y].getType());
			}
			
			
			
			else if(mapa[x][y].getType() == 2){
				drawRotatedImage(bigbudovy, ((x*55) + 50) - (x*28) - (y*27) + zX, ((y*55)+55) + (x*27) - (y*28) + zY - 56, 45,mapa[x][y].getItem(),21);			
			}
		}	
	}
	
	
if(plane != null)
{
	if(plane.OnMap() == true)
	{
		drawVehicle(letadlo,plane.getX()+zX,plane.getY()+zY,plane.getAngle());
		plane.Update();
	}
	else
	{
			plane = null;
	}
}else{
	newplane();
}

document.getElementById("money").innerHTML = formatMoney(hrac.getMoney());
document.getElementById("people").innerHTML = soucasnapopulace + "/" + celkovakapacita;
document.getElementById("transport").innerHTML = maxpopulace;
document.getElementById("favsmi").src="./game/img/" + getsmile(oblibenost) + ".png";
document.getElementById("oblibenost").innerHTML = oblibenost;
}



function getNearest(xx,yy)
{
		while(xx < MAPSIZE_X)
		{
				xx++;
				if(mapa[xx][yy].getType()==0)
					return xx;
					break;
		}
		return (MAPSIZE_X-1);
}

document.onkeydown = checkKey;

      canvas.addEventListener('mousemove', function(evt) {
        var mousePos = getMousePos(canvas, evt);	

		l1:
		for(var x=0;x<MAPSIZE_X;x++)
		{
			l2:
			for(var y=0;y<MAPSIZE_Y;y++)
			{
				if(isInTrojuhelnik(mousePos.x,mousePos.y,23 - (y*27) + (x*27) + zX,55 + (y*27) + (x*27) + zY,77 - (y*27) + (x*27) + zX,55 + (y*27) + (x*27) + zY,50 - (y*27) + (x*27) + zX,30 + (y*27) + (x*27) + zY) 
				|| isInTrojuhelnik(mousePos.x,mousePos.y,23 - (y*27) + (x*27) + zX,55 + (y*27) + (x*27) + zY,77 - (y*27) + (x*27) + zX,55 + (y*27) + (x*27) + zY,50 - (y*27) + (x*27) + zX,80 + (y*27) + (x*27) + zY) )
				{
					
					active[0] = x;
					active[1] = y;
					
					break l1;
					break l2;
				}else{
					active[0] = -1;
					active[1] = -1;
				}
				
			}	
		}
	
      }, false);
      
      
      

      canvas.addEventListener('click', function(evt) {
        var mousePos = getMousePos(canvas, evt);	
		console.log(mousePos.x + "|" + mousePos.y);
		l1:
		for(var x=0;x<MAPSIZE_X;x++)
		{
			l2:
			for(var y=0;y<MAPSIZE_Y;y++)
			{
				if(isInTrojuhelnik(mousePos.x,mousePos.y,30 - (y*27) + (x*27) + zX,61 + (y*27) + (x*27) + zY,81 - (y*27) + (x*27) + zX,61 + (y*27) + (x*27) + zY,56 - (y*27) + (x*27) + zX,36 + (y*27) + (x*27) + zY) || isInTrojuhelnik(mousePos.x,mousePos.y,30 - (y*27) + (x*27) +zX,61 + (y*27) + (x*27) +zY,81 - (y*27) + (x*27) +zX,61 + (y*27) + (x*27) +zY,56 - (y*27) + (x*27) +zX,87 + (y*27) + (x*27) +zY))
				{		
					if(activetype == 50)
					{
						destroy(x,y);
					}else{
					build(x,y,activeitem,activetype);
					}
					break l1;
					break l2;
				}
				
			}	
		}
	
      }, false);
      
      
      
      canvas.addEventListener('contextmenu', function(evt) {
        var mousePos = getMousePos(canvas, evt);	

		l1:
		for(var x=0;x<MAPSIZE_X;x++)
		{
			l2:
			for(var y=0;y<MAPSIZE_Y;y++)
			{
				if(isInTrojuhelnik(mousePos.x,mousePos.y,30 - (y*27) + (x*27) + zX,61 + (y*27) + (x*27) + zY,81 - (y*27) + (x*27) + zX,61 + (y*27) + (x*27) + zY,56 - (y*27) + (x*27) + zX,36 + (y*27) + (x*27) + zY) || isInTrojuhelnik(mousePos.x,mousePos.y,30 - (y*27) + (x*27) +zX,61 + (y*27) + (x*27) +zY,81 - (y*27) + (x*27) +zX,61 + (y*27) + (x*27) +zY,56 - (y*27) + (x*27) +zX,87 + (y*27) + (x*27) +zY))
				{		
					if(mapa[x+1][y].getType() == 2)
						alert("Název:" + mapa[x+1][y].getInfo() + "\nKapacita:" + mapa[x+1][y].getKapacita());
					else if(mapa[x][y+1].getType() == 2)
						alert("Název:" + mapa[x][y+1].getInfo() + "\nKapacita:" + mapa[x][y+1].getKapacita());
					else if(mapa[x+1][y+1].getType() == 2)
						alert("Název:" + mapa[x+1][y+1].getInfo() + "\nKapacita:" + mapa[x+1][y+1].getKapacita());
					else
						alert("Název:" + mapa[x][y].getInfo() + "\nKapacita:" + mapa[x][y].getKapacita());
					
					break l1;
					break l2;
				}
				
			}	
		}
		return false;
      }, false);
