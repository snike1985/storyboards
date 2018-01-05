<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}


include ( "profile_top.php" );

$flag = false;
$refund = false;

$sql = "select order_id,order_type,refund from " . PVS_DB_PREFIX .
	"invoices where invoice_number=" . ( int )@$_GET["id"] . " and status=1";
$rs->open( $sql );
if ( ! $rs->eof ) {
	if ( $rs->row["refund"] == 1 ) {
		$refund = true;
	}

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

if ( $flag == true ) {
?>
	<a href="<?php echo (site_url( ) );?>/invoice-html/?id=<?php echo ( int )@$_GET["id"] ?>" target="blank" class="btn btn-success pull-right" style="color:#FFFFFF;text-decoration:none"><i class="fa fa-file-text"> </i>
			  <?php echo pvs_word_lang( "download" )?> HTML</a>
			<a href="<?php echo (site_url( ) );?>/invoice-pdf/?id=<?php echo ( int )@$_GET["id"] ?>" target="blank" class="btn btn-danger pull-right" style="margin-right: 5px;color:#FFFFFF;text-decoration:none"><i class="fa fa-file-pdf-o"> </i>
			 <?php echo pvs_word_lang( "download" )?> PDF</a>

	<?php
	if ( $refund ) {
?>
		<h1><?php echo pvs_word_lang( "Credit notes" )?> #<?php echo $pvs_global_settings["credit_notes_prefix"] ?><?php echo ( int )@$_GET["id"] ?></h1>
		<?php
	} else {
?>
		<h1><?php echo pvs_word_lang( "Invoice" )?> #<?php echo $pvs_global_settings["invoice_prefix"] ?><?php echo ( int )@$_GET["id"] ?></h1>
		<?php
	}
?>
	





<?php
	$invoice_content = '';
	include ( PVS_PATH . "includes/admin/invoices/invoice_content.php" );
	echo ( $invoice_content );
}
?>






<?php
include ( "profile_bottom.php" );
?>