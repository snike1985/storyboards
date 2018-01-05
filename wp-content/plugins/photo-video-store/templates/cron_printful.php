<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

//The orders IDs must be sent to printful
$printful_ids = array();

//The cron works since the order number
$order_number = ( int )$pvs_global_settings["printful_order_id"];

//Define necessary orders ids
$sql = "select id from " . PVS_DB_PREFIX . "orders where status=1 and id>" . $order_number;
$rs->open( $sql );
while ( ! $rs->eof ) {
	$sql = "select order_id from " . PVS_DB_PREFIX .
		"printful_orders where order_id=" . $rs->row["id"];
	$ds->open( $sql );
	if ( $ds->eof ) {
		$printful_ids[] = $rs->row["id"];
	}

	$rs->movenext();
}
//End. The orders IDs must be sent to printful

include ( PVS_PATH . "includes/admin/prints_printful/send_to_printful.php" );?>
<p>The orders have been sent to printful prints service:</p>
<?php
for ( $i = 0; $i < count( $printful_ids ); $i++ ) {
	echo ( "ID=" . $printful_ids[$i] . "<br>" );
}

?>
