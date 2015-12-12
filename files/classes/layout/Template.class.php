<?php
class Template{
	private $file;
	private $contents = array();
	
	public function Template($template = "main"){
		$this->file = "./templates/" . $template . ".phtml";
		
		$this->contents['content'] = "Obsah nedodán";
	}	
	
	public function __toString(){
		return $this->replaceVariablesInTemplate(file_get_contents($this->file),$this->contents);
	}
	
	private function replaceVariablesInTemplate($template, array $variables){
	 return preg_replace_callback('#{\$(.*?)}#',
		   function($match) use ($variables){
				return $this->contents[$match[1]];
		   },
		   ' '.$template.' ');
	}  
	
	public function setContent($name,$value){
		$this->contents[$name] = $value;
	}
}
?>
