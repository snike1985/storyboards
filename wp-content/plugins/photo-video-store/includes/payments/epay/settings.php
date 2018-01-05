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
	pvs_update_setting('epay_account', pvs_result( $_POST["account"] ));
	pvs_update_setting('epay_password', pvs_result( $_POST["password"] ));
	pvs_update_setting('epay_active', (int) @ $_POST["active"] );
	pvs_update_setting('epay_ipn', (int) @ $_POST["ipn"] );
	
	//Update settings
	pvs_get_settings();
}
?>

<p>You should login on epay.bg as merchant and set <b>Notify/Callback URL:</b><br> <?php echo (site_url( ) );?>/payment-notification/?payment=epay</p>


<form method="post">
<input type="hidden" name="d" value="<?php echo($_GET["d"]);?>">
<input type="hidden" name="action" value="change">

<div class='admin_field'>
<span><?php echo pvs_word_lang( "account" )?>:</span>
<input type='text' name='account'  style="width:400px" value="<?php echo $pvs_global_settings["epay_account"] ?>">
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "Security code" )?>:</span>
<input type='text' name='password'  style="width:400px" value="<?php echo $pvs_global_settings["epay_password"] ?>">
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "enable" )?>:</span>
<input type='checkbox' name='active' value="1" <?php
	if ( $pvs_global_settings["epay_active"] == 1 ) {
		echo ( "checked" );
	}
?>>
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "allow ipn" )?>:</span>
<input type='checkbox' name='ipn' value="1" <?php
	if ( $pvs_global_settings["epay_ipn"] == 1 ) {
		echo ( "checked" );
	}
?>>
</div>

<div class='admin_field'>
<input type="submit" class="btn btn-primary" value="<?php echo pvs_word_lang( "save" )?>">
</div>
</form>