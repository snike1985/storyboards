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
?>
	<html>
	<head>
	<title><?php echo pvs_word_lang( "invoice" )?> <?php echo $pvs_global_settings["invoice_prefix"] ?><?php echo @$_GET["id"] ?></title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
	</head>
	<body>
	<?php
	$invoice_content = '';
	include ( PVS_PATH . "includes/admin/invoices/invoice_content.php" );
	echo ( $invoice_content );?>
	</body>
	</html>
<?php
}
?>