<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["stripe_active"] ) {
	exit();
}

pvs_show_payment_page( 'header', true );

$payment = preg_replace( '/[^a-z0-9]/i', "", $_REQUEST["payment"] );


?>
<h1><?php echo pvs_word_lang( "payment" )?> - Stripe</h1>

<?php
$test_mode = true;
if ( isset( $_SERVER["HTTPS"] ) and $_SERVER["HTTPS"] == "on" ) {
	$test_mode = false;
}

if ( $test_mode ) {
	echo ( "<div class='warning'>Error. The payment method requires a secure ssl connection. The transaction will be in <b>TEST MODE</b>. Please not to use valid credit card details!</div>" );
}
?>

<p>
<?php


//Check if Total is correct
if ( ! pvs_check_order_total( $product_total, $product_type, $product_id ) ) {
	exit();
}
?>
<h2><?php echo pvs_word_lang( "order" )?>:</h2>

<?php echo pvs_show_order_content( $product_type, $product_id )?>




<div class='login_header'><h2 style="margin-top:30px"><?php echo pvs_word_lang( "credit card" )?>:</h2></div>



<script type="text/javascript" src="https://js.stripe.com/v1/"></script>



 <script type="text/javascript">
// This identifies your website in the createToken call below
Stripe.setPublishableKey('<?php echo $pvs_global_settings["stripe_account"]
?>');
 
var stripeResponseHandler = function(status, response) {
var $form = $('#payment-form');
 
if (response.error) {
// Show the errors on the form
$form.find('.payment-errors').text(response.error.message);
$form.find('button').prop('disabled', false);
} else {
// token contains id, last4, and card type
var token = response.id;
// Insert the token into the form so it gets submitted to the server
$form.append($('<input type="hidden" name="stripeToken" />').val(token));
// and re-submit
$form.get(0).submit();
}
};
 
jQuery(function($) {
$('#payment-form').submit(function(e) {
var $form = $(this);
 
// Disable the submit button to prevent repeated clicks
$form.find('button').prop('disabled', true);
 
Stripe.createToken($form, stripeResponseHandler);
 
// Prevent the form from submitting with the default action
return false;
});
});
</script>

<form  id="payment-form" action="<?php echo (site_url( ) );?>/payment-notification/?payment=stripe" method="post">
 <p class="payment-errors" style="color:red"></p>

<input type="hidden" name="product_id" value="<?php echo $product_id
?>">
<input type="hidden" name="product_name" value="<?php echo $product_name
?>">
<input type="hidden" name="product_total" value="<?php echo $product_total
?>">
<input type="hidden" name="product_type" value="<?php echo $product_type
?>">



<div class="form_field">
<span><b>Credit card number:</b></span>
<input type="text"  data-stripe="number"  size="20" class="ibox form-control" style="width:250px">
</div>

<div class="form_field">
<span><b>Credit card expiration date:</b></span>
<input type="text"  data-stripe="exp-month" size="2" class="ibox form-control" style="width:70px;display:inline" placeholder="MM">
<input type="text" data-stripe="exp-year" size="4" class="ibox form-control" style="width:100px;display:inline"  placeholder="YYYY">
</div>

<div class="form_field">
<span><b>CVV code:</b></span>
<input type="text" data-stripe="cvc" size="4" class="ibox form-control" style="width:100px">
</div>


 <button type="submit" class="isubmit btn btn-success"><?php echo pvs_word_lang( "Pay Now" )?></button>

</form>
<?php
pvs_show_payment_page( 'footer', true );
?>