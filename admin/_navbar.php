<?php $db=new dB($dbsetting); 
$lvl=$_SESSION['login-admin']['lvl'];

?>
<div class="navbar-content">
	<!-- start: SIDEBAR -->
	<div class="main-navigation navbar-collapse collapse">
		<!-- start: MAIN MENU TOGGLER BUTTON -->
		<div class="navigation-toggler">
			<i class="clip-chevron-left"></i>
			<i class="clip-chevron-right"></i>
		</div>
		<!-- end: MAIN MENU TOGGLER BUTTON -->
		<!-- start: MAIN NAVIGATION MENU -->
		<ul class="main-navigation-menu">
			<li <?php echo ($_GET['page']=="")?'class="active open"':'';?>>
				<a href="dashboard.php">
					<i class="clip-home-3"></i>
					<span class="title"> Dashboard </span><span class="selected"></span>
				</a>
			</li>
			<li <?php echo ($_GET['page']=="data")?'class="active open"':'';?>>
				<a href="javascript:void(0)">
					<i class="clip-pencil-2"></i>
					<span class="title"> Manajemen Data </span><i class="icon-arrow"></i>
					<span class="selected"></span>
				</a>
				<ul class="sub-menu">
					<?php if($lvl!='S'){?>
					<li <?php echo ($_GET['page']=="data" AND $_GET['menu']=="data-mahasiswa")?'class="active open"':'';?> >
						<a href="?page=data&menu=data-mahasiswa">
							<span class="title"> Data Mahasiswa </span>
						</a>
					</li>
					<li <?php echo ($_GET['page']=="data" AND $_GET['menu']=="data-dosen")?'class="active open"':'';?>>
						<a href="?page=data&menu=data-dosen">
							<span class="title"> Data Dosen </span>
						</a>
					</li>
					<?php 
					} else{?>
					<li <?php echo ($_GET['page']=="data" AND $_GET['menu']=="data-fakultas")?'class="active open"':'';?>>
						<a href="?page=data&menu=data-fakultas">
							<span class="title"> Data Fakultas </span>
						</a>
					</li>
					<li <?php echo ($_GET['page']=="data" AND $_GET['menu']=="data-jurusan")?'class="active open"':'';?>>
						<a href="?page=data&menu=data-jurusan">
							<span class="title"> Data Jurusan </span>
						</a>
					</li>
					<li <?php echo ($_GET['page']=="data" AND $_GET['menu']=="data-prodi")?'class="active open"':'';?>>
						<a href="?page=data&menu=data-prodi">
							<span class="title"> Data Program Studi </span>
						</a>
					</li>
					<?php } ?>
				</ul>
			</li>
			<?php if($lvl!='S'){?>
			<li <?php echo ($_GET['page']=="praoutline")?'class="active open"':'';?>>
				<a href="javascript:void(0)">
					<i class="clip-stack"></i>
					<span class="title"> Praoutline </span><i class="icon-arrow"></i><span class="selected"></span>
				</a>
				<!-- <ul class="sub-menu">
					<li <?php echo ($_GET['page']=="praoutline" AND $_GET['menu']=="statistik")?'class="active open"':'';?>>
						<a href="?page=praoutline&menu=statistik">
							<span class="title"> Statistik </span>
						</a>
					</li>
				</ul> -->
				<ul class="sub-menu">
					<li <?php echo ($_GET['page']=="praoutline" AND $_GET['menu']=="new")?'class="active open"':'';?>>
						<a href="?page=praoutline&menu=new">
							<span class="title">Daftar Draft Praoutline </span>
						</a>
					</li>
				</ul>
				<ul class="sub-menu">
					<li <?php echo ($_GET['page']=="praoutline" AND $_GET['menu']=="cari")?'class="active open"':'';?>>
						<a href="?page=praoutline&menu=cari">
							<span class="title"> Pencarian </span>
						</a>
					</li>
				</ul>
				<ul class="sub-menu">
					<li <?php echo ($_GET['page']=="praoutline" AND $_GET['menu']=="keputusan")?'class="active open"':'';?>>
						<a href="?page=praoutline&menu=keputusan">
							<span class="title"> Kep. Penunjukan Dosen </span>
						</a>
					</li>
				</ul>
				<ul class="sub-menu">
					<li <?php echo ($_GET['page']=="praoutline" AND $_GET['menu']=="kep-draft-praoutline")?'class="active open"':'';?>>
						<a href="?page=praoutline&menu=kep-draft-praoutline">
							<span class="title"> Kep. Draft Praoutline </span>
						</a>
					</li>
				</ul>
				<ul class="sub-menu">
					<li <?php echo ($_GET['page']=="praoutline" AND $_GET['menu']=="pemberitahuan")?'class="active open"':'';?>>
						<a href="?page=praoutline&menu=pemberitahuan">
							<span class="title"> Pemberitahuan </span>
						</a>
					</li>
				</ul>
				<ul class="sub-menu">
					<li <?php echo ($_GET['page']=="praoutline" AND $_GET['menu']=="statistik")?'class="active open"':'';?>>
						<a href="?page=praoutline&menu=statistik">
							<span class="title"> Statistik </span>
						</a>
					</li>
				</ul>
			</li>
			<li <?php echo ($_GET['page']=="pengumuman")?'class="active open"':'';?>>
				<a href="javascript:void(0)">
					<i class="clip-list-2"></i>
					<span class="title"> Pengumuman </span><i class="icon-arrow"></i><span class="selected"></span>
				</a>
				<ul class="sub-menu">
					<li <?php echo ($_GET['page']=="pengumuman" AND $_GET['menu']=="daftar-pengumuman")?'class="active open"':'';?> >
						<a href="?page=pengumuman&menu=daftar-pengumuman">
							<span class="title"> Daftar Pengumuman </span>
						</a>
					</li>
					<li <?php echo ($_GET['page']=="pengumuman" AND $_GET['menu']=="buat-pengumuman")?'class="active open"':'';?>>
						<a href="?page=pengumuman&menu=buat-pengumuman">
							<span class="title"> Buat Pengumuman Baru </span>
						</a>
					</li>
				</ul>
			</li>

			<li <?php echo ($_GET['page']=="jadwal")?'class="active open"':'';?>>
				<a href="javascript:void(0)">
					<i class="clip-note"></i>
					<span class="title"> Jadwal Seminar/Sidang</span><i class="icon-arrow"></i><span class="selected"></span>
				</a>
				<ul class="sub-menu">
					<li <?php echo ($_GET['page']=="jadwal" AND $_GET['menu']!="kalender")?'class="active open"':'';?> >
						<a href="?page=jadwal">
							<span class="title"> Manajemen Data </span>
						</a>
					</li>
					<li <?php echo ($_GET['page']=="jadwal" AND $_GET['menu']=="kalender")?'class="active open"':'';?>>
						<a href="?page=jadwal&menu=kalender">
							<span class="title"> Kalender </span>
						</a>
					</li>
				</ul>
			</li>
			<?php }?>
			<li <?php echo ($_GET['page']=="user")?'class="active open"':'';?>>
				<a href="javascript:void(0)">
					<i class="clip-user-2"></i>
					<span class="title"> User </span><i class="icon-arrow"></i><span class="selected"></span>
				</a>
				<ul class="sub-menu">
					<?php if($lvl=='S'){?>
					<li <?php echo ($_GET['page']=="user" AND $_GET['menu']=="man-user")?'class="active open"':'';?>>
						<a href="?page=user&menu=man-user">
							<span class="title"> Manajemen Administrator Prodi </span>
						</a>
					</li>
					<?php } ?>
					<li <?php echo ($_GET['page']=="user" AND $_GET['menu']=="my-profile")?'class="active open"':'';?>>
						<a href="?page=user&menu=my-profile">
							<span class="title"> Profil Saya </span>
						</a>
					</li>
				</ul>
			</li>
			<?php if($lvl!='S'){?>
			<li <?php echo ($_GET['page']=="pengaturan")?'class="active open"':'';?>>
				<a href="?page=pengaturan">
					<i class="clip-cogs"></i>
					<span class="title"> Pengaturan </span>
				</a>
			</li>
			<?php }?>
			
		</ul>
		<!-- end: MAIN NAVIGATION MENU -->
	</div>
	<!-- end: SIDEBAR -->
</div>