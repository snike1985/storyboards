<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "prints_productsoptions" );
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

//Content
if ( @$_REQUEST["action"] == 'content' )
{
	include ( "content.php" );
} else
{
?>
	
	<a class="btn btn-success toright" href="<?php
	echo ( pvs_plugins_admin_url( 'products_options/index.php' ) );
?>&action=content"><i class="icon-plane icon-white fa fa-plus"></i>&nbsp; <?php
	echo pvs_word_lang( "add" )
?></a>
	
	
	<h1><?php
	echo pvs_word_lang( "products options" )
?></h1>
	
	<?php
	$sql = "select * from " . PVS_DB_PREFIX . "products_options order by title";
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
		<th style="width:70%"><b>* <?php
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
			<tr valign="top">
			<td><input type="checkbox" name="activ<?php
			echo $rs->row["id"]
?>" <?php
			if ( $rs->row["activ"] == 1 )
			{
				echo ( "checked" );
			}
?>></td>
			<td><span class="big"><?php
			echo $rs->row["title"]
?></span></td>
			<td><div class="link_edit"><a href='<?php
			echo ( pvs_plugins_admin_url( 'products_options/index.php' ) );
?>&action=content&id=<?php
			echo $rs->row["id"]
?>'><?php
			echo pvs_word_lang( "edit" )
?></a></td>
			<td><div class="link_delete"><a href='<?php
			echo ( pvs_plugins_admin_url( 'products_options/index.php' ) );
?>&action=delete&id=<?php
			echo $rs->row["id"]
?>'><?php
			echo pvs_word_lang( "delete" )
?></a></div></td>
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
	
	
	
	
	
	</form>
	<?php
	} else
	{
		echo ( "<p><b>" . pvs_word_lang( "not found" ) . "</b></p>" );
	}
?>
	<br>
	<p>* - To translate the properties names and values you should add them in WP language file.</p>
	
	
	<?php
}
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>