<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "affiliates_settings" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

//Change
if ( @$_REQUEST["action"] == 'change' )
{
	include ( "change.php" );
}

if ( isset( $_REQUEST["action"] ) )
{
	//Update settings
	pvs_get_settings();
}
?>






<h1><?php echo pvs_word_lang( "settings" )?>:</h1>

<div class="box box_padding">

<form method="post" action="<?php echo(pvs_plugins_admin_url('affiliates/settings.php'));?>">
<input type="hidden" name="action" value="change">

<div class="admin_field">
<b>Buyer signup commission:</b><br>
<small>If a buyer signs up then an affiliate gets % commission from all orders of the buyer.</small><br>
<input type="text" name="buyer" style="width:100px;margin-top:3px;" value="<?php echo $pvs_global_settings["buyer_commission"] ?>">
</div>

<div class="admin_field">
<b>Seller signup commission:</b><br>
<small>If a seller signs up then an affiliate gets % commission from all sells of the seller.</small><br>
<input type="text" name="seller" style="width:100px;margin-top:3px;" value="<?php echo $pvs_global_settings["seller_commission"] ?>">
</div>

<div class="admin_field">
<b>Change the commission rates for the existed affiliates?</b><br>
<select name="addto" style="width:70px">
	<option value="0">No</option>
	<option value="1">Yes</option>
</select>
</div>

<div class="admin_field">
<input type="submit" class="btn btn-primary" value="<?php echo pvs_word_lang( "save" )?>">
</div>
</form>

</div>

<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>