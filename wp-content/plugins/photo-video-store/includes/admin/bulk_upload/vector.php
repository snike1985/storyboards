<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
?>


<?php
$upload_limit = 50;
?>









<form method="post" action="<?php echo(pvs_plugins_admin_url('catalog/index.php'));
?>&action=vector_upload" name="uploadform">


<h2 class="nav-tab-wrapper">
	  <a href="javascript:change_group('files')" class="nav-tab nav-tab-active menu_settings menu_settings_files"><?php echo pvs_word_lang( "vector" )?></a></li>
	  <a href="javascript:change_group('categories')"  class="nav-tab  menu_settings menu_settings_categories"><?php echo pvs_word_lang( "categories" )?></a>
	</h2>
	<br>
	
	  <div class="group_settings group_files">
			<div class="form_field">
				<p><b>Preupload</b> files here <b><?php echo pvs_upload_dir('baseurl')?><?php echo $pvs_global_settings["vectorpreupload"] ?></b> via FTP</p>

				<p>The *.jpg previews and files for sale must have the same names.</p>
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
				<span><b><?php echo pvs_word_lang( "license" )?>:</b></span>
				<?php
if ( $pvs_global_settings["royalty_free"] and $pvs_global_settings["rights_managed"] ) {
?>
							<script>
								function set_license(value)
								{
									if(value==1)
									{
										$('.box_license2').css('display','none');
										$('.box_license1').css('display','block');
									}
									else
									{
										$('.box_license2').css('display','block');
										$('.box_license1').css('display','none');
									}
								}
							</script>
							<input type="radio" name="license_type"  id="license_type1" value="0" checked onClick="set_license(1)">&nbsp;<label for='license_type1' style='display:inline;font-size:12px'><?php echo pvs_word_lang( "royalty free" )?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" name="license_type"  id="license_type2" value="1" onClick="set_license(2)">&nbsp;<label for='license_type2'  style='display:inline;font-size:12px'><?php echo pvs_word_lang( "rights managed" )?></label>
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
			</div>
			
			
			<?php
$n = 0;
$afiles = array();
$bfiles = array();

$dir = opendir( pvs_upload_dir() . $pvs_global_settings["vectorpreupload"] );
while ( $file = readdir( $dir ) ) {
	if ( $file <> "." && $file <> ".." && $file != "index.html" ) {
		if ( preg_match( "/.jpg$|.jpeg$/i", $file ) ) {
			$afiles[count( $afiles )] = $file;

			$n++;
		} else {
			$bfiles[count( $bfiles )] = $file;
		}
	}
}
closedir( $dir );
sort( $afiles );
reset( $afiles );
sort( $bfiles );
reset( $bfiles );

$sfiles = array();

if ( $pvs_global_settings["royalty_free"] ) {
	$sql = "select * from " . PVS_DB_PREFIX .
		"vector_types where shipped<>1 order by priority";
	$ds->open( $sql );
	while ( ! $ds->eof ) {
		$sfiles[$ds->row["id_parent"]] = "";
		$poisk = "." . str_replace( ",", "$|.", str_replace( " ", "", $ds->row["types"] ) ) .
			"$";
		for ( $i = 0; $i < count( $bfiles ); $i++ ) {
			if ( preg_match( "/" . $poisk . "/i", $bfiles[$i] ) )
			{
				if ( $sfiles[$ds->row["id_parent"]] != "" )
				{
					$sfiles[$ds->row["id_parent"]] .= "|";
				}
				$sfiles[$ds->row["id_parent"]] .= $bfiles[$i];
			}
		}
		$ds->movenext();
	}
}

$xfiles = array();

if ( $pvs_global_settings["rights_managed"] ) {
	$sql = "select id,formats from " . PVS_DB_PREFIX .
		"rights_managed where vector=1";
	$ds->open( $sql );
	while ( ! $ds->eof ) {
		$xfiles[$ds->row["id"]] = "";
		$poisk = "." . str_replace( ",", "$|.", str_replace( " ", "", $ds->row["formats"] ) ) .
			"$";
		for ( $i = 0; $i < count( $bfiles ); $i++ ) {
			if ( preg_match( "/" . $poisk . "/i", $bfiles[$i] ) )
			{
				if ( $xfiles[$ds->row["id"]] != "" )
				{
					$xfiles[$ds->row["id"]] .= "|";
				}
				$xfiles[$ds->row["id"]] .= $bfiles[$i];
			}
		}
		$ds->movenext();
	}
}

if ( count( $afiles ) < $upload_limit ) {
	$upload_limit = count( $afiles );
}
?>
			
			<table class="wp-list-table widefat fixed striped posts">
			<thead>
			<tr>
			<th><?php echo pvs_word_lang( "preview" )?></th>
			<th><?php echo pvs_word_lang( "file" )?></th>
			<th><?php echo pvs_word_lang( "title" )?>/<?php echo pvs_word_lang( "description" )?>/<?php echo pvs_word_lang( "keywords" )?>/<?php echo pvs_word_lang( "model property release" )?></th>
			</tr>
			</thead>
			<?php
for ( $i = 0; $i < $upload_limit; $i++ ) {
	$title = "";
	$description = "";
	$keywords = "";

	$size = getimagesize( pvs_upload_dir() . $pvs_global_settings["vectorpreupload"] .
		$afiles[$i], $info );
	if ( isset( $info["APP13"] ) ) {
		$iptc = iptcparse( $info["APP13"] );

		//Title
		if ( isset( $iptc["2#005"][0] ) and $iptc["2#005"][0] != "" ) {
			$title = $iptc["2#005"][0];
		}

		//Description
		if ( isset( $iptc["2#120"][0] ) and $iptc["2#120"][0] != "" ) {
			$description = $iptc["2#120"][0];
		}

		//Keywords
		if ( isset( $iptc["2#025"][0] ) and $iptc["2#025"][0] != "" ) {
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

	}
?>
				<tr valign="top">
				<td align="center"><img src="<?php echo(site_url());
?>/admin_photo_preview/?file=<?php echo $afiles[$i] ?>&type=vector"><input name="file<?php echo $i
?>" type="hidden" value="<?php echo $afiles[$i] ?>"><br><?php echo $afiles[$i] ?></td>
				<td>
					<input type="hidden"  name="previewphoto<?php echo $i
?>" value="<?php echo $afiles[$i] ?>">
					<input type="hidden"  name="previewflash<?php echo $i
?>" value="">				
					<?php
	$preview_mass = explode( ".", $afiles[$i] );
	$preview_name = "";
	for ( $k = 0; $k < count( $preview_mass ) - 1; $k++ ) {
		$preview_name .= $preview_mass[$k];
	}
?>
					<?php
	if ( $pvs_global_settings["royalty_free"] ) {
?>
						<div class="box_license1" style="display:block">
						<?php
		$sql = "select id_parent,name from " . PVS_DB_PREFIX .
			"licenses order by priority";
		$dr->open( $sql );
		while ( ! $dr->eof ) {
?>
							<div style="margin-top:10px"><b><?php
			echo $dr->row["name"] ?></b></div>
							<?php
			$sql = "select * from " . PVS_DB_PREFIX . "vector_types  where license=" . $dr->
				row["id_parent"] . " order by priority";
			$ds->open( $sql );
			while ( ! $ds->eof )
			{
?>
								<div style="margin-top:10px"><?php
				echo $ds->row["title"] ?>:</div>
				
								<?php
				if ( $ds->row["shipped"] == 1 )
				{
?>
									<div><input type="checkbox" name="file<?php
					echo $ds->row["id_parent"] ?>_<?php
					echo $i
?>"></div>
								<?php
				} else
				{
?>
									<div><select name="file<?php
					echo $ds->row["id_parent"] ?>_<?php
					echo $i
?>" style="width:130px"><option value="">...</option>
									<?php
					$zfiles = explode( "|", $sfiles[$ds->row["id_parent"]] );
					for ( $j = 0; $j < count( $zfiles ); $j++ )
					{
						$sel = "";
						if ( preg_match( "/" . $preview_name . "/i", $zfiles[$j] ) )
						{
							$sel = "selected";
?><option value="<?php
							echo $zfiles[$j] ?>" <?php
							echo $sel
?>><?php
							echo $zfiles[$j] ?></option><?php
						}
					}
?>
									</select></div>
								<?php
				}
?>
								<?php
				$ds->movenext();
			}
			$dr->movenext();
		}
?>
						</div>
						<?php
	}
?>
						<?php
	if ( $pvs_global_settings["rights_managed"] ) {
?>
						<div class="box_license2" style="display:<?php
		if ( ! $pvs_global_settings["royalty_free"] ) {
			echo ( "block" );
		} else {
			echo ( "none" );
		}
?>">
							<?php
		$sql = "select id,title from " . PVS_DB_PREFIX . "rights_managed where vector=1";
		$dr->open( $sql );
		while ( ! $dr->eof ) {
?>
									<div style="margin-top:10px"><?php
			echo $dr->row["title"] ?>:</div>
				
									<div>
										<select name="file<?php
			echo $dr->row["id"] ?>_<?php
			echo $i
?>" style="width:130px"><option value="">...</option>
											<?php
			$zfiles = explode( "|", $xfiles[$dr->row["id"]] );
			for ( $j = 0; $j < count( $zfiles ); $j++ )
			{
				$sel = "";
				if ( preg_match( "/" . $preview_name . "/i", $zfiles[$j] ) )
				{
					$sel = "selected";
?><option value="<?php
					echo $zfiles[$j] ?>" <?php
					echo $sel
?>><?php
					echo $zfiles[$j] ?></option><?php
				}
			}
?>
										</select>
									</div>
								<?php
			$dr->movenext();
		}
?>
						</div>
						<?php
	}
?>
				</td>
				<td>
				<div style="margin-top:3px"><input class='ft' type="text" name="title<?php echo $i
?>" value="<?php echo $title
?>" style="width:400px"></div>
				<div style="margin-top:3px"><textarea class='textarea' name="description<?php echo $i
?>" style="width:400px;height:70px"><?php echo $description
?></textarea></div>
				<div style="margin-top:3px"><textarea class='textarea' name="keywords<?php echo $i
?>"  style="width:400px;height:70px"><?php echo $keywords
?></textarea></div>
				<?php
	if ( $pvs_global_settings["model"] ) {
?>
				<div style="margin-top:3px">
				<select name="model<?php echo $i
?>" style="width:200px">
				<option value="0"></option>
				<?php
		$sql = "select id_parent,name from " . PVS_DB_PREFIX . "models order by name";
		$dn->open( $sql );
		while ( ! $dn->eof ) {
?>
					<option value="<?php
			echo $dn->row["id_parent"] ?>"><?php
			echo $dn->row["name"] ?></option>
					<?php
			$dn->movenext();
		}
?>
				</select></div>
				<?php
	} else {
?>
				<input type="hidden" name="model<?php echo $i
?>" value="">
				<?php
	}
?>
				</td>
				</tr>
				<?php
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





	<div id="button_bottom_static">
		<div id="button_bottom_layout"></div>
		<div id="button_bottom">
			<input type="submit" value="<?php echo pvs_word_lang( "upload" )?>" class="btn btn-primary" style="margin-top:20px">
		</div>
	</div>

</form>