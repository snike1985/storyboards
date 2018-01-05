<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Include necessary template for theme
function pvs_template_include( $template ) {
	if(get_query_var('pvs_page') != '' and file_exists(get_stylesheet_directory() . '/pvs.php')){
			return get_stylesheet_directory() . '/pvs.php';
	}

	return $template;
}

//Show/hide header/footer
function pvs_is_show_header_footer () {
	$flag = true;
	
	$pages_no_header = array (
		'admin_photo_preview',
		'agreement',
		'affiliate-change',
		'billing-coupon',
		'category-password',
		'check-facebook',
		'check-google',
		'check-twitter',
		'check-vk',
		'check-yandex',
		'check-login',
		'check-email',
		'check-guest',
		'check-instagram',
		'checkout-address',
		'checkout-coupon',
		'checkout-method',
		'checkout-shipping',
		'commission-change',
		'content-photo-preview',
		'content-print-price',
		'content-list-paging',
		'count',
		'cron-amazon',
		'cron-ffmpeg',
		'cron-photos',
		'cron-printful',
		'cron-pwinty',
		'cron-rackspace',
		'cron-backblaze',
		'delete-category',
		'delete-publication',
		'download',
		'examination-take',
		'exif',
		'friends-add',
		'friends-delete',
		'friends-remove',
		'image',
		'invoice-html',
		'invoice-pdf',
		'item-password',
		'language-select',
		'lightbox-add',
		'lightbox-delete',
		'lightbox-edit',
		'lightbox-show',
		'like',
		'map-json',
		'messages-add',
		'messages-delete',
		'messages-to-trash',
		'models-add',
		'models-delete',
		'models-edit',
		'models-file-delete',
		'orders-add',
		'orders-scheme',
		'orders-crop',
		'orders-export-csv',
		'orders-export-xls',
		'orders-print-version',
		'popup',
		'preview',
		'payment-process',
		'payment-notification',
		'print-version',
		'prints-preview',
		'printslab-add-to-cart',
		'printslab-add-to-cart2',
		'printslab-add',
		'printslab-change',
		'printslab-delete',
		'printslab-preupload',
		'printslab-upload-process',
		'profile-document-upload',
		'profile-downloads-xls',
		'profile-type-change',
		'profile-edit',
		'profile-photo-upload',
		'profile-photo-delete',
		'publications-edit',
		'recognition-imagga',
		'reviews-change',
		'reviews-content',
		'reviews-delete',
		'reviews-edit',
		'rights-managed-change',
		'rights-managed',
		'rss-category',
		'search-lite',
		'signup-add',
		'shopping-cart-add-collection',
		'shopping-cart-add-light',
		'shopping-cart-add-next',
		'shopping-cart-add-print',
		'shopping-cart-add-prints-stock',
		'shopping-cart-add-rights-managed',
		'shopping-cart-add',
		'shopping-cart-change-new',
		'shopping-cart-change-option',
		'shopping-cart-change',
		'shopping-cart-clear',
		'shopping-cart-delete-light',
		'shopping-cart-delete',
		'shopping-cart-reload',
		'states',
		'support-add',
		'support-rating',
		'tell-a-friend',
		'testimonials-change',
		'testimonials-delete',
		'testimonials-edit',
		'upload-audio',
		'upload-category',
		'upload_files_jquery',
		'upload_java_admin',
		'upload-photo-jquery',
		'upload-photo-jquery-process',
		'upload-photo-plupload',
		'upload-photo-plupload-process',
		'upload-photo-java',
		'upload-photo-java-process',
		'upload-photo-preview',
		'upload-photo',
		'upload-vector',
		'upload-video',
		'user-comments-content',
		'user-testimonials-content',
		'vote-add',
		'vote-user',
		'zoomer'
	);
	
	if ( in_array(get_query_var('pvs_page'), $pages_no_header ) ) {
		$flag = false;
	}
	
	return $flag;
}


function pvs_get_page_url($key) {
	global $pvs_global_settings;

	if ($key == 'signup' and $pvs_global_settings['wordpress_signup']) {
		return site_url() . '/wp-login.php?action=register';
	} else if ($key == 'forgot-password' and $pvs_global_settings['wordpress_signup']) {
		return site_url() . '/wp-login.php?action=lostpassword';
	} else {
		return site_url() . '/' . $key . '/';
	}
}

//Theme array
$pvs_theme_content = array();

//Show theme content
function pvs_get_theme_content ($content_key) {
	global $pvs_theme_content;
	return @$pvs_theme_content[$content_key];
}

//Define if the page is home
function pvs_is_home_page () {
	global $_GET;
	global $_POST;
	$home_flag = false;
	
	if ( count( $_POST ) == 0 and ( count( $_GET ) == 0 or ( isset( $_GET["aff"] ) and count( $_GET ) == 1 ))) {
		$home_flag = true;
	}
	
	return $home_flag;
}

//Show box categories
function pvs_box_categories () {
	global $pvs_global_settings;
	global $pvs_theme_content;
	global $rs;
	
	$box_categories = "";
	$categories_list[1][2] = "";
	$categories_list[2][2] = "";
	$categories_list[1][3] = "";
	$categories_list[2][3] = "";
	$categories_list[3][3] = "";
	$categories_list[1][4] = "";
	$categories_list[2][4] = "";
	$categories_list[3][4] = "";
	$categories_list[4][4] = "";
	$categories_list[1][6] = "";
	$categories_list[2][6] = "";
	$categories_list[3][6] = "";
	$categories_list[4][6] = "";
	$categories_list[5][6] = "";
	$categories_list[6][6] = "";
	
	$category_featured = array();
	$category_featured_url = array();
	$category_featured_photo = array();
	
	$sql = "select id, id_parent, title, url, photo, featured from " . PVS_DB_PREFIX .
		"category where id_parent = 0 and  published = 1 and activation_date < " .
		pvs_get_time() . " and (expiration_date > " . pvs_get_time() .
		" or expiration_date = 0) and password=''  order by priority";
	$rs->open( $sql );
	$n2 = 1;
	$n3 = 1;
	$n4 = 1;
	$n6 = 1;
	while ( ! $rs->eof ) {
		$translate_results = pvs_translate_category( $rs->row["id"], $rs->row["title"],
			"", "" );
	
		$new_category = "<li><a href='" . site_url( ) . $rs->row["url"] . "'>" . $translate_results["title"] .
			"</a></li>";
	
		if ( $n2 == 3 ) {
			$n2 = 1;
		}
		if ( $n3 == 4 ) {
			$n3 = 1;
		}
		if ( $n4 == 5 ) {
			$n4 = 1;
		}
		if ( $n6 == 7 ) {
			$n6 = 1;
		}
	
		$box_categories .= $new_category;
		$categories_list[$n2][2] .= $new_category;
		$categories_list[$n3][3] .= $new_category;
		$categories_list[$n4][4] .= $new_category;
		$categories_list[$n6][6] .= $new_category;
	
		if ( $rs->row["featured"] == 1 ) {
			$category_featured[] = $translate_results["title"];
			$category_featured_url[] = site_url( ) . $rs->row["url"];
			$category_featured_photo[] = $rs->row["photo"];
		}
	
		$n2++;
		$n3++;
		$n4++;
		$n6++;
		$rs->movenext();
	}
	
	$pvs_theme_content[ 'box_categories' ] = $box_categories;
	$pvs_theme_content[ 'categories_list' ] = $categories_list;
	$pvs_theme_content[ 'category_featured' ] = $category_featured;
	$pvs_theme_content[ 'category_featured_url' ] = $category_featured_url;
	$pvs_theme_content[ 'category_featured_photo' ] = $category_featured_photo;
}



//Box prints
function pvs_box_prints () {
	global $pvs_global_settings;
	global $pvs_theme_content;
	global $dr;
	global $dd;
	global $ds;
	global $_REQUEST;

	$prints_list = "";
	$prints_categories = "";
	$prints_categories_list = "";
	$prints_theproject = "";
	$prints_tshop = "";
	
	if ( @$pvs_global_settings["prints"] ) {
		$sql = "select id,title from " . PVS_DB_PREFIX .
			"prints_categories where active=1 order by priority";
		$ds->open( $sql );
		while ( ! $ds->eof ) {
			$sql = "select id_parent,title,priority from " . PVS_DB_PREFIX .
				"prints where category=" . $ds->row["id"] . " order by priority";
			$dr->open( $sql );
			if ( ! $dr->eof ) {
				$prints_categories .= "<li><a href='" . site_url() . "/index.php?search=&print_id=" . $dr->
						row["id_parent"] . "'>" . pvs_word_lang( $ds->row["title"] ) . "</a></li>";
				$prints_categories_list .= "<li class='nav-has-sub'><a href='" . site_url() . "/index.php?search=&print_id=" . $dr->
						row["id_parent"] . "'>" . pvs_word_lang( $ds->row["title"] ) . "</a>";
				$prints_theproject .= '<div class="col-lg-3  col-sm-3 col-md-3"><h4 class="hidden-xs">' . pvs_word_lang( $ds->row["title"] ) . '</h4><ul class="menu">';
				$prints_tshop .= '<ul class="col-lg-3  col-sm-3 col-md-3 col-xs-3"><li><p> <strong> ' . pvs_word_lang( $ds->row["title"] ) . ' </strong> </p></li>';
	
			
				$prints_categories_list .= "<ul class='sub-menu nav-sub-dropdown'>";
	
				while ( ! $dr->eof )
				{
					$prints_list .= "<li><a href='" . site_url() . "/index.php?search=&print_id=" . $dr->
						row["id_parent"] . "'>" . pvs_word_lang( $dr->row["title"] ) . "</a></li>";
					$prints_categories_list .= "<li><a href='" . site_url() .
						"/index.php?search=&print_id=" . $dr->row["id_parent"] . "'>" . pvs_word_lang( $dr->
						row["title"] ) . "</a></li>";
					$prints_theproject .= "<li><a href='" . site_url() .
						"/index.php?search=&print_id=" . $dr->row["id_parent"] . "'>" . pvs_word_lang( $dr->
						row["title"] ) . "</a></li>";
					$prints_tshop .= "<li><a href='" . site_url() . "/index.php?search=&print_id=" .
						$dr->row["id_parent"] . "'>" . pvs_word_lang( $dr->row["title"] ) . "</a></li>";
					$dr->movenext();
				}
	
				$prints_categories_list .= "</ul>";
			}
	
			$prints_categories_list .= "</li>";
			$prints_theproject .= '</ul></div>';
			$prints_tshop .= '</ul>';
	
			$ds->movenext();
		}
	
		$sql = "select id_parent,title,priority from " . PVS_DB_PREFIX .
			"prints where category=0 order by priority";
		$dr->open( $sql );
		if ( ! $dr->eof ) {
			$prints_categories .= "<li><a href='#'>" . pvs_word_lang( "uncategorized" ) .
				"</a></li>";
			$prints_categories_list .= "<li class='nav-has-sub'><a href='#'>" .
				pvs_word_lang( "uncategorized" ) . "</a><ul class='sub-menu nav-sub-dropdown'>";
			$prints_theproject .=
				'<div class="col-lg-3  col-sm-3 col-md-3"><h4 class="hidden-xs">' .
				pvs_word_lang( "uncategorized" ) . '</h4><ul class="menu">';
			$prints_tshop .= '<ul class="col-lg-3  col-sm-3 col-md-3 col-xs-3"><li><p> <strong> ' .
				pvs_word_lang( "uncategorized" ) . ' </strong> </p></li>';
	
			while ( ! $dr->eof ) {
				$prints_list .= "<li><a href='" . site_url() . "/index.php?search=&print_id=" . $dr->
					row["id_parent"] . "'>" . pvs_word_lang( $dr->row["title"] ) . "</a></li>";
				$prints_categories_list .= "<li><a href='" . site_url() .
					"/index.php?search=&print_id=" . $dr->row["id_parent"] . "'>" . pvs_word_lang( $dr->
					row["title"] ) . "</a></li>";
				$prints_theproject .= "<li><a href='" . site_url() .
					"/index.php?search=&print_id=" . $dr->row["id_parent"] . "'>" . pvs_word_lang( $dr->
					row["title"] ) . "</a></li>";
				$prints_tshop .= "<li><a href='" . site_url() . "/index.php?search=&print_id=" .
					$dr->row["id_parent"] . "'>" . pvs_word_lang( $dr->row["title"] ) . "</a></li>";
				$dr->movenext();
			}
	
			$prints_categories_list .= "</ul></li>";
			$prints_theproject .= '</ul></div>';
			$prints_tshop .= '</ul>';
		}
	}

	$pvs_theme_content[ 'prints_list' ] = $prints_list;
	$pvs_theme_content[ 'prints_categories' ] = $prints_categories;
	$pvs_theme_content[ 'prints_categories_list' ] = $prints_categories_list;
	$pvs_theme_content[ 'prints_theproject' ] = $prints_theproject;
	$pvs_theme_content[ 'prints_tshop' ] = $prints_tshop;
}



//Box site info
function pvs_box_site_info () {
	global $pvs_global_settings;
	global $pvs_theme_content;
	global $rs;
	global $table_prefix;
	
	$pvs_theme_content[ 'site_info' ] = '';
	
	$sql="select ID, post_title,post_name from " . $table_prefix . "posts where post_type = 'page' and post_status = 'publish' order by post_title";
	$rs->open($sql);
	while(!$rs->eof)
	{
		$pvs_theme_content[ 'site_info' ] .= '<li><a href="' . site_url( ) . '/' . $rs->row[ 'post_name' ] . '/">' . pvs_word_lang($rs->row[ 'post_title' ]) . '</a></li>';
		$rs->movenext();
	}
}	

//Box languages
function pvs_box_languages () {
	global $pvs_theme_content;
	global $lng;
	global $lang_symbol;
	global $lang_name;
	global $pvs_site_langs;
	
	$box_languages_list = "<ul>";
	
	$lang_img = "";
	
	foreach ( $pvs_site_langs as $key => $value ) {
		$lt = "";
		$sel = "selected";
		if ( $lng != $key ) {
			$lt = "style='opacity:0.7'";
			$sel = "";
		}
	
		$lng3 = strtolower( $key );
		if ( $lng3 == "chinese traditional" ) {
			$lng3 = "chinese";
		}
		if ( $lng3 == "chinese simplified" ) {
			$lng3 = "chinese";
		}
		if ( $lng3 == "afrikaans formal" ) {
			$lng3 = "afrikaans";
		}
		if ( $lng3 == "afrikaans informal" ) {
			$lng3 = "afrikaans";
		}
	
		if ( $key == $lng ) {
			$lang_img = pvs_plugins_url(). "/assets/images/languages/" . $lng3 . ".gif";
		}
		$box_languages_list .= "<li><a href='" . site_url() .
			"/language-select/?lang=" . $key . "'><img src='" . pvs_plugins_url() .
			"/assets/images/languages/" . $lng3 . ".gif' " . $lt . ">" . $key . "</a></li>";
	}
	
	$box_languages_list .= "</ul>";
	
	$pvs_theme_content[ 'lang_img' ] = $lang_img;	
	$pvs_theme_content[ 'lang_symbol' ] = $lang_symbol[$lng];
	$pvs_theme_content[ 'lang_name' ] = $lang_name[$lng];
	$pvs_theme_content[ 'languages_list' ] = $box_languages_list;
}

//Box stats
function pvs_box_stats () {
	global $pvs_theme_content;
	global $pvs_global_settings;
	global $rs;
	global $db;
	global $table_prefix;
	
	$sql = "select count(user_login) as count_login from " . $table_prefix . "users";
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		$pvs_theme_content[ 'stats_users' ] = $rs->row["count_login"];

		$sql = "update " . PVS_DB_PREFIX . "settings set svalue='" . $rs->row["count_login"] .
			"' where stype='stats' and setting_key='stats_users'";
		$db->execute( $sql );
	}

	$vt = 0;
	$downloads = 0;

	if ( @$pvs_global_settings["allow_photo"] == 1 ) {
		$sql = "select count(id) as count_photos,sum(viewed) as count_viewed,sum(downloaded) as count_downloaded from " .
			PVS_DB_PREFIX . "media where published=1 and media_id=1";
		$rs->open( $sql );
		if ( ! $rs->eof ) {
			$pvs_theme_content[ 'stats_photo' ] = $rs->row["count_photos"];
			$vt += $rs->row["count_viewed"];
			$downloads += $rs->row["count_downloaded"];

			$sql = "update " . PVS_DB_PREFIX . "settings set svalue='" . $rs->row["count_photos"] .
				"' where stype='stats' and setting_key='stats_photo'";
			$db->execute( $sql );
		}
	}

	if ( @$pvs_global_settings["allow_video"] == 1 ) {
		$sql = "select count(id) as count_videos,sum(viewed) as count_viewed,sum(downloaded) as count_downloaded from " .
			PVS_DB_PREFIX . "media where published=1 and media_id=2";
		$rs->open( $sql );
		if ( ! $rs->eof ) {
			$pvs_theme_content[ 'stats_video' ] = $rs->row["count_videos"];
			$vt += $rs->row["count_viewed"];
			$downloads += $rs->row["count_downloaded"];

			$sql = "update " . PVS_DB_PREFIX . "settings set svalue='" . $rs->row["count_videos"] .
				"' where stype='stats' and setting_key='stats_video'";
			$db->execute( $sql );
		}
	}

	if ( @$pvs_global_settings["allow_audio"] == 1 ) {
		$sql = "select count(id) as count_audio,sum(viewed) as count_viewed,sum(downloaded) as count_downloaded from " .
			PVS_DB_PREFIX . "media where published=1 and media_id=3";
		$rs->open( $sql );
		if ( ! $rs->eof ) {
			$pvs_theme_content[ 'stats_audio' ] = $rs->row["count_audio"];
			$vt += $rs->row["count_viewed"];
			$downloads += $rs->row["count_downloaded"];

			$sql = "update " . PVS_DB_PREFIX . "settings set svalue='" . $rs->row["count_audio"] .
				"' where stype='stats' and setting_key='stats_audio'";
			$db->execute( $sql );
		}
	}

	if ( @$pvs_global_settings["allow_vector"] == 1 ) {
		$sql = "select count(id) as count_vector,sum(viewed) as count_viewed,sum(downloaded) as count_downloaded from " .
			PVS_DB_PREFIX . "media where published=1 and media_id=4";
		$rs->open( $sql );
		if ( ! $rs->eof ) {
			$pvs_theme_content[ 'stats_vector' ] = $rs->row["count_vector"];
			$vt += $rs->row["count_viewed"];
			$downloads += $rs->row["count_downloaded"];

			$sql = "update " . PVS_DB_PREFIX . "settings set svalue='" . $rs->row["count_vector"] .
				"' where stype='stats' and setting_key='stats_vector'";
			$db->execute( $sql );
		}
	}
	$pvs_theme_content[ 'stats_viewes' ] = $vt;
	$pvs_theme_content[ 'stats_downloads' ] = $downloads;
}

//Box shopping cart
function pvs_box_shopping_cart() {
	global $pvs_theme_content;
	global $pvs_global_settings;
	global $rs;
	global $dr;
	global $ds;
	global $dq;
	
	require_once( PVS_PATH . 'templates/shopping_cart_add_content.php' );
	
	$pvs_theme_content[ 'shopping_cart' ] = "<div id='shopping_cart'>" . $box_shopping_cart . "</div>";
	$pvs_theme_content[ 'shopping_cart_lite' ] = "<div id='shopping_cart_lite'>" . $box_shopping_cart_lite . "</div>";
}

//Box photographers
function pvs_box_photographers() {
	global $pvs_theme_content;
	global $pvs_global_settings;
	global $rs;
	global $ds;
	global $table_prefix;

	$box_photographers = '';
	
	//Define featured categories
	$catlist = array();
	$sql = "select name,menu from " . PVS_DB_PREFIX . "user_category where menu=1";
	$rs->open( $sql );
	while ( ! $rs->eof ) {
		$catlist[] = $rs->row["name"];
		$rs->movenext();
	}
	
	//List of featured photographers
	$sql="select ID, user_login from " . $table_prefix . "users order by user_login";
	$rs->open( $sql );
	while ( ! $rs->eof ) {
		$user_info = get_userdata( $rs->row["ID"] );

		if ( ( @$user_info->utype == 'seller' or @$user_info->utype == 'common' or @$user_info->utype == '' ) and in_array(@$user_info->category, $catlist) ) {
			$qty = 0;
	
			$sql = "select id from " . PVS_DB_PREFIX . "media where author='" . $rs->row["user_login"] . "'";
			$ds->open( $sql );
			$qty += $ds->rc;
			
			if ( $qty > 0 ) {
				$box_photographers .= '<li><a href="' . pvs_user_url( $rs->row["ID"] ) . '">' . pvs_show_user_name ( $rs->row["user_login"] ) . ' &nbsp;&nbsp;<span class="label label-default">' . $qty . '</span></a></li>';
			}
		}

		$rs->movenext();
	}
	
	$pvs_theme_content[ 'photographers' ] = $box_photographers;
}

?>