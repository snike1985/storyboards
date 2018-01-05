<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( @$_REQUEST["action"] == 'api_save' ) {
	include ( "api_save.php" );
}
?>
<h1><?php echo(pvs_word_lang('API keys'));?></h1>

<p>You need to set the API keys to activate your license and to upgrade your script.</p>

<form method="post" action="<?php echo(pvs_plugins_admin_url('dashboard/index.php'));?>">
<input type="hidden" name="action" value="api_save">
<div class='admin_field'>
	<span>API key:</span>
	<input type="text" name="api_key" style="width:350px" value="<?php echo(@$pvs_global_settings["api_key"])?>"><br>
	<small>* Your order number at cmsaccount.com</small>
</div>

<div class='admin_field'>
	<span>API secret:</span>
	<input type="text" name="api_secret" style="width:350px" value="<?php echo(@$pvs_global_settings["api_secret"])?>"><br>
	<small>** You can find it in your member area at cmsaccount.com</small>
</div>

<div class='admin_field'>
	<input type="submit" value="<?php echo(pvs_word_lang("Save"))?>" class="btn btn-primary">
</div>
</form>