<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/ecom/core/init.php';
  $name = sanitize($_POST['full_name']);
  $email = sanitize($_POST['email']);
  $street = sanitize($_POST['street']);
  $city = sanitize($_POST['city']);
  $zipCode = sanitize($_POST['zipCode']);
  $country = sanitize($_POST['country']);
  $errors = array();
  $required = array(
    'full_name' => 'Full Name',
    'email'     => 'Email',
    'street'    => 'Street Address',
    'city'      => 'City',
    'zipCode'  => 'Zip Code',
    'country'   => 'Country',
  );

  //check if all required fields are filled out
  foreach($required as $f => $d){
    if(empty($_POST[$f]) || $_POST[$f] == ''){
      $errors[] = $d.' is required.';
    }
  }

//check if valid email Address
if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
  $errors[] = 'Please enter a valid email.';
}

  if(!empty($errors)){
    echo displayErrors($errors);
  }else{
    echo true;
  }
 ?>
