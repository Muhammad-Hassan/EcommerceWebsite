<?php

require_once '../core/init.php';
include '/includes/head.php';
include '/includes/navigation.php';

	if(!isLoggedIn()){
		loginErrorRedirect();
	}

 ?>

<!-- Orders To Fill -->

<?php

	$transactionQ = "SELECT t.id, t.cart_id, t.full_name, t.description,t.txn_date, t.grandTotal, c.items, c.paid, c.shipped FROM transactions t LEFT JOIN cart c ON t.cart_id = c.id WHERE c.paid = 1 AND c.shipped = 0 ORDER BY t.txn_date";
	$txnResults = $db->query($transactionQ);


 ?>

<div class="col-md-12">
	<h3 class="text-center">Orders To Ship</h3>
	<table class="table table-condensed table-bordered table-striped">
		<thead>
			<th></th>
			<th>Name</th>
			<th>Description</th>
			<th>Total</th>
			<th>Date</th>
		</thead>
		<tbody>
		<?php while($order = mysqli_fetch_assoc($txnResults)): ?>
			<tr>
				<td><a href="orders.php?txn_id=<?= $order['id']; ?>" class="btn btn-xs btn-info">Details</a></td>
				<td><?= $order['full_name']; ?></td>
				<td><?= $order['description']; ?></td>
				<td><?= money($order['grandTotal']); ?></td>
				<td><?= dateFormat($order['txn_date']); ?></td>
			</tr>
		<?php endwhile; ?>
		</tbody>
	</table>
</div>


<div class="row">
	<!-- Sales By Month -->
	<?php

		$thisYear = date("Y");
		$lastYear = $thisYear - 1;

		$thisYearQuery = $db->query("SELECT grandTotal,txn_date FROM transactions WHERE YEAR(txn_date) = '{$thisYear}'");
		$lastYearQuery = $db->query("SELECT grandTotal,txn_date FROM transactions WHERE YEAR(txn_date) = '{$lastYear}'");
		$last = array();
		$current = array();
		$currentTotal = 0;
		$lastTotal = 0;
		while($x = mysqli_fetch_assoc($thisYearQuery)){
			$month = date("m",strtotime($x['txn_date']));
			if(!array_key_exists($month,$current)){
				$current[(int)$month] = $x['grandTotal'];
			}
			else{
				$current[(int)$month] += $x['grandTotal'];
 			}
 			$currentTotal += $x['grandTotal'];
		}

		while($y = mysqli_fetch_assoc($lastYearQuery)){
			$month = date("m",strtotime($y['txn_date']));
			if(!array_key_exists($month,$last)){
				$last[(int)$month] = $y['grandTotal'];
			}
			else{
				$last[(int)$month] += $y['grandTotal'];
 			}
 			$lastTotal += $y['grandTotal'];
		}


	 ?>

	<div class="col-md-4">
		<h3 class="text-center">Sales By Month</h3>
		<table class="table table-condensed table-striped table-bordered">
			<thead>
				<th></th>
				<th><?= $lastYear; ?></th>
				<th><?= $thisYear; ?></th>
			</thead>
			<tbody>
			<?php for($i = 1; $i <= 12; $i++):
			$dt = DateTime::createFromFormat('!m',$i);
			?>
				<tr<?= ((date("m") == $i)?' class="info"':''); ?>>
					<td><?= $dt->format("F"); ?></td>
					<td><?= ((array_key_exists($i, $last))?money($last[$i]):'0'); ?></td>
					<td><?= ((array_key_exists($i, $current))?money($current[$i]):'0'); ?></td>
				</tr>
			<?php endfor; ?>

			<tr>
				<td>Total</td>
				<td><?= money($lastTotal); ?></td>
				<td><?= money($currentTotal); ?></td>
			</tr>
			</tbody>
		</table>
	</div>
	<!-- Inventory -->
	<div class="col-md-8"></div>
</div>

 <?php
 include '/includes/footer.php';

 //session_destroy();

  ?>
