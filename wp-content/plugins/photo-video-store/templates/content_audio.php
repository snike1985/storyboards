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
	
	$sql = "select id,media_id,title,data,description,viewed,author,keywords,userid,usa,duration,format,source,holder,content_type,free,downloaded,rating,server1,google_x,google_y,url,rights_managed,vote_like,vote_dislike,contacts,exclusive,content_type from " .
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
	
		//Audio preview URL
		$photo = pvs_show_preview( $rs->row["id"], "audio", 3, 1, $rs->row["server1"], $rs->row["id"] );
		$audio = pvs_show_preview( $rs->row["id"], "audio", 2, 1, $rs->row["server1"], $rs->row["id"] );
		$preview = pvs_show_preview( $rs->row["id"], "audio", 2, 0, $rs->row["server1"], $rs->row["id"] );
		$pvs_theme_content[ 'photo' ] = $photo;
		$pvs_theme_content[ 'audio' ] = $audio;
		$pvs_theme_content[ 'preview' ] = $preview;
	
		$pvs_theme_content[ 'share_title' ] = urlencode( $translate_results["title"] );
		$pvs_theme_content[ 'share_url' ] = urlencode( site_url() . pvs_item_url( $rs->row["id"], $rs->row["url"] ) );
		$pvs_theme_content[ 'share_image' ] = urlencode( site_url() . $photo );
		$pvs_theme_content[ 'share_description' ] = urlencode( $translate_results["description"] );
	
		//Show download sample
		$pvs_theme_content[ 'downloadsample' ] = $audio;
		//$pvs_theme_content[ 'downloadsample' ] = site_url()."/sample/?id=".$rs->row["id"];
	
		$pvs_theme_content[ 'fotomoto' ] = "<script type='text/javascript' src='//widget.fotomoto.com/stores/script/" . $pvs_global_settings["fotomoto_id"] .
			".js'></script>";
	
		$pvs_theme_content[ 'flag_downloadsample' ] = 0;
		if ( $pvs_global_settings["download_sample"] and ! preg_match( "/icon_audio/", $preview ) ) {
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
	
		$pvs_theme_content[ 'duration' ] = pvs_duration_format( $rs->row["duration"] );
		$pvs_theme_content[ 'format' ] = $rs->row["format"];
		$pvs_theme_content[ 'source' ] = $rs->row["source"];
		$pvs_theme_content[ 'holder' ] = $rs->row["holder"];
	
		//Show audio fields
		$sql = "select fname,activ from " . PVS_DB_PREFIX . "audio_fields";
		$dr->open( $sql );
		while ( ! $dr->eof ) {
			if ( $dr->row["fname"] == "duration" )
			{
				$flag_duration = false;
				if ( $dr->row["activ"] == 1 and $rs->row["duration"] != 0 )
				{
					$flag_duration = true;
				}
				$pvs_theme_content[ 'flag_duration' ] = $flag_duration;
			}
	
			if ( $dr->row["fname"] == "format" )
			{
				$flag_format = false;
				if ( $dr->row["activ"] == 1 and $rs->row["format"] != "" )
				{
					$flag_format = true;
				}
				$pvs_theme_content[ 'flag_format' ] = $flag_format;
			}
	
			if ( $dr->row["fname"] == "source" )
			{
				$flag_source = false;
				if ( $dr->row["activ"] == 1 and $rs->row["source"] != "" )
				{
					$flag_source = true;
				}
				$pvs_theme_content[ 'flag_source' ] = $flag_source;
			}
	
	
			if ( $dr->row["fname"] == "holder" )
			{
				$flag_holder = false;
				if ( $dr->row["activ"] == 1 and $rs->row["holder"] != "" )
				{
					$flag_holder = true;
				}
				$pvs_theme_content[ 'flag_holder' ] = $flag_holder;
			}
	
			$dr->movenext();
		}
		//End. Show fields
	
	
	
		//Audio sizes
		require_once( 'content_sizes.php' );
		
		require_once( get_stylesheet_directory(). '/item_audio.php' );
	}
}
?>