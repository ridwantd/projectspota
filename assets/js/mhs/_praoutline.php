<link rel="stylesheet" type="text/css" href="../assets/plugins/select2/select2.css" />
<link rel="stylesheet" href="../assets/plugins/DataTables/media/css/DT_bootstrap.css" />
<!-- <link rel="stylesheet" href="../assets/plugins/ckeditor/contents.css"> -->
<link href="../assets/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>
<link href="../assets/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="../assets/plugins/gritter/css/jquery.gritter.css">
<link rel="stylesheet" href="../assets/plugins/jQuery-Tags-Input/jquery.tagsinput.css">

<script type="text/javascript" src="../assets/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="../assets/plugins/DataTables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../assets/plugins/DataTables/media/js/DT_bootstrap.js"></script>
<script src="../assets/plugins/ckeditor/ckeditor.js"></script>
<script src="../assets/plugins/ckeditor/adapters/jquery.js"></script>
<script src="../assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="../assets/plugins/bootstrap-modal/js/bootstrap-modal.js"></script>
<script src="../assets/plugins/bootstrap-modal/js/bootstrap-modalmanager.js"></script>
<script src="../assets/plugins/gritter/js/jquery.gritter.min.js"></script>
<script src="../assets/plugins/jQuery-Tags-Input/jquery.tagsinput.min.js"></script>

<script>
	jQuery(document).ready(function() {
		Main.init();
		//daftar berita
		$("#upload_usulan").validate({ // aksi tulis dan edit berita
			errorPlacement: function(error, element) {
			    error.appendTo( element.parent("div"));
			},
			submitHandler:function(form){
				for ( instance in CKEDITOR.instances )
				    {
				        CKEDITOR.instances[instance].updateElement();
				    }

				if(window.FormData !== undefined)  // for HTML5 browsers
				{
					var formData = new FormData(document.getElementById("upload_usulan"));
					$.ajax({
						url:'page/praoutline/act.praoutline.php',
						type:'POST',
						data:formData,
						dataType:'json',
						mimeType:'multipart/form-data',
						contentType: false,
				    	cache: false,
						processData:false,
						beforeSend:function(){
							$("#loading").show();
						},
						success:function(json){
							if(json.result){
								$("#loading").hide();
								$.gritter.add({
									title:'Sukses',
					                time: 1000,
					                text: json.msg,
					                after_close: function(){
										location.href="?page=praoutline&menu=review";
									}
					            });
							}else{
								$("#loading").hide();
								$.gritter.add({
									title:'Kesalahan',
					                time: 4000,
					                text: json.msg
					            });
							}
						}
					});


				}else{  //for olden browsers
				
					var  iframeId = "unique" + (new Date().getTime());
					var iframe = $('<iframe src="javascript:false;" name="'+iframeId+'" />');
					iframe.hide();
					form.attr("target",iframeId);
					iframe.appendTo("body");
					iframe.load(function(e){
						var doc = getDoc(iframe[0]);
						var docRoot = doc.body ? doc.body : doc.documentElement;
						var data = docRoot.innerHTML;
					});
				}
			}
		});

		$("#cari").validate({
			errorPlacement: function(error, element) {
			    error.appendTo( element.parent("div"));
			},
			submitHandler:function(form){
				$.ajax({
					url:'page/praoutline/act.praoutline.php',
					dataType:'html',
					type:'POST',
					data:$("#cari").serialize(),
					cache:false,
					beforeSend:function(){
						$("#loading").show();
					},
					success:function(html){
						$("#loading").fadeOut('fast');
						$("#result-cari").html(html);
					}
				});
			}
		});

		$("#post_review").submit(function() {
			$.ajax({
				url:'page/praoutline/act.praoutline.php',
				dataType:'json',
				type:'POST',
				data:$("#post_review").serialize(),
				cache:false,
				beforeSend:function(){
					$("#loading").show();
				},
				success:function(json){
					if(json.result){
						$("#loading").hide();
						$.gritter.add({
							title:'Sukses',
			                time: 1000,
			                text: json.msg,
			                after_close: function(){
								location.href="?page=praoutline&menu=review";
							}
			            });
					}else{
						$("#loading").hide();
						$.gritter.add({
							title:'Kesalahan',
			                time: 4000,
			                text: json.msg
			            });
					}
				}
			});
			return false;
		});
		
	});

	CKEDITOR.disableAutoInline = true;
	$('textarea.ckeditor').ckeditor({
		height:240
	});

	function doquote(id){
		//$("#balas_review").append('Some text');
		//CKEDITOR.instances.balas_review.insertHtml( '<blockquote><small>Someone famous </small><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p></blockquote>' );
	}
	
</script>