<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "orders_commission" );




$url = pvs_plugins_admin_url('commission/index.php') . "&action=refund_send&d=2";
include ( "payout_content.php" );

?>


