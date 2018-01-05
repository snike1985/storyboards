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
	pvs_update_setting('pagseguro_account', pvs_result( $_POST["account"] ));
	pvs_update_setting('pagseguro_password', pvs_result( $_POST["password"] ));
	pvs_update_setting('pagseguro_active', (int) @ $_POST["active"] );
	
	//Update settings
	pvs_get_settings();
}
?>

<p><a href="http://pagseguro.com.br/"><b>PagSeguro</b></a> is Brazilian payments provider.</p>

<p>You should set the <b>Postback Notification URL</b> in your member area of PagSeguro:<br>
<b><?php echo (site_url( ) );?>/payment-notification/?payment=pagseguro</b></p>


<form method="post">
<input type="hidden" name="d" value="<?php echo($_GET["d"]);?>">
<input type="hidden" name="action" value="change">

<div class='admin_field'>
<span>Seller Email:</span>
<input type='text' name='account'  style="width:400px" value="<?php echo $pvs_global_settings["pagseguro_account"] ?>">
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "Token" )?>:</span>
<input type='text' name='password'  style="width:400px" value="<?php echo $pvs_global_settings["pagseguro_password"] ?>">
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "enable" )?>:</span>
<input type='checkbox' name='active' value="1" <?php
	if ( $pvs_global_settings["pagseguro_active"] == 1 ) {
		echo ( "checked" );
	}
?>>
</div>



<div class='admin_field'>
<input type="submit" class="btn btn-primary" value="<?php echo pvs_word_lang( "save" )?>">
</div>
</form>