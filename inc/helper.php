<?php
/* 
--------------------------------------------------------------------
Ridwan Tasa Dirsa(ridw4n.id@gmail.com)
(c) 2013
--------------------------------------------------------------------
*/

//redirect halaman
if (!function_exists('redirect')){
	function redirect($delay, $url) 
	{
		echo "<meta http-equiv='refresh' content=$delay;url=$url>";
	}
}

// heading h1 - h6
if (!function_exists('heading')){
	function heading($title, $size, $param) 
	{
		$heading = "<h$size $param>$title</h$size>";
		return $heading;
	}
}
//baris
if ( ! function_exists('br')){
	function br($num = 1)
	{
		return str_repeat("<br />", $num);
	}
}
//stylesheet
if (!function_exists('loadCss')){
	function loadCss($url,$echo=TRUE) 
	{
		$loadCss = "<link rel='stylesheet' href=$url type='text/css'/>";
		if($echo==TRUE){
			echo $loadCss."\n";
		}else{
			return $loadCss;
		}
	}
}

//javascript
if (!function_exists('loadJs')){
	function loadJs($url,$echo=TRUE) 
	{
		$loadJs = "<script type='text/javascript' src=$url></script>";
		if($echo==TRUE){
			echo $loadJs;
		}else{
			return $loadJs;
		}
	}
}
//image
if (!function_exists('img')){
	function img($img, $param) 
	{
		$img = "<img src='$img' $param/>";
		return $img;
	}
}
// spasi
if (!function_exists('spasi')){
	function spasi($count) 
	{
		for ($i = 1; $i <= $count; $i++) {
			echo '&nbsp;';
		}
	}
}
// tag meta
if (!function_exists('meta')){
	function meta($name, $content) 
	{
		$meta = "<meta name='$name' content='$content'>";
		return $meta;
	}
}

//load file// gagal
if(!function_exists('loadFile')){
	function loadFile($link,$type="inlcude")
	{
		if(file_exists($link)){
			switch($type){
				case 'include':
					include $link;
				break;
				case 'include_once':
					include_once $link;
				break;
				case 'require':
					require $link;
				break;
				case 'require_once':
					require_once $link;
				break;
			}
		}else{
			echo "<div style='text-align:center' class='alert alert-error'>File yang diload tidak ditemukan.</div>";
		}
	}
} 

function addExtraZero($data, $len) {
	$y = $len - strlen($data);
	while(strlen($x) < $y) {
		$x .= "0";
	}
	return $x . $data;
}

function uangIndo($uang) {
    return number_format($uang, 2, ',', '.');
}

function terbilang($x) {
      $abil = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
      if ($x < 12)
        return " " . $abil[$x];
      elseif ($x < 20)
        return Terbilang($x - 10) . "Belas";
      elseif ($x < 100)
        return Terbilang($x / 10) . " Puluh" . terbilang($x % 10);
      elseif ($x < 200)
        return " seratus" . Terbilang($x - 100);
      elseif ($x < 1000)
        return Terbilang($x / 100) . " Ratus" . terbilang($x % 100);
      elseif ($x < 2000)
        return " seribu" . Terbilang($x - 1000);
      elseif ($x < 1000000)
        return Terbilang($x / 1000) . " Ribu" . terbilang($x % 1000);
      elseif ($x < 1000000000)
        return Terbilang($x / 1000000) . " Juta" . terbilang($x % 1000000);
    }

function tanggalIndo($waktu, $format) { //{tanggalIndoTiga tgl=0000-00-00 00:00:00 format="l, d/m/Y H:i:s"}
	if($waktu == "0000-00-00" || !$waktu || $waktu == "0000-00-00 00:00:00") {
		$rep = "";
	} else {
		if(preg_match('/-/', $waktu)) {
			$tahun = substr($waktu,0,4);
			$bulan = substr($waktu,5,2);
			$tanggal = substr($waktu,8,2);
		} else {
			$tahun = substr($waktu,0,4);
			$bulan = substr($waktu,4,2);
			$tanggal = substr($waktu,6,2);
		}

		$jam = substr($waktu,11,2);
		$menit= substr($waktu,14,2);
		$detik = substr($waktu,17,2);
		$hari_en = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
		$hari_id = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu");
		$bulan_en = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		$bulan_id = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
		$ret = @date($format, @mktime($jam, $menit, $detik, $bulan, $tanggal, $tahun));

		$replace_hari = str_replace($hari_en, $hari_id, $ret);
		$rep = str_replace($bulan_en, $bulan_id, $replace_hari);
		$rep = nl2br($rep);
	}
	return $rep;
}

function bulanIndo($waktu, $format) {
	if(!$waktu) {
		$waktu = date("m");
	}
	$tahun = date("Y");
	$bulan_en = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

	$bulan_id = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
	$ret = date($format, mktime(1, 1, 1, $waktu, 1, $tahun));
	$replace_bulan = str_replace($bulan_en, $bulan_id, $ret);
	return $replace_bulan;
}
//--- gambar ----//
function cektypegambar($type) { 
	if(!($type=="image/jpeg" || $type=="image/pjpeg" || $type=="image/png" || $type=="image/gif")) { 
		return FALSE; 
	}else { 
		return TRUE; 
	}	
} 

function get_ext($imgname){
	$a=explode('.',$imgname);
	$jlh=count($a);
	$ext=$a[$jlh-1];
	return $ext;
}

// This function will proportionally resize image 
function resizeImage($CurWidth,$CurHeight,$MaxSize,$DestFolder,$SrcImage,$Quality,$ImageType)
{
	//Check Image size is not 0
	if($CurWidth <= 0 || $CurHeight <= 0) 
	{
		return false;
	}
	
	//Construct a proportional size of new image
	$ImageScale      	= min($MaxSize/$CurWidth, $MaxSize/$CurHeight); 
	$NewWidth  			= ceil($ImageScale*$CurWidth);
	$NewHeight 			= ceil($ImageScale*$CurHeight);
	
	if($CurWidth < $NewWidth || $CurHeight < $NewHeight)
	{
		$NewWidth = $CurWidth;
		$NewHeight = $CurHeight;
	}
	$NewCanves 	= imagecreatetruecolor($NewWidth, $NewHeight);
	// Resize Image
	if(imagecopyresampled($NewCanves, $SrcImage,0, 0, 0, 0, $NewWidth, $NewHeight, $CurWidth, $CurHeight))
	{
		switch(strtolower($ImageType))
		{
			case 'image/png':
				imagepng($NewCanves,$DestFolder);
				break;
			case 'image/gif':
				imagegif($NewCanves,$DestFolder);
				break;			
			case 'image/jpeg':
			case 'image/pjpeg':
				imagejpeg($NewCanves,$DestFolder,$Quality);
				break;
			default:
				return false;
		}
	//Destroy image, frees up memory	
	if(is_resource($NewCanves)) {imagedestroy($NewCanves);} 
	return true;
	}

}

//This function corps image to create exact square images, no matter what its original size!
function cropImage($CurWidth,$CurHeight,$iSize,$DestFolder,$SrcImage,$Quality,$ImageType)
{	 
	//Check Image size is not 0
	if($CurWidth <= 0 || $CurHeight <= 0) 
	{
		return false;
	}
	
	//abeautifulsite.net has excellent article about "Cropping an Image to Make Square"
	//http://www.abeautifulsite.net/blog/2009/08/cropping-an-image-to-make-square-thumbnails-in-php/
	if($CurWidth>$CurHeight)
	{
		$y_offset = 0;
		$x_offset = ($CurWidth - $CurHeight) / 2;
		$square_size 	= $CurWidth - ($x_offset * 2);
	}else{
		$x_offset = 0;
		$y_offset = ($CurHeight - $CurWidth) / 2;
		$square_size = $CurHeight - ($y_offset * 2);
	}
	
	$NewCanves 	= imagecreatetruecolor($iSize, $iSize);	
	if(imagecopyresampled($NewCanves, $SrcImage,0, 0, $x_offset, $y_offset, $iSize, $iSize, $square_size, $square_size))
	{
		switch(strtolower($ImageType))
		{
			case 'image/png':
				imagepng($NewCanves,$DestFolder);
				break;
			case 'image/gif':
				imagegif($NewCanves,$DestFolder);
				break;			
			case 'image/jpeg':
			case 'image/pjpeg':
				imagejpeg($NewCanves,$DestFolder,$Quality);
				break;
			default:
				return false;
		}
	//Destroy image, frees up memory	
	if(is_resource($NewCanves)) {imagedestroy($NewCanves);} 
	return true;
	}
	  
}
function get_client_ip() {
     $ipaddress = '';
     if ($_SERVER['HTTP_CLIENT_IP'])
         $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
     else if($_SERVER['HTTP_X_FORWARDED_FOR'])
         $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
     else if($_SERVER['HTTP_X_FORWARDED'])
         $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
     else if($_SERVER['HTTP_FORWARDED_FOR'])
         $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
     else if($_SERVER['HTTP_FORWARDED'])
         $ipaddress = $_SERVER['HTTP_FORWARDED'];
     else if($_SERVER['REMOTE_ADDR'])
         $ipaddress = $_SERVER['REMOTE_ADDR'];
     else
         $ipaddress = 'UNKNOWN';

     return $ipaddress; 
}

function set_namepost($id,$title){
	$url=$id."-".str_replace(" ","-",strtolower($title));
	return $url;
}

function getid_fromurl($url){
	$url=explode('-',$url);
	$id=$url[0];
	return $id;
}

function show_level($lvl){
	$text="";
	if(substr($lvl,0,1)==9){
		if($text!=""){
			$text.="| Berita ";
		}else{
			$text.="Berita ";
		}	
	}
	if(substr($lvl,1,1)==9){
		if($text!=""){
			$text.="| Agenda ";
		}else{
			$text.="Agenda ";
		}	
	}
	if(substr($lvl,2,1)==9){
		if($text!=""){
			$text.="| Pengumuman ";
		}else{
			$text.="Pengumuman ";
		}	
	}
	if(substr($lvl,3,1)==9){
		if($text!=""){
			$text.="| Repositori ";
		}else{
			$text.="Repositori ";
		}	
	}
	if(substr($lvl,4,1)==9){
		if($text!=""){
			$text.="| Galeri ";
		}else{
			$text.="Galeri ";
		}	
	}
	
	return $text;
}

function show_error($judul,$pesan,$jenis)
{
	switch ($jenis) {
		case 'fullpage':
			$error='<div class="row-fluid">
				<div class="span12">
			    	<section class="error-404 clearfix">
			            <div class="left-col">
			                <p>404</p>
			            </div><!--left-col-->
			            <div class="right-col">
			                <h1>'.$judul.'</h1>
			                <p>'.$pesan.'</p>
			                <ul class="arrow-list">
			                    <li><a style="cursor:pointer" onclick="history.go(-1);">Kembali ke halaman sebelumnya</a></li>
			                    <li><a href="<?php echo DOMAIN_UTAMA;?>">Menuju Homepage</a></li>
			                </ul>
			            </div>
			        </section>
			    </div>
			</div>';
		break;
		case 'withsidebar':
			$error='<div id="main-col">
				<section class="error-404 clearfix">
					<div class="left-col">
						<p>404</p>
					</div>
					<div class="right-col">
						<h1>'.$judul.'</h1>
						<p>'.$pesan.'</p>
						<ul class="arrow-list">
							<li><a style="cursor:pointer" onclick="history.go(-1);">Kembali ke halaman sebelumnya</a></li>
							<li><a href="<?php echo DOMAIN_UTAMA;?>">Menuju Homepage</a></li>
						</ul>
					</div>
				</section>
			</div>';
		break;
		default:
			$error="";
		break;
	}

	return $error;
}

function bbcode_quote($text,$jenis=null){
	$code = array ( "'\[quote=(.*?);(.*?)\](.*?)'i", "'\[/quote\]'i" );

	if($jenis!=null){
		$html = array ( "<blockquote> \\3", "</blockquote> " );
	}else{
		$html = array ( "<blockquote> Dipost oleh: \\1 <i>(\\2)</i><br />\\3", "</blockquote> \n" );		
	}

	$newtext=preg_replace ( $code, $html, $text );

	return $newtext;		
}

function set_session($name,$value){
	$_SESSION[$name]=$value;
}

function unset_session($name){
	unset($_SESSION[$name]);
}

function get_session($name){
	$value=$_SESSION[$name];
	return $value;
}


function selisih_tgl($date1,$date2){
	$diff = abs(strtotime($date2) - strtotime($date1));

	$data['tahun'] = floor($diff / (365*60*60*24));
	$data['bulan'] = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	$data['hari'] = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

	return $data;
}

?>