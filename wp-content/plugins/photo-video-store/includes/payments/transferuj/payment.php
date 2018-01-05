<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["transferuj_active"] ) {
	exit();
}

pvs_show_payment_page( 'header' );

$user_info = get_userdata(get_current_user_id());
?>
<form action="https://secure.transferuj.pl" method="post" name="process" id="process">
<input name="id" value="<?php echo $pvs_global_settings["transferuj_account"]?>" type="hidden"/>
<input name="kwota" value="<?php echo pvs_price_format( $product_total, 2 )?>" type="hidden">
<input name="opis" value="<?php echo $product_name ?>" type="hidden"/>
<input name="crc" value="<?php echo $product_type ?>-<?php echo $product_id ?>" type="hidden"/>
<input name="md5sum" value="<?php echo md5( $pvs_global_settings["transferuj_account"] . pvs_price_format( $product_total, 2 ) . $product_type . "-" . $product_id . $pvs_global_settings["transferuj_password"] )?>" type="hidden"/>
<input type="hidden" name="pow_url_blad" value="<?php echo (site_url( ) );?>/payment-fail/"/>
<input type="hidden" name="wyn_url" value="<?php echo (site_url( ) );?>/payment-notification/?payment=transferuj"/>
<input type="hidden" name="pow_url" value="<?php echo (site_url( ) );?>/payment-success/"/>
<input name="email" value="<?php echo @$user_info -> user_email?>" type="hidden"/>
</form> 
<?php
pvs_show_payment_page( 'footer' );
?>