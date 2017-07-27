<?php 

require_once '../core/init.php';


	// checking if user has is not logged in then:
	if(!isLoggedIn()){
		// Call the login error redirect function:
		loginErrorRedirect();
	}

	// checking if user has not granted permission of admin:
	if(!hasPermissions('admin')){

		permissionsErrorRedirect('index.php');
	}


	include '/includes/head.php';
	include '/includes/navigation.php';

	


	if(isset($_GET['delete'])){
		$deleteId = sanitize($_GET['delete']);
		$db->query("DELETE FROM users WHERE id = '$deleteId'");
		$_SESSION['success_flash'] = "Selected user has been deleted";
		header('Location:users.php');
	}

	if(isset($_GET['add'])){

		$name = ((isset($_POST['name']))?sanitize($_POST['name']):'');
		$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
		$hashedPassword = password_hash($password,PASSWORD_DEFAULT);
		$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
		$confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
		$permissions = ((isset($_POST['permissions']))?sanitize($_POST['permissions']):'');

		$errors = array();

		if($_POST){

			$emailQuery = $db->query("SELECT * FROM users WHERE email = '$email'");
			$emailCount = mysqli_num_rows($emailQuery);

			if($emailCount != 0){
				$errors[] = "Email provided already exist in the database.";
			}

			$required = array('name','email','password','confirm','permissions');

			foreach ($required as $f) {
				# code...
				if(empty($_POST[$f])){
					$errors[] = 'You must fill out all fields';
					break;
				}
			}

			

			if(strlen($password)<6 && strlen($password)!=0){
				$errors[] = "Password must be at least 6 characters long.";
			}

			if($password != $confirm){
				$errors[] = "Your passwords does not match.";
			}

			if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
				$errors[] = 'You must enter a valid email.';
			}



			if(!empty($errors))
			{
				echo displayErrors($errors);
			}

			else
			{
				$db->query("INSERT INTO users (full_name,email,password,permissions) VALUES ('$name','$email','$hashedPassword','$permissions')");
				$_SESSION['success_flash'] = 'User data inserted successfully.';
				header('Location:users.php');
			}
		}
		?>
		<h2 class="text-center">Add A New User</h2><hr>

		<form action="users.php?add=1" method="post">
				
				<div class="form-group col-md-6">
					
					<label for="name">Full Name:</label>
					<input type="text" name="name" id="name" class="form-control" value="<?= $name; ?>">

				</div>

				<div class="form-group col-md-6">
					
					<label for="email">Email:</label>
					<input type="text"  class="form-control" name="email" id="email" value="<?= $email; ?>">

				</div>


			
				<div class="form-group col-md-6">
					
					<label for="password">Password:</label>
					<input type="password" name="password"  class="form-control" id="password" value="<?= $password; ?>">

				</div>



				<div class="form-group col-md-6">
					
					<label for="confirm">Confirm Password:</label>
					<input type="password" name="confirm" id="confirm"  class="form-control" value="<?= $confirm; ?>">

				</div>



				<div class="form-group col-md-6">
					
					<label for="email">Permissions:</label>
					<select class="form-control" name="permissions">
						<option value=""<?= (($permissions == '')?' selected':''); ?>></option>
						<option value="editor"<?= (($permissions == 'editor')?' selected':''); ?>>Editor</option>
						<option value="admin,editor"<?= (($permissions == 'admin,editor')?' selected':''); ?>>Admin</option>
					</select>

				</div>
				
				<div class="form-group col-md-6 text-right" style="margin-top: 25px;">
					
					<a href="users.php" class="btn btn-default">Cancel</a>
					<input type="submit" value="Add User" class="btn btn-primary">

				</div>



			
		</form>
		<?php
	}
	else
	{


		
		

		

		 

		$userQuery = $db->query("SELECT * FROM users ORDER BY full_name");
	
 ?>

	<h2 class="text-center">Users</h2>
	<a href="users.php?add=1" class="btn btn-success pull-right" id="add-product">Add User</a>
	<hr>

	<table class="table table-bordered table-striped table-condensed">
			<thead>
				
				<th></th>
				<th>Name</th>
				<th>Email</th>
				<th>Join Date</th>
				<th>Last Login</th>
				<th>Permissions</th>

			</thead>

			<tbody>
				<?php while($usersArray = mysqli_fetch_assoc($userQuery)): ?>
				<tr>
					<td>
					
					<?php 
					// if users id not equal to the id which is currently logged on then display delete button for other users data to delete:
					if($usersArray['id'] != $user_id): ?>
						
						<a href="users.php?delete=<?= $usersArray['id']; ?>" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-remove"></span></a>
			
					<?php endif; ?>

					</td>
					<td><?= $usersArray['full_name']; ?></td>
					<td><?= $usersArray['email']; ?></td>
					<td><?= dateFormat($usersArray['join_date']); ?></td>
					<td><?= (($usersArray['last_login'] == '0000-00-00 00:00:00' )? 'Never' : dateFormat($usersArray['last_login'])) ; ?></td>
					<td><?= $usersArray['permissions']; ?></td>
				</tr>
				<?php endwhile; ?>
			</tbody>

	</table>


 <?php }
 include  '/includes/footer.php';

  ?>