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
	pvs_update_setting('midtrans_account', pvs_result( $_POST["account"] ));
	pvs_update_setting('midtrans_password', pvs_result( $_POST["password"] ));
	pvs_update_setting('midtrans_active', (int) @ $_POST["active"] );
	pvs_update_setting('midtrans_test', (int) @ $_POST["test"] );
	
	//Update settings
	pvs_get_settings();
}
?>

<p><a href="https://www.midtrans.com"><b>Midtrans</b></a> is a payment provider.</p>

<p>You should go to Mdtrans account -> Settings -> Configuration and set the parameters:</p><p>

<b>Payment Notification URL:</b><br>
<?php echo (site_url( ) );?>/payment-notification/?payment=midtrans
</p><p>
<b>Finish Redirect URL:</b><br>
<?php echo (site_url( ) );?>/payment-success/
</p><p>
<b>Unfinish Redirect URL:</b><br>
<?php echo (site_url( ) );?>/payment-fail/
</p><p>
<b>Error Redirect URL:</b><br>
<?php echo (site_url( ) );?>/payment-fail/
</p>

<br>


<form method="post">
<input type="hidden" name="d" value="<?php echo($_GET["d"]);?>">
<input type="hidden" name="action" value="change">

<div class='admin_field'>
<span>Client Key:</span>
<input type='text' name='account'  style="width:400px" value="<?php echo $pvs_global_settings["midtrans_account"] ?>">
</div>

<div class='admin_field'>
<span>Server Key:</span>
<input type='text' name='password'  style="width:400px" value="<?php echo $pvs_global_settings["midtrans_password"] ?>">
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "enable" )?>:</span>
<input type='checkbox' name='active' value="1" <?php
	if ( $pvs_global_settings["midtrans_active"] == 1 ) {
		echo ( "checked" );
	}
?>>
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "Test mode" )?>:</span>
<input type='checkbox' name='test' value="1" <?php
	if ( $pvs_global_settings["midtrans_test"] == 1 ) {
		echo ( "checked" );
	}
?>>
</div>

<div class='admin_field'>
<input type="submit" class="btn btn-primary" value="<?php echo pvs_word_lang( "save" )?>">
</div>
</form>