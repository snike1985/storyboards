<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

$flag = false;

$sql = "select order_id,order_type from " . PVS_DB_PREFIX .
	"invoices where invoice_number=" . ( int )@$_GET["id"] . " and status=1";
$rs->open( $sql );
if ( ! $rs->eof ) {
	if ( $rs->row["order_type"] == "orders" ) {
		$sql = "select id from " . PVS_DB_PREFIX . "orders where id=" . $rs->row["order_id"] .
			" and user=" . get_current_user_id();
		$ds->open( $sql );
		if ( ! $ds->eof ) {
			$flag = true;
		}
	}
	if ( $rs->row["order_type"] == "credits" ) {
		$sql = "select id_parent from " . PVS_DB_PREFIX .
			"credits_list where id_parent=" . $rs->row["order_id"] . " and user='" .
			pvs_result( pvs_get_user_login () ) . "'";
		$ds->open( $sql );
		if ( ! $ds->eof ) {
			$flag = true;
		}
	}
	if ( $rs->row["order_type"] == "subscription" ) {
		$sql = "select id_parent from " . PVS_DB_PREFIX .
			"subscription_list where id_parent=" . $rs->row["order_id"] . " and user='" .
			pvs_result( pvs_get_user_login () ) . "'";
		$ds->open( $sql );
		if ( ! $ds->eof ) {
			$flag = true;
		}
	}
}

if (pvs_is_user_admin ()) {
	$flag = true;
}

if ( $flag == true ) {
	$invoice_content = '';
	include ( PVS_PATH . "includes/admin/invoices/invoice_content.php" );

	define( '_MPDF_URI', pvs_plugins_url() . '/includes/plugins/mpdf/' );
	define( '_MPDF_PATH', PVS_PATH . 'includes/plugins/mpdf/' );

	require_once PVS_PATH . 'includes/plugins/mpdf/mpdf.php';

	$mpdf = new mPDF( 'utf-8', 'A4', '0', '', 5, 5, 5, 0, 0, 0 );

	$stylesheet = "body,p,div,td{font:14px Arial}";

	$mpdf->CSSselectMedia = 'pdf';
	$mpdf->WriteHTML( $stylesheet, 1 );
	$mpdf->list_indent_first_level = 1;

	$mpdf->WriteHTML( $invoice_content, 2 );

	$mpdf->Output( 'invoice-' . ( int )@$_GET["id"] . '.pdf', 'I' );
}
?>


