<?php
switch ($_GET['menu']) {
	case 'daftar-pengumuman':
		include "daftar-pengumuman.php";
	break;
	
	case 'buat-pengumuman':
		include "buat-pengumuman.php";
	break;

	case 'edit-pengumuman':
		include "edit-pengumuman.php";
	break;
		
	default:
		echo "<script>location.href='".ADMIN_PAGE."dashboard.php?page=pengumuman&menu=daftar-pengumuman'</script>";
	break;
}
?>