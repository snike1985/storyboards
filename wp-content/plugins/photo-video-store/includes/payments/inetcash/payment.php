<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

pvs_show_payment_page( 'header' );

if ( $pvs_global_settings["inetcash_active"] ) {
	?>
	<form method="post" name="process" id="process" action="https://www.inet-cash.com/mc/shop/start/<?php echo($pvs_global_settings["inetcash_account"]);?>?shopid=<?php echo($product_type);?>-<?php echo($product_id);?>&lang=en&zahlart=cc">	
	</form>
	<?php			
}

pvs_show_payment_page( 'footer' );
?>