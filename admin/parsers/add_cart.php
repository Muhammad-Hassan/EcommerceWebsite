<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/ecom/core/init.php';
// Storing product id from the details modal form:
$product_id = sanitize($_POST['product_id']);
// Storing size of the product from details modal form:
$size = sanitize($_POST['size']);
// Storing available product from details modal form:
$available = sanitize($_POST['available']);
// Storing quantity of product from details modal form:
$quantity = sanitize($_POST['quantity']);
// Making an array which contains data of the product:
$item = array();
// Defining array item 
$item[] = array(
	// First column contains the product id:
	'id' => $product_id,
	// Second contains size:
	'size' => $size,
	// Third contains quantity:
	'quantity' => $quantity,


	);

// Defining a variable to hold domain if server http host is not equal to the localhost then return the server http host else return false:
$domain = ($_SERVER['HTTP_HOST'] != 'localhost')?'.'.$_SERVER['HTTP_HOST']:false;
// Select all from products where id match with the product_id from details modal form:
$query = $db->query("SELECT * FROM products WHERE id = '{$product_id}'");
// Making an associative array:
$product = mysqli_fetch_assoc($query);
// Updating session variable to display message:
$_SESSION['success_flash'] = $product['title'].' added to your cart.';

//Check to see if the cart cookie exist:

if($cart_id != ''){
	// Defining a sql query to select all from cart table where id match with cart id:
	$cartQuery = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
	// Making an associative array for cart:
	$cart = mysqli_fetch_assoc($cartQuery);
	// By using json_decode funtion we are decoding string from the database cart table which is in the format of json string so json_decode will going to convert it into a PHP variable and then we are defining true as a second parameter which will convert it into an object so then we can use it as an associative array:
	$previousItemsInCart = json_decode($cart['items'],true);
	// Making a variable to hold a number 0 when itmes not match:
	$items_match = 0;
	// Making an array to store new Items in Cart:
	$newItems = array();
	// Executing foreach loop for the previous items in cart:
	foreach ($previousItemsInCart as $pItems) {
		// Verifying if the id and size of the current item matches with the id and size of the previous item in cart then: 
		if($item[0]['id'] == $pItems['id'] && $item[0]['size'] == $pItems['size']){
			// Update the quantity of the previous item store in cart:
			$pItems['quantity'] = $pItems['quantity'] + $item[0]['quantity'];
			// Verifying if previous item in cart exceed total available amount of quantity then:
			if($pItems['quantity']>$available){
				// Update previous item quantity in cart to the maximum available quantity:
				$pItems['quantity'] = $available;
			}
			// Change the items_match var value to 1 which indicates that items does matches in cart:
			$items_match = 1;
		}
		// Assigning newItems array to the previous items array:
		$newItems[] = $pItems;
	}
	// if items does not match with the previous items in cart then:
	if($items_match != 1){
		// Merge both arrays together by using array_merge function of PHP:
		$newItems = array_merge($item,$previousItemsInCart);

	}
	// Encode the newItems array as json format then store that data to the var items_json:
	$items_json = json_encode($newItems);
	// Defining the var to hold expiry date of cart:
	$cart_expire = date("Y-m-d H:i:s",strtotime("+30 days"));
	// Executing the Update query to update cart table in databae:
	$db->query("UPDATE cart SET items = '{$items_json}', expire_date = '{$cart_expire}' WHERE 
		id = '{$cart_id}'");
	
	setcookie(CART_COOKIE,'',1,"/",$domain,false);
	setcookie(CART_COOKIE,$cart_id,CART_COOKIE_EXPIRE,'/',$domain,false);
}


else{
	// add the cart to the database and set cookie:
	$items_json = json_encode($item);
	$cart_expire = date("Y-m-d H:i:s",strtotime("+30 days"));
	$db->query("INSERT INTO cart (items,expire_date) VALUES ('{$items_json}','{$cart_expire}')");
	$cart_id = $db->insert_id;
	setcookie(CART_COOKIE,$cart_id,CART_COOKIE_EXPIRE,'/',$domain,false);
}

 ?>