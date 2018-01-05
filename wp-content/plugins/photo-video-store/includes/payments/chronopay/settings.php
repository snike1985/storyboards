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
	pvs_update_setting('chronopay_account', pvs_result( $_POST["account"] ));
	pvs_update_setting('chronopay_password', pvs_result( $_POST["password"] ));
	pvs_update_setting('chronopay_active', (int) @ $_POST["active"] );
	pvs_update_setting('chronopay_ipn', (int) @ $_POST["ipn"] );
	
	//Update settings
	pvs_get_settings();
}
?>

<p>In the Chronopay client interface please set the <b>Access URL</b> field of the product you will use to the following:<br> 
<a href="<?php echo (site_url( ) );?>/payment-notification/?payment=chronopay"><?php echo (site_url( ) );?>/payment-notification/?payment=chronopay</a></p>


<form method="post">
<input type="hidden" name="d" value="<?php echo($_GET["d"]);?>">
<input type="hidden" name="action" value="change">

<div class='admin_field'>
<span><?php echo pvs_word_lang( "product id" )?>:</span>
<input type='text' name='account'  style="width:400px" value="<?php echo $pvs_global_settings["chronopay_account"] ?>">
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "encryption key" )?>:</span>
<input type='text' name='password'  style="width:400px" value="<?php echo $pvs_global_settings["chronopay_password"] ?>">
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "enable" )?>:</span>
<input type='checkbox' name='active' value="1" <?php
	if ( $pvs_global_settings["chronopay_active"] == 1 ) {
		echo ( "checked" );
	}
?>>
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "allow ipn" )?>:</span>
<input type='checkbox' name='ipn' value="1" <?php
	if ( $pvs_global_settings["chronopay_ipn"] == 1 ) {
		echo ( "checked" );
	}
?>>
</div>

<div class='admin_field'>
<input type="submit" class="btn btn-primary" value="<?php echo pvs_word_lang( "save" )?>">
</div>
</form>