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
	pvs_update_setting('paxum_account', pvs_result( $_POST["account"] ));
	pvs_update_setting('paxum_password', pvs_result( $_POST["password"] ));
	pvs_update_setting('paxum_active', (int) @ $_POST["active"] );
	
	//Update settings
	pvs_get_settings();
}
?>

<p><a href="http://paxum.com"><b>Paxum.com</b></a> is a payments provider.</p>

<p>To start receiving IPN messages you have to login into your account, go to Merchant Services -> IPN Settings, select "Turn ON IPN", enter notification URL and select "Receive IPN messages":</p>

<p><b>Notification URL:</b><br>
<?php echo (site_url( ) );?>/payment-notification/?payment=paxum
</p>



<form method="post">
<input type="hidden" name="d" value="<?php echo($_GET["d"]);?>">
<input type="hidden" name="action" value="change">

<div class='admin_field'>
<span><?php echo pvs_word_lang( "account" )?>:</span>
<input type='text' name='account'  style="width:400px" value="<?php echo $pvs_global_settings["paxum_account"] ?>">
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "Secret key" )?>:</span>
<input type='text' name='password'  style="width:400px" value="<?php echo $pvs_global_settings["paxum_password"] ?>">
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "enable" )?>:</span>
<input type='checkbox' name='active' value="1" <?php
	if ( $pvs_global_settings["paxum_active"] == 1 ) {
		echo ( "checked" );
	}
?>>
</div>



<div class='admin_field'>
<input type="submit" class="btn btn-primary" value="<?php echo pvs_word_lang( "save" )?>">
</div>
</form>