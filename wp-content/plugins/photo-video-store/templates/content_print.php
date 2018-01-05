<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}



include ( "content_js_items.php" );

if ( pvs_check_password_publication( get_query_var('pvs_id') ) ) {
	$check_passsword_url = 'item-password';
	require_once( get_stylesheet_directory(). '/item_protected.php' );
} else {
	$sql = "update " . PVS_DB_PREFIX . "media set viewed=viewed+1 where id_parent=" . ( int )get_query_var('pvs_id');
	$db->execute( $sql );
	
	$sql = "select id,title,data,published,description,featured,keywords,author,viewed,userid,watermark,free,downloaded,rating,server1,google_x,google_y,url,editorial,rights_managed,vote_like,vote_dislike,contacts,exclusive,url_jpg,url_png,url_gif,url_raw,url_tiff,url_eps,content_type from " .
		PVS_DB_PREFIX . "media where published=1 and id=" . ( int )get_query_var('pvs_id');
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		$translate_results = pvs_translate_publication( $rs->row["id"], $rs->row["title"],
			$rs->row["description"], $rs->row["keywords"] );
	
		$photo_formats = array();
		$sql = "select id,photo_type from " . PVS_DB_PREFIX .
			"photos_formats where enabled=1 order by id";
		$dr->open( $sql );
		while ( ! $dr->eof ) {
			$photo_formats[$dr->row["id"]] = $dr->row["photo_type"];
			$dr->movenext();
		}
	
		$photo_files = array();
		foreach ( $photo_formats as $key => $value ) {
			if ( $rs->row["url_" . $value] != "" )
			{
				$photo_files[$value] = $rs->row["url_" . $value];
				$image_width[$value] = 0;
				$image_height[$value] = 0;
				$image_filesize[$value] = 0;
			}
		}
	
		$flag_storage = false;
		$folder = $rs->row["id"];
		$remote_thumb_width = 0;
		$remote_thumb_height = 0;
		$remote_print = "";
		$remote_print_width = 0;
		$remote_print_height = 0;
	
		if ( pvs_is_remote_storage() ) {
			$sql = "select url,filename1,filename2,width,height,item_id,filesize from " .
				PVS_DB_PREFIX . "filestorage_files where id_parent=" . $rs->row["id"];
			$ds->open( $sql );
			while ( ! $ds->eof )
			{
				$ext = strtolower( pvs_get_file_info( $ds->row["filename1"], "extention" ) );
				if ( $ext == "jpeg" )
				{
					$ext = "jpg";
				}
				if ( $ext == "tif" )
				{
					$ext = "tiff";
				}
	
				if ( $ds->row["item_id"] != 0 )
				{
					$image_width[$ext] = $ds->row["width"];
					$image_height[$ext] = $ds->row["height"];
					$image_filesize[$ext] = $ds->row["filesize"];
				}
				if ( preg_match( "/thumb2/", $ds->row["filename1"] ) )
				{
					$remote_thumb_width = $ds->row["width"];
					$remote_thumb_height = $ds->row["height"];
				}
				if ( preg_match( "/thumb_print/", $ds->row["filename1"] ) )
				{
					$remote_print = $ds->row["url"] . "/" . $ds->row["filename2"];
					$remote_print_width = $ds->row["width"];
					$remote_print_height = $ds->row["height"];
				}
				$flag_storage = true;
				$ds->movenext();
			}
		}
	
		if ( ! $flag_storage ) {
			foreach ( $photo_files as $key => $value )
			{
				if ( file_exists( pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) . "/" .
					$folder . "/" . $value ) )
				{
					$size = @getimagesize( pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) .
						"/" . $folder . "/" . $value );
					$image_width[$key] = ( int )$size[0];
					$image_height[$key] = ( int )$size[1];
					$image_filesize[$key] = filesize( pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) .
						"/" . $folder . "/" . $value );
				}
			}
		}
	
		$default_width = 0;
		$default_height = 0;
		$default_filesize = 0;
	
		foreach ( $photo_files as $key => $value ) {
			$pvs_theme_content[ 'photo_width' ] = $image_width[$key];
			$pvs_theme_content[ 'photo_height' ] = $image_height[$key];
			$photo_size = strval( pvs_price_format( $image_filesize[$key] / ( 1024 * 1024 ),
				3 ) ) . " Mb.";
			$pvs_theme_content[ 'photo_size' ] = $photo_size;
	
			if ( $image_width[$key] >= $image_height[$key] )
			{
				if ( $image_width[$key] > $default_width or $default_width == 0 )
				{
					$default_width = $image_width[$key];
					$default_height = $image_height[$key];
					$default_filesize = $image_filesize[$key];
				}
			} else
			{
				if ( $image_height[$key] < $default_height or $default_height == 0 )
				{
					$default_width = $image_width[$key];
					$default_height = $image_height[$key];
					$default_filesize = $image_filesize[$key];
				}
			}
		}
	
		$pvs_theme_content[ 'default_width' ] = $default_width;
		$pvs_theme_content[ 'default_height' ] = $default_height;
	
		$kk = 0;
		$fl = false;
	
		//Photo previews
		$preview = pvs_show_preview( $rs->row["id"], "photo", 2, 0, $rs->row["server1"],
			$rs->row["id"] );
		$preview_url = pvs_show_preview( $rs->row["id"], "photo", 2, 1, $rs->row["server1"],
			$rs->row["id"] );
		$preview_url2 = str_replace(pvs_upload_dir('baseurl'), pvs_upload_dir(), pvs_show_preview( $rs->row["id"], "photo", 2, 1, $rs->
			row["server1"], $rs->row["id"], false ));
	
		$pvs_theme_content[ 'share_title' ] = urlencode( $translate_results["title"] );
		$pvs_theme_content[ 'share_url' ] = urlencode( site_url() . pvs_item_url( $rs->row["id"], $rs->row["url"] ) );
		$pvs_theme_content[ 'share_image' ] = urlencode( site_url() . $preview_url );
		$pvs_theme_content[ 'share_description' ] = urlencode( $translate_results["description"] );
	
		if ( ! $flag_storage ) {
			$sz = getimagesize($preview_url2 );
			$iframe_width = $sz[0];
			$iframe_height = $sz[1];
		} else {
			$iframe_width = $remote_thumb_width;
			$iframe_height = $remote_thumb_height;
		}
		$pvs_theme_content[ 'big_width_prints' ] = $iframe_width;
		$pvs_theme_content[ 'big_height_prints' ] = $iframe_height;
	
		$pvs_theme_content[ 'print_type' ] = $prints_preview;
		if ( file_exists( PVS_PATH . "includes/prints/" . $prints_preview . "_big.php" ) ) {

			$pvs_theme_content[ 'image' ] = $preview_url;
			
			include( PVS_PATH . "includes/prints/" . $prints_preview . "_big.php" );
			
			$pvs_theme_content[ 'image' ] = $pvs_theme_content[ 'print_content' ];
		} else {
			$pvs_theme_content[ 'image' ] = "<img src='" . $preview_url . "' class='img-responsive'>";
			$pvs_theme_content[ 'big_width_prints' ] = 0;
			$pvs_theme_content[ 'big_height_prints' ] = 0;
		}
	
		$flag_resize = 0;
		$resize_min = $pvs_global_settings["thumb_width2"];
		$resize_max = $pvs_global_settings["prints_previews_width"];
		$resize_value = $pvs_global_settings["thumb_width2"];
	
		$sql = "select * from " . PVS_DB_PREFIX . "prints where id_parent=" . ( int ) get_query_var('pvs_print_id');
		$ds->open( $sql );
		if ( ! $ds->eof ) {
			$flag_resize = $ds->row["resize"];
			$resize_min = $ds->row["resize_min"];
			$resize_max = $ds->row["resize_max"];
			$resize_value = $ds->row["resize_value"];
		}
	
		$pvs_theme_content[ 'flag_resize' ] = $flag_resize;
	
		if ( $default_width < $default_height ) {
			$photo_size = $default_height;
		} else {
			$photo_size = $default_width;
		}
	
		$print_thumb = $preview_url;
		if ( $default_width > $default_height ) {
			$print_width = $pvs_global_settings["prints_previews_width"];
			$print_height = round( $pvs_global_settings["prints_previews_width"] * $default_height /
				$default_width );
		} else {
			$print_height = $pvs_global_settings["prints_previews_width"];
			$print_width = round( $pvs_global_settings["prints_previews_width"] * $default_width /
				$default_height );
		}
	
		if ( $pvs_global_settings["prints_previews_thumb"] and $pvs_global_settings["prints_previews_width"] >
			$pvs_global_settings["thumb_width2"] ) {
			if ( ! $flag_storage )
			{
				$print_thumb = pvs_upload_dir('baseurl') . pvs_server_url( $rs->row["server1"] ) . "/" . $folder .
					"/thumb_print.jpg";
	
				if ( ! file_exists( pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) . "/" .
					$folder . "/thumb_print.jpg" ) )
				{
					if ( file_exists( pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) . "/" .
						$folder . "/" . @$photo_files["gif"] ) and @$photo_files["gif"] != '' )
					{
						pvs_photo_resize( pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) . "/" .
							$folder . "/" . @$photo_files["gif"], pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) .
							"/" . $folder . "/thumb_print.jpg", 3 );
						pvs_publication_watermark_add( get_query_var('pvs_id'), pvs_upload_dir() . pvs_server_url( $rs->
							row["server1"] ) . "/" . $folder . "/thumb_print.jpg" );
					}
	
					if ( file_exists( pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) . "/" .
						$folder . "/" . @$photo_files["png"] ) and @$photo_files["png"] != '' )
					{
						pvs_photo_resize( pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) . "/" .
							$folder . "/" . @$photo_files["png"], pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) .
							"/" . $folder . "/thumb_print.jpg", 3 );
						pvs_publication_watermark_add( get_query_var('pvs_id'), pvs_upload_dir() . pvs_server_url( $rs->
							row["server1"] ) . "/" . $folder . "/thumb_print.jpg" );
					}
	
					if ( file_exists( pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) . "/" .
						$folder . "/" . @$photo_files["jpg"] ) and @$photo_files["jpg"] != '' )
					{
						pvs_photo_resize( pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) . "/" .
							$folder . "/" . @$photo_files["jpg"], pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) .
							"/" . $folder . "/thumb_print.jpg", 3 );
						pvs_publication_watermark_add( get_query_var('pvs_id'), pvs_upload_dir() . pvs_server_url( $rs->
							row["server1"] ) . "/" . $folder . "/thumb_print.jpg" );
					}
				}
			} else
			{
				if ( $remote_print != '' and $remote_print_width != 0 and $remote_print_height !=
					0 )
				{
					$print_thumb = $remote_print;
					$print_width = $remote_print_width;
					$print_height = $remote_print_height;
				}
			}
		}
	
		$pvs_theme_content[ 'print_preview' ] = $print_thumb;
		$pvs_theme_content[ 'width_print_preview' ] = $print_width;
		$pvs_theme_content[ 'height_print_preview' ] = $print_height;
	
		//Texts
		$pvs_theme_content[ 'title' ] = $translate_results["title"];
		
		$pvs_theme_content[ 'print_title' ] = pvs_word_lang( @$prints_title );
		$pvs_theme_content[ 'url' ] = site_url() . $rs->row["url"];
		$pvs_theme_content[ 'published' ] = date( date_format, $rs->row["data"] );
		$pvs_theme_content[ 'path' ] = @$path;
	
		//Show category
		$pvs_theme_content[ 'category' ] = pvs_show_category( $rs->row["id"] );
	
		//Show rating
		pvs_show_rating( get_query_var('pvs_id'), $rs->row["rating"] );
	
		$pvs_theme_content[ 'description' ] = str_replace( "\r", "<br>", $translate_results["description"] );
	
		$pvs_theme_content[ 'like' ] = ( int )$rs->row["vote_like"];
		$pvs_theme_content[ 'dislike' ] = ( int )$rs->row["vote_dislike"];
	
		//Show next/previous navigation
		pvs_show_navigation( get_query_var('pvs_id'), "photos", ( int ) get_query_var('pvs_print_id'), $prints_preview );
	
		//Show author
		pvs_show_author( $rs->row["author"] );
	
		//Show community tools
		pvs_show_community();
	
		//Show keywords
		$keywords = array();
		$titles = explode( " ", pvs_remove_words( $translate_results["title"] ) );
		pvs_show_keywords( get_query_var('pvs_id'), "photo" );
	
		//Show tell a friend
		$pvs_theme_content[ 'tell_a_friend_link' ] = site_url() . "/tell-a-friend/?id_parent=" . ( int )get_query_var('pvs_id');
	
		//Show favorite buttons
		pvs_show_favorite( get_query_var('pvs_id') );
	
		if ( is_user_logged_in() ) {
			$pvs_theme_content[ 'mail_link' ] = site_url() . "/messages-new/?user=" . $rs->row["author"];
		} else {
			$pvs_theme_content[ 'mail_link' ] = site_url() . "/login/";
		}
	
	
		//Show related items
		pvs_show_related_prints( get_query_var('pvs_id'), ( int ) get_query_var('pvs_print_id'),$rs->row["title"], "check" );

		$pvs_theme_content[ 'id' ] = get_query_var('pvs_id');
		$id_parent = get_query_var('pvs_id');
		include ( "content_print_properties.php" );
	
		require_once( get_stylesheet_directory(). '/item_print.php' );
	}
}
?>