<?php
session_start();
include ("inc/helper.php");
include ("inc/konfigurasi.php");
include ("inc/db.pdo.class.php");

$db=new dB($dbsetting);

$q="SELECT gcm.*,tm.nmLengkap as mhs,td.nmLengkap as dosen FROM gcm_service gcm
LEFT JOIN tbmhs tm ON(tm.nim=gcm.iduser)
LEFT JOIN tbdosen td ON (td.nip=gcm.iduser) ORDER BY gcm.iduser";

echo "<b>Timezone Default : </b>".date_default_timezone_get();
echo "<hr/>";
echo date("d-m-Y H:i:s");
echo "<hr/>";

$db->runQuery($q);
if($db->dbRows()>0){
	while($r=$db->dbFetch()){
		switch ($r['jenisuser']){
			case 'M':
				echo "<div style='background-color:#F5D754'>Nama Mahasiswa : ".$r['mhs']."<br/>NIM : ".$r['iduser']." <br/> GCMregid : ".$r['regid']."</div><hr/>";
			break;

			case 'D':
			case 'K':
				echo "<div style='background-color:#88BAED'>Nama Dosen : ".$r['dosen']."<br/>NIP : ".$r['iduser']." <br/> GCMregid : ".$r['regid']."</div><hr/>";
			break;
		}
	}
}

echo "<hr/>";
$qqq="SELECT NOW()";
$db->runQuery($qqq);
$xxx=$db->dbFetch();
//print_r($xxx);
echo NOW;