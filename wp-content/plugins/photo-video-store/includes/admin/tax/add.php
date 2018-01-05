<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_tax" );

$id = 0;

$enabled = 0;
$price_include = 0;
$files = 0;
$credits = 0;
$subscription = 0;
$prints = 0;

if ( isset( $_POST["enabled"] ) )
{
	$enabled = 1;
}
if ( isset( $_POST["price_include"] ) )
{
	$price_include = 1;
}
if ( isset( $_POST["files"] ) )
{
	$files = 1;
}
if ( isset( $_POST["credits"] ) )
{
	$credits = 1;
}
if ( isset( $_POST["subscription"] ) )
{
	$subscription = 1;
}
if ( isset( $_POST["prints"] ) )
{
	$prints = 1;
}

if ( isset( $_REQUEST["id"] ) )
{
	$sql = "update " . PVS_DB_PREFIX . "tax set title='" . pvs_result( $_POST["title"] ) .
		"',rates_depend=" . ( int )$_POST["rates_depend"] . ",price_include=" . $price_include .
		",rate_all=" . ( float )$_POST["rate_all"] . ",rate_all_type=" . ( int )$_POST["rate_all_type"] .
		",enabled=" . $enabled . ",regions=" . ( int )$_POST["regions"] . ",files=" . $files .
		",credits=" . $credits . ",subscription=" . $subscription . ",prints=" . $prints .
		",customer=" . ( int )$_POST["customer"] . "  where id=" . ( int )$_REQUEST["id"];
	$db->execute( $sql );

	$id = ( int )$_REQUEST["id"];
} else
{
	$sql = "insert into " . PVS_DB_PREFIX .
		"tax (title,rates_depend,price_include,rate_all,rate_all_type,enabled,regions,files,credits,subscription,customer,prints) values ('" .
		pvs_result( $_POST["title"] ) . "'," . ( int )$_POST["rates_depend"] . "," . $price_include .
		"," . ( float )$_POST["rate_all"] . "," . ( int )$_POST["rate_all_type"] . "," .
		$enabled . "," . ( int )$_POST["regions"] . "," . $files . "," . $credits . "," .
		$subscription . "," . ( int )$_POST["customer"] . "," . $prints . ")";
	$db->execute( $sql );

	$sql = "select id from " . PVS_DB_PREFIX . "tax where title='" . pvs_result( $_POST["title"] ) .
		"' order by id desc";
	$rs->open( $sql );
	$id = $rs->row["id"];
}

//Add regions
if ( $id != 0 )
{
	$sql = "delete from " . PVS_DB_PREFIX . "tax_regions where id_parent=" . $id;
	$db->execute( $sql );

	if ( $_POST["regions"] == 1 )
	{
		$j = 0;
		$sql = "select name,id from " . PVS_DB_PREFIX .
			"countries where activ=1 order by priority,name";
		$dd->open( $sql );
		while ( ! $dd->eof )
		{
			if ( isset( $_POST["country" . $dd->row["id"]] ) )
			{
				$sql = "insert into " . PVS_DB_PREFIX .
					"tax_regions (id_parent,country,state) values (" . $id . ",'" . $dd->row["name"] .
					"','')";
				$db->execute( $sql );
			}

			if ( isset( $mstates[$dd->row["name"]] ) )
			{
				foreach ( $mstates[$dd->row["name"]] as $key => $value )
				{
					if ( isset( $_POST["state" . $j] ) )
					{
						$sql = "insert into " . PVS_DB_PREFIX .
							"tax_regions (id_parent,country,state) values (" . $id . ",'" . $dd->row["name"] .
							"','" . $value . "')";
						$db->execute( $sql );
					}

					$j++;
				}
			}
			$dd->movenext();
		}
	}
}
?>