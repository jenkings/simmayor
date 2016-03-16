var ceny = new Array(3);
ceny[0] = new Array(11);
ceny[1] = new Array(1);
ceny[2] = new Array(2);

var nazvy = new Array(3);
nazvy[0] = new Array(11);
nazvy[1] = new Array(1);
nazvy[2] = new Array(2);

var kapacita = new Array();
var kapacita2 = new Array();

//----------------POVRCHY--------------------------------//
nazvy[0][0] = "Tráva"
ceny[0][0] = 50;

nazvy[0][1] = "Kámen"
ceny[0][1] = 60;

nazvy[0][2] = "Sníh"
ceny[0][2] = 80;

nazvy[0][3] = "silnice"
ceny[0][3] = 250;

nazvy[0][4] = "silnice"
ceny[0][4] = 250;

nazvy[0][5] = "silnice"
ceny[0][5] = 220;

nazvy[0][6] = "silnice"
ceny[0][6] = 220;

nazvy[0][7] = "silnice"
ceny[0][7] = 220;

nazvy[0][8] = "silnice"
ceny[0][8] = 220;

nazvy[0][9] = "staveniště"
ceny[0][9] = 0;

nazvy[0][10] = "křižovatka"
ceny[0][10] = 280;


//----------------BUDOVY--------------------------------//
nazvy[1][0] = "Přístav"
ceny[1][0] = 25080;
kapacita[0] = 0;

nazvy[1][1] = "Chatky"
ceny[1][1] = 880;
kapacita[1] = 15;

nazvy[1][2] = "Stany"
ceny[1][2] = 680;
kapacita[2] = 10;


nazvy[1][3] = "Malý domek"
ceny[1][3] = 2480;
kapacita[3] = 15;

nazvy[1][4] = "Malý Hotel"
ceny[1][4] = 7480;
kapacita[4] = 40;

nazvy[1][5] = "Velký Hotel"
ceny[1][5] = 18480;
kapacita[5] = 82;


//----------------PRŮMYSL--------------------------------//
nazvy[2][0] = "Důl";
ceny[2][0] = 40000;
kapacita2[0] = 0;

nazvy[2][1] = "Elektrárna";
ceny[2][1] = 60000;
kapacita2[1] = 0;

nazvy[2][2] = "Letiště";
ceny[2][2] = 88000;
kapacita2[2] = 0;

nazvy[2][3] = "Nemocnice";
ceny[2][3] = 12000;
kapacita[3] = 0;

nazvy[2][4] = "Ropné pole";
ceny[2][4] = 37040;
kapacita2[4] = 0;

nazvy[2][5] = "Stadion";
ceny[2][5] = 15845;
kapacita2[5] = 0;

nazvy[2][6] = "Luxusní hotel";
ceny[2][6] = 60845;
kapacita2[6] = 384;

nazvy[2][7] = "Recyklační centrum";
ceny[2][7] = 350845;
kapacita2[7] = 0;


var Item = function(x,typ) {
    var prvek = x;
	var type = typ;

    this.getItem = function() {
        return prvek;
    }
    
    this.getType = function() {
        return type;
    }
    
    this.getInfo = function() {
        return "" + nazvy[type][prvek];
    }
    
    this.getCena = function() {
        return "" + ceny[type][prvek];
    }
    
    this.getKapacita = function() {	
        if(type==1)
			return kapacita[prvek];
		if(type==2)
			return kapacita2[prvek];
		else
			return 0;
    }
    
};


