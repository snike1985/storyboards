<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "affiliates_commission" );


$url = pvs_plugins_admin_url('affiliates/payout.php') . '&action=payout_send';
include ( plugin_dir_path( __FILE__ ) . "../commission/payout_content.php" );

?>


