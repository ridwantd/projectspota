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
		$("#daftar-user").dataTable({
			"iDisplayLength": 5,
			"aLengthMenu": [
                [5, 10, 20, 50, -1],
                [5, 10, 20, 50, "All"] // change per page values here
            ],
			"bProcessing": true,
			"bServerSide": true,
			"bSort": false,
			"bFilter": false,
			"sAjaxSource": "page/user/list.daftar-user.php",
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

		$('#daftar-user_wrapper .dataTables_filter input').addClass("form-control input-sm").attr("placeholder", "Search");
        $('#daftar-user_wrapper .dataTables_length select').addClass("m-wrap small");
        $('#daftar-user_wrapper .dataTables_length select').select2();

        $("#btnTambahUser").click(function(){

        });

        $("#myprofile").validate({
        	errorPlacement:function(error,element){
        		error.appendTo( element.parent("div"));
        	},
        	rules:{
        		pwd_lama: {
				    required: function(element) {
			        return $("#pwd").val()!="";
			      	},
			    	minlength: 6
				},
				emailuser:{
					email: true
				},
				pwd:{
					minlength: 6
				}
        	},
        	messages:{
        		pwd:{
        			minlength:"Password Minimal 6 karakter"
        		},
        		pwd_lama:{
        			minlength:"Password Minimal 6 karakter"
        		}
        	},
        	submitHandler:function(form){
        		$.ajax({
        			url:'page/user/act.user.php',
        			dataType:'json',
        			type:'post',
        			cache:false,
        			data:$("#myprofile").serialize(),
        			beforeSend:function(){
        				$("#loading").show();
        			},
        			success:function(json){
        				if(json.result){
        					$("#loading").hide();
        					$.gritter.add({
                                title:'Sukses',
                                time: 1000,
                                text: json.msg
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
		$("#tambahuserbaru").validate({
        	errorPlacement:function(error,element){
        		error.appendTo( element.parent("div"));
        	},
        	rules:{
        		nama_lengkap:{
        			required:true
        		},
				emailuser:{
					email: true
				},
				pwd:{
					required:true,
					minlength: 6
				},
                prodi:{
                    required:true
                },
				username:{
					required:true,
					minlength: 5,
					remote:{
				        url: "page/user/checkuser.php",
				        type: "post"
				    }
				}
        	},
        	messages:{
        		pwd:{
        			required:"Password tidak boleh kosong.",
        			minlength:"Password Minimal 6 karakter"
        		},
        		emailuser:{
        			email:"Silakan masukkan email yang valid."
        		},
                prodi:{
                    required:"Silakan Pilih Program Studi"
                },
        		username:{
        			required:"Username tidak boleh kosong.",
        			minlength:"Username minimal 5 karakter",
        			remote:"Username sudah ada."
        		},
        		nama_lengkap:{
        			required:"Nama Lengkap harus diisi"
        		}
        	},
        	submitHandler:function(form){
        		$.ajax({
        			url:'page/user/act.user.php',
        			dataType:'json',
        			type:'post',
        			cache:false,
        			data:$("#tambahuserbaru").serialize(),
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
                                    $("#tambahuser").modal('hide');
                                    $("#daftar-user").dataTable().fnDraw();
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
		
		$("#editdatauser").validate({
        	errorPlacement:function(error,element){
        		error.appendTo( element.parent("div"));
        	},
        	rules:{
        		nama_lengkap:{
        			required:true
        		},
				emailuser:{
					email: true
				},
				username:{
					required:true,
					minlength: 5
				}
        	},
        	messages:{
        		emailuser:{
        			email:"Silakan masukkan email yang valid."
        		},
        		username:{
        			required:"Username tidak boleh kosong.",
        			minlength:"Username minimal 5 karakter."
        		},
        		nama_lengkap:{
        			required:"Nama Lengkap harus diisi"
        		}
        	},
        	submitHandler:function(form){
        		$.ajax({
        			url:'page/user/act.user.php',
        			dataType:'json',
        			type:'post',
        			cache:false,
        			data:$("#editdatauser").serialize(),
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
                                    $("#edituser").modal('hide');
                                    $("#daftar-user").dataTable().fnDraw();
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
	});

	function EditUser(id){
		$("#edituser").modal({
			keyboard:false,
			show:true,
			remote:'page/user/form-edituser.php?user='+id
		});
	}

	function HapusUser(id){
		if(confirm("Hapus Admin??")){
			$.ajax({
				url:'page/user/act.user.php',
				type:'post',
				dataType:'json',
				data:'act=hapususer&id='+id,
				cache:false,
				success:function(json){
					if(json.result){
						$.gritter.add({
                            title:'Sukses',
                            time: 1000,
                            text: json.msg,
                            after_close: function(){
                                $("#daftar-user").dataTable().fnDraw();
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

	function NonaktifkanUser(id){
		if(confirm("Nonaktifkan status Admin??")){
			$.ajax({
				url:'page/user/act.user.php',
				type:'post',
				dataType:'json',
				data:'act=nonaktifkanuser&id='+id,
				cache:false,
				success:function(json){
					if(json.result){
						$.gritter.add({
                            title:'Sukses',
                            time: 1000,
                            text: json.msg,
                            after_close: function(){
                                $("#daftar-user").dataTable().fnDraw();
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

	function AktifkanUser(id){
		if(confirm("Aktifkan status Admin??")){
			$.ajax({
				url:'page/user/act.user.php',
				type:'post',
				dataType:'json',
				data:'act=aktifkanuser&id='+id,
				cache:false,
				success:function(json){
					if(json.result){
						$.gritter.add({
                            title:'Sukses',
                            time: 1000,
                            text: json.msg,
                            after_close: function(){
                                $("#daftar-user").dataTable().fnDraw();
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