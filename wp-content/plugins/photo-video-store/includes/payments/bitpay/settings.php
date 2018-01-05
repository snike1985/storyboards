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
	pvs_update_setting('bitpay_account', pvs_result( $_POST["bitpay_account"] ));
	pvs_update_setting('bitpay_active', (int) @ $_POST["bitpay_active"] );
	pvs_update_setting('bitpay_test', (int) @ $_POST["bitpay_test"] );
	
	//Update settings
	pvs_get_settings();
}
?>

<p><a href="http://www.bitpay.com"><b>Bitpay</b></a> is a Bitcoin payment provider.</p>

<form method="post">
<input type="hidden" name="d" value="<?php echo($_GET["d"]);?>">
<input type="hidden" name="action" value="change">

<div class='admin_field'>
<span>API key:</span>
<input type='text' name='bitpay_account'  style="width:400px" value="<?php echo $pvs_global_settings["bitpay_account"] ?>">
</div>


<div class='admin_field'>
<span>Test mode:</span>
<input type='checkbox' name='bitpay_test' value="1" <?php
if ( $pvs_global_settings["bitpay_test"] == 1 ) {
	echo ( "checked" );
}
?>>
</div>



<div class='admin_field'>
<span><?php echo pvs_word_lang( "enable" )?>:</span>
<input type='checkbox' name='bitpay_active' value="1" <?php
if ( $pvs_global_settings["bitpay_active"] == 1 ) {
	echo ( "checked" );
}
?>>
</div>

<div class='admin_field'>
<input type="submit" class="btn btn-primary" value="<?php echo pvs_word_lang( "save" )?>">
</div>
</form>