<?php 
session_start();
if(!$_SESSION['login-dosen']){
	header('location:login.php');
}

include ("../inc/helper.php");
include ("../inc/konfigurasi.php");
include ("../inc/db.pdo.class.php");
?>
<!DOCTYPE html>
<!-- Template Name: Clip-One - Responsive Admin Template build with Twitter Bootstrap 3 Version: 1.0 Author: ClipTheme -->
<!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
	<!--<![endif]-->
	<!-- start: HEAD -->
	<head>
		<title>Dashboard - Halaman Dosen</title>
		<!-- start: META -->
		<meta charset="utf-8" />
		<!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="description" />
		<meta content="" name="author" />
		<!-- end: META -->
		<!-- start: MAIN CSS -->
		<link href="../assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" href="../assets/plugins/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="../assets/fonts/style.css">
		<link rel="stylesheet" href="../assets/css/main.css">
		<link rel="stylesheet" href="../assets/css/main-responsive.css">
		<link rel="stylesheet" href="../assets/plugins/iCheck/skins/all.css">
		<link rel="stylesheet" href="../assets/plugins/perfect-scrollbar/src/perfect-scrollbar.css">
		<link rel="stylesheet" href="../assets/css/theme_light.css" id="skin_color">
		<!--[if IE 7]>
		<link rel="stylesheet" href="../assets/plugins/font-awesome/css/font-awesome-ie7.min.css">
		<![endif]-->
		<!-- end: MAIN CSS -->
		<!-- <link rel="shortcut icon" href="../images/logokalbar.png" /> -->

	</head>
	<!-- end: HEAD -->
	<!-- start: BODY -->
	<body class="">
		<!-- start: HEADER -->
		<?php require ("_header.php");?>
		<!-- end: HEADER -->
		<!-- start: MAIN CONTAINER -->
		<div class="main-container">
			<?php require("_navbar.php");?>
			<!-- start: PAGE -->
			<div class="main-content">
				<div class="container">
					<!-- start: PAGE HEADER -->
					<?php
					switch ($_GET['page']){
						default:
							include "page/dashboard/dashboard.php";
						break;

						case 'praoutline':
							include "page/praoutline/praoutline.php";
						break;

						case 'user':
							include "page/user/user.php";
						break;

						case 'skripsi':
							include "page/skripsi/skripsi.php";
						break;

						case 'pengumuman':
							include "page/pengumuman/pengumuman.php";
						break;

						/*case 'pengaturan':
							include "page/pengaturan/pengaturan.php";
						break;*/
					}
					?>
					<!-- end: PAGE CONTENT-->
				</div>
			</div>
			<!-- end: PAGE -->
		</div>
		<!-- end: MAIN CONTAINER -->
		<!-- start: FOOTER -->
		<div class="footer clearfix">
			<?php require "_footer.php";?>
		</div>
		<!-- end: FOOTER -->
		<!-- start: MAIN JAVASCRIPTS -->
		<!--[if lt IE 9]>
		<script src="../assets/plugins/respond.min.js"></script>
		<script src="../assets/plugins/excanvas.min.js"></script>
		<![endif]-->
		<script src="../js/jquery-1.8.3.min.js"></script>
		<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
		<script src="../assets/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>
		<script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
		<script src="../assets/plugins/blockUI/jquery.blockUI.js"></script>
		<script src="../assets/plugins/iCheck/jquery.icheck.min.js"></script>
		<script src="../assets/plugins/perfect-scrollbar/src/jquery.mousewheel.js"></script>
		<script src="../assets/plugins/perfect-scrollbar/src/perfect-scrollbar.js"></script>
		<script src="../assets/js/main.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#btnLogout").click(function(){
					if(confirm("Keluar dari halaman ini ??")){
						$.ajax({
							url:'act.auth.php',
							cache:false,
							type:'post',
							data:'act=logout',
							dataType:'json',
							success:function(json){
								if(json.result){
									location.href='<?php echo DOMAIN_UTAMA;?>';
								}
							}
						});
					}
					return false;
				});
			});
		</script>
		<!-- end: MAIN JAVASCRIPTS -->
		
	<?php
	switch ($_GET['page']){
		default:
			include "../assets/js/dosen/_dashboard.php";
		break;

		case 'praoutline':
			include "../assets/js/dosen/_praoutline.php";
		break;

		case 'skripsi':
			include "../assets/js/dosen/_skripsi.php";
		break;

		case 'user':
			include "../assets/js/dosen/_user.php";
		break;

		case 'pengumuman':
			include "../assets/js/dosen/_pengumuman.php";
		break;

		/*case 'pengaturan':
			include "../assets/js/admin/_pengaturan.php";
		break;*/

		
	}
	?>
	</body>
	<!-- end: BODY -->
</html>
