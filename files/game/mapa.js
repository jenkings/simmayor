var mapa = new Array(MAPSIZE_X);
			for (var i = 0; i < MAPSIZE_X; i++) {
				mapa[i] = new Array(MAPSIZE_Y);
			}	


var beta = map.split("|");

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
