<link rel="stylesheet" href="../assets/plugins/gritter/css/jquery.gritter.css">
<script src="../assets/plugins/ckeditor/ckeditor.js"></script>
<script src="../assets/plugins/ckeditor/adapters/jquery.js"></script>
<script src="../assets/plugins/gritter/js/jquery.gritter.min.js"></script>
<script>
	jQuery(document).ready(function() {
		Main.init();

		CKEDITOR.disableAutoInline = true;
	$('textarea.ckeditor').ckeditor({
		height:400
	});

	$("#ProfilBtnSimpan").click(function(){
		$.ajax({
			url:'page/profil/act.profil.php',
			dataType:'json',
			type:'post',
			cache:false,
			data:$("#profil").serialize(),
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
		                time: 5000,
		                text: json.msg
		            });
				}
			}
		});

    	//return false;
	});
	});
</script>