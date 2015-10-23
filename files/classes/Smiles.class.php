<?php
class Smiles
{
    private $slozka;
    private $textid;
    private $soubory = array();
    
    
    public function __construct($slozka, $textid)
    {
        $this->slozka = $slozka;
        $this->textid = $textid;
    }
    
    
    public function nacti()
    {
        $slozka = dir($this->slozka);

        while ($polozka = $slozka->read()) 
        {
            if (is_file($this->slozka . '/' . $polozka))
            {
                $this->soubory[] = $polozka;
            }
        }
        $slozka->close();
    }
    
    
    public function vypis()
    {	
		?>
		
		
		
			<script>
			function insertAtCursor(myField, myValue) 
			{
				//IE support
				if (document.selection) {
					myField.focus();
					sel = document.selection.createRange();
					sel.text = myValue;
				}
				//MOZILLA and others
				else if (myField.selectionStart || myField.selectionStart == '0') {
					var startPos = myField.selectionStart;
					var endPos = myField.selectionEnd;
					myField.value = myField.value.substring(0, startPos)
						+ myValue
						+ myField.value.substring(endPos, myField.value.length);
				} else {
					myField.value += myValue;
				}
			}
			
			
			function addsmile(x)
			{
				var hodn = "";
				
				if(x == "1.gif")
					hodn = ":D";
				if(x == "2.gif")
					hodn = ":P";
				if(x == "3.gif")
					hodn = ":)";
				if(x == "4.gif")
					hodn = ";)";
				if(x == "5.gif")
					hodn = "O.o";
				if(x == "6.gif")
					hodn = ":BEER:";
				if(x == "7.gif")
					hodn = ":(";
				if(x == "8.gif")
					hodn = ":/";
				
				insertAtCursor(<?php echo $this->textid;?>, hodn);
			}
			
			</script>
		
		
		
		<?php

        foreach ($this->soubory as $soubor)
        {			
            $smile = $this->slozka . '/' . htmlspecialchars($soubor);
            echo('<img src="' . $smile . '" alt="" onclick="addsmile(\''.$soubor.'\')">');   
        }
    }
}
?>
