


<?php 
	require_once $_SERVER['DOCUMENT_ROOT'].'/ecom/core/init.php';
	if(!isLoggedIn()){
		loginErrorRedirect();
	}

	include 'includes/head.php';
	include 'includes/navigation.php';
	$dbPath = '';

	// Verifying if the delete key is set:
	if(isset($_GET['delete'])){
		// Take out the integer id of the delete key:
		$id = (int)$_GET['delete'];
		// Query for updating products table where id is equal to the delete key id and setting deleted column value to 1:
		$deleteQuery = "UPDATE products SET deleted=1 WHERE id='$id'";
		$db->query($deleteQuery);
		header('Location:products.php');
	}

	// When the add or get key is set then display the form for adding new product details into the database:
	if (isset($_GET['add']) || isset($_GET['edit'])) {
		
		$brandQuery = $db->query("SELECT * FROM brand ORDER BY brand");
		$parentCategoryQuery = $db->query("SELECT * FROM categories WHERE parent = 0 ORDER BY category");

		$title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):'');
		$brand = ((isset($_POST['brand'])&& $_POST['brand']!= '')?sanitize($_POST['brand']):'');
		$parent = ((isset($_POST['parent'])&& $_POST['parent']!= '')?sanitize($_POST['parent']):'');
		$categories = ((isset($_POST['child'])&& $_POST['child']!= '')?sanitize($_POST['child']):'');

		$price = ((isset($_POST['price']) && $_POST['price'] != '')?sanitize($_POST['price']):'');

		$list_price = ((isset($_POST['list_price']) && $_POST['list_price'] != '')?sanitize($_POST['list_price']):'');

		$description = ((isset($_POST['description']) && $_POST['description'] != '')?sanitize($_POST['description']):'');

		$sizes = ((isset($_POST['sizes']) && $_POST['sizes'] != '')?sanitize($_POST['sizes']):'');

		$sizes = rtrim($sizes,',');

		$savedImage = '';

		
		if(isset($_GET['edit'])){

			$edit_id = (int)$_GET['edit'];
			$editProduct = $db->query("SELECT * FROM products WHERE id = '$edit_id'");
			$editProductArray = mysqli_fetch_assoc($editProduct);
			$title =((isset($_POST['title'])&& !empty($_POST['title']))?sanitize($_POST['title']):$editProductArray['title']);
			$brand =((isset($_POST['brand'])&& !empty($_POST['brand']))?sanitize($_POST['brand']):$editProductArray['brand']);
			
			$categories = ((isset($_POST['child'])&& $_POST['child']!= '')?sanitize($_POST['child']):$editProductArray['categories']);
			$pQuery = $db->query("SELECT * FROM categories WHERE id = '$categories'");
			$pResult = mysqli_fetch_assoc($pQuery);
			$parent =((isset($_POST['parent'])&& !empty($_POST['parent']))?sanitize($_POST['parent']):$pResult['parent']);

			$price =((isset($_POST['price'])&& !empty($_POST['price']))?sanitize($_POST['price']):$editProductArray['price']);

			$list_price =((isset($_POST['list_price'])&& !empty($_POST['list_price']))?sanitize($_POST['list_price']):$editProductArray['list_price']);

			$description =((isset($_POST['description'])&& !empty($_POST['description']))?sanitize($_POST['description']):$editProductArray['description']);

			$sizes =((isset($_POST['sizes'])&& !empty($_POST['sizes']))?sanitize($_POST['sizes']):$editProductArray['sizes']);

			$sizes = rtrim($sizes,',');

			$savedImage =(($editProductArray['image']!= '')?$editProductArray['image']:'');
			$dbPath = $savedImage;

			// This code is for the deleting of image in the edit part :
			if(isset($_GET['delete_image'])){
				// Saving the url to the image stored in the database:
				$image_url = $_SERVER['DOCUMENT_ROOT'].$editProductArray['image'];
				// Destroying the image url by the function unlink:
				unlink($image_url);
				// Updating the table products in the database by changing the value of image column to an empty string where id match with the edit id:
				$db->query("UPDATE products SET image = '' WHERE id = '$edit_id'");
				header('Location: products.php?edit='.$edit_id);
			}

		}

		if(!empty($sizes)){

				$sizeString = sanitize($sizes);
				// Trimining the last part of the string which contains additional , :
				$sizeString = rtrim($sizeString,','); 
				//echo $sizeString;
				// Using explode funtion to seperate string by , :
				$sizesArray = explode(',',$sizeString);
				// Making two empty arrays for size and quantity string:
				$sizeArray = array();
				$qtyArray = array();
				// iterating through the array which contains sizes and quantity :
				foreach ($sizesArray as $ss) {
					// Making a new array to hold down the size and quantity only by exploding out the : in between two strings:
					$s = explode(':', $ss);
					// Storing the size string which is at the index 0 into the size array:
					$sizeArray[] = $s[0];
					// Storing the quantity string which is at the index 1 into the qty array:
					$qtyArray[] = $s[1];
					
				}
			}
			else
			{
				// if form is posted without any information about sizes and quantity then make an empty array of sizes and quantity :
				$sizesArray=array();
			}

		
		// if form is posted to add a new product then execute following code:
		if($_POST){
			
			
			//$categories = sanitize($_POST['child']);
			//$price = sanitize($_POST['price']);
			//$list_price = sanitize($_POST['list_price']);
			//$sizes = sanitize($_POST['sizes']);
			$description = sanitize($_POST['description']);
			
			// Making an empty array :
			$errors = array();
			// if form is posted with not an empty sizes and quantity:
			
			$requiredFields = array('title','brand','price','parent','child','sizes');
			foreach ($requiredFields as $field) {
				if($_POST[$field]==''){
					$errors[]='All fields with an asterisk * are required.';
					break;
				}
			}

			// Verifying that the user has uploaded the correct Image not any other file:
			if(!empty($_FILES)){

				//var_dump($_FILES);
				// making a variable to hold down the data contained in a super global variable $_FILES which is an associative array:
				$photo = $_FILES['photo'];
				// Assigning the name column from the associative array:
				$name = $photo['name'];
				// Assigning the name after exploding the name by . :
				$nameArray = explode('.',$name);
				// Assigning the first part of the string which is name into variable by refering the array index 0:
				$fileName = $nameArray[0];
				// Assigning the second part of the string which is the extension by refering the array index 1:
				$fileExtension = $nameArray[1];
				// Assigning the type of the file by exploding the string by forward slash / :
				$mime = explode('/',$photo['type']);
				// Assigning the Type of the file into a variable which is at an index 0:
				$mimeType = $mime[0];
				// Assinging the temporary Location name which generates automatically when file is uploaded:
				$tmpLocation = $photo['tmp_name'];
				// Assigning the size column of an associative array to the variable:
				$fileSize = $photo['size'];
					
				$allowedExtensions = array('jpg','jpeg','png','gif');

				$uploadName = md5(microtime()).'.'.$fileExtension;
				$uploadPath = BASEURL.'images/products/'.$uploadName;
				$dbPath = '/ecom/images/products/'.$uploadName;



				if(!in_array($fileExtension,$allowedExtensions)){
					$errors[] = 'The file extension must be jpg, jpeg, png or gif';
				}

				if($fileSize > 5000000){
					$errors[] = 'The file size must be equal to or lower than 5MB.';
				}

				// if the type od the file is not an image then throw an error:
				if($mimeType != 'image'){
					$errors[] = 'The file must be an image.';
				}


			}
			// if errors array is not an empty then echo out the function to display errors which i have created inside helpers.php file:
			if(!empty($errors)){
				echo displayErrors($errors);
			}
			else
			{
				if(!empty($_FILES)){
				//Upload file and insert to the database
				move_uploaded_file($tmpLocation, $uploadPath);
			}
				// This query Will execute when user will add the new product :
				$insertSQL = "INSERT INTO products (title,price,list_price,brand,categories,sizes,image,description) VALUES ('$title','$price','$list_price','$brand','$categories','$sizes','$dbPath','$description')";
				// Verifying that edit key must be set:
				if(isset($_GET['edit'])){
					// This query will run when user will edit the product:
					// Then Update the products table based on the user input on the form:
					$insertSQL = "UPDATE products SET title='$title',price='$price',list_price='$list_price',brand='$brand',categories='$categories',sizes='$sizes',image='$dbPath',description='$description' WHERE id='$edit_id'";
				}

				$db->query($insertSQL);
				header('Location:products.php');

			}
		}

		?>
		
		<h2 class="text-center"><?= ((isset($_GET['edit']))?'Edit ':'Add A New '); ?>Product</h2>
		<form action="products.php?<?= ((isset($_GET['edit']))?'edit='.$edit_id:'add=1'); ?>" method="POST" enctype="multipart/form-data">
			<div class="form-group col-md-3">
				<label for="title">Title*:</label>
				<input type="text" name="title" class="form-control" id="title" 
				value="<?= $title; ?>" 
				>

			</div>

			<div class="form-group col-md-3">
				<label for="brand">Brand*:</label>
				<select name="brand" id="brand" class="form-control">
					<option value=""<?= (( $brand == '')? ' selected': '' ); ?>></option>
					<?php while($b = mysqli_fetch_assoc($brandQuery)): ?>
					
					<option value="<?= $b['id']; ?>"
					<?= (($brand == $b['id']) ? ' selected': '' ); ?> >
					<?= $b['brand']; ?></option>

					<?php endwhile; ?>

				</select>

			</div>

			<div class="form-group col-md-3">
				<label for="parent">Parent Category*:</label>
				<select name="parent" id="parent" class="form-control">
					
					<option value=""<?= (($parent == '')?' selected':''); ?>></option>
					<?php while($p = mysqli_fetch_assoc($parentCategoryQuery)): ?>
					
					<option value="<?= $p['id']; ?>"
					<?= (($parent == $p['id'])?' selected': ''); ?>
					><?= $p['category']; ?></option>
					<?php endwhile; ?>

				</select>

			</div>

			<div class="form-group col-md-3">
				<label for="child">Child Category*:</label>
			<select name="child" id="child" class="form-control"></select>
			</div>

			<div class="form-group col-md-3">
				<label for="price">Price*:</label>
				<input type="text" name="price" id="price" class="form-control" 
				value="<?= $price; ?>">
			</div>

			<div class="form-group col-md-3">
				<label for="list_price">List Price:</label>
				<input type="text" name="list_price" id="list_price" class="form-control" 
				value="<?= $list_price; ?>">
			</div>

			<div class="form-group col-md-3">
				<label>Quantity & Sizes*:</label>
				<button class="btn btn-default form-control" 
				onclick="jQuery('#sizesModal').modal('toggle');return false;">Quantity & Sizes</button>
			</div>

			<div class="form-group col-md-3">
				<label for="sizes">Sizes & Quantity Preview</label>
				<input type="text" name="sizes" class="form-control" id="sizes"
				value="<?= $sizes; ?>" readonly>
			</div>
			
			<div class="form-group col-md-6">
				<?php if($savedImage != ''): ?>
					<div class="saved-image"><img src="<?= $savedImage; ?>" alt="Saved Image">
					<br>
					<a href="products.php?delete_image=1&edit=<?= $edit_id; ?>" class="text-danger">Delete Image</a>

					</div>
				<?php else: ?>
				<label for="photo">Product Image:</label>
				<input type="file" name="photo" id="photo" class="form-control">
				<?php endif; ?>
			</div>

			<div class="form-group col-md-6">
				<label for="description">Description:</label>
				<textarea name="description" id="description" class="form-control" cols="30" rows="6"><?= $description; ?></textarea>
			</div>
			<div class="form-group pull-right">
			<a href="products.php" class="btn btn-default">Cancel</a>
			<input type="submit" value="<?= ((isset($_GET['edit']))?'Edit ':'Add '); ?>Product" class="btn btn-success pull-right">
			</div>
			<div class="clearfix"></div>
			
		</form>

		<!-- Modal -->
<div class="modal fade" id="sizesModal" tabindex="-1" role="dialog" aria-labelledby="sizesModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="sizesModalLabel">Size & Quantity</h4>
      </div>
      <div class="modal-body">
        	<div class="container-fluid">
			<?php for($i=1;$i<=12;$i++): ?>
			
			<div class="form-group col-md-4">
				<label for="size<?= $i; ?>">Size:</label>
				<input type="text" class="form-control" name="size<?= $i; ?>" id="size<?= $i; ?>" value="<?= ((!empty($sizeArray[$i-1]))?$sizeArray[$i-1]:'') ?>">

			</div>

			<div class="form-group col-md-2">
				<label for="qty<?= $i; ?>">Quantity:</label>
				<input type="number" min="0" class="form-control" name="qty<?= $i; ?>" id="qty<?= $i; ?>" value="<?= ((!empty($qtyArray[$i-1]))?$qtyArray[$i-1]:'') ?>">

			</div>

			<?php endfor; ?>
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" 
        onclick="updateSizes(); jQuery('#sizesModal').modal('toggle');return false;">Save changes</button>
      </div>
    </div>
  </div>
</div>


		<?php  		
	
	}
	else
	{




	$sql = "SELECT * FROM products WHERE deleted = 0";
	$presult = $db->query($sql); 

	// This Condition is for the Featured Button:
	if(isset($_GET['featured']))
	{
		$id = (int)$_GET['id'];
		$featured = (int)$_GET['featured'];
		// Update the products table by setting featured column to the value 0 if the value is 1 or to the value 1 if the value is 0 where id is equal to the id belonging to the clicked product in the table:
		$featuredSql = "UPDATE products SET featured = '$featured' WHERE id = '$id'";
		$db->query($featuredSql);
		header('Location:products.php');
	}
 ?>

	<h2 class="text-center">Products</h2> 

	<a href="products.php?add=1" class="btn btn-success pull-right" id="add-product">Add Product</a> <div class="clearfix"></div>
	<hr>
	<table class="table table-bordered table-condensed table-striped">
		<thead><th></th><th>Product</th><th>Price</th><th>Category</th><th>Featured</th><th>Sold</th></thead>
	

	<tbody>
		<?php while($product = mysqli_fetch_assoc($presult)):
		// Selecting all the rows from categories table where id is related to child id 
		$childId = $product['categories'];
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
				<a href="products.php?edit=<?= $product['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
				<a href="products.php?delete=<?= $product['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove"></span></a>
			</td>
			<td><?= $product['title']; ?></td>
			<td>$<?= $product['price']; ?></td>
			<td><?= $category; ?></td>
			<td>
			<!-- Logic to toggle value of featured when user clicked the button of featured column in the table if the value of featured is 1 then toggle it to 0 or if the value is 0 then toggle it to 1 on the click of user -->
			<a href="products.php?featured=<?= (($product['featured'] == 0)?'1':'0'); ?>&id=<?= $product['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-<?= (($product['featured'] == 1)?'minus':'plus'); ?>"></span></a>
			&nbsp; <?= (($product['featured'] == 1)?'Featured Product':''); ?>
			</td>
			<td></td>
		</tr>

		<?php endwhile; ?>
	</tbody>

</table>
 <?php 
}
 	include 'includes/footer.php';

  ?>

<script>
  	jQuery('document').ready(function(){

  		get_child_options('<?= $categories; ?>');
  	});

  </script>
  