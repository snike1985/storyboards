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
?>&d=1&action=price_content" style="margin-left:20px"><i class="icon-file icon-white fa fa-plus"></i>&nbsp; <?php
echo pvs_word_lang( "add" )
?></a>

<p>
<a href="http://en.wikipedia.org/wiki/Rights_Managed">Rights Managed</a>, or RM, in photography and the stock photo industry, refers to a copyright license which, if purchased by a user, allows the one time use of the photo as specified by the license. If the user wants to use the photo for other uses an additional license needs to be purchased. RM licences can be given on a non-exclusive or exclusive basis. 
</p>


<br>

<?php
$sql = "select id,title,price from " . PVS_DB_PREFIX .
	"rights_managed order by id";
$rs->open( $sql );
if ( ! $rs->eof )
{
?>
	<table class="wp-list-table widefat fixed striped posts">
	<thead>
	<tr>
	<th style="width:60%"><b><?php
	echo pvs_word_lang( "title" )
?>:</b></th>
	<th><b><?php
	echo pvs_word_lang( "price" )
?>:</b></th>
	<th></th>
	<th></th>
	<th></th>
	</tr>
	</thead>
	<?php
	while ( ! $rs->eof )
	{
?>
		<tr>
		<td class="big"><?php
		echo $rs->row["title"]
?></td>
		<td class="big"><?php
		echo pvs_price_format( $rs->row["price"], 2 )
?></td>
		<td><div class="link_edit"><a href='<?php
		echo ( pvs_plugins_admin_url( 'rights_managed/index.php' ) );
?>&d=1&action=price_content&id=<?php
		echo $rs->row["id"]
?>'><?php
		echo pvs_word_lang( "edit" )
?></a></td>
		<td><div class="link_edit"><a href='<?php
		echo ( pvs_plugins_admin_url( 'rights_managed/index.php' ) );
?>&d=1&action=content&id=<?php
		echo $rs->row["id"]
?>'><?php
		echo pvs_word_lang( "price scheme" )
?></a></td>
		<td>
		<div class="link_delete"><a href='<?php
		echo ( pvs_plugins_admin_url( 'rights_managed/index.php' ) );
?>&d=1&action=price_delete&id=<?php
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

