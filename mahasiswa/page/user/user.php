<?php
switch ($_GET['menu']) {		
	case 'my-profile':
		include "my-profile.php";
	break;
	
	default:
		echo "<script>location.href='".MHS_PAGE."dashboard.php?page=user&menu=my-profile'</script>";
	break;
}
?>