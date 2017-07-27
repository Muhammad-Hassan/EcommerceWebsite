<?php 
	require_once $_SERVER['DOCUMENT_ROOT'].'/ecom/core/init.php';
	include 'includes/head.php';

	$hashedPassword = $user_data['password'];
	
	
	$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
	$password = trim($password);
	// Using password_hash function to hash new password provided by the user:
	$newHashedPassword = password_hash($password,PASSWORD_DEFAULT);
	$oldPassword = ((isset($_POST['old_password']))?sanitize($_POST['old_password']):'');
	$oldPassword = trim($oldPassword);
	$confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
	$confirm = trim($confirm);
	$errors = array();
	?>



<div id="login-form">
	
<div>
	<?php 
		if($_POST){

		// if any of the field is empty then throw an error message:
		if(empty($_POST['old_password']) || empty($_POST['password']) || empty($_POST['confirm']))
		{
			$errors[] = "You must enter all fields.";
		}

	


		
		if(strlen($password)<6){
			$errors[]= "Password must be at least 6 characters long.";
		}

		// if new password not verified by the old password in the form of hashed password stored in the database then throw an error message:
		if(!password_verify($oldPassword,$hashedPassword)){
			$errors[]="Your old password does not match our record.";
		}
		
		if($password != $confirm){
			$errors[] = "Please type same password twice to proceed in new password and confirm fields.";
		}

		if(!empty($errors)){
			echo displayErrors($errors);
		}
		else{
			// Save New Password In Database:
			$query = $db->query("UPDATE users SET password = '$newHashedPassword' WHERE id='$user_id'");
			$_SESSION['success_flash'] = "Your password has updated!";
			header('Location:index.php');

			
		}
	}

	

	 ?>


</div>

<h2 class="text-center">Change Password</h2><hr>
<form action="change_password.php" method="post">
	<div class="form-group">
		<label for="old_password">Old Password:</label>
		<input type="password" name="old_password" id="old_password" class="form-control" value="<?= $oldPassword; ?>">

	</div>

	<div class="form-group">
		<label for="password">New Password:</label>
		<input type="password" name="password" id="password" class="form-control" value="<?= $password; ?>">

	</div>

	<div class="form-group">
		<label for="confirm">Confirm New Password:</label>
		<input type="password" name="confirm" id="confirm" class="form-control" value="<?= $confirm; ?>">
	</div>

	<div class="form-group">
	<a href="index.php" class="btn btn-default">Cancel</a>
		<input type="submit" value="Save" class="btn btn-primary">
	</div>

</form>

	<p class="text-right"><a href="/ecom/index.php" alt="home">Visit Site</a></p>
</div>


<?php 
	include 'includes/footer.php';
 ?>