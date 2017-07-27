<?php 
require_once "core/init.php";
include "includes/head.php"; 
include "includes/navigation.php";       
include "includes/headerpartial.php";
include "includes/leftsidebar.php";

  if(isset($_GET['cat'])){
    $categoryId = sanitize($_GET['cat']);
  }
  else{
    $categoryId = '';
  }


/*This query will select all rows from products table where value of the featured column is 
equal to 1 */
$sql = "SELECT * FROM products WHERE categories='$categoryId' AND deleted = 0";
$productsByCategory = $db->query($sql);
$category = getCategory($categoryId); 
?>
        
        
        <!-- Header -->
        
     
          
      

        <div class="col-md-8">
          
          <div class="row">
            
            <h2 class="text-center"><?= $category['ParentCategory'].' > '. $category['childCategory']; ?></h2>

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





