<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "prints_printscategories" );
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
?>





<a class="btn btn-success toright" href="<?php
echo ( pvs_plugins_admin_url( 'prints_categories/index.php' ) );
?>&action=add"><i class="icon-print icon-white fa fa-plus"></i>&nbsp; <?php
echo pvs_word_lang( "add" )
?></a>


<h1><?php
echo pvs_word_lang( "Prints categories" )
?></h1>





<br>

<?php
$sql = "select id,title,priority,active from " . PVS_DB_PREFIX .
	"prints_categories order by priority";
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
	echo pvs_word_lang( "active" )
?>:</b></th>
	<th><b><?php
	echo pvs_word_lang( "priority" )
?>:</b></th>
	<th style="width:60%"><b>* <?php
	echo pvs_word_lang( "title" )
?>:</b></th>
	<th></th>
	</tr>
	</thead>
	<?php
	while ( ! $rs->eof )
	{
?>
		<tr>
		<td><input type="checkbox" name="active<?php
		echo $rs->row["id"]
?>" value="1" <?php
		if ( $rs->row["active"] == 1 )
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
?>" type="text" style="width:250px" value="<?php
		echo $rs->row["title"]
?>"></td>		
		<td><div class="link_delete"><a href='<?php
		echo ( pvs_plugins_admin_url( 'prints_categories/index.php' ) );
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

<p>* - To translate the categories names you should add them in WP language file.</p>

		<div id="button_bottom_static">
		<div id="button_bottom_layout"></div>
		<div id="button_bottom">
			<input type="submit" value="<?php
	echo pvs_word_lang( "save" )
?>" class="btn btn-primary" style="margin-top:20px">
		</div>
	</div>
	
		</form>
<?php
}
?>



<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>