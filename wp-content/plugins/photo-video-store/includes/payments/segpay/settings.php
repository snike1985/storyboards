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
	pvs_update_setting('segpay_active', (int) @ $_POST["active"] );
	pvs_update_setting('segpay_ipn', (int) @ $_POST["ipn"] );
	
	//Update settings
	pvs_get_settings();
}

if ( @$_REQUEST["action"] == 'change2' )
{
	$sql = "select * from " . PVS_DB_PREFIX .
		"gateway_segpay";
	$rs->open( $sql );
	while ( ! $rs->eof ) {
	
		if ( isset( $_POST["product" . $rs->row["subscription"] . "_" . $rs->row["credits"]] ) ) {
			$sql = "update " . PVS_DB_PREFIX . "gateway_segpay set package_id='" .
			pvs_result( $_POST["package" . $rs->row["subscription"] . "_" . $rs->row["credits"]] ) .
			"',product_id='" .
				pvs_result( $_POST["product" . $rs->row["subscription"] . "_" . $rs->row["credits"]] ) .
				"' where subscription=" . $rs->row["subscription"] . " and credits=" . $rs->row["credits"];
			$db->execute( $sql );
		}
	
		$rs->movenext();
	}
}
?>

<ul>
<li>Segpay may be used only for <b>subscription or credits</b> payments. 
<li>You should create Package IDs and Product IDs at https://my.segpay.com/ (Create Packages -> Price Points) for each  your subscription and credits plans.


<li> Enter Post Back<br>
<b>2nd Trans Post URL:</b> <?php echo (site_url( ) );?>/payment-notification/?payment=segpay&product_id=< extra product_id >&product_type=< extra product_type >&approved=< approved >&trans_id=< tranid >
?>

</ul>


<form method="post">
<input type="hidden" name="d" value="<?php echo($_GET["d"]);?>">
<input type="hidden" name="action" value="change">



<div class='admin_field'>
<span><?php echo pvs_word_lang( "enable" )?>:</span>
<input type='checkbox' name='active' value="1" <?php
	if ( $pvs_global_settings["segpay_active"] == 1 ) {
		echo ( "checked" );
	}
?>>
</div>

<div class='admin_field'>
<span><?php echo pvs_word_lang( "allow ipn" )?>:</span>
<input type='checkbox' name='ipn' value="1" <?php
	if ( $pvs_global_settings["segpay_ipn"] == 1 ) {
		echo ( "checked" );
	}
?>>
</div>

<div class='admin_field'>
<input type="submit" class="btn btn-primary" value="<?php echo pvs_word_lang( "save" )?>">
</div>
</form>


<br>

<form method="post">
<input type="hidden" name="d" value="<?php echo($_GET["d"]);?>">
<input type="hidden" name="action" value="change2">
<table class="wp-list-table widefat fixed striped posts">
<thead>
<tr valign="top">
<th><b><?php echo pvs_word_lang( "subscription" )?>/<?php echo pvs_word_lang( "credits" )?>:</b></th>
<th><b><?php echo pvs_word_lang( "price" )?></b></th>
<th><b>Package ID</b></th>
<th><b>Product ID</b></th>
<th><b>Test</b></th>
</tr>
</thead>
<?php
$ids = " credits=0 and subscription<>0 ";
$sql = "select * from " . PVS_DB_PREFIX . "subscription order by priority";
$rs->open( $sql );
while ( ! $rs->eof ) {
	$sql = "select * from " . PVS_DB_PREFIX .
		"gateway_segpay where subscription=" . $rs->row["id_parent"];
	$ds->open( $sql );
	if ( $ds->eof ) {
		$sql = "insert into " . PVS_DB_PREFIX .
			"gateway_segpay (package_id,product_id,subscription,credits) values (0,0," .
			$rs->row["id_parent"] . ",0)";
		$db->execute( $sql );
	}

	$sql = "select * from " . PVS_DB_PREFIX .
		"gateway_segpay where subscription=" . $rs->row["id_parent"];
	$ds->open( $sql );
	if ( ! $ds->eof ) {
		$ids .= " and subscription<>" . $rs->row["id_parent"];
?>
		<tr>
		<td><?php echo $rs->row["title"] ?></td>
		<td><?php echo pvs_currency( 1, false )?><?php echo pvs_price_format( $rs->row["price"], 2 )?> <?php echo pvs_currency( 2, false )?></td>
		<td><input type="text" name="package<?php echo $rs->row["id_parent"] ?>_0" style="width:80px" value="<?php echo $ds->row["package_id"] ?>"></td>
		<td><input type="text" name="product<?php echo $rs->row["id_parent"] ?>_0" style="width:80px" value="<?php echo $ds->row["product_id"] ?>"></td>
		<td><input type="button" class="btn" onclick="location.href='https://secure2.segpay.com/billing/poset.cgi?x-eticketid=<?php echo $ds->row["package_id"] ?>:<?php echo $ds->row["product_id"] ?>'" value="<?php echo pvs_word_lang( "buy" )?>"></td>
		</tr>
		<?php
	}
	$rs->movenext();
}
$sql = "delete from " . PVS_DB_PREFIX . "gateway_segpay where " . $ids;
$db->execute( $sql );

if ( $pvs_global_settings["credits"] ) {
	$ids = " credits<>0 and subscription=0 ";
	$sql = "select * from " . PVS_DB_PREFIX . "credits order by priority";
	$rs->open( $sql );
	while ( ! $rs->eof ) {
		$sql = "select * from " . PVS_DB_PREFIX . "gateway_segpay where credits=" . $rs->
			row["id_parent"];
		$ds->open( $sql );
		if ( $ds->eof ) {
			$sql = "insert into " . PVS_DB_PREFIX .
				"gateway_segpay (package_id,product_id,subscription,credits) values (0,0,0," .
				$rs->row["id_parent"] . ")";
			$db->execute( $sql );
		}

		$sql = "select * from " . PVS_DB_PREFIX . "gateway_segpay where credits=" . $rs->
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
			<td><input type="text" name="package0_<?php
			echo $rs->row["id_parent"] ?>" style="width:80px" value="<?php
			echo $ds->row["package_id"] ?>"></td>
			<td><input type="text" name="product0_<?php
			echo $rs->row["id_parent"] ?>" style="width:80px" value="<?php
			echo $ds->row["product_id"] ?>"></td>
			<td><input type="button" class="btn" onclick="location.href='https://secure2.segpay.com/billing/poset.cgi?x-eticketid=<?php echo $ds->row["package_id"] ?>:<?php echo $ds->row["product_id"] ?>'" value="<?php echo pvs_word_lang( "buy" )?>"></td>
			</tr>
			<?php
		}
		$rs->movenext();
	}
	$sql = "delete from " . PVS_DB_PREFIX . "gateway_segpay where " . $ids;
	$db->execute( $sql );
}
?>

</table>

<input type="submit" class="btn btn-primary" value="<?php echo pvs_word_lang( "save" )?>" style="margin:3px 0px 0px 6px">
</form>