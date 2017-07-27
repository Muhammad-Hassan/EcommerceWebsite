<?php 
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/ecom/core/init.php';
	if(!isLoggedIn()){
		loginErrorRedirect();
	}

	include 'includes/head.php';
	include 'includes/navigation.php';

	$sql = "SELECT * FROM categories WHERE parent = 0";
	$result = $db->query($sql);

	$errors = array();
	$category = '';
	$postParent = '';


	// Edit Logic For Categories :

	if(isset($_GET['edit']) && !empty($_GET['edit'])){
		$edit_id = (int)$_GET['edit'];
		$edit_id = sanitize($edit_id);
		$editSql = "SELECT * FROM categories WHERE id = '$edit_id'";
		$editResult = $db->query($editSql);
		$categoryEdit = mysqli_fetch_assoc($editResult);
	}

	// Deleting Entries From Categories Table:

	if(isset($_GET['delete']) && !empty($_GET['delete'])){

		$delete_id = (int)$_GET['delete'];
		$delete_id = sanitize($delete_id);
		$sql = "SELECT * FROM categories WHERE id = '$delete_id'";
		$result = $db->query($sql);
		$categoryDelete = mysqli_fetch_assoc($result);
		// if the selected row is Parent:
		if($category['parent'] == 0){
			// Then Delete All the Childs Which That Selected Parent have:
			$sql = "DELETE FROM categories WHERE parent = '$delete_id'";
			$db->query($sql);
		}

		$dsql = "DELETE FROM categories WHERE id = '$delete_id'";
		$db->query($dsql);
		header('Location: categories.php');
	}


	// Process Category Form Errors Validation:

	if(isset($_POST) && !empty($_POST)){
		$postParent = sanitize($_POST['parent']);
		$category = sanitize($_POST['category']);
		$sqlform = "SELECT * FROM categories WHERE category = '$category' AND parent = '$postParent'";
		if(isset($_GET['edit'])){
			$id = $categoryEdit['id'];
			$sqlform = "SELECT * FROM categories WHERE category = '$category' AND parent = '$postParent' AND id != '$id'";
		}
		$fresult = $db->query($sqlform);
		$count = mysqli_num_rows($fresult);

		// if Category Form is posted blank then:
		if($category == ''){
			// Add this message to the errors array:
			$errors[] .= 'The category cannot be left blank'; 
		}
	
		if($count > 0){
		$errors[] .= $category.' already exist.Please choose a new category';
		}

	if(!empty($errors)){
		$display = displayErrors($errors); ?>

		<script>
		jQuery('document').ready(function(){
			jQuery('#errors').html('<?= $display; ?>');
		});


		</script>	
		<?php 
	}

	else{

		$updateSql = "INSERT INTO categories (category,parent) VALUES ('$category','$postParent')";
		if(isset($_GET['edit'])){
			$updateSql = "UPDATE categories SET category = '$category', parent = '$postParent' WHERE id = '$edit_id'";
		}
		$db->query($updateSql);
		header('Location: categories.php');

	}

	}
	$valueParent = 0;
	$valueCategory = '';
	if(isset($_GET['edit'])){
		$valueCategory = $categoryEdit['category'];
		$valueParent = $categoryEdit['parent'];
		
	}else
	{ 
		if(isset($_POST))
	{
		$valueCategory = $category;
		$valueParent = $postParent;
	}
	}

 ?>

	


<h2 class="text-center">Categories</h2><hr>
<div class="row">

	<!-- Section For Form: -->
	<div class="col-md-6">
		<form action="categories.php<?= ((isset($_GET['edit']))?'?edit='.$edit_id:''); ?>" class="form" method="post">
			<div class="form-group">
			<legend><?= ((isset($_GET['edit']))?'Edit':'Add A'); ?> Category:</legend>
				<div id="errors"></div>
				<label for="parent">Parent</label>
				<select name="parent" id="parent" class="form-control">
					<option value="0"<?= (($valueParent == 0)?'selected="selected"':''); ?>>Parent</option>
					<?php while ($parent = mysqli_fetch_assoc($result)) : ?>
						<option value="<?= $parent['id']; ?>"<?= (($valueParent == $parent['id'])?'selected="selected"':''); ?>><?= $parent['category']; ?>
							
						</option>
					<?php endwhile; ?>
				</select>
			</div>
		
		<div class="form-group">
		<label for="category">Category</label>
		<input type="text" class="form-control" id="category" name="category" 
		value="<?= $valueCategory; ?>">

		</div>

		<div class="form-group">
			<input type="submit" value="<?= ((isset($_GET['edit'])) ? 'Edit' : 'Add'); ?> Category" class="btn btn-success">
		</div>
			
		</form>
	</div>

	


	<div class="col-md-6">
		<table class="table table-bordered">
			<thead>
				<th>Category</th><th>Parent</th><th></th>

			</thead>
		<tbody>
			<?php 
			$sql = "SELECT * FROM categories WHERE parent = 0";
			$result = $db->query($sql);
			while($parent = mysqli_fetch_assoc($result)): 
			$parent_id = (int)$parent['id'];
			$sql2 = "SELECT * FROM categories WHERE parent = '$parent_id'";
			$cresult = $db->query($sql2);



			?>
			<tr class="bg-primary">
				<td><?= $parent['category']; ?></td>
				<td>Parent</td>
				<td>
					<a href="categories.php?edit=<?= $parent['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
					<a href="categories.php?delete=<?= $parent['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>
				</td>


			</tr>
			<?php while($child = mysqli_fetch_assoc($cresult)): ?>
			<tr class="bg-info">
				<td><?= $child['category']; ?></td>
				<td><?= $parent['category']; ?></td>
				<td>
					<a href="categories.php?edit=<?= $child['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
					<a href="categories.php?delete=<?= $child['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>
				</td>


			</tr>

		<?php endwhile; ?>
		<?php endwhile; ?>

		</tbody>


		</table>

	</div>



</div>

 <?php include 'includes/footer.php'; ?>