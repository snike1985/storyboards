<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}


include ( "JsHttpRequest.php" );

$JsHttpRequest = new JsHttpRequest( $mtg );

$id = ( int )$_REQUEST["id"];

if ( is_user_logged_in() ) {


	//Show images
	$size_result = pvs_define_thumb_size( $id );
	$lightbox_image = $size_result["thumb"];
	$lightbox_width = $size_result["width"];
	$lightbox_height = $size_result["height"];
	//End. Show images

	//Show select
	$lightbox_list = "";
	$sql = "select id_parent from " . PVS_DB_PREFIX . "lightboxes_admin where user=" . ( int )
		get_current_user_id();
	$rs->open( $sql );
	while ( ! $rs->eof ) {
		$sql = "select title from " . PVS_DB_PREFIX . "lightboxes where id=" . $rs->row["id_parent"] .
			" order by title";
		$ds->open( $sql );
		if ( ! $ds->eof ) {
			$sel = "";
			$sql = "select id_parent from " . PVS_DB_PREFIX . "lightboxes_files where item=" .
				$id . " and id_parent=" . $rs->row["id_parent"];
			$dr->open( $sql );
			if ( ! $dr->eof )
			{
				$sel = "checked";
			}

			$lightbox_list .= "<div style='margin-top:5px'><input type='checkbox' id='chk" .
				$rs->row["id_parent"] . "' name='chk" . $rs->row["id_parent"] . "' " . $sel .
				">&nbsp;" . $ds->row["title"] . "</div>";
		}
		$rs->movenext();
	}
	$lightbox_list .= "<div style='margin-top:5px'><input type='checkbox' id='new_lightbox' name='new_lightbox'>&nbsp;<input type='text' value='" .
		pvs_word_lang( "new" ) . "' id='new' name='new' style='width:100px' onClick=\"this.value=''\"></div>";

	$lightbox = '<form id="lightbox_form" style="margin:0px" enctype="multipart/form-data">
	<div id="lightbox_header">
		' . pvs_word_lang("lightboxes") . '
	</div>
		
	<div id="lightbox_content">
		<table border="0" cellpadding="0" cellspacing="0">
		<tr valign="top">
		<td>
				<img src="' . $lightbox_image . '" width="' . $lightbox_width . '" height="' . $lightbox_height . '">
		</td>
		<td style="padding-left:15px">
			<div>
				<b>' . pvs_word_lang("Select a lightbox") . ':</b>
			</div>
			' . $lightbox_list . '
		</td>
		</tr>
		</table>
	</div>
	
	<div id="lightbox_footer">
		<input type="hidden" name="publication" value="' . $id . '">
		<input type="button" value="' . pvs_word_lang("Save") . '" class="lightbox_button" onClick="pvs_lightbox_add(\'' . site_url() . '\')">
	</div>
	</form>';

	$GLOBALS['_RESULT'] = array( "authorization" => 1, "lightbox_message" => $lightbox );
} else
{
	$GLOBALS['_RESULT'] = array( "authorization" => 0, "lightbox_message" =>
			pvs_word_lang( "You should login to use the option" ) );
}

?>