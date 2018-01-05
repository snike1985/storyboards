<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
?>

<script>
	fields_photo = new Array("license","languages","orientation","model","language","color");
	fields_video = new Array("aspect_ratio","duration_video","language","resolution","model");

	function change_stock_type(value) {
		if(value == '' || value == 'photo' || value == 'illustration') {		
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
if ( ( int )@$_REQUEST["print_id"] > 0 and $pvs_global_settings["fotolia_prints"] ) {
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
if ( $pvs_global_settings["fotolia_contributor"] == "" ) {
?>
		<div class="search_title2"><b><?php echo pvs_word_lang( "Contributor" )?> ID:</b></div>
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
		
		<div class="search_title2"><b><?php echo pvs_word_lang( "categories" )?>:</b></div>
		<div class="search_text2">
			<select name="category" style="width:175px" class='ibox form-control'>
	<option value='-1'></option>
	<?php
$sql = "select id,title from " . PVS_DB_PREFIX .
	"category_stock where stock='fotolia' order by title";
$rs->open( $sql );
while ( ! $rs->eof ) {
	$sel = "";
	if ( ( isset( $_REQUEST["category"] ) and $_REQUEST["category"] == $rs->row["id"] ) or
		( ! isset( $_REQUEST["category"] ) and $rs->row["id"] == $pvs_global_settings["fotolia_category"] ) ) {
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
		
		<div class="search_title2 field_license"><b><?php echo pvs_word_lang( "size" )?>:</b></div>
		<div class="search_text2 field_license">
			<select name="license" style="width:175px" class='ibox form-control'>
			<?php
$list_license = array(
	"",
	"L",
	"XL",
	"XXL",
	"XXL>25MP" );
foreach ( $list_license as $key => $value ) {
	$sel = "";
	if ( $value == @$_REQUEST["license"] ) {
		$sel = "selected";
	}
?>
	<option value='<?php echo $value
?>' <?php echo $sel
?>><?php echo $value
?></option>
	<?php
}
?>
			</select>
		</div>	
		

		
		<div class="search_title2 field_license"><b><?php echo pvs_word_lang( "languages" )?>:</b></div>
		<div class="search_text2 field_license">
			<select name="language" style="width:175px" class='ibox form-control'>
			<?php
$lang_fotolia[2] = "American";
$lang_fotolia[1] = "French";
$lang_fotolia[3] = "English";
$lang_fotolia[4] = "German";
$lang_fotolia[5] = "Spanish";
$lang_fotolia[6] = "Italian";
$lang_fotolia[7] = "Portuguese";
$lang_fotolia[8] = "Brazilian";
$lang_fotolia[9] = "Japanese";
$lang_fotolia[11] = "Polish";
$lang_fotolia[12] = "Russian";
$lang_fotolia[13] = "Chinese";
$lang_fotolia[14] = "Turkish";
$lang_fotolia[15] = "Korean";
$lang_fotolia[22] = "Dutch";
$lang_fotolia[23] = "Swedish";

foreach ( $lang_fotolia as $key => $value ) {
	$sel = "";
	if ( $key == @$_REQUEST["language"] ) {
		$sel = "selected";
	}
?>
	<option value='<?php echo $key
?>' <?php echo $sel
?>><?php echo $value
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
		
		
		<div class="search_title2 field_aspect_ratio"><b><?php echo pvs_word_lang( "duration" )?>:</b></div>
		<div class="search_text2 field_aspect_ratio">
			<select name="duration" style="width:175px" class='ibox form-control'>
			<?php
$list_duration["all"] = "";
$list_duration[""] = "0 - 10 sec.";
$list_duration["10"] = "10 - 20 sec.";
$list_duration["20"] = "20 - 30 sec.";
$list_duration["30"] = " > 30 sec.";

foreach ( $list_duration as $key => $value ) {
	$sel = "";
	if ( $key == @$_REQUEST["duration"] ) {
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
		
		<div class="search_title2 field_resolution"><b><?php echo pvs_word_lang( "resolution" )?>:</b></div>
		<div class="search_text2 field_resolution">
			<select name="resolution" style="width:175px" class='ibox form-control'>
			<?php
$list_resolution[""] = "";
$list_resolution["HD1080"] = "HD1080";
$list_resolution["HD720"] = "HD720";

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