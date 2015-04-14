<?php
switch ($_GET['menu']) {
	case 'kalender':
		include "kalender.php";
	break;

	default:
		include "daftar-seminar.php";
	break;
}
?>