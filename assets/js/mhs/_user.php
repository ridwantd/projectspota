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
		$("#updateprofil").validate({
        	errorPlacement:function(error,element){
                error.appendTo( element.parent("div"));
            },
            rules:{
                nmLengkap:{
                    required:true,
                    minlength:3
                },
                email:{
                    required:true
                }
            },
            messages:{
                nmLengkap:{
                    required:"Nama Lengkap tidak boleh kosong",
                    minlength:"Minimal 3 karakter"
                },
                email:{
                    required:"Email harus diisi"
                }
            },
            submitHandler:function(form){
                if(window.FormData !== undefined)  // for HTML5 browsers
                {
                    var formData = new FormData(document.getElementById("updateprofil"));
                    $.ajax({
                        url:'page/user/act.user.php',
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
                                        location.href="?page=user&menu=my-profile";
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
	});
</script>