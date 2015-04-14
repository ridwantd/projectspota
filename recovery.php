<?php

include ("inc/helper.php");
include ("inc/konfigurasi.php");
include ("inc/db.pdo.class.php");

$db=new dB($dbsetting);

$token=$_GET['key'];

$check="SELECT * FROM temp_resetpass WHERE rkey='$token' LIMIT 1";
$db->runQuery($check);
if($db->dbRows()>0){
	$r=$db->dbFetch();
	$jenisuser=$r['jenis'];
	$tglrecover=$r['tglrecover'];

}else{
	//pesan key invalid..
}

?>