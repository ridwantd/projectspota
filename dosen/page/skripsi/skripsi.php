<?php
switch ($_GET['menu']) {		
	case 'bimbingan':
		include "bimbingan.php";
	break;

	case 'forum':
		include "forum.php";
	break;
	
	case 'forumdosen':
		include "forumdosen.php";
	break;
		
	case 'history':
		include "history.php";
	break;
		
	case 'review':
		include "review.php";
	break;
		
	case 'jadwal':
		include "jadwal.php";
	break;
	
	default:
		echo "<script>location.href='".DOSEN_PAGE."dashboard.php'</script>";
	break;
}
?>