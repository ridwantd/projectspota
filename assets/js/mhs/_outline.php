<link rel="stylesheet" href="../assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css">
<script src="../assets/plugins/bootstrap-daterangepicker/moment.min.js"></script>
<script src="../assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="../assets/js/form-elements.js"></script>
<script src="../assets/plugins/ckeditor/ckeditor.js"></script>
<script src="../assets/plugins/ckeditor/adapters/jquery.js"></script>
<script>
	jQuery(document).ready(function() {
		Main.init();
		
		//function to initiate daterangepicker
		$('.date-range').daterangepicker();
		
		
	});
	
	CKEDITOR.disableAutoInline = true;
	$('textarea.ckeditor').ckeditor({
		height:240
	});
</script>