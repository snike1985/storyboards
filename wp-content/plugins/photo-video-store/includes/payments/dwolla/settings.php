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
	pvs_update_setting('dwolla_account', pvs_result( $_POST["account"] ));
	pvs_update_setting('dwolla_password', pvs_result( $_POST["password"] ));
	pvs_update_setting('dwolla_password2', pvs_result( $_POST["password2"] ));
	pvs_update_setting('dwolla_password3', pvs_result( $_POST["password3"] ));
	pvs_update_setting('dwolla_active', (int) @ $_POST["active"] );
	pvs_update_setting('dwolla_test', (int) @ $_POST["test"] );
	
	//Update settings
	pvs_get_settings();
}
?>

<p><a href="http://www.dwolla.com/"><b>Dwolla</b></a> is a payments provider. 
The best way to move money. No percentages. No hidden fees. Just 25 cents per transaction or free for transactions $10 and less.
</p>


<ul>
<li>You should login Dwolla account and go to App permissions -> Create an application.</li>


<li><b>Payment Callback URL</b> and <b>
Payment Redirect URL </b>:<br><?php echo (site_url( ) );?>/payment-notification/?payment=dwolla</li>



</ul>


<form method="post">
<input type="hidden" name="d" value="<?php echo($_GET["d"]);?>">
<input type="hidden" name="action" value="change">

<div class='admin_field'>
<span><?php echo pvs_word_lang( "account" )?>:</span>
<input type='text' name='account'  style="width:400px" value="<?php echo $pvs_global_settings["dwolla_account"] ?>">
</div>

<div class='admin_field'>
<span>API Key:</span>
<input type='text' name='password'  style="width:400px" value="<?php echo $pvs_global_settings["dwolla_password"] ?>">
</div>

<div class='admin_field'>
<span>API Secret:</span>
<input type='text' name='password2'  style="width:400px" value="<?php echo $pvs_global_settings["dwolla_password2"] ?>">
</div>

<div class='admin_field'>
<span>Pin:</span>
<input type='text' name='password3'  style="width:400px" value="<?php echo $pvs_global_settings["dwolla_password3"] ?>">
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "enable" )?>:</span>
<input type='checkbox' name='active' value="1" <?php
	if ( $pvs_global_settings["dwolla_active"] == 1 ) {
		echo ( "checked" );
	}
?>>
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "Test mode" )?>:</span>
<input type='checkbox' name='test' value="1" <?php
	if ( $pvs_global_settings["dwolla_test"] == 1 ) {
		echo ( "checked" );
	}
?>>
</div>

<div class='admin_field'>
<input type="submit" class="btn btn-primary" value="<?php echo pvs_word_lang( "save" )?>">
</div>
</form>