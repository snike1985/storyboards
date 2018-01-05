<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "catalog_bulkupload" );

function pvs_get_encoding( $str ) {
	$cp_list = array( 'utf-8', 'windows-1251' );
	foreach ( $cp_list as $k => $codepage ) {
		if ( md5( $str ) === md5( @iconv( $codepage, $codepage, $str ) ) ) {
			return $codepage;
		}
	}
	return null;
}
?>


<form method="post" action="<?php echo(pvs_plugins_admin_url('catalog/index.php'));
?>&action=photo_upload" name="uploadform">


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
			<p><b>You should preupload</b> *.jpg files here <b><?php echo pvs_upload_dir('baseurl')?><?php echo $pvs_global_settings["photopreupload"] ?></b> on FTP</p>
		
			<p>If you want to upload <b>additional formats</b> (*.gif,*.png,*.raw,*.tiff,*.eps) the files must have the same names as *.jpg.</p>
		</div>
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

		<div class="form_field">
		<span><b>Remove</b> files from <?php echo $pvs_global_settings["photopreupload"] ?> after the upload</span>
		<input type="checkbox" name="remove" checked>
		</div>
		
		
		<?php
$photo_formats = array();
$sql = "select id,photo_type from " . PVS_DB_PREFIX .
	"photos_formats where enabled=1 and photo_type<>'jpg' order by id";
$dr->open( $sql );
while ( ! $dr->eof ) {
	$photo_formats[$dr->row["id"]] = $dr->row["photo_type"];
	$dr->movenext();
}

$n = 0;
$afiles = array();

$dir = opendir( pvs_upload_dir() . $pvs_global_settings["photopreupload"] );
while ( $file = readdir( $dir ) ) {
	if ( $file <> "." && $file <> ".." ) {
		if ( preg_match( "/.jpg$|.jpeg$/i", $file ) ) {
			$afiles[count( $afiles )] = $file;
			$n++;
		}
	}
}
closedir( $dir );
sort( $afiles );
reset( $afiles );
?>
		<script language="javascript">
		
		function selectall() {
			if(document.getElementById("allphotos").checked)
			{
				for(i=0;i<<?php echo count( $afiles )?>;i++)
				{
					$(".photocheck").attr("checked",true);
				}
			}
			else
			{
				for(i=0;i<<?php echo count( $afiles )?>;i++)
				{
					$(".photocheck").attr("checked",false);
				}
			}
		}
		
		</script>
		
		<?php
$page_mass = array(
	10,
	20,
	30,
	40,
	50,
	100,
	0 );
?>
		<div class="form_field">
			<span><b><?php echo ( pvs_word_lang( "photos" ) );
?>:</b></span>
			<select class="form-control" onChange="location.href=this.value" style="width:100px">
			<?php
for ( $i = 0; $i < count( $page_mass ); $i++ ) {
	$sel = "";
	if ( $page_mass[$i] == ( int )$_SESSION["bulk_page"] ) {
		$sel = "selected";
	}
?>
				<option value="<?php echo(pvs_plugins_admin_url('bulk_upload/index.php'));?>&d=1&quantity=<?php echo $page_mass[$i] ?>" <?php echo $sel
?>>
				<?php
	if ( $page_mass[$i] == 0 ) {
		echo ( pvs_word_lang( "all files" ) );
	} else {
		echo ( $page_mass[$i] );
	}
?>
				</option>
				<?php
}
?>
			</select>
		</div>
		
		<div class="form_field">
			<?php
if ( ( int )$_SESSION["bulk_page"] != 0 ) {
	echo ( pvs_paging( $n, $str, ( int )$_SESSION["bulk_page"], 7, pvs_plugins_admin_url('bulk_upload/index.php'),
		"&d=1" ) );
	$kolvo = ( int )$_SESSION["bulk_page"];
} else
{
	$kolvo = 100000000000;
}
?>
		</div>


		<table class="wp-list-table widefat fixed striped posts">
		<thead>
		<tr>
		<th><input type="checkbox" id="allphotos" checked onClick="selectall()"></th>
		<th><?php echo pvs_word_lang( "preview" )?></th>
		<th><?php echo pvs_word_lang( "IPTC info" )?>: <?php echo pvs_word_lang( "title" )?>/<?php echo pvs_word_lang( "description" )?>/<?php echo pvs_word_lang( "keywords" )?></th>
		</tr>
		</thead>
		<?php
for ( $i = 0; $i < count( $afiles ); $i++ ) {
	if ( $i > $kolvo * ( $str - 1 ) - 1 and $i < $kolvo * $str ) {
		$title = "";
		$description = "";
		$keywords = "";

		$size = getimagesize( pvs_upload_dir() . $pvs_global_settings["photopreupload"] .
			$afiles[$i], $info );
		if ( isset( $info["APP13"] ) ) {
			$iptc = iptcparse( $info["APP13"] );

			//Title
			if ( isset( $iptc["2#005"][0] ) and $iptc["2#005"][0] != "" )
			{
				$title = $iptc["2#005"][0];
			} else
			{
				if ( isset( $iptc["2#105"][0] ) and $iptc["2#105"][0] != "" )
				{
					$title = $iptc["2#105"][0];
				}
			}

			//$title = mb_convert_encoding($title, 'UTF-8', pvs_get_encoding($title));

			//Description
			if ( isset( $iptc["2#120"][0] ) and $iptc["2#120"][0] != "" )
			{
				$description = $iptc["2#120"][0];
			}

			//$description = mb_convert_encoding($description, 'UTF-8', pvs_get_encoding($description));

			//Keywords
			if ( isset( $iptc["2#025"][0] ) and $iptc["2#025"][0] != "" )
			{
				$iptc_kw = "";
				for ( $t = 0; $t < count( $iptc["2#025"] ); $t++ )
				{
					if ( $iptc_kw != "" )
					{
						$iptc_kw .= ",";
					}
					$iptc_kw .= $iptc["2#025"][$t];
				}
				if ( $iptc_kw != "" )
				{
					$keywords = $iptc_kw;
				}
			}

			//$keywords = mb_convert_encoding($keywords, 'UTF-8', pvs_get_encoding($keywords));
		}
?>
				<tr valign="top" <?php
		if ( ( $i + 1 ) % 2 == 0 ) {
			echo ( "class='snd'" );
		}
?>>
					<td><input name="f<?php echo $i
?>" id="f<?php echo $i
?>" type="checkbox" checked style="margin-top:3px" class="photocheck"></td>
					<td><img src="<?php echo(site_url());
?>/admin_photo_preview/?file=<?php echo $afiles[$i] ?>&type=photo"><input name="file<?php echo $i
?>" type="hidden" value="<?php echo $afiles[$i] ?>">
					<div style='margin-bottom:3px'><small><?php echo $afiles[$i] ?></small></div>
					<?php
		$filename = pvs_get_file_info( $afiles[$i], "filename" );
		foreach ( $photo_formats as $key => $value ) {
			if ( $value == "tiff" )
			{
				if ( file_exists( pvs_upload_dir() . $pvs_global_settings["photopreupload"] . "/" .
					$filename . ".tif" ) )
				{
?>
								<div style='margin-bottom:3px'><small><?php
					echo $filename . ".tif"
?></small></div>
								<?php
				}
				if ( file_exists( pvs_upload_dir() . $pvs_global_settings["photopreupload"] . "/" .
					$filename . ".tiff" ) )
				{
?>
								<div style='margin-bottom:3px'><small><?php
					echo $filename . ".tiff"
?></small></div>
								<?php
				}
			} else
			{
				if ( file_exists( pvs_upload_dir() . $pvs_global_settings["photopreupload"] . "/" .
					$filename . "." . $value ) )
				{
?>
								<div style='margin-bottom:3px'><small><?php
					echo $filename . "." . $value
?></small></div>
								<?php
				}
			}
		}
?>
					</td>
					<td>
					<div><textarea class='textarea' name="title<?php echo $i
?>" style="width:400px;height:70px"><?php echo $title
?></textarea></div>
					<div style="margin-top:3px"><textarea class='textarea' name="description<?php echo $i
?>" style="width:400px;height:150px"><?php echo $description
?></textarea></div>
					<div style="margin-top:3px"><textarea class='textarea' name="keywords<?php echo $i
?>" style="width:400px;height:150px"><?php echo $keywords
?></textarea></div>
					</td>
				</tr>
				<?php
	}
}
?>
		</table>
	  </div>
	  <div class="group_settings group_categories">
		<div class="form_field">
				<?php
$itg = "";
$nlimit = 0;
pvs_build_menu_admin_tree( 0, "admin" );
echo ( $itg );
?>
		</div>
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



	<div id="button_bottom_static">
		<div id="button_bottom_layout"></div>
		<div id="button_bottom">
			<input type="submit" class="btn btn-primary" value="<?php echo pvs_word_lang( "upload" )?>" style="margin-top:20px">
		</div>
	</div>
</form>