<div class="navbar navbar-inverse navbar-fixed-top">
	<!-- start: TOP NAVIGATION CONTAINER -->
	<div class="container">
		<div class="navbar-header">
			<!-- start: RESPONSIVE MENU TOGGLER -->
			<button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
				<span class="clip-list-2"></span>
			</button>
			<!-- end: RESPONSIVE MENU TOGGLER -->
			<!-- start: LOGO -->
			<a class="navbar-brand" href="dashboard.php">
				<!-- CLIP<i class="clip-clip"></i>ONE -->
				ADMIN - SPOTA UNTAN 
				<?php 
					if (isset($_SESSION['login-admin']['nmprodi'])){ 
					echo strtoupper("(Prodi ".$_SESSION['login-admin']['nmprodi'].")"); 
					}
				?>
			</a>
			<!-- end: LOGO -->
		</div>
		<div class="navbar-tools">
			<!-- start: TOP NAVIGATION MENU -->
			<ul class="nav navbar-right" style="padding:0">
				<li class="dropdown current-user">
					<a data-toggle="dropdown" class="dropdown-toggle" href="#">
						<!-- <img src="assets/images/avatar-1-small.jpg" class="circle-img" alt=""> -->
						<i class="clip-user"></i>
						<span class="username"><?php echo $_SESSION['login-admin']['nama_lengkap'];?></span>
						<i class="clip-chevron-down"></i>
					</a>
					<ul class="dropdown-menu">
						<li>
							<a href="?page=user&menu=my-profile">
								<i class="clip-user-2"></i>
								&nbsp;Profil Admin
							</a>
						</li>
						<!-- <li class="divider"></li> -->
						<!-- <li>
							<a href="utility_lock_screen.html"><i class="clip-locked"></i>
								&nbsp;Lock Screen </a>
						</li> 
						<li>
							<a href="<?php echo DOMAIN_UTAMA;?>" target="_blank">
								<i class="icon-external-link"></i>
								&nbsp;Web Repositori
							</a>
						</li>-->
						<li>
							<a href="#" id="btnLogout">
								<i class="clip-exit"></i>
								&nbsp;Log Out
							</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>