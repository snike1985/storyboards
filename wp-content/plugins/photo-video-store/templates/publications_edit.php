<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}



if ( $pvs_global_settings["userupload"] == 0 ) {	
	exit();
}

//Get list of IDs
$res_id = array();
$res_module = array();
$res_category = 0;
$res_photo = 0;
$res_video = 0;
$res_audio = 0;
$res_vector = 0;
$nlimit = 0;

foreach ( $_POST as $key => $value ) {
	$res_temp = explode( "sel", $key );

	if ( count( $res_temp ) == 2 and ( int )$res_temp[1] > 0 ) {

		if ( @$_POST["formaction"] == "edit" or @$_POST["formaction"] == "delete" ) {
			$res_id[] = ( int )$res_temp[1];

			$sql = "select media_id from " . PVS_DB_PREFIX . "media where id=" . ( int )$res_temp[1];
			$dr->open( $sql );
			while ( ! $dr->eof )
			{
				$res_module[] = $dr->row["media_id"];
				if ( pvs_media_type ($dr->row["media_id"]) == 'photo' )
				{
					$res_photo++;
				}

				if ( pvs_media_type ($dr->row["media_id"]) == 'video' )
				{
					$res_video++;
				}

				if ( pvs_media_type ($dr->row["media_id"]) == 'audio' )
				{
					$res_audio++;
				}

				if ( pvs_media_type ($dr->row["media_id"]) == 'vector' )
				{
					$res_vector++;
				}

				$dr->movenext();
			}
		}
	}
}
//End. Get list of IDs

//Change publications properties
if ( @$_POST["formaction"] == "edit" ) {
	$return_url = $_POST["return_url"];

	if ( ! isset( $_POST["step"] ) ) {		
		get_header(); 
		echo('<div class="container second_page">');
		include ( "profile_top.php" );

		echo ( "<h1>" . pvs_word_lang( "my publications" ) . " &mdash; " . pvs_word_lang
			( "edit" ) . "</h1>" );

		if ( $pvs_global_settings["clarifai"] ) {
			echo ( "<div class='form_field'><p><b>" . pvs_word_lang( "Image recognition" ) .
				":</b></p>" );
			$clarifai_files = "";
			$imagga_files = "";

			echo ( "<a href=\"javascript:go_clarifai()\"  class='btn btn-warning'>Clarifai</a> " );
			echo ( "</div><br>" );
		}

		if ( count( $res_id ) > 0 ) {
			echo ( "<form method='post' action='<?php echo (site_url( ) );?>/publications-edit/'>" );

			echo ( "<table border='0' cellpadding='0' cellspacing='1' class='profile_table' width='100%'>" );

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
				$sql = "select id,title,description,keywords,free,featured,adult from " .
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

					$adult = "";
					if ( $rs->row["adult"] == 1 )
					{
						$adult = "checked";
					}

					
					$category_ids = array();
					$sql = "select category_id from " . PVS_DB_PREFIX . "category_items where publication_id=" . $res_id[$i];
					$ds->open( $sql );
					while ( ! $ds->eof ) {
						$category_ids[$ds->row["category_id"]] = 1;
						$ds->movenext();
					}
					$itg = "";
					$nlimit = 0;
					pvs_build_menu_admin_tree( 0, "seller", "cat" . $res_id[$i] . "_" );
					$category = $itg;


					echo ( "<tr><th colspan='2'>" . pvs_word_lang( $type ) . " ID=" . $res_id[$i] .
						"</th></tr><tr valign='top'>" );
					echo ( "<td>" );
					echo ( "<div style='margin-bottom:3px'>" . pvs_show_preview( $res_id[$i], $type,
						1, 0 ) . "</div>" );

					
					echo('<script>
			$(document).ready(function(){
				$(".categories_tree_menu").treeview({
					collapsed: false
				});
			});
			</script>');

					echo ( "<div class='form_field'><span><b>" . pvs_word_lang( "category" ) .
						":</b></span>" .
						$category . "</div>" );
						
					echo ( "</td>" );
					echo ( "<td>" );


					echo ( "<div class='form_field'><span><b>" . pvs_word_lang( "title" ) .
						":</b></span><input class='ibox form-control' type='text' name='title" . $res_id[$i] .
						"' value='" . $rs->row["title"] . "' style='width:400px'></div>" );

					echo ( "<div class='form_field'><span><b>" . pvs_word_lang( "description" ) .
						":</b></span><textarea class='ibox form-control' name='description" . $res_id[$i] .
						"' style='width:400px;height:150px'>" . $rs->row["description"] .
						"</textarea></div>" );

					echo ( "<div class='form_field'><span><b>" . pvs_word_lang( "keywords" ) .
						":</b></span><textarea class='ibox form-control' name='keywords" . $res_id[$i] .
						"' id='keywords" . $res_id[$i] . "' style='width:400px;height:150px'>" . $rs->
						row["keywords"] . "</textarea></div>" );
					echo ( "<input type='hidden' name='sel" . $res_id[$i] . "' value='1'>" );

					echo ( "<div class='form_field'><span><b>" . pvs_word_lang( "free" ) .
						":</b></span><input type='checkbox' name='free" . $res_id[$i] . "' " . $free .
						"></div>" );

					if ( $pvs_global_settings["adult_content"] )
					{
						echo ( "<div class='form_field'><span><b>" . pvs_word_lang( "adult content" ) .
							":</b></span><input type='checkbox' name='adult" . $res_id[$i] . "' " . $adult .
							"></div>" );
					}
					echo ( "</td>" );
					echo ( "</tr>" );
				}
			}

			echo ( "</table>" );

			echo ( "<input type='hidden'  name='formaction' value='" . pvs_result( @$_POST["formaction"] ) .
				"'><input type='hidden'  name='return_url' value='" . $_SERVER["HTTP_REFERER"] .
				"'>
			<input type='hidden'  name='step' value='2'>
			<input type='submit' class='isubmit' value='" . pvs_word_lang( "save" ) .
				"' style='margin-top:15px'>" );

			echo ( "</form>" );

		} else {
			echo ( "<p>" . pvs_word_lang( "not found" ) . "</p>" );
			echo ( "<input type='button' class='isubmit' onClick=\"location.href='" . $return_url .
				"'\"  value='" . pvs_word_lang( "Back" ) . "'>" );
		}

		if ( $pvs_global_settings["clarifai"] ) {
?>
		<script src="https://sdk.clarifai.com/js/clarifai-1.2.0.js"></script>
		<script>
		  Clarifai.initialize({
			'clientId': '<?php
			echo $pvs_global_settings["clarifai_key"]; ?>',
			'clientSecret': '<?php
			echo $pvs_global_settings["clarifai_password"]; ?>'
		  });
		
		
		function get_clarifai(url,field_id,language,default_value) {
			Clarifai.getTagsByUrl(url, {
		  'model': '<?php echo $pvs_global_settings["clarifai_model"]; ?>','language': '<?php
			echo ( $lang_symbol[$lng_original] );?>'
		}).then(
			  function(response) {
	tags = "";

	if(default_value) {
		tags = $("#"+field_id).val();
	}
	
	tags_obj = {};
	
	for(i=0;i<response.results[0].result.tag.classes.length;i++) {
		if(tags !=	 "") {
			tags += ",";
		}
		tags += response.results[0].result.tag.classes[i];
	}
	
	tags_mass = tags.split(',');
	
	for(i=0;i<tags_mass.length;i++) {
		tags_obj[tags_mass[i]] = 1;
	}
	
	tags = "";
	
	for (var key in tags_obj) 
	{
		if(tags !=	 "") {
			tags += ", ";
		}
		tags += key;
	}
	
	$("#"+field_id).val(tags);
			  },
			  function(err) {
	//$("#"+field_id).val(err);
			  }
			);
		}
		
		function go_clarifai() {
			clarifai_files = {};
			<?php
			echo ( @$clarifai_files );?>
			for(key in clarifai_files) 
			{
	get_clarifai(clarifai_files[key],key,'<?php
			echo ( $lang_symbol[$lng_original] );?>',true)
			}
		}
		</script>
		<?php
		}
	
		include ( "profile_bottom.php" );
		echo('</div>');
		get_footer(); 
		

	} else {
		for ( $i = 0; $i < count( $res_id ); $i++ ) {

			$free = 0;
			if ( isset( $_POST["free" . $res_id[$i]] ) )
			{
				$free = 1;
			}

			$adult = 0;
			if ( isset( $_POST["adult" . $res_id[$i]] ) )
			{
				$adult = 1;
			}

			$sql = "select id from " . PVS_DB_PREFIX . "media where (userid=" . ( int )
				get_current_user_id() . " or author='" . pvs_result( pvs_get_user_login () ) .
				"') and id=" . $res_id[$i];
			$rs->open( $sql );
			if ( ! $rs->eof )
			{
				$sql = "update " . PVS_DB_PREFIX . "media set title='" . pvs_result( $_POST["title" .
					$res_id[$i]] ) . "',description='" . pvs_result( $_POST["description" . $res_id[$i]] ) .
					"',keywords='" . pvs_result( $_POST["keywords" . $res_id[$i]] ) . "',free=" . $free . ",adult=" . $adult . " where id=" . $res_id[$i];
				$db->execute( $sql );
				
				pvs_add_categories( $res_id[$i], "cat" . $res_id[$i] . "_" );

				pvs_item_url( $res_id[$i] );
			}

		}
		header( "location:" . $return_url );
	}
}
//End. Change publications properties

//Delete publications
if ( @$_POST["formaction"] == "delete" and ! $demo_mode ) {
	for ( $i = 0; $i < count( $res_id ); $i++ ) {
		$sql = "select id from " . PVS_DB_PREFIX . "media where (userid=" . ( int )
			get_current_user_id() . " or author='" . pvs_result( pvs_get_user_login () ) .
			"') and id=" . $res_id[$i] . " and (published=0 or published=-1)";
		$rs->open( $sql );
		if ( ! $rs->eof ) {
			pvs_publication_delete( $res_id[$i] );
		}
	}

	header( "location:" . $_POST["return_url"] );
}
//End. Delete publications

//

?>




