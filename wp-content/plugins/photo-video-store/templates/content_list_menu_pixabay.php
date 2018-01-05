<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
?>

<script>
	fields_photo = new Array("image_type","orientation");
	fields_video = new Array("video_type");

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

<form id='listing_form' method="get" action="<?php echo site_url()?>/" style="margin:0px">

<div class="search_left_top"></div>
<div class="search_left_body">
	<div class="search_title"><?php echo pvs_word_lang( "search" )?></div>
	<div class="search_text">
	<?php
if ( ( int )@$_REQUEST["print_id"] > 0 and $pvs_global_settings["pixabay_prints"] ) {
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
		
		
		<div class="search_title2"><b><?php echo pvs_word_lang( "categories" )?>:</b></div>
		<div class="search_text2">
			<select name="category" style="width:175px" class='ibox form-control'>
	<option value=''></option>
	<?php
$pixabay_categories = array(
	'fashion',
	'nature',
	'backgrounds',
	'science',
	'education',
	'people',
	'feelings',
	'religion',
	'health',
	'places',
	'animals',
	'industry',
	'food',
	'computer',
	'sports',
	'transportation',
	'travel',
	'buildings',
	'business',
	'music' );
foreach ( $pixabay_categories as $key => $value ) {
	$sel = "";
	if ( ( isset( $_REQUEST["category"] ) and $_REQUEST["category"] == $value ) or ( !
		isset( $_REQUEST["category"] ) and $value == $pvs_global_settings["pixabay_category"] ) ) {
		$sel = "selected";
	}
?>
		<option value='<?php echo $value
?>'  <?php echo $sel
?>><?php echo ucfirst( $value )?></option>
		<?php
}
?>
			</select>
		</div>	
		
		
	
		<div class="search_title2"><b><?php echo pvs_word_lang( "type" )?>:</b></div>
		<div class="search_text2">
			<select name="stock_type" style="width:175px" class='ibox form-control' onChange='change_stock_type(this.value)'>
			<?php
$list_stocktypes = array(
	"",
	"photo",
	"videos" );
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
		
		<div class="search_title2 field_image_type"><b><?php echo pvs_word_lang( "photo" )?> <?php echo pvs_word_lang( "type" )?>:</b></div>
		<div class="search_text2 field_image_type">
			<select name="image_type" style="width:175px" class='ibox form-control'>
			<?php
$list_stocktypes = array(
	"all",
	"photo",
	"illustration",
	"vector" );
foreach ( $list_stocktypes as $key => $value ) {
	$sel = "";
	if ( $value == @$_REQUEST["image_type"] ) {
		$sel = "selected";
	}
?>
	<option value='<?php echo $value
?>' <?php echo $sel
?>><?php echo ucfirst( pvs_word_lang( $value ) )?></option>
	<?php
}
?>
			</select>
		</div>	
		
		<div class="search_title2 field_video_type"><b><?php echo pvs_word_lang( "video" )?> <?php echo pvs_word_lang( "type" )?>:</b></div>
		<div class="search_text2 field_video_type">
			<select name="video_type" style="width:175px" class='ibox form-control'>
			<?php
$list_stocktypes = array(
	"all",
	"film",
	"animation" );
foreach ( $list_stocktypes as $key => $value ) {
	$sel = "";
	if ( $value == @$_REQUEST["video_type"] ) {
		$sel = "selected";
	}
?>
	<option value='<?php echo $value
?>' <?php echo $sel
?>><?php echo ucfirst( pvs_word_lang( $value ) )?></option>
	<?php
}
?>
			</select>
		</div>	

		

		
		<div class="search_title2 field_lang"><b><?php echo pvs_word_lang( "languages" )?>:</b></div>
		<div class="search_text2 field_lang">
			<select name="lang" style="width:175px" class='ibox form-control'>
			<?php
$list_language = array(
	"cs",
	"da",
	"de",
	"en",
	"es",
	"fr",
	"id",
	"it",
	"hu",
	"nl",
	"no",
	"pl",
	"pt",
	"ro",
	"sk",
	"fi",
	"sv",
	"tr",
	"vi",
	"th",
	"bg",
	"ru",
	"el",
	"ja",
	"ko",
	"zh" );
$lang_others["ko"] = "Korean";
$lang_others["nb"] = "NB";
$lang_others["zh"] = "Chinese";
$lang_others["vi"] = "Vietnamese";
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