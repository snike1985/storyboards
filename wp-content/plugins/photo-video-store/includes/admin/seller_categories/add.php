<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_documents" );

$category = 0;
$upload1 = 0;
$upload2 = 0;
$upload3 = 0;
$upload4 = 0;
$menu = 0;
$blog = 0;

if ( isset( $_POST["category"] ) )
{
	$category = 1;
}
if ( isset( $_POST["upload"] ) )
{
	$upload1 = 1;
}
if ( isset( $_POST["upload2"] ) )
{
	$upload2 = 1;
}
if ( isset( $_POST["upload3"] ) )
{
	$upload3 = 1;
}
if ( isset( $_POST["upload4"] ) )
{
	$upload4 = 1;
}
if ( isset( $_POST["menu"] ) )
{
	$menu = 1;
}
if ( isset( $_POST["blog"] ) )
{
	$blog = 1;
}

//If the category is new
if ( isset( $_GET["id"] ) and ( int )$_GET["id"] != 0 )
{
	$sql = "select id_parent,name from " . PVS_DB_PREFIX .
		"user_category where id_parent=" . ( int )$_GET["id"];
	$rs->open( $sql );
	if ( ! $rs->eof )
	{
		if ( pvs_result( $_POST["name"] ) != $rs->row["name"] )
		{
			$sql="select ID from " . $table_prefix . "users";
			$ds->open($sql);
			while(!$ds->eof)
			{
				$user_info = get_userdata(get_current_user_id());
				
				if ($user_info->category == $rs->row["name"]) {
					update_user_meta( $ds->row["ID"], 'category', pvs_result( $_POST["name"] ));
				}
		
				$ds->movenext();
			}
		}
	}

	$sql = "update " . PVS_DB_PREFIX . "user_category set name='" . pvs_result( $_POST["name"] ) .
		"',priority=" . ( int )$_POST["priority"] . ",category=" . $category .
		",upload=" . $upload1 . ",upload2=" . $upload2 . ",upload3=" . $upload3 .
		",upload4=" . $upload4 . ",menu=" . $menu . ",blog=" . $blog . ",percentage=" . ( float )
		$_POST["percentage"] . ",percentage_prints=" . ( float )$_POST["percentage_prints"] .
		",percentage_subscription=" . ( float )$_POST["percentage_subscription"] .
		",percentage_type=" . ( int )$_POST["percentage_type"] .
		",percentage_prints_type=" . ( int )$_POST["percentage_prints_type"] .
		",percentage_subscription_type=" . ( int )$_POST["percentage_subscription_type"] .
		",photolimit=" . ( int )$_POST["photolimit"] . ",videolimit=" . ( int )$_POST["videolimit"] .
		",previewvideolimit=" . ( int )$_POST["previewvideolimit"] . ",audiolimit=" . ( int )
		$_POST["audiolimit"] . ",previewaudiolimit=" . ( int )$_POST["previewaudiolimit"] .
		",vectorlimit=" . ( int )$_POST["vectorlimit"] . " where id_parent=" . ( int )$_GET["id"];
	$db->execute( $sql );
} else
{
	$sql = "insert into " . PVS_DB_PREFIX .
		"user_category (name,priority,category,upload,upload2,upload3,upload4,menu,blog,percentage,percentage_prints,percentage_subscription,percentage_type,percentage_prints_type,percentage_subscription_type,photolimit,videolimit,previewvideolimit,audiolimit,previewaudiolimit,vectorlimit) values ('" .
		pvs_result( $_POST["name"] ) . "'," . ( int )$_POST["priority"] . "," . $category .
		"," . $upload1 . "," . $upload2 . "," . $upload3 . "," . $upload4 . "," . $menu .
		"," . $blog . "," . ( float )$_POST["percentage"] . "," . ( float )$_POST["percentage_prints"] .
		"," . ( float )$_POST["percentage_subscription"] . "," . ( int )$_POST["percentage_type"] .
		"," . ( int )$_POST["percentage_prints_type"] . "," . ( int )$_POST["percentage_subscription_type"] .
		"," . ( int )$_POST["photolimit"] . "," . ( int )$_POST["videolimit"] . "," . ( int )
		$_POST["previewvideolimit"] . "," . ( int )$_POST["audiolimit"] . "," . ( int )
		$_POST["previewaudiolimit"] . "," . ( int )$_POST["vectorlimit"] . ")";
	$db->execute( $sql );
}
?>