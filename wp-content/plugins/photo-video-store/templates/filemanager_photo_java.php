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

include ( "profile_top.php" );


$tmp_folder = "user_" . get_current_user_id();
if ( file_exists( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder ) ) {
	$dir = opendir( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder );
	while ( $file = readdir( $dir ) ) {
		if ( $file <> "." && $file <> ".." ) {
			@unlink( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder . "/" . $file );
		}
	}
} else
{
	mkdir( pvs_upload_dir() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder );
}

$photo_names = "thumb1,thumb2";
$photo_sizes = $pvs_global_settings["thumb_width"] . "x" . $pvs_global_settings["thumb_width"] .
	"," . $pvs_global_settings["thumb_width2"] . "x" . $pvs_global_settings["thumb_width2"];
$photo_quality = "1000,1000";

if ( $pvs_global_settings["prints"] and $pvs_global_settings["prints_previews"] and
	$pvs_global_settings["prints_previews_thumb"] and $pvs_global_settings["prints_previews_width"] >
	$pvs_global_settings["thumb_width2"] ) {
	$photo_names .= ",thumb_print";
	$photo_sizes .= "," . $pvs_global_settings["prints_previews_width"] . "x" . $pvs_global_settings["prints_previews_width"];
	$photo_quality .= ",1000";
}

$flag_original = false;
$sql = "select id_parent,size from " . PVS_DB_PREFIX .
	"sizes group by size order by size";
$rs->open( $sql );
while ( ! $rs->eof ) {
	if ( $rs->row["size"] != 0 ) {
		if ( $rs->row["size"] != $pvs_global_settings["thumb_width"] and $rs->row["size"] !=
			$pvs_global_settings["thumb_width2"] ) {
			$photo_names .= ",photo_" . $rs->row["size"];
			$photo_sizes .= "," . $rs->row["size"] . "x" . $rs->row["size"];
			$photo_quality .= ",1000";
		}
	} else {
		if ( ! $flag_original ) {
			$photo_names .= ",original";
			$photo_sizes .= ",100000x100000";
			$photo_quality .= ",1000";
		}
		$flag_original = true;
	}
	$rs->movenext();
}
?>

<script>
$(document).ready(function() {
	change_group('upload');
});
</script>

<h1><?php echo pvs_word_lang( "java photo uploader" )?></h1>

<br>
<div class="nav-tabs-custom tabs-style-2">
	<ul class="nav nav-tabs" style="margin-left:0px">
	  <li class="menu_settings menu_settings_upload"><a href="javascript:change_group('upload')" class="nav-link active"><?php echo pvs_word_lang( "photos" )?></a></li>
	  <?php
		if ( ! $pvs_global_settings["printsonly"] ) {
		?>
				<li class="menu_settings menu_settings_price"><a href="javascript:change_group('price')" class="nav-link"><?php echo pvs_word_lang( "price" )?></a></li>
			  <?php
		}
		?>
	  <?php
		if ( $pvs_global_settings["prints"] ) {
		?>
				<li class="menu_settings menu_settings_prints"><a href="javascript:change_group('prints')" class="nav-link"><?php echo pvs_word_lang( "prints" )?></a></li>
			  <?php
		}
		?>
	  <li class="menu_settings menu_settings_categories"><a href="javascript:change_group('categories')" class="nav-link"><?php echo pvs_word_lang( "categories" )?></a></li>
	  <li class="menu_settings menu_settings_other"><a href="javascript:change_group('other')" class="nav-link"><?php echo pvs_word_lang( "settings" )?></a></li>
	  <li class="menu_settings menu_settings_models"><a href="javascript:change_group('models')" class="nav-link"><?php echo pvs_word_lang( "models" )?></a></li>
	  <?php
		if ( $pvs_global_settings["google_coordinates"] ) {
		?>
				<li class="menu_settings menu_settings_google"><a href="javascript:change_group('google')" class="nav-link"><?php echo pvs_word_lang( "Google map" )?></a></li>
			  <?php
		}
		?>
	</ul>
</div>
<div style="padding:20px" class="tab-content">
	  <div class='group_settings group_upload'>

<p><?php echo pvs_word_lang( "select files" )?>. (*.jpg <  <?php echo $lphoto
?>M)</b></p>




 <applet id="jumpLoaderApplet" name="jumpLoaderApplet"
	code="jmaster.jumploader.app.JumpLoaderApplet.class"
	archive="<?php echo pvs_plugins_url()?>/assets/js/mediautil_z.jar,<?php echo pvs_plugins_url()?>/assets/js/sanselan_z.jar,<?php echo pvs_plugins_url()?>/assets/js/jumploader_z.jar"
	width="700"
	height="500"
	mayscript>
    	<param name="uc_sendImageMetadata" value="true"/>
    	<param name="uc_imageEditorEnabled" value="true"/>
        <param name="uc_useLosslessJpegTransformations" value="true"/>
		<param name="uc_uploadUrl" value="<?php echo site_url()?>/upload-photo-java/?clientId=<?php echo get_current_user_id() ?>&token=<?php echo pvs_get_user_token( get_current_user_id() ); ?>"/>
        <param name="uc_uploadScaledImages" value="true"/>


        <param name="uc_scaledInstanceNames" value="<?php echo $photo_names
?>"/>
        <param name="uc_scaledInstanceDimensions" value="<?php echo $photo_sizes
?>"/>
        <param name="uc_scaledInstanceQualityFactors" value="<?php echo $photo_quality
?>"/>

        <param name="ac_fireUploaderFileAdded" value="true"/>
		<param name="ac_fireUploaderFileStatusChanged" value="true"/>
        <param name="uc_fileNamePattern" value="^.+\.(?i)((jpg)|(jpeg))$"/>
        <param name="vc_fileNamePattern" value="^.+\.(?i)((jpg)|(jpeg))$"/>
        <param name="vc_disableLocalFileSystem" value="false"/>
        <param name="vc_mainViewFileTreeViewVisible" value="false"/>
        <param name="vc_mainViewFileListViewVisible" value="false"/>
        <param name="uc_imageRotateEnabled" value="true"/>
        <param name="uc_scaledInstancePreserveMetadata" value="true"/>
        <param name="uc_deleteTempFilesOnRemove" value="true"/>
</applet>
</div>






<form method="post" Enctype="multipart/form-data" action="<?php echo site_url()?>/upload-photo-java-process/" name="uploadform">


<?php
$free = 0;
$model = 0;
$editorial = 0;
$adult = 0;
$folderid = 0;
include ( "filemanager_photo_content.php" );?>

<hr>
			<div class="form_field">
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
	<span><?php echo pvs_word_lang( "terms and conditions" )?></span>
	<iframe src="<?php echo site_url()?>/agreement/?id=<?php echo($pvs_global_settings["upload_terms"])?>" frameborder="no" scrolling="yes" class="framestyle_terms"></iframe>
	<br><input name="terms" id="terms" type="checkbox" value="1"  onClick="check_terms();"> <?php echo pvs_word_lang( "i agree" )?>
	 		</div>

<div class="form_field">
	<input type="submit" name="subm" id="upload_submit" class="isubmit" value="<?php echo pvs_word_lang( "next step" )?>" disabled>
</div>

</form>

</div>
<?php
include ( "profile_bottom.php" );
?>