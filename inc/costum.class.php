<?php
class PagingHalaman{
	// diadaptasikan untuk digunakan bersama bootstrap 2.3.2
	// Fungsi untuk mencek halaman dan posisi data
	function cariPosisi($batas){
		if(empty($_GET['hal'])){
			$posisi=0;
			$_GET['hal']=1;
		}
		else{
			$posisi = ($_GET['hal']-1) * $batas;
		}
		return $posisi;
	}

	// Fungsi untuk menghitung total halaman
	function jumlahHal($jmldata, $batas){
		$jmlhalaman = ceil($jmldata/$batas);
		return $jmlhalaman;
	}

	// Fungsi untuk link halaman 1,2,3 (untuk admin)
	function navHalaman($halaman_aktif, $jmlhalaman){
		
		$page="page=".$_GET['page'];
		$other="";
		if($_GET['modul']!=""){
			$other.="&modul=".$_GET['modul']."";
		}
		if($_GET['list']!=""){
			$other.="&list=".$_GET['list']."";
		}
		if($_GET['sort']!=""){
			$other.="&sort=".$_GET['sort']."";
		}
	
		$link_halaman = "<ul class='page-numbers clearfix'>";
		if($_GET['hal']-1==0){
			//$link_halaman.='<li class="disabled"><span><<</span></li>';
			$link_halaman.='<li><a href="#" class="prev page-numbers">Previous</a></li>';
		}else{
			//$link_halaman.='<li><a href="'.DOMAIN_UTAMA.'/?'.$page.$other.'&hal='.($_GET['hal']-1).'"><<</a></li>';
			$link_halaman.='<li><a href="'.DOMAIN_UTAMA.'/?'.$page.$other.'&hal='.($_GET['hal']-1).'" class="prev page-numbers">Previous</a></li>';
		}
	// Link halaman 1,2,3, ...
		for ($i=1; $i<=$jmlhalaman; $i++){
			if ($i == $halaman_aktif){
				//$link_halaman .= "<b>$i</b> | ";
				//$link_halaman .= '<li class="active"><span>'.$i.'<span></li>';
				$link_halaman .= '<li><span class="page-numbers current">'.$i.'</span></li>';
			}else{
				//$link_halaman .= '<li><a href='.DOMAIN_UTAMA.'/?'.$page.$other.'&hal='.$i.'>'.$i.'</a></li> ';
				$link_halaman .= '<li><a href="'.DOMAIN_UTAMA.'/?'.$page.$other.'&hal='.$i.'" class="page-numbers">'.$i.'</a></li> ';
			}
			
		$link_halaman .= " ";
		}
		if($_GET['hal']==$jmlhalaman){
			//$link_halaman.='<li class="disabled"><span>>></span></li>';
			$link_halaman.='<li style="margin-right: 0px;"><a class="next page-numbers" href="#">Next</a></li>';
		}else{
			//$link_halaman.='<li><a href="'.DOMAIN_UTAMA.'/?'.$page.$other.'&hal='.($_GET['hal']+1).'">>></a></li>';
			$link_halaman.='<li style="margin-right: 0px;"><a class="next page-numbers" href="'.DOMAIN_UTAMA.'/?'.$page.$other.'&hal='.($_GET['hal']+1).'">Next</a></li>';
		}
		$link_halaman .="</ul>";
		
	return $link_halaman;
	}

}
/*
class PagingHalaman{
	// diadaptasikan untuk digunakan bersama bootstrap 2.3.2
	// Fungsi untuk mencek halaman dan posisi data
	function cariPosisi($batas){
		if(empty($_GET['hal'])){
			$posisi=0;
			$_GET['hal']=1;
		}
		else{
			$posisi = ($_GET['hal']-1) * $batas;
		}
		return $posisi;
	}

	// Fungsi untuk menghitung total halaman
	function jumlahHal($jmldata, $batas){
		$jmlhalaman = ceil($jmldata/$batas);
		return $jmlhalaman;
	}

	// Fungsi untuk link halaman 1,2,3 (untuk admin)
	function navHalaman($halaman_aktif, $jmlhalaman){
		
		$page="page=".$_GET['page'];
		$other="";
		if($_GET['modul']!=""){
			$other.="&modul=".$_GET['modul']."";
		}
		if($_GET['list']!=""){
			$other.="&list=".$_GET['list']."";
		}
		if($_GET['sort']!=""){
			$other.="&sort=".$_GET['sort']."";
		}
	
		$link_halaman = "<ul class='page-numbers clearfix'>";
		if($_GET['hal']-1==0){
			//$link_halaman.='<li class="disabled"><span><<</span></li>';
			$link_halaman.='<li><a href="#" class="prev page-numbers">Previous</a></li>';
		}else{
			//$link_halaman.='<li><a href="'.$_SERVER['PHP_SELF'].'?'.$page.$other.'&hal='.($_GET['hal']-1).'"><<</a></li>';
			$link_halaman.='<li><a href="'.$_SERVER['PHP_SELF'].'?'.$page.$other.'&hal='.($_GET['hal']-1).'" class="prev page-numbers">Previous</a></li>';
		}
	// Link halaman 1,2,3, ...
		for ($i=1; $i<=$jmlhalaman; $i++){
			if ($i == $halaman_aktif){
				//$link_halaman .= "<b>$i</b> | ";
				//$link_halaman .= '<li class="active"><span>'.$i.'<span></li>';
				$link_halaman .= '<li><span class="page-numbers current">'.$i.'</span></li>';
			}else{
				//$link_halaman .= '<li><a href='.$_SERVER['PHP_SELF'].'?'.$page.$other.'&hal='.$i.'>'.$i.'</a></li> ';
				$link_halaman .= '<li><a href="'.$_SERVER['PHP_SELF'].'?'.$page.$other.'&hal='.$i.'" class="page-numbers">'.$i.'</a></li> ';
			}
			
		$link_halaman .= " ";
		}
		if($_GET['hal']==$jmlhalaman){
			//$link_halaman.='<li class="disabled"><span>>></span></li>';
			$link_halaman.='<li style="margin-right: 0px;"><a class="next page-numbers" href="#">Next</a></li>';
		}else{
			//$link_halaman.='<li><a href="'.$_SERVER['PHP_SELF'].'?'.$page.$other.'&hal='.($_GET['hal']+1).'">>></a></li>';
			$link_halaman.='<li style="margin-right: 0px;"><a class="next page-numbers" href="'.$_SERVER['PHP_SELF'].'?'.$page.$other.'&hal='.($_GET['hal']+1).'">Next</a></li>';
		}
		$link_halaman .="</ul>";
		
	return $link_halaman;
	}

}
*/
?>