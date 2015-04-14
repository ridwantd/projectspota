<?php $db=new dB($dbsetting); 
$lvl=$_SESSION['login-dosen']['lvl'];

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
			<li <?php echo ($_GET['page']=="praoutline")?'class="active open"':'';?>>
				<a href="javascript:void(0)">
					<i class="clip-stack"></i>
					<span class="title"> Praoutline </span><i class="icon-arrow"></i><span class="selected"></span>
				</a>
				<ul class="sub-menu">
					<li <?php echo ($_GET['page']=="praoutline" AND $_GET['menu']=="statistik")?'class="active open"':'';?>>
						<a href="?page=praoutline&menu=statistik">
							<span class="title"> Statistik </span>
						</a>
					</li>
				</ul> 
				<ul class="sub-menu">
					<li <?php echo ($_GET['page']=="praoutline" AND $_GET['menu']=="new")?'class="active open"':'';?>>
						<a href="?page=praoutline&menu=new">
							<span class="title">Daftar Draft Praoutline </span>
						</a>
					</li>
				</ul>
				<ul class="sub-menu">
					<li <?php echo ($_GET['page']=="praoutline" AND $_GET['menu']=="myreview")?'class="active open"':'';?>>
						<a href="?page=praoutline&menu=myreview">
							<span class="title"> Review Saya </span>
						</a>
					</li>
				</ul>
				<!-- <ul class="sub-menu">
					<li <?php echo ($_GET['page']=="praoutline" AND $_GET['menu']=="daftar-praoutline")?'class="active open"':'';?>>
						<a href="?page=praoutline&menu=daftar-praoutline">
							<span class="title"> Daftar Praoutline </span>
						</a>
					</li>
				</ul> -->
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
				<?php
				if($_SESSION['login-dosen']['jenisdosen']=='K'){
				?>
				<ul class="sub-menu">
					<li <?php echo ($_GET['page']=="praoutline" AND $_GET['menu']=="kep-draft-praoutline")?'class="active open"':'';?>>
						<a href="?page=praoutline&menu=kep-draft-praoutline">
							<span class="title"> Kep. Draft Praoutline </span>
						</a>
					</li>
				</ul>
				<?php
				}
				?>
				<ul class="sub-menu">
					<li <?php echo ($_GET['page']=="praoutline" AND $_GET['menu']=="pemberitahuan")?'class="active open"':'';?>>
						<a href="?page=praoutline&menu=pemberitahuan">
							<span class="title"> Pemberitahuan </span>
						</a>
					</li>
				</ul>
			</li>
			<li <?php echo ($_GET['page']=="skripsi")?'class="active open"':'';?>>
				<a href="javascript:void(0)">
					<i class="clip-stack"></i>
					<span class="title"> Tugas Akhir </span><i class="icon-arrow"></i><span class="selected"></span>
				</a>
				<?php
				$nip=$_SESSION['login-dosen']['nip'];
				$new="SELECT 
						td.*,						
						tr.*,
						COUNT(tr.status) as jlhreview
					FROM tbdiskusi td
					LEFT JOIN tbreviewdiskusi tr ON (td.idDiskusi=tr.idDiskusi)
					WHERE td.idDiskusi=tr.idDiskusi and tr.reviewer not like '$nip' and tr.status='0' group by td.pemb";
					$db->runQuery($new);
					$cnt=$db->dbFetch();
					if($db->dbRows()>0){ $i=$cnt['jlhreview'];}else{ $i='0';}
				?>
				<ul class="sub-menu">
					<li <?php echo ($_GET['page']=="skripsi" AND $_GET['menu']=="bimbingan")?'class="active open"':'';?>>
						<a href="?page=skripsi&menu=bimbingan">
							<span class="title"> Bimbingan Terbaru (<?php echo "<b>$i</b>";?>)</span>
						</a>
					</li>
				</ul>
				<ul class="sub-menu">
					<li <?php echo ($_GET['page']=="skripsi" AND $_GET['menu']=="forum")?'class="active open"':'';?>>
						<a href="?page=skripsi&menu=forum">
							<span class="title"> Forum Pembimbing </span>
						</a>
					</li>
				</ul>
				<!-- <ul class="sub-menu">
					<li <?php echo ($_GET['page']=="skripsi" AND $_GET['menu']=="jadwal")?'class="active open"':'';?>>
						<a href="?page=skripsi&menu=jadwal">
							<span class="title"> Jadwal Seminar dan Sidang </span>
						</a>
					</li>
				</ul> -->
			</li> 
			<li <?php echo ($_GET['page']=="pengumuman")?'class="active open"':'';?>>
				<a href="dashboard.php?page=pengumuman">
					<i class="clip-list-2"></i>
					<span class="title"> Pengumuman </span><span class="selected"></span>
				</a>
			</li>
			<li <?php echo ($_GET['page']=="user")?'class="active open"':'';?>>
				<a href="javascript:void(0)">
					<i class="clip-user-2"></i>
					<span class="title"> User </span><i class="icon-arrow"></i><span class="selected"></span>
				</a>
				<ul class="sub-menu">
					<li <?php echo ($_GET['page']=="user" AND $_GET['menu']=="my-profile")?'class="active open"':'';?>>
						<a href="?page=user&menu=my-profile">
							<span class="title"> Profil Saya </span>
						</a>
					</li>
				</ul>
			</li>
		</ul>
		<!-- end: MAIN NAVIGATION MENU -->
	</div>
	<!-- end: SIDEBAR -->
</div>