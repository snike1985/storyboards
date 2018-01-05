<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_subscription" );

pvs_update_setting('subscription_limit', pvs_result( $_POST["subscription_limit"] ) );
?>