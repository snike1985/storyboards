<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

if ( ! isset( $_GET["id"] ) ) {
	$site = "upload_audio";
} else
{
	$site = "publications";
}

if ( $pvs_global_settings["userupload"] == 0 ) {
	header( "location:" . site_url() . "/profile/" );
	exit();
}


include ( "profile_top.php" );
?>

<script>
$(document).ready(function() {
	change_group('upload');
});
</script>

<h1>
<?php
if ( ! isset( $_GET["id"] ) ) {
	echo ( pvs_word_lang( "upload audio" ) );
} else
{
	echo ( pvs_word_lang( "edit" ) . " &mdash; " . pvs_word_lang( "audio" ) . " #" .
		$_GET["id"] );
}
?>
</h1>

<br>
<div class="nav-tabs-custom tabs-style-2">
	<ul class="nav nav-tabs" style="margin-left:0px">
	  <li class="menu_settings menu_settings_upload"><a href="javascript:change_group('upload')" class="nav-link active"><?php echo pvs_word_lang( "audio" )?></a></li>
	  <li class="menu_settings menu_settings_categories"><a href="javascript:change_group('categories')" class="nav-link"><?php echo pvs_word_lang( "categories" )?></a></li>
	  <li class="menu_settings menu_settings_other"><a href="javascript:change_group('other')" class="nav-link"><?php echo pvs_word_lang( "settings" )?></a></li>
	  <?php
		if ( $pvs_global_settings["google_coordinates"] ) {
		?>
				<li class="menu_settings menu_settings_google" class="nav-link"><a href="javascript:change_group('google')"><?php echo pvs_word_lang( "Google map" )?></a></li>
			  <?php
		}
		?>
	</ul>
</div>
<div style="padding:20px" class="tab-content">

<?php
$fields_show = array();
$fields_required = "";
$fields_required2 = "";
$sql = "select * from " . PVS_DB_PREFIX . "audio_fields order by priority";
$rs->open( $sql );
while ( ! $rs->eof ) {
	if ( $rs->row["activ"] == 1 or $rs->row["always"] == 1 ) {
		$fields_show[$rs->row["name"]] = 1;
		if ( $rs->row["required"] == 1 and $rs->row["fname"] != "terms" and $rs->row["fname"] !=
			"sale" and $rs->row["fname"] != "previewvideo" and $rs->row["fname"] !=
			"previewpicture" and $rs->row["fname"] != "duration" and $rs->row["fname"] != "category" ) {
			if ( $fields_required != "" )
			{
				$fields_required .= ",";
			}
			$fields_required .= "'" . $rs->row["fname"] . "'";

			if ( $fields_required2 != "" )
			{
				$fields_required2 .= ",";
			}
			$fields_required2 .= "0";
		}
	}
	$rs->movenext();
}
?>

<script>
	form_fields=new Array(<?php echo $fields_required
?>);
	fields_emails=new Array(<?php echo $fields_required2
?>);
	error_message="<?php echo pvs_word_lang( "Incorrect field" )?>";
	
	function my_form_validate2()
	{
		change_group('other');
		return my_form_validate()
	}
</script>
<script src="<?php echo pvs_plugins_url()?>/assets/js/jquery.qtip-1.0.0-rc3.min.js"></script>


<?php
$title = "";
$description = "";
$keywords = "";
$foldername = "";
$folderid = "";
$folderid2 = 0;
$folderid3 = 0;
$duration = 0;
$format = "";
$source = "";
$holder = "";
$model = 0;
$free = 0;
$pnew = false;
$google_x = 0;
$google_y = 0;
$adult = 0;

if ( $pvs_global_settings["royalty_free"] ) {
	$rights_managed = 0;
} else
{
	$rights_managed = 1;
}

if ( isset( $_GET["id"] ) ) {
	$id = ( int )$_GET["id"];

	$sql = "select id,title,description,keywords,userid,duration,format,source,holder,free,google_x,google_y,adult,rights_managed from " .
		PVS_DB_PREFIX . "media where id=" . ( int )$_GET["id"] . " and (userid=" . ( int )
		get_current_user_id() . " or author='" . pvs_result( pvs_get_user_login () ) .
		"')";
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		$title = $rs->row["title"];
		$description = $rs->row["description"];
		$keywords = $rs->row["keywords"];
		$duration = $rs->row["duration"];
		$format = $rs->row["format"];
		$source = $rs->row["source"];
		$holder = $rs->row["holder"];
		$free = $rs->row["free"];
		$pnew = true;
		$google_x = $rs->row["google_x"];
		$google_y = $rs->row["google_y"];
		$adult = $rs->row["adult"];
		$rights_managed = $rs->row["rights_managed"];
	} else {
		exit();
	}
} else
{
	$id = 0;
}
?>





<form method="post" Enctype="multipart/form-data" action="<?php echo (site_url( ) );?>/upload-audio/?d=4<?php
if ( isset( $_GET["id"] ) ) {
	echo ( "&id=" . $_GET["id"] );
}
?>"  id="uploadform" name="uploadform"  onSubmit="return my_form_validate2();">

<div class='group_settings group_upload'>
<?php
if ( isset( $_GET["id"] ) ) {
	echo "<div style='margin-bottom:10px'>" . pvs_show_preview( ( int )$_GET["id"], "audio", 3, 0 ) . '</div>';
	echo pvs_show_preview( ( int )$_GET["id"], "audio", 2, 0 );

	if ( $pvs_global_settings["clarifai"] or $pvs_global_settings["imagga"] ) {
		$recognition_file_clarifai = pvs_show_preview( $id, "audio",
			3, 1 );
		$recognition_file_imagga = pvs_show_preview( $id, "audio", 3,
			1 );

		echo ( "<br><p><b>" . pvs_word_lang( "Image recognition" ) .
			":</b></p><input type='hidden' id='recognition_lang' value='" . $lang_symbol[$lng_original] .
			"'>" );

		if ( $pvs_global_settings["clarifai"] ) {
			echo ( "<a href=\"javascript:get_clarifai('" . $recognition_file_clarifai .
				"','keywords_clarifai','" . $pvs_global_settings["clarifai_language"] .
				"',false)\"  class='btn btn-warning'>Clarifai</a> " );
		}

		if ( $pvs_global_settings["imagga"] ) {
			echo ( "<a href=\"javascript:get_imagga('" . $recognition_file_imagga .
				"','keywords_imagga','" . $pvs_global_settings["imagga_language"] . "',false)\"  class='btn btn-primary'>Imagga</a> " );
		}

		if ( $pvs_global_settings["clarifai"] ) {
			echo ( '<div id="keywords_clarifai_box" style="display:none;margin-top:20px"><p><b>Clarifai - ' .
				pvs_word_lang( "keywords" ) .
				':</b></p><textarea id="keywords_clarifai" style="width:400px;height:150px;margin:5px 0px 8px 0px;display:block"></textarea><a href="javascript:apply_keywords(\'keywords_clarifai\',\'keywords\')" class="btn btn-default">' .
				pvs_word_lang( 'Apply' ) . '</a></div>' );
		}

		if ( $pvs_global_settings["imagga"] ) {
			echo ( '<div id="keywords_imagga_box" style="display:none;margin-top:20px"><p><b>Imagga - ' .
				pvs_word_lang( "keywords" ) .
				':</b></p><textarea id="keywords_imagga" style="width:400px;height:150px;display:block;margin:5px 0px 8px 0px"></textarea><a href="javascript:apply_keywords(\'keywords_imagga\',\'keywords\')" class="btn btn-default">' .
				pvs_word_lang( 'Apply' ) . '</a></div>' );
		}
	}
?>
<br><br><br>
<?php
}
?>





<?php
if ( isset( $fields_show["file for sale"] ) ) {
	if ( $pvs_global_settings["royalty_free"] and $pvs_global_settings["rights_managed"] and
		$pvs_global_settings["rights_managed_sellers"] ) {
?>
	<input type="radio" name="license_type"  id="license_type1" value="0" <?php
		if ( $rights_managed == 0 ) {
			echo ( "checked" );
		}
?> onClick="set_license(1)">&nbsp;<label for='license_type1' style='display:inline;font-size:12px'><?php echo pvs_word_lang( "royalty free" )?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="radio" name="license_type"  id="license_type2" value="1" <?php
		if ( $rights_managed > 0 ) {
			echo ( "checked" );
		}
?> onClick="set_license(2)">&nbsp;<label for='license_type2'  style='display:inline;font-size:12px'><?php echo pvs_word_lang( "rights managed" )?></label>
			<?php
	} else {
?>
			<input type="hidden" name="license_type" value="<?php
		if ( ! $pvs_global_settings["royalty_free"] ) {
			echo ( 1 );
		} else {
			echo ( 0 );
		}
?>">
			<?php
	}
?>


<?php
	$file_form = true;
	$flag_jquery = false;
?>
<?php
	if ( $pvs_global_settings["royalty_free"] ) {
?>
	<div id="box_license1" style="display:<?php
		if ( $rights_managed == 0 ) {
			echo ( "block" );
		} else {
			echo ( "none" );
		}
?>">
		<div class="form_field">
			<?php echo pvs_files_upload_form( $id, "audio", false )?>
		</div>
	</div>
	<?php
	}
?>
	
	<?php
	if ( $pvs_global_settings["rights_managed"] and $pvs_global_settings["rights_managed_sellers"] ) {
?>
	<div id="box_license2" style="display:<?php
		if ( $rights_managed > 0 ) {
			echo ( "block" );
		} else {
			echo ( "none" );
		}
?>">
		<?php echo pvs_rights_managed_upload_form( "audio", $rights_managed, $id, false )?>
	</div>
	<?php
	}
}
?>
</div>


<?php
//If category is enabled
if ( isset( $fields_show["category"] ) ) {

	//Category's list
	$category_ids = array();
	
	if ( $id != 0 ) {
		$sql = "select category_id from " . PVS_DB_PREFIX .
			"category_items where publication_id=" . $id;
		$rs->open( $sql );
		while ( ! $rs->eof ) {
			$category_ids[$rs->row["category_id"]] = 1;
			$rs->movenext();
		}
	}
?>


<div class='group_settings group_categories'>
	<div class="form_field">
			<?php
			$itg = "";
			$nlimit = 0;
			pvs_build_menu_admin_tree( 0, "seller" );
			echo ( $itg );
			?>
			<script>
			$(document).ready(function(){
				$("#categories_tree_menu").treeview({
					collapsed: false,
					persist: "cookie",
					cookieId: "treeview-black"
				});
			});
			</script>
	</div>
</div>



<?php
}
//End. If category is enabled

?>

<div class='group_settings group_other'>





<?php
if ( isset( $fields_show["title"] ) ) {
?>
	<div  class="form_field">
		<span><b><?php echo pvs_word_lang( "title" )?>:</b></span>
		<input class='ibox form-control' name="title" id="title" value="<?php echo $title?>" type="text" style="width:450px">
	</div>
<?php
}
?>

<?php
if ( isset( $fields_show["description"] ) ) {
?>
	<div class="form_field">
		<span><b><?php echo pvs_word_lang( "description" )?>:</b></span>
		<textarea class='ibox form-control' name="description" id="description" style="width:450px;height:200px"><?php echo $description?></textarea>
	</div>
<?php
}
?>

<?php
if ( isset( $fields_show["keywords"] ) ) {
?>
	<div  class="form_field">
		<span><b><?php echo pvs_word_lang( "keywords" )?>:</b></span>
		<textarea name="keywords" id="keywords" style="width:450px;height:200px" class='ibox form-control'><?php echo $keywords?></textarea>
		<span class="smalltext">(Example: key1,key2)</span>
	</div>
<?php
}
?>






<?php
if ( isset( $fields_show["duration"] ) ) {
?>
	<div  class="form_field">
		<span><b><?php echo pvs_word_lang( "duration" )?>:</b></span>
		<?php echo pvs_duration_form( $duration, "duration" )?>
	</div>
<?php
}
?>


<?php
if ( isset( $fields_show["track format"] ) ) {
?>
	<div  class="form_field">
		<span><b><?php echo pvs_word_lang( "track format" )?>:</b></span>
		<select name="format" id="format" class='ibox form-control' style="width:150px">
		<option value="">...</option>
		<?php
	$sql = "select * from " . PVS_DB_PREFIX . "audio_format";
	$dr->open( $sql );
	while ( ! $dr->eof ) {
		$sel = "";
		if ( $dr->row["name"] == $format ) {
			$sel = "selected";
		}
		?>
			<option value="<?php echo $dr->row["name"] ?>" <?php echo $sel?>><?php echo $dr->row["name"] ?></option>
			<?php
		$dr->movenext();
	}
?>
		</select>
	</div>
<?php
}
?>




<?php
if ( isset( $fields_show["track source"] ) ) {
?>
	<div class="form_field">
		<span><b><?php echo pvs_word_lang( "track source" )?>:</b></span>
		<select name="source" id="source" class='ibox form-control' style="width:150px">
		<option value="">...</option>
		<?php
	$sql = "select * from " . PVS_DB_PREFIX . "audio_source";
	$dr->open( $sql );
	while ( ! $dr->eof ) {
		$sel = "";
		if ( $dr->row["name"] == $source ) {
			$sel = "selected";
		}
		?>
			<option value="<?php echo $dr->row["name"] ?>" <?php echo $sel?>><?php echo $dr->row["name"] ?></option>
			<?php
		$dr->movenext();
	}
?>
		</select>
	</div>
<?php
}
?>





<?php
if ( isset( $fields_show["copyright holder"] ) ) {
?>
	<div class="form_field">
		<span><b><?php echo pvs_word_lang( "copyright holder" )?>:</b></span>
		<input class='ibox form-control' name="holder" id="holder" value="<?php echo $holder
?>" type="text" style="width:200px">
	</div>
<?php
}
?>




<div class="form_field">
	<span><b><?php echo pvs_word_lang( "free" )?>:</b></span>
	<input name="free" id="free" type="checkbox" <?php
	if ( $free == 1 ) {
		echo ( "checked" );
	}
	?>>
</div>
	
<?php
if ( $pvs_global_settings["adult_content"] ) {
?>
<div class="form_field">
	<span><b><?php echo pvs_word_lang( "adult content" )?>:</b></span>
	<input name="adult" type="checkbox" <?php
	if ( $adult == 1 ) {
		echo ( "checked" );
	}
?>>
</div>
<?php
}
?>
</div>

<?php
if ( $pvs_global_settings["google_coordinates"] ) {
?>
<div class='group_settings group_google'>
<div  class="gllpLatlonPicker">
	<div class="form_field">
		<span><b><?php echo pvs_word_lang( "Google coordinate X" )?>:</b></span>
		<input class='ibox form-control gllpLatitude' name="google_x" value="<?php echo $google_x ?>" type="text" style="width:200px">
	</div>

	<div class="form_field">
		<span><b><?php echo pvs_word_lang( "Google coordinate Y" )?>:</b></span>
		<input class='ibox form-control gllpLongitude' name="google_y" value="<?php echo $google_y ?>" type="text" style="width:200px">
	</div>
	
	<div class="form_field">
	<input type="hidden" class="gllpZoom" value="3"/>
	<input type="hidden" class="gllpUpdateButton" value="update map">
	<div class="gllpMap" id='map' style="width: 500px; height: 250px;margin-bottom:10px"></div>
	<input type="text" class="gllpSearchField ibox form-control" style="width:200px;display:inline">
	<input type="button" class="gllpSearchButton btn btn-default" value="<?php echo pvs_word_lang( "search" )?>">
	<script src='https://maps.googleapis.com/maps/api/js?sensor=false&key=<?php echo $pvs_global_settings["google_api"] ?>'></script>
	<script src='<?php echo pvs_plugins_url()?>/assets/js/gmap_picker/jquery-gmaps-latlon-picker.js'></script>
	</div>
</div>	
</div>
<?php
}
?>



<?php
if ( isset( $fields_show["terms and conditions"] ) ) {	
	if ( ! isset( $_GET["id"] ) ) {
	?>
	<hr>
	<script>
		function check_terms() {
			if( $('#terms').is(':checked')==false) {
				document.getElementById('upload_submit').disabled=true;
			}
			else
			{
				document.getElementById('upload_submit').disabled=false;
			}
		}
	</script>
			<div class="form_field">
	<span><?php echo pvs_word_lang( "terms and conditions" )?></span>
	<iframe src="<?php echo site_url()?>/agreement/?id=<?php echo($pvs_global_settings["upload_terms"])?>" frameborder="no" scrolling="yes" class="framestyle_terms"></iframe>
	<br><input name="terms" id="terms" type="checkbox" value="1"  onClick="check_terms();"> <?php echo pvs_word_lang( "i agree" )?>
	 		</div>	
		
	<?php
	}
}
?>








<div  class="form_field">
	<input class='isubmit' value="<?php
	if ( isset( $_GET["id"] ) ) {
		echo ( pvs_word_lang( "save" ) );
	} else
	{
		echo ( pvs_word_lang( "upload" ) );
	}
	?>" name="subm" id="upload_submit" type="submit" <?php
	if ( ! isset( $_GET["id"] ) ) {
	?>disabled<?php
	}
	?>>
</div>

</form>

</div>
<?php
include ( "profile_bottom.php" );
?>