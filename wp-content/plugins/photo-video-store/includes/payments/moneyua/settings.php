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
	pvs_update_setting('moneyua_account', pvs_result( $_POST["account"] ));
	pvs_update_setting('moneyua_password', pvs_result( $_POST["password"] ));
	pvs_update_setting('moneyua_active', (int) @ $_POST["active"] );
	pvs_update_setting('moneyua_test', (int) @ $_POST["test"] );
	pvs_update_setting('moneyua_commission', (int) @ $_POST["commission"] );
	
	//Update settings
	pvs_get_settings();
}
?>

<p><a href="http://money.ua"><b>Money.ua</b></a> is a payments provider.</p>


<form method="post">
<input type="hidden" name="d" value="<?php echo($_GET["d"]);?>">
<input type="hidden" name="action" value="change">

<div class='admin_field'>
<span><?php echo pvs_word_lang( "account" )?>:</span>
<input type='text' name='account'  style="width:400px" value="<?php echo $pvs_global_settings["moneyua_account"] ?>">
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "Secret key" )?>:</span>
<input type='text' name='password'  style="width:400px" value="<?php echo $pvs_global_settings["moneyua_password"] ?>">
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "enable" )?>:</span>
<input type='checkbox' name='active' value="1" <?php
	if ( $pvs_global_settings["moneyua_active"] == 1 ) {
		echo ( "checked" );
	}
?>>
</div>

<div class='admin_field'>
<span>Commission:</span>
<select name='commission'  style="width:300px">
	<option value="0" <?php
	if ( $pvs_global_settings["moneyua_commission"] == 0 ) {
		echo ( "selected" );
	}
?>>The store pays the commission</option>
	<option value="1" <?php
	if ( $pvs_global_settings["moneyua_commission"] == 1 ) {
		echo ( "selected" );
	}
?>>A client pays the commission</option>
</select>
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "Test mode" )?>:</span>
<input type='checkbox' name='test' value="1" <?php
	if ( $pvs_global_settings["moneyua_test"] == 1 ) {
		echo ( "checked" );
	}
?>>
</div>

<div class='admin_field'>
<input type="submit" class="btn btn-primary" value="<?php echo pvs_word_lang( "save" )?>">
</div>
</form>