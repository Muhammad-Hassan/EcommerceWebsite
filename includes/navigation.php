 

<?php 

$sql = "SELECT * from categories where parent=0";
$resultOfQuery = $db->query($sql);


 ?>






  <nav class="navbar navbar-default navbar-fixed-top">
            
            <div class="container">
                
                <a href="index.php" class="navbar-brand">Boutique</a>
                <ul class="nav navbar-nav">
                    <?php while($parent = mysqli_fetch_assoc($resultOfQuery)) : ?>
                    <?php $parent_id = $parent['id']; 
                          $sql2 = "SELECT * from categories where parent = $parent_id";
                          $resultOfSecondQuery = $db->query($sql2);


                    ?>

                    <li class="dropdown">
                       
                       <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php echo $parent['category']; ?>
  
                       <span class="caret"></span></a>
                       
                       <ul class="dropdown-menu" role="menu">
                           <?php while($child = mysqli_fetch_assoc($resultOfSecondQuery)) : ?>
                           <li><a href="category.php?cat=<?= $child['id']; ?>"><?php echo $child['category']; ?></a></li>
                           <?php endwhile; ?>
                           
                       </ul>
                        
                        
                    </li>
                    <?php endwhile; ?>

                    <li><a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span>My Cart</a></li>


                </ul>
                
            </div>
            
        </nav>