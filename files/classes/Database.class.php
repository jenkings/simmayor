<?php
class Database{
  private $spojeni;

  function __construct($host,$user,$pass,$name){
    $options=array(
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
      );
    $this->spojeni= @new PDO("mysql:host=$host;dbname=$name",$user,$pass,$options);
  }

  function query($query,$param=Array()){
      $navrat=$this->spojeni->prepare($query);
      $navrat->execute($param);
      return $navrat->rowCount();
  }
  
function queryPlayer($query,$param=Array()){  
	$navrat=$this->spojeni->prepare($query); 
    @$navrat->bindParam(':id', intval($param[1]), PDO::PARAM_INT);
    $navrat->execute();
    return $navrat->fetch(PDO::FETCH_ASSOC);
}

  function queryOne($query,$param=Array()){
      $navrat=$this->spojeni->prepare($query);
      $navrat->execute($param);
      return $navrat->fetch(PDO::FETCH_ASSOC);
  }

  function queryAll($query,$param=Array()){
      $navrat=$this->spojeni->prepare($query);
      $navrat->execute($param);
      return $navrat->fetchAll(PDO::FETCH_ASSOC);
  }
  
	function __destruct()
	{
		$this->spojeni = null;
	}
}
