<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
?>

<script>
	fields_photo = new Array("license","languages","orientation","age","model","gender","ethnicity","people_number","language","color");
	fields_video = new Array("license","aspect_ratio","duration_video","language","resolution","age","model","gender","ethnicity","people_number");
	fields_audio = new Array("album_title","artists","bmp","duration_audio","genre","instrumental","instruments","lyrics","moods","vocal_description");

	function change_stock_type(value) {
		if(value == '' || value == 'photo' || value == 'illustration') {		
			deactivate_fields('video');
			deactivate_fields('audio');
			activate_fields('photo');
		}
		
		if(value == 'videos') {
			deactivate_fields('photo');
			deactivate_fields('audio');	
			activate_fields('video');
		}
		
		if(value == 'music') {
			deactivate_fields('photo');
			deactivate_fields('video');
			activate_fields('audio');		
		}
	}
	
	function activate_fields(value) {
		if(value == 'photo') {
			fields_stock = fields_photo;
		}
		if(value == 'video') {
			fields_stock = fields_video;
		}
		if(value == 'audio') {
			fields_stock = fields_audio;
		}
		
		for(i=0;i<fields_stock.length;i++) {
			$('.field_' + fields_stock[i]).css('display','block');
		}
	}
	
	function deactivate_fields(value) {
		if(value == 'photo') {
			fields_stock = fields_photo;
		}
		if(value == 'video') {
			fields_stock = fields_video;
		}
		if(value == 'audio') {
			fields_stock = fields_audio;
		}	
		
		for(i=0;i<fields_stock.length;i++) {
			$('.field_' + fields_stock[i]).css('display','none');
		}
	}
</script>

<form id='listing_form' method="get" action="<?php echo site_url()?>/" style="margin:0px">

<div class="search_left_top"></div>
<div class="search_left_body">
	<div class="search_title"><?php echo pvs_word_lang( "search" )?></div>
	<div class="search_text">
	<?php
if ( ( int )@$_REQUEST["print_id"] > 0 and $pvs_global_settings["shutterstock_prints"] ) {
?>
		<div class="search_title2"><b><?php echo pvs_word_lang( "prints and products" )?>:</b></div>
		<div class="search_text2">
		<select name="print_id" class='ibox form-control' style="width:175px" >
		<option value="0"></option>
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
	
		<div class="search_title2"><b><?php echo pvs_word_lang( "keywords" )?>:</b></div>
		<div class="search_text2">
			<input type='text' name='search' style="width:175px" class='ibox form-control' value='<?php echo pvs_result( @$_REQUEST["search"] )?>'>
		</div>
		
		<?php
if ( $pvs_global_settings["shutterstock_contributor"] == "" ) {
?>
		<div class="search_title2"><b><?php echo pvs_word_lang( "Contributor" )?>:</b></div>
		<div class="search_text2">
			<input type='text' name='author' style="width:175px" class='ibox form-control' value='<?php
	if ( isset( $_REQUEST["author"] ) ) {
		echo ( pvs_result( $_REQUEST["author"] ) );
	}
?>'>
		</div>
		<?php
}
?>
	
		<div class="search_title2"><b><?php echo pvs_word_lang( "type" )?>:</b></div>
		<div class="search_text2">
			<select name="stock_type" style="width:175px" class='ibox form-control' onChange='change_stock_type(this.value)'>
			<?php
$list_stocktypes = array(
	"",
	"photo",
	"illustration",
	"vector",
	"videos",
	"music" );
foreach ( $list_stocktypes as $key => $value ) {
	$sel = "";
	if ( $value == @$_REQUEST["stock_type"] ) {
		$sel = "selected";
	}
?>
	<option value='<?php echo $value
?>' <?php echo $sel
?>><?php echo pvs_word_lang( $value )?></option>
	<?php
}
?>
			</select>
		</div>	
		
		<div class="search_title2"><b><?php echo pvs_word_lang( "categories" )?>:</b></div>
		<div class="search_text2">
			<select name="category" style="width:175px" class='ibox form-control'>
	<option value='-1'></option>
	<?php
$sql = "select id,title from " . PVS_DB_PREFIX .
	"category_stock where stock='shutterstock' order by title";
$rs->open( $sql );
while ( ! $rs->eof ) {
	$sel = "";
	if ( ( isset( $_REQUEST["category"] ) and $_REQUEST["category"] == $rs->row["id"] ) or
		( ! isset( $_REQUEST["category"] ) and $rs->row["id"] == $pvs_global_settings["shutterstock_category"] ) ) {
		$sel = "selected";
	}
?>
		<option value="<?php echo $rs->row["id"] ?>" <?php echo $sel
?>><?php echo $rs->row["title"] ?></option>
		<?php
	$rs->movenext();
}
?>
			</select>
		</div>	
		
		<div class="search_title2 field_license"><b><?php echo pvs_word_lang( "license" )?>:</b></div>
		<div class="search_text2 field_license">
			<select name="license" style="width:175px" class='ibox form-control'>
			<?php
$list_license = array(
	"commercial",
	"editorial",
	"enhanced" );
foreach ( $list_license as $key => $value ) {
	$sel = "";
	if ( $value == @$_REQUEST["license"] ) {
		$sel = "selected";
	}
?>
	<option value='<?php echo $value
?>' <?php echo $sel
?>><?php echo pvs_word_lang( $value )?></option>
	<?php
}
?>
			</select>
		</div>	
		

		
		<div class="search_title2 field_language"><b><?php echo pvs_word_lang( "languages" )?>:</b></div>
		<div class="search_text2 field_language">
			<select name="language" style="width:175px" class='ibox form-control'>
			<?php
$list_language = array(
	"cs",
	"da",
	"de",
	"en",
	"es",
	"fi",
	"fr",
	"hu",
	"it",
	"ja",
	"ko",
	"nb",
	"nl",
	"pl",
	"pt",
	"ru",
	"sv",
	"th",
	"tr",
	"zh" );
$lang_others["ko"] = "Korean";
$lang_others["nb"] = "NB";
$lang_others["zh"] = "Chinese";
foreach ( $list_language as $key => $value ) {
	$sel = "";
	if ( $value == "en" and ! isset( $_REQUEST["language"] ) ) {
		$sel = "selected";
	}

	if ( $value == @$_REQUEST["language"] ) {
		$sel = "selected";
	}
?>
	<option value='<?php echo $value
?>' <?php echo $sel
?>><?php
	if ( isset( $lang_symbol_inv[$value] ) ) {
		echo ( $lang_symbol_inv[$value] );
	} else {
		echo ( @$lang_others[$value] );
	}
?></option>
	<?php
}
?>
			</select>
		</div>	
		
		<div class="search_title2 field_orientation"><b><?php echo pvs_word_lang( "orientation" )?>:</b></div>
		<div class="search_text2 field_orientation">
			<select name="orientation" style="width:175px" class='ibox form-control'>
			<?php
$list_orientation = array(
	"",
	"horizontal",
	"vertical" );
foreach ( $list_orientation as $key => $value ) {
	$sel = "";
	if ( $value == @$_REQUEST["orientation"] ) {
		$sel = "selected";
	}
?>
	<option value='<?php echo $value
?>'  <?php echo $sel
?>><?php echo pvs_word_lang( $value )?></option>
	<?php
}
?>
			</select>
		</div>	
		
		<div class="search_title2 field_color"><b><?php echo pvs_word_lang( "color" )?>:</b></div>
		<div class="search_text2 field_color">
		<link rel='stylesheet' href='<?php echo pvs_plugins_url()?>/assets/js/colorpicker/css/colorpicker.css' type='text/css' />
		<script type='text/javascript' src='<?php echo pvs_plugins_url()?>/assets/js/colorpicker/js/colorpicker.js'></script>
		<script type='text/javascript' src='<?php echo pvs_plugins_url()?>/assets/js/colorpicker/js/eye.js'></script>
		<script type='text/javascript' src='<?php echo pvs_plugins_url()?>/assets/js/colorpicker/js/utils.js'></script>
		<?php
if ( ! isset( $_REQUEST["color"] ) ) {
	$_REQUEST["color"] = "FFFFFF";
}
?>
		<input type='hidden' id='color' name='color' value='<?php echo $_REQUEST["color"] ?>' />
		<div id="customWidget" style="margin-left:-4px">
		<div id="colorSelector2"><div style="background-color: #<?php echo $_REQUEST["color"] ?>"></div></div>
	                <div id="colorpickerHolder2">
	                </div>
	</div>
	
	<script>$('#colorSelector2').ColorPicker({
	color: '#<?php echo $_REQUEST["color"] ?>',
	onShow: function (colpkr) {
		$(colpkr).fadeIn(500);
		return false;
	},
	onHide: function (colpkr,hex) {
		$(colpkr).fadeOut(500);
		return false;		
	},
	onChange: function (hsb, hex, rgb) {
		$('#colorSelector2 div').css('backgroundColor', '#' + hex);
		$('#color').val(hex);
	}
});</script>
		</div>	
		
		<div class="search_title2 field_model"><b><?php echo pvs_word_lang( "model property release" )?>:</b></div>
			
		<div class="search_text2 field_model">
			<input type="checkbox" name="model" <?php
if ( @$_REQUEST["model"] == 1 ) {
	echo ( "checked" );
}
?> value="1">
		</div>	
		
		
		<div class="search_title2 field_aspect_ratio"><b><?php echo pvs_word_lang( "aspect ratio" )?>:</b></div>
		<div class="search_text2 field_aspect_ratio">
			<select name="aspect_ratio" style="width:175px" class='ibox form-control'>
			<?php
$list_aspect_ratio[""] = "";
$list_aspect_ratio["4_3"] = "4:3";
$list_aspect_ratio["16_9"] = "16:9";
$list_aspect_ratio["nonstandard"] = pvs_word_lang( "other" );

foreach ( $list_aspect_ratio as $key => $value ) {
	$sel = "";
	if ( $key == @$_REQUEST["aspect_ratio"] ) {
		$sel = "selected";
	}
?>
	<option value='<?php echo $key
?>'  <?php echo $sel
?>><?php echo pvs_word_lang( $value )?></option>
	<?php
}
?>
			</select>
		</div>
		
		<div class="search_title2 field_resolution"><b><?php echo pvs_word_lang( "resolution" )?>:</b></div>
		<div class="search_text2 field_resolution">
			<select name="resolution" style="width:175px" class='ibox form-control'>
			<?php
$list_resolution[""] = "";
$list_resolution["4k"] = "4k";
$list_resolution["standard_definition"] = "SD";
$list_resolution["high_definition"] = "HD";

foreach ( $list_resolution as $key => $value ) {
	$sel = "";
	if ( $key == @$_REQUEST["resolution"] ) {
		$sel = "selected";
	}
?>
	<option value='<?php echo $key
?>'  <?php echo $sel
?>><?php echo pvs_word_lang( $value )?></option>
	<?php
}
?>
			</select>
		</div>
		
		
		<div class="search_title2 field_duration_video"><b><?php echo pvs_word_lang( "duration" )?>:</b></div>
		<div class="search_text2 field_duration_video">
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
	<input type="hidden" id="duration_video" name="duration_video" value="<?php echo $duration_video1
?> - <?php echo $duration_video2
?>">
	<div id="slider-range"></div>
	<div class="box_slider2">0m</div>
	<div class="box_slider3">120m</div>
			</div>
		</div>
			
			
			
		<div class="search_title2 field_album_title"><b><?php echo pvs_word_lang( "Album title" )?>:</b></div>
		<div class="search_text2 field_album_title">
			<input type='text' name='album_title' style="width:175px" class='ibox form-control' value='<?php echo pvs_result( @$_REQUEST["album_title"] )?>'>
		</div>
		
		<div class="search_title2 field_artists"><b><?php echo pvs_word_lang( "Artists" )?>:</b></div>
		<div class="search_text2 field_artists">
			<input type='text' name='artists' style="width:175px" class='ibox form-control' value='<?php echo pvs_result( @$_REQUEST["artists"] )?>'>
		</div>
		
		<div class="search_title2 field_genre"><b><?php echo pvs_word_lang( "Genre" )?>:</b></div>
		<div class="search_text2 field_genre">
			<select name="genre" style="width:175px" class='ibox form-control'>
			<?php
$list_genre = array(
	"",
	"Blues",
	"Children",
	"Classical",
	"Country",
	"Dance/Electronic",
	"Hip-Hop/Rap",
	"Holiday",
	"Jazz",
	"New Age",
	"Pop/Rock",
	"R&B/Soul",
	"Reggae/Ska",
	"Spiritual",
	"World/International" );
foreach ( $list_genre as $key => $value ) {
	$sel = "";
	if ( $value == @$_REQUEST["genre"] ) {
		$sel = "selected";
	}
?>
	<option value='<?php echo $value
?>'  <?php echo $sel
?>><?php echo pvs_word_lang( $value )?></option>
	<?php
}
?>
			</select>
		</div>
		
		<div class="search_title2 field_duration_audio"><b><?php echo pvs_word_lang( "duration" )?>:</b></div>
		<div class="search_text2 field_duration_audio">
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
	<input type="hidden" id="duration_audio" name="duration_audio" value="<?php echo $duration_audio1
?> - <?php echo $duration_audio2
?>">
	<div id="slider-range2"></div>
	<div class="box_slider2">0m</div>
	<div class="box_slider3">120m</div>
			</div>
		</div>
		
		
		<div class="search_title2 field_bmp"><b><?php echo pvs_word_lang( "Beats per minute" )?>:</b></div>
		<div class="search_text2 field_bmp">
			<?php
$bmp1 = 0;
$bmp2 = 120;
if ( isset( $_REQUEST["bmp"] ) ) {
	$bmp_mass = explode( " - ", pvs_result( $_REQUEST["bmp"] ) );
	if ( isset( $bmp_mass[0] ) and isset( $bmp_mass[1] ) ) {
		$bmp1 = ( int )$bmp_mass[0];
		$bmp2 = ( int )$bmp_mass[1];
	}
}
?>
			<script>
			$(function() {
			$( "#slider-range3" ).slider({
			range: true,
			min: 0,
			max: 240,
			values: [<?php echo $bmp1
?>,<?php echo $bmp2
?>],
			slide: function( event, ui ) {
			$( "#bmp" ).val(ui.values[ 0 ] + " - " + ui.values[ 1 ] );
			}
			});
			$( "#bmp" ).val($( "#slider-range2" ).slider( "values", 0 ) +
			" - " + $( "#slider-range2" ).slider( "values", 1 ) );
			});
			</script>
			<div class="box_slider">
	<input type="hidden" id="bmp" name="bmp" value="<?php echo $bmp1
?> - <?php echo $bmp2
?>">
	<div id="slider-range3"></div>
	<div class="box_slider2">0 BMP</div>
	<div class="box_slider3">240 BMP</div>
			</div>
		</div>
		
		<div class="search_title2 field_instrumental"><b><?php echo pvs_word_lang( "Instrumental" )?>:</b></div>
			
		<div class="search_text2 field_instrumental">
			<input type="checkbox" name="instrumental" <?php
if ( @$_REQUEST["instrumental"] == 1 ) {
	echo ( "checked" );
}
?> value="1">
		</div>	
		
		<div class="search_title2 field_instruments"><b><?php echo pvs_word_lang( "Instruments" )?>:</b></div>
		<div class="search_text2 field_instruments">
			<input type='text' name='instruments' style="width:175px" class='ibox form-control' value='<?php echo pvs_result( @$_REQUEST["instruments"] )?>'>
		</div>
		
		<div class="search_title2 field_lyrics"><b><?php echo pvs_word_lang( "Lyrics" )?>:</b></div>
		<div class="search_text2 field_lyrics">
			<input type='text' name='lyrics' style="width:175px" class='ibox form-control' value='<?php echo pvs_result( @$_REQUEST["lyrics"] )?>'>
		</div>
		
		<div class="search_title2 field_moods"><b><?php echo pvs_word_lang( "Moods" )?>:</b></div>
		<div class="search_text2 field_moods">
			<input type='text' name='moods' style="width:175px" class='ibox form-control' value='<?php echo pvs_result( @$_REQUEST["moods"] )?>'>
		</div>
		
		<div class="search_title2 field_vocal_description"><b><?php echo pvs_word_lang( "Vocal description" )?>:</b></div>
		<div class="search_text2 field_vocal_description">
			<input type='text' name='vocal_description' style="width:175px" class='ibox form-control' value='<?php echo pvs_result( @$_REQUEST["vocal_description"] )?>'>
		</div>
		
		
		<div class="search_title2 field_age"><b><?php echo pvs_word_lang( "Age" )?>:</b></div>
		<div class="search_text2 field_age">
			<select name="age" style="width:175px" class='ibox form-control'>
			<?php
$list_age = array(
	"",
	"infants",
	"children",
	"teenagers",
	"20s",
	"30s",
	"40s",
	"50s",
	"60s",
	"older" );
foreach ( $list_age as $key => $value ) {
	$sel = "";
	if ( $value == @$_REQUEST["age"] ) {
		$sel = "selected";
	}
?>
	<option value='<?php echo $value
?>'  <?php echo $sel
?>><?php echo pvs_word_lang( $value )?></option>
	<?php
}
?>
			</select>
		</div>
		
		<div class="search_title2 field_gender"><b><?php echo pvs_word_lang( "Gender" )?>:</b></div>
		<div class="search_text2 field_gender">
			<select name="gender" style="width:175px" class='ibox form-control'>
			<?php
$list_gender = array(
	"",
	"male",
	"female",
	"both" );
foreach ( $list_gender as $key => $value ) {
	$sel = "";
	if ( $value == @$_REQUEST["gender"] ) {
		$sel = "selected";
	}
?>
	<option value='<?php echo $value
?>'  <?php echo $sel
?>><?php echo pvs_word_lang( $value )?></option>
	<?php
}
?>
			</select>
		</div>
		
		<div class="search_title2 field_ethnicity"><b><?php echo pvs_word_lang( "Ethnicity" )?>:</b></div>
		<div class="search_text2 field_ethnicity">
			<select name="ethnicity" style="width:175px" class='ibox form-control'>
			<?php
$list_ethnicity = array(
	"",
	"african",
	"african_american",
	"black",
	"brazilian",
	"chinese",
	"caucasian",
	"east_asian",
	"hispanic",
	"japanese",
	"middle_eastern",
	"native_american",
	"pacific_islander",
	"south_asian",
	"southeast_asian",
	"other" );
foreach ( $list_ethnicity as $key => $value ) {
	$sel = "";
	if ( $value == @$_REQUEST["ethnicity"] ) {
		$sel = "selected";
	}
?>
	<option value='<?php echo $value
?>'  <?php echo $sel
?>><?php echo pvs_word_lang( $value )?></option>
	<?php
}
?>
			</select>
		</div>
		
		<div class="search_title2 field_people_number"><b><?php echo pvs_word_lang( "People number" )?>:</b></div>
		<div class="search_text2 field_people_number">
			<select name="people_number" style="width:175px" class='ibox form-control'>
			<?php
$list_peoplenumber = array(
	"",
	"0",
	"1",
	"2",
	"3",
	"4" );
foreach ( $list_peoplenumber as $key => $value ) {
	$sel = "";
	if ( $value == @$_REQUEST["people_number"] ) {
		$sel = "selected";
	}
?>
	<option value='<?php echo $value
?>'  <?php echo $sel
?>><?php echo pvs_word_lang( $value )?></option>
	<?php
}
?>
			</select>
		</div>
		

	</div>
	
	<div class="search_text"><input type="submit" value="<?php echo pvs_word_lang( "search" )?>" class="isubmit"></div>
</div>
<div class="search_left_bottom"></div>
</form>

<?php
if ( @$_REQUEST["stock_type"] != "" ) {
?><script>change_stock_type('<?php echo pvs_result( @$_REQUEST["stock_type"] )?>')</script><?php
} else
{
?><script>change_stock_type('photo')</script><?php
}
?>