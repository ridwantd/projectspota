<?php
	session_start();
	$idprodi=$_SESSION['login-dosen']['prodi'];
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */
	
	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
	$aColumns = array('td.nmLengkap');
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "trh.id";
	
	/* DB table to use */
	$sTable = "tbrekaphasil trh,tbdosen td ";
	
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
	$sOrder = "ORDER BY td.nip";
	
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
		$where2=" AND td.status='A' AND trh.idProdi='$idprodi' ";
	}else{
		$where2=" WHERE td.status='A' AND trh.idProdi='$idprodi' ";
	}
	/*
	 * SQL queries
	 * Get data to display
	 */
	$sQuery0 = "
		SELECT td.nip,td.nmLengkap, 
			COUNT(if(trh.pemb1=td.nip,1,null)) as pemb1,
			COUNT(if(trh.pemb2=td.nip,1,null)) as pemb2,
			COUNT(if(trh.peng1=td.nip,1,null)) as peng1,
			COUNT(if(trh.peng2=td.nip,1,null)) as peng2
		FROM $sTable
		$sWhere
		$where2
		GROUP BY td.nip
		$sOrder 
		";
	//echo $sQuery0;
	$db->runQuery($sQuery0);
	$iFilteredTotal = $db->dbRows();

	$result=$db->runQuery($sQuery0.$sLimit);

	/* Total data set length */
	$sQuery2 = "
		SELECT COUNT(DISTINCT(td.nip)) as total FROM $sTable $sWhere $where2
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

		$row[0]=$aRow['nmLengkap'];
		$row[1]=$aRow['nip'];
		$row[2]='<a href="#stat-keldosen" onClick="mhsPemb1(\''.$aRow['nip'].'\')">'.$aRow['pemb1'].'</a>';
		$row[3]='<a href="#stat-keldosen" onClick="mhsPemb2(\''.$aRow['nip'].'\')">'.$aRow['pemb2'].'</a>';
		$row[4]='<a href="#stat-keldosen" onClick="mhsPeng1(\''.$aRow['nip'].'\')">'.$aRow['peng1'].'</a>';
		$row[5]='<a href="#stat-keldosen" onClick="mhsPeng2(\''.$aRow['nip'].'\')">'.$aRow['peng2'].'</a>';

		$output['aaData'][] = $row;
		// print_r($row);
		
	}
	
	echo json_encode( $output );
?>