var Scrollbar = function(nodeLink,name,minR,maxR,steps) {
    this.node = nodeLink;
    this.max = maxR;
    this.min = minR;
    this.name = name;
    this.stepsCount = (steps > (this.max-this.min) ? this.max-this.min : steps);
    this.stepSize = 0;
    Scrollbar.count ++;
    this.scale = 1;
    
    this.output = document.createElement("INPUT");
    this.node.parentNode.appendChild(this.output);
    this.output.name = this.name;
    this.output.value = this.min;
    this.output.type = "hidden";
    this.bar = document.createElement("DIV");
    this.value = document.createElement("DIV");
    this.value.innerHTML = this.min;
    this.bar.setAttribute("id", "bar"+Scrollbar.count);
    this.node.parentNode.appendChild(this.bar);
    this.value.setAttribute("id", "value"+Scrollbar.count);
    this.bar.appendChild(this.value);
    this.bar.addEventListener('mousedown', this, false);	
	this.value.addEventListener('mousedown', this, false);	
	this.bar.addEventListener('mouseup', this, false);
	this.value.addEventListener('mouseup', this, false);
	this.line = document.createElement("DIV");
	this.bar.appendChild(this.line);
	this.bar.appendChild(this.value);
	this.line.style.height = "8px";
	this.line.style.width = "100%";
	this.line.style.backgroundColor = "green";
	this.line.style.position = "relative";
	this.line.style.float = "none";
	this.bar.style.userSelect = "none"
	this.bar.style.width = "200px";
	this.bar.style.height = "25px";
	this.bar.style.position = "relative";
	this.bar.style.display = "block";
	this.value.style.backgroundColor = "yellow";
	this.value.style.width = "20px";
	this.value.style.position = "relative";
	this.value.style.height = "25px";
	this.value.style.userSelect = "none";
	this.value.style.marginLeft = "-10px";
	this.value.style.textAlign = "center";
	this.value.style.float = "none";
	this.value.style.fontWeight = "bold";
	
	
	this.setLineColor = function(color){this.line.style.backgroundColor = color;}
	this.setRodColor = function(color){this.value.style.backgroundColor = color;}
	this.setRodRadius = function(value){this.value.style.borderRadius = value + "px";}
	this.setLineRadius = function(value){this.line.style.borderRadius = value + "px";}
	this.setFontColor = function(color){this.value.style.color = color;}
	
	
	this.nearestDividable = function(number,divider){
		zbytek = number%divider;
		if(zbytek < (divider/2)) return number-zbytek;
			else return (number-zbytek) + divider;
	}
    this.calcValue = function(fromLeft){
		return this.nearestDividable(Math.round(fromLeft * this.scale),this.stepSize) + this.min;
	}
    
	this.resizeRod = function(newWidth){
		this.value.style.width = newWidth + "px";
	}
	
	this.resizeBar = function(newWidth){
		this.bar.style.width = newWidth + "px";
		this.line.style.width = newWidth + "px";
	}
	
	this.recalcSizes = function(){
		this.line.style.marginTop = (parseInt(this.bar.style.height)/2) - (parseInt(this.line.style.height) / 2) + "px";
		this.value.style.marginTop = "-" + (parseInt(this.line.style.height) + parseInt(this.line.style.marginTop)) + "px";
	}
	
	this.recalcStepSize = function(){
		this.stepSize = (this.max-this.min)/this.stepsCount;
	}
	
	this.recalcScale = function(){
		rozptyl = this.max - this.min;
		this.scale = rozptyl/100;
	}
	
    this.handleEvent = function(e) {
        switch(e.type) {
            case "mouseup":
                var set_perc = ((((e.clientX - this.bar.offsetLeft) / this.bar.offsetWidth)).toFixed(2));
				this.bar.removeEventListener('mousemove', this, false);
                break;
            case "mousedown":
                var set_perc = ((((e.clientX - this.bar.offsetLeft) / this.bar.offsetWidth)).toFixed(2));
				this.bar.addEventListener('mousemove', this, false);	
                break;
             case "mousemove":
                var set_perc = ((((e.clientX - this.bar.offsetLeft) / this.bar.offsetWidth)).toFixed(2));
                var kolikproc = (set_perc * 100 > 100 ? 100 : set_perc * 100);
                if(kolikproc <0) kolikproc=0;
				this.value.innerHTML = this.calcValue(kolikproc);
				this.output.value = this.calcValue(kolikproc);
				console.log(((parseInt(this.bar.style.width) / 100) * kolikproc) - (parseInt(this.value.style.width)/2));
				this.value.style.marginLeft = ((parseInt(this.bar.style.width) / 100) * kolikproc) - (parseInt(this.value.style.width)/2) + 'px'; // 5 je pulka sirky
                break;
        }
    }

	this.recalcSizes();
	this.recalcStepSize();
	this.recalcScale();
};
Scrollbar.count = 0;


