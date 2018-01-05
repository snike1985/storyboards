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
	pvs_update_setting('2checkout_account', pvs_result( $_POST["account"] ));
	pvs_update_setting('2checkout_password', pvs_result( $_POST["password"] ));
	pvs_update_setting('2checkout_active', (int) @ $_POST["active"] );
	pvs_update_setting('2checkout_ipn', (int) @ $_POST["ipn"] );
	
	//Update settings
	pvs_get_settings();
}
?>

<p><b>Please notice that <a href="http://www.2checkout.com/">2checkout.com</a> doesn't allow Credits model!</b></p>

<p>You should follow the instructions:<br>

- Log in to your 2Checkout account<br>
- Click on the <b>Site Management</b>.<br>
- Set the option <b>Direct Return?</b> to <b>Yes</b><br>
- Set the <b>Approved URL</b> to:<br>
<a href="<?php echo (site_url( ) );?>/payment-notification/?payment=2checkout"><?php echo (site_url( ) );?>/payment-notification/?payment=2checkout</a><br>


</p>


<form method="post">
<input type="hidden" name="d" value="<?php echo((int)$_GET["d"]);?>">
<input type="hidden" name="action" value="change">

<div class='admin_field'>
<span><?php echo pvs_word_lang( "account" )?>:</span>
<input type='text' name='account'  style="width:400px" value="<?php echo $pvs_global_settings["2checkout_account"] ?>">
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "password" )?>:</span>
<input type='text' name='password'  style="width:400px" value="<?php echo $pvs_global_settings["2checkout_password"] ?>">
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "enable" )?>:</span>
<input type='checkbox' name='active' value="1" <?php
	if ( $pvs_global_settings["2checkout_active"] == 1 ) {
		echo ( "checked" );
	}
?>>
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "allow ipn" )?>:</span>
<input type='checkbox' name='ipn' value="1" <?php
	if ( $pvs_global_settings["2checkout_ipn"] == 1 ) {
		echo ( "checked" );
	}
?>>
</div>

<div class='admin_field'>
<input type="submit" class="btn btn-primary" value="<?php echo pvs_word_lang( "save" )?>">
</div>
</form>