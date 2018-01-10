<?php

add_theme_support( 'automatic-feed-links' );

if ( defined( 'PVS_NAME' ) ) {
	//Rewrite rules
	add_action( 'after_switch_theme', 'pvs_rewrite_rules');

	//Include template file
	add_filter('template_include', 'pvs_template_include');

	//Box categories
	pvs_box_categories();

	//Box prints
	pvs_box_prints();

	//Box site info
	pvs_box_site_info();

	//Box languages
	pvs_box_languages();

	//Box stats
	pvs_box_stats();

	//Box shopping cart
	pvs_box_shopping_cart();


}

function pvs_show_related_items2( $id, $type ) {
	global $db;
	global $ds;
	global $keywords;
	global $titles;
	global $pvs_theme_content;
	global $pvs_global_settings;

	$pvs_theme_content[ 'flag_related' ] = false;
	$sqlkey = "";

	//Relate by the first keyword
	for ( $k = 0; $k < count($keywords); $k++ )
	{
		if ($k < 1) {
			if ( $sqlkey != "" )
			{
				$sqlkey .= " or ";
			}

			$sqlkey .= " keywords like '%" . $keywords[$k] . "%' ";
		}
	}


	if ( $sqlkey != "" )
	{
		$tt = 0;

		$count_random = 0;
		$limit_random = " limit 0," . 4;

		$protected_categories = pvs_get_password_protected();

		if ( $protected_categories != "" )
		{
			$sql = "select  id, media_id, title, server1, downloaded, url, author, description from " .
			       PVS_DB_PREFIX . "media where published=1 and id <> " . ( int )$id . " and (" . $sqlkey .
			       ")  and id not in (select publication_id from " .
			       PVS_DB_PREFIX . "category_items where " . $protected_categories . ") " . $limit_random;
		} else
		{
			$sql = "select  id, media_id, title, downloaded, server1, url, author, description from " .
			       PVS_DB_PREFIX . "media where published=1 and id <> " . ( int )$id . " and (" . $sqlkey .
			       ") " . $limit_random;
		}

		$ds->open( $sql );

		if ( ! $ds->eof )
		{
			$item_content = "";

			while ( ! $ds->eof )
			{
				if ( $tt < $pvs_global_settings["related_items_quantity"] )
				{
					$item_text = $item_content;

					$preview_type = 1;
					if ( $ds->row["media_id"] == 2 or $ds->row["media_id"] == 3 )
					{
						$preview_type = 3;
					}

					$hoverbox_results = pvs_get_hoverbox( $ds->row["id"], pvs_media_type ($ds->row["media_id"]), $ds->row["server1"],
						$ds->row["title"], pvs_show_user_name( $ds->row["author"] ) );

					$preview = pvs_show_preview( $ds->row["id"], pvs_media_type ($ds->row["media_id"]), $preview_type, 1 );
					$user_data = get_user_by( 'slug', $ds->row["author"] );

					$related_id = $ds->row["id"];
					$related_downloaded = $ds->row["downloaded"];
					$related_author = $user_data->ID;
					$related_title = $ds->row["title"];
					$related_description = $ds->row["description"];
					$related_url = pvs_item_url( $ds->row["id"], $ds->row["url"] );
					$related_preview = $hoverbox_results["flow_image"];
					$related_lightbox = $hoverbox_results["hover"];
					$related_width = $hoverbox_results["flow_width"];
					$related_height = $hoverbox_results["flow_height"];

					if ($type == 'show') {
						include(get_template_directory() . "/item_related.php");
					}

					if ( $pvs_global_settings["related_items"])
					{
						$pvs_theme_content[ 'flag_related' ] = true;
					}
				}
				$tt++;

				$ds->movenext();
			}
		}
	}
}