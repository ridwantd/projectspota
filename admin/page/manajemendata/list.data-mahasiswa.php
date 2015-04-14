<?php
	session_start();
	$idlogin=$_SESSION['login-admin']['id'];
	$prodiadmin=$_SESSION['login-admin']['prodi'];
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */
	
	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
	$aColumns = array('tm.nim','tm.nmLengkap', 'tp.nmProdi', 'tm.thnmasuk');
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "tm.idmhs";
	
	/* DB table to use */
	$sTable = "tbmhs tm ";
	
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
	$sOrder = "";
	if ( isset( $_GET['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
		{
			if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
			{
				$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
					($_GET['sSortDir_'.$i]==='desc' ? 'asc' : 'desc') .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}
	
	/* 
	 * Filtering
	 * NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here, but concerned about efficiency
	 * on very large tables, and MySQL's regex functionality is very limited
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
	if($_SESSION['login-admin']['lvl']!='S'){
		if($sWhere!=''){
			$where2="AND tp.idProdi = $prodiadmin";
		}else{
			$where2="WHERE tp.idProdi = $prodiadmin";
		}
	}
	/*
	 * SQL queries
	 * Get data to display
	 */
	$sQuery0 = "
	SELECT tm.idmhs, tm.nim, tm.nmLengkap, tm.thnmasuk, tm.email, tm.status, tp.nmProdi
	FROM   $sTable LEFT JOIN tbprodi tp ON(tp.idProdi=tm.idProdi)
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
		SELECT COUNT(idmhs) as total FROM tbmhs 
	";
	$db->runQuery($sQuery2);
	$aResultTotal = $db->dbFetch();
	$iTotal = $aResultTotal['total'];

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

		if($aRow['status']=="N"){
			$badge=' - <span class="label label-warning"> tidak aktif</span>';
			$tombol='<li role="presentation">
								<a role="menuitem" tabindex="-1" href="#" onClick="AktifkanAkunMhs('.$aRow['idmhs'].')">
									<i class="clip-checkmark-circle-2"></i> Aktifkan Akun
								</a>
							</li>';
		}else{
			$badge='';
			$tombol='<li role="presentation">
								<a role="menuitem" tabindex="-1" href="#" onClick="NonaktifkanAkunMhs('.$aRow['idmhs'].')">
									<i class="clip-cancel-circle-2"></i> Nonaktifkan
								</a>
							</li>';
		}

		$row[0]=$aRow['nmLengkap'].$badge;
		$row[1]=$aRow['nim'];
		$row[2]=$aRow['thnmasuk'];
		$aksi='<div class="btn-group">
						<a class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" href="#">
							<i class="icon-cog"></i> <span class="caret"></span>
						</a>
						<ul role="menu" class="dropdown-menu pull-right">
							'.$tombol.'
							<li role="presentation">
								<a role="menuitem" tabindex="-1" href="?page=data&menu=data-mahasiswa&act=edit&id='.$aRow['idmhs'].'">
									<i class="icon-edit"></i> Edit
								</a>
							</li>							
							<li role="presentation">
								<a role="menuitem" tabindex="-1" href="#" onClick="HapusMhs('.$aRow['idmhs'].')">
									<i class="icon-remove"></i> Hapus
								</a>
							</li>
						</ul>
					</div>';
		if($_SESSION['login-admin']['lvl']=='S'){
			$row[3]=$aRow['nmProdi'];
			$row[4]=$aksi;
		}else{
			$row[3]=$aksi;
		}
		

		$output['aaData'][] = $row;
		// print_r($row);
		
	}
	
	echo json_encode( $output );
?>