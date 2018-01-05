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
	pvs_update_setting('zombaio_account', pvs_result( $_POST["account"] ));
	pvs_update_setting('zombaio_account2', pvs_result( $_POST["account2"] ));
	pvs_update_setting('zombaio_password', pvs_result( $_POST["password"] ));
	pvs_update_setting('zombaio_active', (int) @ $_POST["active"] );
	
	//Update settings
	pvs_get_settings();
}
?>

<p><a href="http://www.zombaio.com"><b>Zombaio.com</b></a> is an Adult Entertainment Industry payments provider.</p>



<p>You may pay <b>only for the Credits</b> by Zombaio.</p>

<ul>
<li>First you have to create a <b>new account</b> on <a href="https://secure.zombaio.com/zoa">Zombaio.com</a> and add a <b>New Site (manually)</b>.</li>

<li>Go to <b>Pricing Structure</b> and add <b>New pricing</b>. Pricing type: <b>Purchase of Credits</b>. </li>

<li>You must have <a href="<?php echo(pvs_plugins_admin_url('credits-types/index.php'));?>"><b>the same credits list</b></a> on the site.</li>

<li><b>Postback URL:</b><br><?php echo (site_url( ) );?>/payment-notification/?payment=zombaio</li>


</ul>


<form method="post">
<input type="hidden" name="d" value="<?php echo($_GET["d"]);?>">
<input type="hidden" name="action" value="change">

<div class='admin_field'>
<span><?php echo pvs_word_lang( "Site ID" )?>:</span>
<input type='text' name='account'  style="width:400px" value="<?php echo $pvs_global_settings["zombaio_account"] ?>">
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "Zombaio GW Pass" )?>:</span>
<input type='text' name='password'  style="width:400px" value="<?php echo $pvs_global_settings["zombaio_password"] ?>">
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "Pricing Structure ID" )?>:</span>
<input type='text' name='account2'  style="width:400px" value="<?php echo $pvs_global_settings["zombaio_account2"] ?>">
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "enable" )?>:</span>
<input type='checkbox' name='active' value="1" <?php
	if ( $pvs_global_settings["zombaio_active"] == 1 ) {
		echo ( "checked" );
	}
?>>
</div>



<div class='admin_field'>
<input type="submit" class="btn btn-primary" value="<?php echo pvs_word_lang( "save" )?>">
</div>
</form>