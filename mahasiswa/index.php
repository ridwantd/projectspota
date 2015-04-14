<?php
session_start();

if(!$_SESSION['login-mhs']){
	header('location:login.php');
}else{
	header('location:dashboard.php');
}

?>