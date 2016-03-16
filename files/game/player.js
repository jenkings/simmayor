var Player = function(money) {
    this.penize = money;

    this.getMoney = function() {
			return this.penize;
    }
    
    this.GiveMoney = function(amount) {
        this.penize += amount * 1;
    }
    
    this.SetMoney = function(amount) {
        this.penize = amount *1;
    }
    
};
