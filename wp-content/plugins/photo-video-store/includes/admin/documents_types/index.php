<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_documents" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

//Change
if ( @$_REQUEST["action"] == 'change' )
{
	include ( "change.php" );
}

//Add
if ( @$_REQUEST["action"] == 'add' )
{
	include ( "add.php" );
}

//Delete
if ( @$_REQUEST["action"] == 'delete' )
{
	include ( "delete.php" );
}
?>




<a class="btn btn-success toright" href="<?php
echo ( pvs_plugins_admin_url( 'documents_types/index.php' ) );
?>&action=add"><i class="icon-user icon-white fa fa-plus"></i> <?php
echo pvs_word_lang( "add" )
?></a>



<h1><?php
echo pvs_word_lang( "Documents types" )
?></h1>

<p>Sometimes the users have to upload different documents to identify a person, a country and etc.</p>


<?php
$sql = "select * from " . PVS_DB_PREFIX . "documents_types order by priority";
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
	echo pvs_word_lang( "enabled" )
?>:</b></th>
	<th><b><?php
	echo pvs_word_lang( "priority" )
?>:</b></th>
	<th style="width:20%"><b><?php
	echo pvs_word_lang( "title" )
?>:</b></th>
	<th style="width:30%"><b><?php
	echo pvs_word_lang( "description" )
?>:</b></th>
	<th><b><?php
	echo pvs_word_lang( "size" )
?> (MB):</b></th>
	<th><b><?php
	echo pvs_word_lang( "buyer" )
?>:</b></th>
	<th><b><?php
	echo pvs_word_lang( "seller" )
?>:</b></th>
	<th><b><?php
	echo pvs_word_lang( "affiliate" )
?>:</b></th>
	<th></ht>
	</tr>
	</thead>
	<?php
	while ( ! $rs->eof )
	{
?>
		<tr valign="top">
		<td><input name="enabled<?php
		echo $rs->row["id"]
?>" type="checkbox" value="1" <?php
		if ( $rs->row["enabled"] == 1 )
		{
			echo ( "checked" );
		}
?>></td>
		<td><input name="priority<?php
		echo $rs->row["id"]
?>" type="text" style="width:40px" value="<?php
		echo $rs->row["priority"]
?>"></td>
		<td><input name="title<?php
		echo $rs->row["id"]
?>" type="text" style="width:220px" value="<?php
		echo $rs->row["title"]
?>"></td>
		<td><input name="description<?php
		echo $rs->row["id"]
?>" type="text" style="width:300px" value="<?php
		echo $rs->row["description"]
?>"></td>
		<td><input name="filesize<?php
		echo $rs->row["id"]
?>" type="text" style="width:50px" value="<?php
		echo $rs->row["filesize"]
?>"></td>
		<td><input name="buyer<?php
		echo $rs->row["id"]
?>" type="checkbox" value="1" <?php
		if ( $rs->row["buyer"] == 1 )
		{
			echo ( "checked" );
		}
?>></td>
		<td><input name="seller<?php
		echo $rs->row["id"]
?>" type="checkbox" value="1" <?php
		if ( $rs->row["seller"] == 1 )
		{
			echo ( "checked" );
		}
?>></td>
		<td><input name="affiliate<?php
		echo $rs->row["id"]
?>" type="checkbox" value="1" <?php
		if ( $rs->row["affiliate"] == 1 )
		{
			echo ( "checked" );
		}
?>></td>
		<td>
		<div class="link_delete"><a href='<?php
		echo ( pvs_plugins_admin_url( 'documents_types/index.php' ) );
?>&action=delete&id=<?php
		echo $rs->row["id"]
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
	<br>
	<p><input type="submit" class="btn btn-primary" value="<?php
	echo pvs_word_lang( "save" )
?>"></p>
	</form><br>
<?php
}
?>





<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>