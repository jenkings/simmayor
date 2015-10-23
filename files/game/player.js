var Player = function(money) {
    var penize = money;

    this.getMoney = function() {
			return penize;
    }
    
    this.GiveMoney = function(amount) {
        penize += amount;
    }
    
    this.SetMoney = function(amount) {
        penize = amount + 1;
    }
    
};
