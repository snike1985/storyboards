<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["privatbank_active"] ) {
	exit();
}

pvs_show_payment_page( 'header' );
?>
    <form method="post" action="https://www.moneybookers.com/app/payment.pl"  name="process" id="process">
        <input type="hidden" name="pay_to_email" value="<?php echo $pvs_global_settings["privatbank_account"] ?>" />
        <input type="hidden" name="return_url" value="<?php echo (site_url( ) );?>/payment-success/" />
        <input type="hidden" name="cancel_url" value="<?php echo (site_url( ) );?>/payment-fail/" />
        <input type="hidden" name="status_url" value="<?php echo (site_url( ) );?>/payment-notification/?payment=skrill" />
        <input type="hidden" name="language" value="EN" />
        <input type="hidden" name="amount" value="<?php echo $product_total ?>" />
        <input type="hidden" name="currency" value="<?php echo pvs_get_currency_code(1) ?>" />
        <input type="hidden" name="detail1_description" value="<?php echo $product_name ?>" />
        <input type="hidden" name="detail1_text" value="<?php echo $product_id ?>" />
        <input type="hidden" name="transaction_id" value="<?php echo $product_id ?>" />
        <input type="hidden" name="merchant_fields" value="order_id" />
        <input type="hidden" name="order_id" value="<?php echo $product_type ?>-<?php echo $product_id ?>" />
    </form>

<?php
pvs_show_payment_page( 'footer' );
?>