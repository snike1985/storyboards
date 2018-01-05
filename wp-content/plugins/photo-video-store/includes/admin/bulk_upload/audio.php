<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "catalog_bulkupload" );

?>




<script>
function mdefault(t) {
	with(document.uploadform) {
		dd=eval(t+".value");
		for(i=0;i<<?php echo $pvs_global_settings["bulk_upload"] ?>;i++) {
			rs=eval(t+i);
			rs.value=dd
		}
	}
}
</script>






<form method="post" action="<?php echo(pvs_plugins_admin_url('catalog/index.php'));
?>&action=audio_upload" name="uploadform">


<h2 class="nav-tab-wrapper">
	  <a href="javascript:change_group('files')" class="nav-tab nav-tab-active menu_settings menu_settings_files"><?php echo pvs_word_lang( "audio" )?></a></li>
	  <a href="javascript:change_group('categories')"  class="nav-tab  menu_settings menu_settings_categories"><?php echo pvs_word_lang( "categories" )?></a>
	</h2>
	<br>
	  <div class="group_settings group_files">
			<div class="form_field">
			You should upload files here <b><?php echo pvs_upload_dir('baseurl')?><?php echo $pvs_global_settings["audiopreupload"] ?></b> on FTP<br><br>
			
			Photo previews: <b>*.jpg, *.jpeg</b><br>
			Audio previews: <b>mp3</b>
			
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
			
			<table class='table_admin table table-striped' style="width:100%">
			<tr>
			<th><b><?php echo pvs_word_lang( "file" )?></b></th>
			<th><b><?php echo pvs_word_lang( "title" )?>/<?php echo pvs_word_lang( "description" )?>/<?php echo pvs_word_lang( "keywords" )?><?php
if ( $pvs_global_settings["model"] ) {
	echo ( "/" . pvs_word_lang( "model property release" ) );
}
?></b></th>
			<th><b><?php echo pvs_word_lang( "settings" )?></b></th>
			</tr>

			<tr valign="top">
			<td>Default meanings for the fields:</td>
			<td>
				<div><input type="text" name="title" onkeyup="mdefault('title')" value="" style="width:400px"></div>
				<div style="margin-top:3px"><textarea name="description" onkeyup="mdefault('description')" style="width:400px;height:100px"></textarea></div>
				<div style="margin-top:3px"><input type="text" name="keywords" onkeyup="mdefault('keywords')" value="" style="width:400px"></div>
				<?php
if ( $pvs_global_settings["model"] ) {
?>
					<div style="margin-top:3px">
						<select name="model" onChange="mdefault('model')" style="width:400px">
							<option value="0"></option>
							<?php
	$sql = "select id_parent,name from " . PVS_DB_PREFIX . "models order by name";
	$dn->open( $sql );
	while ( ! $dn->eof ) {
?>
								<option value="<?php echo $dn->row["id_parent"] ?>"><?php echo $dn->row["name"] ?></option>
								<?php
		$dn->movenext();
	}
?>
						</select>
					</div>
				<?php
}
?>
			</td>
			<td >
			<?php
$sql = "select * from " . PVS_DB_PREFIX . "audio_fields order by priority";
$rs->open( $sql );
while ( ! $rs->eof ) {
	if ( $rs->row["name"] == "track format" and ( $rs->row["activ"] == 1 or $rs->
		row["always"] == 1 ) ) {
?>
					<div style="margin-bottom:9px">
						<b><?php echo pvs_word_lang( "track format" )?>:</b><br>
						<select name="format" style="width:150px" onChange="mdefault('format')">
							<option value="">...</option>
							<?php
		$sql = "select * from " . PVS_DB_PREFIX . "audio_format";
		$dr->open( $sql );
		while ( ! $dr->eof ) {
?>
								<option value="<?php
			echo $dr->row["name"] ?>"><?php
			echo $dr->row["name"] ?></option>
								<?php
			$dr->movenext();
		}
?>
						</select>
					</div>
					<?php
	}

	if ( $rs->row["name"] == "track source" and ( $rs->row["activ"] == 1 or $rs->
		row["always"] == 1 ) ) {
?>
					<div style="margin-bottom:9px"><b><?php echo pvs_word_lang( "track source" )?>:</b><br>
						<select name="source" style="width:150px" onChange="mdefault('source')">
							<option value="">...</option>
							<?php
		$sql = "select * from " . PVS_DB_PREFIX . "audio_source";
		$dr->open( $sql );
		while ( ! $dr->eof ) {
?>
								<option value="<?php
			echo $dr->row["name"] ?>"><?php
			echo $dr->row["name"] ?></option>
								<?php
			$dr->movenext();
		}
?>
						</select>
					</div>
					<?php
	}

	if ( $rs->row["name"] == "copyright holder" and ( $rs->row["activ"] == 1 or $rs->
		row["always"] == 1 ) ) {
?>
					<div style="margin-bottom:9px">
						<b><?php echo pvs_word_lang( "copyright holder" )?>:</b><br>
						<input name="holder" value="" type="text" style="width:150px" onkeyup="mdefault('holder')">
					</div>
					<?php
	}
	$rs->movenext();
}
?>
			</td>
			</tr>
			<?php
$afiles = array();
$bfiles = array();
$cfiles = array();

if ( file_exists( pvs_upload_dir() . $pvs_global_settings["audiopreupload"] ) ) {
	$dir = opendir( pvs_upload_dir() . $pvs_global_settings["audiopreupload"] );
	while ( $file = readdir( $dir ) ) {
		if ( $file <> "." && $file <> ".." ) {
			if ( preg_match( "/.jpg$|.gif$|.png$|.jpeg$/i", $file ) )
			{
				$afiles[count( $afiles )] = $file;
			}

			if ( preg_match( "/.mp3$/i", $file ) )
			{
				$bfiles[count( $bfiles )] = $file;
			}

			if ( ! preg_match( "/.jpg$|.gif$|.png$|.jpeg$/i", $file ) )
			{
				$cfiles[count( $cfiles )] = $file;
			}
		}
	}
}

sort( $afiles );
reset( $afiles );
sort( $bfiles );
reset( $bfiles );
sort( $cfiles );
reset( $cfiles );

$sfiles = array();

if ( $pvs_global_settings["royalty_free"] ) {
	$sql = "select * from " . PVS_DB_PREFIX .
		"audio_types where shipped<>1 order by priority";
	$ds->open( $sql );
	while ( ! $ds->eof ) {
		$sfiles[$ds->row["id_parent"]] = "";
		$poisk = "." . str_replace( ",", "$|.", str_replace( " ", "", $ds->row["types"] ) ) .
			"$";

		for ( $i = 0; $i < count( $cfiles ); $i++ ) {
			if ( preg_match( "/" . $poisk . "/i", $cfiles[$i] ) )
			{
				if ( $sfiles[$ds->row["id_parent"]] != "" )
				{
					$sfiles[$ds->row["id_parent"]] .= "|";
				}
				$sfiles[$ds->row["id_parent"]] .= $cfiles[$i];
			}
		}

		$ds->movenext();
	}
}

$xfiles = array();

if ( $pvs_global_settings["rights_managed"] ) {
	$sql = "select id,formats from " . PVS_DB_PREFIX .
		"rights_managed where audio=1";
	$ds->open( $sql );
	while ( ! $ds->eof ) {
		$xfiles[$ds->row["id"]] = "";
		$poisk = "." . str_replace( ",", "$|.", str_replace( " ", "", $ds->row["formats"] ) ) .
			"$";
		for ( $i = 0; $i < count( $cfiles ); $i++ ) {
			if ( preg_match( "/" . $poisk . "/i", $cfiles[$i] ) )
			{
				if ( $xfiles[$ds->row["id"]] != "" )
				{
					$xfiles[$ds->row["id"]] .= "|";
				}
				$xfiles[$ds->row["id"]] .= $cfiles[$i];
			}
		}
		$ds->movenext();
	}
}

for ( $i = 0; $i < $pvs_global_settings["bulk_upload"]; $i++ ) {
?>
				<tr valign="top"  <?php
	if ( $i % 2 == 0 ) {
		echo ( "class='snd'" );
	}
?>>
					<td>
						<div><?php echo pvs_word_lang( "preview" )?> <?php echo pvs_word_lang( "photo" )?>:</div>
			
						<div><select name="previewphoto<?php echo $i
?>" style="width:130px"><option value="">...</option>
						<?php
	for ( $j = 0; $j < count( $afiles ); $j++ ) {
?><option value="<?php echo $afiles[$j] ?>"><?php echo $afiles[$j] ?></option><?php
	}
?>
						</select></div>
			
						<div style="margin-top:10px"><?php echo pvs_word_lang( "preview" )?> <?php echo pvs_word_lang( "audio" )?>:</div>
						
						<div><select name="previewaudio<?php echo $i
?>" style="width:130px"><option value="">...</option>
						<?php
	for ( $j = 0; $j < count( $bfiles ); $j++ ) {
?><option value="<?php echo $bfiles[$j] ?>"><?php echo $bfiles[$j] ?></option><?php
	}
?>
						</select></div>
			
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
			$sql = "select * from " . PVS_DB_PREFIX . "audio_types  where license=" . $dr->
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
?><option value="<?php
						echo $zfiles[$j] ?>"><?php
						echo $zfiles[$j] ?></option><?php
					}
?>
												</select></div>
											<?php
				}
				$ds->movenext();
			}
			$dr->movenext();
		}
?>
					</div>
					<?php
	}

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
		$sql = "select id,title from " . PVS_DB_PREFIX . "rights_managed where audio=1";
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
?><option value="<?php
				echo $zfiles[$j] ?>"><?php
				echo $zfiles[$j] ?></option><?php
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

			<td class=tab<?php
	if ( $i % 2 == 1 ) {
		echo ( 4 );
	} else {
		echo ( 6 );
	}
?>>
			<div><input type="text" name="title<?php echo $i
?>" value="" style="width:400px"></div>
			<div style="margin-top:3px"><textarea name="description<?php echo $i
?>" style="width:400px;height:100px"></textarea></div>
			<div style="margin-top:3px"><input type="text" name="keywords<?php echo $i
?>" value="" style="width:400px"></div>
			<?php
	if ( $pvs_global_settings["model"] ) {
?>
				<div style="margin-top:3px">
				<select name="model<?php echo $i
?>" style="width:400px">
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
			<td  class=tab<?php
	if ( $i % 2 == 1 ) {
		echo ( 4 );
	} else {
		echo ( 6 );
	}
?>>
			<?php
	$sql = "select * from " . PVS_DB_PREFIX . "audio_fields order by priority";
	$rs->open( $sql );
	while ( ! $rs->eof ) {
		if ( $rs->row["name"] == "duration" and ( $rs->row["activ"] == 1 or $rs->row["always"] ==
			1 ) ) {
?>
					<div style="margin-bottom:9px"><b><?php
			echo pvs_word_lang( "duration" )?>:</b><br><?php
			echo pvs_duration_form( 0, "duration" . $i )?></div>
					<?php
		}

		if ( $rs->row["name"] == "track format" and ( $rs->row["activ"] == 1 or $rs->
			row["always"] == 1 ) ) {
?>
					<div style="margin-bottom:9px"><b><?php
			echo pvs_word_lang( "track format" )?>:</b><br>
					<select name="format<?php
			echo $i
?>" style="width:150px">
						<option value="">...</option>
						<?php
			$sql = "select * from " . PVS_DB_PREFIX . "audio_format";
			$dr->open( $sql );
			while ( ! $dr->eof )
			{
?>
							<option value="<?php
				echo $dr->row["name"] ?>"><?php
				echo $dr->row["name"] ?></option>
							<?php
				$dr->movenext();
			}
?>
					</select>
					</div>
					<?php
		}

		if ( $rs->row["name"] == "track source" and ( $rs->row["activ"] == 1 or $rs->
			row["always"] == 1 ) ) {
?>
					<div style="margin-bottom:9px"><b><?php
			echo pvs_word_lang( "track source" )?>:</b><br>
					<select name="source<?php
			echo $i
?>" style="width:150px">
						<option value="">...</option>
						<?php
			$sql = "select * from " . PVS_DB_PREFIX . "audio_source";
			$dr->open( $sql );
			while ( ! $dr->eof )
			{
?>
							<option value="<?php
				echo $dr->row["name"] ?>"><?php
				echo $dr->row["name"] ?></option>
							<?php
				$dr->movenext();
			}
?>
					</select>
					</div>
					<?php
		}

		if ( $rs->row["name"] == "copyright holder" and ( $rs->row["activ"] == 1 or $rs->
			row["always"] == 1 ) ) {
?>
					<div style="margin-bottom:9px"><b><?php
			echo pvs_word_lang( "copyright holder" )?>:</b><br><input name="holder<?php
			echo $i
?>" value="" type="text" style="width:150px"></div>
					<?php
		}
		$rs->movenext();
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