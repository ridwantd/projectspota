<link rel="stylesheet" type="text/css" href="../assets/plugins/select2/select2.css" />
<link rel="stylesheet" href="../assets/plugins/DataTables/media/css/DT_bootstrap.css" />
<link rel="stylesheet" href="../assets/plugins/ckeditor/contents.css">
<link href="../assets/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>
<link href="../assets/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="../assets/plugins/gritter/css/jquery.gritter.css">

<script type="text/javascript" src="../assets/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="../assets/plugins/DataTables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../assets/plugins/DataTables/media/js/DT_bootstrap.js"></script>
<script src="../assets/plugins/ckeditor/ckeditor.js"></script>
<script src="../assets/plugins/ckeditor/adapters/jquery.js"></script>
<script src="../assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>

<script src="../assets/plugins/bootstrap-modal/js/bootstrap-modal.js"></script>
<script src="../assets/plugins/bootstrap-modal/js/bootstrap-modalmanager.js"></script>
<script src="../assets/plugins/gritter/js/jquery.gritter.min.js"></script>
<script>
	jQuery(document).ready(function() {
		Main.init();

		$('#list-pengumuman').dataTable({
			"iDisplayLength": 5,
			"aLengthMenu": [
                [5, 10, 15, 20, 50, 100, -1],
                [5, 10, 15, 20, 50, 100, "All"] // change per page values here
            ],
			"bProcessing": true,
			"bServerSide": true,
			"bSort": false,
			"sAjaxSource": "page/pengumuman/list.daftar-pengumuman.php",
			"oLanguage": {
	            "sLengthMenu": "Menampilkan _MENU_ Data per halaman",
	            "sZeroRecords": "Maaf, Data tidak ada",
	            "sInfo": "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
	            "sInfoEmpty": "Menampilakan 0 s/d 0 dari 0 data",
	            "sSearch": "",
	            "sInfoFiltered": "",
	            "oPaginate": {
                    "sPrevious": "",
                    "sNext": ""
                }
	        }
		});

		$('#list-pengumuman_wrapper .dataTables_filter input').addClass("form-control input-sm").attr("placeholder", "Search");
        $('#list-pengumuman_wrapper .dataTables_length select').addClass("m-wrap small");
        $('#list-pengumuman_wrapper .dataTables_length select').select2();

        $("#tulis_pengumuman").validate({ // aksi tulis dan edit pengumuman
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
					var formData = new FormData(document.getElementById("tulis_pengumuman"));
					$.ajax({
						url:'page/pengumuman/act.pengumuman.php',
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
										location.href="?page=pengumuman&menu=daftar-pengumuman";
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


				}else  //for olden browsers
				{
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

		/*$('#list-daftarkategori').dataTable({
			"iDisplayLength": 5,
			"aLengthMenu": [
                [5, 10, 15, 20, 50, -1],
                [5, 10, 15, 20, 50, "All"] // change per page values here
            ],
			"bProcessing": true,
			"bServerSide": true,
			"bSort": false,
			"bFilter": false,
			"sAjaxSource": "page/pengumuman/list.kategori-pengumuman.php",
			"oLanguage": {
	            "sLengthMenu": "Menampilkan _MENU_ Data per halaman",
	            "sZeroRecords": "Maaf, Data tidak ditemukan",
	            "sInfo": "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
	            "sInfoEmpty": "Menampilakan 0 s/d 0 dari 0 data",
	            "sSearch": "",
	            "sInfoFiltered": "",
	            "oPaginate": {
                    "sPrevious": "",
                    "sNext": ""
                }
	        },
	        "aoColumnDefs": [
		      { "sClass": "text-center", "aTargets": [ 1 ] }
		    ]
		});
		$('#Btntambahkategori').click(function(){
			$("#nama_kategori").val("");
			$("#tambahkategori").modal('show');
		});
		$("#form-kategori").validate({
			errorPlacement: function(error, element) {
			    error.appendTo( element.parent("div"));
			},
			submitHandler:function(form){
				//alert($("#form-kategori").serialize());
				$.ajax({
					url:'page/pengumuman/act.pengumuman.php',
					type:'post',
					dataType:'json',
					cache:false,
					data:'act=tambahkat&'+$("#form-kategori").serialize(),
					success:function(json){
						if(json.result){
							$("#tambahkategori").modal('hide');
							$.gritter.add({
								title:'Sukses',
				                time: 1000,
				                text: json.msg,
				                after_close: function(){
									$('#list-daftarkategori').dataTable().fnDraw();
								}
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
		$("#eform-kategori").validate({
			errorPlacement: function(error, element) {
			    error.appendTo( element.parent("div"));
			},
			submitHandler:function(form){
				//alert($("#form-kategori").serialize());
				$.ajax({
					url:'page/pengumuman/act.pengumuman.php',
					type:'post',
					dataType:'json',
					cache:false,
					data:'act=updatekat&'+$("#eform-kategori").serialize(),
					success:function(json){
						if(json.result){
							$("#editkategori").modal('hide');
							$.gritter.add({
								title:'Sukses',
				                time: 1000,
				                text: json.msg,
				                after_close: function(){
									$('#list-daftarkategori').dataTable().fnDraw();
								}
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

		$('#list-daftarkategori_wrapper .dataTables_filter input').addClass("form-control input-sm").attr("placeholder", "Search");
        $('#list-daftarkategori_wrapper .dataTables_length select').addClass("m-wrap small");
        $('#list-daftarkategori_wrapper .dataTables_length select').select2();

        $("#kategori-pengumuman").change(function(){
			if($("#kategori-pengumuman").val()=="addnew"){
				$("#nama_kategori").val("");
				$("#addkategori").modal('show');
			}
		});

		$("#form-addkategori").validate({
			errorPlacement: function(error, element) {
			    error.appendTo( element.parent("div"));
			},
			submitHandler:function(form){
				//alert($("#form-kategori").serialize());
				$.ajax({
					url:'page/pengumuman/act.pengumuman.php',
					type:'post',
					dataType:'json',
					cache:false,
					data:'act=tambahkat&'+$("#form-addkategori").serialize(),
					success:function(json){
						if(json.result){
							$("#addkategori").modal('hide');
							$.gritter.add({
								title:'Sukses',
				                time: 1000,
				                text: json.msg,
				                after_close: function(){
									$("#kategori-pengumuman").append("<option selected value='"+json.idkat+"'>"+json.namekat+"</option>");
									$("#kategori-pengumuman").focus();
								}
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
		});*/

	});
	function getDoc(frame) {
	     var doc = null;
	     try {
	         if (frame.contentWindow) {
	             doc = frame.contentWindow.document;
	         }
	     } catch(err) {
	     }

	     if (doc) { 
	         return doc;
	     }
	     try { 
	         doc = frame.contentDocument ? frame.contentDocument : frame.document;
	     } catch(err) {
	         doc = frame.document;
	     }
	     return doc;
	}
	
	function EditPengumuman(id){
		location.href="?page=pengumuman&menu=edit-pengumuman&pengumuman="+id;
	}

	function HapusPengumuman(id){
		if(confirm("Hapus Pengumuman ini")){
			$.ajax({
				url:'page/pengumuman/act.pengumuman.php',
				type:'post',
				dataType:'json',
				cache:false,
				data:'act=hapuspengumuman&pengumuman='+id,
				success:function(json){
					if(json.result){
						$.gritter.add({
							title:'Sukses',
			                time: 1000,
			                text: json.msg,
			                after_close: function(){
								$('#list-pengumuman').dataTable().fnDraw();
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
	}

	function PublishPengumuman(id){
		if(confirm('Terbitkan Pengumuman ini ??')){
			$.ajax({
				url:'page/pengumuman/act.pengumuman.php',
				type:'post',
				dataType:'json',
				cache:false,
				data:'act=publish&idpengumuman='+id,
				success:function(json){
					if(json.result){
						$.gritter.add({
							title:'Sukses',
			                time: 1000,
			                text: json.msg,
			                after_close: function(){
								$('#list-pengumuman').dataTable().fnDraw();
							}
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
		}
	}
</script>