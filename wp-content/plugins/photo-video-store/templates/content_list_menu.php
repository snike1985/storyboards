<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
?>
<form id='listing_form' method="get" action="<?php echo site_url()?>/" style="margin:0px">
<?php
//Default variables

if ( isset( $_REQUEST["id_parent"] ) ) {
	echo ( "<input type='hidden' name='id_parent' value='" . ( int )$_REQUEST["id_parent"] .
		"'>" );
}

if ( isset( $_REQUEST["acategory"] ) ) {
	echo ( "<input type='hidden' name='acategory' value='" . ( int )$_REQUEST["acategory"] .
		"'>" );
}

if ( isset( $_REQUEST["category"] ) ) {
	echo ( "<input type='hidden' name='category' value='" . pvs_result( $_REQUEST["category"] ) .
		"'>" );
}

if ( isset( $_REQUEST["items"] ) ) {
	echo ( "<input type='hidden' name='items' value='" . ( int )$_REQUEST["items"] .
		"'>" );
}

if ( isset( $_REQUEST["c"] ) ) {
	echo ( "<input type='hidden' name='c' value='" . pvs_result( $_REQUEST["c"] ) .
		"'>" );
}

$vars_categories = pvs_build_variables( "id_parent", "acategory", true,
	"category" );
$vars_portfolio = pvs_build_variables( "user", "portfolio" );
$vars_author = pvs_build_variables( "author", "" );
$vars_lightbox = pvs_build_variables( "lightbox", "" );
$vars_prints = pvs_build_variables( "print_id", "" );

//End. Default variables.

?>
	<div class="search_left_top"></div>
	<div class="search_left_body">
	<div class="search_title"><?php echo pvs_word_lang( "search" )?></div>
	<div id="search_current">
		<?php
//Keywords menu
if ( isset( $_REQUEST["search"] ) and $_REQUEST["search"] != "" ) {
	if ( ! in_array( pvs_result( $_REQUEST["search"] ), $kw_mass ) ) {
		$kw_mass[] = pvs_result( $_REQUEST["search"] );
		//$_REQUEST["search"]="";
	}
}

sort( $kw_mass );
reset( $kw_mass );

if ( count( $kw_mass ) > 0 ) {
	echo ( "<div class='search_current_kw_title'>" . pvs_word_lang( "keywords" ) .
		"</div>" );
} else
{
	echo ( "<div class='search_current_kw'>" . pvs_word_lang( "all files" ) .
		"</div>" );
}

$kw_string = "";
for ( $i = 0; $i < count( $kw_mass ); $i++ ) {
	if ( $kw_string != "" ) {
		$kw_string .= "|";
	}
	$kw_string .= $kw_mass[$i];

	$var_prefix = "";
	for ( $j = 0; $j < count( $kw_mass ); $j++ ) {
		if ( $i != $j ) {
			if ( $var_prefix != "" )
			{
				$var_prefix .= "|";
			}
			$var_prefix .= $kw_mass[$j];
		}
	}

	echo ( "<div class='search_current_kw'>" );
	echo ( "<input type='button' class='search_current_delete' onClick=\"location.href='" .
		pvs_build_variables( "kw_list", "search" ) . "&kw_list=" . $var_prefix . "'\">" );
	echo ( $kw_mass[$i] );
	echo ( "</div>" );
}

echo ( "<input type='hidden' name='kw_list' value='" . $kw_string . "'>" );
//End. Keywords menu

//Prints menu
if ( isset( $_REQUEST["print_id"] ) ) {
	echo ( "<div class='search_line2'></div>" );
	echo ( "<div class='search_current_kw_title'>" . pvs_word_lang( "prints" ) .
		"</div>" );

	$sql2 = "select title from " . PVS_DB_PREFIX . "prints where id_parent=" . ( int )
		$_REQUEST["print_id"];
	$dr->open( $sql2 );
	if ( ! $dr->eof ) {
		echo ( "<div class='search_current_kw'>" );
		echo ( "<input type='hidden' name='print_id' value='" . ( int )$_REQUEST["print_id"] .
			"'>" );
		echo ( "<input type='button' class='search_current_delete' onClick=\"location.href='" .
			$vars_prints . "'\">" );
		echo ( pvs_word_lang( $dr->row["title"] ) );
		echo ( "</div>" );
	}
}
//End. Prints menu

//Portfolio menu
if ( ( isset( $_REQUEST["portfolio"] ) and isset( $_REQUEST["user"] ) ) or ( isset
	( $_REQUEST["author"] ) and $_REQUEST["author"] != '' ) ) {
	echo ( "<div class='search_line2'></div>" );
	echo ( "<div class='search_current_kw_title'>" . pvs_word_lang( "portfolio" ) .
		"</div>" );
	if ( isset( $_REQUEST["author"] ) and $_REQUEST["author"] != '' ) {
		$sql2 = "select user_login from " . $table_prefix . "users where user_login='" .
			pvs_result( $_REQUEST["author"] ) . "'";
		$dr->open( $sql2 );
		if ( ! $dr->eof ) {
			echo ( "<div class='search_current_kw'>" );
			echo ( "<input type='button' class='search_current_delete' onClick=\"location.href='" .
				$vars_author . "'\">" );
			echo ( $dr->row["user_login"] );
			echo ( "</div>" );
		}
	} else {
		if ( isset( $_REQUEST["portfolio"] ) and isset( $_REQUEST["user"] ) ) {
			$sql2 = "select user_login from " . $table_prefix . "users where ID=" . ( int )
				$_REQUEST["user"];
			$dr->open( $sql2 );
			if ( ! $dr->eof )
			{
				echo ( "<div class='search_current_kw'>" );
				echo ( "<input type='hidden' name='portfolio' value='1'>" );
				echo ( "<input type='hidden' name='user' value='" . ( int )$_REQUEST["user"] .
					"'>" );
				echo ( "<input type='button' class='search_current_delete' onClick=\"location.href='" .
					$vars_portfolio . "'\">" );
				echo ( $dr->row["user_login"] );
				echo ( "</div>" );
			}
		}
	}
}
//End portfolio menu

//Lightbox menu
if ( isset( $_REQUEST["lightbox"] ) ) {
	echo ( "<div class='search_line2'></div>" );
	echo ( "<div class='search_current_kw_title'>" . pvs_word_lang( "lightboxes" ) .
		"</div>" );
	$sql2 = "select title from " . PVS_DB_PREFIX . "lightboxes where id=" . ( int )
		$_REQUEST["lightbox"];
	$dr->open( $sql2 );
	if ( ! $dr->eof ) {
		echo ( "<div class='search_current_kw'>" );
		echo ( "<input type='hidden' name='lightbox' value='" . ( int )$_REQUEST["lightbox"] .
			"'>" );
		echo ( "<input type='button' class='search_current_delete' onClick=\"location.href='" .
			$vars_lightbox . "'\">" );
		echo ( $dr->row["title"] );
		echo ( "</div>" );
	}
}
//End lightbox menu

//Category menu
if ( isset( $_REQUEST["id_parent"] ) or isset( $_REQUEST["acategory"] ) or isset
	( $_REQUEST["category"] ) ) {
	echo ( "<div class='search_line2'></div>" );
	echo ( "<div class='search_current_kw_title'>" . pvs_word_lang( "category" ) .
		"</div>" );

	if ( isset( $_REQUEST["acategory"] ) ) {
		$category_id = ( int )$_REQUEST["acategory"];
		$sql2 = "select id_parent,title from " . PVS_DB_PREFIX .
			"category where id_parent=" . $category_id;
	}
	if ( isset( $_REQUEST["category"] ) ) {
		if ( ! preg_match( "/^[0-9]+$/", $_REQUEST["category"] ) ) {
			$sql2 = "select id_parent,title from " . PVS_DB_PREFIX .
				"category where title='" . str_replace( "-", " ", pvs_result_strict( $_REQUEST["category"] ) ) .
				"'";
		} else {
			$sql2 = "select id_parent,title from " . PVS_DB_PREFIX .
				"category where id_parent=" . ( int )$_REQUEST["category"];
		}
	}
	if ( isset( $_REQUEST["id_parent"] ) ) {
		$category_id = ( int )$_REQUEST["id_parent"];
		$sql2 = "select id_parent,title from " . PVS_DB_PREFIX .
			"category where id_parent=" . $category_id;
	}

	$dr->open( $sql2 );
	if ( ! $dr->eof ) {
		$translate_results = pvs_translate_category( $dr->row["id_parent"], $dr->row["title"],
			"", "" );
		echo ( "<div class='search_current_kw'>" );
		echo ( "<input type='button' class='search_current_delete' onClick=\"location.href='" .
			$vars_categories . "'\">" );
		echo ( $translate_results["title"] );
		echo ( "</div>" );
	}
}
//End. Category menu

?>
	</div>
	
	<div class="search_title"><?php echo pvs_word_lang( "keywords" )?></div>
	<div class="search_text">
		<div id="search_keywords">
			<input name="search" type="text" class="ibox3" onClick="this.value=''">
			<input type="submit" class="ibox3_submit" value="">
		</div>
	</div>
	<script languages="javascript">
	 	function listing_submit()
	 	{
	 		$('#listing_form').submit();
	 	}
	 	
	 	function show_sub(value,value2)
	 	{
	 		if(document.getElementById(value).style.display=='none')
	 		{
	 			$("#"+value).slideDown("fast");
	 			document.getElementById(value2).className='search_title4';
	 			document.cookie = "z_" + value + "=" + escape (1) + ";path=/";
	 		}
	 		else
	 		{
	 			$("#"+value).slideUp("fast");
	 			document.getElementById(value2).className='search_title3';
	 			document.cookie = "z_" + value + "=" + escape (0) + ";path=/";
	 		}
	 	}
	 	

	</script>
<?php
$qnt_types = 0;
if ( $pvs_global_settings["allow_photo"] ) {
	$qnt_types++;
}
if ( $pvs_global_settings["allow_video"] ) {
	$qnt_types++;
}
if ( $pvs_global_settings["allow_audio"] ) {
	$qnt_types++;
}
if ( $pvs_global_settings["allow_vector"] ) {
	$qnt_types++;
}

if ( $qnt_types > 1 and ! $pvs_global_settings["printsonly"] ) {
?>
	<div class="search_text">
	<?php
		if ( $pvs_global_settings["allow_photo"] ) {
?>
			<div class="search_checkbox"><input type="checkbox" name="sphoto" <?php
			if ( $mass_types["photo"] == 1 )
			{
				echo ( "checked" );
			}
?> onClick="listing_submit()"> <?php
			echo pvs_word_lang( "photo" )?></div>
			<?php
		}
		if ( $pvs_global_settings["allow_video"] ) {
?>
			<div class="search_checkbox"><input type="checkbox" name="svideo" <?php
			if ( $mass_types["video"] == 1 )
			{
				echo ( "checked" );
			}
?> onClick="listing_submit()"> <?php
			echo pvs_word_lang( "video" )?></div>
			<?php
		}
		if ( $pvs_global_settings["allow_audio"] ) {
?>
			<div class="search_checkbox"><input type="checkbox" name="saudio" <?php
			if ( $mass_types["audio"] == 1 )
			{
				echo ( "checked" );
			}
?> onClick="listing_submit()"> <?php
			echo pvs_word_lang( "audio" )?></div>
			<?php
		}
		if ( $pvs_global_settings["allow_vector"] ) {
?>
			<div class="search_checkbox"><input type="checkbox" name="svector" <?php
			if ( $mass_types["vector"] == 1 )
			{
				echo ( "checked" );
			}
?> onClick="listing_submit()"> <?php
			echo pvs_word_lang( "vector" )?></div>
			<?php
		}
?>
	</div>
	
	<?php
}
?>	
	
	<?php
if ( $pvs_global_settings["royalty_free"] and $pvs_global_settings["rights_managed"] and
	! $pvs_global_settings["printsonly"] ) {
?>
		<div class="search_title"><?php echo pvs_word_lang( "license" )?></div>
		
		<div class="search_text">
			<div class="search_checkbox"><input type="checkbox" name="royalty_free" value="1" <?php
	if ( $royalty_free == 1 ) {
		echo ( "checked" );
	}
?> onClick="listing_submit()"> <?php echo pvs_word_lang( "royalty free" )?></div>
		
			<div class="search_checkbox"><input type="checkbox" name="rights_managed" value="1" <?php
	if ( $rights_managed == 1 ) {
		echo ( "checked" );
	}
?> onClick="listing_submit()"> <?php echo pvs_word_lang( "rights managed" )?></div>
		</div>
	<?php
}
?>
	
	<?php
if ( $pvs_global_settings["prints"] ) {
?>
		<div class="search_title"><?php echo pvs_word_lang( "prints and products" )?></div>
		
		<div class="search_text">
			<select onChange='location.href=this.value' class='ibox' style="width:90%">
			<option value="#"></option>
			<?php
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
		while ( ! $dd->eof ) {
			$chk = "";
			if ( @$_REQUEST["print_id"] == $dd->row["id_parent"] )
			{
				$chk = "selected";
			}
?>
			<option value="<?php
			echo pvs_build_variables( "print_id", "" )?>&print_id=<?php
			echo $dd->row["id_parent"] ?>" <?php
			echo $chk
?>><?php
			echo pvs_word_lang( $dd->row["title"] )?></option>
		<?php
			$dd->movenext();
		}
	}
?>
			</select>
		</div>
	<?php
}
?>
	
	<div class="search_line"></div>

	
	<div class="search_title3" id="search_title_advanced" onClick="show_sub('search_advanced_search','search_title_advanced');"><?php echo pvs_word_lang( "advanced search" )?></div>
	<div id="search_advanced_search" class="search_sub" style="display:none">
	
		<div class="search_title2"><?php echo pvs_word_lang( "item id" )?>:</div>
		<div class="search_text2">
			<input type="text" name="item_id" style="width:135px" class='ibox2'>
		</div>
	
		<div class="search_title2"><?php echo pvs_word_lang( "author" )?>:</div>
		<div class="search_text2">
			<input type="text" name="author" style="width:135px" class='ibox2' value='<?php
if ( isset( $_REQUEST["author"] ) ) {
	echo ( pvs_result( $_REQUEST["author"] ) );
}
?>'>
		</div>
		
		<?php
if ( $pvs_global_settings["show_content_type"] ) {
?>
		<div class="search_title2"><?php echo pvs_word_lang( "content type" )?>:</div>
		<div class="search_text2">
			<select name="content_type" style="width:135px" class='ibox2 form-control'>
			<option value=''><?php echo pvs_word_lang( "all" )?></option>
			<?php
	$sql4 = "select * from " . PVS_DB_PREFIX . "content_type order by priority";
	$dr->open( $sql4 );
	while ( ! $dr->eof ) {
		$sel = "";
		if ( @$_REQUEST["content_type"] == $dr->row["name"] ) {
			$sel = "selected";
		}
?>
	<option value="<?php echo $dr->row["name"] ?>" <?php echo $sel
?>><?php echo $dr->row["name"] ?></option>
	<?php
		$dr->movenext();
	}
?>
			</select>
		</div>
		<?php
}

if ( $stock_remote ) {
?>
			<div class="search_title2"><?php echo pvs_word_lang( "type" )?>:</div>
			<div class="search_text2">
	<select name='c' style='width:135px' class='ibox2 form-control'>
	<?php
	for ( $i = 0; $i < count( $cmenu ); $i++ ) {
		$sel = "";
		if ( $c == $cmenu[$i] ) {
			$sel = " selected ";
		}

		echo ( "<option value='" . $cmenu[$i] . "' " . $sel . ">" . pvs_word_lang( $cmenu[$i] ) .
			"</option>" );
	}
?>
	</select>
			</div>
			<?php
}
?>
		
		
		<div class="search_title2"><?php echo pvs_word_lang( "date" )?></div>
			<div class="search_text2">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
	<input type='text' name='publication_date' id='publication_date' style='width:120px' value='<?php echo pvs_result( @$_REQUEST["publication_date"] )?>' class='ibox2'>
		 		<script>
		$(function() {
		$( "#publication_date" ).datepicker();
		});
	</script>
			</div>
			
			
		<div class="search_title2"><?php echo pvs_word_lang( "price" )?>:</div>
			<div class="search_text2">
			<input type="text"  class='ibox2' id="price" name="price" value="<?php echo $price_min
?> - <?php echo $price_max
?>" readonly style="width:120px;margin-bottom:0px">
	<script>
	$(function() {
	$( "#slider-range3" ).slider({
	range: true,
	min: 0,
	max: <?php echo ( int )$pvs_global_settings["max_price"] ?>,
	values: [<?php echo $price_min
?>,<?php echo $price_max
?>],
	slide: function( event, ui ) {
	$( "#price" ).val(ui.values[ 0 ] + " - " + ui.values[ 1 ] );
	}
	});
	$( "#price" ).val($( "#slider-range3" ).slider( "values", 0 ) +
	" - " + $( "#slider-range3" ).slider( "values", 1 ) );
	});
	</script>
	<div class="box_slider">		
		<div id="slider-range3"></div>
		<div class="box_slider2">0</div>
		<div class="box_slider3"><?php echo ( int )$pvs_global_settings["max_price"] ?></div>
	</div>
	
			</div>
		
		
		<?php
if ( $pvs_global_settings["adult_content"] ) {
?>
		<div class="search_title2"><?php echo pvs_word_lang( "exclude adult content" )?>:</div>
		<div class="search_text2">
			<input type="checkbox" name="adult" class='ibox2' <?php
	if ( isset( $_REQUEST["adult"] ) ) {
		echo ( "checked" );
	}
?>>
		</div>
		<?php
}
?>
		
		<?php
if ( $pvs_global_settings["exclusive_price"] ) {
?>
		<div class="search_title2"><?php echo pvs_word_lang( "exclusive price" )?>:</div>
		<div class="search_text2">
			<input type="checkbox" name="exclusive" class='ibox2' <?php
	if ( isset( $_REQUEST["exclusive"] ) ) {
		echo ( "checked" );
	}
?>>
		</div>
		<?php
}
?>
		
		<?php
if ( $pvs_global_settings["contacts_price"] ) {
?>
		<div class="search_title2"><?php echo pvs_word_lang( "contact us to get the price" )?>:</div>
		<div class="search_text2">
			<input type="checkbox" name="contacts" class='ibox2' <?php
	if ( isset( $_REQUEST["contacts"] ) ) {
		echo ( "checked" );
	}
?>>
		</div>
		<?php
}
?>
		
	</div>
	
	<?php
if ( $pvs_global_settings["allow_photo"] ) {
?>
		<div class="search_line"></div>
		<div  class="search_title3"  id="search_title_photo" onClick="show_sub('search_photo_filters','search_title_photo');"><?php echo pvs_word_lang( "photo filters" )?></div>
		<div id="search_photo_filters" class="search_sub" style="display:none">
			<div class="search_title2"><?php echo pvs_word_lang( "license" )?>:</div>
			<div class="search_text2">
	<input type="checkbox" name="creative" <?php echo $creative
?>> <?php echo pvs_word_lang( "creative" )?><br>
	<input type="checkbox" name="editorial" <?php echo $editorial
?>> <?php echo pvs_word_lang( "editorial" )?>
			</div>
		
			<div class="search_title2"><?php echo pvs_word_lang( "color" )?>:</div>
			<div class="search_text2">
	<?php
	$default_color = "";
	if ( isset( $_REQUEST["color"] ) ) {
		$default_color = pvs_result( $_REQUEST["color"] );
	}
	?>
	<div id='colorpicker' class='color_selector'><div style='background-color:#<?php echo($default_color);?>'></div></div>
	<script>
			$(document).ready(function() {
			$('#colorpicker').ColorPicker({
				color: '#<?php echo($default_color);?>',
				onShow: function (colpkr) {
		$(colpkr).fadeIn(500);
		return false;
				},
				onHide: function (colpkr,hex) {
		$(colpkr).fadeOut(500);
		return false;		
				},
				onChange: function (hsb, hex, rgb) {
		$('#colorpicker div').css('backgroundColor', '#' + hex);
		$('#property_color').val(hex);

				}
			});});
	</script>
	<input type='hidden' id='property_color'  name='color' value='<?php echo($default_color);?>'>
			</div>
		
			<div class="search_title2"><?php echo pvs_word_lang( "orientation" )?>:</div>
			<div class="search_text2">
	<?php
	$default_orientation = -1;
	if ( isset( $_REQUEST["orientation"] ) ) {
		$default_orientation = ( int )$_REQUEST["orientation"];
	}
?>
	<input type="radio" name="orientation" value="-1" <?php
	if ( $default_orientation == -1 ) {
		echo ( "checked" );
	}
?>> <?php echo pvs_word_lang( "all" )?><br>
	<input type="radio" name="orientation" value="0" <?php
	if ( $default_orientation == 0 ) {
		echo ( "checked" );
	}
?>> <?php echo pvs_word_lang( "landscape" )?><br>
	<input type="radio" name="orientation" value="1" <?php
	if ( $default_orientation == 1 ) {
		echo ( "checked" );
	}
?>> <?php echo pvs_word_lang( "portrait" )?>
			</div>
			</div>
		<?php
}

if ( $pvs_global_settings["allow_video"] and ! $pvs_global_settings["printsonly"] ) {
?>
		<div class="search_line"></div>
		<div  class="search_title3"   id="search_title_video" onClick="show_sub('search_video_filters','search_title_video');"><?php echo pvs_word_lang( "video filters" )?></div>
		<div id="search_video_filters" class="search_sub" style="display:none">
			<div class="search_title2"><?php echo pvs_word_lang( "duration" )?> (sec.):</div>
			<div class="search_text2">
			<input type="text"  class='ibox2' id="duration_video" name="duration_video" value="<?php echo $duration_video1
?> - <?php echo $duration_video2
?>" readonly style="width:120px;margin-bottom:0px">
	<script>
		$(function() {
		$( "#slider-range" ).slider({
		range: true,
		min: 0,
		max: 7200,
		values: [<?php echo $duration_video1
?>,<?php echo $duration_video2
?>],
		slide: function( event, ui ) {
		$( "#duration_video" ).val(ui.values[ 0 ] + " - " + ui.values[ 1 ] );
		}
		});
		$( "#duration_video" ).val($( "#slider-range" ).slider( "values", 0 ) +
		" - " + $( "#slider-range" ).slider( "values", 1 ) );

		});
	</script>
	<div class="box_slider">
		<div id="slider-range"></div>
		<div class="box_slider2">0m</div>
		<div class="box_slider3">120m</div>
	</div>
			</div>
		
			<div class="search_title2"><?php echo pvs_word_lang( "clip format" )?>:</div>
			<div class="search_text2">
	<select name="format" style="width:135px"  class='ibox2'>
		<option value="">...</option>
		<?php
	$sql2 = "select * from " . PVS_DB_PREFIX . "video_format";
	$dr->open( $sql2 );
	while ( ! $dr->eof ) {
		$sel = "";
		if ( isset( $_REQUEST["format"] ) and $_REQUEST["format"] == $dr->row["name"] ) {
			$sel = "selected";
		}
?>
			<option value="<?php echo $dr->row["name"] ?>" <?php echo $sel
?>><?php echo $dr->row["name"] ?></option>
			<?php
		$dr->movenext();
	}
?>
	</select>
			</div>
			
			<div class="search_title2"><?php echo pvs_word_lang( "aspect ratio" )?>:</div>
			<div class="search_text2">
	<select name="ratio" style="width:135px"  class='ibox2'>
	<option value="">...</option>
	<?php
	$sql2 = "select * from " . PVS_DB_PREFIX . "video_ratio";
	$dr->open( $sql2 );
	while ( ! $dr->eof ) {
		$sel = "";
		if ( isset( $_REQUEST["ratio"] ) and $_REQUEST["ratio"] == $dr->row["name"] ) {
			$sel = "selected";
		}
?>
		<option value="<?php echo $dr->row["name"] ?>" <?php echo $sel
?>><?php echo $dr->row["name"] ?></option>
		<?php
		$dr->movenext();
	}
?>
	</select>
			</div>

			<div class="search_title2"><?php echo pvs_word_lang( "field rendering" )?>:</div>
			<div class="search_text2">
	<select name="rendering" style="width:135px"  class='ibox2'>
	<option value="">...</option>
	<?php
	$sql2 = "select * from " . PVS_DB_PREFIX . "video_rendering";
	$dr->open( $sql2 );
	while ( ! $dr->eof ) {
		$sel = "";
		if ( isset( $_REQUEST["rendering"] ) and $_REQUEST["rendering"] == $dr->row["name"] ) {
			$sel = "selected";
		}
?>
		<option value="<?php echo $dr->row["name"] ?>" <?php echo $sel
?>><?php echo $dr->row["name"] ?></option>
		<?php
		$dr->movenext();
	}
?>
	</select>
			</div>

			<div class="search_title2"><?php echo pvs_word_lang( "frames per second" )?>:</div>
			<div class="search_text2">
	<select name="frames" style="width:135px"  class='ibox2'>
	<option value="">...</option>
	<?php
	$sql2 = "select * from " . PVS_DB_PREFIX . "video_frames";
	$dr->open( $sql2 );
	while ( ! $dr->eof ) {
		$sel = "";
		if ( isset( $_REQUEST["frames"] ) and $_REQUEST["frames"] == $dr->row["name"] ) {
			$sel = "selected";
		}
?>
		<option value="<?php echo $dr->row["name"] ?>" <?php echo $sel
?>><?php echo $dr->row["name"] ?></option>
		<?php
		$dr->movenext();
	}
?>
	</select>
			</div>
			</div>
		<?php
}
?>
	
	<?php
if ( $pvs_global_settings["allow_audio"] and ! $pvs_global_settings["printsonly"] ) {
?>
		<div class="search_line"></div>
		<div  class="search_title3"  id="search_title_audio" onClick="show_sub('search_audio_filters','search_title_audio');"><?php echo pvs_word_lang( "audio filters" )?></div>
		<div id="search_audio_filters" class="search_sub" style="display:none">
		
			<div class="search_title2"><?php echo pvs_word_lang( "duration" )?> (sec.):</div>
			<div class="search_text2">
			<input type="text"  class='ibox2' id="duration_audio" name="duration_audio" value="<?php echo $duration_audio1
?> - <?php echo $duration_audio2
?>" readonly style="width:120px;margin-bottom:0px">
	<script>
	$(function() {
	$( "#slider-range2" ).slider({
	range: true,
	min: 0,
	max: 7200,
	values: [<?php echo $duration_audio1
?>,<?php echo $duration_audio2
?>],
	slide: function( event, ui ) {
	$( "#duration_audio" ).val(ui.values[ 0 ] + " - " + ui.values[ 1 ] );
	}
	});
	$( "#duration_audio" ).val($( "#slider-range2" ).slider( "values", 0 ) +
	" - " + $( "#slider-range2" ).slider( "values", 1 ) );
	});
	</script>
	<div class="box_slider">
		<div id="slider-range2"></div>
		<div class="box_slider2">0m</div>
		<div class="box_slider3">120m</div>
	</div>
			</div>
		
		
			<div class="search_title2"><?php echo pvs_word_lang( "track format" )?>:</div>
			<div class="search_text2">
	<select class='ibox2' name="format2" style="width:135px" onChange="mdefault('format')">
	<option value="">...</option>
	<?php
	$sql2 = "select * from " . PVS_DB_PREFIX . "audio_format";
	$dr->open( $sql2 );
	while ( ! $dr->eof ) {
		$sel = "";
		if ( isset( $_REQUEST["format2"] ) and $_REQUEST["format2"] == $dr->row["name"] ) {
			$sel = "selected";
		}
?>
		<option value="<?php echo $dr->row["name"] ?>" <?php echo $sel
?>><?php echo $dr->row["name"] ?></option>
		<?php
		$dr->movenext();
	}
?>
	</select>
			</div>

			<div class="search_title2"><?php echo pvs_word_lang( "track source" )?>:</div>
			<div class="search_text2">
	<select class='ibox2' name="source" style="width:135px" onChange="mdefault('source')">
	<option value="">...</option>
	<?php
	$sql2 = "select * from " . PVS_DB_PREFIX . "audio_source";
	$dr->open( $sql2 );
	while ( ! $dr->eof ) {
		$sel = "";
		if ( isset( $_REQUEST["source"] ) and $_REQUEST["source"] == $dr->row["name"] ) {
			$sel = "selected";
		}
?>
		<option value="<?php echo $dr->row["name"] ?>" <?php echo $sel
?>><?php echo $dr->row["name"] ?></option>
		<?php
		$dr->movenext();
	}
?>
	</select>
			</div>
			</div>
		<?php
}
?>
	

	
	<div class="search_line"></div>
	
	<div  class="search_title3" id="search_title_categories"  onClick="show_sub('search_categories','search_title_categories');"><?php echo pvs_word_lang( "categories" )?></div>
	<div id="search_categories" style="display:none">
		<div class="search_text">
			<script src="<?php echo( pvs_plugins_url() ); ?>/assets/js/navgoco/jquery.cookie.min.js"></script>
			<script src="<?php echo( pvs_plugins_url() ); ?>/assets/js/navgoco/jquery.navgoco.min.js"></script>
			<link rel="stylesheet" type="text/css" href="<?php echo( pvs_plugins_url() ); ?>/assets/js/navgoco/jquery.navgoco.css" media="screen" />
			<script>
			$(document).ready(function() {
    // Initialize navgoco with default options
    $("#search_left_categories_menu").navgoco({
        caretHtml: '',
        accordion: false,
        openClass: 'open',
        save: true,
        cookie: {
            name: 'navgoco',
            expires: false,
            path: '/'
        },
        slide: {
            duration: 400,
            easing: 'swing'
        }
    });
   // $("#search_left_categories_menu").navgoco('toggle', true,0,10,17);
   // open submenus where <ul data-index="0,10,17"
});
			</script>
			<?php
//echo($categorymenu);
echo ( preg_replace( "/^<ul/i", "<ul  id='search_left_categories_menu' class='nav_categories'", pvs_get_theme_content ('box_categories') ) );?>
		</div>
	</div>

	<div class="search_line"></div>
	
	<div  class="search_title3" id="search_title_lightboxes"  onClick="show_sub('search_lightboxes','search_title_lightboxes');"><?php echo pvs_word_lang( "lightboxes" )?></div>
	<div id="search_lightboxes" style="display:none">
		<div class="search_text">
			<?php echo ( $lightboxesmenu );?>
		</div>
	</div>
	
		<script language="javascript">
		
		function show_sub_default() {
		 <?php
$mass_sub = array();
$mass_sub2 = array();
$mass_sub[] = 'search_advanced_search';
$mass_sub2[] = 'search_title_advanced';

if ( $pvs_global_settings["allow_photo"] ) {
	$mass_sub[] = 'search_photo_filters';
	$mass_sub2[] = 'search_title_photo';
}

if ( $pvs_global_settings["allow_video"] and ! $pvs_global_settings["printsonly"] ) {
	$mass_sub[] = 'search_video_filters';
	$mass_sub2[] = 'search_title_video';
}

if ( $pvs_global_settings["allow_audio"] and ! $pvs_global_settings["printsonly"] ) {
	$mass_sub[] = 'search_audio_filters';
	$mass_sub2[] = 'search_title_audio';
}

$mass_sub[] = 'search_categories';
$mass_sub2[] = 'search_title_categories';

$mass_sub[] = 'search_lightboxes';
$mass_sub2[] = 'search_title_lightboxes';

for ( $i = 0; $i < count( $mass_sub ); $i++ ) {
	if ( isset( $_COOKIE["z_" . $mass_sub[$i]] ) and ( int )$_COOKIE["z_" . $mass_sub[$i]] ==
		1 ) {
?>
	document.getElementById('<?php echo $mass_sub[$i] ?>').style.display='block';
	 			document.getElementById('<?php echo $mass_sub2[$i] ?>').className='search_title4';
	<?php
	}
}
?>
	 	}
	 	show_sub_default()
	 	</script>
	

	<div class="search_line"></div>
	<div class="search_text"><input type="submit" value="<?php echo pvs_word_lang( "search" )?>" class="isubmit"></div>
	</div>
	<div class="search_left_bottom"></div>
	</form>