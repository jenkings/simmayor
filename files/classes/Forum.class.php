<?php
require_once "./classes/Parser.class.php";
class Forum{
  private $seznam;
  private $db;

  function  __construct($spojeni){
    $this->db=$spojeni;
  }

  public function getThreads($sekce) 
  {
	$this->seznam=$this->db->queryAll("SELECT id,datum,nazev FROM topics WHERE idsekce = '" . $sekce . "̈́' ORDER BY datum DESC");
    $rows=array();
    foreach($this->seznam as $row){
      $rows[]="<li><a href='index.php?pid=thread&topicid=".$row['id']."'><h3>".$row['nazev']."</h3></a>  <span>".$row['datum']."</span></li>";
    }
    $temata=implode("\n",$rows);
    if (count($rows) == 0) return "<h3>Zatím žádné diskuze.</h3>";
    return "<div id='forum'><ul id='forum_kategorie'>$temata</ul></div>";
  }
  
  public function getTopic($id) 
  {
	$this->seznam=$this->db->queryOne("SELECT nazev,jmeno,avatar,text,vipdo FROM topics t INNER JOIN accounts a ON  t.idzakladatele = a.id WHERE t.id = ?",array($id));
    
    $cas = $this->seznam['vipdo'];
	$comparedate=date("Y-m-d H:i:s",strtotime($cas));
	if(date("Y-m-d H:i:s") < $comparedate)
	{
		$prvni= "<h2>". $this->seznam['nazev'] ."</h2><li><div class='user'><h4 style='color:orange'>". $this->seznam['jmeno'] . "</h4><img src='./avatars/".$this->seznam['avatar'].".jpg'></div><div class='content'>" . Parser::parse($this->seznam['text'])."</div></li>";
	}else{
		$prvni= "<h2>". $this->seznam['nazev'] ."</h2><li><div class='user'><h4>". $this->seznam['jmeno'] . "</h4><img src='./avatars/".$this->seznam['avatar'].".jpg'></div><div class='content'>" . Parser::parse($this->seznam['text'])."</div></li>";
	}


    $this->seznam=$this->db->queryAll("SELECT idodepisovatele,text,jmeno,avatar,vipdo FROM posts p INNER JOIN accounts a ON p.idodepisovatele = a.id WHERE idtematu = ? ORDER BY p.id",array($id));
    $rows=array();
    foreach($this->seznam as $row){
		
		
		$cas = $row['vipdo'];
		$comparedate=date("Y-m-d H:i:s",strtotime($cas));
		if(date("Y-m-d H:i:s") < $comparedate)
		{
			$rows[]= "<li><div class='user'><h4 style='color:orange;'>". $row['jmeno'] . "</h4><img src='./avatars/".$row['avatar'].".jpg'></div><div  class='content'>" . Parser::parse($row['text'])."</div></li>";
		}else{
			$rows[]= "<li><div class='user'><h4>". $row['jmeno'] . "</h4><img src='./avatars/".$row['avatar'].".jpg'></div><div  class='content'>" . Parser::parse($row['text'])."</div></li>";
		}
    }
    $zbytek=implode("\n",$rows);
    return "<div id='forum'><ul id='forum_tema'>$prvni $zbytek</ul></div>";
  }
  
	public function TopicForm($sekce)
	{
		if(isset($_SESSION['prihlasen']) && $_SESSION['prihlasen'] != "")
		{
			$text ="";
			$text .= "<form action='./index.php?pid=newpost' method='post' id='newtopic'><h2>Nové téma</h2>Nadpis:<input type='text' size='20' name='nadpis' value=''>Zpráva:<textarea name='obsah' id='ob'> </textarea><input type='hidden' name='sekce' value='".$sekce."'><input type='submit' value='Založit'></form>";
			return $text;
		}
	}
	
	public function PostForm($tema)
	{
		if(isset($_SESSION['prihlasen']) && $_SESSION['prihlasen'] != "")
		{
			$text ="";
			$text .= "<form action='./index.php?pid=newpost' method='post' id='newtopic'><h2>Odpovědět</h2>Zpráva:<textarea name='text' id='te'> </textarea><input type='hidden' name='idtopicu' value='".$tema."'><input type='submit' value='Odpovědět'></form>";
			return $text;
		}
	}
	
	public function createPost($text,$topic,$userID){
		if(isset($_SESSION['prihlasen']) && $_SESSION['prihlasen'] != ""){
			$data = array();
			$data[0] = $topic;
			$data[1] = intval($userID);
			$data[2] = $text;
			$this->db->query("INSERT INTO posts (idtematu,idodepisovatele,text) VALUES (?,?,?)",$data);
			$this->db->query("UPDATE topics SET datum=? WHERE id=?",array(date('Y-m-d H:i:s'),$topic));
		}
	}
	
	public function createTopic($nadpis,$text,$sekce,$userID){
		if(isset($_SESSION['prihlasen']) && $_SESSION['prihlasen'] != ""){
			$data = array();
			$data[0] = $sekce;
			$data[1] = $userID;
			$data[2] = date('Y-m-d H:i:s');
			$data[3] = $nadpis;
			$data[4] = $text;
			$this->db->query("INSERT INTO topics (idsekce,idzakladatele,datum,nazev,text) VALUES (?,?,?,?,?)",$data);
		}
	}
	
}
