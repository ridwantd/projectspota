<link rel="stylesheet" type="text/css" href="../assets/plugins/select2/select2.css" />
<link rel="stylesheet" href="../assets/plugins/DataTables/media/css/DT_bootstrap.css" />
<link rel="stylesheet" href="../assets/plugins/ckeditor/contents.css">
<link href="../assets/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>
<link href="../assets/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="../assets/plugins/gritter/css/jquery.gritter.css">
<link rel="stylesheet" href="../assets/plugins/datepicker/css/datepicker.css">
<link rel="stylesheet" href="../assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
<link rel="stylesheet" href="../assets/plugins/fullcalendar/fullcalendar/fullcalendar.css">

<script type="text/javascript" src="../assets/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="../assets/plugins/DataTables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../assets/plugins/DataTables/media/js/DT_bootstrap.js"></script>
<script type="text/javascript" src="../assets/plugins/fullcalendar/fullcalendar/fullcalendar.js"></script>
<script src="../assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="../assets/plugins/datepicker/js/bootstrap-datepicker.js"></script>
<script src="../assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script src="../assets/plugins/bootstrap-modal/js/bootstrap-modal.js"></script>
<script src="../assets/plugins/bootstrap-modal/js/bootstrap-modalmanager.js"></script>
<script src="../assets/plugins/gritter/js/jquery.gritter.min.js"></script>
<script>
	jQuery(document).ready(function() {
		Main.init();
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();

		$('.date-picker').datepicker({
            autoclose: true
        });

        $(".search-select").select2({
            placeholder: "Pilih Mahasiswa",
            allowClear: true
        });

        $('.time-picker').timepicker({
        	minuteStep: 5,
            showInputs: true,
            disableFocus: true,
            showMeridian:false
        });

		$('#list-jadwal').dataTable({
			"iDisplayLength": 5,
			"aLengthMenu": [
                [5, 10, 15, 20, 50, 100, -1],
                [5, 10, 15, 20, 50, 100, "All"] // change per page values here
            ],
			"bProcessing": true,
			"bServerSide": true,
			"bSort": false,
			"sAjaxSource": "page/jadwal/list.jadwal.php",
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

		$('#list-jadwal_wrapper .dataTables_filter input').addClass("form-control input-sm").attr("placeholder", "Search");
        $('#list-jadwal_wrapper .dataTables_length select').addClass("m-wrap small");
        $('#list-jadwal_wrapper .dataTables_length select').select2();

       $("#form_jadwal").validate({
        	errorPlacement:function(error,element){
        		error.appendTo( element.parent("div"));
        	},
        	submitHandler:function(form){
        		$.ajax({
        			url:'page/jadwal/act.jadwal.php',
        			dataType:'json',
        			type:'post',
        			cache:false,
        			data:$("#form_jadwal").serialize(),
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
                                	location.href="?page=jadwal";
                                    $("#list-jadwal").dataTable().fnDraw();
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
		$('#calendar').fullCalendar({
			editable: true,
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month'
			},
			events: "page/jadwal/json.kalender.php",
		   // Convert the allDay from string to boolean
			eventRender: function(event, element, view) {
		    	if (event.allDay === 'true') {
		     		event.allDay = true;
		    	} else {
		     		event.allDay = false;
		    	}
			},
			selectable: true,
			selectHelper: true,
			eventClick: function (calEvent, jsEvent, view) {
				//alert(calEvent.id);
				$("#JadwalDetail").modal('show');
				$.ajax({
        			url:'page/jadwal/act.jadwal.php',
        			dataType:'json',
        			type:'post',
        			cache:false,
        			data:'act=detailjadwal&id='+calEvent.id,
        			beforeSend:function(){
        				$("#tbjadwal").hide();
        			},
        			success:function(json){
        				if(json.result){
        					$("#tbjadwal").show();
        					$("#nama").html(json.nama+" ("+json.nim+")");
        					$("#jenis").html(json.jenis);
        					$("#judul").html(json.judul);
        					$("#tgl").html(json.tgl+" "+json.wkt);
        					$("#ruangan").html(json.ruangan);
        					$("#pembimbing1").html(json.pemb1);
        					$("#pembimbing2").html(json.pemb2);
        					$("#penguji1").html(json.peng1);
        					$("#penguji2").html(json.peng2);
        					$("#JadwalDetail").modal('show');        					
        				}else{
        					alert(json.msg);
        				}
        			}
        		});
        		return false;
                /*var form = $("<form></form>");
                form.append("<label>Detail</label>");
                form.append("<div class='input-group'><input class='form-control' type=text value='" + calEvent.title + "' /><span class='input-group-btn'><button type='submit' class='btn btn-success'><i class='fa fa-check'></i> Save</button></span></div>");
                $modal.modal({
                    backdrop: 'static'
                });
                $modal.find('.remove-event').show().end().find('.save-event').hide().end().find('.modal-body').empty().prepend(form).end().find('.remove-event').unbind('click').click(function () {
                    calendar.fullCalendar('removeEvents', function (ev) {
                        return (ev._id == calEvent._id);
                    });
                    $modal.modal('hide');
                });
                $modal.find('form').on('submit', function () {
                    calEvent.title = form.find("input[type=text]").val();
                    calendar.fullCalendar('updateEvent', calEvent);
                    $modal.modal('hide');
                    return false;
                });*/
            }		   
		});

	});

	
	function EditJadwal(id){
		location.href="?page=jadwal&act=edit&id="+id;
	}

	function HapusJadwal(id){
		if(confirm("Hapus Jadwal ini")){
			$.ajax({
				url:'page/jadwal/act.jadwal.php',
				type:'post',
				dataType:'json',
				cache:false,
				data:'act=hapusjadwal&jadwal='+id,
				success:function(json){
					if(json.result){
						$.gritter.add({
							title:'Sukses',
			                time: 1000,
			                text: json.msg,
			                after_close: function(){
								$('#list-jadwal').dataTable().fnDraw();
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

	function PublishJadwal(id){
		if(confirm('Terbitkan Jadwal ini ??')){
			$.ajax({
				url:'page/jadwal/act.jadwal.php',
				type:'post',
				dataType:'json',
				cache:false,
				data:'act=publish&idjadwal='+id,
				success:function(json){
					if(json.result){
						$.gritter.add({
							title:'Sukses',
			                time: 1000,
			                text: json.msg,
			                after_close: function(){
								$('#list-jadwal').dataTable().fnDraw();
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