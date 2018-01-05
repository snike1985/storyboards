<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "catalog_bulkupload" );
?>







<form method="post" action="<?php echo(pvs_plugins_admin_url('catalog/index.php'));
?>&action=photo_java_upload" name="uploadform">


<h2 class="nav-tab-wrapper">
	  <a href="javascript:change_group('files')" class="nav-tab nav-tab-active menu_settings menu_settings_files"><?php echo pvs_word_lang( "photos" )?></a></li>
	  <?php
if ( ! $pvs_global_settings["printsonly"] ) {
?>
	  	<a href="javascript:change_group('price')"  class="nav-tab menu_settings menu_settings_price"><?php echo pvs_word_lang( "price" )?></a>
	  <?php
}
?>
	  <?php
if ( $pvs_global_settings["prints"] ) {
?>
	  	<a href="javascript:change_group('prints')"  class="nav-tab  menu_settings menu_settings_prints"><?php echo pvs_word_lang( "prints" )?></a>
	  <?php
}
?>
	  <a href="javascript:change_group('categories')"  class="nav-tab  menu_settings menu_settings_categories"><?php echo pvs_word_lang( "categories" )?></a>
	</h2>
	<br>
	  <div class="group_settings group_files">
		<div class="form_field">
			<span><b><?php echo ( pvs_word_lang( "author" ) );
?>:</b></span>
			<select class="form-control" name="author" style="width:150px;margin-top:2px">
				<?php
$sql="select ID, user_login from " . $table_prefix . "users order by user_login";
$rs->open( $sql );
while ( ! $rs->eof ) {
	$sel = '';
	if ($rs->row["ID"] == get_current_user_id()) {
		$sel = 'selected';
	}
?>
					<option value="<?php echo $rs->row["user_login"] ?>" <?php echo($sel);
?>><?php echo $rs->row["user_login"] ?></option>
					<?php
	$rs->movenext();
}
?>
			</select>
		</div>	
				
		<?php
//Create a temporary folder for the preupload
$tmp_folder = "user_" . get_current_user_id();
if ( file_exists( pvs_plugins_url() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder ) ) {
	$dir = opendir( pvs_plugins_url() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder );
	while ( $file = readdir( $dir ) ) {
		if ( $file <> "." && $file <> ".." ) {
			@unlink( pvs_plugins_url() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder . "/" . $file );
		}
	}
} else
{
	mkdir( pvs_plugins_url() . PVS_UPLOAD_DIRECTORY . "/" . $tmp_folder );
}

//Create a list of the photo's sizes
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
		<div class="form_field">
			You should select *.jpg images and then click "Upload".
		</div>
		 <applet id="jumpLoaderApplet" name="jumpLoaderApplet"
			code="jmaster.jumploader.app.JumpLoaderApplet.class"
			archive="<?php echo pvs_plugins_url()?>/assets/js/mediautil_z.jar,<?php echo pvs_plugins_url()?>/assets/js/sanselan_z.jar,<?php echo pvs_plugins_url()?>/assets/js/jumploader_z.jar"
			width="700"
			height="500"
			mayscript>
				<param name="uc_sendImageMetadata" value="true"/>
				<param name="uc_imageEditorEnabled" value="true"/>
				<param name="uc_useLosslessJpegTransformations" value="true"/>
				<param name="uc_uploadUrl" value="<?php echo(site_url());
?>/upload_java_admin/?clientId=<?php echo get_current_user_id() ?>&token=<?php echo pvs_get_user_token( get_current_user_id() ); ?>"/>
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
	  <div class="group_settings group_price">
			<?php
if ( $pvs_global_settings["royalty_free"] and $pvs_global_settings["rights_managed"] ) {
?>
						<script>
							function set_license(value)
							{
								if(value==1)
								{
									document.getElementById('box_license2').style.display='none';
									document.getElementById('box_license1').style.display='block';
								}
								else
								{
									document.getElementById('box_license2').style.display='block';
									document.getElementById('box_license1').style.display='none';
								}
							}
						</script>
						<input type="radio" name="license_type"  id="license_type1" value="0" checked onClick="set_license(1)">&nbsp;&nbsp;<label for='license_type1' style='display:inline;font-size:12px'><?php echo pvs_word_lang( "royalty free" )?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="license_type"  id="license_type2" value="1" onClick="set_license(2)">&nbsp;&nbsp;<label for='license_type2'  style='display:inline;font-size:12px'><?php echo pvs_word_lang( "rights managed" )?></label>
					<?php
} else
{
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
?>
			<?php
if ( $pvs_global_settings["royalty_free"] ) {
?>
			<div id="box_license1" style="display:block;margin-top:20px">
				<?php echo pvs_photo_upload_form( 0, false )?>
			</div>
			<?php
}
?>
			
			<?php
if ( $pvs_global_settings["rights_managed"] ) {
?>
			<div id="box_license2" style="display:<?php
	if ( ! $pvs_global_settings["royalty_free"] ) {
		echo ( "block" );
	} else {
		echo ( "none" );
	}
?>;margin-top:20px">
				<?php echo pvs_rights_managed_upload_form( "photo", 1, 0, false )?>
			</div>
			<?php
}
?>	
	  </div>
	  <div class="group_settings group_prints">
		<?php
if ( $pvs_global_settings["prints"] ) {
	echo pvs_prints_upload_form();
}
?>
	  </div>
	  <div  class="group_settings group_categories">
		<div class="form_field">
				<?php
$itg = "";
$nlimit = 0;
pvs_build_menu_admin_tree( 0, "admin" );
echo ( $itg );
?>
		</div>
	  </div>





<div id="java_bulk"></div>


	<div id="button_bottom_static">
		<div id="button_bottom_layout"></div>
		<div id="button_bottom">
			<input type="submit" value="<?php echo pvs_word_lang( "upload" )?>" class="btn btn-primary" style="margin-top:20px">
		</div>
	</div>


</form>