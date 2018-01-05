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
	pvs_update_setting('robokassa_account', pvs_result( $_POST["account"] ));
	pvs_update_setting('robokassa_password', pvs_result( $_POST["password"] ));
	pvs_update_setting('robokassa_password2', pvs_result( $_POST["password2"] ));
	pvs_update_setting('robokassa_active', (int) @ $_POST["active"] );
	
	//Update settings
	pvs_get_settings();
}
?>

<p><a href="http://robokassa.ru/"><b>Robokassa</b></a> is Russian payments provider.</p>

<p>You should set:</p>
<ul>
<li>
	<b>Result URL:</b>
	<br><?php echo (site_url( ) );?>/payment-notification/?payment=robokassa
</li>

<li>
	<b>Send method:</b>
	<br>GET
</li>

<li>
	<b>Success URL:</b>
	<br><?php echo (site_url( ) );?>/payment-success/
</li>

<li>
	<b>Fail URL:</b>
	<br><?php echo (site_url( ) );?>/payment-fail/
</li>
</ul>


<form method="post">
<input type="hidden" name="d" value="<?php echo($_GET["d"]);?>">
<input type="hidden" name="action" value="change">

<div class='admin_field'>
<span><?php echo pvs_word_lang( "Merchant login" )?>:</span>
<input type='text' name='account'  style="width:400px" value="<?php echo $pvs_global_settings["robokassa_account"] ?>">
</div>

<div class='admin_field'>
<span>Password #1:</span>
<input type='text' name='password'  style="width:400px" value="<?php echo $pvs_global_settings["robokassa_password"] ?>">
</div>

<div class='admin_field'>
<span>Password #2:</span>
<input type='text' name='password2'  style="width:400px" value="<?php echo $pvs_global_settings["robokassa_password2"] ?>">
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "enable" )?>:</span>
<input type='checkbox' name='active' value="1" <?php
	if ( $pvs_global_settings["robokassa_active"] == 1 ) {
		echo ( "checked" );
	}
?>>
</div>



<div class='admin_field'>
<input type="submit" class="btn btn-primary" value="<?php echo pvs_word_lang( "save" )?>">
</div>
</form>