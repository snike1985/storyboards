<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_licenses" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

//Change
if ( @$_REQUEST["action"] == 'change' )
{
	$sql = "select id_parent,priority,name from " . PVS_DB_PREFIX .
		"licenses order by priority";
	$rs->open( $sql );
	while ( ! $rs->eof )
	{
		$sql = "update " . PVS_DB_PREFIX . "licenses set name='" . pvs_result( $_POST["title" .
			$rs->row["id_parent"]] ) . "',priority=" . ( int )$_POST["priority" . $rs->row["id_parent"]] .
			" where id_parent=" . $rs->row["id_parent"];
		$db->execute( $sql );
		$rs->movenext();
	}
}

//Insert
if ( @$_REQUEST["action"] == 'insert' )
{
	//If the category is new
	if ( isset( $_GET["id"] ) and ( int )$_GET["id"] != 0 )
	{
		$sql = "update " . PVS_DB_PREFIX . "licenses set name='" . pvs_result( $_POST["name"] ) .
			"',priority=" . ( int )$_POST["priority"] . ",description='" . pvs_result( $_POST["description"] ) .
			"' where id_parent=" . ( int )$_GET["id"];
		$db->execute( $sql );
	} else
	{
		$sql = "insert into " . PVS_DB_PREFIX .
			"licenses (name,priority,description) values ('" . pvs_result( $_POST["name"] ) .
			"'," . ( int )$_POST["priority"] . ",'" . pvs_result( $_POST["description"] ) .
			"')";
		$db->execute( $sql );
	}
}

//Delete
if ( @$_REQUEST["action"] == 'delete' )
{
	$sql = "delete from " . PVS_DB_PREFIX . "licenses where id_parent=" . ( int )$_GET["id"];
	$db->execute( $sql );
}
?>




<?php
if ( @$_REQUEST['action'] != 'add' and @$_REQUEST['action'] != 'edit' )
{
?>
	<h1><?php
	echo pvs_word_lang( "License" )
?></h1>
	
	<a class="button button-secondary button-large alignright" href="<?php
	echo ( pvs_plugins_admin_url( 'licenses/index.php' ) );
?>&action=add"><?php
	echo pvs_word_lang( "add" )
?></a>
	
	<p>You should add different licenses for the <a href="<?php echo(pvs_plugins_admin_url('prices/index.php'));?>">prices</a> like: Royalty Free, Extended and etc.</p>
	
	
	<br>
	
	<?php
	$sql = "select id_parent,priority,name from " . PVS_DB_PREFIX .
		"licenses order by priority";
	$rs->open( $sql );
	if ( ! $rs->eof )
	{
?>
		<form method="post">
		<input type="hidden" name="action" value="change">
		<table class="wp-list-table widefat fixed striped posts">
		<thead>
			<tr>
			<th><b><?php
		echo pvs_word_lang( "priority" )
?>:</b></th>
			<th style="width:70%"><b><?php
		echo pvs_word_lang( "title" )
?>:</b></th>
			<th></th>
			<th></th>
			</tr>
		</thead>
		<?php
		while ( ! $rs->eof )
		{
?>
			<tr>
			<td><input name="priority<?php
			echo $rs->row["id_parent"]
?>" type="text" style="width:40px" value="<?php
			echo $rs->row["priority"]
?>"></td>
			<td><input name="title<?php
			echo $rs->row["id_parent"]
?>" type="text" style="width:250px" value="<?php
			echo $rs->row["name"]
?>"></td>
			<td><div class="link_edit"><a href='<?php
			echo ( pvs_plugins_admin_url( 'licenses/index.php' ) );
?>&action=edit&id=<?php
			echo $rs->row["id_parent"]
?>'><?php
			echo pvs_word_lang( "edit" )
?></a></td>
			<td>
			<div class="link_delete"><a href='<?php
			echo ( pvs_plugins_admin_url( 'licenses/index.php' ) );
?>&action=delete&id=<?php
			echo $rs->row["id_parent"]
?>'><?php
			echo pvs_word_lang( "delete" )
?></a></div>
			</td>
			</tr>
			<?php
			$rs->movenext();
		}
?>
		</table>
		<p><input type="submit" class="button button-primary button-large" value="<?php
		echo pvs_word_lang( "save" )
?>"></p>
		</form><br>
	<?php
	}
} else
{
	//If it is new
	$id = 0;
	if ( isset( $_GET["id"] ) )
	{
		$id = ( int )$_GET["id"];
	}

	//Fields list
	$admin_fields = array(
		"name",
		"priority",
		"description" );

	$admin_names = array(
		pvs_word_lang( "title" ),
		pvs_word_lang( "priority" ),
		pvs_word_lang( "description" ) );

	//Fields meanings
	$admin_meanings = array(
		"",
		"0",
		"" );

	//Fields types
	$admin_types = array(
		"text",
		"int",
		"editor" );

	//If it isn't a new category
	if ( $id != 0 )
	{
		//Get field's values
		$sql = "select name,priority,description from " . PVS_DB_PREFIX .
			"licenses where id_parent=" . ( int )$_GET["id"];
		$rs->open( $sql );
		if ( ! $rs->eof )
		{
			for ( $i = 0; $i < count( $admin_fields ); $i++ )
			{
				$admin_meanings[$i] = $rs->row[$admin_fields[$i]];
			}
		}
	}
?>

	
	
	<h1><?php
	if ( $id == 0 )
	{
		echo ( pvs_word_lang( "add" ) . " &mdash; " . pvs_word_lang( "license" ) );
	} else
	{
		echo ( pvs_word_lang( "edit" ) . " &mdash; " . pvs_word_lang( "license" ) );
	}
?></h1>
	<br>
	<?php
	echo ( pvs_build_admin_form( pvs_plugins_admin_url( 'licenses/index.php' ) .
		"&action=insert&id=" . $id, "catalog" ) );
}
?>



<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>