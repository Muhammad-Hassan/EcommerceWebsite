<h3 class="text-center">Popular Items</h3>

<?php 

	$transactionQ = $db->query("SELECT * FROM cart WHERE paid = 1 ORDER BY id DESC LIMIT 5 ");
	$results = array();

	while($row = mysqli_fetch_assoc($transactionQ)){
		$results[] = $row;
	}
	$rowCount = $transactionQ->num_rows;
	$usedIds = array();
	for($i=0;$i<$rowCount;$i++){
		$jsonitems = $results[$i]['items'];
		$items = json_decode($jsonitems,true);

		foreach($items as $item){
			if(!in_array($item['id'],$usedIds)){
				$usedIds[] = $item['id'];
			}
		}
	}


 ?>

 <div id="recent_widget">
 	<table class="table table-condensed">
 		<?php foreach($usedIds as $id):

 			$productQ = $db->query("SELECT id,title FROM products WHERE id = '{$id}'");
 			$product = mysqli_fetch_assoc($productQ);

 		 ?>
				
			<tr>
				<td>
					<?= substr($product['title'],0,15); ?>
				</td>
				<td>
					<a class="text-primary" onclick="detailsModal('<?= $id; ?>');">View</a>
				</td>
			</tr>



		<?php endforeach; ?>
 	</table>

 </div>

