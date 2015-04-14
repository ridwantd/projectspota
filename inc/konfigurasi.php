<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of konfigurasi
 *
 * @author Ridwan
 */

date_default_timezone_set('Asia/Jakarta');
$now=date("Y-m-d H:i:s");
$curdate=date("Y-m-d");
$curtime=date("H:i:s");

/*$dbsetting['MySQLHost'] = "localhost";
$dbsetting['MySQLUser'] = "k1383423_spota";
$dbsetting['MySQLPasswd'] = "adminspota99";
$dbsetting['MySQLDb'] = "k1383423_spotauntan";

$dbsetting['ERR_report']=TRUE;

DEFINE('DOMAIN_UTAMA',"http://spota.untan.ac.id");
DEFINE('ADMIN_PAGE',"http://spota.untan.ac.id/admin/");
DEFINE('MHS_PAGE',"http://spota.untan.ac.id/mahasiswa/");
DEFINE('DOSEN_PAGE',"http://spota.untan.ac.id/dosen/");

$dir_utama="/";*/
$dbsetting['MySQLHost'] = "localhost";
$dbsetting['MySQLUser'] = "root";
$dbsetting['MySQLPasswd'] = "admin92";
$dbsetting['MySQLDb'] = "project_spota";

$dbsetting['ERR_report']=TRUE;

DEFINE('DOMAIN_UTAMA',"http://localhost/~project/spota");
DEFINE('ADMIN_PAGE',DOMAIN_UTAMA."/admin/");
DEFINE('MHS_PAGE',DOMAIN_UTAMA."/mahasiswa/");
DEFINE('DOSEN_PAGE',DOMAIN_UTAMA."/dosen/");

$dir_utama="/~project/spota/";


DEFINE("LAMPIRAN_FILE",$_SERVER['DOCUMENT_ROOT'].$dir_utama."files/");
DEFINE("DIR_GAMBAR",$_SERVER['DOCUMENT_ROOT'].$dir_utama."img/");
DEFINE('LINK_GAMBAR',DOMAIN_UTAMA."/img/");
DEFINE('NOW',$now);
DEFINE('CURTIME',$curtime);
DEFINE('CURDATE',$curdate);

if (!defined('GOOGLE_API_KEY')) {
	define("GOOGLE_API_KEY", "AIzaSyArEBTIbIKPHN214bC59UIkhxPyZI3b3E8"); 		
}
?>