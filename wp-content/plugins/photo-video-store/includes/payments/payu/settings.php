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
	pvs_update_setting('payu_account', pvs_result( $_POST["account"] ));
	pvs_update_setting('payu_password', pvs_result( $_POST["password"] ));
	pvs_update_setting('payu_password2', pvs_result( $_POST["password2"] ));
	pvs_update_setting('payu_password3', pvs_result( $_POST["password3"] ));
	pvs_update_setting('payu_active', (int) @ $_POST["active"] );
	
	//Update settings
	pvs_get_settings();
}
?>


<p><a href="http://payu.pl"><b>PayU</b></a> is a payments provider.</p>

<p>You should set the parameter in your account at payu.com:</p>

<ul>
<li>
	<b>Adres raportow:</b><br>
	<?php echo (site_url( ) );?>/payment-notification/?payment=payu
</li>

<li>
	<b>Adres powrotu pozytywnego:</b>
	<br><?php echo (site_url( ) );?>/payment-success/
</li>

<li>
	<b>Adres powrotu blednego:</b>
	<br><?php echo (site_url( ) );?>/payment-fail/
</li>
</ul>



<form method="post">
<input type="hidden" name="d" value="<?php echo($_GET["d"]);?>">
<input type="hidden" name="action" value="change">

<div class='admin_field'>
<span>Id punktu platnosci (pos_id):</span>
<input type='text' name='account'  style="width:400px" value="<?php echo $pvs_global_settings["payu_account"] ?>">
</div>

<div class='admin_field'>
<span>Klucz (MD5):</span>
<input type='text' name='password'  style="width:400px" value="<?php echo $pvs_global_settings["payu_password"] ?>">
</div>

<div class='admin_field'>
<span>Drugi klucz (MD5):</span>
<input type='text' name='password2'  style="width:400px" value="<?php echo $pvs_global_settings["payu_password2"] ?>">
</div>

<div class='admin_field'>
<span>Klucz autoryzacji platnosci (pos_auth_key):</span>
<input type='text' name='password3'  style="width:400px" value="<?php echo $pvs_global_settings["payu_password3"] ?>">
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "enable" )?>:</span>
<input type='checkbox' name='active' value="1" <?php
	if ( $pvs_global_settings["payu_active"] == 1 ) {
		echo ( "checked" );
	}
?>>
</div>



<div class='admin_field'>
<input type="submit" class="btn btn-primary" value="<?php echo pvs_word_lang( "save" )?>">
</div>
</form>