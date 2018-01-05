<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

$sql_mass = array();
$json_string = "";

//Media
$sql_mass["media"] =
	"select id,title,server1,google_x,google_y,description,media_id from " .
	PVS_DB_PREFIX . "media where google_x<>0 and google_y<>0 order by id desc";

//Category
$sql_mass["category"] =
	"select id,title,description,location,keywords,google_x,google_y,photo,creation_date from " .
	PVS_DB_PREFIX . "category where google_x<>0 and google_y<>0 and activation_date < " .
	pvs_get_time() . " and (expiration_date > " . pvs_get_time() .
	" or expiration_date = 0) order by id desc";

$n = 0;

foreach ( $sql_mass as $key => $value ) {
	$rs->open( $value );
	while ( ! $rs->eof ) {
		$img_url = "";

		$remote_width = 0;
		$remote_height = 0;
		$flag_storage = false;
		$img_width = 0;
		$img_height = 0;

		if ( $key != "category" and $rs->row["media_id"] == 1 ) {
			$img_url = pvs_show_preview( $rs->row["id"], "photo", 1, 1, $rs->row["server1"],
				$rs->row["id"], false );

			$sql = "select url,filename1,filename2,width,height from " . PVS_DB_PREFIX .
				"filestorage_files where id_parent=" . $rs->row["id"] .
				" and (filename1='thumb1.jpg' or filename1='thumb1.jpeg')";
			$ds->open( $sql );
			if ( ! $ds->eof )
			{
				$remote_width = $ds->row["width"];
				$remote_height = $ds->row["height"];
				$flag_storage = true;
			}
		}
		if ( $key != "category" and $rs->row["media_id"] == 2 ) {
			$img_url = pvs_show_preview( $rs->row["id"], "video", 1, 1, $rs->row["server1"],
				$rs->row["id"], false );

			$sql = "select url,filename1,filename2,width,height from " . PVS_DB_PREFIX .
				"filestorage_files where id_parent=" . $rs->row["id"] .
				" and (filename1='thumb.jpg' or filename1='thumb.jpeg' or filename1='thumb0.jpg' or filename1='thumb0.jpeg')";
			$ds->open( $sql );
			if ( ! $ds->eof )
			{
				$remote_width = $ds->row["width"];
				$remote_height = $ds->row["height"];
				$flag_storage = true;
			}
		}
		if ( $key != "category" and $rs->row["media_id"] == 3 ) {
			$img_url = pvs_show_preview( $rs->row["id"], "audio", 1, 1, $rs->row["server1"],
				$rs->row["id"], false );

			$sql = "select url,filename1,filename2,width,height from " . PVS_DB_PREFIX .
				"filestorage_files where id_parent=" . $rs->row["id"] .
				" and (filename1='thumb.jpg' or filename1='thumb.jpeg')";
			$ds->open( $sql );
			if ( ! $ds->eof )
			{
				$remote_width = $ds->row["width"];
				$remote_height = $ds->row["height"];
				$flag_storage = true;
			}
		}
		if ( $key != "category" and $rs->row["media_id"] == 4 ) {
			$img_url = pvs_show_preview( $rs->row["id"], "vector", 1, 1, $rs->row["server1"],
				$rs->row["id"], false );

			$sql = "select url,filename1,filename2,width,height from " . PVS_DB_PREFIX .
				"filestorage_files where id_parent=" . $rs->row["id"] .
				" and (filename1='thumb1.jpg' or filename1='thumb1.jpeg' or filename1='thumb.jpg' or filename1='thumb.jpeg')";
			$ds->open( $sql );
			if ( ! $ds->eof )
			{
				$remote_width = $ds->row["width"];
				$remote_height = $ds->row["height"];
				$flag_storage = true;
			}
		}

		if ( $key != "category" ) {
			if ( ! $flag_storage )
			{
				$size = @getimagesize( pvs_upload_dir() . $img_url );
				$img_width = round( $size[0] / 2 );
				$img_height = round( $size[1] / 2 );
			} else
			{
				$img_width = round( $remote_width / 2 );
				$img_height = round( $remote_height / 2 );
			}
		} else {
			$category_result = pvs_show_category_preview($rs->row["id"]);
			$img_url = $category_result["photo"];
			$img_width = round( $category_result["width"] / 4 );
			$img_height = round( $category_result["height"] / 4 );
		}

		if ( $json_string != '' ) {
			$json_string .= ',';
		}

		if ( $key != "category" ) {
			$json_string .= '{"photo_id": ' . $rs->row["id"] . ', "photo_title": "' .
				addslashes( str_replace( "\r", "", str_replace( "\n", "", $rs->row["title"] ) ) ) .
				'", "photo_url": "' . pvs_item_url( $rs->row["id"] ) .
				'", "photo_file_url": "' . $img_url . '", "longitude": ' . $rs->row["google_y"] .
				', "latitude": ' . $rs->row["google_x"] . ', "width": ' . $img_width .
				', "height": ' . $img_height . ', "description": "' . addslashes( str_replace( "\r",
				"", str_replace( "\n", "", $rs->row["description"] ) ) ) . '"}';
		} else {

			$itg = "";
			$nlimit = 0;
			$count_id = pvs_count_files_in_category( $rs->row["id"] );

			$json_string .= '{"photo_id": ' . $rs->row["id"] . ', "photo_title": "' .
				addslashes( str_replace( "\r", "", str_replace( "\n", "", $rs->row["title"] ) ) ) .
				'", "photo_url": "' . pvs_category_url( $rs->row["id"] ) .
				'", "photo_file_url": "' . $img_url . '", "longitude": ' . $rs->row["google_y"] .
				', "latitude": ' . $rs->row["google_x"] . ', "width": ' . $img_width .
				', "height": ' . $img_height . ', "description": "<div>' . addslashes( str_replace
				( "\r", "", str_replace( "\n", "", $rs->row["description"] ) ) ) . '</div><div>' .
				addslashes( str_replace( "\r", "", str_replace( "\n", "", $rs->row["location"] ) ) ) .
				'</div><div>' . date( date_format, $rs->row['creation_date'] ) . '</div><div>' .
				pvs_word_lang( "photos" ) . ': ' . $count_id . '</div>' . '"}';
		}

		$n++;
		$rs->movenext();
	}
}
?>

var data = { "count": <?php echo $n
?>,
 "photos": [<?php echo $json_string
?>
]}

