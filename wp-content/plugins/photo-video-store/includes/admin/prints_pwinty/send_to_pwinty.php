<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "prints_pwinty" );

//Define necessary prints ids
$prints_mas = array();
$sql = "select print_id from " . PVS_DB_PREFIX . "pwinty_prints where activ=1";
$ds->open( $sql );
while ( ! $ds->eof )
{
	$prints_mas[] = $ds->row["print_id"];
	$ds->movenext();
}
//End. Define necessary prints ids

$sql = "select * from " . PVS_DB_PREFIX . "pwinty";
$rs->open( $sql );
if ( ! $rs->eof )
{
	define( "PWINTY_MERCHANTID", $rs->row["account"] );
	define( "PWINTY_APIKEY", $rs->row["password"] );
	if ( $rs->row["testmode"] == 1 )
	{
		define( "PWINTY_API", "sandbox" );
	} else
	{
		define( "PWINTY_API", "production" );
	}

	$usetrackedshipping = $rs->row["usetrackedshipping"];
	$payment = $rs->row["payment"];
	$qualitylevel = $rs->row["qualitylevel"];
	$photoresizing = $rs->row["photoresizing"];
} else
{
	exit();
}

include ( PVS_PATH . "includes/plugins/pwinty/PHPPwinty.php" );

$pwinty = new PHPPwinty();

for ( $i = 0; $i < count( $pwinty_ids ); $i++ )
{
	$sql = "select id,user,shipping_firstname,shipping_lastname,shipping_address,shipping_country,shipping_city,shipping_zip,shipping_state from " .
		PVS_DB_PREFIX . "orders where id=" . ( int )$pwinty_ids[$i] . " and status=1";
	$rs->open( $sql );
	if ( ! $rs->eof )
	{
		// create the order
		$name = $rs->row["shipping_firstname"] . " " . $rs->row["shipping_lastname"];
		$adr1 = "";
		$adr2 = "";
		$adr = explode( "\n", $rs->row["shipping_address"] );
		$adr1 = $adr[0];
		if ( isset( $adr[1] ) )
		{
			$adr2 = $adr[1];
		}

		$text = "Order ID" . $pwinty_ids[$i];

		$order = $pwinty->createOrder( $name, $adr1, $adr2, $rs->row["shipping_city"], $rs->
			row["shipping_state"], $rs->row["shipping_zip"], @$mcountry_code[$rs->row["shipping_country"]],
			@$mcountry_code[$rs->row["shipping_country"]], $usetrackedshipping, $payment, $qualitylevel );

		$sql = "select item,price,quantity,option1_id,option1_value,option2_id,option2_value,option3_id,option3_value,printslab,printslab_id,prints from " .
			PVS_DB_PREFIX . "orders_content where prints=1 and id_parent=" . ( int )$pwinty_ids[$i];
		$ds->open( $sql );
		while ( ! $ds->eof )
		{
			if ( $ds->row["prints"] == 1 )
			{
				if ( $ds->row["printslab"] != 1 )
				{
					$sql = "select printsid,itemid,title from " . PVS_DB_PREFIX .
						"prints_items where id_parent=" . $ds->row["item"];
					$dr->open( $sql );
					if ( ! $dr->eof and in_array( $dr->row["printsid"], $prints_mas ) )
					{
						$title = $dr->row["title"];
						$sql = "select title from " . PVS_DB_PREFIX . "pwinty_prints where print_id=" .
							$dr->row["printsid"];
						$dn->open( $sql );
						if ( ! $dn->eof )
						{
							$title = $dn->row["title"];
						}

						$url = "";
						$flag_storage = false;

						$sql = "select url,filename2,filename1,width,height,item_id from " .
							PVS_DB_PREFIX . "filestorage_files where id_parent=" . $dr->row["itemid"];
						$dn->open( $sql );
						while ( ! $dn->eof )
						{
							if ( $dn->row["item_id"] != 0 )
							{
								$url = $dn->row["url"] . "/" . $dn->row["filename2"];
							}

							$flag_storage = true;
							$dn->movenext();
						}

						if ( ! $flag_storage )
						{
							$sql = "select server1 from " . PVS_DB_PREFIX . "media where media_id=1 and id=" . $dr->
								row["itemid"];
							$dd->open( $sql );
							if ( ! $dd->eof )
							{
								$sql = "select url from " . PVS_DB_PREFIX . "items where id_parent=" . $dr->row["itemid"];
								$dn->open( $sql );
								if ( ! $dn->eof )
								{
									$afile = $dn->row["url"];
								} else
								{
									$dir = opendir( pvs_upload_dir() . pvs_server_url( $dd->row["server1"] ) . "/" . $dr->
										row["itemid"] );
									while ( $file = readdir( $dir ) )
									{
										if ( $file <> "." && $file <> ".." )
										{
											if ( preg_match( "/.jpg$|.jpeg$/i", $file ) and ! preg_match( "/thumb/", $file ) and
												! preg_match( "/photo_[0-9]+/", $file ) )
											{
												$afile = $file;
											}
										}
									}
									closedir( $dir );
								}

								if ( $afile != "" )
								{
									$url = pvs_upload_dir() . pvs_server_url( $dd->row["server1"] ) .
										"/" . $dr->row["itemid"] . "/" . $afile;
								}
							}
						}

						if ( $url != "" )
						{
							if ( ! $flag_storage )
							{
								$new_url = "/content/pwinty/" . $rs->row["id"] . "_" . md5( pvs_get_time
									( date( "H" ), date( "i" ), date( "s" ), date( "m" ), date( "d" ), date( "Y" ) ) ) .
									".jpg";
								copy( $url, pvs_upload_dir() . $new_url );
								$url = pvs_upload_dir('baseurl') . $new_url;
							}
							$pwinty->addPhoto( $order, $title, $url, $ds->row["quantity"], $photoresizing, $ds->
								row["price"] * 100, "", "" );

						}
					}
				} else
				{
					if ( in_array( $ds->row["item"], $prints_mas ) )
					{
						$title = "";
						$url = "";
						$sql = "select id,title,id_parent,photo from " . PVS_DB_PREFIX .
							"galleries_photos where id=" . $ds->row["printslab_id"];
						$dn->open( $sql );
						if ( ! $dn->eof )
						{
							$url = pvs_upload_dir('baseurl') . "/content/galleries/" . $dn->row["id_parent"] . "/" .
								$dn->row["photo"];
						}

						$sql = "select title from " . PVS_DB_PREFIX . "pwinty_prints where print_id=" .
							$ds->row["item"];
						$dn->open( $sql );
						if ( ! $dn->eof )
						{
							$title = $dn->row["title"];
						}

						if ( $url != "" )
						{
							$pwinty->addPhoto( $order, $title, $url, $ds->row["quantity"], $photoresizing, $ds->
								row["price"] * 100, "", "" );

						}
					}
				}
			}

			$ds->movenext();
		}

		$sql = "insert " . PVS_DB_PREFIX .
			"pwinty_orders (order_id,pwinty_id,data) values (" . $rs->row["id"] . "," . $order .
			"," . pvs_get_time( date( "H" ), date( "i" ), date( "s" ), date( "m" ), date( "d" ),
			date( "Y" ) ) . ")";
		$db->execute( $sql );

		// view the order, make sure it's all there
		$order_details = $pwinty->getOrder( $order );
		//print_r($order_details);

		// submit the order
		$pwinty->updateOrderStatus( $order, "Submitted" );
	}
}
?>