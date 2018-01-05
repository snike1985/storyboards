<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_checkout" );

$checkout_settings = array(
	'checkout_order_billing',
	'checkout_order_shipping',
	'checkout_credits_billing',
	'checkout_subscription_billing' );

for ( $i = 0; $i < count( $checkout_settings ); $i++ )
{
	pvs_update_setting($checkout_settings[$i], ( int )@$_POST[$checkout_settings[$i]]);
}
?>
