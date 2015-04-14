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
			<li <?php echo ($_GET['page']=="praoutline")?'class="active open"':'';?>>
				<a href="javascript:void(0)">
					<i class="clip-stack"></i>
					<span class="title"> Praoutline </span><i class="icon-arrow"></i><span class="selected"></span>
				</a>
				<ul class="sub-menu">
					<li <?php echo ($_GET['page']=="praoutline" AND $_GET['menu']=="upload")?'class="active open"':'';?>>
						<a href="?page=praoutline&menu=upload">
							<span class="title"> Upload Praoutline </span>
						</a>
					</li>
				</ul>
				<ul class="sub-menu">
					<li <?php echo ($_GET['page']=="praoutline" AND $_GET['menu']=="review")?'class="active open"':'';?>>
						<a href="?page=praoutline&menu=review">
							<span class="title"> Review </span>
						</a>
					</li>
				</ul>
				<ul class="sub-menu">
					<li <?php echo ($_GET['page']=="praoutline" AND $_GET['menu']=="daftar-praoutline")?'class="active open"':'';?>>
						<a href="?page=praoutline&menu=daftar-praoutline">
							<span class="title"> Pencarian </span>
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
			</li>
			<?php
			//cek status draft mahasiswa
			$cek="SELECT id FROM tbrekaphasil WHERE nim='".$_SESSION['login-mhs']['nim']."' AND kep_akhir='1' LIMIT 1";
			$db->runQuery($cek);
			if($db->dbRows()>0){
			?>
			<li <?php echo ($_GET['page']=="outline")?'class="active open"':'';?>>
				<a href="javascript:void(0)">
					<i class="clip-stack"></i>
					<span class="title"> Tugas Akhir</span><i class="icon-arrow"></i><span class="selected"></span>
				</a>
				<ul class="sub-menu">
					<li <?php echo ($_GET['page']=="outline" AND $_GET['menu']=="diskusi")?'class="active open"':'';?>>
						<a href="?page=outline&menu=diskusi">
							<span class="title"> Diskusi Tugas Akhir </span>
						</a>
					</li>
				</ul>
				<?php
				$nim=$_SESSION['login-mhs']['nim'];
				$new="SELECT 
						td.*,						
						tr.*,
						COUNT(tr.status) as jlhreview
					FROM tbdiskusi td
					LEFT JOIN tbreviewdiskusi tr ON (td.idDiskusi=tr.idDiskusi)
					WHERE td.idDiskusi=tr.idDiskusi and tr.reviewer not like '$nim' and tr.status='0' group by td.nim";
					$db->runQuery($new);
					$cnt=$db->dbFetch();
					if($db->dbRows()>0){ $i=$cnt['jlhreview'];}else{ $i='0';}
				?>
				<ul class="sub-menu">
					<li <?php echo ($_GET['page']=="outline" AND $_GET['menu']=="new")?'class="active open"':'';?>>
						<a href="?page=outline&menu=new">
							<span class="title"> Review Terbaru (<?php echo "<b>$i</b>";?>)</span>
						</a>
					</li>
				</ul>
				<ul class="sub-menu">
					<li <?php echo ($_GET['page']=="outline" AND $_GET['menu']=="list")?'class="active open"':'';?>>
						<a href="?page=outline&menu=list">
							<span class="title"> Review Tugas Akhir</span>
						</a>
					</li>
				</ul>
				<ul class="sub-menu">
					<li <?php echo ($_GET['page']=="outline" AND $_GET['menu']=="jadwal_outline")?'class="active open"':'';?>>
						<a href="?page=outline&menu=jadwal_outline">
							<span class="title"> Pengajuan Jadwal Outline</span>
						</a>
					</li>
				</ul>
				<ul class="sub-menu">
					<li <?php echo ($_GET['page']=="outline" AND $_GET['menu']=="jadwal_sidang")?'class="active open"':'';?>>
						<a href="?page=outline&menu=jadwal_sidang">
							<span class="title"> Pengajuan Jadwal Sidang</span>
						</a>
					</li>
				</ul>
			</li>
			<?php
			}
			?>
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