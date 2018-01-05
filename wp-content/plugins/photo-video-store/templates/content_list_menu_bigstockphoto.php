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
if ( ( int )@$_REQUEST["print_id"] > 0 and $pvs_global_settings["bigstockphoto_prints"] ) {
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
if ( $pvs_global_settings["bigstockphoto_contributor"] == "" ) {
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
	"illustration",
	"vector" );
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
	"category_stock where stock='bigstockphoto' order by title";
$rs->open( $sql );
while ( ! $rs->eof ) {
	$sel = "";
	if ( ( isset( $_REQUEST["category"] ) and $_REQUEST["category"] == $rs->row["title"] ) or
		( ! isset( $_REQUEST["category"] ) and $rs->row["title"] == $pvs_global_settings["bigstockphoto_category"] ) ) {
		$sel = "selected";
	}
?>
		<option value="<?php echo $rs->row["title"] ?>" <?php echo $sel
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
$list_language["es"] = "Spanish";
$list_language["de"] = "German";
$list_language["pt"] = "Portuguese";
$list_language["it"] = "Italian";
$list_language["nl"] = "Dutch";
$list_language["fr"] = "French";
$list_language["ja"] = "Japanese";
$list_language["zh"] = "Chinese";
$list_language["ru"] = "Russian";
$list_language["cs"] = "Czech";
$list_language["da"] = "Danish";
$list_language["fi"] = "Finnish";
$list_language["hu"] = "Hungarian";
$list_language["ko"] = "Korean";
$list_language["nb"] = "Norwegian";
$list_language["pl"] = "Polish";
$list_language["sv"] = "Swedish";
$list_language["th"] = "Thai";
$list_language["tr"] = "Turkish";

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
$list_orientation[""] = "";
$list_orientation["h"] = "horizontal";
$list_orientation["v"] = "vertical";
foreach ( $list_orientation as $key => $value ) {
	$sel = "";
	if ( $key == @$_REQUEST["orientation"] ) {
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

