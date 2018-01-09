<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

if ( $pvs_global_settings["userupload"] == 0 ) {
	exit;
}

$sql = "select id,id_parent,title,description,photo,published,userid from " .
	PVS_DB_PREFIX . "category where userid=" . get_current_user_id() .
	" order by id desc";
$rs->open( $sql );
if ( ! $rs->eof ) {
?>
	<table border="0" cellpadding="5" cellspacing="0" class="profile_table">
		<tr>
			<th><b><?php echo pvs_word_lang( "title" );?>:</b></th>
			<th></th>
			<th><b><?php echo pvs_word_lang( "description" );?>:</b></th>
			<th><b><?php echo pvs_word_lang( "status" );?>:</b></th>
			<th></th>
			<th></th>
		</tr>
	<?php
	$n = 0;
	$tr = 1;
	while ( ! $rs->eof ) {
		if ( $n >= $kolvo * ( $str - 1 ) and $n < $kolvo * $str ) {
			$preview = pvs_plugins_url() . "/assets/images/not_found.gif";
			if ( $rs->row["photo"] != "" and file_exists( pvs_upload_dir() . $rs->
				row["photo"] ) )
			{
				$preview = pvs_upload_dir('baseurl') . $rs->row["photo"];
			}

			$url = pvs_category_url( $rs->row["id"] );?>
			<tr valign="top"  <?php
			if ( $tr % 2 == 0 )
			{
				echo ( "class='snd'" );
			}
?>> 
	<td><?php
			if ( $rs->row["published"] == 1 )
			{
?><a href="<?php
				echo $url;
?>"><?php
			}
?><img src="<?php
			echo $preview;
?>" border="0"></a></td>
	<td><?php
			if ( $preview != "" and $rs->row["published"] == 1 )
			{
?><a href="<?php
				echo $url;
?>"><?php
			}
?><?php
			echo $rs->row["title"];
?></a></td>
	<td><?php
			echo $rs->row["description"];
?></td>
	<td><?php
			if ( $rs->row["published"] == 1 )
			{
				echo ( "<div class='link_approved'>" . pvs_word_lang( "approved" ) . "</div>" );
			}
			if ( $rs->row["published"] == 0 )
			{
				echo ( "<div class='link_pending'>" . pvs_word_lang( "pending" ) . "</div>" );
			}
			if ( $rs->row["published"] == -1) {
				echo ( "<div class='link_pending'>" . pvs_word_lang( "declined" ) . "</div>" );
			}
?></td>
			<td style="padding-left:20px">
	<div class="link_edit"><a href='<?php echo (site_url( ) );?>/filemanager-category/?id=<?php
			echo $rs->row["id"];
?>&d=1'><?php
			echo pvs_word_lang( "edit" );?></a></div>
			</td>
			<td style="padding-left:20px">
		<div class="link_delete"><a href='<?php echo (site_url( ) );?>/delete-category/?id=<?php
				echo $rs->row["id"];
?>' onClick="return confirm('<?php
				echo pvs_word_lang( "delete" );?>?');"><?php
				echo pvs_word_lang( "delete" );?></a></div>

			</td>
			</tr>

			<?php
		}
		$n++;
		$tr++;
		$rs->movenext();
	}
?>
	</table>
	<?php echo ( pvs_paging( $n, $str, $kolvo, $kolvo2, site_url() . "/publications/", "&d=1" ) );
} else
{
	echo ( "<b>" . pvs_word_lang( "not found" ) . "</b>" );
}
?>