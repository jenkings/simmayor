var mapa = new Array(MAPSIZE_X);
			for (var i = 0; i < MAPSIZE_X; i++) {
				mapa[i] = new Array(MAPSIZE_Y);
			}	


for(var x=0;x<MAPSIZE_X;x++)
{
	for(var y=0;y<MAPSIZE_Y;y++)
	{
		mapa[x][y] = new Item(0,0);
	}
}

var beta = map.split("|");
var loop = Math.sqrt(beta.length-1);
var pom = 0;
for(var x = 0;x<loop;x++){
	for(var y = 0;y<loop;y++){
		var s = beta[pom].split(",");
		mapa[x][y] = new Item(s[0],s[1]);
		pom++;
	}
}
/*
var pom = 0;
for(var x=0;x<MAPSIZE_X;x++)
{
	for(var y=0;y<MAPSIZE_Y;y++)
	{
		var s = beta[pom].split(",");
		mapa[x][y] = new Item(s[0],s[1]);
		pom++;
	}
}
*/
