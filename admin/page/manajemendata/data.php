<?php
switch ($_GET['menu']) {
	case 'data-mahasiswa':
		include "data-mahasiswa.php";
	break;

	case 'data-dosen':
		include "data-dosen.php";
	break;

	case 'data-fakultas':
		include "data-fakultas.php";
	break;

	case 'data-jurusan':
		include "data-jurusan.php";
	break;

	case 'data-prodi':
		include "data-prodi.php";
	break;
	
	default:
		echo "<script>location.href='".ADMIN_PAGE."dashboard.php?page=data&menu=data-mahasiswa'</script>";
	break;
}

?>