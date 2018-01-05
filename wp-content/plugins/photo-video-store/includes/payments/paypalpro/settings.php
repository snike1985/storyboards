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
	pvs_update_setting('paypalpro_account', pvs_result( $_POST["account"] ));
	pvs_update_setting('paypalpro_password', pvs_result( $_POST["password"] ));
	pvs_update_setting('paypalpro_signature', pvs_result( $_POST["signature"] ));
	pvs_update_setting('paypalpro_active', (int) @ $_POST["active"] );
	
	//Update settings
	pvs_get_settings();
}
?>

<p>Verify your <b>Paypal</b> account status. Go to your <b>PayPal Profile</b> under <b>My settings</b> and verify that your <b>Account Type</b> is either <b>Premier</b> or <b>Business</b>, or upgrade your account.</p>

<p>Verify your <b>API settings</b>. Click on <b>My selling</b> tools. Click <b>Selling online</b> and verify your <b>API access</b>. Click <b>Update</b> to view or set up your API signature and credentials.</p>


<form method="post">
<input type="hidden" name="d" value="<?php echo($_GET["d"]);?>">
<input type="hidden" name="action" value="change">

<div class='admin_field'>
<span><?php echo pvs_word_lang( "Username" )?>:</span>
<input type='text' name='account'  style="width:400px" value="<?php echo $pvs_global_settings["paypalpro_account"] ?>">
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "Password" )?>:</span>
<input type='text' name='password'  style="width:400px" value="<?php echo $pvs_global_settings["paypalpro_password"] ?>">
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "Signature" )?>:</span>
<input type='text' name='signature'  style="width:400px" value="<?php echo $pvs_global_settings["paypalpro_signature"] ?>">
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "enable" )?>:</span>
<input type='checkbox' name='active' value="1" <?php
	if ( $pvs_global_settings["paypalpro_active"] == 1 ) {
		echo ( "checked" );
	}
?>>
</div>



<div class='admin_field'>
<input type="submit" class="btn btn-primary" value="<?php echo pvs_word_lang( "save" )?>">
</div>
</form>