var Scrollbar = function(nodeLink,minR,maxR,step) {
    this.node = nodeLink;
    this.max = maxR;
    this.min = minR;
    this.stepsCount = step;
    Scrollbar.count ++;
    
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
    
	this.resizeRod = function(newWidth){
		this.value.style.width = newWidth + "px";
	}
	
	
	this.recalcSizes = function(){
		this.line.style.marginTop = (parseInt(this.bar.style.height)/2) - (parseInt(this.line.style.height) / 2) + "px";
		this.value.style.marginTop = "-" + (parseInt(this.line.style.height) + parseInt(this.line.style.marginTop)) + "px";
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
				this.value.innerHTML = Math.round(set_perc * 100);
				//this.value.style.marginLeft = ((set_perc * 100) - (parseInt(this.value.style.width)/2)) + '%'; // 5 je pulka sirky
				var kolikproc = set_perc * 100
				console.log(((parseInt(this.bar.style.width) / 100) * kolikproc) - (parseInt(this.value.style.width)/2));
				this.value.style.marginLeft = ((parseInt(this.bar.style.width) / 100) * kolikproc) - (parseInt(this.value.style.width)/2) + 'px'; // 5 je pulka sirky
                break;
        }
    }

	this.recalcSizes();
};
Scrollbar.count = 0;


