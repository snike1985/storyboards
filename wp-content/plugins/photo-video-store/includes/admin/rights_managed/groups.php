<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_rightsmanaged" );
?>

<br>

<a class="btn btn-success toright" href="<?php
echo ( pvs_plugins_admin_url( 'rights_managed/index.php' ) );
?>&d=2&action=groups_content" style="margin-left:20px"><i class="icon-th icon-white fa fa-plus"></i>&nbsp; <?php
echo pvs_word_lang( "add group" )
?></a>



<br><br><br>

<?php
$sql = "select id,title from " . PVS_DB_PREFIX .
	"rights_managed_groups order by id";
$rs->open( $sql );
if ( ! $rs->eof )
{
?>
	<table class="wp-list-table widefat fixed striped posts">
	<thead>
	<tr>
	<th style="width:70%"><b><?php
	echo pvs_word_lang( "title" )
?>:</b></th>
	<th><b><?php
	echo pvs_word_lang( "edit" )
?>:</b></th>
	<th><b><?php
	echo pvs_word_lang( "delete" )
?></b></th>
	</tr>
	</thead>
	<?php
	while ( ! $rs->eof )
	{
?>
		<tr>
		<td><span class="big"><?php
		echo $rs->row["title"]
?></span></td>
		<td><div class="link_edit"><a href='<?php
		echo ( pvs_plugins_admin_url( 'rights_managed/index.php' ) );
?>&d=2&action=groups_content&id=<?php
		echo $rs->row["id"]
?>'><?php
		echo pvs_word_lang( "edit" )
?></a></td>
		<td>
		<div class="link_delete"><a href='<?php
		echo ( pvs_plugins_admin_url( 'rights_managed/index.php' ) );
?>&d=2&action=groups_delete&id=<?php
		echo $rs->row["id"]
?>' onClick="return confirm('<?php
		echo pvs_word_lang( "delete" )
?>?');"><?php
		echo pvs_word_lang( "delete" )
?></a></div>
		</td>
		</tr>
		<?php
		$rs->movenext();
	}
?>
	</table>
<?php
}
?>

