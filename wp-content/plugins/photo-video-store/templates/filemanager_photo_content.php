<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}
?>

<div class='group_settings group_price'>
	<?php
	if ( ! $pvs_global_settings["printsonly"] ) {
	?>
		<div class="form_field">
			<?php
		if ( $pvs_global_settings["royalty_free"] and $pvs_global_settings["rights_managed"] and
			$pvs_global_settings["rights_managed_sellers"] ) {
	?>
		<input type="radio" name="license_type"  id="license_type1" value="0" checked onClick="set_license(1)">&nbsp;<label for='license_type1' style='display:inline;font-size:12px'><?php echo pvs_word_lang( "royalty free" )?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="radio" name="license_type"  id="license_type2" value="1" onClick="set_license(2)">&nbsp;<label for='license_type2'  style='display:inline;font-size:12px'><?php echo pvs_word_lang( "rights managed" )?></label>
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
	$file_form = false;
	$flag_jquery = true;
?>
		<?php
	if ( $pvs_global_settings["royalty_free"] ) {
?>
		<div id="box_license1" style="display:block">
			<?php echo pvs_photo_upload_form( 0, false )?>
		</div>
		<?php
	}
?>
		
		<?php
	if ( $pvs_global_settings["rights_managed"] and $pvs_global_settings["rights_managed_sellers"] ) {
?>
		<div id="box_license2" style="display:<?php
		if ( ! $pvs_global_settings["royalty_free"] ) {
			echo ( "block" );
		} else {
			echo ( "none" );
		}
?>">
			<?php echo pvs_rights_managed_upload_form( "photo", 1, 0, false )?>
		</div>
		<?php
	}
?>
	</div>
	<?php
}
?>
</div>



<div class='group_settings group_prints'>
	<?php
if ( $pvs_global_settings["prints_users"] ) {
?>
		<div class="form_field">
			<?php echo ( pvs_prints_upload_form() );?>
		</div>
		<?php
}
?>
</div>



<div class='group_settings group_categories'>
	<div class="form_field">
			<?php
			$itg = "";
			$nlimit = 0;
			pvs_build_menu_admin_tree( 0, "seller" );
			echo ( $itg );?>
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



<div class='group_settings group_other'>
	<div class="form_field">
		<span><b><?php echo pvs_word_lang( "free" )?>:</b></span>
		<input name="free" type="checkbox" <?php
if ( $free == 1 ) {
	echo ( "checked" );
}
?>>
	</div>	
	
	<div class="form_field">
		<span><b><?php echo pvs_word_lang( "editorial" )?>:</b></span>
		<input name="editorial" type="checkbox" <?php
if ( $editorial == 1 ) {
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




<div class='group_settings group_models'>
	<?php
if ( $pvs_global_settings["model"] ) {
?>
	<div class="form_field">
		<?php
		echo ( pvs_show_models( 0 ) );
		?>
	</div>
	<?php
}
?>
</div>





<div class='group_settings group_google'>
	<?php
if ( $pvs_global_settings["google_coordinates"] ) {
?>
	<div  class="gllpLatlonPicker">
		<div class="form_field">
			<span><b><?php echo pvs_word_lang( "Google coordinate X" )?>:</b></span>
			<input class='ibox form-control gllpLatitude' name="google_x" value="0" type="text" style="width:200px">
		</div>
		
		<div class="form_field">
			<span><b><?php echo pvs_word_lang( "Google coordinate Y" )?>:</b></span>
			<input class='ibox form-control gllpLongitude' name="google_y" value="0" type="text" style="width:200px">
		</div>
		
		<div class="form_field">
			<input type="hidden" class="gllpZoom" value="3"/>
			<input type="hidden" class="gllpUpdateButton" value="update map">
			<div class="gllpMap" id='map' style="width: 500px; height: 250px;margin-bottom:10px"></div>
			<input type="text" class="gllpSearchField ibox form-control" style="width:200px;display:inline">
			<input type="button" class="gllpSearchButton btn btn-default" value="<?php echo pvs_word_lang( "search" )?>">
			<script src='https://maps.googleapis.com/maps/api/js?sensor=false&key=<?php echo $pvs_global_settings["google_api"] ?>'></script>
			<script src='<?php echo(pvs_plugins_url());?>/assets/js/gmap_picker/jquery-gmaps-latlon-picker.js'></script>
		</div>
	</div>
	<?php
}
?>
</div>