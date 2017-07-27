<?php
require_once 'core/init.php';

// Set your secret key
//see your keys here https://dashboard.stripe.com/account/apikeys

\Stripe\Stripe::setApiKey(STRIPE_PRIVATE);
//Get all of the credit card details submitted by the user
$token = $_POST['stripeToken'];
//Get the rest of the information or post data
$full_name = sanitize($_POST['full_name']);
$email = sanitize($_POST['email']);
$street = sanitize($_POST['street']);

$city = sanitize($_POST['city']);
$contact = sanitize($_POST['contact']);
$zipCode = sanitize($_POST['zipCode']);
$country = sanitize($_POST['country']);
$tax = sanitize($_POST['tax']);
$subTotal = sanitize($_POST['subTotal']);
$grandTotal = sanitize($_POST['grandTotal']);
$cart_id = sanitize($_POST['cart_id']);
$description = sanitize($_POST['description']);
$charge_amount = number_format($grandTotal,2) * 100;
$metadata = array(
  "cart_id" => $cart_id,
  "tax" => $tax,
  "subTotal" => $subTotal,

);

//Create the stripe charge on Stripe Servers - this is going to charge the user credit card
try {
$charge = \Stripe\Charge::create(array(
  "amount" => $charge_amount,
  "currency" => CURRENCY,
  "source" => $token,
  "description" => $description,
  "receipt_email" => $email,
  "metadata" => $metadata)
);

// Adjust Inventory After User Checkout:

// Selecting all rows from cart table where id matches with the cart id:
$itemQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
$itemResults = mysqli_fetch_assoc($itemQ);
// Decoding json format data from database inside column items of cart table and making it an associative array by declaring true as a second parameter for predefined function:
$items = json_decode($itemResults['items'],true);

// Iterate over each item present in associative array:
foreach ($items as $item) {

  // Making an array to hold new sizes:
  $newSizes = array();
  // Storing the relevant item id :
  $item_id = $item['id'];
  // Selecting all the products from products table where id matches with the item id through which loop is currently iterating:
  $productQ = $db->query("SELECT sizes FROM products WHERE id = '{$item_id}'");
  // Making an associative array :
  $product = mysqli_fetch_assoc($productQ);
  // Making a variable to store sizes in a form of array after calling a helper function:
  $sizes = sizesToArray($product['sizes']);
  // Iterating another foreach nested loop for sizes :
  foreach ($sizes as $size) {
    // Verifying if total size matches with the item size:
    if($size['size'] == $item['size']){
      // Decrease quantity of that item:
      $q = $size['quantity'] - $item['quantity'];
      // Update newSizes array to hold size and quantity update data:
      $newSizes[] = array('size' => $size['size'],'quantity' => $q);

    }
    else{

      $newSizes[] = array('size' => $size['size'],'quantity' => $size['quantity']);
    }
  }
  // Calling a function to convert newSizes array into relevant string for storing inside database:
  $sizeString = sizesToString($newSizes);
  $db->query("UPDATE products SET sizes = '{$sizeString}' WHERE id = '{$item_id}'");
}


//update cart
$db->query("UPDATE cart SET paid = 1 WHERE id = '{$cart_id}'");
$db->query("INSERT INTO transactions (charge_id,cart_id,full_name,email,street,city,zipCode,country,contact,subTotal,tax,grandTotal,description,txn_type) VALUES ('$charge->id','$cart_id','$full_name','$email','$street','$city','$zipCode','$country','$contact','$subTotal','$tax','$grandTotal','$description','$charge->object')");

$domain = ($_SERVER['HTTP_HOST'] != 'localhost')? '.'.$_SERVER['HTTP_HOST']:false;
setcookie(CART_COOKIE,'',1,"/",$domain,false);
include 'includes/head.php';
include 'includes/navigation.php';
include 'includes/headerpartial.php';

 ?>
 <h1 class="text-center text-success">Thank You!</h1>
 <p> Your card has been sucessfully charged <?=money($grandTotal);?>. You have been emailed a receipt. Please
   check your spam folder if it is not in your inbox. Additionally you can also print this page </p>
   <p>
     Your receipt number is: <strong><?=$cart_id;?></strong></p>
    <p>Your order wil be shipped to the address below.</p>
    <address>
      <?=$full_name;?><br />
      <?=$street;?><br />
      <?=$city. ','.$zipCode;?><br />
      <?=$country;?><br />

    </address>
<?php
include 'includes/footer.php';
} catch(\Stripe\Error\Card $e) {
  //The card has been declined
  echo $e;
}

 ?>
