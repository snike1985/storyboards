<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}


$payment_type = preg_replace( '/[^a-z0-9]/i', "", @$_REQUEST["payment"] );

if ( ! isset ($pvs_payments[$payment_type]) )
{
	exit();
}

include ( PVS_PATH. "includes/payments/" . $payment_type . "/notification.php" );
?>
