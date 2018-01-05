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
	pvs_update_setting('webmoney_account', pvs_result( $_POST["account"] ));
	pvs_update_setting('webmoney_password', pvs_result( $_POST["password"] ));
	pvs_update_setting('webmoney_active', (int) @ $_POST["active"] );
	pvs_update_setting('webmoney_ipn', (int) @ $_POST["ipn"] );
	
	//Update settings
	pvs_get_settings();
}
?>

<p>You have to login at Webmoney site, go to 'Settings' section and set the parameters:</p>

<ul>
	<li>
		<b>Result URL:</b><br>
		<?php echo (site_url( ) );?>/payment-notification/?payment=webmoney
	</li>
	
	<li>
		<b>Success URL:</b><br>
		<?php echo (site_url( ) );?>/payment-success/
	</li>
	
	<li>
		<b>Fail URL:</b><br>
		<?php echo (site_url( ) );?>/payment-fail/
	</li>

<li><b>Hash-method:</b> SHA256</li>

</ul>


<form method="post">
<input type="hidden" name="d" value="<?php echo($_GET["d"]);?>">
<input type="hidden" name="action" value="change">

<div class='admin_field'>
<span><?php echo pvs_word_lang( "Merchant ID" )?>:</span>
<input type='text' name='account'  style="width:400px" value="<?php echo $pvs_global_settings["webmoney_account"] ?>">
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "Security code" )?>:</span>
<input type='text' name='password'  style="width:400px" value="<?php echo $pvs_global_settings["webmoney_password"] ?>">
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "enable" )?>:</span>
<input type='checkbox' name='active' value="1" <?php
	if ( $pvs_global_settings["webmoney_active"] == 1 ) {
		echo ( "checked" );
	}
?>>
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "allow ipn" )?>:</span>
<input type='checkbox' name='ipn' value="1" <?php
	if ( $pvs_global_settings["webmoney_ipn"] == 1 ) {
		echo ( "checked" );
	}
?>>
</div>

<div class='admin_field'>
<input type="submit" class="btn btn-primary" value="<?php echo pvs_word_lang( "save" )?>">
</div>
</form>