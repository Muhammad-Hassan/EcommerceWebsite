<?php 

	require_once $_SERVER['DOCUMENT_ROOT'].'/ecom/core/init.php';
	if(!isLoggedIn()){
		loginErrorRedirect();
	}

	include 'includes/head.php';
	include 'includes/navigation.php';

	




	
	

	

 ?>
	

	<h2 class="text-center">Archived Products</h2><hr>

	<table class="table table-bordered table-condensed table-striped">
		
		<thead>
			
			<th></th>
			<th>Product</th>
			<th>Price</th>
			<th>Category</th>
			<th>Sold</th>

		</thead>

		<tbody>
			
		<?php

		$sql = "SELECT * FROM products WHERE deleted = 1";
		$result = $db->query($sql);

		 while($deletedProduct = mysqli_fetch_assoc($result)): 
			
			// Selecting all the rows from categories table where id is related to child id 
		$childId = $deletedProduct['categories'];
		$childSql = "SELECT * FROM categories WHERE id = '$childId'";
		$result = $db->query($childSql);
		// Making an associative array to hold all the rows of categories table belong to the child id
		$childCategory = mysqli_fetch_assoc($result);
		// Making a variable to hold an id related to the parent 
		$parentId = $childCategory['parent'];
		// Selecting all the rows from categories where id is related to the parent id 
		$parentSql = "SELECT * FROM categories WHERE id = '$parentId'";
		$parentResult = $db->query($parentSql);
		// Making an associative array to hold all the rows of categories table belong to the parent id:
		$parentCategory = mysqli_fetch_assoc($parentResult);
		// Concatinating both parent and child associative arrays category data with a tilde sign to produce output for the category column in the table:
		$category = $parentCategory['category'].'~'.$childCategory['category'];
		 ?>

		<tr>
			
		<td>
			<a href="archived.php?restore=<?= $deletedProduct['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-refresh"></span></a>

		</td>
		<td><?= $deletedProduct['title']; ?></td>
		<td><?= $deletedProduct['price']; ?></td>
		<td><?= $category; ?></td>
		<td></td>

		</tr>

		<?php endwhile; ?>
		</tbody>


	</table>


 <?php 

 	if(isset($_GET['restore'])){
		// Take out the integer id of the restore key:
		$id = (int)$_GET['restore'];
		// Query for updating products table where id is equal to the restore key id and setting deleted column value to 0:
		$deleteQuery = "UPDATE products SET deleted=0 WHERE id='$id'";
		$db->query($deleteQuery);
		header('Location:archived.php');
	}

 	include 'includes/footer.php';
  ?>