<?php

class web extends dB{
	private $db;

	public function __construct(){
		$this->db=new db($dbsetting);
	}

	function web_title(){
		$d=$this->db;
		$d->runQuery("SELECT val as webtitle  FROM web_setting WHERE id='1' AND name='web_title'");
		if($d->dbRows()>0){
			$r=$d->dbFetch();
			echo $r['webtitle'];
		}else{
			return FALSE;
		}
	}
}
?>