<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/ecom/core/init.php';
  $mode = sanitize($_POST['mode']);
  $editSize = sanitize($_POST['editSize']);
  $editId = sanitize($_POST['editId']);
  $cartQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
  $result = mysqli_fetch_assoc($cartQ);
  $items = json_decode($result['items'],true);var_dump($result);
  $updated_items = array();
  $domain = (($_SERVER['HTTP_HOST'] != 'localhost')?'.'.$_SERVER['HTTP_HOST']:false);

  if($mode == 'deleteOne'){
    foreach($items as $item){
      if($item['id'] == $editId && $item['size'] == $editSize){
        $item['quantity'] = $item['quantity'] - 1;
      }
      if($item['quantity'] > 0){
        $updated_items[] = $item;
      }
    }
  }

  if($mode == 'addOne'){
    foreach($items as $item){
      if($item['id'] == $editId && $item['size'] == $editSize){
        $item['quantity'] = $item['quantity'] + 1;
      }
      $updated_items[] = $item;
    }
  }

  if(!empty($updated_items)){
    $json_updated = json_encode($updated_items);
    $db->query("UPDATE cart SET items = '{$json_updated}' WHERE id = '{$cart_id}'");
    $_SESSION['success_flash'] = 'Your shopping cart has been updated!';
  }

  if(empty($updated_items)){
    $db->query("DELETE FROM cart WHERE id = '{$cart_id}'");
    setcookie(CART_COOKIE,'',1,"/",$domain,false);
  }
 ?>
