<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
?>

<script>
	fields_photo = new Array("license","artists","graphical_styles","license_models","orientation","file_types","age","ethnicity","people_number","compositions");
	fields_video = new Array("license","resolution","age");

	function change_stock_type(value) {
		if(value == '' || value == 'photo') {		
			deactivate_fields('video');
			activate_fields('photo');
		}
		
		if(value == 'videos') {
			deactivate_fields('photo');
			activate_fields('video');
		}
	}
	
	function activate_fields(value) {
		if(value == 'photo') {
			fields_stock = fields_photo;
		}
		if(value == 'video') {
			fields_stock = fields_video;
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
		
		for(i=0;i<fields_stock.length;i++) {
			$('.field_' + fields_stock[i]).css('display','none');
		}
	}
</script>

<?php
if ( @$_REQUEST["search"] == '' ) {
	$_REQUEST["search"] = $pvs_global_settings["istockphoto_query"];
}
?>

<form id='listing_form' method="get" action="<?php echo site_url()?>/" style="margin:0px">

<div class="search_left_top"></div>
<div class="search_left_body">
	<div class="search_title"><?php echo pvs_word_lang( "search" )?></div>

	<div class="search_text">
		
		<?php
if ( ( int )@$_REQUEST["print_id"] > 0 and $pvs_global_settings["istockphoto_prints"] ) {
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
		
		<div class="search_title2 field_license"><b><?php echo pvs_word_lang( "license" )?>:</b></div>
		<div class="search_text2 field_license">
			<select name="license" style="width:175px" class='ibox form-control'>
			<?php
$list_license = array(
	"",
	"creative",
	"editorial" );
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
		
		<?php
if ( $pvs_global_settings["istockphoto_contributor"] == "" ) {
?>
		<div class="search_title2 field_artists"><b><?php echo pvs_word_lang( "Artist" )?>:</b></div>
		<div class="search_text2 field_artists">
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
$list_stocktypes = array( "photo", "videos" );
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
		
		<div class="search_title2 field_graphical_styles"><b><?php echo pvs_word_lang( "Graphical styles" )?>:</b></div>
		<div class="search_text2 field_graphical_styles">
			<select name="graphical_styles" style="width:175px" class='ibox form-control'>
			<?php
$list_graphical_styles = array(
	"",
	"fine_art",
	"illustration",
	"photography" );
foreach ( $list_graphical_styles as $key => $value ) {
	$sel = "";
	if ( $value == @$_REQUEST["graphical_styles"] ) {
		$sel = "selected";
	}
?>
	<option value='<?php echo $value
?>'  <?php echo $sel
?>><?php echo pvs_word_lang( str_replace( "_", " ", $value ) )?></option>
	<?php
}
?>
			</select>
		</div>
		
		<div class="search_title2 field_license_models"><b><?php echo pvs_word_lang( "License models" )?>:</b></div>
		<div class="search_text2 field_license_models">
			<select name="license_models" style="width:175px" class='ibox form-control'>
			<?php
$list_license_models[""] = '';
$list_license_models["rightsmanaged"] = pvs_word_lang( "rights managed" );
$list_license_models["royaltyfree"] = pvs_word_lang( "royalty free" );
;
foreach ( $list_license_models as $key => $value ) {
	$sel = "";
	if ( $key == @$_REQUEST["license_models"] ) {
		$sel = "selected";
	}
?>
	<option value='<?php echo $key
?>'  <?php echo $sel
?>><?php echo $value
?></option>
	<?php
}
?>
			</select>
		</div>
		
		<div class="search_title2"><b><?php echo pvs_word_lang( "collection" )?>:</b></div>
		<div class="search_text2">
			<input type='text' name='category' style="width:175px" class='ibox form-control' value='<?php
if ( isset( $_REQUEST["category"] ) and $_REQUEST["category"] != -1 ) {
	echo ( pvs_result( $_REQUEST["category"] ) );
}
?>'>
		</div>	
		

		
		
		<div class="search_title2 field_orientation"><b><?php echo pvs_word_lang( "orientation" )?>:</b></div>
		<div class="search_text2 field_orientation">
			<select name="orientation" style="width:175px" class='ibox form-control'>
			<?php
$list_orientation = array(
	"",
	"Horizontal",
	"Vertical",
	"Square",
	"PanoramicHorizontal",
	"PanoramicVertical" );
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
		
		
		<div class="search_title2 field_file_types"><b><?php echo pvs_word_lang( "file types" )?>:</b></div>
		<div class="search_text2 field_file_types">
			<select name="file_types" style="width:175px" class='ibox form-control'>
			<?php
$list_file_types = array(
	"",
	"eps",
	"gif",
	"jpg",
	"png" );
foreach ( $list_file_types as $key => $value ) {
	$sel = "";
	if ( $value == @$_REQUEST["file_types"] ) {
		$sel = "selected";
	}
?>
	<option value='<?php echo $value
?>'  <?php echo $sel
?>><?php echo $value
?></option>
	<?php
}
?>
			</select>
		</div>
		


		
		<div class="search_title2 field_resolution"><b><?php echo pvs_word_lang( "Resolution" )?>:</b></div>
		<div class="search_text2 field_resolution">
			<select name="resolution" style="width:175px" class='ibox form-control'>
			<?php
$list_resolution[""] = "";
$list_resolution["sd"] = "SD";
$list_resolution["hd"] = "HD";
$list_resolution["4k"] = "4K";

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
		
		

		


		
		<div class="search_title2 field_age"><b><?php echo pvs_word_lang( "Age" )?>:</b></div>
		<div class="search_text2 field_age">
			<select name="age" style="width:175px" class='ibox form-control'>
			<?php
$list_age = array(
	"",
	"newborn",
	"baby",
	"child",
	"teenager",
	"young_adult",
	"adult",
	"adults_only",
	"mature_adult",
	"senior_adult",
	"0-1_months",
	"2-5_months",
	"6-11_months",
	"12-17_months",
	"18-23_months",
	"2-3_years",
	"4-5_years",
	"6-7_years",
	"8-9_years",
	"10-11_years",
	"12-13_years",
	"14-15_years",
	"16-17_years",
	"18-19_years",
	"20-24_years",
	"20-29_years",
	"25-29_years",
	"30-34_years",
	"30-39_years",
	"35-39_years",
	"40-44_years",
	"40-49_years",
	"45-49_years",
	"50-54_years",
	"50-59_years",
	"55-59_years",
	"60-64_years",
	"60-69_years",
	"65-69_years",
	"70-79_years",
	"80-89_years",
	"90_plus_years",
	"100_over" );
foreach ( $list_age as $key => $value ) {
	$sel = "";
	if ( $value == @$_REQUEST["age"] ) {
		$sel = "selected";
	}
?>
	<option value='<?php echo $value
?>'  <?php echo $sel
?>><?php echo pvs_word_lang( str_replace( "_", " ", $value ) )?></option>
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
	"black",
	"caucasian",
	"east_asian",
	"hispanic_latino",
	"japanese",
	"middle_eastern",
	"mixed_race_person",
	"multiethnic_group",
	"native_american_first_nations",
	"pacific_islander",
	"south_asian",
	"southeast_asian" );
foreach ( $list_ethnicity as $key => $value ) {
	$sel = "";
	if ( $value == @$_REQUEST["ethnicity"] ) {
		$sel = "selected";
	}
?>
	<option value='<?php echo $value
?>'  <?php echo $sel
?>><?php echo pvs_word_lang( str_replace( "_", " ", $value ) )?></option>
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
	"none",
	"one",
	"two",
	"group" );
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
		
		<div class="search_title2 field_compositions"><b><?php echo pvs_word_lang( "Compositions" )?>:</b></div>
		<div class="search_text2 field_compositions">
			<select name="compositions" style="width:175px" class='ibox form-control'>
			<?php
$list_compositions = array(
	"",
	"abstract",
	"candid",
	"close_up",
	"copy_space",
	"cut_out",
	"full_frame",
	"full_length",
	"headshot",
	"looking_at_camera",
	"macro",
	"portrait",
	"sparse",
	"still_life",
	"three_quarter_length",
	"waist_up" );
foreach ( $list_compositions as $key => $value ) {
	$sel = "";
	if ( $value == @$_REQUEST["compositions"] ) {
		$sel = "selected";
	}
?>
	<option value='<?php echo $value
?>'  <?php echo $sel
?>><?php echo pvs_word_lang( str_replace( "_", " ", $value ) )?></option>
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