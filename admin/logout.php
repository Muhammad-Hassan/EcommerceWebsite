<?php 

	require_once $_SERVER['DOCUMENT_ROOT'].'/ecom/core/init.php';

	if(isset($_SESSION['DBUser'])){
		unset($_SESSION['DBUser']);
		header('Location:login.php');
	}

 ?>