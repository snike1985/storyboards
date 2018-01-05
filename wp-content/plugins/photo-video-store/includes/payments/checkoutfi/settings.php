<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "settings_payments" );

if ( @$_REQUEST["action"] == 'change' )
{
	pvs_update_setting('checkoutfi_account', pvs_result( $_POST["checkoutfi_account"] ));
	pvs_update_setting('checkoutfi_password', pvs_result( $_POST["checkoutfi_password"] ));
	pvs_update_setting('checkoutfi_active', (int) @ $_POST["checkoutfi_active"] );
	
	//Update settings
	pvs_get_settings();
}
?>

<p><a href="http://www.checkout.fi"><b>Checkout.fi</b></a> is a Finnish payments gateway provider.</p>


<form method="post">
<input type="hidden" name="d" value="<?php echo($_GET["d"]);?>">
<input type="hidden" name="action" value="change">

<div class='admin_field'>
<span>Merchant ID:</span>
<input type='text' name='checkoutfi_account'  style="width:400px" value="<?php echo $pvs_global_settings["checkoutfi_account"] ?>">
</div>

<div class='admin_field'>
<span>Security Key:</span>
<input type='text' name='checkoutfi_password'  style="width:400px" value="<?php echo $pvs_global_settings["checkoutfi_password"] ?>">
</div>




<div class='admin_field'>
<span><?php echo pvs_word_lang( "enable" )?>:</span>
<input type='checkbox' name='checkoutfi_active' value="1" <?php
if ( $pvs_global_settings["checkoutfi_active"] == 1 ) {
	echo ( "checked" );
}
?>>
</div>


<div class='admin_field'>
<input type="submit" class="btn btn-primary" value="<?php echo pvs_word_lang( "save" )?>">
</div>
</form>