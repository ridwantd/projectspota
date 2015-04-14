<link rel="stylesheet" type="text/css" href="../assets/plugins/select2/select2.css" />
<link rel="stylesheet" href="../assets/plugins/DataTables/media/css/DT_bootstrap.css" />		
<link href="../assets/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>
<link href="../assets/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="../assets/plugins/gritter/css/jquery.gritter.css">

<script type="text/javascript" src="../assets/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="../assets/plugins/DataTables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../assets/plugins/DataTables/media/js/DT_bootstrap.js"></script>
<script src="../assets/plugins/bootstrap-modal/js/bootstrap-modal.js"></script>
<script src="../assets/plugins/bootstrap-modal/js/bootstrap-modalmanager.js"></script>
<script src="../assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="../assets/plugins/gritter/js/jquery.gritter.min.js"></script>
<script>
	jQuery(document).ready(function() {
		Main.init();
        //data fakultas
        <?php if($_GET['menu']=='data-fakultas'){ ?>
		$("#data-fakultas").dataTable({
			"iDisplayLength": 10,
			"aLengthMenu": [
                [10, 20, 30, -1],
                [10, 20, 30, "All"] // change per page values here
            ],
			"bProcessing": true,
			"bServerSide": true,
			"bSort": false,
			"bFilter": false,
			"sAjaxSource": "page/manajemendata/list.data-fakultas.php",
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

		$('#data-fakultas_wrapper .dataTables_filter input').addClass("form-control input-sm").attr("placeholder", "Search");
        $('#data-fakultas_wrapper .dataTables_length select').addClass("m-wrap small");
        $('#data-fakultas_wrapper .dataTables_length select').select2();


        $("#tambahdatafak").validate({
        	errorPlacement:function(error,element){
        		error.appendTo( element.parent("div"));
        	},
        	rules:{
        		idFak:{
					required:true,
					remote:{
				        url: "page/manajemendata/checkkodefakultas.php",
				        type: "post"
				    }
				},
        		nmFakultas:{
        			required:true,
        			minlength:1
        		}
        	},
        	messages:{
        		idFak:{
        			required:"Kode Fakultas tidak boleh kosong.",
        			remote:"Kode Fakultas sudah digunakan."
        		},
        		nmFakultas:{
        			required:"Nama Fakultas tidak boleh kosong.",
        			minlength:"Nama Fakultas minimal 1 karakter"
        		}
        		
        	},
        	submitHandler:function(form){
        		$.ajax({
        			url:'page/manajemendata/act.data-fakultas.php',
        			dataType:'json',
        			type:'post',
        			cache:false,
        			data:$("#tambahdatafak").serialize(),
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
                                    $("#tambahfakultas").modal('hide');
                                    $("#data-fakultas").dataTable().fnDraw();
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
        	}
        });
		
		$("#editdatafak").validate({
        	errorPlacement:function(error,element){
        		error.appendTo( element.parent("div"));
        	},
        	rules:{
        		idFak:{
					required:true
				},
        		nmFakultas:{
        			required:true,
        			minlength:1
        		}
        	},
        	messages:{
        		idFak:{
        			required:"Kode Fakultas tidak boleh kosong."
        		},
        		nmFakultas:{
        			required:"Nama Fakultas tidak boleh kosong.",
        			minlength:"Nama Fakultas minimal 1 karakter"
        		}
        		
        	},
        	submitHandler:function(form){
        		$.ajax({
        			url:'page/manajemendata/act.data-fakultas.php',
        			dataType:'json',
        			type:'post',
        			cache:false,
        			data:$("#editdatafak").serialize(),
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
                                    $("#editfakultas").modal('hide');
                                    $("#data-fakultas").dataTable().fnDraw();
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
        	}
        });
        <?php } ?>

        //data jurusan
        <?php if($_GET['menu']=='data-jurusan'){  ?>
        $("#data-jurusan").dataTable({
            "iDisplayLength": 10,
            "aLengthMenu": [
                [10, 20, 30, -1],
                [10, 20, 30, "All"] // change per page values here
            ],
            "bProcessing": true,
            "bServerSide": true,
            "bSort": false,
            "bFilter": true,
            "sAjaxSource": "page/manajemendata/list.data-jurusan.php",
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

        $('#data-jurusan_wrapper .dataTables_filter input').addClass("form-control input-sm").attr("placeholder", "Search");
        $('#data-jurusan_wrapper .dataTables_length select').addClass("m-wrap small");
        $('#data-jurusan_wrapper .dataTables_length select').select2();


        $("#tambahdatajur").validate({
            errorPlacement:function(error,element){
                error.appendTo( element.parent("div"));
            },
            rules:{
                idFak:{
                    required:true
                },
                nmJurusan:{
                    required:true,
                    minlength:1
                }
            },
            messages:{
                idFak:{
                    required:"Pilih Fakultas.",
                },
                nmJurusan:{
                    required:"Nama Jurusan tidak boleh kosong.",
                    minlength:"Nama Jurusan minimal 1 karakter"
                }
                
            },
            submitHandler:function(form){
                $.ajax({
                    url:'page/manajemendata/act.data-jurusan.php',
                    dataType:'json',
                    type:'post',
                    cache:false,
                    data:$("#tambahdatajur").serialize(),
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
                                    $("#tambahjurusan").modal('hide');
                                    $("#data-jurusan").dataTable().fnDraw();
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
            }
        });
        
        $("#editdatajur").validate({
            errorPlacement:function(error,element){
                error.appendTo( element.parent("div"));
            },
            rules:{
                idFak:{
                    required:true
                },
                nmJurusan:{
                    required:true,
                    minlength:1
                }
            },
            messages:{
                idFak:{
                    required:"Pilih Fakultas"
                },
                nmJurusan:{
                    required:"Nama Jurusan tidak boleh kosong.",
                    minlength:"Nama Jurusan minimal 1 karakter"
                }
                
            },
            submitHandler:function(form){
                $.ajax({
                    url:'page/manajemendata/act.data-jurusan.php',
                    dataType:'json',
                    type:'post',
                    cache:false,
                    data:$("#editdatajur").serialize(),
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
                                    $("#editjurusan").modal('hide');
                                    $("#data-jurusan").dataTable().fnDraw();
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
            }
        });
        <?php } ?>
        //data program studi
        <?php if($_GET['menu']=='data-prodi'){ ?>
        $("#data-prodi").dataTable({
            "iDisplayLength": 10,
            "aLengthMenu": [
                [10, 20, 30, -1],
                [10, 20, 30, "All"] // change per page values here
            ],
            "bProcessing": true,
            "bServerSide": true,
            "bSort": false,
            "bFilter": true,
            "sAjaxSource": "page/manajemendata/list.data-prodi.php",
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

        $('#data-prodi_wrapper .dataTables_filter input').addClass("form-control input-sm").attr("placeholder", "Search");
        $('#data-prodi_wrapper .dataTables_length select').addClass("m-wrap small");
        $('#data-prodi_wrapper .dataTables_length select').select2();

        $("#tambahdataprodi").validate({
            errorPlacement:function(error,element){
                error.appendTo( element.parent("div"));
            },
            rules:{
                idFak:{
                    required:true
                },
                idJur:{
                    required:true
                },
                nmProdi:{
                    required:true,
                    minlength:1
                }
            },
            messages:{
                idFak:{
                    required:"Pilih Fakultas.",
                },
                idJur:{
                    required:"Pilih Jurusan.",
                },
                nmProdi:{
                    required:"Nama Program Studi tidak boleh kosong.",
                    minlength:"Nama Program Studi minimal 1 karakter"
                }
                
            },
            submitHandler:function(form){
                $.ajax({
                    url:'page/manajemendata/act.data-prodi.php',
                    dataType:'json',
                    type:'post',
                    cache:false,
                    data:$("#tambahdataprodi").serialize(),
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
                                    $("#tambahprodi").modal('hide');
                                    $("#data-prodi").dataTable().fnDraw();
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
            }
        });
        
        $("#editdataprodi").validate({
            errorPlacement:function(error,element){
                error.appendTo( element.parent("div"));
            },
            rules:{
                idFak:{
                    required:true
                },
                idJur:{
                    required:true
                },
                nmProdi:{
                    required:true,
                    minlength:1
                }
            },
            messages:{
                idFak:{
                    required:"Pilih Fakultas"
                },
                idJur:{
                    required:"Pilih Jurusan"
                },
                nmProdi:{
                    required:"Nama Program Studi tidak boleh kosong.",
                    minlength:"Nama Program Studi minimal 1 karakter"
                }
                
            },
            submitHandler:function(form){
                $.ajax({
                    url:'page/manajemendata/act.data-prodi.php',
                    dataType:'json',
                    type:'post',
                    cache:false,
                    data:$("#editdataprodi").serialize(),
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
                                    $("#editprodi").modal('hide');
                                    $("#data-prodi").dataTable().fnDraw();
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
            }
        }); 
        <?php } ?>
        //data mahasiswa
        <?php if($_GET['menu']=='data-mahasiswa'){ ?>
        $("#data-mahasiswa").dataTable({
            "iDisplayLength": 10,
            "aLengthMenu": [
                [10, 20, 30, -1],
                [10, 20, 30, "All"] // change per page values here
            ],
            "bProcessing": true,
            "bServerSide": true,
            "bSort": false,
            "bFilter": true,
            "sAjaxSource": "page/manajemendata/list.data-mahasiswa.php",
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

        $('#data-mahasiswa_wrapper .dataTables_filter input').addClass("form-control input-sm").attr("placeholder", "Search");
        $('#data-mahasiswa_wrapper .dataTables_length select').addClass("m-wrap small");
        $('#data-mahasiswa_wrapper .dataTables_length select').select2();

        $("#tambah_mahasiswa").validate({
            errorPlacement:function(error,element){
                error.appendTo( element.parent("div"));
            },
            rules:{
                nim:{
                    required:true,
                    minlength:4,
                    remote:{
                        url: "page/manajemendata/checknim.php",
                        type: "post"
                    }
                },
                nmLengkap:{
                    required:true,
                    minlength:3
                },
                password:{
                    required:true
                },
                password_again:{
                    equalTo:password
                },
                thnmasuk:{
                    required:true
                },
                prodi:{
                    required:true
                }
            },
            messages:{
                nim:{
                    required:"NIM harus diisi.",
                    minlength:"NIM minimal 4 karakter",
                    remote:"NIM sudah ada"
                },
                nmLengkap:{
                    required:"Nama Lengkap tidak boleh kosong",
                    minlength:"Minimal 3 karakter"
                },
                password:{
                    required:"Password harus diisi"
                },
                password_again:{
                    equalTo:"Password Tidak Cocok"
                },
                thnmasuk:{
                    required:"Tahun Masuk/Angkatan harus dipilih"
                },
                prodi:{
                    required:"Program Studi harus dipilih"
                }
            },
            submitHandler:function(form){
                if(window.FormData !== undefined)  // for HTML5 browsers
                {
                    var formData = new FormData(document.getElementById("tambah_mahasiswa"));
                    $.ajax({
                        url:'page/manajemendata/act.data-mhs.php',
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
                                        location.href="?page=data&menu=data-mahasiswa";
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
        
        $("#edit_mahasiswa").validate({
            errorPlacement:function(error,element){
                error.appendTo( element.parent("div"));
            },
            rules:{
                nim:{
                    required:true,
                    minlength:4
                },
                nmLengkap:{
                    required:true,
                    minlength:3
                },
                thnmasuk:{
                    required:true
                },
                prodi:{
                    required:true
                }
            },
            messages:{
                nim:{
                    required:"NIM harus diisi.",
                    minlength:"NIM minimal 4 karakter"
                },
                nmLengkap:{
                    required:"Nama Lengkap tidak boleh kosong",
                    minlength:"Minimal 3 karakter"
                },
                thnmasuk:{
                    required:"Tahun Masuk/Angkatan harus dipilih"
                },
                prodi:{
                    required:"Program Studi harus dipilih"
                }
            },
            submitHandler:function(form){
                if(window.FormData !== undefined)  // for HTML5 browsers
                {
                    var formData = new FormData(document.getElementById("edit_mahasiswa"));
                    $.ajax({
                        url:'page/manajemendata/act.data-mhs.php',
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
                                        location.href="?page=data&menu=data-mahasiswa";
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
        <?php } ?>

        //data dosen
        <?php if($_GET['menu']=='data-dosen'){ ?>
        $("#data-dosen").dataTable({
            "iDisplayLength": 10,
            "aLengthMenu": [
                [10, 20, 30, -1],
                [10, 20, 30, "All"] // change per page values here
            ],
            "bProcessing": true,
            "bServerSide": true,
            "bSort": false,
            "bFilter": true,
            "sAjaxSource": "page/manajemendata/list.data-dosen.php",
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

        $('#data-dosen_wrapper .dataTables_filter input').addClass("form-control input-sm").attr("placeholder", "Search");
        $('#data-dosen_wrapper .dataTables_length select').addClass("m-wrap small");
        $('#data-dosen_wrapper .dataTables_length select').select2();

        $("#tambah_dosen").validate({
            errorPlacement:function(error,element){
                error.appendTo( element.parent("div"));
            },
            rules:{
                nip_dosen:{
                    required:true,
                    minlength:4,
                    remote:{
                        url: "page/manajemendata/checknipdosen.php",
                        type: "post"
                    },
                    digits:true
                },
                nmLengkap:{
                    required:true,
                    minlength:3
                },
                password:{
                    required:true
                },
                password_again:{
                    equalTo:password
                },
                jabatan:{
                    required:true
                },
                prodi:{
                    required:true
                }
            },
            messages:{
                nip_dosen:{
                    required:"NIP Dosen harus diisi.",
                    minlength:"NIP minimal 4 karakter",
                    remote:"NIP Dosen sudah ada",
                    digits:"NIP harus angka"
                },
                nmLengkap:{
                    required:"Nama Lengkap tidak boleh kosong",
                    minlength:"Minimal 3 karakter"
                },
                password:{
                    required:"Password harus diisi"
                },
                password_again:{
                    equalTo:"Password Tidak Cocok"
                },
                jabatan:{
                    required:"Jabatan harus dipilih"
                },
                prodi:{
                    required:"Program Studi harus dipilih"
                }
            },
            submitHandler:function(form){
                if(window.FormData !== undefined)  // for HTML5 browsers
                {
                    var formData = new FormData(document.getElementById("tambah_dosen"));
                    $.ajax({
                        url:'page/manajemendata/act.data-dosen.php',
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
                                        location.href="?page=data&menu=data-dosen";
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
        
        $("#edit_dosen").validate({
            errorPlacement:function(error,element){
                error.appendTo( element.parent("div"));
            },
            rules:{
                nip_dosen:{
                    required:true,
                    minlength:4,
                    digits:true
                },
                nmLengkap:{
                    required:true,
                    minlength:3
                },
                jabatan:{
                    required:true
                },
                prodi:{
                    required:true
                }
            },
            messages:{
                nip_dosen:{
                    required:"NIP Dosen harus diisi.",
                    minlength:"NIP minimal 4 karakter",
                    digits:"NIP harus angka"
                },
                nmLengkap:{
                    required:"Nama Lengkap tidak boleh kosong",
                    minlength:"Minimal 3 karakter"
                },
                jabatan:{
                    required:"Jabatan harus dipilih"
                },
                prodi:{
                    required:"Program Studi harus dipilih"
                }
            },
            submitHandler:function(form){
                if(window.FormData !== undefined)  // for HTML5 browsers
                {
                    var formData = new FormData(document.getElementById("edit_dosen"));
                    $.ajax({
                        url:'page/manajemendata/act.data-dosen.php',
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
                                        location.href="?page=data&menu=data-dosen";
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
        
        <?php } ?>

	});

	function HapusFak(id){
		if(confirm("Hapus Data Fakultas ini??")){
			$.ajax({
				url:'page/manajemendata/act.data-fakultas.php',
				type:'post',
				dataType:'json',
				data:'act=hapusfak&idFak='+id,
				cache:false,
				success:function(json){
					if(json.result){
						$.gritter.add({
                            title:'Sukses',
                            time: 1000,
                            text: json.msg,
                            after_close: function(){
                                $("#data-fakultas").dataTable().fnDraw();
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
		return false;
	}

	function EditFak(id){
		$("#editfakultas").modal({
			keyboard:false,
			show:true,
			remote:'page/manajemendata/form-editfakultas.php?kode='+id
		});
	}

    function HapusJur(id){
        if(confirm("Hapus Data Jurusan ini??")){
            $.ajax({
                url:'page/manajemendata/act.data-jurusan.php',
                type:'post',
                dataType:'json',
                data:'act=hapusjur&idJur='+id,
                cache:false,
                success:function(json){
                    if(json.result){
                        $.gritter.add({
                            title:'Sukses',
                            time: 1000,
                            text: json.msg,
                            after_close: function(){
                                $("#data-jurusan").dataTable().fnDraw();
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
        return false;
    }

    function EditJur(id){
        $("#editjurusan").modal({
            keyboard:false,
            show:true,
            remote:'page/manajemendata/form-editjurusan.php?id='+id
        });
    }

    function HapusProdi(id){
        if(confirm("Hapus Data Program Studi ini??")){
            $.ajax({
                url:'page/manajemendata/act.data-prodi.php',
                type:'post',
                dataType:'json',
                data:'act=hapusprodi&idProdi='+id,
                cache:false,
                success:function(json){
                    if(json.result){
                        $.gritter.add({
                            title:'Sukses',
                            time: 1000,
                            text: json.msg,
                            after_close: function(){
                                $("#data-prodi").dataTable().fnDraw();
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
        return false;
    }

    function EditProdi(id){
        $("#editprodi").modal({
            keyboard:false,
            show:true,
            remote:'page/manajemendata/form-editprodi.php?id='+id
        });
    }

    function getJurusan(){
        var fakultas=document.getElementById("fromidfak");
        //alert(fakultas.value);
        $.ajax({
            url:'page/manajemendata/_getjurusan.php',
            type:'post',
            data:'act=getjur&idFak='+fakultas.value,
            cache:false,
            success:function(html){
                $('.selectJur').html("");
                $('.selectJur').html(html);
            }
        });
    }

    function HapusDosen(id){
        if(confirm("Hapus Data Dosen??")){
            $.ajax({
                url:'page/manajemendata/act.data-dosen.php',
                type:'post',
                dataType:'json',
                data:'act=hapusdosen&iddosen='+id,
                cache:false,
                success:function(json){
                    if(json.result){
                        $.gritter.add({
                            title:'Sukses',
                            time: 1000,
                            text: json.msg,
                            after_close: function(){
                                $("#data-dosen").dataTable().fnDraw();
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
        return false;
    }

    function NonaktifkanAkunDosen(id){
        if(confirm("Nonaktifkan Akun ini??")){
            $.ajax({
                url:'page/manajemendata/act.data-dosen.php',
                type:'post',
                dataType:'json',
                data:'act=disable&id='+id,
                cache:false,
                success:function(json){
                    if(json.result){
                        $.gritter.add({
                            title:'Sukses',
                            time: 1000,
                            text: json.msg,
                            after_close: function(){
                                $("#data-dosen").dataTable().fnDraw();
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
        return false;
    }

    function AktifkanAkunDosen(id){
        if(confirm("Aktifkan Akun ini??")){
            $.ajax({
                url:'page/manajemendata/act.data-dosen.php',
                type:'post',
                dataType:'json',
                data:'act=enable&id='+id,
                cache:false,
                success:function(json){
                    if(json.result){
                        $.gritter.add({
                            title:'Sukses',
                            time: 1000,
                            text: json.msg,
                            after_close: function(){
                                $("#data-dosen").dataTable().fnDraw();
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
        return false;
    }

    function HapusMhs(id){
        if(confirm("Hapus Data Mahasiswa??")){
            $.ajax({
                url:'page/manajemendata/act.data-mhs.php',
                type:'post',
                dataType:'json',
                data:'act=hapusmhs&idmhs='+id,
                cache:false,
                success:function(json){
                    if(json.result){
                        $.gritter.add({
                            title:'Sukses',
                            time: 1000,
                            text: json.msg,
                            after_close: function(){
                                $("#data-mahasiswa").dataTable().fnDraw();
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
        return false;
    }

    function NonaktifkanAkunMhs(id){
        if(confirm("Nonaktifkan Akun ini??")){
            $.ajax({
                url:'page/manajemendata/act.data-mhs.php',
                type:'post',
                dataType:'json',
                data:'act=disable&id='+id,
                cache:false,
                success:function(json){
                    if(json.result){
                        $.gritter.add({
                            title:'Sukses',
                            time: 1000,
                            text: json.msg,
                            after_close: function(){
                                $("#data-mahasiswa").dataTable().fnDraw();
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
        return false;
    }

    function AktifkanAkunMhs(id){
        if(confirm("Aktifkan Akun ini??")){
            $.ajax({
                url:'page/manajemendata/act.data-mhs.php',
                type:'post',
                dataType:'json',
                data:'act=enable&id='+id,
                cache:false,
                success:function(json){
                    if(json.result){
                        $.gritter.add({
                            title:'Sukses',
                            time: 1000,
                            text: json.msg,
                            after_close: function(){
                                $("#data-mahasiswa").dataTable().fnDraw();
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
        return false;
    }
</script>