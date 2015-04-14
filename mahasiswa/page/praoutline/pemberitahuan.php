<div class="row">
	<div class="col-sm-12">
		<ol class="breadcrumb">
			<li>
				<i class="clip-home-3"></i>
				<a href="<?php ECHO MHS_PAGE;?>">
					Home
				</a>
			</li>
			<li class="active">
				Pemberitahuan
			</li>
			<li class="search-box">
				<label><?php echo tanggalIndo(date('Y-m-d H:i:s'),'j F Y, H:i');?></label>
			</li>
		</ol>
		<div class="page-header">
			<h1>Pemberitahuan <small></small></h1>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<table class="table table-hover" id="tb-pemberitahuan">
			<?php
			//variabel yg ada di pemberitahuan berasal dari _header.php
			$db->runQuery($Q_notif_review);
			if($jlh_notif_review>0){
				while($r=$db->dbFetch()){
					echo '<tr>
						<td style="width:20%">'.tanggalIndo($r['tgl'],'j F Y, H:i').'</td>
						<td> <a href="?page=praoutline&menu=review#post_review" rel="nofollow" target="_blank">'.$r['msg'].'</a></td>
					</tr>';
				}
			}else{
				echo '<tr>
					<td colspan="2">Tidak Ada Pemberitahuan Terbaru</td>
				</tr>';
			}
			?>
		</table>
</div>
</div>