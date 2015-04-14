<?php
switch ($_GET['menu']) {		
	case 'upload':
		include "upload.php";
	break;

	case 'review':
		include "review.php";
	break;

	case 'daftar-praoutline':
		include "daftar-praoutline.php";
	break;

	case 'pemberitahuan':
		include "pemberitahuan.php";
	break;
	
	default:
		echo "<script>location.href='".DOSEN_PAGE."dashboard.php'</script>";
	break;
}
?>