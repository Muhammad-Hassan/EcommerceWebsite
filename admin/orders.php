<?php

	require_once '../core/init.php';

	if(!isLoggedIn()){
		header('Location:login.php');
	}
	include '/includes/head.php';
	include '/includes/navigation.php';

	// Completing Order:

	if(isset($_GET['complete']) && $_GET['complete'] == 1){
		$cartId = sanitize($_GET['cart_id']);
		$db->query("UPDATE cart SET shipped = 1 WHERE id = '{$cartId}'");
		$_SESSION['success_flash'] = "The order has been completed.";
		header('Location:index.php');
	}

	$transactionId = sanitize((int)$_GET['txn_id']);

	$txnQuery = $db->query("SELECT * FROM transactions WHERE id = '{$transactionId}'");
	$txn = mysqli_fetch_assoc($txnQuery);
	$cart_id = $txn['cart_id'];
	$cartQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
	$cart = mysqli_fetch_assoc($cartQ);

	$items = json_decode($cart['items'],true);

	$idArray = array();
	$products = array();

	foreach($items as $i){
		$idArray[] = $i['id'];
	}





	$ids = implode(',',$idArray);

	$productQ = $db->query("SELECT i.id as 'id', i.title as 'title', c.id as 'cid', c.category as 'child', p.category as 'parent' FROM products i
		LEFT JOIN categories c ON i.categories = c.id
		LEFT JOIN categories p ON c.parent = p.id
		WHERE i.id IN ({$ids})");


	while($p = mysqli_fetch_assoc($productQ)){
		foreach($items as $item){
			if($item['id'] == $p['id']){
				$x = $item;
				continue;
			}
		}
		$products[] = array_merge($x,$p);
	}
 ?>

<h2 class="text-center">Items Ordered</h2>

<table class="table table-condensed table-striped table-bordered">
	<thead>
		<th>Quantity</th>
		<th>Title</th>
		<th>Category</th>
		<th>Size</th>
	</thead>
	<tbody>
		<?php foreach($products as $product): ?>
		<tr>
			<td><?= $product['quantity']; ?></td>
			<td><?= $product['title']; ?></td>
			<td><?= $product['parent'].' ~ '.$product['child']; ?></td>
			<td><?= $product['size']; ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>


	<div class="row">
		<div class="col-md-6">
			<h3 class="text-center">Order Details</h3>
		<table class="table table-condensed table-striped table-bordered">
			<tbody>
				<tr>
					<td>Sub Total</td>
					<td><?= money($txn['subTotal']); ?></td>
				</tr>
				<tr>
					<td>Tax</td>
					<td><?= money($txn['tax']); ?></td>
				</tr>
				<tr>
					<td>Grand Total</td>
					<td><?= money($txn['grandTotal']); ?></td>
				</tr>
				<tr>
					<td>Order Date</td>
					<td><?= dateFormat($txn['txn_date']); ?></td>
				</tr>
			</tbody>
		</table>
		</div>
		<div class="col-md-6">
			<h3 class="text-center">Shipping Address</h3>
			<address>
				<?= $txn['full_name']; ?><br>
				<?= $txn['street']; ?><br>
				<?= $txn['contact']; ?><br>
				<?= $txn['city']; ?><br>
				<?= $txn['country']; ?><br>
			</address>
		</div>
	</div>


	<div class="pull-right">
		<a href="index.php" class="btn btn-lg btn-default">Cancel</a>
		<a href="orders.php?complete=1&cart_id=<?= $cart_id;?>" class="btn btn-primary btn-lg">
			Complete Order
		</a>
	</div>

 <?php include '/includes/footer.php'; ?>
