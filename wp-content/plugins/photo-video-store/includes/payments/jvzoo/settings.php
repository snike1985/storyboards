<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "settings_payments" );

if ( @$_REQUEST["action"] == 'change' )
{
	pvs_update_setting('jvzoo_account', pvs_result( $_POST["account"] ));
	pvs_update_setting('jvzoo_password', pvs_result( $_POST["password"] ));
	pvs_update_setting('jvzoo_active', (int) @ $_POST["active"] );
	
	//Update settings
	pvs_get_settings();
}

if ( @$_REQUEST["action"] == 'change2' )
{
	$sql = "select * from " . PVS_DB_PREFIX .
		"gateway_jvzoo";
	$rs->open( $sql );
	while ( ! $rs->eof ) {
	
		if ( isset( $_POST["product" . $rs->row["subscription"] . "_" . $rs->row["credits"]] ) ) {
			$sql = "update " . PVS_DB_PREFIX . "gateway_jvzoo set product_id='" .
				pvs_result( $_POST["product" . $rs->row["subscription"] . "_" . $rs->row["credits"]] ) .
				"' where subscription=" . $rs->row["subscription"] . " and credits=" . $rs->row["credits"];
			$db->execute( $sql );
		}
	
		$rs->movenext();
	}
}
?>




<form method="post">
<input type="hidden" name="d" value="<?php echo($_GET["d"]);?>">
<input type="hidden" name="action" value="change">

<div class='admin_field'>
<span><?php echo pvs_word_lang( "account" )?>:</span>
<input type='text' name='account'  style="width:400px" value="<?php echo $pvs_global_settings["jvzoo_account"] ?>">
</div>

<div class='admin_field'>
<span>JVZIPN Secret Key:</span>
<input type='text' name='password'  style="width:400px" value="<?php echo $pvs_global_settings["jvzoo_password"] ?>">
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "enable" )?>:</span>
<input type='checkbox' name='active' value="1" <?php
	if ( $pvs_global_settings["jvzoo_active"] == 1 ) {
		echo ( "checked" );
	}
?>>
</div>



<div class='admin_field'>
<input type="submit" class="btn btn-primary" value="<?php echo pvs_word_lang( "save" )?>">
</div>
</form>


<br>
<h3>Landing page URL</h3> 

<p>Please place products code here or create other langing pages:<br><a href="<?php echo (site_url( ) );?>/payment/jvzoo/"><b><?php echo (site_url( ) );?>/payment/jvzoo/</b></a> (File: /wp-content/plugins/photo-video-store/includes/payments/jvzoo/payment.php)</p>
<br>
<h3>Products</h3>

<p>1. Create products in <b>Member area -> Sellers -> Sellers Dashboard -> Add a Product</b> at jvzoo.com</p>


<p>2. Set Instant Payment Notification URL for each product: EXTERNAL PROGRAM INTEGRATION -> Recommended: Method #1 -> JVZIPN URL:<br><a href="<?php echo (site_url( ) );?>/payment-notification/?payment=jvzoo"><b><?php echo (site_url( ) );?>/payment-notification/?payment=jvzoo</b></a></p>

<p>3. The products must correspond to your <b>Credits and Subscription plans</b>. Enter JVZoo Product IDs:</p>

<form method="post">
<input type="hidden" name="d" value="<?php echo($_GET["d"]);?>">
<input type="hidden" name="action" value="change2">
<table class="wp-list-table widefat fixed striped posts">
<thead>
<tr valign="top">
<th><b><?php echo pvs_word_lang( "subscription" )?>/<?php echo pvs_word_lang( "credits" )?>:</b></th>
<th><b><?php echo pvs_word_lang( "price" )?></b></th>
<th><b>JVZoo Product ID</b></th>
</tr>
</thead>
<?php
$ids = " credits=0 and subscription<>0 ";
$sql = "select * from " . PVS_DB_PREFIX . "subscription order by priority";
$rs->open( $sql );
while ( ! $rs->eof ) {
	$sql = "select * from " . PVS_DB_PREFIX .
		"gateway_jvzoo where subscription=" . $rs->row["id_parent"];
	$ds->open( $sql );
	if ( $ds->eof ) {
		$sql = "insert into " . PVS_DB_PREFIX .
			"gateway_jvzoo (product_id,subscription,credits) values (0," .
			$rs->row["id_parent"] . ",0)";
		$db->execute( $sql );
	}

	$sql = "select * from " . PVS_DB_PREFIX .
		"gateway_jvzoo where subscription=" . $rs->row["id_parent"];
	$ds->open( $sql );
	if ( ! $ds->eof ) {
		$ids .= " and subscription<>" . $rs->row["id_parent"];
?>
		<tr>
		<td><?php echo $rs->row["title"] ?></td>
		<td><?php echo pvs_currency( 1, false )?><?php echo pvs_price_format( $rs->row["price"], 2 )?> <?php echo pvs_currency( 2, false )?></td>
		<td><input type="text" name="product<?php echo $rs->row["id_parent"] ?>_0" style="width:80px" value="<?php echo $ds->row["product_id"] ?>"></td>
		</tr>
		<?php
	}
	$rs->movenext();
}
$sql = "delete from " . PVS_DB_PREFIX . "gateway_jvzoo where " . $ids;
$db->execute( $sql );

if ( $pvs_global_settings["credits"] ) {
	$ids = " credits<>0 and subscription=0 ";
	$sql = "select * from " . PVS_DB_PREFIX . "credits order by priority";
	$rs->open( $sql );
	while ( ! $rs->eof ) {
		$sql = "select * from " . PVS_DB_PREFIX . "gateway_jvzoo where credits=" . $rs->
			row["id_parent"];
		$ds->open( $sql );
		if ( $ds->eof ) {
			$sql = "insert into " . PVS_DB_PREFIX .
				"gateway_jvzoo (product_id,subscription,credits) values (0,0," .
				$rs->row["id_parent"] . ")";
			$db->execute( $sql );
		}

		$sql = "select * from " . PVS_DB_PREFIX . "gateway_jvzoo where credits=" . $rs->
			row["id_parent"];
		$ds->open( $sql );
		if ( ! $ds->eof ) {
			$ids .= " and credits<>" . $rs->row["id_parent"];
?>
			<tr>
			<td><?php
			echo $rs->row["title"] ?></td>
			<td><?php
			echo pvs_currency( 1, false )?><?php
			echo pvs_price_format( $rs->row["price"], 2 )?> <?php
			echo pvs_currency( 2, false )?></td>
			<td><input type="text" name="product0_<?php
			echo $rs->row["id_parent"] ?>" style="width:80px" value="<?php
			echo $ds->row["product_id"] ?>"></td>
			</tr>
			<?php
		}
		$rs->movenext();
	}
	$sql = "delete from " . PVS_DB_PREFIX . "gateway_jvzoo where " . $ids;
	$db->execute( $sql );
}
?>

</table>
<br><br>
<input type="submit" class="btn btn-primary" value="<?php echo pvs_word_lang( "save" )?>">
</form>