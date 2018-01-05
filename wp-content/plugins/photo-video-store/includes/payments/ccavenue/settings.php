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
	pvs_update_setting('ccavenue_account', pvs_result( $_POST["account"] ));
	pvs_update_setting('ccavenue_password', pvs_result( $_POST["password"] ));
	pvs_update_setting('ccavenue_password2', pvs_result( $_POST["password2"] ));
	pvs_update_setting('ccavenue_active', (int) @ $_POST["active"] );
	
	//Update settings
	pvs_get_settings();
}
?>

<p><a href="http://ccavenue.com/"><b>CCAvenue</b></a> is a payments provider.</p>


<form method="post">
<input type="hidden" name="d" value="<?php echo($_GET["d"]);?>">
<input type="hidden" name="action" value="change">

<div class='admin_field'>
<span>Merchant ID:</span>
<input type='text' name='account'  style="width:400px" value="<?php echo $pvs_global_settings["ccavenue_account"] ?>">
</div>

<div class='admin_field'>
<span>Access Code:</span>
<input type='text' name='password2'  style="width:400px" value="<?php echo $pvs_global_settings["ccavenue_password2"] ?>">
</div>

<div class='admin_field'>
<span>Encryption Key:</span>
<input type='text' name='password'  style="width:400px" value="<?php echo $pvs_global_settings["ccavenue_password"] ?>">
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "enable" )?>:</span>
<input type='checkbox' name='active' value="1" <?php
	if ( $pvs_global_settings["ccavenue_active"] == 1 ) {
		echo ( "checked" );
	}
?>>
</div>



<div class='admin_field'>
<input type="submit" class="btn btn-primary" value="<?php echo pvs_word_lang( "save" )?>">
</div>
</form>