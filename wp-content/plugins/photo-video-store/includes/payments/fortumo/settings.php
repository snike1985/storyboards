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
	pvs_update_setting('fortumo_account', pvs_result( $_POST["account"] ));
	pvs_update_setting('fortumo_password', pvs_result( $_POST["password"] ));
	pvs_update_setting('fortumo_active', (int) @ $_POST["active"] );
	
	//Update settings
	pvs_get_settings();
}
?>

<p><a href="https://www.fortumo.com"><b>Fortumo</b></a> is a mobile payments provider.</p>

<p>You may pay <b>only for the Credits</b> by Fortumo. It is impossible to purchase orders in dollars or subscription plans.</p>

<p>First you have to create a <b>new account</b> on Fortumo and add a <b>	Pay-by-Mobile Widget</b>.</p>

<ul>
<li><b>Name of the credit:</b> Credits</li>
<li><b>The selling rate of the credit.</b> You havee to find an appropriate price. You should notice that the credits packages won't correspond to the <a href="<?php echo(pvs_plugins_admin_url('credits_types/index.php'));?>">settings</a></li>

<li><b>To which URL will your payment requests be forwarded to?</b><br>
<?php echo (site_url( ) );?>/payment/fortumo/
</li>

<li><b>Where to redirect the user after completing the payment?</b><br>
<?php echo (site_url( ) );?>/payment-success/
</li>

</ul>


<form method="post">
<input type="hidden" name="d" value="<?php echo($_GET["d"]);?>">
<input type="hidden" name="action" value="change">

<div class='admin_field'>
<span><?php echo pvs_word_lang( "Service ID" )?>:</span>
<input type='text' name='account'  style="width:400px" value="<?php echo $pvs_global_settings["fortumo_account"] ?>">
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "Secure Key" )?>:</span>
<input type='text' name='password'  style="width:400px" value="<?php echo $pvs_global_settings["fortumo_password"] ?>">
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "enable" )?>:</span>
<input type='checkbox' name='active' value="1" <?php
	if ( $pvs_global_settings["fortumo_active"] == 1 ) {
		echo ( "checked" );
	}
?>>
</div>



<div class='admin_field'>
<input type="submit" class="btn btn-primary" value="<?php echo pvs_word_lang( "save" )?>">
</div>
</form>