<?php
	session_start();
	$idprodi=$_SESSION['login-mhs']['prodi'];
	$idmhs=$_SESSION['login-mhs']['id'];
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */
	
	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
	$aColumns = array('tp.judul');
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "tp.id";
	
	/* DB table to use */
	$sTable = "tbpengumuman tp";
	
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
	$sOrder = "ORDER BY tp.tgl DESC, tp.judul ASC";
	
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
		$where2="AND tp.idProdi='$idprodi' AND tujuan IN ('A','M')";
	}else{
		$where2="WHERE tp.idProdi='$idprodi' AND tujuan IN ('A','M')";
	}
	/*
	 * SQL queries
	 * Get data to display
	 */
	$sQuery0 = "
		SELECT *,
		(SELECT count(id) FROM tmp_notif WHERE idkonten=tp.id AND iduser='".$idmhs."' AND idProdi='".$idprodi."') as new 
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
		SELECT COUNT(tp.id) as total FROM $sTable $where2
	";
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

		$row[0]="<a href='?page=pengumuman&lihat=".$aRow['id']."'>".$aRow['judul']."</a>".$badge;
		$row[1]=tanggalIndo($aRow['tgl'],'j F Y, H:i');
		$output['aaData'][] = $row;
		// print_r($row);
		
	}
	
	echo json_encode( $output );
?>