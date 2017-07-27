
        </div>
         <footer class="text-center" id="footer">&copy; Copyright 2016</footer>

    


        <script>
        
            $(window).scroll(function(){
               
                // Holding the vertical position of scroll bar in the variable vscroll
                var vscroll = $(this).scrollTop();
                
                
                // assigning the property of css to the id of logo-text
                $('#logo-text').css({
                    /* transforming the position of the content present under the id logo-text 
                     0 px for the horizantal axis and dividing the vertical scroll position with 2 for
                     the vertical axis*/
                   "transform" : "translate(0px, "+vscroll/2+"px)"
                });
                
                 $('#back-flower').css({
                    /* transforming the position of the content present under the id logo-text 
                     0 px for the horizantal axis and dividing the vertical scroll position with 2 for
                     the vertical axis*/
                   "transform" : "translate(0px, -"+vscroll/12+"px)"
                });
                
                
                  $('#for-flower').css({
                    /* transforming the position of the content present under the id logo-text 
                     0 px for the horizantal axis and dividing the vertical scroll position with 2 for
                     the vertical axis*/
                   "transform" : "translate(0px, -"+vscroll/2+"px)"
                });
                
                
                
                
                
            });
        

            // This function will return the dynamic details of Modal from database:
            function detailsModal(id){
                var data = {"id": id};
                jQuery.ajax({
                    url:'/ecom/includes/detailsmodal.php',
                    method: "post",
                    data : data,
                    success : function(data){
                        jQuery('body').append(data);
                        jQuery('#details-modal').modal('toggle');
                    },
                    error : function(){
                        alert("Something Went Wrong!");
                    }
                });



            }
            // This function is for Updating Cart:
             function update_cart(mode,editId,editSize){
                // Defining var data to hold the mode,editId and editSize:
                var data = {"mode":mode,"editId":editId,"editSize":editSize};
                // Defining ajax request:
                jQuery.ajax({
                    // Defining url of the parser file update_cart.php:
                    url : '/ecom/admin/parsers/update_cart.php',
                    // Defining method:
                    method : "post",
                    // Defining data:
                    data : data,
                    // Defining function for success:
                    success : function(){location.reload();},
                    // Defining funtion for error:
                    error: function(){alert("Something went wrong during updating cart!");}
                });
            }
            // function update_cart(mode,editId,editSize){
            //     // Defining var data to hold the mode,editId and editSize:
            //     var data = {"mode":mode,"editId":editId,"editSize":editSize};
            //     // Defining ajax request:
            //     jQuery.ajax({
            //         // Defining url of the parser file update_cart.php:
            //         url : '/ecom/admin/parsers/update_cart.php',
            //         // Defining method:
            //         method : "post",
            //         // Defining data:
            //         data : data,
            //         // Defining function for success:
            //         success : function(){location.reload();},
            //         // Defining funtion for error:
            //         error: function(){alert("Something went wrong during updating cart!");}
            //     });
            // }

           
            
            
        </script>
        
        
    </body>
    
</html>