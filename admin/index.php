<?php
session_start();
if(!$_SESSION['login-admin']){
	header('location:login.php');
}else{
	header('location:dashboard.php');
}

?>