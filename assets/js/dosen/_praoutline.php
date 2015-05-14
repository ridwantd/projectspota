<link rel="stylesheet" type="text/css" href="../assets/plugins/select2/select2.css" />
<link rel="stylesheet" href="../assets/plugins/DataTables/media/css/DT_bootstrap.css" />
<!-- <link rel="stylesheet" href="../assets/plugins/ckeditor/contents.css"> -->
<!-- <link href="../assets/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/> -->
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

		$(".search-select").select2({
            placeholder: "Pilih Dosen",
            allowClear: true
        });


		$('#list-judul').dataTable({
			"iDisplayLength": 10,
			"aLengthMenu": [
                [10, 15, 20, 50, 100, -1],
                [10, 15, 20, 50, 100, "All"] // change per page values here
            ],
			"bProcessing": true,
			"bServerSide": true,
			"bSort": false,
			"sAjaxSource": "page/praoutline/list.judul.php",
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

		$('#list-judul_wrapper .dataTables_filter input').addClass("form-control input-sm").attr("placeholder", "Search");
        $('#list-judul_wrapper .dataTables_length select').addClass("m-wrap small");
        $('#list-judul_wrapper .dataTables_length select').select2();

        $('#kep-draft-praoutline').dataTable({
			"iDisplayLength": 10,
			"aLengthMenu": [
                [10, 15, 20, 50, 100, -1],
                [10, 15, 20, 50, 100, "All"] // change per page values here
            ],
			"bProcessing": true,
			"bServerSide": true,
			"bSort": false,
			"sAjaxSource": "page/praoutline/list.kep.draft.praoutline.php",
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

		$('#kep-draft-praoutline_wrapper .dataTables_filter input').addClass("form-control input-sm").attr("placeholder", "Search");
        $('#kep-draft-praoutline_wrapper .dataTables_length select').addClass("m-wrap small");
        $('#kep-draft-praoutline_wrapper .dataTables_length select').select2();

        $('#list-judulditerima').dataTable({
			"iDisplayLength": 10,
			"aLengthMenu": [
                [10, 15, 20, 50, 100, -1],
                [10, 15, 20, 50, 100, "All"] // change per page values here
            ],
			"bProcessing": true,
			"bServerSide": true,
			"bSort": false,
			"sAjaxSource": "page/praoutline/list.judulditerima.php",
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

		$('#list-judulditerima_wrapper .dataTables_filter input').addClass("form-control input-sm").attr("placeholder", "Search");
        $('#list-judulditerima_wrapper .dataTables_length select').addClass("m-wrap small");
        $('#list-judulditerima_wrapper .dataTables_length select').select2();

        $('#list-myreview').dataTable({
			"iDisplayLength": 10,
			"aLengthMenu": [
                [10, 15, 20, 50, 100, -1],
                [10, 15, 20, 50, 100, "All"] // change per page values here
            ],
			"bProcessing": true,
			"bServerSide": true,
			"bSort": false,
			"sAjaxSource": "page/praoutline/list.myreview.php",
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

		$('#list-myreview_wrapper .dataTables_filter input').addClass("form-control input-sm").attr("placeholder", "Search");
        $('#list-myreview_wrapper .dataTables_length select').addClass("m-wrap small");
        $('#list-myreview_wrapper .dataTables_length select').select2();


        $('#stat-draft-praoutline').dataTable({
			"iDisplayLength": 10,
			"aLengthMenu": [
                [10, 15, 20, 50, 100, -1],
                [10, 15, 20, 50, 100, "All"] // change per page values here
            ],
			"bProcessing": true,
			"bServerSide": true,
			"bSort": false,
			"sAjaxSource": "page/praoutline/list.statistikdraft.php",
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

		$('#stat-draft-praoutline_wrapper .dataTables_filter input').addClass("form-control input-sm").attr("placeholder", "Search");
        $('#stat-draft-praoutline_wrapper .dataTables_length select').addClass("m-wrap small");
        $('#stat-draft-praoutline_wrapper .dataTables_length select').select2();

        $('#stat-keldosen').dataTable({
			"iDisplayLength": 10,
			"aLengthMenu": [
                [10, 15, 20, 50, 100, -1],
                [10, 15, 20, 50, 100, "All"] // change per page values here
            ],
			"bProcessing": true,
			"bServerSide": true,
			"bSort": false,
			"sAjaxSource": "page/praoutline/list.statistikdosen.php",
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
	        },
	        "aoColumns": [ 
                {"sClass": "left"},
                {"sClass": "left"},
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"}
	        ]
		});

		$('#stat-keldosen_wrapper .dataTables_filter input').addClass("form-control input-sm").attr("placeholder", "Search");
        $('#stat-keldosen_wrapper .dataTables_length select').addClass("m-wrap small");
        $('#stat-keldosen_wrapper .dataTables_length select').select2();

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
								//location.href="?page=praoutline&menu=review";
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
			return false;
		});

		$("#putusan_judul").submit(function() {
			$.ajax({
				url:'page/praoutline/act.praoutline.php',
				dataType:'json',
				type:'POST',
				data:$("#putusan_judul").serialize(),
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
								location.href="?page=praoutline&menu=kep-draft-praoutline";
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

		});{

		}
		
	});

	CKEDITOR.config.autoParagraph = false;
	CKEDITOR.disableAutoInline = true;
	$('textarea.ckeditor').ckeditor({
		height:240
	});

	function openrev(idpr){
		if(confirm("Aksi Ini Akan Membuka Kembali Review Pada Draft Praoutline ini. Lanjutkan ??")){
			$.ajax({
				url:'page/praoutline/act.praoutline.php',
				dataType:'json',
				type:'POST',
				data:"act=open_judul&idpr="+idpr,
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
								location.href="?page=praoutline&menu=kep-draft-praoutline";
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
		}
	}

	function viewDataStat(smt){
		location.href="dashboard.php?page=praoutline&menu=statistik&smt="+smt;
	}

	function mhsPemb1(nip){
		$.ajax({
			url:'page/praoutline/act.praoutline.php',
			dataType:'html',
			type:'POST',
			data:"act=getmhs&jenis=pemb1&nip="+nip,
			cache:false,
			beforeSend:function(){
				$("#loading").show();
			},
			success:function(html){
				$("#datadaftar").html(html);
				$('.daftamahasiswa').dataTable({
					"iDisplayLength": 5,
					"aLengthMenu": [
		                [5,10, 15, 20, 50, 100, -1],
		                [5,10, 15, 20, 50, 100, "All"] // change per page values here
		            ],
					"bProcessing": true,
					"bSort": false,
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
			    $('#daftamahasiswa_wrapper .dataTables_filter input').addClass("form-control input-sm").attr("placeholder", "Search");
		        $('#daftamahasiswa_wrapper .dataTables_length select').addClass("m-wrap small");
		        $('#daftamahasiswa_wrapper .dataTables_length select').select2();

				$("#mhsmodal").modal('show');
			}
		});
	}

	function mhsPemb2(nip){
		$.ajax({
			url:'page/praoutline/act.praoutline.php',
			dataType:'html',
			type:'POST',
			data:"act=getmhs&jenis=pemb2&nip="+nip,
			cache:false,
			beforeSend:function(){
				$("#loading").show();
			},
			success:function(html){
				$("#datadaftar").html(html);
				$('.daftamahasiswa').dataTable({
					"iDisplayLength": 5,
					"aLengthMenu": [
		                [5,10, 15, 20, 50, 100, -1],
		                [5,10, 15, 20, 50, 100, "All"] // change per page values here
		            ],
					"bProcessing": true,
					"bSort": false,
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
			    $('#daftamahasiswa_wrapper .dataTables_filter input').addClass("form-control input-sm").attr("placeholder", "Search");
		        $('#daftamahasiswa_wrapper .dataTables_length select').addClass("m-wrap small");
		        $('#daftamahasiswa_wrapper .dataTables_length select').select2();
				$("#mhsmodal").modal('show');
			}
		});
	}

	function mhsPeng1(nip){
		$.ajax({
			url:'page/praoutline/act.praoutline.php',
			dataType:'html',
			type:'POST',
			data:"act=getmhs&jenis=peng1&nip="+nip,
			cache:false,
			beforeSend:function(){
				$("#loading").show();
			},
			success:function(html){
				$("#datadaftar").html(html);
				$('.daftamahasiswa').dataTable({
					"iDisplayLength": 5,
					"aLengthMenu": [
		                [5,10, 15, 20, 50, 100, -1],
		                [5,10, 15, 20, 50, 100, "All"] // change per page values here
		            ],
					"bProcessing": true,
					"bSort": false,
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
			    $('#daftamahasiswa_wrapper .dataTables_filter input').addClass("form-control input-sm").attr("placeholder", "Search");
		        $('#daftamahasiswa_wrapper .dataTables_length select').addClass("m-wrap small");
		        $('#daftamahasiswa_wrapper .dataTables_length select').select2();
				$("#mhsmodal").modal('show');
			}
		});
	}

	function mhsPeng2(nip){
		$.ajax({
			url:'page/praoutline/act.praoutline.php',
			dataType:'html',
			type:'POST',
			data:"act=getmhs&jenis=peng2&nip="+nip,
			cache:false,
			beforeSend:function(){
				$("#loading").show();
			},
			success:function(html){
				$("#datadaftar").html(html);
				$('.daftamahasiswa').dataTable({
					"iDisplayLength": 5,
					"aLengthMenu": [
		                [5,10, 15, 20, 50, 100, -1],
		                [5,10, 15, 20, 50, 100, "All"] // change per page values here
		            ],
					"bProcessing": true,
					"bSort": false,
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
			    $('#daftamahasiswa_wrapper .dataTables_filter input').addClass("form-control input-sm").attr("placeholder", "Search");
		        $('#daftamahasiswa_wrapper .dataTables_length select').addClass("m-wrap small");
		        $('#daftamahasiswa_wrapper .dataTables_length select').select2();
				$("#mhsmodal").modal('show');
			}
		});
	}

	
</script>