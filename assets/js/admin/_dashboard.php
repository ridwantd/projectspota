<link rel="stylesheet" href="../assets/plugins/fullcalendar/fullcalendar/fullcalendar.css" />
<link href="../assets/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>
<link href="../assets/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>

<script src="../assets/plugins/fullcalendar/fullcalendar/fullcalendar.js"></script> 
<script src="../assets/plugins/bootstrap-modal/js/bootstrap-modal.js"></script>
<script src="../assets/plugins/bootstrap-modal/js/bootstrap-modalmanager.js"></script>
<script>
	jQuery(document).ready(function() {
		Main.init();
		/*Index.init();*/
		var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        $('#calendar').fullCalendar({
            editable: true,
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month'
            },
            events: "page/dashboard/json.kalender.php",
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
                    url:'page/dashboard/act.dashboard.php',
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
            }          
        });
	});
</script>