<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}


//Check access
pvs_admin_panel_access( "catalog_categories|catalog_catalog" );

//Change category's priority
if ( $_POST["formaction"] == "priority" )
{
	$sql = "select id from " . PVS_DB_PREFIX . "category";
	$rs->open( $sql );
	while ( ! $rs->eof )
	{
		if ( isset( $_POST["priority" . $rs->row["id"]] ) )
		{
			$sql = "update " . PVS_DB_PREFIX . "category set priority=" . ( int )$_POST["priority" .
				$rs->row["id"]] . " where id=" . $rs->row["id"];
			$db->execute( $sql );
		}

		$rs->movenext();
	}
}
//End. Change category's priority

//Get list of IDs
$res_id = array();
$res_module = array();
$res_category = 0;
$res_photo = 0;
$res_video = 0;
$res_audio = 0;
$res_vector = 0;
$nlimit = 0;

foreach ( $_POST as $key => $value )
{
	$res_temp = explode( "sel", $key );

	if ( count( $res_temp ) == 2 and ( int )$res_temp[1] > 0 )
	{

		if ( $_POST["formaction"] == "thumbs_publication" )
		{
			$res_id[] = ( int )$res_temp[1];
			$res_module[] = 30;
			$res_photo++;
		} elseif ( $_POST["formaction"] == "change_publication" or $_POST["formaction"] ==
		"content_publication" or $_POST["formaction"] == "move_publication" or $_POST["formaction"] == "move_collection" or $_POST["formaction"] ==
			"free_publication" or $_POST["formaction"] == "featured_publication" or $_POST["formaction"] ==
			"editorial_publication" or $_POST["formaction"] == "adult_publication" or $_POST["formaction"] ==
			"contacts_publication" or $_POST["formaction"] == "exclusive_publication" or $_POST["formaction"] ==
			"approve_publication" or $_POST["formaction"] == "rights_managed" or $_POST["formaction"] ==
			"bulk_change_publication" or $_POST["formaction"] == "bulk_keywords_publication" )
		{
			$res_id[] = ( int )$res_temp[1];

			$sql = "select media_id from " . PVS_DB_PREFIX . "media where id=" . ( int )
				$res_temp[1];
			$dr->open( $sql );
			while ( ! $dr->eof )
			{
				if ( pvs_media_type ($dr->row["media_id"]) == 'photo' )
				{
					$res_module[] = $dr->row["media_id"];
					$res_photo++;
				}

				if ( pvs_media_type ($dr->row["media_id"]) == 'video' )
				{
					$res_module[] = $dr->row["media_id"];
					$res_video++;
				}

				if ( pvs_media_type ($dr->row["media_id"]) == 'audio' )
				{
					$res_module[] = $dr->row["media_id"];
					$res_audio++;
				}

				if ( pvs_media_type ($dr->row["media_id"]) == 'vector' )
				{
					$res_module[] = $dr->row["media_id"];
					$res_vector++;
				}

				$dr->movenext();
			}
		} else
		{
			//Publications are included into the category
			$res_id[] = ( int )$res_temp[1];
			$res_module[] = 0;
			$res_category++;
			$nlimit = 0;
			pvs_get_included_publications( ( int )$res_temp[1] );
		}
	}
}
//End. Get list of IDs

//Delete the category and all included content
if ( $_POST["formaction"] == "delete_category" )
{

	if ( ! isset( $_POST["step"] ) )
	{
		echo ( "<h1>" . pvs_word_lang( "categories" ) . "</h1>" );
		echo ( "<p>Do you want to delete the categories and all included publications?</p>" );

		echo ( "<ul>" );
		echo ( "<li>" . pvs_word_lang( "categories" ) . ": <b>" . $res_category .
			"</b></li>" );
		if ( $pvs_global_settings["allow_photo"] )
		{
			echo ( "<li>" . pvs_word_lang( "photo" ) . ": <b>" . $res_photo . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_video"] )
		{
			echo ( "<li>" . pvs_word_lang( "video" ) . ": <b>" . $res_video . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_audio"] )
		{
			echo ( "<li>" . pvs_word_lang( "audio" ) . ": <b>" . $res_audio . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_vector"] )
		{
			echo ( "<li>" . pvs_word_lang( "vector" ) . ": <b>" . $res_vector . "</b></li>" );
		}
		echo ( "</ul>" );

		echo ( "<form method='post' action='" . pvs_plugins_admin_url('catalog/index.php') . "'>" );

		foreach ( $_POST as $key => $value )
		{
			$res_temp = explode( "sel", $key );

			if ( count( $res_temp ) == 2 and ( int )$res_temp[1] > 0 )
			{
				echo ( "<input type='hidden' name='" . $key . "' value='1'>" );
			}
		}

		echo ( "<input type='hidden'  name='formaction' value='delete_category'>
		<input type='hidden'  name='step' value='2'>
		<input type='hidden'  name='action' value='edit'>
		<input type='submit' class='btn btn-primary'  value='" . pvs_word_lang( "Yes" ) .
			"'>&nbsp;&nbsp;&nbsp;
		<input type='button'  class='btn btn-danger' onClick=\"location.href='" . pvs_plugins_admin_url('catalog/index.php') . "'\"  value='" .
			pvs_word_lang( "No" ) . "'>
		</form>" );
	} else
	{
		for ( $i = 0; $i < count( $res_id ); $i++ )
		{
			if ( $res_module[$i] == 0 )
			{
				if ( ! $demo_mode )
				{
					pvs_delete_category( $res_id[$i], 0 );
				}
			} else
			{
				if ( ! $demo_mode )
				{
					pvs_publication_delete( $res_id[$i] );
				}
			}
		}
	}
}
//End. Delete the category and all included content

//Delete publications
if ( $_POST["formaction"] == "delete_publication" )
{
	foreach ( $_POST as $key => $value )
	{
		$res_temp = explode( "sel", $key );

		if ( count( $res_temp ) == 2 and ( int )$res_temp[1] > 0 )
		{
			if ( ! $demo_mode )
			{
				pvs_publication_delete( ( int )$res_temp[1] );
			}
		}
	}
}
//End. Delete publications

//Regeneration thumbs for the photos
if ( $_POST["formaction"] == "thumbs" or $_POST["formaction"] ==
	"thumbs_publication" )
{
	if ( ! isset( $_POST["step"] ) )
	{
		if ( $_POST["formaction"] == "thumbs" )
		{
			echo ( "<h1>" . pvs_word_lang( "categories" ) . "</h1>" );
		} else
		{
			echo ( "<h1>" . pvs_word_lang( "catalog" ) . "</h1>" );
		}
		echo ( "<p>Do you want to regenerate thumbs for the photo's publications?</p>" );
		echo ( "<p><b>Attention!</b> The operation can overload your server because every thumb's generation requires RAM memory especially for the high-resolution photos.</p>" );

		if ( $pvs_global_settings["allow_photo"] )
		{
			echo ( "<p>" . pvs_word_lang( "photo" ) . ": <b>" . $res_photo . "</b></p>" );
		}

		echo ( "<form method=\"post\" action='" . pvs_plugins_admin_url('catalog/index.php') . "'>" );

		foreach ( $_POST as $key => $value )
		{
			$res_temp = explode( "sel", $key );

			if ( count( $res_temp ) == 2 and ( int )$res_temp[1] > 0 )
			{
				echo ( "<input type='hidden' name='" . $key . "' value='1'>" );
			}
		}

		if ( $res_photo > 0 )
		{
			echo ( "<input type='hidden'  name='formaction' value='" . pvs_result( $_POST["formaction"] ) .
				"'>
			<input type='hidden'  name='step' value='2'>
			<input type='submit'  class='btn btn-primary'   value='" . pvs_word_lang( "Yes" ) .
				"'>&nbsp;&nbsp;&nbsp;
			<input type='button' class='btn btn-primary'  onClick=\"location.href='" . $_SERVER["HTTP_REFERER"] .
				"'\"  value='" . pvs_word_lang( "No" ) . "'>" );
		}

		echo ( "</form>" );
	} else
	{
		for ( $i = 0; $i < count( $res_id ); $i++ )
		{
			if ( $res_module[$i] == 1 )
			{
				$sql = "select server1 from " . PVS_DB_PREFIX . "media where id=" . $res_id[$i];
				$rs->open( $sql );
				if ( ! $rs->eof )
				{
					$url = pvs_get_photo_file( $res_id[$i] );

					pvs_photo_resize( pvs_upload_dir() . $site_servers[$rs->
						row["server1"]] . "/" . $res_id[$i] . "/" . $url, pvs_upload_dir() . $site_servers[$rs->row["server1"]] . "/" . $res_id[$i] .
						"/thumb1.jpg", 1 );

					pvs_photo_resize( pvs_upload_dir() . $site_servers[$rs->
						row["server1"]] . "/" . $res_id[$i] . "/" . $url, pvs_upload_dir() . $site_servers[$rs->row["server1"]] . "/" . $res_id[$i] .
						"/thumb2.jpg", 2 );
					pvs_publication_watermark_add( $res_id[$i], pvs_upload_dir() . $site_servers[$rs->row["server1"]] . "/" . $res_id[$i] .
						"/thumb2.jpg" );
				}
			}
		}
	}
}
//End. Regeneration thumbs for the photos

//Change 'content_type' for the files
if ( $_POST["formaction"] == "content" or $_POST["formaction"] ==
	"content_publication" )
{
	if ( ! isset( $_POST["step"] ) )
	{
		if ( $_POST["formaction"] == "content" )
		{
			echo ( "<h1>" . pvs_word_lang( "categories" ) . "</h1>" );
		} else
		{
			echo ( "<h1>" . pvs_word_lang( "catalog" ) . "</h1>" );
		}

		echo ( "<p>Do you want to change <a href='<?php echo(pvs_plugins_admin_url('content_types/index.php'));?>'>Content type</a> for the publications?</p>" );

		echo ( "<form method='post' action='" . pvs_plugins_admin_url('catalog/index.php') . "'>" );

		echo ( "<p><select name='content_type' style='width:200'>" );

		$sql = "select name from " . PVS_DB_PREFIX . "content_type order by priority";
		$rs->open( $sql );
		while ( ! $rs->eof )
		{
			echo ( "<option value='" . $rs->row["name"] . "'>" . $rs->row["name"] .
				"</option>" );
			$rs->movenext();
		}
		echo ( "</select></p>" );

		echo ( "<ul>" );
		if ( $pvs_global_settings["allow_photo"] )
		{
			echo ( "<li>" . pvs_word_lang( "photo" ) . ": <b>" . $res_photo . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_video"] )
		{
			echo ( "<li>" . pvs_word_lang( "video" ) . ": <b>" . $res_video . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_audio"] )
		{
			echo ( "<li>" . pvs_word_lang( "audio" ) . ": <b>" . $res_audio . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_vector"] )
		{
			echo ( "<li>" . pvs_word_lang( "vector" ) . ": <b>" . $res_vector . "</b></li>" );
		}
		echo ( "</ul>" );

		foreach ( $_POST as $key => $value )
		{
			$res_temp = explode( "sel", $key );

			if ( count( $res_temp ) == 2 and ( int )$res_temp[1] > 0 )
			{
				echo ( "<input type='hidden' name='" . $key . "' value='1'>" );
			}
		}

		echo ( "<input type='hidden'  name='formaction' value='" . pvs_result( $_POST["formaction"] ) .
			"'>
		<input type='hidden'  name='action' value='edit'>
		<input type='hidden'  name='step' value='2'>
		<input type='submit'  class='btn btn-primary'  value='" . pvs_word_lang( "Yes" ) .
			"'>&nbsp;&nbsp;&nbsp;
		<input type='button'  class='btn btn-danger' onClick=\"location.href='" . $_SERVER["HTTP_REFERER"] .
			"'\"  value='" . pvs_word_lang( "No" ) . "'>" );

		echo ( "</form>" );
	} else
	{
		for ( $i = 0; $i < count( $res_id ); $i++ )
		{
				$sql = "update " . PVS_DB_PREFIX . "media set content_type='" . pvs_result( $_POST["content_type"] ) .
					"' where id=" . $res_id[$i];
				$db->execute( $sql );
		}
	}
}
//End. Change 'content_type' for the files

//Change publications properties
if ( $_POST["formaction"] == "change_publication" )
{
	if ( ! isset( $_POST["step"] ) or $_POST["step"] == 1 )
	{
		echo ( "<h1>" . pvs_word_lang( "catalog" ) . "</h1>" );

		if ( count( $res_id ) > 0 )
		{
			echo ( "<script>function change_lang_step(){\$('#step_action').val(1);}</script>" );

			echo ( "<form method='post' action='" . pvs_plugins_admin_url('catalog/index.php') . "' id='form_change'>" );

			if ( $pvs_global_settings["multilingual_publications"] )
			{
				echo ( "<div class='admin_field'><span>" . pvs_word_lang( "languages" ) .
					":</span><select class='form-control' id='recognition_lang' name='lang' style='width:200px;display:inline' onChange='change_lang_step()'>" );

				$sql = "select name,display,activ from " . PVS_DB_PREFIX .
					"languages where display=1 order by name";
				$rs->open( $sql );
				while ( ! $rs->eof )
				{
					$sel = "";

					if ( ! isset( $_POST["lang"] ) )
					{
						if ( $rs->row["name"] == $lng_original )
						{
							$sel = "selected";
						}
					} else
					{
						if ( $rs->row["name"] == $_POST["lang"] )
						{
							$sel = "selected";
						}
					}

					echo ( "<option value='" . $rs->row["name"] . "' " . $sel . ">" . $rs->row["name"] .
						"</option>" );
					$rs->movenext();
				}

				echo ( "</select> <input type='submit' class='btn btn-primary' value='" .
					pvs_word_lang( "select" ) . "'></div>" );

				if ( $pvs_global_settings["clarifai"] )
				{
					echo ( "<div class='admin_field'><p><b>" . pvs_word_lang( "Image recognition" ) .
						":</b></p>" );
					$clarifai_files = "";
					$imagga_files = "";

					echo ( "<a href=\"javascript:go_clarifai()\"  class='btn btn-warning'>Clarifai</a> " );
					echo ( "</div>" );
				}
			}

			echo ( "<table class='wp-list-table widefat fixed striped posts'>
<thead><tr><th>" .
				pvs_word_lang( "preview" ) . "</th><th style='width:50%'>" . pvs_word_lang( "title" ) . " - " . pvs_word_lang( "description" ) .
				" - " . pvs_word_lang( "keywords" ) . "</th><th>" . pvs_word_lang( "featured" ) .
				"</th><th>" . pvs_word_lang( "free" ) . "</th></tr></thead>" );

			for ( $i = 0; $i < count( $res_id ); $i++ )
			{
				if ( $res_module[$i] == 1 )
				{
					$type = "photo";
				}
				if ( $res_module[$i] == 2 )
				{
					$type = "video";
				}
				if ( $res_module[$i] == 3 )
				{
					$type = "audio";
				}
				if ( $res_module[$i] == 4 )
				{
					$type = "vector";
				}
				$sql = "select id,title,description,keywords,free,featured,server1 from " .
					PVS_DB_PREFIX . "media where id=" . ( int )$res_id[$i];
				$rs->open( $sql );
				if ( ! $rs->eof )
				{
					if ( $pvs_global_settings["clarifai"] or $pvs_global_settings["imagga"] )
					{
						$recognition_file = pvs_show_preview( ( int )$res_id[$i], $type,
							2, 1 );
						$recognition_file_clarifai = $recognition_file;
						$recognition_file_imagga = $recognition_file;

						if ( $type == 'video' and $pvs_global_settings["imagga"] )
						{
							$recognition_file_imagga = pvs_show_preview( ( int )$res_id[$i],
								$type, 3, 1 );
						}

						if ( $type == 'audio' )
						{
							$recognition_file_clarifai = pvs_show_preview( ( int )$res_id[$i],
								$type, 3, 1 );
							$recognition_file_imagga = pvs_show_preview( ( int )$res_id[$i],
								$type, 3, 1 );
						}

						$clarifai_files .= 'clarifai_files["keywords' . ( int )$res_id[$i] . '"] = "' .
							$recognition_file_clarifai . '";';
						$imagga_files .= 'imagga_files["keywords' . ( int )$res_id[$i] . '"] = "' . $recognition_file_imagga .
							'";';
					}

					$free = "";
					if ( $rs->row["free"] == 1 )
					{
						$free = "checked";
					}

					$featured = "";
					if ( $rs->row["featured"] == 1 )
					{
						$featured = "checked";
					}

					$hoverbox_results = pvs_get_hoverbox( $res_id[$i], $type, $rs->row["server1"],
						"", "" );

					echo ( "<tr valign='top'>" );
					echo ( "<td>" );
					echo ( "<div style='margin-bottom:3px'><img src='" . pvs_show_preview( $res_id[$i],
						$type, 1, 1 ) . "' " . $hoverbox_results["hover"] . "></div>" );
					echo ( "<div><small>" . pvs_word_lang( $type ) . " ID=" . $res_id[$i] .
						"</small></div>" );
					echo ( "</td>" );
					echo ( "<td>" );

					$title = "";
					$description = "";
					$keywords = "";

					if ( isset( $_POST["lang"] ) and $_POST["lang"] != $lng )
					{
						$lng_symbol = @$lang_symbol[$_POST["lang"]];
						if ( $lng == "Chinese traditional" )
						{
							$lng_symbol = "zh1";
						}
						if ( $lng == "Chinese simplified" )
						{
							$lng_symbol = "zh2";
						}
						if ( $lng == "Afrikaans formal" )
						{
							$lng_symbol = "af1";
						}
						if ( $lng == "Afrikaans informal" )
						{
							$lng_symbol = "af2";
						}

						$sql = "select title,keywords,description from " . PVS_DB_PREFIX .
							"translations where id=" . ( int )$res_id[$i] . " and lang='" . $lng_symbol .
							"'";
						$dr->open( $sql );
						if ( ! $dr->eof )
						{
							$title = $dr->row["title"];
							$description = $dr->row["description"];
							$keywords = $dr->row["keywords"];
						}
					} else
					{
						$title = $rs->row["title"];
						$description = $rs->row["description"];
						$keywords = $rs->row["keywords"];
					}

					echo ( "<div><input type='text' name='title" . $res_id[$i] . "' value='" . $title .
						"' style='width:400px'></div>" );

					echo ( "<div style='margin-top:3px'><textarea class='textarea' name='description" .
						$res_id[$i] . "' style='width:400px;height:130px'>" . $description .
						"</textarea></div>" );

					echo ( "<div style='margin-top:3px'><textarea class='textarea' name='keywords" .
						$res_id[$i] . "'  id='keywords" . $res_id[$i] .
						"' style='width:400px;height:130px'>" . $keywords . "</textarea></div>" );

					echo ( "<input type='hidden' name='sel" . $res_id[$i] . "' value='1'>" );
					echo ( "</td>" );
					echo ( "<td>" );
					echo ( "<input type='checkbox' name='featured" . $res_id[$i] . "' " . $featured .
						">" );
					echo ( "</td>" );
					echo ( "<td>" );
					echo ( "<input type='checkbox' name='free" . $res_id[$i] . "' " . $free . ">" );
					echo ( "</td>" );
					echo ( "</tr>" );
				}
			}

			echo ( "</table>" );

			echo ( "<input type='hidden'  name='formaction' value='" . pvs_result( $_POST["formaction"] ) .
				"'>
			<input type='hidden'  name='step' id='step_action' value='2'><input type='hidden'  name='action' value='edit'>
			<input type='submit'  class='btn btn-primary'  value='" . pvs_word_lang( "Save" ) .
				"' style='margin-top:15px'>" );

			echo ( "</form>" );

		}
	} else
	{
		for ( $i = 0; $i < count( $res_id ); $i++ )
		{

			if ( $res_module[$i] == 1 )
			{
				$table = "photos";
			}
			if ( $res_module[$i] == 2 )
			{
				$table = "videos";
			}
			if ( $res_module[$i] == 3 )
			{
				$table = "audio";
			}
			if ( $res_module[$i] == 4 )
			{
				$table = "vector";
			}

			$free = 0;
			if ( isset( $_POST["free" . $res_id[$i]] ) )
			{
				$free = 1;
			}

			$featured = 0;
			if ( isset( $_POST["featured" . $res_id[$i]] ) )
			{
				$featured = 1;
			}

			if ( isset( $_POST["lang"] ) and $_POST["lang"] != $lng )
			{
				$sql = "update " . PVS_DB_PREFIX . "media set featured=" . $featured . ",free=" . $free . " where id=" . $res_id[$i];
				$db->execute( $sql );

				$lng_symbol = @$lang_symbol[$_POST["lang"]];
				if ( $lng == "Chinese traditional" )
				{
					$lng_symbol = "zh1";
				}
				if ( $lng == "Chinese simplified" )
				{
					$lng_symbol = "zh2";
				}
				if ( $lng == "Afrikaans formal" )
				{
					$lng_symbol = "af1";
				}
				if ( $lng == "Afrikaans informal" )
				{
					$lng_symbol = "af2";
				}

				$sql = "select id from " . PVS_DB_PREFIX . "translations where id=" . $res_id[$i] .
					" and lang='" . pvs_result( $lng_symbol ) . "'";
				$dr->open( $sql );
				if ( $dr->eof )
				{
					$sql = "insert into " . PVS_DB_PREFIX .
						"translations (id,title,keywords,description,lang,types) values (" . $res_id[$i] .
						",'','','','" . pvs_result( $lng_symbol ) . "',0)";
					$db->execute( $sql );
				}

				$sql = "update " . PVS_DB_PREFIX . "translations set  title='" . pvs_result( $_POST["title" .
					$res_id[$i]] ) . "',description='" . pvs_result( $_POST["description" . $res_id[$i]] ) .
					"',keywords='" . pvs_result( $_POST["keywords" . $res_id[$i]] ) . "' where id=" .
					$res_id[$i] . " and lang='" . pvs_result( $lng_symbol ) . "'";
				$db->execute( $sql );
			} else
			{
				$sql = "update " . PVS_DB_PREFIX . "media set title='" . pvs_result( $_POST["title" .
					$res_id[$i]] ) . "',description='" . pvs_result( $_POST["description" . $res_id[$i]] ) .
					"',keywords='" . pvs_result( $_POST["keywords" . $res_id[$i]] ) . "',featured=" . $featured . ",free=" . $free . " where id=" .
					$res_id[$i];
				$db->execute( $sql );
			}
			pvs_item_url( $res_id[$i] );

		}
	}
}
//End. Change publications properties


//Move files to category
if ( @$_POST["formaction"] == "move_publication" ) {
	if ( ! isset( $_POST["step"] ) ) {

		echo ( "<h1>" . pvs_word_lang( "catalog" ) . "</h1>" );

		echo ( "<p>Do you want to move the publications to the new category?</p>" );

		echo ( "<form method='post' action='" . pvs_plugins_admin_url('catalog/index.php') . "'>" );

		echo ( "<ul>" );
		if ( $pvs_global_settings["allow_photo"] ) {
			echo ( "<li>" . pvs_word_lang( "photo" ) . ": <b>" . $res_photo . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_video"] ) {
			echo ( "<li>" . pvs_word_lang( "video" ) . ": <b>" . $res_video . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_audio"] ) {
			echo ( "<li>" . pvs_word_lang( "audio" ) . ": <b>" . $res_audio . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_vector"] ) {
			echo ( "<li>" . pvs_word_lang( "vector" ) . ": <b>" . $res_vector . "</b></li>" );
		}
		echo ( "</ul>" );

		echo ( "<br><h5>" . pvs_word_lang( "categories" ) . ":</h5>" );

		echo ( '<link rel="stylesheet" href="' . pvs_plugins_url() .
			'/assets/js/treeview/jquery.treeview.css" />
		<script src="' . pvs_plugins_url() . '/assets/js/treeview/jquery.cookie.js"></script>
		<script src="' . pvs_plugins_url() . '/assets/js/treeview/jquery.treeview.js"></script>
		
		<script>
		$(document).ready(function(){
			$("#categories_tree_menu").treeview({
				collapsed: false,
				persist: "cookie",
				cookieId: "treeview-black"
			});
		});
		</script>' );

		$itg = "";
		$nlimit = 0;
		pvs_build_menu_admin_tree( 0, "admin" );
		echo ( $itg );

		foreach ( $_POST as $key => $value ) {
			$res_temp = explode( "sel", $key );

			if ( count( $res_temp ) == 2 and ( int )$res_temp[1] > 0 )
			{
				echo ( "<input type='hidden' name='" . $key . "' value='1'>" );
			}
		}

		echo ( "<input type='hidden'  name='formaction' value='" . pvs_result( $_POST["formaction"] ) .
			"'>
		<input type='hidden'  name='step' value='2'><input type='hidden'  name='action' value='edit'><br>
		<input type='submit'  class='btn btn-primary'  value='" . pvs_word_lang( "save" ) .
			"'>
		" );

		echo ( "</form>" );
	} else {
		for ( $i = 0; $i < count( $res_id ); $i++ ) {
			pvs_add_categories( $res_id[$i] );
		}
	}
}
//End. Move files to category




//Move files to collection
if ( @$_POST["formaction"] == "move_collection" ) {
	if ( ! isset( $_POST["step"] ) ) {
		echo ( "<h1>" . pvs_word_lang( "Collections" ) . "</h1>" );

		echo ( "<p>Do you want to move the publications to the collection?</p>" );

		echo ( "<form method='post' action='" . pvs_plugins_admin_url('catalog/index.php') . "'>" );

		echo ( "<ul>" );
		if ( $pvs_global_settings["allow_photo"] ) {
			echo ( "<li>" . pvs_word_lang( "photo" ) . ": <b>" . $res_photo . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_video"] ) {
			echo ( "<li>" . pvs_word_lang( "video" ) . ": <b>" . $res_video . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_audio"] ) {
			echo ( "<li>" . pvs_word_lang( "audio" ) . ": <b>" . $res_audio . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_vector"] ) {
			echo ( "<li>" . pvs_word_lang( "vector" ) . ": <b>" . $res_vector . "</b></li>" );
		}
		echo ( "</ul>" );

		echo ( "<br><h5>" . pvs_word_lang( "Collections based on the items" ) . ":</h5>" );

		$sql = "select id, title from " . PVS_DB_PREFIX . "collections where types=1 order by title";
		$dd->open( $sql );
		while ( ! $dd->eof )
		{
			echo("<div class='collection_box'><input type='checkbox' name='collection" . $dd->row["id"] . "' value='1'> " . $dd->row["title"] . "</div>");
			$dd->movenext();
		}
		echo("<div class='clearfix'></div>");

		foreach ( $_POST as $key => $value ) {
			$res_temp = explode( "sel", $key );

			if ( count( $res_temp ) == 2 and ( int )$res_temp[1] > 0 )
			{
				echo ( "<input type='hidden' name='" . $key . "' value='1'>" );
			}
		}

		echo ( "<input type='hidden'  name='formaction' value='" . pvs_result( $_POST["formaction"] ) .
			"'>
		<input type='hidden'  name='step' value='2'><input type='hidden'  name='action' value='edit'><br>
		<input type='submit'  class='btn btn-primary'  value='" . pvs_word_lang( "add" ) .
			"'>
		" );

		echo ( "</form>" );
	} else {
		for ( $i = 0; $i < count( $res_id ); $i++ ) {
			$sql = "delete from " . PVS_DB_PREFIX . "collections_items where category_id=0 and publication_id=" . $res_id[$i];
			$db->execute( $sql );
			
			$sql = "select id from " . PVS_DB_PREFIX . "collections where types=1";
			$rs->open( $sql );
			while ( ! $rs->eof ) {
				if (isset($_POST["collection" . $rs->row["id"]])) {
					$sql = "insert into " . PVS_DB_PREFIX . "collections_items (publication_id, category_id, collection_id) values (" . $res_id[$i] . ", 0, " . $rs->row["id"] . ")";
					$db->execute( $sql );
				}
				$rs->movenext();
			}			
		}
	}
}
//End. Move files to collection




//Regenerate URLs
if ( $_POST["formaction"] == "regenerate_urls" )
{

	if ( ! isset( $_POST["step"] ) )
	{
		echo ( "<h1>" . pvs_word_lang( "regenerate urls" ) . "</h1>" );
		echo ( "<p>The script uses WP mod-rewrite URLs. They are created one time when you add a publication or edit its properties. The URLs are virtual. So the files like /stock-photo/photo-title.html don't exist on the server.</p>" );

		echo ( "<p>Sometimes it is necessary to regenerate all URLs because WP settings were changed.</p>" );

		echo ( "<p>The tool will regenerate all URLs - not only selected.</p>" );

		echo ( "<form method='post' action='" . pvs_plugins_admin_url('catalog/index.php') . "'>" );

		echo ( "<input type='hidden'  name='formaction' value='regenerate_urls'>
		<input type='hidden'  name='step' value='2'><input type='hidden'  name='action' value='edit'>
		<input type='submit'  class='btn btn-primary'  value='" . pvs_word_lang( "Yes" ) .
			"'>&nbsp;&nbsp;&nbsp;
		<input type='button'  class='btn btn-danger' onClick=\"location.href='" . pvs_plugins_admin_url('catalog/index.php') . "'\"  value='" .
			pvs_word_lang( "No" ) . "'>
		</form>" );
	} else
	{
		$sql = "select id from " . PVS_DB_PREFIX . "media";
		$rs->open( $sql );
		while ( ! $rs->eof )
		{
			pvs_item_url( $rs->row["id"] );
			$rs->movenext();
		}
	}
}
//End. Regenerate URLs

//Change files to free/paid
if ( $_POST["formaction"] == "free" or $_POST["formaction"] ==
	"free_publication" )
{
	if ( ! isset( $_POST["step"] ) )
	{
		if ( $_POST["formaction"] == "free" )
		{
			echo ( "<h1>" . pvs_word_lang( "categories" ) . "</h1>" );
		} else
		{
			echo ( "<h1>" . pvs_word_lang( "catalog" ) . "</h1>" );
		}

		echo ( "<p>Do you want to change the files to free/paid?</p>" );

		echo ( "<form method='post' action='" . pvs_plugins_admin_url('catalog/index.php') . "'>" );

		echo ( "<p><input type='radio' name='free' value='1' checked> " . pvs_word_lang
			( "free" ) . "</p>" );

		echo ( "<p><input type='radio' name='free' value='0'> " . pvs_word_lang( "paid" ) .
			"</p>" );

		echo ( "<ul>" );
		if ( $pvs_global_settings["allow_photo"] )
		{
			echo ( "<li>" . pvs_word_lang( "photo" ) . ": <b>" . $res_photo . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_video"] )
		{
			echo ( "<li>" . pvs_word_lang( "video" ) . ": <b>" . $res_video . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_audio"] )
		{
			echo ( "<li>" . pvs_word_lang( "audio" ) . ": <b>" . $res_audio . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_vector"] )
		{
			echo ( "<li>" . pvs_word_lang( "vector" ) . ": <b>" . $res_vector . "</b></li>" );
		}
		echo ( "</ul>" );

		foreach ( $_POST as $key => $value )
		{
			$res_temp = explode( "sel", $key );

			if ( count( $res_temp ) == 2 and ( int )$res_temp[1] > 0 )
			{
				echo ( "<input type='hidden' name='" . $key . "' value='1'>" );
			}
		}

		echo ( "<input type='hidden'  name='formaction' value='" . pvs_result( $_POST["formaction"] ) .
			"'>
		<input type='hidden'  name='step' value='2'><input type='hidden'  name='action' value='edit'>
		<input type='submit'  class='btn btn-primary'  value='" . pvs_word_lang( "Ok" ) .
			"'>" );

		echo ( "</form>" );
	} else
	{
		for ( $i = 0; $i < count( $res_id ); $i++ )
		{
			$sql = "update " . PVS_DB_PREFIX . "media set free=" . ( int )$_POST["free"] . " where id=" . $res_id[$i];
			$db->execute( $sql );
		}
	}
}
//End. Change files to free/paid

//Change rights-managed price
if ( $_POST["formaction"] == "rights_managed" or $_POST["formaction"] ==
	"rights_managed_categories" )
{
	if ( ! isset( $_POST["step"] ) )
	{
		if ( $_POST["formaction"] == "rights_managed_categories" )
		{
			echo ( "<h1>" . pvs_word_lang( "categories" ) . "</h1>" );
		} else
		{
			echo ( "<h1>" . pvs_word_lang( "catalog" ) . "</h1>" );
		}

		echo ( "<p>Please select rights-managed price for the publications:</p>" );

		echo ( "<p><b>Attention!</b> You won't be able to change rights-managed files back to Royalty-free.</p>" );

		echo ( "<form method='post' action='" . pvs_plugins_admin_url('catalog/index.php') . "'>" );

		echo ( "<select name='rights_managed' style='width:400px'>" );

		$sql = "select id,title from " . PVS_DB_PREFIX . "rights_managed";
		$ds->open( $sql );
		while ( ! $ds->eof )
		{
			echo ( "<option value='" . $ds->row["id"] . "'>" . $ds->row["title"] .
				"</option>" );
			$ds->movenext();
		}

		echo ( "</select><br><br>" );

		echo ( "<ul>" );
		if ( $pvs_global_settings["allow_photo"] )
		{
			echo ( "<li>" . pvs_word_lang( "photo" ) . ": <b>" . $res_photo . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_video"] )
		{
			echo ( "<li>" . pvs_word_lang( "video" ) . ": <b>" . $res_video . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_audio"] )
		{
			echo ( "<li>" . pvs_word_lang( "audio" ) . ": <b>" . $res_audio . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_vector"] )
		{
			echo ( "<li>" . pvs_word_lang( "vector" ) . ": <b>" . $res_vector . "</b></li>" );
		}
		echo ( "</ul>" );

		foreach ( $_POST as $key => $value )
		{
			$res_temp = explode( "sel", $key );

			if ( count( $res_temp ) == 2 and ( int )$res_temp[1] > 0 )
			{
				echo ( "<input type='hidden' name='" . $key . "' value='1'>" );
			}
		}

		echo ( "<input type='hidden'  name='formaction' value='" . pvs_result( $_POST["formaction"] ) .
			"'>
		<input type='hidden'  name='step' value='2'><input type='hidden'  name='action' value='edit'>
		<input type='submit'  class='btn btn-primary'  value='" . pvs_word_lang( "Ok" ) .
			"'>" );

		echo ( "</form>" );
	} else
	{
		$sql = "select id,title,price,photo,video,audio,vector from " . PVS_DB_PREFIX .
			"rights_managed where id=" . ( int )$_POST["rights_managed"];
		$ds->open( $sql );
		if ( ! $ds->eof )
		{
			for ( $i = 0; $i < count( $res_id ); $i++ )
			{
				if ( $res_module[$i] == 1 and $ds->row["photo"] == 1 )
				{
					$sql = "update " . PVS_DB_PREFIX . "media set rights_managed=" . ( int )$_POST["rights_managed"] .
						" where id=" . $res_id[$i];
					$db->execute( $sql );

					$sql = "update " . PVS_DB_PREFIX . "items set name='" . $ds->row["title"] .
						"',price=" . $ds->row["price"] . ",price_id=" . ( int )$_POST["rights_managed"] .
						" where id_parent=" . $res_id[$i];
					$db->execute( $sql );
				}
				if ( $res_module[$i] == 2 and $ds->row["video"] == 1 )
				{
					$sql = "update " . PVS_DB_PREFIX . "media set rights_managed=" . ( int )$_POST["rights_managed"] .
						" where id=" . $res_id[$i];
					$db->execute( $sql );

					$sql = "update " . PVS_DB_PREFIX . "items set name='" . $ds->row["title"] .
						"',price=" . $ds->row["price"] . ",price_id=" . ( int )$_POST["rights_managed"] .
						" where id_parent=" . $res_id[$i];
					$db->execute( $sql );
				}
				if ( $res_module[$i] == 3 and $ds->row["audio"] == 1 )
				{
					$sql = "update " . PVS_DB_PREFIX . "media set rights_managed=" . ( int )$_POST["rights_managed"] .
						" where id=" . $res_id[$i];
					$db->execute( $sql );

					$sql = "update " . PVS_DB_PREFIX . "items set name='" . $ds->row["title"] .
						"',price=" . $ds->row["price"] . ",price_id=" . ( int )$_POST["rights_managed"] .
						" where id_parent=" . $res_id[$i];
					$db->execute( $sql );
				}
				if ( $res_module[$i] == 4 and $ds->row["vector"] == 1 )
				{
					$sql = "update " . PVS_DB_PREFIX . "media set rights_managed=" . ( int )$_POST["rights_managed"] .
						" where id=" . $res_id[$i];
					$db->execute( $sql );

					$sql = "update " . PVS_DB_PREFIX . "items set name='" . $ds->row["title"] .
						"',price=" . $ds->row["price"] . ",price_id=" . ( int )$_POST["rights_managed"] .
						" where id_parent=" . $res_id[$i];
					$db->execute( $sql );
				}
			}
		}
	}
}
//End. Change rights-managed price

//Change files to featured
if ( $_POST["formaction"] == "featured" or $_POST["formaction"] ==
	"featured_publication" )
{
	if ( ! isset( $_POST["step"] ) )
	{
		if ( $_POST["formaction"] == "featured" )
		{
			echo ( "<h1>" . pvs_word_lang( "categories" ) . "</h1>" );
		} else
		{
			echo ( "<h1>" . pvs_word_lang( "catalog" ) . "</h1>" );
		}

		echo ( "<p>Do you want to change the files to Featured/Common?</p>" );

		echo ( "<form method='post' action='" . pvs_plugins_admin_url('catalog/index.php') . "'>" );

		echo ( "<p><input type='radio' name='featured' value='1' checked> " .
			pvs_word_lang( "featured" ) . "</p>" );

		echo ( "<p><input type='radio' name='featured' value='0'> " . pvs_word_lang( "common" ) .
			"</p>" );

		echo ( "<ul>" );
		if ( $pvs_global_settings["allow_photo"] )
		{
			echo ( "<li>" . pvs_word_lang( "photo" ) . ": <b>" . $res_photo . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_video"] )
		{
			echo ( "<li>" . pvs_word_lang( "video" ) . ": <b>" . $res_video . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_audio"] )
		{
			echo ( "<li>" . pvs_word_lang( "audio" ) . ": <b>" . $res_audio . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_vector"] )
		{
			echo ( "<li>" . pvs_word_lang( "vector" ) . ": <b>" . $res_vector . "</b></li>" );
		}
		echo ( "</ul>" );

		foreach ( $_POST as $key => $value )
		{
			$res_temp = explode( "sel", $key );

			if ( count( $res_temp ) == 2 and ( int )$res_temp[1] > 0 )
			{
				echo ( "<input type='hidden' name='" . $key . "' value='1'>" );
			}
		}

		echo ( "<input type='hidden'  name='formaction' value='" . pvs_result( $_POST["formaction"] ) .
			"'>
		<input type='hidden'  name='step' value='2'><input type='hidden'  name='action' value='edit'>
		<input type='submit'  class='btn btn-primary' value='" . pvs_word_lang( "Ok" ) .
			"'>" );

		echo ( "</form>" );
	} else
	{
		for ( $i = 0; $i < count( $res_id ); $i++ )
		{
			$sql = "update " . PVS_DB_PREFIX . "media set featured=" . ( int )$_POST["featured"] .
				" where id=" . $res_id[$i];
			$db->execute( $sql );
		}
	}
}
//End. Change files to featured

//Change files to adult
if ( $_POST["formaction"] == "adult" or $_POST["formaction"] ==
	"adult_publication" )
{
	if ( ! isset( $_POST["step"] ) )
	{
		if ( $_POST["formaction"] == "adult" )
		{
			echo ( "<h1>" . pvs_word_lang( "categories" ) . "</h1>" );
		} else
		{
			echo ( "<h1>" . pvs_word_lang( "catalog" ) . "</h1>" );
		}

		echo ( "<p>Do you want to change the files to Adult/Common?</p>" );

		echo ( "<form method='post' action='" . pvs_plugins_admin_url('catalog/index.php') . "'>" );

		echo ( "<p><input type='radio' name='adult' value='1' checked> " . pvs_word_lang
			( "adult content" ) . "</p>" );

		echo ( "<p><input type='radio' name='adult' value='0'> " . pvs_word_lang( "common" ) .
			"</p>" );

		echo ( "<ul>" );
		if ( $pvs_global_settings["allow_photo"] )
		{
			echo ( "<li>" . pvs_word_lang( "photo" ) . ": <b>" . $res_photo . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_video"] )
		{
			echo ( "<li>" . pvs_word_lang( "video" ) . ": <b>" . $res_video . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_audio"] )
		{
			echo ( "<li>" . pvs_word_lang( "audio" ) . ": <b>" . $res_audio . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_vector"] )
		{
			echo ( "<li>" . pvs_word_lang( "vector" ) . ": <b>" . $res_vector . "</b></li>" );
		}
		echo ( "</ul>" );

		foreach ( $_POST as $key => $value )
		{
			$res_temp = explode( "sel", $key );

			if ( count( $res_temp ) == 2 and ( int )$res_temp[1] > 0 )
			{
				echo ( "<input type='hidden' name='" . $key . "' value='1'>" );
			}
		}

		echo ( "<input type='hidden'  name='formaction' value='" . pvs_result( $_POST["formaction"] ) .
			"'>
		<input type='hidden'  name='step' value='2'><input type='hidden'  name='action' value='edit'>
		<input type='submit'  class='btn btn-primary'  value='" . pvs_word_lang( "Ok" ) .
			"'>" );

		echo ( "</form>" );
	} else
	{
		for ( $i = 0; $i < count( $res_id ); $i++ )
		{
			$sql = "update " . PVS_DB_PREFIX . "media set adult=" . ( int )$_POST["adult"] .
				" where id=" . $res_id[$i];
			$db->execute( $sql );
		}
	}
}
//End. Change files to adult

//Change files to exclusive
if ( $_POST["formaction"] == "exclusive" or $_POST["formaction"] ==
	"exclusive_publication" )
{
	if ( ! isset( $_POST["step"] ) )
	{
		if ( $_POST["formaction"] == "exclusive" )
		{
			echo ( "<h1>" . pvs_word_lang( "categories" ) . "</h1>" );
		} else
		{
			echo ( "<h1>" . pvs_word_lang( "catalog" ) . "</h1>" );
		}

		echo ( "<p>Do you want to change the files to Exclusive/Common?</p>" );

		echo ( "<form method='post' action='" . pvs_plugins_admin_url('catalog/index.php') . "'>" );

		echo ( "<p><input type='radio' name='exclusive' value='1' checked> " .
			pvs_word_lang( "exclusive price" ) . "</p>" );

		echo ( "<p><input type='radio' name='exclusive' value='0'> " . pvs_word_lang( "common" ) .
			"</p>" );

		echo ( "<ul>" );
		if ( $pvs_global_settings["allow_photo"] )
		{
			echo ( "<li>" . pvs_word_lang( "photo" ) . ": <b>" . $res_photo . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_video"] )
		{
			echo ( "<li>" . pvs_word_lang( "video" ) . ": <b>" . $res_video . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_audio"] )
		{
			echo ( "<li>" . pvs_word_lang( "audio" ) . ": <b>" . $res_audio . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_vector"] )
		{
			echo ( "<li>" . pvs_word_lang( "vector" ) . ": <b>" . $res_vector . "</b></li>" );
		}
		echo ( "</ul>" );

		foreach ( $_POST as $key => $value )
		{
			$res_temp = explode( "sel", $key );

			if ( count( $res_temp ) == 2 and ( int )$res_temp[1] > 0 )
			{
				echo ( "<input type='hidden' name='" . $key . "' value='1'>" );
			}
		}

		echo ( "<input type='hidden'  name='formaction' value='" . pvs_result( $_POST["formaction"] ) .
			"'>
		<input type='hidden'  name='step' value='2'><input type='hidden'  name='action' value='edit'>
		<input type='submit'  class='btn btn-primary'  value='" . pvs_word_lang( "Ok" ) .
			"'>" );

		echo ( "</form>" );
	} else
	{
		for ( $i = 0; $i < count( $res_id ); $i++ )
		{
			$sql = "update " . PVS_DB_PREFIX . "media set exclusive=" . ( int )$_POST["exclusive"] .
				" where id=" . $res_id[$i];
			$db->execute( $sql );
		}
	}
}
//End. Change files to exclusive

//Change files to contacts
if ( $_POST["formaction"] == "contacts" or $_POST["formaction"] ==
	"contacts_publication" )
{
	if ( ! isset( $_POST["step"] ) )
	{
		if ( $_POST["formaction"] == "contacts" )
		{
			echo ( "<h1>" . pvs_word_lang( "categories" ) . "</h1>" );
		} else
		{
			echo ( "<h1>" . pvs_word_lang( "catalog" ) . "</h1>" );
		}

		echo ( "<p>Do you want to change the files to 'Contacts us to get the price'/Common?</p>" );

		echo ( "<form method='post' action='" . pvs_plugins_admin_url('catalog/index.php') . "'>" );

		echo ( "<p><input type='radio' name='contacts' value='1' checked> " .
			pvs_word_lang( "Contacts us to get the price" ) . "</p>" );

		echo ( "<p><input type='radio' name='contacts' value='0'> " . pvs_word_lang( "common" ) .
			"</p>" );

		echo ( "<ul>" );
		if ( $pvs_global_settings["allow_photo"] )
		{
			echo ( "<li>" . pvs_word_lang( "photo" ) . ": <b>" . $res_photo . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_video"] )
		{
			echo ( "<li>" . pvs_word_lang( "video" ) . ": <b>" . $res_video . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_audio"] )
		{
			echo ( "<li>" . pvs_word_lang( "audio" ) . ": <b>" . $res_audio . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_vector"] )
		{
			echo ( "<li>" . pvs_word_lang( "vector" ) . ": <b>" . $res_vector . "</b></li>" );
		}
		echo ( "</ul>" );

		foreach ( $_POST as $key => $value )
		{
			$res_temp = explode( "sel", $key );

			if ( count( $res_temp ) == 2 and ( int )$res_temp[1] > 0 )
			{
				echo ( "<input type='hidden' name='" . $key . "' value='1'>" );
			}
		}

		echo ( "<input type='hidden'  name='formaction' value='" . pvs_result( $_POST["formaction"] ) .
			"'>
		<input type='hidden'  name='step' value='2'><input type='hidden'  name='action' value='edit'>
		<input type='submit'  class='btn btn-primary'  value='" . pvs_word_lang( "Ok" ) .
			"'>" );

		echo ( "</form>" );
	} else
	{
		for ( $i = 0; $i < count( $res_id ); $i++ )
		{
			$sql = "update " . PVS_DB_PREFIX . "media set contacts=" . ( int )$_POST["contacts"] .
				" where id=" . $res_id[$i];
			$db->execute( $sql );
		}
	}
}
//End. Change files to contacts

//Bulk change titles, keywords, description
if ( $_POST["formaction"] == "bulk_change" or $_POST["formaction"] ==
	"bulk_change_publication" )
{
	if ( ! isset( $_POST["step"] ) )
	{
		echo ( "<h1>" . pvs_word_lang( "Bulk change titles, keywords, description" ) .
			"</h1>" );

		echo ( "<p>You should select a field which you want to change and write a new meaning. Attention! The old value will be replaced with the new one for all selected publications.</p>" );

		echo ( "<form method='post' action='" . pvs_plugins_admin_url('catalog/index.php') . "'>" );

		echo ( "<ul>" );
		if ( $pvs_global_settings["allow_photo"] )
		{
			echo ( "<li>" . pvs_word_lang( "photo" ) . ": <b>" . $res_photo . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_video"] )
		{
			echo ( "<li>" . pvs_word_lang( "video" ) . ": <b>" . $res_video . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_audio"] )
		{
			echo ( "<li>" . pvs_word_lang( "audio" ) . ": <b>" . $res_audio . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_vector"] )
		{
			echo ( "<li>" . pvs_word_lang( "vector" ) . ": <b>" . $res_vector . "</b></li>" );
		}
		echo ( "</ul>" );

		echo ( "<div class='admin_field'><span>" . pvs_word_lang( "property" ) .
			":</span><select name='field_type' style='width:300px'><option value='title'>" .
			pvs_word_lang( "title" ) . "</option><option value='keywords'>" . pvs_word_lang
			( "keywords" ) . "</option><option value='description'>" . pvs_word_lang( "description" ) .
			"</option></select></div>" );

		echo ( "<div class='admin_field'><span>" . pvs_word_lang( "value" ) .
			":</span><textarea name='field_value' style='width:500px;height:150px'></textarea></div>" );

		foreach ( $_POST as $key => $value )
		{
			$res_temp = explode( "sel", $key );

			if ( count( $res_temp ) == 2 and ( int )$res_temp[1] > 0 )
			{
				echo ( "<input type='hidden' name='" . $key . "' value='1'>" );
			}
		}

		echo ( "<input type='hidden'  name='formaction' value='" . pvs_result( $_POST["formaction"] ) .
			"'>
		<input type='hidden'  name='step' value='2'><input type='hidden'  name='action' value='edit'>
		<input type='submit'  class='btn btn-primary'  value='" . pvs_word_lang( "Ok" ) .
			"'>" );

		echo ( "</form>" );
	} else
	{
		for ( $i = 0; $i < count( $res_id ); $i++ )
		{
			$field_name = "title";
			if ( $_POST["field_type"] == "title" )
			{
				$field_name = "title";
			}
			if ( $_POST["field_type"] == "keywords" )
			{
				$field_name = "keywords";
			}
			if ( $_POST["field_type"] == "description" )
			{
				$field_name = "description";
			}

			if ( pvs_result( $_POST["field_value"] ) != "" )
			{
				$sql = "update " . PVS_DB_PREFIX . "media set " . $field_name . "='" .
					pvs_result( $_POST["field_value"] ) . "' where id=" . $res_id[$i];
				$db->execute( $sql );
			}
		}
	}
}
//End. Bulk change titles, keywords, description

//Bulk add/remove keywords
if ( $_POST["formaction"] == "bulk_keywords" or $_POST["formaction"] ==
	"bulk_keywords_publication" )
{
	if ( ! isset( $_POST["step"] ) )
	{
		echo ( "<h1>" . pvs_word_lang( "Bulk add/remove keywords" ) . "</h1>" );

		echo ( "<p>You should write keywords (, - separator) and select an appropriate action</p>" );

		echo ( "<form method='post' action='" . pvs_plugins_admin_url('catalog/index.php') . "'>" );

		echo ( "<ul>" );
		if ( $pvs_global_settings["allow_photo"] )
		{
			echo ( "<li>" . pvs_word_lang( "photo" ) . ": <b>" . $res_photo . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_video"] )
		{
			echo ( "<li>" . pvs_word_lang( "video" ) . ": <b>" . $res_video . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_audio"] )
		{
			echo ( "<li>" . pvs_word_lang( "audio" ) . ": <b>" . $res_audio . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_vector"] )
		{
			echo ( "<li>" . pvs_word_lang( "vector" ) . ": <b>" . $res_vector . "</b></li>" );
		}
		echo ( "</ul>" );

		echo ( "<div class='admin_field'><span>" . pvs_word_lang( "select action" ) .
			":</span><select name='keywords_action' style='width:300px'><option value='add'>" .
			pvs_word_lang( "add new keywords" ) . "</option><option value='remove'>" .
			pvs_word_lang( "remove keywords" ) . "</option></select></div>" );

		echo ( "<div class='admin_field'><span>" . pvs_word_lang( "keywords" ) .
			":</span><textarea name='keywords' style='width:500px;height:150px'></textarea></div>" );

		foreach ( $_POST as $key => $value )
		{
			$res_temp = explode( "sel", $key );

			if ( count( $res_temp ) == 2 and ( int )$res_temp[1] > 0 )
			{
				echo ( "<input type='hidden' name='" . $key . "' value='1'>" );
			}
		}

		echo ( "<input type='hidden'  name='formaction' value='" . pvs_result( $_POST["formaction"] ) .
			"'>
		<input type='hidden'  name='step' value='2'><input type='hidden'  name='action' value='edit'>
		<input type='submit'  class='btn btn-primary'  value='" . pvs_word_lang( "Ok" ) .
			"'>" );

		echo ( "</form>" );
	} else
	{

		if ( pvs_result( $_POST["keywords"] ) != "" )
		{
			$keywords_new = explode( ",", str_replace( ";", ",", pvs_result( $_POST["keywords"] ) ) );
			foreach ( $keywords_new as $key => $value )
			{
				$keywords_new[$key] = trim( $value );
				if ( $keywords_new[$key] == "" )
				{
					unset( $keywords_new[$key] );
				}
			}

			for ( $i = 0; $i < count( $res_id ); $i++ )
			{
				$sql = "select keywords from " . PVS_DB_PREFIX .
					"media where id=" . $res_id[$i];
				$dr->open( $sql );
				if ( ! $dr->eof )
				{
					$keywords_old = explode( ",", str_replace( ";", ",", $dr->row["keywords"] ) );
					foreach ( $keywords_old as $key => $value )
					{
						$keywords_old[$key] = trim( $value );
						if ( $keywords_old[$key] == "" )
						{
							unset( $keywords_old[$key] );
						}
					}

					if ( $_POST["keywords_action"] == "add" )
					{
						foreach ( $keywords_new as $key => $value )
						{
							if ( ! in_array( $value, $keywords_old ) )
							{
								$keywords_old[] = $value;
							}
						}
					} else
					{
						foreach ( $keywords_old as $key => $value )
						{
							if ( in_array( $value, $keywords_new ) )
							{
								unset( $keywords_old[$key] );
							}
						}
					}

					$keywords_list = "";
					foreach ( $keywords_old as $key => $value )
					{
						if ( $keywords_list != "" )
						{
							$keywords_list .= ",";
						}
						$keywords_list .= $value;
					}

					$sql = "update " . PVS_DB_PREFIX . "media set keywords='" . $keywords_list .
						"' where id=" . $res_id[$i];
					$db->execute( $sql );
				}
			}
		}
	}
}
//End. Bulk add/remove keywords

//Change files to editorial
if ( $_POST["formaction"] == "editorial" or $_POST["formaction"] ==
	"editorial_publication" )
{
	if ( ! isset( $_POST["step"] ) )
	{
		if ( $_POST["formaction"] == "editorial" )
		{
			echo ( "<h1>" . pvs_word_lang( "categories" ) . "</h1>" );
		} else
		{
			echo ( "<h1>" . pvs_word_lang( "catalog" ) . "</h1>" );
		}

		echo ( "<p>Do you want to change the photos <b>(" . $res_photo .
			")</b> to Editorial/Creative?</p>" );

		echo ( "<form method='post' action='" . pvs_plugins_admin_url('catalog/index.php') . "'>" );

		echo ( "<p><input type='radio' name='editorial' value='1' checked> " .
			pvs_word_lang( "editorial" ) . "</p>" );

		echo ( "<p><input type='radio' name='editorial' value='0'> " . pvs_word_lang( "creative" ) .
			"</p>" );

		foreach ( $_POST as $key => $value )
		{
			$res_temp = explode( "sel", $key );

			if ( count( $res_temp ) == 2 and ( int )$res_temp[1] > 0 )
			{
				echo ( "<input type='hidden' name='" . $key . "' value='1'>" );
			}
		}

		echo ( "<input type='hidden'  name='formaction' value='" . pvs_result( $_POST["formaction"] ) .
			"'>
		<input type='hidden'  name='step' value='2'><input type='hidden'  name='action' value='edit'>
		<input type='submit'  class='btn btn-primary'  value='" . pvs_word_lang( "Ok" ) .
			"'>" );

		echo ( "</form>" );
	} else
	{
		for ( $i = 0; $i < count( $res_id ); $i++ )
		{
			if ( $res_module[$i] == 1 )
			{
				$sql = "update " . PVS_DB_PREFIX . "media set editorial=" . ( int )$_POST["editorial"] .
					" where id=" . $res_id[$i];
				$db->execute( $sql );
			}
		}
	}
}
//End. Change files to editorial

//Change files to approve
if ( $_POST["formaction"] == "approve" or $_POST["formaction"] ==
	"approve_publication" )
{
	if ( ! isset( $_POST["step"] ) )
	{
		if ( $_POST["formaction"] == "approve" )
		{
			echo ( "<h1>" . pvs_word_lang( "categories" ) . "</h1>" );
		} else
		{
			echo ( "<h1>" . pvs_word_lang( "catalog" ) . "</h1>" );
		}

		echo ( "<p>Do you want to approve/decline the files?</p>" );

		echo ( "<form method='post' action='" . pvs_plugins_admin_url('catalog/index.php') . "'>" );

		echo ( "<p><input type='radio' name='approve' value='1' checked> " .
			pvs_word_lang( "approve" ) . "</p>" );

		echo ( "<p><input type='radio' name='approve' value='0'> " . pvs_word_lang( "pending" ) .
			"</p>" );

		echo ( "<p><input type='radio' name='approve' value='-1'> " . pvs_word_lang( "decline" ) .
			"</p>" );

		echo ( "<ul>" );
		if ( $pvs_global_settings["allow_photo"] )
		{
			echo ( "<li>" . pvs_word_lang( "photo" ) . ": <b>" . $res_photo . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_video"] )
		{
			echo ( "<li>" . pvs_word_lang( "video" ) . ": <b>" . $res_video . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_audio"] )
		{
			echo ( "<li>" . pvs_word_lang( "audio" ) . ": <b>" . $res_audio . "</b></li>" );
		}
		if ( $pvs_global_settings["allow_vector"] )
		{
			echo ( "<li>" . pvs_word_lang( "vector" ) . ": <b>" . $res_vector . "</b></li>" );
		}
		echo ( "</ul>" );

		foreach ( $_POST as $key => $value )
		{
			$res_temp = explode( "sel", $key );

			if ( count( $res_temp ) == 2 and ( int )$res_temp[1] > 0 )
			{
				echo ( "<input type='hidden' name='" . $key . "' value='1'>" );
			}
		}

		echo ( "<input type='hidden'  name='formaction' value='" . pvs_result( $_POST["formaction"] ) .
			"'>
		<input type='hidden'  name='step' value='2'><input type='hidden'  name='action' value='edit'>
		<input type='submit'  class='btn btn-primary' value='" . pvs_word_lang( "Ok" ) .
			"'>" );

		echo ( "</form>" );
	} else
	{
		for ( $i = 0; $i < count( $res_id ); $i++ )
		{
			$sql = "update " . PVS_DB_PREFIX . "media set published=" . ( int )$_POST["approve"] .
					" where id=" . $res_id[$i];
			$db->execute( $sql );
		}
	}
}
//End. Change files to approve

?>