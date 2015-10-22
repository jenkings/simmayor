var Plane = function(x,y,SX,SY) {
    var X = x;
    var Y = y;
    var sX = SX;
    var sY = SY;
    
    var uhel = Math.atan(sY/sX);
    
    this.getX = function() {
			return X;
    }
    this.getY = function() {
			return Y;
    }
    
    this.getsX = function() {
			return sX;
    }
    this.getsY = function() {
			return sY;
    }
    this.getAngle = function() {
		if(sX > 0 && sY > 0)
			return uhel;	
			
		else if(sX < 0 && sY < 0)
			return uhel + 3.14;	
			
			
		else if(sX < 0 && sY > 0)
			return 3.14 + uhel;		
			
			
		else if(sX > 0 && sY < 0)
			return 6.28+uhel;
	}
    
    this.Update = function() {
			X += sX;
			Y += sY;
    }
    
    this.OnMap = function() {
			if(X > 900 || X < -500 || Y > 1000 || Y < 100)
				return false;
			else 
				return true;
    }

};
