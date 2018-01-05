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
	pvs_update_setting('epaykkbkz_active', (int) @ $_POST["active"] );

	
	//Update settings
	pvs_get_settings();
}
?>

<p><a href="http://epay.kkb.kz/"><b>Epay.kkb.kz</b></a> is a payments provider of Kazakhstan.</p>

<p>To install the gateway you should:</p>

<ul>
	<li>Modify the file on ftp: <?php echo PVS_PATH;?>includes/plugins/epaykkbkz/<b>config.txt</b></li>
	<li>Upload <b>Private and Public certificate files</b> here: <?php echo PVS_PATH?>includes/plugins/epaykkbkz/</li>
</ul>



<form method="post">
<input type="hidden" name="d" value="<?php echo($_GET["d"]);?>">
<input type="hidden" name="action" value="change">



<div class='admin_field'>
<span><?php echo pvs_word_lang( "enable" )?>:</span>
<input type='checkbox' name='active' value="1" <?php
	if ( $pvs_global_settings["epaykkbkz_active"] == 1 ) {
		echo ( "checked" );
	}
?>>
</div>


<div class='admin_field'>
<input type="submit" class="btn btn-primary" value="<?php echo pvs_word_lang( "save" )?>">
</div>
</form>