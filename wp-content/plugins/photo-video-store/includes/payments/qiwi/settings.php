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
	pvs_update_setting('qiwi_account', pvs_result( $_POST["account"] ));
	pvs_update_setting('qiwi_account2', pvs_result( $_POST["account2"] ));
	pvs_update_setting('qiwi_password', pvs_result( $_POST["password"] ));
	pvs_update_setting('qiwi_password2', pvs_result( $_POST["password2"] ));
	pvs_update_setting('qiwi_active', (int) @ $_POST["active"] );
	
	//Update settings
	pvs_get_settings();
}
?>

<p>
You should login in your QIWI account at <a href="http://ishop.qiwi.ru/"><b>ishop.qiwi.ru</b></a> and enable <b>REST</b> protocol.
</p>

<p>
<b>URL (callback):</b><br>
<?php echo (site_url( ) );?>/payment-notification/?payment=qiwi</p>
</p>



</p>
<br>


<form method="post">
<input type="hidden" name="d" value="<?php echo($_GET["d"]);?>">
<input type="hidden" name="action" value="change">

<div class='admin_field'>
<span><?php echo pvs_word_lang( "Shop ID" )?>:</span>
<input type='text' name='account'  style="width:400px" value="<?php echo $pvs_global_settings["qiwi_account"] ?>">
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "API ID" )?>:</span>
<input type='text' name='account2'  style="width:400px" value="<?php echo $pvs_global_settings["qiwi_account2"] ?>">
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "API password" )?>:</span>
<input type='text' name='password'  style="width:400px" value="<?php echo $pvs_global_settings["qiwi_password"] ?>">
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "Notification password" )?>:</span>
<input type='text' name='password2'  style="width:400px" value="<?php echo $pvs_global_settings["qiwi_password2"] ?>">
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "enable" )?>:</span>
<input type='checkbox' name='active' value="1" <?php
	if ( $pvs_global_settings["qiwi_active"] == 1 ) {
		echo ( "checked" );
	}
?>>
</div>



<div class='admin_field'>
<input type="submit" class="btn btn-primary" value="<?php echo pvs_word_lang( "save" )?>">
</div>
</form>