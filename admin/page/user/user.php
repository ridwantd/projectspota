<?php
switch ($_GET['menu']) {
	case 'man-user':
		if($_SESSION['login-admin']['lvl']=='S'){
			include "daftar-user.php";
		}else{
			//page not found 404
		}
	break;
		
	case 'my-profile':
		include "my-profile.php";
	break;
	
	default:
		echo "<script>location.href='".ADMIN_PAGE."dashboard.php?page=user&menu=man-user'</script>";
	break;
}
?>