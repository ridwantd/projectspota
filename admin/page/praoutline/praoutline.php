<?php
switch ($_GET['menu']) {		
	case 'my-review':
		include "my-review.php";
	break;

	case 'new':
		include "judul-terbaru.php";
	break;

	case 'statistik':
		include "statistik.php";
	break;

	case 'review':
		include "review.php";
	break;

	/*case 'daftar-praoutline':
		include "daftar-praoutline.php";
	break;*/

	case 'cari':
		include "cari.php";
	break;

	case 'keputusan':
		include "keputusan.php";
	break;

	case 'kep-draft-praoutline':
		include "kep.draft.praoutline.php";
	break;

	case 'pemberitahuan':
		include "pemberitahuan.php";
	break;
	
	default:
		echo "<script>location.href='".ADMIN_PAGE."dashboard.php'</script>";
	break;
}
?>