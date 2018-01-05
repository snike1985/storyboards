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
	
	$sql = "select id,media_id,title,data,description,viewed,author,keywords,userid,content_type,free,downloaded,rating,server1,google_x,google_y,url,rights_managed,vote_like,vote_dislike,contacts,exclusive,content_type from " .
		PVS_DB_PREFIX . "media where published=1 and id=" . ( int )get_query_var('pvs_id');
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		if ( ! file_exists( pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) . "/" .
			$rs->row["id"] ) ) {
			mkdir( pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) . "/" . $rs->row["id"] );
		}
	
		$translate_results = pvs_translate_publication( $rs->row["id"], $rs->row["title"],
			$rs->row["description"], $rs->row["keywords"] );
	
		$folder = $rs->row["id"];
		$kk = 0;
	
		$remote_files = array();
		$remote_previews = array();
		$flag_storage = false;
	
		if ( pvs_is_remote_storage() ) {
			$sql = "select filename1,filename2,url,item_id,filesize from " . PVS_DB_PREFIX .
				"filestorage_files where id_parent=" . $rs->row["id"];
			$ds->open( $sql );
			while ( ! $ds->eof )
			{
				if ( $ds->row["item_id"] != 0 )
				{
					$remote_files[$ds->row["filename1"]] = $ds->row["filesize"];
				} else
				{
					$remote_previews[$ds->row["filename1"]] = $ds->row["url"] . "/" . $ds->row["filename2"];
				}
	
				$flag_storage = true;
				$ds->movenext();
			}
		}
	
		$preview_items = "";
		$preview_items_carousel = "";
		$preview_items_carousel_menu = "";
		$preview_items_carousel_active = "active";
		$preview_items_carousel_count = 0;
		$afiles = array();
	
		//Preview screenshots
		if ( ! $flag_storage ) {
			$dir = opendir( pvs_upload_dir() . pvs_server_url( $rs->row["server1"] ) . "/" . $folder );
			while ( $file = readdir( $dir ) )
			{
				if ( $file <> "." && $file <> ".." )
				{
					if ( preg_match( "/thumbs[0-9]+/", $file ) )
					{
						if ( preg_match( "/.jpg$|.jpeg$|.png$|.gif$/i", $file ) )
						{
							$kk = explode( "thumbs", $file );
							if ( count( $kk ) > 1 )
							{
								$afiles[( int )$kk[1]] = $file;
							}
						}
					}
				}
			}
			closedir( $dir );
			ksort( $afiles );
			reset( $afiles );
	
			for ( $k = 0; $k < count( $afiles ); $k++ )
			{
				if ( isset( $afiles[$k] ) )
				{
					$file = $afiles[$k];
					$thumbz = str_replace( "thumbs", "thumbz", $file );
					$preview_items .= "<img src=\"" . pvs_upload_dir('baseurl') . pvs_server_url( $rs->row["server1"] ) .
						"/" . $folder . "/" . $thumbz . "\">";
					$preview_items_carousel .= '<div class="item ' . $preview_items_carousel_active .
						'"><img src="' . pvs_upload_dir('baseurl') . pvs_server_url( $rs->row["server1"] ) . "/" . $folder .
						"/" . $thumbz . '" class="img-responsive"></div>';
					$preview_items_carousel_menu .=
						'<li data-target="#carousel-example-generic" data-slide-to="' . $preview_items_carousel_count .
						'" class="' . $preview_items_carousel_active . '"></li>';
					$preview_items_carousel_active = '';
					$preview_items_carousel_count++;
				}
			}
		} else {
			foreach ( $remote_previews as $key => $value )
			{
				if ( preg_match( "/thumbs[0-9]+/", $key ) )
				{
					if ( preg_match( "/.jpg$|.jpeg$|.png$|.gif$/i", $key ) )
					{
						$kk = explode( "thumbs", $key );
						if ( count( $kk ) > 1 )
						{
							$afiles[( int )$kk[1]] = $key;
						}
					}
				}
			}
	
			for ( $k = 1; $k < count( $afiles ); $k++ )
			{
				if ( isset( $afiles[$k] ) )
				{
					$file = $afiles[$k];
					$thumbz = str_replace( "thumbs", "thumbz", $file );
					$preview_items .= "<img src='" . $remote_previews[$thumbz] . "'>";
					$preview_items_carousel .= '<div class="item ' . $preview_items_carousel_active .
						'"><img src="' . $remote_previews[$thumbz] . '" class="img-responsive"></div>';
					$preview_items_carousel_menu .=
						'<li data-target="#carousel-example-generic" data-slide-to="' . $preview_items_carousel_count .
						'" class="' . $preview_items_carousel_active . '"></li>';
					$preview_items_carousel_active = '';
					$preview_items_carousel_count++;
				}
			}
		}
	
		$flag_previews = false;
		if ( $preview_items != "" ) {
			$flag_previews = true;
		}
	
		$pvs_theme_content[ 'flag_previews' ] = $flag_previews;
	
		if ( $preview_items != "" ) {
			$preview_items = "<style>#galleria{height:320px;width:" . $pvs_global_settings["thumb_width2"] .
				"px}</style><div id='galleria'>" . $preview_items .
				"</div><script> Galleria.loadTheme('" . pvs_plugins_url() .
				"/includes/plugins/galleria/themes/classic/galleria.classic.js'); Galleria.run('#galleria');</script>";
	
			$preview_items_carousel =
				'<div id="carousel-example-generic" class="carousel slide" data-ride="carousel" style="overflow:hidden;max-height:350px;max-width:' .
				$pvs_global_settings["thumb_width2"] . 'px">
			  <!-- Indicators -->
			  <ol class="carousel-indicators">
	' . $preview_items_carousel_menu . '
			  </ol>
			  <div class="carousel-inner" role="listbox">
	' . $preview_items_carousel . '
			  </div>
			  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
	<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
	<span class="sr-only">Previous</span>
			  </a>
			  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
	<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
	<span class="sr-only">Next</span>
			  </a>
			</div>';
	
			//$pvs_theme_content[ 'image' ] = $preview_items;
			$pvs_theme_content[ 'image' ] = $preview_items_carousel;
		}
	
		//End. Preview screenshots
		
		$vector_preview = pvs_show_preview( $rs->row["id"], "vector", 3, 1, $rs->row["server1"], $rs->row["id"] );
		
		//Previews jpg
		if ( preg_match( "/icon_vector/", $vector_preview ) ) {
			$vector = pvs_show_preview( $rs->row["id"], "vector", 2, 0, $rs->row["server1"],
				$rs->row["id"] );
			$vector_preview = pvs_show_preview( $rs->row["id"], "vector", 2, 1, $rs->
				row["server1"], $rs->row["id"] );
			if ( $pvs_global_settings["zoomer"] and ! preg_match( "/icon_vector/", $vector_preview ) )
			{
				$vector_preview_url = str_replace(pvs_upload_dir('baseurl'), pvs_upload_dir(), pvs_show_preview( $rs->row["id"], "vector", 2, 1, $rs->
					row["server1"], $rs->row["id"], false ));
	
				$vector_preview_original = str_replace( "thumb2", "thumb_original", $vector_preview_url );
				if ( $flag_storage )
				{
					if ( isset( $remote_previews["thumb_original.jpg"] ) )
					{
						$iframe_width = $remote_thumb_width;
						$iframe_height = $remote_thumb_height;
						$pvs_theme_content[ 'image' ] = "<iframe width=" . $iframe_width .
							" height=" . $iframe_height . " src='" . site_url() .
							"/content-photo-preview/?id=" . ( int )get_query_var('pvs_id') . "&width=" . $iframe_width .
							"&height=" . $iframe_height . "' frameborder=no scrolling=no></iframe>";
					}
				} else
				{
					if ( file_exists( $vector_preview_original ) )
					{
						$sz = getimagesize( $vector_preview_url );
						$iframe_width = $sz[0];
						$iframe_height = $sz[1];
	
						$pvs_theme_content[ 'image' ] = "<iframe width=" . $iframe_width .
							" height=" . $iframe_height . " src='" . site_url() .
							"/content-photo-preview.php/?id=" . ( int )get_query_var('pvs_id') . "&width=" . $iframe_width .
							"&height=" . $iframe_height . "' frameborder=no scrolling=no></iframe>";
					}
				}
			}
		}
	
		$pvs_theme_content[ 'share_title' ] = urlencode( $translate_results["title"] );
		$pvs_theme_content[ 'share_url' ] = urlencode( site_url() . pvs_item_url( $rs->row["id"], $rs->row["url"] ) );
		$pvs_theme_content[ 'share_image' ] = urlencode( site_url() . $preview );
		$pvs_theme_content[ 'share_description' ] = urlencode( $translate_results["description"] );
	
		//Show download sample
		$pvs_theme_content[ 'downloadsample' ] = $vector_preview;
		//$pvs_theme_content[ 'downloadsample' ] = site_url()."/sample/?id=".$rs->row["id"];
	
		$pvs_theme_content[ 'fotomoto' ] = "<script type='text/javascript' src='//widget.fotomoto.com/stores/script/" . $pvs_global_settings["fotomoto_id"] .
			".js'></script>";
	
		$pvs_theme_content[ 'flag_downloadsample' ] = 0;
		if ( $pvs_global_settings["download_sample"] and ! preg_match( "/icon_audio/", $vector_preview ) ) {
			$pvs_theme_content[ 'flag_downloadsample' ] = 1;
		}
	
		//Texts
		$pvs_theme_content[ 'title' ] = $translate_results["title"];
		$pvs_theme_content[ 'url' ] = site_url() . $rs->row["url"];
		$pvs_theme_content[ 'published' ] = date( date_format, $rs->row["data"] );
		$pvs_theme_content[ 'license' ] = site_url() . "/license/";
	
		//Show category
		$pvs_theme_content[ 'category' ] = pvs_show_category( $rs->row["id"] );
	
		$pvs_theme_content[ 'flag_exclusive' ] = $rs->row["exclusive"];
	
		//Show rating
		pvs_show_rating( get_query_var('pvs_id'), $rs->row["rating"] );
	
		$pvs_theme_content[ 'downloads' ] = $rs->row["downloaded"];
		$pvs_theme_content[ 'viewed' ] = $rs->row["viewed"];
		$pvs_theme_content[ 'description' ] = str_replace( "\r", "<br>", $translate_results["description"] );
	
		$pvs_theme_content[ 'like' ] = ( int )$rs->row["vote_like"];
		$pvs_theme_content[ 'dislike' ] = ( int )$rs->row["vote_dislike"];
	
		//Show next/previous navigation
		pvs_show_navigation( get_query_var('pvs_id'), "photos" );
	
		//Show author
		pvs_show_author( $rs->row["author"] );
	
		//Show community tools
		pvs_show_community();
	
		//Show google map
		pvs_show_google_map( $rs->row["google_x"], $rs->row["google_y"] );
		
		//Show color
		pvs_show_colors( get_query_var('pvs_id'), "vector" );
	
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
		pvs_show_related_items( get_query_var('pvs_id'), "check" );
	
		$sql = "select id_parent,itemid from " . PVS_DB_PREFIX . "reviews where itemid=" . ( int )
			get_query_var('pvs_id');
		$dr->open( $sql );
		$pvs_theme_content[ 'reviews' ] = pvs_word_lang( "reviews" ) . "(" . strval( $dr->rc ) . ")";
		
		$pvs_theme_content[ 'id' ] = get_query_var('pvs_id');
	
		//Content type
		$pvs_theme_content[ 'content_type' ] = "<a href='" . site_url() . "/?content_type=" . $rs->row["content_type"] . "'>" . $rs->row["content_type"] . "</a>";
	
	
	
	
	
		//Vector sizes
		require_once( 'content_sizes.php' );
		
		require_once( get_stylesheet_directory(). '/item_vector.php' );
	}
}
?>