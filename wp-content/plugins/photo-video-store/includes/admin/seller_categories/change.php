<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_documents" );

$sql = "select id_parent,priority,name from " . PVS_DB_PREFIX .
	"user_category order by priority";
$rs->open( $sql );
while ( ! $rs->eof )
{
	if ( pvs_result( $_POST["title" . $rs->row["id_parent"]] ) != $rs->row["name"] )
	{
		$sql="select ID from " . $table_prefix . "users";
		$ds->open($sql);
		while(!$ds->eof)
		{
			$user_info = get_userdata(get_current_user_id());
			
			if ($user_info->category == $rs->row["name"]) {
				update_user_meta( $ds->row["ID"], 'category', pvs_result( $_POST["title" . $rs->row["id_parent"]] ));
			}
	
			$ds->movenext();
		}
	}

	$sql = "update " . PVS_DB_PREFIX . "user_category set name='" . pvs_result( $_POST["title" .
		$rs->row["id_parent"]] ) . "',priority=" . ( int )$_POST["priority" . $rs->row["id_parent"]] .
		",percentage=" . ( float )$_POST["percentage" . $rs->row["id_parent"]] .
		",percentage_prints=" . ( float )$_POST["percentage_prints" . $rs->row["id_parent"]] .
		",percentage_subscription=" . ( float )$_POST["percentage_subscription" . $rs->
		row["id_parent"]] . ",percentage_type=" . ( int )$_POST["percentage_type" . $rs->
		row["id_parent"]] . ",percentage_prints_type=" . ( int )$_POST["percentage_prints_type" .
		$rs->row["id_parent"]] . ",percentage_subscription_type=" . ( int )$_POST["percentage_subscription_type" .
		$rs->row["id_parent"]] . " where id_parent=" . $rs->row["id_parent"];
	$db->execute( $sql );
	$rs->movenext();
}
?>
