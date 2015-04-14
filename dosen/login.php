<!DOCTYPE html>
<!-- Template Name: Clip-One - Responsive Admin Template build with Twitter Bootstrap 3 Version: 1.0 Author: ClipTheme -->
<!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
	<!--<![endif]-->
	<!-- start: HEAD -->
	<head>
		<title>LOGIN DOSEN - SPOTA UNTAN</title>		
		<link rel="shortcut icon" href="../img/logountan.png">
		<!-- start: META -->
		<meta charset="utf-8" />
		<!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="spota, untan, sistem pendukung, tugas akhir" name="description" />
		<meta content="universitas tanjungpura" name="author" />
		<!-- end: META -->
		<!-- start: MAIN CSS -->
		<link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" href="../assets/plugins/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="../assets/fonts/style.css">
		<link rel="stylesheet" href="../assets/css/main.css">
		<!--[if IE 7]>
		<link rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome-ie7.min.css">
		<![endif]-->
		<!-- end: MAIN CSS -->
		<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
		<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
	</head>
	<!-- end: HEAD -->
	<!-- start: BODY -->
	<body class="login example2">
		<div class="main-login col-sm-4 col-sm-offset-4">
			<div class="logo"><!-- <img style="width:60px;height:60px; margin-right:10px" src="../img/untanlogo.png"/> -->SPOTA UNIVERSITAS TANJUNGPURA
			</div>
			<!-- start: LOGIN BOX -->
			<div class="box-login">
				<h3>LOGIN DOSEN</h3>
				<p>
					Silakan masukkan username (NIP) dan password anda.
				</p>
				<form class="form-login" action="" method="POST">
					<input type="hidden" name="act" value="login" />
					<div class="errorHandler alert alert-danger no-display">
						<i class="fa fa-remove-sign"></i> Ada kesalahan, silakan diperiksa kembali.
					</div>
					<fieldset>
						<div class="form-group">
							<span class="input-icon">
								<input type="text" class="form-control" name="username" placeholder="Masukkan NIP Anda">
								<i class="fa fa-user"></i> </span>
						</div>
						<div class="form-group form-actions">
							<span class="input-icon">
								<input type="password" class="form-control password" name="password" placeholder="Masukkan Password Anda">
								<i class="fa fa-lock"></i>
								<a class="forgot" href="#">
									Lupa Password
								</a> </span>
						</div>
						<div class="form-actions">
							<button type="submit" class="btn btn-bricky pull-right">
								Login <i class="fa fa-arrow-circle-right"></i>
							</button>
						</div>
					</fieldset>
				</form>
			</div>
			<!-- end: LOGIN BOX -->
			<!-- start: FORGOT BOX -->
			<div class="box-forgot">
				<h3>Lupa Password?</h3>
				<p>
					Silakan masukkan email anda.
				</p>
				<form class="form-forgot" action="" method="POST">
					<input type="hidden" name="act" value="recoverpass" />
					<div class="errorHandler alert alert-danger no-display">
						<i class="fa fa-remove-sign"></i> Ada kesalahan, silakan dicek terlebih dahulu
					</div>
					<fieldset>
						<div class="form-group">
							<span class="input-icon">
								<input type="email" class="form-control" name="email" placeholder="Email">
								<i class="fa fa-envelope"></i> </span>
						</div>
						<div class="form-actions">
							<button class="btn btn-light-grey go-back">
								<i class="fa fa-circle-arrow-left"></i> Kembali
							</button>
							<button type="submit" class="btn btn-bricky pull-right">
								Submit <i class="fa fa-arrow-circle-right"></i>
							</button>
						</div>
					</fieldset>
				</form>
			</div>
			<!-- end: FORGOT BOX -->
			
			<!-- end: REGISTER BOX -->
			<!-- start: COPYRIGHT -->
			<div class="copyright">
				2014 &copy; Universitas Tanjungpura.
			</div>
			<!-- end: COPYRIGHT -->
		</div>
		<!-- start: MAIN JAVASCRIPTS -->
		<!--[if lt IE 9]>
		<script src="assets/plugins/respond.min.js"></script>
		<script src="assets/plugins/excanvas.min.js"></script>
		<![endif]-->
		<script src="../js/jquery-1.8.3.min.js"></script>
		<script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>	
		<script src="../assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
		<script src="../assets/js/admin/login.js"></script>
		<!-- end: MAIN JAVASCRIPTS -->
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script>
			jQuery(document).ready(function() {
				Login.init();
			});
		</script>
	</body>
	<!-- end: BODY -->
</html>