<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

pvs_show_payment_page( 'header' );

if ( $pvs_global_settings["clickbank_active"] ) {
		$aproduct = 0;

		if ( $_POST["tip"] == "credits" ) {
			$sql = "select * from " . PVS_DB_PREFIX . "gateway_clickbank where credits=" . ( int )
				$_POST["credits"];
			$ds->open( $sql );
			if ( ! $ds->eof )
			{
				$aproduct = $ds->row["product_id"];
			}
		}

		if ( $_POST["tip"] == "subscription" ) {
			$sql = "select * from " . PVS_DB_PREFIX .
				"gateway_clickbank where subscription=" . ( int )$_POST["subscription"];
			$ds->open( $sql );
			if ( ! $ds->eof )
			{
				$aproduct = $ds->row["product_id"];
			}
		}
?>
<script language=javascript>function oo(){location.href='http://www.clickbank.net/sell.cgi?link=<?php echo $pvs_global_settings["clickbank_account"]
?>/<?php echo $aproduct
?>/credit&seed=<?php echo $product_type
?>-<?php echo $product_id
?>';}oo();</script>
<?php
}

pvs_show_payment_page( 'footer' );
?>