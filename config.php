
<?php
// Defining a Constant To hold the path to the server:
define('BASEURL', $_SERVER['DOCUMENT_ROOT'].'/ecom/');
define('CART_COOKIE','ECoM7102fyP@hwk@f');
define('CART_COOKIE_EXPIRE', time()+(86400*30));
define('TAXRATE', 0);

define('CURRENCY','usd');
define('CHECKOUTMODE','TEST'); // Change TEST to LIVE when live project is ready!

if(CHECKOUTMODE == 'TEST'){
	define('STRIPE_PRIVATE','sk_test_IMHDCdbn33WJbpebOAgKaiNN');
	define('STRIPE_PUBLIC','pk_test_E7W9893SEPJNETZoriWv5OMj');
}

if(CHECKOUTMODE == 'LIVE'){
	define('STRIPE_PRIVATE','sk_live_7vsMVzpHBlcyifByA27sZWH1');
	define('STRIPE_PUBLIC','pk_live_IWWZ8lU8KsBUJbxCBpHDDiOu');
}



 ?>
