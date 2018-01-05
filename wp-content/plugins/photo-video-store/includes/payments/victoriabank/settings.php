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
	pvs_update_setting('victoriabank_account', pvs_result( $_POST["account"] ));
	pvs_update_setting('victoriabank_account2', pvs_result( $_POST["account2"] ));
	pvs_update_setting('victoriabank_active', (int) @ $_POST["active"] );
	
	//Update settings
	pvs_get_settings();
}
?>

<p><a href="http://vb.md"><b>Victoria</b></a> is Moldavian bank.</p>

<p>
You should set the parameters:
</p>

<ul>

<li>Upload <b>Public key</b> here on ftp:<br> <b><?php echo PVS_PATH?>/includes/plugins/victoriabank/victoria_pub.pem</b></li>
<br>
<li>Generate a <b>new RSA key </b> in the command string on your computer:<br> <b>openssl genrsa -f4 -out key.pem 2048 </b></li>
<br>
<li>Upload <b>RSA key</b> here on ftp:<br> <b><?php echo PVS_PATH?>/includes/plugins/victoriabank/key.pem</b></li>
<br>
<li>Set the <b>Call back URL</b> in your account at vb.mb:<br> <b><?php echo (site_url( ) );?>/payment-notification/?payment=victoriabank</b></li>

</ul>

<br>


<form method="post">
<input type="hidden" name="d" value="<?php echo($_GET["d"]);?>">
<input type="hidden" name="action" value="change">

<div class='admin_field'>
<span><?php echo pvs_word_lang( "Terminal" )?>:</span>
<input type='text' name='account'  style="width:400px" value="<?php echo $pvs_global_settings["victoriabank_account"] ?>">
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "Merchant" )?>:</span>
<input type='text' name='account2'  style="width:400px" value="<?php echo $pvs_global_settings["victoriabank_account2"] ?>">
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "enable" )?>:</span>
<input type='checkbox' name='active' value="1" <?php
	if ( $pvs_global_settings["victoriabank_active"] == 1 ) {
		echo ( "checked" );
	}
?>>
</div>



<div class='admin_field'>
<input type="submit" class="btn btn-primary" value="<?php echo pvs_word_lang( "save" )?>">
</div>
</form>