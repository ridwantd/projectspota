<?php
	session_start();
	$idprodi=$_SESSION['login-dosen']['prodi'];
	$iddosen=$_SESSION['login-dosen']['id'];
	$nipdosen=$_SESSION['login-dosen']['nip'];
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */
	
	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
	$aColumns = array('trh.judul_final','trh.nim');
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "trh.id";
	
	/* DB table to use */
	$sTable = "tbrekaphasil trh";
	
	/* Database connection information */
	include ("../../../inc/helper.php");
	include ("../../../inc/konfigurasi.php");
	include ("../../../inc/db.pdo.class.php");

	$db=new dB($dbsetting);
	
	/* 
	 * Paging
	 */
	$sLimit = "";
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".intval( $_GET['iDisplayStart'] ).", ".
			intval( $_GET['iDisplayLength'] );
	}
	
	
	/*
	 * Ordering
	 */
	$sOrder = "ORDER BY trh.tgl_kep DESC, trh.wkt_kep DESC";
	
	/* 
	 * Filtering
	 */
	$sWhere = "";
	if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
	{
		$sWhere = "WHERE (";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" )
			{
				$sWhere .= "".$aColumns[$i]." LIKE '%".$_GET['sSearch']."%' OR ";
			}
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}
	
	/* Individual column filtering */
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= "".$aColumns[$i]." LIKE '%".$_GET['sSearch_'.$i]."%' ";
		}
	}


	$where2="";
	if($sWhere!=''){
		$where2=" AND trh.idProdi='$idprodi' AND trh.kep_akhir='1' AND (trh.pemb1='$nipdosen' OR trh.pemb2='$nipdosen' OR trh.peng1='$nipdosen' OR trh.peng2='$nipdosen') ";
	}else{
		$where2=" WHERE trh.idProdi='$idprodi' AND trh.kep_akhir='1' AND (trh.pemb1='$nipdosen' OR trh.pemb2='$nipdosen' OR trh.peng1='$nipdosen' OR trh.peng2='$nipdosen') ";
	}
	/*
	 * SQL queries
	 * Get data to display
	 */
	$sQuery0 = "
		SELECT trh.*,
		(SELECT nmLengkap FROM tbdosen WHERE nip=trh.pemb1) as dpemb1,
		(SELECT nmLengkap FROM tbdosen WHERE nip=trh.pemb2) as dpemb2,
		(SELECT nmLengkap FROM tbdosen WHERE nip=trh.peng1) as dpeng1,
		(SELECT nmLengkap FROM tbdosen WHERE nip=trh.peng2) as dpeng2,
		(SELECT nmLengkap FROM tbmhs WHERE nim=trh.nim) as nm_mhs
		FROM $sTable
		$sWhere
		$where2
		$sOrder 
		";
	//echo $sQuery0;
	$db->runQuery($sQuery0);
	$iFilteredTotal = $db->dbRows();

	$result=$db->runQuery($sQuery0.$sLimit);

	/* Total data set length */
	$sQuery2 = "
		SELECT COUNT(trh.id) as total FROM $sTable $sWhere $where2
	";
	//echo $sQuery2;
	$db->runQuery($sQuery2);
	$aResultTotal = $db->dbFetch();
	$iTotal = $aResultTotal['total'];

	/*$rResultTotal = mysql_query( $sQuery, $gaSql['link'] ) or fatal_error( 'MySQL Error: ' . mysql_errno() );
	$aResultTotal = mysql_fetch_array($rResultTotal);
	$iTotal = $aResultTotal[0];*/
	
	
	/*
	 * Output
	 */

	$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	
	while ( $aRow = $db->dbFetch($result) )
	{
		//print_r($aRow);
		$row = array();

		$row[0]=$aRow['nm_mhs']."<br/>NIM: ".$aRow['nim'];
		$row[1]='<a href="?page=praoutline&menu=review&prid='.$aRow['idpraoutline'].'">'.$aRow['judul_final'].'</a><br/>';
		$row[1].='Pembimbing 1: '.$aRow['dpemb1'].' | Pembimbing 2: '.$aRow['dpemb2'].'<br/>Penguji 1: '.$aRow['dpeng1'].' | Penguji 2: '.$aRow['dpeng2'];
		$row[2]=$aRow['tahun_ajaran']." - ".$aRow['semester'];
		$row[3]=tanggalIndo($aRow['tgl_kep']." ".$aRow['wkt_kep'],'j F Y, H:i');
		/*$row[4]='1. '.$aRow['dpemb1'].' <br/>2. '.$aRow['dpemb2'];
		$row[5]='1. '.$aRow['dpeng1'].' <br/>2. '.$aRow['dpeng2'];*/
		$output['aaData'][] = $row;
		// print_r($row);
		
	}
	
	echo json_encode( $output );
?>