<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["fortumo_active"] ) {
	exit();
}

pvs_show_payment_page( 'header', true );


?>
<h1>SMS payment by Fortumo</h1>
<script src="https://fortumo.com/javascripts/fortumopay.js" type="text/javascript"></script>
<a id="fmp-button" href="#" rel="<?php echo $pvs_global_settings["fortumo_account"]
?>/<?php echo get_current_user_id() ?>">
 <img src="https://fortumo.com/images/fmp/fortumopay_96x47.png" width="96" height="47" alt="Mobile Payments by Fortumo" border="0" />
</a>

<?php
pvs_show_payment_page( 'footer',true );
?>