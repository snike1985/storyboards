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
	pvs_update_setting('targetpay_account', pvs_result( $_POST["account"] ));
	pvs_update_setting('targetpay_active', (int) @ $_POST["active"] );
	pvs_update_setting('targetpay_test', (int) @ $_POST["test"] );
	
	//Update settings
	pvs_get_settings();
}
?>

<p><a href="http://targetpay.com"><b>Targetpay</b></a> is Ideal payments provider.</p>


<form method="post">
<input type="hidden" name="d" value="<?php echo($_GET["d"]);?>">
<input type="hidden" name="action" value="change">

<div class='admin_field'>
<span><?php echo pvs_word_lang( "account" )?>:</span>
<input type='text' name='account'  style="width:400px" value="<?php echo $pvs_global_settings["targetpay_account"] ?>">
</div>



<div class='admin_field'>
<span><?php echo pvs_word_lang( "enable" )?>:</span>
<input type='checkbox' name='active' value="1" <?php
	if ( $pvs_global_settings["targetpay_active"] == 1 ) {
		echo ( "checked" );
	}
?>>
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "Test mode" )?>:</span>
<input type='checkbox' name='test' value="1" <?php
	if ( $pvs_global_settings["targetpay_test"] == 1 ) {
		echo ( "checked" );
	}
?>>
</div>

<div class='admin_field'>
<input type="submit" class="btn btn-primary" value="<?php echo pvs_word_lang( "save" )?>">
</div>
</form>