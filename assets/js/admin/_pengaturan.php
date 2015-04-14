<link rel="stylesheet" type="text/css" href="../assets/plugins/select2/select2.css" />
<link rel="stylesheet" href="../assets/plugins/DataTables/media/css/DT_bootstrap.css" />
<link rel="stylesheet" href="../assets/plugins/ckeditor/contents.css">
<link href="../assets/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>
<link href="../assets/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="../assets/plugins/datepicker/css/datepicker.css">
<link rel="stylesheet" href="../assets/plugins/gritter/css/jquery.gritter.css">

<script type="text/javascript" src="../assets/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="../assets/plugins/DataTables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../assets/plugins/DataTables/media/js/DT_bootstrap.js"></script>
<script src="../assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="../assets/plugins/ckeditor/ckeditor.js"></script>
<script src="../assets/plugins/ckeditor/adapters/jquery.js"></script>
<script src="../assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="../assets/plugins/bootstrap-modal/js/bootstrap-modal.js"></script>
<script src="../assets/plugins/bootstrap-modal/js/bootstrap-modalmanager.js"></script>
<script src="../assets/plugins/gritter/js/jquery.gritter.min.js"></script>
<script>
	jQuery(document).ready(function() {
		Main.init();

		$("#pengaturan").validate({
			errorPlacement: function(error, element) {
			    error.appendTo( element.parent("div"));
			},
			rules:{
				smt:{
					required:true
				},
				thn_ajaran:{
					required:true
				},
				min_setuju:{
					required:true
				}
			},
			messages:{
				smt:{
					required:"Silakan Pilih Semester Yang Aktif Sekarang"
				},
				thn_ajaran:{
					required:"Tahun Ajaran Tidak Boleh Kosong"
				},
				min_setuju:{
					required:"Syarat Minimal Close Draft Praoutline Harus dipilih"
				}
			},
			submitHandler:function(form){
				$.ajax({
					url:'page/pengaturan/act.pengaturan.php',
					type:'post',
					dataType:'json',
					cache:false,
					data:$("#pengaturan").serialize(),
					success:function(json){
						if(json.result){
							$.gritter.add({
								title:'Sukses',
				                time: 1000,
				                text: json.msg
					        });
						}else{
							$.gritter.add({
								title:'Kesalahan',
				                time: 4000,
				                text: json.msg
					        });
						}
					}
				});
				return false;
			}
		});

	});

</script>