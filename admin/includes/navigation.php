<nav class="navbar navbar-default navbar-fixed-top">
            
            <div class="container">
                
                <a href="/ecom/admin/index.php" class="navbar-brand">Boutique Admin</a>
                <ul class="nav navbar-nav">
                  
                  <li><a href="brands.php">Brands</a></li>

                  <li><a href="categories.php">Categories</a></li>  

                  <li><a href="products.php">Products</a></li>  

                   <li><a href="archived.php">Archived</a></li>  
                  
                  <?php if(hasPermissions('admin')): ?>
                    <li><a href="users.php">Users</a></li>  
                  <?php endif; ?>

                  <li class="dropdown">
                    
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    Hello <?= $firstName; ?>! <span class="caret"></span>
                    <ul class="dropdown-menu" role="menu">
                      <li><a href="change_password.php">Change Password</a></li>
                      <li><a href="logout.php">Log Out</a></li>
                    </ul>
                  </a>

                  </li>
                 <!--    <li class="dropdown">
                       
                       <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      
  
                       <span class="caret"></span></a>
                       
                       <ul class="dropdown-menu" role="menu">
                          
                           
                       </ul>
                        
                        
                    </li> -->
                   


                </ul>
                
            </div>
            
        </nav>