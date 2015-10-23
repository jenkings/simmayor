var canvas = document.getElementById("platno");
var context = canvas.getContext("2d");

context.fillStyle = "#FFFFFF";
context.fillRect(0, 0, 390, 140);

var x = gethighest();
var meritko = 380 / tridy[x];

context.fillStyle = "#FF0000";

context.fillRect(0, 0, tridy[0] * meritko, 40);
context.fillRect(0, 50, tridy[1] * meritko, 40);
context.fillRect(0, 100, tridy[2] * meritko, 40);


context.fillStyle = "#000000";
context.font = "25px sans-serif";

context.fillText("zbohatlíci", 10, 25);
context.fillText("střední třída", 10, 80);
context.fillText("chudina", 10, 130);

context.font = "20px serif";
context.fillText(tridy[0], 360, 25);
context.fillText(tridy[1], 360, 80);
context.fillText(tridy[2], 360, 130);



function gethighest()
{
		if(tridy[0] >=tridy[1] && tridy[0]>=tridy[2])
			return 0;
		else if(tridy[1] >=tridy[0] && tridy[1]>=tridy[2])
			return 1;
		else if(tridy[2] >=tridy[1] && tridy[0]>=tridy[0])
			return 2;
}
