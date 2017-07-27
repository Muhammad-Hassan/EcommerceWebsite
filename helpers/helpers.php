<?php

	// This function will display Errors for Brands Form:
	function displayErrors($errors){
		$display = '<ul class="bg-danger">';
		foreach ($errors as $error) {
			# code...
			$display .= '<li class="text-danger">'.$error. '</li>';
		}
		$display .= '</ul>';
		return $display;
	}

	function money($number){
	  return '$'.number_format($number,2);
	}

	// This helper function will convert the input html entites into UTF-8 character code:
	function sanitize($dirty){
		return htmlentities($dirty,ENT_QUOTES,"UTF-8");
	}


	function closeModal(){
		jQuery('#details-modal').modal('hide');
		setTimeout(function(){
			jQuery('#details-modal').remove();
		},500);
	}

	// This function is for the login access to the user based on the id which is store inside users table in the database:


	function login($user_id){
		// Storing the user id from the users table into the session variable:
		$_SESSION['DBUser'] = $user_id;
		// Making a global variable so then its value can be accessed inside or outside this function:
		global $db;
		// Defining a variable to hold current date in the format of Year-Month-Date Hour:Minute:Seconds:
		$date = date("Y-m-d H:i:s");
		// Executing query for updating users table where assigning last_login value to the current date stored in the $date variable where id is equal to the user id inside database:
		$db->query("UPDATE users SET last_login = '$date' WHERE id='$user_id'");
		// Making a session variable to hold down the string:
		$_SESSION['success_flash'] = 'You are now logged in!';
		header('Location:index.php');
	}

	// This function is for verifying whether user is logged in or not:
	function isLoggedIn(){
		//Verifying if both conditions becomes true then return true:
		if(isset($_SESSION['DBUser']) && $_SESSION['DBUser']>0){
			return true;
		}
		return false;
	}

	// This function is for the redirection of the flow of code when any error occured inside the execution of the login function:
	// By default the url parameter value if not passed in calling of function will be login.php
	function loginErrorRedirect($url = 'login.php'){
		$_SESSION['error_flash'] = 'You must be logged in to access that page.';
		header('Location: '.$url);
	}

	// This function is for the redirection of the flow of code when any error occured during the execution of the hasPermission function:
	function permissionsErrorRedirect($url = 'login.php'){
		$_SESSION['error_flash'] = 'You dont have permissions to access that page.';
		header('Location: '.$url);
	}

	// This function is for the verification of the permissions assigned to the user whether it can access certain pages or not based on the permissions granted inside the database by the admin:
	function hasPermissions($permission = 'admin'){
		// Making user_data variable global so then its outside value can be access within function:
		global $user_data;
		// Making an array by exploding permissions stored in the database by , :
		$permissions = explode(',',$user_data['permissions']);
		// Verifying if in the array both permission and permissions value matched then return true:
		if(in_array($permission, $permissions,true)){
			return true;
		}
		// else return false:
		return false;

	}


	function dateFormat($date){
		return date("d M Y h:i A",strtotime($date));
	}

	function getCategory($childId){
		global $db;
		$id = sanitize($childId);
		$sql = "SELECT p.id AS 'ParentId', p.category AS 'ParentCategory', c.id AS 'ChildId', c.category AS 'childCategory'
			FROM categories c
			INNER JOIN categories p
			ON c.parent = p.id
			WHERE c.id = '$id'";
		$query = $db->query($sql);
		$category = mysqli_fetch_assoc($query);
		return $category;
	}

	function addToCart(){
		alert("It works!");
	}

	function sizesToArray($string){

		$sizesArray = explode(',', $string);
		$returnArray = array();
		foreach ($sizesArray as $size) {
			# code...
			$s = explode(':',$size);
			$returnArray[] = array('size' => $s[0], 'quantity' => $s[1]);
		}
		return $returnArray;
	}

	function sizesToString($sizes){

		$sizeString = '';
		foreach ($sizes as $size) {
			# code...
			$sizeString .= $size['size']. ':' . $size['quantity'].',';

		}
		$trimmed = rtrim($sizeString,',');
		return $trimmed;
	}




 ?>
