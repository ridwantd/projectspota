<?php
$db=new dB($dbsetting);
?>
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
				DOSEN - SPOTA UNTAN 
				<?php 
					if (isset($_SESSION['login-dosen']['nmprodi'])){ 
					echo strtoupper("(Prodi ".$_SESSION['login-dosen']['nmprodi'].")"); 
					}
				?>
			</a>
			<!-- end: LOGO -->
		</div>
		<div class="navbar-tools">
			<!-- start: TOP NAVIGATION MENU -->
			<ul class="nav navbar-right" style="padding:0">
				<?php
				$Q_notif_review="SELECT tnr.* 
					FROM tmp_notif_r tnr 
					LEFT JOIN tbpraoutline tp ON(tp.id=tnr.idkonten) 
					WHERE tnr.read = 'N' 
					AND tnr.jns_usr = 'D'
					AND tnr.user = '".$_SESSION['login-dosen']['nip']."'
					AND tnr.idProdi = '".$_SESSION['login-dosen']['prodi']."'";

					//echo $Q_notif_review;
					$notif_review=$db->runQuery($Q_notif_review);
					$jlh_notif_review=$db->dbRows($notif_review);
				?>
				<li class="dropdown">
					<a class="dropdown-toggle" href="?page=praoutline&menu=pemberitahuan" title="Tanggapan/ Review">
						<i class="clip-notification-2"></i>
						<?php 
						if($jlh_notif_review>0){ 
							echo '<span class="badge">'.$jlh_notif_review.'</span>';
							$_SESSION['new_review_dsn']=array();
							while($rev=$db->dbFetch($notif_review)){
								$_SESSION['new_review_dsn'][$rev['idkonten']][]=$rev['id'];
							}
						}
						
						?>
						
					</a>
				</li>
				<?php
				$qpengumuan="SELECT COUNT(id) as jlh FROM tbpengumuman WHERE id NOT IN(SELECT idkonten FROM tmp_notif WHERE iduser='".$_SESSION['login-dosen']['id']."' AND typeuser='D' AND jenis='P') AND idProdi='".$_SESSION['login-dosen']['prodi']."' AND tujuan IN ('A','D')";
				$notif_pengumuman=$db->runQuery($qpengumuan);
				$rpengumuman=$db->dbFetch($notif_pengumuman);
				$jlh_notif_pengumuman=$rpengumuman['jlh'];
				?>
				<li class="dropdown">
					<a class="dropdown-toggle" href="?page=pengumuman" title="Pengumuman">
						<i class="clip-list-5"></i>
						<?php if($jlh_notif_pengumuman>0){ ?><span class="badge"> <?php echo $jlh_notif_pengumuman;?></span><?php } ?>
					</a>
				</li>
				<li class="dropdown current-user">
					<a data-toggle="dropdown" class="dropdown-toggle" href="#">
						<!-- <img src="assets/images/avatar-1-small.jpg" class="circle-img" alt=""> -->
						<i class="clip-user"></i>
						<span class="username"><?php echo $_SESSION['login-dosen']['nama_lengkap'];?></span>
						<i class="clip-chevron-down"></i>
					</a>
					<ul class="dropdown-menu">
						<li>
							<a href="?page=user&menu=my-profile">
								<i class="clip-user-2"></i>
								&nbsp;Profil Dosen
							</a>
						</li>
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