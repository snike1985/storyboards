<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "prints_types" );

$id = 0;

$quantity = ( int )$_POST["quantity"];
if ( $_POST["quantity_type"] == -1 )
{
	$quantity = -1;
}

if ( isset( $_GET["id"] ) )
{
	$sql = "update " . PVS_DB_PREFIX . "prints set title='" . pvs_result( $_POST["title"] ) .
		"',description='" . pvs_result( $_POST["description"] ) . "',price=" . ( float )
		$_POST["price"] . ",priority=" . ( int )$_POST["priority"] . ",weight=" . ( float )
		$_POST["weight"] . ",option1=" . ( int )$_POST["option1"] . ",option2=" . ( int )
		$_POST["option2"] . ",option3=" . ( int )$_POST["option3"] . ",option4=" . ( int )
		$_POST["option4"] . ",option5=" . ( int )$_POST["option5"] . ",option6=" . ( int )
		$_POST["option6"] . ",option7=" . ( int )$_POST["option7"] . ",option8=" . ( int )
		$_POST["option8"] . ",option9=" . ( int )$_POST["option9"] . ",option10=" . ( int )
		$_POST["option10"] . ",photo=" . ( int )@$_POST["photo"] . ",printslab=" . ( int )
		@$_POST["printslab"] . ",category=" . ( int )$_POST["category"] . ",preview=" . ( int )
		$_POST["preview"] . ",resize=" . ( int )@$_POST["resize"] . ",option1_value='" .
		pvs_result( $_POST["option_value1"] ) . "',option2_value='" . pvs_result( $_POST["option_value2"] ) .
		"',option3_value='" . pvs_result( $_POST["option_value3"] ) .
		"',option4_value='" . pvs_result( $_POST["option_value4"] ) .
		"',option5_value='" . pvs_result( $_POST["option_value5"] ) .
		"',option6_value='" . pvs_result( $_POST["option_value6"] ) .
		"',option7_value='" . pvs_result( $_POST["option_value7"] ) .
		"',option8_value='" . pvs_result( $_POST["option_value8"] ) .
		"',option9_value='" . pvs_result( $_POST["option_value9"] ) .
		"',option10_value='" . pvs_result( $_POST["option_value10"] ) . "',resize_min=" . ( int )
		$_POST["resize_min"] . ",resize_max=" . ( int )$_POST["resize_max"] .
		",resize_value=" . ( int )$_POST["resize_value"] . ", in_stock=" . $quantity .
		" where id_parent=" . ( int )$_GET["id"];
	$db->execute( $sql );

	$id = ( int )$_GET["id"];
} else
{
	$sql = "insert into " . PVS_DB_PREFIX .
		"prints (title,description,price,priority,weight,option1,option2,option3,option4,option5,option6,option7,option8,option9,option10,photo,printslab,category,preview,resize,option1_value,option2_value,option3_value,option4_value,option5_value,option6_value,option7_value,option8_value,option9_value,option10_value,resize_min,resize_max,resize_value,in_stock) values ('" .
		pvs_result( $_POST["title"] ) . "','" . pvs_result( $_POST["description"] ) .
		"'," . ( float )$_POST["price"] . "," . ( int )$_POST["priority"] . "," . ( float )
		$_POST["weight"] . "," . ( int )$_POST["option1"] . "," . ( int )$_POST["option2"] .
		"," . ( int )$_POST["option3"] . "," . ( int )$_POST["option4"] . "," . ( int )
		$_POST["option5"] . "," . ( int )$_POST["option6"] . "," . ( int )$_POST["option7"] .
		"," . ( int )$_POST["option8"] . "," . ( int )$_POST["option9"] . "," . ( int )
		$_POST["option10"] . "," . ( int )@$_POST["photo"] . "," . ( int )@$_POST["printslab"] .
		"," . ( int )$_POST["category"] . "," . ( int )$_POST["preview"] . "," . ( int )
		@$_POST["resize"] . ",'" . pvs_result( $_POST["option_value1"] ) . "','" .
		pvs_result( $_POST["option_value2"] ) . "','" . pvs_result( $_POST["option_value3"] ) .
		"','" . pvs_result( $_POST["option_value4"] ) . "','" . pvs_result( $_POST["option_value5"] ) .
		"','" . pvs_result( $_POST["option_value6"] ) . "','" . pvs_result( $_POST["option_value7"] ) .
		"','" . pvs_result( $_POST["option_value8"] ) . "','" . pvs_result( $_POST["option_value9"] ) .
		"','" . pvs_result( $_POST["option_value10"] ) . "'," . ( int )$_POST["resize_min"] .
		"," . ( int )$_POST["resize_max"] . "," . ( int )$_POST["resize_value"] . "," .
		$quantity . ")";
	$db->execute( $sql );

	$sql = "select id_parent from " . PVS_DB_PREFIX . "prints where title='" .
		pvs_result( $_POST["title"] ) . "' order by id_parent desc";
	$rs->open( $sql );
	if ( ! $rs->eof )
	{
		$id = $rs->row["id_parent"];
	}
}

//Upload photos
if ( $id != 0 )
{
	for ( $i = 1; $i < 6; $i++ )
	{
		$_FILES["photo" . $i]['name'] = pvs_result_file( $_FILES["photo" . $i]['name'] );
		if ( $_FILES["photo" . $i]['size'] > 0 )
		{
			if ( preg_match( "/jpg$/i", $_FILES["photo" . $i]['name'] ) and ! preg_match( "/text/i",
				$_FILES["photo" . $i]['type'] ) )
			{
				$img1 = pvs_upload_dir() . "/content/prints/product" . $id . "_" . $i .
					"_small.jpg";
				$img2 = pvs_upload_dir() . "/content/prints/product" . $id . "_" . $i .
					"_big.jpg";

				move_uploaded_file( $_FILES["photo" . $i]['tmp_name'], $img2 );

				pvs_easyResize( $img2, $img1, 100, $pvs_global_settings["thumb_width"] );
				pvs_easyResize( $img2, $img2, 100, $pvs_global_settings["thumb_width2"] );
			}
		}
	}
}
?>
