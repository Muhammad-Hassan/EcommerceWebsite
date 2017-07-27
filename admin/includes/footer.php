
        </div><br><br>
         <footer class="col-md-12 text-center" id="footer">&copy; Copyright 2016</footer>
        
        <script>
        function updateSizes(){
        	var sizeString = '';
        	for(var i =1; i <= 12; i++){
        		if(jQuery('#size'+i).val() != ''){
        			sizeString += jQuery('#size'+i).val()+ ':' + jQuery('#qty'+i).val()+ ',';
        		}
        	}
        	jQuery('#sizes').val(sizeString);
        }

        	function get_child_options(selected){

                if(typeof selected == 'undefined'){
                    var selected = '';
                }

        		// making a variable to holding down the value of the option which gets selected from the parent category option list:
        		var parentIDValue = jQuery('#parent').val();
        		jQuery.ajax({
        			// The url of the file:
        			url: '/ecom/admin/parsers/child_categories.php',
        			// Method of posting:
        			type: 'POST',
        			// Data which gets posted in this case it is parent Category Id and its value :
        			data: {parentID : parentIDValue,selected : selected},
        			// On the success of the Data execute the function: 
        			success: function(data){
        				// Select the html element with the id of child and display its html with the data send back from the selected parent category in this case it will be value for the child category option box:
        				jQuery('#child').html(data);
        			},
        			// In case of error execute this anonymous function with an alert message:
        			error: function(){alert("Something went wrong with the child options.")},
        		});
        	}
        	/*This code is for listening up the change of select option of Parent Category
        	When the select option changed then execute the get_child_options function :*/
        	jQuery('select[name="parent"]').change(function(){

                get_child_options();
            });
        </script>
        
    </body>
    
</html>