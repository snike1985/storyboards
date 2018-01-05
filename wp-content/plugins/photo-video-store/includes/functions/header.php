<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
$flag_social = false;
$social_mass = array();
$pvs_meta_tags = '';
$pvs_meta_keywords = '';
$pvs_meta_description = '';

//Meta categories
if ( get_query_var('pvs_page') == 'category') {
	$sql = "select id, id_parent, title,priority,password,description,keywords,photo,upload,published,url from " .
		PVS_DB_PREFIX . "category where id=" . ( int )get_query_var('pvs_id');
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		$translate_results = pvs_translate_category( $rs->row["id"], $rs->row["title"],
			$rs->row["description"], $rs->row["keywords"] );

		$pvs_meta_keywords .= $translate_results["keywords"];
		$pvs_meta_description .= $translate_results["description"];
		$social_mass["type"] = "category";
		$social_mass["title"] = $translate_results["title"];
		$social_mass["keywords"] = $translate_results["keywords"];
		$social_mass["description"] = $translate_results["description"];
		$social_mass["url"] = site_url() . $rs->row["url"];
		$social_mass["author"] = "";
		$social_mass["google_x"] = 0;
		$social_mass["google_y"] = 0;
		$social_mass["data"] = 0;
		$social_mass["image"] = $rs->row["photo"];

		if ( ! preg_match( "/http/i", $social_mass["image"] ) ) {
			$social_mass["image"] = site_url() . $social_mass["image"];
		}

		$sql = "select title from " . PVS_DB_PREFIX . "category where id_parent=" . $rs->row["id_parent"];
		$ds->open( $sql );
		{
			$social_mass["category"] = $ds->row["title"];
		}
	}
}

//Meta publication
if ( get_query_var('pvs_page') == 'photo' or get_query_var('pvs_page') == 'video' or get_query_var('pvs_page') == 'audio' or get_query_var('pvs_page') == 'vector' ) {
	$sql = "select id,title,keywords,description,url,author,google_x,google_y,data,server1 from " .
		PVS_DB_PREFIX . "media where id=" . ( int )get_query_var('pvs_id');
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		$pvs_meta_keywords .= $rs->row["keywords"];
		$pvs_meta_description .= $rs->row["description"];
		$social_mass["type"] = get_query_var('pvs_page');

		if ( @$prints_flag ) {
			$social_mass["title"] = $prints_title . ": " . $rs->row["title"];
		} else {
			$social_mass["title"] = $rs->row["title"];
		}

		$social_mass["keywords"] = $rs->row["keywords"];
		$social_mass["description"] = $rs->row["description"];

		if ( @$prints_flag ) {
			$social_mass["url"] = site_url() . pvs_print_url( $rs->row["id"], ( int )$_REQUEST["print_id"],
				$rs->row["title"], $prints_preview, "" );
		} else {
			$social_mass["url"] = site_url() . $rs->row["url"];
		}

		$social_mass["author"] = $rs->row["author"];
		$social_mass["google_x"] = $rs->row["google_x"];
		$social_mass["google_y"] = $rs->row["google_y"];
		$social_mass["data"] = $rs->row["data"];
		if ( get_query_var('pvs_page') == 'photo' or get_query_var('pvs_page') == 'print') {
			$social_mass["image"] = pvs_show_preview( $rs->row["id"], "photo", 2, 1, $rs->row["server1"], $rs->row["id"] );
		}
		if ( get_query_var('pvs_page') == 'video') {
			$social_mass["image"] = pvs_show_preview( $rs->row["id"], "video", 1, 1, $rs->row["server1"], $rs->row["id"] );
		}
		if ( get_query_var('pvs_page') == 'audio') {
			$social_mass["image"] = pvs_show_preview( $rs->row["id"], "audio", 1, 1, $rs->row["server1"], $rs->row["id"] );
		}
		if ( get_query_var('pvs_page') == 'vector') {
			$social_mass["image"] = pvs_show_preview( $rs->row["id"], "vector", 2, 1, $rs->row["server1"], $rs->row["id"] );
		}

		if ( ! preg_match( "/http/i", $social_mass["image"] ) ) {
			$social_mass["image"] = site_url() . $social_mass["image"];
		}
		
		$social_mass["category"] = '';
		$sql = "select title from " . PVS_DB_PREFIX . "category where id in (select category_id from " . PVS_DB_PREFIX . "category_items where publication_id=" . $rs->row["id"] . ")";
		$ds->open( $sql );
		while (!$ds->eof) {
			if ($social_mass["category"] != '') {
				$social_mass["category"] .= ', ';
			}
			$social_mass["category"] .= $ds->row["title"];
			$ds->movenext();
		}
	}
}



//Prints
$prints_flag = false;
$prints_title_flag = true;
$prints_preview = "";
$prints_title = "";

if ( ( int ) get_query_var('pvs_print_id') > 0 ) {
	if ( $pvs_global_settings["prints_previews"] ) {
		$print_info = pvs_get_print_preview_info( ( int ) get_query_var('pvs_print_id') );
		$prints_flag = $print_info["flag"];
		$prints_preview = $print_info["preview"];
		$prints_title = $print_info["title"];
	}
} else
{
	if ( $pvs_global_settings["printsonly"] and $pvs_global_settings["prints_previews"] ) {
		$prints_mass = array();

		$sql_prints = "select id from " . PVS_DB_PREFIX .
			"prints_categories where active=1 order by priority";
		$dr->open( $sql_prints );
		while ( ! $dr->eof ) {
			$prints_mass[] = $dr->row["id"];
			$dr->movenext();
		}
		$prints_mass[] = 0;

		foreach ( $prints_mass as $key => $value ) {
			$sql_prints = "select id_parent,title from " . PVS_DB_PREFIX .
				"prints where category=" . $value . " order by priority";
			$dd->open( $sql_prints );
			if ( ! $dd->eof )
			{
				$print_info = pvs_get_print_preview_info( ( int ) get_query_var('pvs_print_id') );
				$prints_flag = $print_info["flag"];
				$prints_preview = $print_info["preview"];
				$prints_title = $print_info["title"];
				$prints_title_flag = false;
				break;
			}
		}
	}
}




//Stock API
$flag_stock = false;

if ( (int) get_query_var('pvs_print_id') > 0 ) {
    $var_print = '&print_id=' . (int) get_query_var('pvs_print_id');
} else {
    $var_print = '';
}

//Shutterstock API
if ( (int) get_query_var('shutterstock') > 0 ) {
    $auth = base64_encode( $pvs_global_settings[ "shutterstock_id" ] . ":" . $pvs_global_settings[ "shutterstock_secret" ] );
    
    $url = 'https://api.shutterstock.com/v2/images/' . (int) get_query_var('shutterstock');
    
    if ( get_query_var('shutterstock_type') == "video" ) {
        $url = 'https://api.shutterstock.com/v2/videos/' . (int) get_query_var('shutterstock');
    }
    
    if ( get_query_var('shutterstock_type') == "audio" ) {
        $url = 'https://api.shutterstock.com/v2/audio/' . (int) get_query_var('shutterstock');
    }
    
    $ch = curl_init();
    
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
         'Authorization: Basic ' . $auth 
    ) );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch, CURLOPT_USERAGENT, $_SERVER[ 'HTTP_USER_AGENT' ] );
    
    $data = curl_exec( $ch );
    if ( !curl_errno( $ch ) ) {
        $shutterstock_results = json_decode( $data );
        $flag_stock           = true;
        
        $shutterstock_keywords       = "";
        $shutterstock_keywords_links = "";
        if ( isset( $shutterstock_results->keywords ) ) {
            foreach ( $shutterstock_results->keywords as $key => $value ) {
                if ( $shutterstock_keywords != "" ) {
                    $shutterstock_keywords .= ', ';
                }
                if ( $shutterstock_keywords_links != "" ) {
                    $shutterstock_keywords_links .= ', ';
                }
                $shutterstock_keywords .= $value;
                $shutterstock_keywords_links .= '<a href="' . site_url() . '/index.php?stock=shutterstock&search=' . urlencode( $value ) . $var_print . '" >' . $value . '</a>';
            }
        }
        
        $shutterstock_categories       = "";
        $shutterstock_categories_links = "";
        if ( isset( $shutterstock_results->categories ) ) {
            foreach ( $shutterstock_results->categories as $key => $value ) {
                if ( $shutterstock_categories != "" ) {
                    $shutterstock_categories .= ', ';
                }
                if ( $shutterstock_categories_links != "" ) {
                    $shutterstock_categories_links .= ', ';
                }
                $shutterstock_categories .= @$value->name;
                $shutterstock_categories_links .= '<a href="' . site_url() . '/index.php?stock=shutterstock&category=' . @$value->id . $var_print . '" >' . @$value->name . '</a>';
            }
        }
        
        $meta_title = @$shutterstock_results->description;
        $pvs_meta_keywords .= $shutterstock_keywords;
        $pvs_meta_description .= @$shutterstock_results->description;
        $social_mass[ "type" ]        = @$shutterstock_results->media_type;
        $social_mass[ "title" ]       = @$shutterstock_results->description;
        $social_mass[ "keywords" ]    = $shutterstock_keywords;
        $social_mass[ "description" ] = @$shutterstock_results->description;
        if ( (int)get_query_var('pvs_print_id') > 0 ) {
            $social_mass[ "url" ] = site_url() . pvs_print_url( @$shutterstock_results->id, (int) get_query_var('pvs_print_id'), @$shutterstock_results->description, $prints_preview, "shutterstock" );
        } else {
            $social_mass[ "url" ] = site_url() . pvs_get_stock_page_url( "shutterstock", @$shutterstock_results->id, @$shutterstock_results->description, pvs_result( get_query_var('shutterstock_type') ) );
        }
        $social_mass[ "author" ]   = "Shutterstock Contributor ID #" . @$shutterstock_results->contributor->id;
        $social_mass[ "google_x" ] = "";
        $social_mass[ "google_y" ] = "";
        $social_mass[ "data" ]     = @$shutterstock_results->added_date;
        
        if ( get_query_var('shutterstock_type') == "video" ) {
            $social_mass[ "image" ] = @$shutterstock_results->assets->thumb_jpg->url;
        } elseif ( get_query_var('shutterstock_type') == "audio" ) {
            $social_mass[ "image" ] = @$shutterstock_results->assets->waveform->url;
        } else {
            $social_mass[ "image" ] = @$shutterstock_results->assets->small_thumb->url;
        }
        
        $social_mass[ "category" ] = $shutterstock_categories;
    }
}
//End. Shutterstock API





//Fotolia API
if ( (int) get_query_var('fotolia') > 0 ) {
    $auth = base64_encode( $pvs_global_settings[ "fotolia_id" ] . ":" );
    
    $url = 'http://api.fotolia.com/Rest/1/media/getMediaData?id=' . (int) get_query_var('fotolia');
    
    $ch = curl_init();
    
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
         'Authorization: Basic ' . $auth 
    ) );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch, CURLOPT_USERAGENT, $_SERVER[ 'HTTP_USER_AGENT' ] );
    
    $data = curl_exec( $ch );
    if ( !curl_errno( $ch ) ) {
        $fotolia_results = json_decode( $data );
        $flag_stock      = true;
        
        $fotolia_keywords       = "";
        $fotolia_keywords_links = "";
        if ( isset( $fotolia_results->keywords ) ) {
            foreach ( $fotolia_results->keywords as $key => $value ) {
                if ( $fotolia_keywords != "" ) {
                    $fotolia_keywords .= ', ';
                }
                if ( $fotolia_keywords_links != "" ) {
                    $fotolia_keywords_links .= ', ';
                }
                $fotolia_keywords .= $value->name;
                $fotolia_keywords_links .= '<a href="' . site_url() . '/index.php?stock=fotolia&search=' . urlencode( $value->name ) . $var_print . '" >' . $value->name . '</a>';
            }
        }
        
        $fotolia_categories       = "";
        $fotolia_categories_links = "";
        if ( isset( $fotolia_results->cat1_hierarchy ) ) {
            foreach ( $fotolia_results->cat1_hierarchy as $key => $value ) {
                if ( $fotolia_categories != "" ) {
                    $fotolia_categories .= ', ';
                }
                if ( $fotolia_categories_links != "" ) {
                    $fotolia_categories_links .= ', ';
                }
                $fotolia_categories .= @$value->name;
                $fotolia_categories_links .= '<a href="' . site_url() . '/index.php?stock=fotolia&category=' . @$value->id . $var_print . '" >' . @$value->name . '</a>';
            }
        }
        
        $meta_title = @$fotolia_results->title;
        $pvs_meta_keywords .= $fotolia_keywords;
        $pvs_meta_description .= @$fotolia_results->title;
        if ( @$fotolia_results->media_type_id == 1 ) {
            $social_mass[ "type" ] = "photo";
        }
        if ( @$fotolia_results->media_type_id == 2 ) {
            $social_mass[ "type" ] = "illustration";
        }
        if ( @$fotolia_results->media_type_id == 3 ) {
            $social_mass[ "type" ] = "vector";
        }
        if ( @$fotolia_results->media_type_id == 4 ) {
            $social_mass[ "type" ] = "video";
        }
        
        $fotolia_type = "photo";
        if ( @$value->media_type_id == 4 ) {
            $fotolia_type = "video";
        }
        
        $social_mass[ "title" ]       = @$fotolia_results->title;
        $social_mass[ "keywords" ]    = $fotolia_keywords;
        $social_mass[ "description" ] = "";
        
        if ( (int)get_query_var('pvs_print_id') > 0 ) {
            $social_mass[ "url" ] = site_url() . pvs_print_url( @$fotolia_results->id, (int) get_query_var('pvs_print_id'), @$fotolia_results->title, $prints_preview, "fotolia" );
        } else {
            $social_mass[ "url" ] = site_url() . pvs_get_stock_page_url( "fotolia", @$fotolia_results->id, @$fotolia_results->title, $fotolia_type );
        }
        $social_mass[ "author" ]   = "Fotolia Contributor " . @$fotolia_results->creator_name;
        $social_mass[ "google_x" ] = "";
        $social_mass[ "google_y" ] = "";
        $social_mass[ "data" ]     = @$fotolia_results->creation_date;
        $social_mass[ "image" ]    = @$fotolia_results->thumbnail_url;
        $social_mass[ "category" ] = $fotolia_categories;
    }
}
//End. Fotolia API


//Istockphoto API
if ( (int) get_query_var('istockphoto') > 0 ) {
    if ( get_query_var('istockphoto_type') == 'photo' ) {
        $url = 'https://api.gettyimages.com/v3/images/' . (int) get_query_var('istockphoto') . "/?fields=artist,artist_title,asset_family,call_for_image,caption,city,collection_code,collection_id,collection_name,color_type,comp,copyright,country,credit_line,date_created,date_submitted,detail_set,display_set,download_sizes,editorial_segments,event_ids,graphical_style,id,keywords,license_model,links,max_dimensions,orientation,people,prestige,preview,product_types,quality_rank,referral_destinations,thumb,title";
    } else {
        $url = 'https://api.gettyimages.com/v3/videos/' . (int) get_query_var('istockphoto') . '/?fields=id,allowed_use,artist,asset_family,caption,clip_length,collection_code,collection_id,collection_name,color_type,copyright,comp,date_created,display_set,download_sizes,era,editorial_segments,keywords,license_model,mastered_to,originally_shot_on,preview,product_types,shot_speed,source,thumb,title';
    }
    //echo($url);
    $ch = curl_init();
    
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
         'Api-Key: ' . $pvs_global_settings[ "istockphoto_id" ] 
    ) );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch, CURLOPT_USERAGENT, $_SERVER[ 'HTTP_USER_AGENT' ] );
    
    $data = curl_exec( $ch );
    if ( !curl_errno( $ch ) ) {
        $results    = json_decode( $data );
        $flag_stock = true;
        
        //var_dump($results);exit();
        
        if ( get_query_var('istockphoto_type') == 'photo' ) {
            $data2 = $results->images;
        } else {
            $data2[ 0 ] = $results;
        }
        
        foreach ( $data2 as $key => $value ) {
            $istockphoto_results = $value;
            
            $istockphoto_keywords         = "";
            $istockphoto_keywords_links   = "";
            $istockphoto_keywords_related = "";
            if ( isset( $istockphoto_results->keywords ) ) {
                $kk = 0;
                foreach ( $istockphoto_results->keywords as $key2 => $value2 ) {
                    if ( isset( $value2->text ) ) {
                        if ( $istockphoto_keywords != "" ) {
                            $istockphoto_keywords .= ', ';
                        }
                        if ( $istockphoto_keywords_links != "" ) {
                            $istockphoto_keywords_links .= ', ';
                        }
                        $istockphoto_keywords .= @$value2->text;
                        $istockphoto_keywords_links .= '<a href="' . site_url() . '/index.php?stock=istockphoto&search=' . urlencode( @$value2->text ) . $var_print . '" >' . @$value2->text . '</a>';
                        if ( $kk == 0 ) {
                            $istockphoto_keywords_related = @$value2->text;
                        }
                        
                        $kk++;
                    }
                }
            }
            
            if ( get_query_var('istockphoto_type') == 'photo' ) {
                $social_mass[ "type" ] = "photo";
                $istockphoto_type      = "photo";
            } else {
                $social_mass[ "type" ] = "video";
                $istockphoto_type      = "video";
            }
            
            $istockphoto_categories       = @$istockphoto_results->collection_name;
            $istockphoto_categories_links = @$istockphoto_results->collection_name;
            
            $meta_title = @$istockphoto_results->title;
            $pvs_meta_keywords .= $istockphoto_keywords;
            $pvs_meta_description .= @$istockphoto_results->title;
            
            $social_mass[ "title" ]       = @$istockphoto_results->title;
            $social_mass[ "keywords" ]    = $istockphoto_keywords;
            $social_mass[ "description" ] = "";
            
            if ( (int)get_query_var('pvs_print_id') > 0 ) {
                $social_mass[ "url" ] = site_url() . pvs_print_url( @$istockphoto_results->id, (int) get_query_var('pvs_print_id'), @$istockphoto_results->title, $prints_preview, "istockphoto" );
            } else {
                $social_mass[ "url" ] = site_url() . pvs_get_stock_page_url( "istockphoto", @$istockphoto_results->id, @$istockphoto_results->title, $istockphoto_type );
            }
            $social_mass[ "author" ]   = "Istockphoto Artist " . @$istockphoto_results->artist;
            $social_mass[ "google_x" ] = "";
            $social_mass[ "google_y" ] = "";
            $social_mass[ "data" ]     = @$istockphoto_results->date_submitted;
            
            $istockphoto_image = @$istockphoto_results->display_sizes;
            if ( get_query_var('istockphoto_type') == 'photo' ) {
                $istockphoto_preview = $istockphoto_image[ 0 ];
            } else {
                $istockphoto_preview = $istockphoto_image[ 2 ];
            }
            $social_mass[ "image" ] = $istockphoto_preview->uri;
            
            
            $social_mass[ "category" ] = $istockphoto_categories;
        }
    }
}
//End. Istockphoto API







//Depositphotos API
if ( (int) get_query_var('depositphotos') > 0 ) {
    $url = 'http://api.depositphotos.com?dp_apikey=' . $pvs_global_settings[ "depositphotos_id" ] . '&dp_command=getMediaData&dp_media_id=' . (int) get_query_var('depositphotos');
    
    $ch = curl_init();
    
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch, CURLOPT_USERAGENT, $_SERVER[ 'HTTP_USER_AGENT' ] );
    
    $data = curl_exec( $ch );
    if ( !curl_errno( $ch ) ) {
        $depositphotos_results = json_decode( $data );
        $flag_stock            = true;
        
        $depositphotos_keywords       = "";
        $depositphotos_keywords_links = "";
        if ( isset( $depositphotos_results->tags ) ) {
            foreach ( $depositphotos_results->tags as $key => $value ) {
                if ( $depositphotos_keywords != "" ) {
                    $depositphotos_keywords .= ', ';
                }
                if ( $depositphotos_keywords_links != "" ) {
                    $depositphotos_keywords_links .= ', ';
                }
                $depositphotos_keywords .= $value;
                $depositphotos_keywords_links .= '<a href="' . site_url() . '/index.php?stock=depositphotos&search=' . urlencode( $value ) . $var_print . '" >' . $value . '</a>';
            }
        }
        
        $depositphotos_categories       = "";
        $depositphotos_categories_links = "";
        if ( isset( $depositphotos_results->categories ) ) {
            foreach ( $depositphotos_results->categories as $key => $value ) {
                if ( $depositphotos_categories != "" ) {
                    $depositphotos_categories .= ', ';
                }
                if ( $depositphotos_categories_links != "" ) {
                    $depositphotos_categories_links .= ', ';
                }
                $depositphotos_categories .= @$value;
                $depositphotos_categories_links .= '<a href="' . site_url(). '/index.php?stock=depositphotos&category=' . @$key . $var_print . '" >' . @$value . '</a>';
            }
        }
        
        $meta_title = @$depositphotos_results->title;
        $pvs_meta_keywords .= $depositphotos_keywords;
        $pvs_meta_description .= @$depositphotos_results->description;
        $social_mass[ "type" ]        = @$depositphotos_results->itype;
        $social_mass[ "title" ]       = @$depositphotos_results->title;
        $social_mass[ "keywords" ]    = $depositphotos_keywords;
        $social_mass[ "description" ] = @$depositphotos_results->description;
        
        if ( (int)get_query_var('pvs_print_id') > 0 ) {
            $social_mass[ "url" ] = site_url() . pvs_print_url( @$depositphotos_results->id, (int) get_query_var('pvs_print_id'), @$depositphotos_results->title, $prints_preview, "depositphotos" );
        } else {
            $social_mass[ "url" ] = site_url() . pvs_get_stock_page_url( "depositphotos", @$depositphotos_results->id, @$depositphotos_results->title, pvs_result( get_query_var('depositphotos_type') ) );
        }
        $social_mass[ "author" ]   = "Depositphotos Contributor -  " . @$depositphotos_results->username;
        $social_mass[ "google_x" ] = "";
        $social_mass[ "google_y" ] = "";
        $social_mass[ "data" ]     = @$depositphotos_results->published;
        
        if ( get_query_var('depositphotos_type') == "photo" ) {
            $social_mass[ "image" ] = @$depositphotos_results->huge_thumb;
        } else {
            $social_mass[ "image" ] = @$depositphotos_results->huge_thumb;
        }
        
        $social_mass[ "category" ] = $depositphotos_categories;
    }
}
//End. depositphotos API







//Bigstockphoto API
if ( (int) get_query_var('bigstockphoto') > 0 ) {
    $url = 'https://api.bigstockphoto.com/2/' . $pvs_global_settings[ "bigstockphoto_id" ] . '/image/' . (int) get_query_var('bigstockphoto');
    
    $ch = curl_init();
    
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch, CURLOPT_USERAGENT, $_SERVER[ 'HTTP_USER_AGENT' ] );
    
    $data = curl_exec( $ch );
    if ( !curl_errno( $ch ) ) {
        $bigstockphoto_results2 = json_decode( $data );
        $bigstockphoto_results  = $bigstockphoto_results2->data->image;
        
        $flag_stock = true;
        
        $bigstockphoto_keywords       = $bigstockphoto_results->keywords;
        $kw                           = explode( ",", $bigstockphoto_keywords );
        $bigstockphoto_keywords_links = "";
        foreach ( $kw as $key => $value ) {
            if ( $bigstockphoto_keywords_links != "" ) {
                $bigstockphoto_keywords_links .= ', ';
            }
            $bigstockphoto_keywords_links .= '<a href="' . site_url() . '/index.php?stock=bigstockphoto&search=' . urlencode( $value ) . $var_print . '" >' . $value . '</a>';
        }
        
        $bigstockphoto_categories       = "";
        $bigstockphoto_categories_links = "";
        if ( isset( $bigstockphoto_results->categories ) ) {
            foreach ( $bigstockphoto_results->categories as $key => $value ) {
                if ( $bigstockphoto_categories != "" ) {
                    $bigstockphoto_categories .= ', ';
                }
                if ( $bigstockphoto_categories_links != "" ) {
                    $bigstockphoto_categories_links .= ', ';
                }
                $bigstockphoto_categories .= @$value->name;
                $bigstockphoto_categories_links .= '<a href="' . site_url() . '/index.php?stock=bigstockphoto&category=' . urlencode( @$value->name ) . $var_print . '" >' . @$value->name . '</a>';
            }
        }
        
        $meta_title = @$bigstockphoto_results->title;
        $pvs_meta_keywords .= $bigstockphoto_keywords;
        $pvs_meta_description .= @$bigstockphoto_results->description;
        $social_mass[ "type" ]        = "photo";
        $social_mass[ "title" ]       = @$bigstockphoto_results->title;
        $social_mass[ "keywords" ]    = $bigstockphoto_keywords;
        $social_mass[ "description" ] = @$bigstockphoto_results->description;
        
        if ( (int)get_query_var('pvs_print_id') > 0 ) {
            $social_mass[ "url" ] = site_url() . pvs_print_url( @$bigstockphoto_results->id, (int) get_query_var('pvs_print_id'), @$bigstockphoto_results->title, $prints_preview, "bigstockphoto" );
        } else {
            $social_mass[ "url" ] = site_url() . pvs_get_stock_page_url( "bigstockphoto", @$bigstockphoto_results->id, @$bigstockphoto_results->title, "photo" );
        }
        $social_mass[ "author" ]   = "Bigstockphoto Contributor -  " . @$bigstockphoto_results->contributor;
        $social_mass[ "google_x" ] = "";
        $social_mass[ "google_y" ] = "";
        $social_mass[ "data" ]     = "";
        $social_mass[ "image" ]    = @$bigstockphoto_results->preview->url;
        $social_mass[ "category" ] = $bigstockphoto_categories;
    }
}
//End. Bigstockphoto API







//123rf API
if ( (int) get_query_var('rf123') > 0 ) {
    $url = 'http://api.123rf.com/rest/?method=123rf.images.getInfo.V2&apikey=' . $pvs_global_settings[ "rf123_id" ] . '&imageid=' . (int) get_query_var('rf123') . '&ies=1';
    
    $ch = curl_init();
    
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch, CURLOPT_USERAGENT, $_SERVER[ 'HTTP_USER_AGENT' ] );
    
    $data = curl_exec( $ch );
    if ( !curl_errno( $ch ) ) {
        $rf123_results2 = json_decode( json_encode( simplexml_load_string( $data ) ) );
        
        $rf123_results = $rf123_results2->image;
        
        $flag_stock = true;
        
        $rf123_keywords         = "";
        $rf123_keywords_links   = "";
        $rf123_keywords_similar = "";
        $kk                     = 0;
        foreach ( $rf123_results->keywords->keyword as $key => $value ) {
            if ( $rf123_keywords != "" ) {
                $rf123_keywords .= ', ';
            }
            if ( $rf123_keywords_links != "" ) {
                $rf123_keywords_links .= ', ';
            }
            $rf123_keywords_links .= '<a href="' . site_url() . '/index.php?stock=rf123&search=' . urlencode( $value ) . $var_print . '" >' . $value . '</a>';
            $rf123_keywords .= $value;
            
            if ( $kk < 2 ) {
                $rf123_keywords_similar .= $value . " ";
            }
            
            $kk++;
        }
        
        $rf123_categories       = "";
        $rf123_categories_links = "";
        
        $meta_title = @$rf123_results->description;
        $pvs_meta_keywords .= $rf123_keywords;
        $pvs_meta_description .= @$rf123_results->description;
        $social_mass[ "type" ]        = "photo";
        $social_mass[ "title" ]       = @$rf123_results->description;
        $social_mass[ "keywords" ]    = $rf123_keywords;
        $social_mass[ "description" ] = @$rf123_results->description;
        
        if ( (int)get_query_var('pvs_print_id') > 0 ) {
            $social_mass[ "url" ] = site_url() . pvs_print_url( @$rf123_results->{"@attributes"}->id, (int) get_query_var('pvs_print_id'), @$rf123_results->description, $prints_preview, "123rf" );
        } else {
            $social_mass[ "url" ] = site_url() . pvs_get_stock_page_url( "123rf", @$rf123_results->{"@attributes"}->id, @$rf123_results->description, "photo" );
        }
        $social_mass[ "author" ]   = "123rf Contributor -  " . @$rf123_results->contributor->{"@attributes"}->id;
        $social_mass[ "google_x" ] = "";
        $social_mass[ "google_y" ] = "";
        $social_mass[ "data" ]     = "";
        
        $preview = 'http://images.assetsdelivery.com/compings/' . @$rf123_results->contributor->{"@attributes"}->id . '/' . @$rf123_results->{"@attributes"}->folder . '/' . @$rf123_results->{"@attributes"}->filename . '.jpg';
        
        $social_mass[ "image" ]    = $preview;
        $social_mass[ "category" ] = $rf123_categories;
    }
}
//End. 123rf API



//Pixabay API
if ( (int) get_query_var('pixabay') > 0 ) {
    $url = 'https://pixabay.com/api/?key=' . $pvs_global_settings[ "pixabay_id" ] . '&id=' . (int) get_query_var('pixabay');
    
    if ( get_query_var('pixabay_type') == "videos" ) {
        $url = 'https://pixabay.com/api/videos/?key=' . $pvs_global_settings[ "pixabay_id" ] . '&id=' . (int) get_query_var('pixabay');
    }
    
    
    $ch = curl_init();
    
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch, CURLOPT_USERAGENT, $_SERVER[ 'HTTP_USER_AGENT' ] );
    
    $data = curl_exec( $ch );
    if ( !curl_errno( $ch ) ) {
        $pixabay_results2 = json_decode( $data );
        $flag_stock       = true;
        
        foreach ( $pixabay_results2->hits as $key => $value ) {
            $pixabay_results        = @$value;
            $pixabay_keywords       = @$value->tags;
            $pixabay_keywords_links = "";
            if ( isset( $value->tags ) ) {
                $pixabay_kw = explode( ", ", $value->tags );
                foreach ( $pixabay_kw as $key2 => $value2 ) {
                    if ( $pixabay_keywords_links != "" ) {
                        $pixabay_keywords_links .= ', ';
                    }
                    $pixabay_keywords_links .= '<a href="' . site_url() . '/index.php?stock=pixabay&search=' . urlencode( $value2 ) . $var_print . '" >' . $value2 . '</a>';
                }
            }
            
            $pixabay_categories       = "";
            $pixabay_categories_links = "";
            
            $meta_title = @$value->tags;
            $pvs_meta_keywords .= @$value->tags;
            $pvs_meta_description .= "";
            $social_mass[ "type" ]        = @$value->type;
            $social_mass[ "title" ]       = @$value->tags;
            $social_mass[ "keywords" ]    = @$value->tags;
            $social_mass[ "description" ] = "";
            
            if ( (int)get_query_var('pvs_print_id') > 0 ) {
                $social_mass[ "url" ] = site_url() . pvs_print_url( @$value->id, (int) get_query_var('pvs_print_id'), @$value->tags, $prints_preview, "pixabay" );
            } else {
                $social_mass[ "url" ] = site_url() . pvs_get_stock_page_url( "pixabay", @$value->id, @$value->tags, pvs_result( get_query_var('pixabay_type') ) );
            }
            $social_mass[ "author" ]   = "Pixabay Contributor: " . @$value->user;
            $social_mass[ "google_x" ] = "";
            $social_mass[ "google_y" ] = "";
            $social_mass[ "data" ]     = "";
            
            if ( get_query_var('pixabay_type') == "videos" ) {
                $social_mass[ "image" ] = "https://i.vimeocdn.com/video/" . @$value->picture_id . "_295x166.jpg";
            } else {
                $social_mass[ "image" ] = @$value->previewURL;
            }
            
            $social_mass[ "category" ] = $pixabay_categories;
        }
    }
}
//End. Pixabay API


//Build meta tags
if ( isset( $social_mass["type"] ) ) {
	$meta_key = strtolower( preg_replace( '/[^a-z0-9_]/i', '', str_replace( " ", "_", get_bloginfo('name') ) ) );
	$pvs_meta_tags .= "<meta content=\"" . $meta_key . ":" . $social_mass["type"] . "\" property=\"og:type\" />\n";
	$pvs_meta_tags .= "<meta content=\"" . $social_mass["url"] . "\" property=\"og:url\" />\n";
	$pvs_meta_tags .= "<meta content=\"" . $social_mass["title"] . "\" property=\"og:title\" />\n";
	$pvs_meta_tags .= "<meta content=\"" . $social_mass["description"] . "\" property=\"og:description\" />\n";
	$pvs_meta_tags .= "<meta content=\"" . $social_mass["image"] . "\" property=\"og:image\" />\n";

	if ( $social_mass["author"] != "" ) {
		$pvs_meta_tags .= "<meta content=\"" . $social_mass["author"] . "\" property=\"" . $meta_key .
			":author\" />\n";
	}

	$pvs_meta_tags .= "<meta content=\"" . $social_mass["category"] . "\" property=\"" .
		$meta_key . ":category\" />\n";

	if ( $social_mass["google_x"] != 0 ) {
		$pvs_meta_tags .= "<meta content=\"" . $social_mass["google_x"] . "\" property=\"" .
			$meta_key . ":location:latitude\" />\n";
	}

	if ( $social_mass["google_y"] != 0 ) {
		$pvs_meta_tags .= "<meta content=\"" . $social_mass["google_y"] . "\" property=\"" .
			$meta_key . ":location:longitude\" />\n";
	}

	if ( is_int( $social_mass["data"] ) ) {
		if ( $social_mass["data"] != 0 )
		{
			$pvs_meta_tags .= "<meta content=\"" . date( date_short, $social_mass["data"] ) . "\" property=\"" .
				$meta_key . ":uploaded\" />\n";
		}
	} else {
		$pvs_meta_tags .= "<meta content=\"" . $social_mass["data"] . "\" property=\"" . $meta_key .
			":uploaded\" />\n";
	}

	$keywords = explode( ",", str_replace( ";", ",", $social_mass["keywords"] ) );
	for ( $i = 0; $i < count( $keywords ); $i++ ) {
		$keywords[$i] = trim( $keywords[$i] );
		if ( $keywords[$i] != "" )
		{
			$pvs_meta_tags .= "<meta content=\"" . $keywords[$i] . "\" property=\"" . $meta_key .
				":tags\" />\n";
		}
	}

	$pvs_meta_tags .= "<meta property=\"twitter:card\" value=\"photo\" />\n";
	$pvs_meta_tags .= "<meta property=\"twitter:site\" value=\"@" . get_bloginfo('name') .
		"\" />\n";

	if ( $social_mass["author"] != "" ) {
		$pvs_meta_tags .= "<meta property=\"twitter:creator\" value=\"@" . $social_mass["author"] .
			"\" />\n";
	}

	$pvs_meta_tags .= "<meta property=\"twitter:url\" value=\"" . $social_mass["url"] .
		"\" />\n";
	$pvs_meta_tags .= "<meta property=\"twitter:title\" value=\"" . $social_mass["title"] .
		"\" />\n";
	$pvs_meta_tags .= "<meta property=\"twitter:image\" value=\"" . $social_mass["image"] .
		"\" />\n";
}


//Get title
$pvs_pagename_separator = " - ";
$pvs_pagename = '';

$pvs_path = "";
$pvs_path_left = "<li>";
$pvs_path_right = "</li>";


if ( get_query_var('pvs_page') == "contacts" ) {
	$pvs_pagename .= $pvs_pagename_separator . pvs_word_lang( "contacts" );
	$pvs_path = $pvs_path_left . pvs_word_lang( "contacts" ) . $pvs_path_right;
}
if ( get_query_var('pvs_page') == "support" ) {
	$pvs_pagename .= $pvs_pagename_separator . pvs_word_lang( "support" );
	$pvs_path = $pvs_path_left . pvs_word_lang( "support" ) . $pvs_path_right;
}
if ( get_query_var('pvs_page') == "cart" ) {
	$pvs_pagename .= $pvs_pagename_separator . pvs_word_lang( "shopping cart" );
	$pvs_path = $pvs_path_left . pvs_word_lang( "shopping cart" ) . $pvs_path_right;
}
if ( get_query_var('pvs_page') == "checkout" ) {
	$pvs_pagename .= $pvs_pagename_separator . pvs_word_lang( "checkout" );
	$pvs_path = $pvs_path_left . pvs_word_lang( "checkout" ) . $pvs_path_right;
}

if ( get_query_var('pvs_page') == "photo" or get_query_var('pvs_page') == "print" or get_query_var('pvs_page') == "video" or get_query_var('pvs_page') == "audio" or get_query_var('pvs_page') == "vector") {
	$sql="select title from " . PVS_DB_PREFIX . "media where id=" . (int)get_query_var('pvs_id');
	$ds->open($sql);
	if(!$ds->eof) {
		$pvs_pagename = $pvs_pagename_separator . $ds->row["title"];
		if ((int)get_query_var('pvs_print_id') > 0) {
			$print_info = pvs_get_print_preview_info( ( int ) get_query_var('pvs_print_id') );
			$pvs_pagename .= $pvs_pagename_separator . pvs_word_lang( $print_info["title"] );
		}
	}
	
	$sql="select category_id from " . PVS_DB_PREFIX . "category_items where publication_id=" . (int)get_query_var('pvs_id');
	$ds->open($sql);
	if(!$ds->eof) {
		$pvs_path = pvs_get_title_path( 0, $ds->row["category_id"], "category", "title", "", "", true );
	}	
}

if ( get_query_var('pvs_page') == "category") {
	if ( get_query_var('pvs_search') == "" ) {
		$sql="select title from " . PVS_DB_PREFIX . "category where id=" . (int)get_query_var('pvs_id');
		$ds->open($sql);
		if(!$ds->eof) {
			$pvs_pagename = $pvs_pagename_separator . $ds->row["title"];
			$pvs_path = pvs_get_title_path( 0, (int)get_query_var('pvs_id'), "category", "title", "", "", true );
		}	
	} else {
		$pvs_pagename .= $pvs_pagename_separator . get_query_var('pvs_search');
		$pvs_path = $pvs_path_left . get_query_var('pvs_search') . $pvs_path_right;
	}
}

if ( get_query_var('pvs_page') == "orders" ) {
	$pvs_pagename .= $pvs_pagename_separator . pvs_word_lang( "orders" );
	$pvs_path = $pvs_path_left . pvs_word_lang( "orders" ) . $pvs_path_right;
}
if ( get_query_var('pvs_page') == "profile" ) {
	$pvs_pagename .= $pvs_pagename_separator . pvs_word_lang( "my profile" );
	$pvs_path = $pvs_path_left . pvs_word_lang( "my profile" ) . $pvs_path_right;
}


if ( get_query_var('pvs_page') == "languages" ) {
	$pvs_pagename .= $pvs_pagename_separator . pvs_word_lang( "languages" );
	$pvs_path = $pvs_path_left . pvs_word_lang( "languages" ) . $pvs_path_right;
}
if ( get_query_var('pvs_page') == "categories" ) {
	$pvs_pagename .= $pvs_pagename_separator . pvs_word_lang( "categories" );
	$pvs_path = $pvs_path_left . pvs_word_lang( "Browse categories" ) . $pvs_path_right;
}
if ( get_query_var('pvs_page') == "profile_about" ) {
	$pvs_pagename .= $pvs_pagename_separator . pvs_word_lang( "my profile" );
	$pvs_path = $pvs_path_left . pvs_word_lang( "my profile" ) . $pvs_path_right;
}
if ( get_query_var('pvs_page') == "credits" ) {
	$pvs_pagename .= $pvs_pagename_separator . pvs_word_lang( "credits" );
	$pvs_path = $pvs_path_left . pvs_word_lang( "credits" ) . $pvs_path_right;
}
if ( get_query_var('pvs_page') == "subscription" ) {
	$pvs_pagename .= $pvs_pagename_separator . pvs_word_lang( "subscription" );
	$pvs_path = $pvs_path_left . pvs_word_lang( "subscription" ) . $pvs_path_right;
}
if ( preg_match("/profile-downloads/", get_query_var('pvs_page')) ) {
	$pvs_pagename .= $pvs_pagename_separator . pvs_word_lang( "my downloads" );
	$pvs_path = $pvs_path_left . pvs_word_lang( "my downloads" ) . $pvs_path_right;
}
if ( get_query_var('pvs_page') == "coupons" ) {
	$pvs_pagename .= $pvs_pagename_separator . pvs_word_lang( "coupons" );
	$pvs_path = $pvs_path_left . pvs_word_lang( "coupons" ) . $pvs_path_right;
}
if ( preg_match("/printslab/", get_query_var('pvs_page')) ) {
	$pvs_pagename .= $pvs_pagename_separator . pvs_word_lang( "prints lab" );
	$pvs_path = $pvs_path_left . pvs_word_lang( "prints lab" ) . $pvs_path_right;
}
if ( get_query_var('pvs_page') == "my-favorite-list" ) {
	$pvs_pagename .= $pvs_pagename_separator . pvs_word_lang( "my favorite list" );
	$pvs_path = $pvs_path_left . pvs_word_lang( "my favorite list" ) . $pvs_path_right;
}
if ( get_query_var('pvs_page') == "friends" ) {
	$pvs_pagename .= $pvs_pagename_separator . pvs_word_lang( "friends" );
	$pvs_path = $pvs_path_left . pvs_word_lang( "friends" ) . $pvs_path_right;
}
if ( get_query_var('pvs_page') == "messages" ) {
	$pvs_pagename .= $pvs_pagename_separator . pvs_word_lang( "messages" );
	$pvs_path = $pvs_path_left . pvs_word_lang( "messages" ) . $pvs_path_right;
}

if ( get_query_var('pvs_page') == "reviews" ) {
	$pvs_pagename .= $pvs_pagename_separator . pvs_word_lang( "comments" );
	$pvs_path = $pvs_path_left . pvs_word_lang( "comments" ) . $pvs_path_right;
}
if ( get_query_var('pvs_page') == "testimonials" ) {
	$pvs_pagename .= $pvs_pagename_separator . pvs_word_lang( "testimonials" );
	$pvs_path = $pvs_path_left . pvs_word_lang( "testimonials" ) . $pvs_path_right;
}
if ( preg_match("/upload/", get_query_var('pvs_page')) or preg_match("/publication/", get_query_var('pvs_page'))  ) {
	$pvs_pagename .= $pvs_pagename_separator . pvs_word_lang( "my upload" );
	$pvs_path = $pvs_path_left . pvs_word_lang( "my upload" ) . $pvs_path_right;
}
if ( get_query_var('pvs_page') == "commission" ) {
	$pvs_pagename .= $pvs_pagename_separator . pvs_word_lang( "my commission" );
	$pvs_path = $pvs_path_left . pvs_word_lang( "my commission" ) . $pvs_path_right;
}
if ( get_query_var('pvs_page') == "affiliate" ) {
	$pvs_pagename .= $pvs_pagename_separator . pvs_word_lang( "affiliate" );
	$pvs_path = $pvs_path_left . pvs_word_lang( "affiliate" ) . $pvs_path_right;
}
if ( get_query_var('pvs_page') == "license" ) {
	$pvs_pagename .= $pvs_pagename_separator . pvs_word_lang( "license" );
	$pvs_path = $pvs_path_left . pvs_word_lang( "license" ) . $pvs_path_right;
}
if ( get_query_var('pvs_page') == "models" ) {
	$pvs_pagename .= $pvs_pagename_separator . pvs_word_lang( "models" );
	$pvs_path = $pvs_path_left . pvs_word_lang( "models" ) . $pvs_path_right;
}
if ( get_query_var('pvs_page') == "map" ) {
	$pvs_pagename .= " - Google map";
	$pvs_path = $pvs_path_left . "Google map" . $pvs_path_right;
}

if ( get_query_var('pvs_page') == "user" ) {

	$user_info = get_user_by("login", get_query_var('pvs_user_id'));
	$pvs_pagename .= $pvs_pagename_separator . pvs_word_lang( "user" ) . $pvs_pagename_separator . @$user_info -> user_login;
	$pvs_path = $pvs_path_left . "<a href='" . site_url() . "/users/'>" . pvs_word_lang( "users" ) . "</a>" . $pvs_path_right . $pvs_path_left . @$user_info -> user_login . $pvs_path_right;
}
if ( get_query_var('pvs_page') == "user_portfolio" ) {
	$pvs_pagename .= $pvs_pagename_separator . pvs_word_lang( "portfolio" ) . $pvs_pagename_separator . $name_user;
	$pvs_path = $pvs_path_left . pvs_word_lang( "portfolio" ) . $pvs_path_right . $pvs_path_left . $name_user .
		$pvs_path_right;
}

if ( get_query_var('pvs_page') == "user_testimonials" ) {
	$pvs_pagename .= $pvs_pagename_separator . pvs_word_lang( "testimonials" ) . $pvs_pagename_separator . $name_user;
	$pvs_path = $pvs_path_left . pvs_word_lang( "testimonials" ) . $pvs_path_right . $pvs_path_left . $name_user .
		$pvs_path_right;
}
if ( get_query_var('pvs_page') == "user_friends" ) {
	$pvs_pagename .= $pvs_pagename_separator . pvs_word_lang( "friends" ) . $pvs_pagename_separator . $name_user;
	$pvs_path = $pvs_path_left . pvs_word_lang( "friends" ) . $pvs_path_right . $pvs_path_left . $name_user . $pvs_path_right;
}
if ( get_query_var('pvs_page') == "user_lightbox" ) {
	$pvs_pagename .= $pvs_pagename_separator . pvs_word_lang( "my favorite list" ) . $pvs_pagename_separator . $name_user;
	$pvs_path = $pvs_path_left . pvs_word_lang( "my favorite list" ) . $pvs_path_right . $pvs_path_left . $name_user .
		$pvs_path_right;
}
if ( get_query_var('pvs_page') == "userlist" ) {
	$pvs_pagename .= $pvs_pagename_separator . pvs_word_lang( "users" );
	$pvs_path = $pvs_path_left . pvs_word_lang( "users" ) . $pvs_path_right;
}

if ( get_query_var('pvs_page') == 'stockapi') {
	$pvs_pagename .= $pvs_pagename_separator . @$meta_title;
}


?>