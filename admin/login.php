<?php 
	require_once $_SERVER['DOCUMENT_ROOT'].'/ecom/core/init.php';
	include 'includes/head.php';

	 // $password = 'password';
	 // $hashed = password_hash($password,PASSWORD_DEFAULT);
	 // echo $hashed;

	$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
	//$email = trim($email);
	$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
	//$password = trim($password);
	$errors = array();
	?>

	<style>
		body{
			background-image: url('/ecom/images/headerlogo/background.png');
			background-size: 100vw 100vh ;
			background-attachment: fixed;
		}
	</style>


<div id="login-form">
	
<div>
	<?php 
		if($_POST){
		if(empty($_POST['email']) || empty($_POST['password']))
		{
			$errors[] = "You must enter email and password.";
		}

		// Validating Email:

		if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
			$errors[] = "You must enter a validate email.";
		}


		// Verify that if email exist in the database or not:

		$query = $db->query("SELECT * FROM users WHERE email='$email'");
		$usersCount = mysqli_num_rows($query);
		$user = mysqli_fetch_assoc($query);
		
		if($usersCount < 1){
			$errors[] = "Email provided doesn't exist in the database.";
		}

		if(strlen($password)<6){
			$errors[]= "Password must be at least 6 characters long.";
		}

		if(!password_verify($password,$user['password'])){
			$errors[]="Your password doesn't match our records.";
		}

		if(!empty($errors)){
			echo displayErrors($errors);
		}
		else{
			// Assigning the id of the users table to the variable user_id:
			$user_id = $user['id'];
			// Calling login function with the parameter $user_id:
			login($user_id);
		}
	}

	

	 ?>


</div>

<h2 class="text-center">Login</h2><hr>
<form action="login.php" method="post">
	<div class="form-group">
		<label for="email">Email:</label>
		<input type="text" name="email" id="email" class="form-control" value="<?= $email; ?>">

	</div>

	<div class="form-group">
		<label for="password">Password:</label>
		<input type="password" name="password" id="password" class="form-control" value="<?= $password; ?>">

	</div>

	<div class="form-group">
		<input type="submit" value="Login" class="btn btn-primary">
	</div>

</form>

	<p class="text-right"><a href="/ecom/index.php" alt="home">Visit Site</a></p>
</div>


<?php 
	include 'includes/footer.php';
 ?>