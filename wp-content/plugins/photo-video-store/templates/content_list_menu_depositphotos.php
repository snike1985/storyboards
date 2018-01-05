<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
?>


<form id='listing_form' method="get" action="<?php echo site_url()?>/" style="margin:0px">

<div class="search_left_top"></div>
<div class="search_left_body">
	<div class="search_title"><?php echo pvs_word_lang( "search" )?></div>

	<div class="search_text">
	
		<?php
if ( ( int )@$_REQUEST["print_id"] > 0 and $pvs_global_settings["depositphotos_prints"] ) {
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
if ( $pvs_global_settings["depositphotos_contributor"] == "" ) {
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
			<select name="stock_type" style="width:175px" class='ibox form-control'>
			<?php
$list_stocktypes = array(
	"",
	"photo",
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
	"category_stock where stock='depositphotos' order by title";
$rs->open( $sql );
while ( ! $rs->eof ) {
	$sel = "";
	if ( ( isset( $_REQUEST["category"] ) and $_REQUEST["category"] == $rs->row["id"] ) or
		( ! isset( $_REQUEST["category"] ) and $rs->row["id"] == $pvs_global_settings["depositphotos_category"] ) ) {
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
	"",
	"commercial",
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
		

		
		<div class="search_title2 field_license"><b><?php echo pvs_word_lang( "languages" )?>:</b></div>
		<div class="search_text2 field_license">
			<select name="language" style="width:175px" class='ibox form-control'>
			<?php
$list_language["en"] = "English";
$list_language["de"] = "Deutsch";
$list_language["fr"] = "Français";
$list_language["es"] = "Español";
$list_language["ru"] = "Русский";
$list_language["it"] = "Italiano";
$list_language["pt"] = "Português";
$list_language["pl"] = "Polski";
$list_language["nl"] = "Nederlands";
$list_language["jp"] = "日本語";
$list_language["cz"] = "Česky";
$list_language["se"] = "Svenska";
$list_language["cn"] = "中文";
$list_language["tr"] = "Türkçe";
$list_language["mx"] = "Español (Mexico)";
$list_language["gr"] = "Ελληνικά";
$list_language["ko"] = "한국어";
$list_language["br"] = "Português (Brasil)";
$list_language["hu"] = "Magyar";
$list_language["ua"] = "Українська";

foreach ( $list_language as $key => $value ) {
	$sel = "";
	if ( $key == "en" and ! isset( $_REQUEST["language"] ) ) {
		$sel = "selected";
	}

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
	"vertical",
	"Square" );
foreach ( $list_orientation as $key => $value ) {
	$sel = "";
	if ( $value == @$_REQUEST["orientation"] ) {
		$sel = "selected";
	}
?>
	<option value='<?php echo strtolower( $value )?>'  <?php echo $sel
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
		

		
		
		<div class="search_title2 field_age"><b><?php echo pvs_word_lang( "Age" )?>:</b></div>
		<div class="search_text2 field_age">
			<select name="age" style="width:175px" class='ibox form-control'>
			<?php
$list_age = array(
	'',
	'infant',
	'child',
	'teenager',
	'20',
	'30',
	'40',
	'50',
	'60',
	'70' );
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
	'',
	'asian',
	'brazilian',
	'black',
	'caucasian',
	'hispanic',
	'middle',
	'multi',
	'native',
	'other' );
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
	"3" );
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

