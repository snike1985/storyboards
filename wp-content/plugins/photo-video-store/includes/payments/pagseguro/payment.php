<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["pagseguro_active"] ) {
	exit();
}

pvs_show_payment_page( 'header' );
?>
<form name="process" id="process" method="post" action="https://pagseguro.uol.com.br/v2/checkout/payment.html">  

    <input type="hidden" name="receiverEmail" value="<?php echo $pvs_global_settings["pagseguro_account"] ?>">  
    <input type="hidden" name="currency" value="BRL">  
      
    <input type="hidden" name="itemId1" value="<?php echo $product_id ?>">  
    <input type="hidden" name="itemDescription1" value="<?php echo $product_type ?>">  
    <input type="hidden" name="itemAmount1" value="<?php echo pvs_price_format( $product_total, 2 )?>">  
    <input type="hidden" name="itemQuantity1" value="1">  
 
 <input type="hidden" name="tipo_frete" value="EN">
</form> 
<?php
pvs_show_payment_page( 'footer' );
?>