<?php
session_start();
if(!$_SESSION['login-dosen']){
	header('location:login.php');
}else{
	header('location:dashboard.php');
}

?>