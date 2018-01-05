<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_payout" );

pvs_update_setting('payout_price', ( float )$_POST["price"]);
?>