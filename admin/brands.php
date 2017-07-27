<?php 

require_once '../core/init.php';
if(!isLoggedIn()){
		loginErrorRedirect();
	}

include '/includes/head.php';
include '/includes/navigation.php';

$sql = "SELECT * FROM brand Order By brand";
$result = $db->query($sql);


// Edits Brand Stored In Database:
	
	if(isset($_GET['edit']) && !empty($_GET['edit'])){
		$edit_id = (int)$_GET['edit'];
		$edit_id = sanitize($edit_id);
		$sqlEdit = "SELECT * FROM brand WHERE id = '$edit_id'";
		$resultEdit = $db->query($sqlEdit);
		$resultEditArray = mysqli_fetch_assoc($resultEdit);
	}




// Deletes Brand From Database:

	if (isset($_GET['delete']) && !empty($_GET['delete'])){
		$delete_id = (int)$_GET['delete'];
		$delete_id = sanitize($delete_id);
		$sql = "DELETE FROM brand WHERE id = '$delete_id'";
		$db->query($sql);
		header('Location: brands.php');
	}





// Making an array to hold errors related to the Brand Form Submission:
$errors = array();

// Verifying the submission of Brand Form:
if (isset($_POST['add_submit'])){
	/*Making a variable to hold the data present inside brand column of brand table:
	using helper function sanitize converting the input data into html entites:*/
	$brandInDatabase = sanitize($_POST['brand']);

	$sql = "SELECT * FROM brand WHERE brand = '$brandInDatabase'";

	// Checking whether Edit Button Clicked or not:
	if(isset($_GET['edit'])){
		/*Updating SQL statement to select all the rows from brand table where brand 
		column is equal to the brand stored in the database AND id is not equal to 
		the brand edit button clicked by the user:*/
		$sql = "SELECT * FROM brand WHERE brand = '$brandInDatabase' AND id != '$edit_id'";

	}

	$result = $db->query($sql);
	/* Holding the number of rows which corresponds to the given data inside database:
	By using the predefined function mysqli_num_rows:
	*/
	$countNumOfRowsForBrand = mysqli_num_rows($result);

	// if number of rows is > 0 which means there exist a row for the given data then simply
	// add the error message to the errors array:
	if($countNumOfRowsForBrand > 0){
		$errors[] .=$brandInDatabase." already exist. Please Choose another Name.";
	}



	// Verifying if submission of Brand Form is blank:
	if($_POST['brand'] == ''){
		// Add the message to the errors array:
		$errors[] .= 'You must enter a brand!';
	}
	// Verifying that errors array is filled and if it is filled then execute helper function:
	if(!empty($errors)){
		// Display Errors:
		echo displayErrors($errors);
	}
	// if there are no errors then execute this block of statements:
	else
	{
		// Making SQL query to insert the input brand to the brand table in database:
		$sql = "INSERT into brand (brand) VALUES ('$brandInDatabase')";
		// Checking if User Clicked Edit Button:
		if(isset($_GET['edit'])){
			// Then Update the Sql statement to update brand table where id match with the 
			// edit button clicked by the user:
			$sql = "UPDATE brand SET brand = '$brandInDatabase' WHERE id = '$edit_id'";
		}

		$result = $db->query($sql);
		// Refreshing the page brands.php:
		header('Location: brands.php');
	
	}
}

 ?>
<h2 class="text-center">Brands</h2><hr>

<!-- Brands Form -->


<div class="text-center">

	<form action="brands.php<?= ((isset($_GET['edit']))?'?edit='.$edit_id:'') ?>" class="form-inline" method="post">
	

		<div class="form-group">
		<?php 
		$brand_value = '';
		if(isset($_GET['edit'])){
			$brand_value = $resultEditArray['brand'];
		}
		else
		{
			if(isset($_POST['brand'])){
				$brand_value = sanitize($_POST['brand']);
			}
		}



		 ?>
			

			<label for="brand"><?= ((isset($_GET['edit']))?'Edit A': 'Add A') ?> Brand:</label>
			<input type="text" name="brand" id="brand" class="form-control" 
			value="<?= $brand_value; ?>">

			<?php if(isset($_GET['edit'])): ?>
				
				<a href="brands.php" class="btn btn-default">Cancel</a>

			<?php endif; ?>


			<input type="submit" name="add_submit" value="<?= ((isset($_GET['edit']))?'Edit':'Add') ?> Brand" class="btn btn-success">
		</div>


	</form><hr>



</div>

<table class="table table-bordered talbe-striped tbl-auto table-condensed">
	<thead>
		<th></th>
		<th>Brand</th>
		<th></th>
	</thead>
<tbody>
	<?php while ($brand = mysqli_fetch_assoc($result)) : ?>
	<tr>
		<td><a href="brands.php?edit=<?= $brand['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a></td>
		<td><?= $brand['brand']; ?></td>
		<td><a href="brands.php?delete=<?= $brand['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a></td>

	</tr>
<?php endwhile; ?>
</tbody>


</table>


 <?php 
 include '/includes/footer.php';

  ?>