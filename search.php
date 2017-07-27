<?php 
require_once "core/init.php";
include "includes/head.php"; 
include "includes/navigation.php";       
include "includes/headerpartial.php";
include "includes/leftsidebar.php";


$sql = "SELECT * FROM products";
$categoryId = (($_POST['cat']!= '')?sanitize($_POST['cat']):'');
if($categoryId == ''){
  $sql .= ' WHERE deleted = 0';
}
else{
  $sql .= " WHERE categories = '{$categoryId}' AND deleted = 0 ";
}
$price_sort = (($_POST['price_sort'] != '')?sanitize($_POST['price_sort']):''); 

$min_price = (($_POST['min_price'] != '')?sanitize($_POST['min_price']):''); 

$max_price = (($_POST['max_price'] != '')?sanitize($_POST['max_price']):''); 

$brand = (($_POST['brand'] != '')?sanitize($_POST['brand']):''); 

if($min_price != ''){
  $sql .= " AND price >= '{$min_price}'";
}

if($max_price != ''){
  $sql .= " AND price <=  '{$max_price}'";
}

if($brand != ''){
  $sql .= " AND brand = '{$brand}'";
}

if($price_sort == 'low'){
  $sql .= " ORDER BY price";
}

if($price_sort == 'high'){
  $sql .= " ORDER BY price DESC";
}

$productsByCategory = $db->query($sql);
$category = getCategory($categoryId); 
?>
        
        
        <!-- Header -->
        
     
          
      

        <div class="col-md-8">
          
          <div class="row">

          <?php if($categoryId != ''): ?>
            
            <h2 class="text-center"><?= $category['ParentCategory'].' > '. $category['childCategory']; ?></h2>

          <?php else: ?>

          <h2 class="text-center">Boutique</h2>

          <?php endif; ?>
            <!-- Making an associative array of Featured Products to display
                on homepage -->
            
            <?php while($featured_products = mysqli_fetch_assoc($productsByCategory)) : ?>

              

            <div class="col-md-3">

             <!-- Title of the product is displaying dynamically : --> 
              <h3 class="text-center"><?= $featured_products['title']; ?></h4>
              <!-- Image of the product is displaying dynamically : -->
              <img src="<?= $featured_products['image']; ?>" id="img-prod" alt="<?= $featured_products['title']; ?>" />
              <!-- List price is displaying dynamically : -->
              <p class="text-danger list-price">List Price: <s>$<?= $featured_products['list_price']; ?></s></p>
              <!-- Price of the products is displaying dynamically : -->
              <p class="price">Our Price: $<?= $featured_products['price']; ?></p>

              <button type="button" class="btn btn-sm btn-success" onclick="detailsModal(<?= $featured_products['id']; ?>)">Details</button>

            </div>
            
            <!-- Wrapping down while loop to display all featured products -->
           
            <?php endwhile; ?>
           


          </div>



        </div>

    <?php 
    
    include "includes/rightsidebar.php";
    include "includes/footer.php";

    ?>





