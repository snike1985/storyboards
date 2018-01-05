<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_models" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

//Add
if ( @$_REQUEST["action"] == 'add' )
{
	include ( "add.php" );
}

//Change
if ( @$_REQUEST["action"] == 'change' )
{
	include ( "change.php" );
}

//Delete
if ( @$_REQUEST["action"] == 'delete' )
{
	include ( "delete.php" );
}

//Delete thumb
if ( @$_REQUEST["action"] == 'delete_thumb' )
{
	include ( "delete_thumb.php" );
}

//Content
if ( @$_REQUEST["action"] == 'content' )
{
	include ( "content.php" );
} else
{
?>
	
	
	
	
	<a class="btn btn-success toright" href="<?php
	echo ( pvs_plugins_admin_url( 'models/index.php' ) );
?>&action=content"><i class="icon-user icon-white fa fa-plus"></i>&nbsp; <?php
	echo pvs_word_lang( "add" )
?></a>
	
	
	
	
	<h1><?php
	echo pvs_word_lang( "model property release" )
?></h1>
	<br>
	
	
	
	<?php
	$sql = "select id_parent,name,user from " . PVS_DB_PREFIX .
		"models order by name";
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
		echo pvs_word_lang( "title" )
?>:</b></th>
		<th><b><?php
		echo pvs_word_lang( "user" )
?>:</b></th>
		<th></th>
		<th></th>
		</tr>
		</thead>
		<?php
		while ( ! $rs->eof )
		{
?>
			<tr valign="top">
			<td><input name="title<?php
			echo $rs->row["id_parent"]
?>" type="text" style="width:250px" value="<?php
			echo $rs->row["name"]
?>"></td>
			<td><div class="link_user">
				<?php
			$sql = "select ID, user_login from " . $table_prefix .
				"users where user_login='" . $rs->row["user"] . "'";
			$ds->open( $sql );
			if ( ! $ds->eof )
			{
				echo ( "<a href='" . pvs_plugins_admin_url( 'customers/index.php' ) .
					"&action=content&id=" . $ds->row["ID"] . "'>" . $rs->row["user"] . "</a>" );
			}
?></div>
			</td>
			<td><div class="link_edit"><a href='<?php
			echo ( pvs_plugins_admin_url( 'models/index.php' ) );
?>&action=content&id=<?php
			echo $rs->row["id_parent"]
?>'><?php
			echo pvs_word_lang( "edit" )
?></a></td>
			<td>
			<div class="link_delete"><a href='<?php
			echo ( pvs_plugins_admin_url( 'models/index.php' ) );
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
		<br>
		<p><input type="submit" class="btn btn-primary" value="<?php
		echo pvs_word_lang( "save" )
?>"></p>
		</form><br>
	<?php
	}
}
?>





<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>