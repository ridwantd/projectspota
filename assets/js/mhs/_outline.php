<link rel="stylesheet" href="../assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css">
<link rel="stylesheet" href="../assets/plugins/gritter/css/jquery.gritter.css">
<script src="../assets/plugins/bootstrap-daterangepicker/moment.min.js"></script>
<script src="../assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="../assets/js/form-elements.js"></script>
<script src="../assets/plugins/ckeditor/ckeditor.js"></script>
<script src="../assets/plugins/ckeditor/adapters/jquery.js"></script>
<script src="../assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="../assets/plugins/gritter/js/jquery.gritter.min.js"></script>
<script>
	jQuery(document).ready(function() {
		Main.init();
		
		//function to initiate daterangepicker
		$('.date-range').daterangepicker();
		
		$("#tambah_diskusi").validate({
			errorPlacement: function(error, element) {
			    error.appendTo( element.parent("div"));
			},
			rules:{
                pemb:{
                    required:true
                },
                stta:{
                    required:true
                },
                bab:{
                    required:true
                },
                sub:{
                    required:true
                }
            },
            messages:{
                 pemb:{
                    required:"Silakan Pilih Dosen Pembimbing."
                },
                stta:{
                    required:"Silakan Pilih Status Tugas Akhir."
                },
                bab:{
                    required:"Silakan Pilih BAB Bahasan."
                },
                sub:{
                    required:"Silakan Inputkan Sub Bahasan."
                }
            },
			submitHandler:function(form){
				$.ajax({
					url:'page/outline/act.outline.php',
					dataType:'json',
					type:'POST',
					data:$("#tambah_diskusi").serialize(),
					cache:false,
					success:function(json){
						if(json.result){
							$.gritter.add({
								title:'Sukses',
				                time: 1000,
				                text: json.msg,
				                after_close: function(){
									location.href="?page=outline&menu=list";
								}
				            });
						}else{
							$.gritter.add({
								title:'Kesalahan',
				                time: 1000,
				                text: json.msg
				            });
						}
						
					}
				});
			}
		});

		$("#post_review").validate({ //
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
					var formData = new FormData(document.getElementById("post_review"));
					$.ajax({
						url:'page/outline/act.outline.php',
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
										// location.href="?page=outline&menu=list";
										location.reload();
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

		$("#post_jadwal").validate({
			errorPlacement: function(error, element) {
			    error.appendTo( element.parent("div"));
			},
			rules:{
                pemb1:{
                    required:true
                },
                pemb2:{
                    required:true
                },
                peng1:{
                    required:true
                },
                peng2:{
                    required:true
                }
            },
            messages:{
                 pemb1:{
                    required:"Silakan Inputkan Nama Pembimbing 1."
                },
                pemb2:{
                    required:"Silakan Inputkan Nama Pembimbing 2."
                },
                peng1:{
                    required:"Silakan Inputkan Nama Penguji 1."
                },
                peng2:{
                    required:"Silakan Inputkan Nama Penguji 2."
                }
            },
			submitHandler:function(form){
				$.ajax({
					url:'page/outline/act.outline.php',
					dataType:'json',
					type:'POST',
					data:$("#post_jadwal").serialize(),
					cache:false,
					success:function(json){
						if(json.result){
							$.gritter.add({
								title:'Sukses',
				                time: 1000,
				                text: json.msg,
				                after_close: function(){
									location.reload();
								}
				            });
						}else{
							$.gritter.add({
								title:'Kesalahan',
				                time: 1000,
				                text: json.msg
				            });
						}
						
					}
				});
			}
		});
	});
	
	CKEDITOR.disableAutoInline = true;
	$('textarea.ckeditor').ckeditor({
		height:240
	});

</script>