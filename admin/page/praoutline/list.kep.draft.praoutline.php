<?php
	session_start();
	$idprodi=$_SESSION['login-admin']['prodi'];
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
	$sTable .= " LEFT JOIN tbreview tr ON (tp.id=tr.idpraoutline) ";
	$sTable .= " LEFT JOIN tbmhs tm ON (tm.nim=tp.nim) ";
	$sTable .= " LEFT JOIN tbrekaphasil trh ON (trh.idpraoutline=tp.id) ";
	
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
		$where2=" AND tp.idProdi='$idprodi' ";
	}else{
		$where2=" WHERE tp.idProdi='$idprodi' ";
	}
	/*
	 * SQL queries
	 * Get data to display
	 */
	$sQuery0 = "
		SELECT tp.*,
		COUNT(tr.id) as jlhreview,
		COUNT(if(tr.jenis_review='0',1,null)) as komentar,
		COUNT(if(tr.jenis_review='1',1,null)) as putusan,
		COUNT(if(tr.putusan='1',1,null)) as setuju,
		count(if(tr.putusan='0',1,null)) as tdk_setuju,
		COUNT(trh.id) as found,
		tm.nmLengkap as nm_mhs
		FROM $sTable
		$sWhere
		$where2
		GROUP BY tp.id
		$sOrder 
		";
	//echo $sQuery0;
	$db->runQuery($sQuery0);
	$iFilteredTotal = $db->dbRows();

	$result=$db->runQuery($sQuery0.$sLimit);

	/* Total data set length */
	$sQuery2 = "
		SELECT COUNT(tp.id) as total FROM $sTable $sWhere $where2 GROUP BY tp.id
	";
	//echo $sQuery2;
	$db->runQuery($sQuery2);
	$aResultTotal = $db->dbFetch();
	$iTotal = $aResultTotal['total'];

	$sQuery3="SELECT `values` FROM web_setting WHERE name='min_close' AND idProdi='$idprodi' LIMIT 1";
	//echo $sQuery3;
	$db->runQuery($sQuery3);
	$minimal_setuju="";
	if($db->dbRows()>0){
		$s=$db->dbFetch();
		$minimal_setuju=$s['values'];
	}else{
		$minimal_setuju=10;
	}
	
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

		if($aRow['status_usulan']==0){
			$statusPraoutline='';
		}else if($aRow['status_usulan']==1){
			$statusPraoutline='| <span class="label label-success">Judul Diterima</span>';
		}else if($aRow['status_usulan']==2){
			$statusPraoutline='| <span class="label label-danger">Judul Ditolak</span>';
		}else if($aRow['status_usulan']==3){
			$statusPraoutline='| <span class="label label-danger">Judul Gugur</span>';
		}	


		$row[0]=$aRow['nm_mhs']."<br/>NIM: ".$aRow['nim'];
		$row[1]='<a target="_blank" href="?page=praoutline&menu=review&prid='.$aRow['id'].'">'.$aRow['judul'].'</a>';
		$row[1].='<p>Jumlah Review : <span class="badge badge-info">'.$aRow['jlhreview'].'</span> | Setuju : <span class="badge badge-success"> '.$aRow['setuju'].'</span> | Tidak Setuju : <span class="badge badge-danger">'.$aRow['tdk_setuju'].'</span> '.$statusPraoutline.'</p>';
		$row[2]=$aRow['thn_ajaran']." - ".$aRow['semester'];
		$row[3]=tanggalIndo($aRow['tgl_upload'],'j F Y, H:i');


		if($aRow['found']==0){
			$aksi='<div class="btn-group">
					<a class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" href="#">
						<i class="icon-cog"></i> <span class="caret"></span>
					</a>
					<ul role="menu" class="dropdown-menu pull-right">		
						<li role="presentation">
							<a role="menuitem" tabindex="-1" href="?page=praoutline&menu=kep-draft-praoutline&prid='.$aRow['id'].'">
								<i class="icon-edit"></i> Close
							</a>
						</li>							
					</ul>
				</div>';
		}else{
			$aksi='<div class="btn-group">
					<a class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" href="#">
						<i class="icon-cog"></i> <span class="caret"></span>
					</a>
					<ul role="menu" class="dropdown-menu pull-right">		
						<li role="presentation">
							<a role="menuitem" tabindex="-1" onClick="openrev('.$aRow['id'].')" href="#">
								<i class="icon-edit"></i> Open
							</a>
						</li>							
					</ul>
				</div>';
		}
		
		$row[4]=$aksi;
		if($aRow['setuju']>=$minimal_setuju){
			$output['aaData'][] = $row;
		}
		// print_r($row);
		
	}
	
	echo json_encode( $output );
?>