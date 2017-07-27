   <?php 
    require_once '../core/init.php';
    $id = $_POST['id'];
    $id = (int)$id;
    $sql = "SELECT * FROM products WHERE id = '$id'";
    $result = $db->query($sql);
    $product = mysqli_fetch_assoc($result);
    $brand_id = $product['brand'];
    $sql = "SELECT brand FROM brand WHERE id = '$brand_id'";
    $brandQueryResult = $db->query($sql);
    $brand = mysqli_fetch_assoc($brandQueryResult);
    $productSizeString = $product['sizes'];
    $productSizeStringArray = explode(',', $productSizeString); 
    ?>



    <!-- Details Modal -->
    <!-- Starting the buffer to read entire code -->
<?php ob_start(); ?>
        <div class="modal fade details-1" id="details-modal" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true">
          
          <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button class="close" type="button" onclick="closeModal();">
                <span aria-hidden="true">&times;</span>

              </button>
              <h4 class="modal-title text-center"><?= $product['title']; ?></h4>
            </div>

            <div class="modal-body">
              
              <div class="container-fluid">
                
                <div class="row">
                <span id="modal_errors" class="bg-danger"></span>
                  <div class="col-sm-6">
                  
                    <div class="center-block">
                      
                      <img src="<?= $product['image']; ?>" alt="<?= $product['title']; ?>" class="details img-responsive">

                    
                    </div>
                    
                  

                  </div>
                  <div class="col-sm-6">
                    <h4>Details</h4>
                    <p><?= $product['description']; ?></p>
                    <hr>
                    <p>Price: $<?= $product['price']; ?></p>
                    <p>Brand: <?= $brand['brand']; ?></p>
                    <form action="add_cart.php" method="post" id="add_product_form">
                    <input type="hidden" name="product_id" value="<?= $id; ?>">
                    <input type="hidden" name="available" id="available" value="">
                      <div class="form-group">
                       
                          <!-- <label for="quantity">Quantity:</label>
                          <input type="number" class="form-control" id="quantity" name="quantity" min="0"> -->
                          <label for="size">Size:</label>
                        <select name="size" id="size" class="form-control">
                         
                       <option value=""></option>
                          <?php foreach ($productSizeStringArray as $sizeString) {
                            # code...
                            $productSizeStringArray = explode(':', $sizeString);
                            $productSize = $productSizeStringArray[0];
                            $available = $productSizeStringArray[1];
                            if($available > 0){
                            echo '<option value="'.$productSize.'" data-available="'.$available.'">'.$productSize.'('.$available.' Available)</option>';
                          }
                          } ?>
                          
                         
                        </select>

                        
                      
                      </div>
                      <br>
                      
                      <div class="form-group">
                        <div class="col-sm-3">
                         <label for="quantity">Quantity:</label>
                          <input type="number" class="form-control" id="quantity" name="quantity" min="0">
                        </div>
                      </div>
                    </form>
                  </div>

                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-default" onclick="closeModal();">Close</button>
              <button class="btn btn-warning" onclick="addToCart(); return false;"><span class="glyphicon glyphicon-shopping-cart"></span>Add To Cart</button>
            </div>
            </div>
          </div>
      
      <!-- This Function Will Close Details Modal -->
      <script type="text/javascript">
      // Selecting the size id from the details modal and attaching a change event with it to execute a function when change occurs:
      jQuery('#size').change(function(){
        // Storing and setting variable available to the option selected by the user in the size selection box and then passing the data the value of the availabe variable:
        var available = jQuery('#size option:selected').data("available");
        // Then selecting the id available and setting its value to the var available:
        jQuery('#available').val(available);
      });
        
        function closeModal(){
    jQuery('#details-modal').modal('hide');
    // This function is setting the timeout for the details modal which means details modal code will be removed after 500 millisecond:
    setTimeout(function(){
      jQuery('#details-modal').remove();
      jQuery('.modal-backdrop').remove();
     },500);
  }

  // This function will be executed when user clicks on the Add To Cart button:
  function addToCart(){
    // Selecting the html entity with the id of modal_errors and setting to an empty string:
   jQuery('#modal_errors').html("");
   // Storing size from the value of input in the details modal where id is size:
   var size = jQuery('#size').val();
   // Storing quantity from the value of select box in the details modal where id is quantity:
   var quantity = jQuery('#quantity').val();
   // Storing available from the value of input hidden field where id is available:
   var available = jQuery('#available').val();
   // Setting error variable to an empty string:
   var error = '';
   // Storing the data of the form which contains id of add_product_form after serializing it
   // using serialize funtion of php:
   var data = jQuery('#add_product_form').serialize();
   // Verifying if size or quantity are equal to an empty string or quantity is equal to zero then:
   if(size == '' || quantity == '' || quantity == 0 ){
    // Update the error variable with an error message of html :
    error += '<p class="text-danger text-center">You must choose Size and Quantity.</p> ';
    // Selecting the id of modal_errors and setting its html to the error variable:
    jQuery('#modal_errors').html(error);
    // Break out from this function:
    return;
   }
   // Else if quantity is greater than available stock:
   else if(quantity > available){
    // Update error variable with error message:
    error += '<p class="text-danger text-center">There are only '+available+' available.</p>';
    // Display error message on the form:
    jQuery('#modal_errors').html(error);
   }
   // Else if everything above return false then:
   else{
    // Execute an ajax request:
    jQuery.ajax({
      // the url of the file which is to be send:
      url: '/ecom/admin/parsers/add_cart.php',
      // the method will be post:
      method : 'post',
      // data will be data:
      data : data,
      // On success execute a function:
      success: function(){
        // Just reload the page in order to gets Cookies working properly:
        location.reload();
      },
      // On error of ajax request execute this function:
      error: function(){alert("Something went wrong!");}

    });
   }

  }


      </script>

        </div>
      <!-- Cleaning the buffer -->  
<?= ob_get_clean(); ?>