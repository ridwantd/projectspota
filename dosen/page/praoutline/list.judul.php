<?php
	session_start();
	$idprodi=$_SESSION['login-dosen']['prodi'];
	$iddosen=$_SESSION['login-dosen']['id'];
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */
	
	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
	$aColumns = array('tp.judul','tp.nim');
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "tp.id";
	
	/* DB table to use */
	$sTable = "tbpraoutline tp";
	
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
	$sOrder = "ORDER BY tp.tgl_upload DESC, tp.judul ASC";
	
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
		$where2=" AND tp.idProdi='$idprodi' AND tp.status_usulan='0' ";
	}else{
		$where2=" WHERE tp.idProdi='$idprodi' AND tp.status_usulan='0' ";
	}
	/*
	 * SQL queries
	 * Get data to display
	 */
	$sQuery0 = "
		SELECT tp.*,
		((SELECT count(id) FROM tmp_notif WHERE iduser='".$iddosen."' AND typeuser='D' AND jenis='J' AND idProdi='".$idprodi."' AND idkonten=tp.id)) as new,
		(SELECT nmLengkap FROM tbmhs WHERE nim=tp.nim LIMIT 1) as nm_mhs
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
		SELECT COUNT(tp.id) as total FROM $sTable $sWhere $where2
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

		if($aRow['new']==0){
			$badge=' - <span class="label label-warning"> Baru</span>';
		}else{
			$badge='';
		}

		$row[0]=$aRow['nm_mhs']."<br/>NIM: ".$aRow['nim'];
		$row[1]='<a href="?page=praoutline&menu=review&prid='.$aRow['id'].'">'.$aRow['judul'].'</a>'.$badge;
		$row[2]=$aRow['thn_ajaran']." - ".$aRow['semester'];
		$row[3]=tanggalIndo($aRow['tgl_upload']." ".$aRow['wkt_upload'],'j F Y, H:i');
		$output['aaData'][] = $row;
		// print_r($row);
		
	}
	
	echo json_encode( $output );
?>