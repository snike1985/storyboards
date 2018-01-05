<?php
/***************************************************************************
*                                                                         																*
*   Copyright (c) 2006-2017 CMSaccount Inc. All rights reserved.     	   									*
*                                                                         																*
*   Photo Video Store script is a commercial software. Any distribution is strictly prohibited.     * 						   
*																																		*					  
*   Website: https://www.cmsaccount.com/																			*				  
*   E-mail: sales@cmsaccount.com  																					*					   
*   Support: https://www.cmsaccount.com/forum/	                          									*
*                                                                       															    *
****************************************************************************/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Build categorie table - /admin/categories/
function pvs_build_menu_admin_categories( $t_id, $otstup )
{
	global $db;
	$dp = new TMySQLQuery;
	$dp->connection = $db;
	$dt = new TMySQLQuery;
	$dt->connection = $db;
	global $itg;
	global $nlimit;
	global $_COOKIE;

	$sql = "select id, id_parent, title, priority,photo from " . PVS_DB_PREFIX .
		"category where id_parent=" . $t_id . "  order by priority,title";
	$dp->open( $sql );
	while ( ! $dp->eof )
	{
		if ( $nlimit < 1000 )
		{
			//padding-left
			$otp = "";
			for ( $i = 0; $i < $otstup; $i++ )
			{
				$otp .= "&nbsp;&nbsp;";
			}

			//If included subcategories exist
			$zp = false;
			$sql = "select id, id_parent, title, priority from " . PVS_DB_PREFIX .
				"category where id_parent=" . $dp->row["id"];
			$dt->open( $sql );
			if ( ! $dt->eof )
			{
				$zp = true;
			}

			//if parent closed
			$vis = "";
			if ( isset( $_COOKIE["sub_" . $dp->row["id_parent"]] ) and ( int )$_COOKIE["sub_" .
				$dp->row["id_parent"]] == 0 )
			{
				$vis = "style='display:none'";
			}

			//Plus-minus icon
			$img_marker = "minus";

			if ( isset( $_COOKIE["sub_" . $dp->row["id"]] ) and ( int )$_COOKIE["sub_" . $dp->
				row["id"]] == 0 )
			{
				$img_marker = "plus";
			}

			if ( $zp )
			{
				$img = "<a href='javascript:subopen(" . $dp->row["id"] . ");'><img id='plus" . $dp->
					row["id"] . "' src='" . pvs_plugins_url() . "/includes/admin/includes/img/" . $img_marker .
					".gif'  style='width:13px;height:13px' border='0'></a>&nbsp;";
			} else
			{
				$img = "<img src='" . pvs_plugins_url() .
					"/includes/admin/includes/img/e.gif' style='width:13px;height:13px' border='0'>&nbsp;";
			}

			$photo = '';
			if ( $dp->row["photo"] != '' and file_exists( pvs_upload_dir() . $dp->row["photo"] ) )
			{
				$photo = '<img src="' . pvs_upload_dir( 'baseurl' ) . $dp->row["photo"] .
					'" style="max-width:80px;max-height:80px">';
			}

			$itg .= "<tr id='row" . $dp->row["id"] . "' " . $vis . ">
		<td><input type='checkbox' id='sel" . $dp->row["id"] . "' name='sel" . $dp->
				row["id"] . "'></td>
		<td>" . $photo . "</td>
		<td><input type='text' name='priority" . $dp->row["id"] . "' value='" . $dp->
				row["priority"] . "' style='width:40px'></td>
		<td nowrap width='80%'>" . $otp . $img . "<a href='" . pvs_plugins_admin_url( 'categories/index.php' ) .
				"&action=content&id=" . $dp->row["id"] . "'>" . $dp->row["title"] . "</a></td>
		<td><div class='link_edit'><a href='" . pvs_plugins_admin_url( 'categories/index.php' ) .
				"&action=content&id=" . $dp->row["id"] . "'>" . pvs_word_lang( "edit" ) .
				"</a></div></td>
		<td><div class='link_delete'><a href='" . pvs_plugins_admin_url( 'categories/index.php' ) .
				"&action=delete&id=" . $dp->row["id"] . "' onClick=\"return confirm('" .
				pvs_word_lang( "delete" ) . "?');\">" . pvs_word_lang( "delete" ) .
				"</a></div></td>
		</tr>";

			pvs_build_menu_admin_categories( $dp->row["id"], $otstup + 2 );
		}
		$nlimit++;
		$dp->movenext();
	}
}

//Select fields for date
function pvs_admin_date( $data, $field )
{
	$res = "";
	global $m_month;

	$res .= "<table border='0' cellpadding='0' cellspacing='0'>
	<tr valign='top'>
	<td><select name='" . $field .
		"_day' style='width:70px;margin-right:5px' class='ibox form-control'>";

	for ( $j = 1; $j < 32; $j++ )
	{
		if ( $j < 10 )
		{
			$ji = "0" . $j;
		} else
		{
			$ji = $j;
		}

		$sel = "";
		if ( date( "d", $data ) == $j )
		{
			$sel = "selected";
		}

		$res .= "<option value='" . $j . "' " . $sel . ">" . $ji . "</option>";
	}

	$res .= "</select>&nbsp;</td>
	<td><select name='" . $field .
		"_month' style='width:120px;margin-right:5px' class='ibox form-control'>";

	for ( $j = 0; $j < 12; $j++ )
	{
		$sel = "";
		if ( date( "m", $data ) == $j + 1 )
		{
			$sel = "selected";
		}

		$res .= "<option value='" . ( $j + 1 ) . "' " . $sel . ">" . pvs_word_lang( strtolower
			( $m_month[$j] ) ) . "</option>";
	}

	$res .= "</select>&nbsp;</td>
	<td><select name='" . $field .
		"_year' style='width:90px;margin-right:15px' class='ibox form-control'>";

	for ( $j = date( "Y" ) - 5; $j < date( "Y" ) + 15; $j++ )
	{
		$sel = "";
		if ( date( "Y", $data ) == $j )
		{
			$sel = "selected";
		}

		$res .= "<option value='" . $j . "' " . $sel . ">" . $j . "</option>";
	}

	$res .= "</select>&nbsp;&nbsp;</td>
	<td><select name='" . $field .
		"_hour' style='width:70px;margin-right:5px' class='ibox form-control'>";

	for ( $j = 0; $j < 24; $j++ )
	{
		if ( $j < 10 )
		{
			$ji = "0" . $j;
		} else
		{
			$ji = $j;
		}

		$sel = "";
		if ( date( "G", $data ) == $j )
		{
			$sel = "selected";
		}

		$res .= "<option value='" . $j . "' " . $sel . ">" . $ji . "</option>";
	}

	$res .= "</select></td>
	<td><select name='" . $field .
		"_minute' style='width:70px;margin-right:5px' class='ibox form-control'>";

	for ( $j = 0; $j < 60; $j++ )
	{
		if ( $j < 10 )
		{
			$ji = "0" . $j;
		} else
		{
			$ji = $j;
		}

		$sel = "";
		if ( date( "i", $data ) == $j )
		{
			$sel = "selected";
		}

		$res .= "<option value='" . $j . "' " . $sel . ">" . $ji . "</option>";
	}

	$res .= "</select></td>
	<td><select name='" . $field .
		"_second' style='width:70px' class='ibox form-control'>";

	for ( $j = 0; $j < 60; $j++ )
	{
		if ( $j < 10 )
		{
			$ji = "0" . $j;
		} else
		{
			$ji = $j;
		}

		$sel = "";
		if ( date( "s", $data ) == $j )
		{
			$sel = "selected";
		}

		$res .= "<option value='" . $j . "' " . $sel . ">" . $ji . "</option>";
	}

	$res .= "</select></td>
	</tr>
	</table>";

	return $res;
}

//The function builds a duration form
function pvs_duration_form( $data, $field )
{
	$res = "";

	$res .= "<table border='0' cellpadding='0' cellspacing='0'><tr>";
	$res .= "<td nowrap><select name='" . $field .
		"_hour' style='width:70px;margin-right:5px' class='ibox form-control'>";

	$form_hours = floor( $data / 3600 );
	$form_minutes = floor( ( $data - $form_hours * 3600 ) / 60 );
	$form_seconds = $data - $form_hours * 3600 - $form_minutes * 60;

	for ( $j = 0; $j < 100; $j++ )
	{
		if ( $j < 10 )
		{
			$ji = "0" . $j;
		} else
		{
			$ji = $j;
		}
		$sel = "";
		if ( $form_hours == $j )
		{
			$sel = "selected";
		}
		$res .= "<option value='" . $j . "' " . $sel . ">" . $ji . "</option>";
	}

	$res .= "</select></td><td nowrap><select name='" . $field .
		"_minute' style='width:70px;margin-right:5px' class='ibox form-control'>";

	for ( $j = 0; $j < 60; $j++ )
	{
		if ( $j < 10 )
		{
			$ji = "0" . $j;
		} else
		{
			$ji = $j;
		}
		$sel = "";
		if ( $form_minutes == $j )
		{
			$sel = "selected";
		}
		$res .= "<option value='" . $j . "' " . $sel . ">" . $ji . "</option>";
	}

	$res .= "</select></td><td><select name='" . $field .
		"_second' style='width:70px' class='ibox form-control'>";

	for ( $j = 0; $j < 60; $j++ )
	{
		if ( $j < 10 )
		{
			$ji = "0" . $j;
		} else
		{
			$ji = $j;
		}
		$sel = "";
		if ( $form_seconds == $j )
		{
			$sel = "selected";
		}
		$res .= "<option value='" . $j . "' " . $sel . ">" . $ji . "</option>";
	}

	$res .= "</select></td></tr></table>";
	return $res;
}
//End. The function builds a duration form

//Build rights-managed upload form
function pvs_rights_managed_upload_form( $type, $rights_managed, $id, $admin_session )
{
	global $ds;
	global $rs;
	global $dn;
	global $dd;
	global $file_form;
	global $pvs_global_settings;
	global $site_servers;
	global $site_server_activ;
	global $lphoto;
	global $lvideo;
	global $lpreviewvideo;
	global $laudio;
	global $lpreviewaudio;
	global $lvector;
	global $flag_jquery;
	$res = "";

	if ( ( $type == "video" and $pvs_global_settings["video_uploader"] ==
		"jquery uploader" ) or ( $type == "audio" and $pvs_global_settings["audio_uploader"] ==
		"jquery uploader" ) or ( $type == "vector" and $pvs_global_settings["vector_uploader"] ==
		"jquery uploader" ) )
	{
		pvs_create_temp_folder();
	}

	$sql = "select * from " . PVS_DB_PREFIX . "rights_managed where " . $type . "=1";
	$ds->open( $sql );
	if ( ! $ds->eof )
	{
		$res .= "<table border='0' cellpadding='5' cellspacing='1' class='profile_table table table-striped table-hover'>";
		if ( $file_form )
		{
			$res .= "<tr>
			<th colspan=2><b>" . pvs_word_lang( "file" ) . ":</b></th>
			</tr>";

			$res .= "<tr class='snd'>
			<td colspan='2'>";

			if ( ( $type == "photo" and $pvs_global_settings["photo_uploader"] ==
				"usual uploader" ) or ( $type == "video" and $pvs_global_settings["video_uploader"] ==
				"usual uploader" ) or ( $type == "audio" and $pvs_global_settings["audio_uploader"] ==
				"usual uploader" ) or ( $type == "vector" and $pvs_global_settings["vector_uploader"] ==
				"usual uploader" ) )
			{
				$res .= "<input name='video_rights' type='file' style='width:400px' class='ibox form-control'>";
			}

			if ( ( $type == "photo" and $pvs_global_settings["photo_uploader"] ==
				"jquery uploader" ) or ( $type == "video" and $pvs_global_settings["video_uploader"] ==
				"jquery uploader" ) or ( $type == "audio" and $pvs_global_settings["audio_uploader"] ==
				"jquery uploader" ) or ( $type == "vector" and $pvs_global_settings["vector_uploader"] ==
				"jquery uploader" ) )
			{
				$res .= "<span class=\"btn btn-success fileinput-button\">
        					<i class=\"icon-plus icon-white\" style=\"float:left\"></i> " .
					pvs_word_lang( "select files" ) . "...
        					<!-- The file input field used as target for the file upload widget -->
        					<input type=\"file\" name=\"files[]\" onClick='change_bar(100)'>
        					<input type=\"hidden\" id='file_sale100' name='file_sale100' value=''>
    					</span>
    					<div class='progress' style=\"margin-top:15px\">
						  <div  id=\"bar100\" class='bar progress-bar progress-bar-info progress-bar-striped' role='progressbar' style='width: 0%'>
							<span class='sr-only'></span>
						  </div>
						</div>
    					<div id=\"files100\" class=\"files\"></div>
    					";

			}

			$res .= "</td>
			</tr>";

			if ( $type == "photo" )
			{
				$res .= "<tr>
				<td colspan='2'>" . pvs_word_lang( "use iptc info" ) . ": <input name='" . $type .
					"_iptc_rights' type='checkbox' checked></td>
				</tr>";
			}
		}

		$res .= "<tr>
			<th style='width:70%'><b>" . pvs_word_lang( "price" ) . ":</b></th>
			<th><b>" . pvs_word_lang( "type" ) . ":</b></th>
			</tr>";

		if ( $rights_managed == 0 )
		{
			$sel = "checked";
		} else
		{
			$sel = "";
		}

		$filetypes2 = "jpe?g|mp4|flv|zip|mp3";
		$sql = "select * from " . PVS_DB_PREFIX . "rights_managed where " . $type . "=1";
		$rs->open( $sql );
		while ( ! $rs->eof )
		{
			if ( $rights_managed != 0 and $rights_managed == $rs->row["id"] )
			{
				$sel = "checked";
			}

			$res .= "<tr><td><input type='radio' name='rights_id' value='" . $rs->row["id"] .
				"' " . $sel . ">&nbsp;" . $rs->row["title"] . "</td><td>" . $rs->row["formats"] .
				"</td></tr>";

			if ( $sel == "checked" )
			{
				$sel = "";
			}

			$filetypes2 .= "|" . str_replace( ",", "|", str_replace( " ", "", strtolower( $rs->
				row["formats"] ) ) );

			$rs->movenext();
		}

		if ( ( $type == "photo" and $pvs_global_settings["photo_uploader"] ==
			"jquery uploader" ) or ( $type == "video" and $pvs_global_settings["video_uploader"] ==
			"jquery uploader" ) or ( $type == "audio" and $pvs_global_settings["audio_uploader"] ==
			"jquery uploader" ) or ( $type == "vector" and $pvs_global_settings["vector_uploader"] ==
			"jquery uploader" ) )
		{
			if ( ! $flag_jquery )
			{
				if ( $admin_session )
				{
					$filelimit = 1000000;
				} else
				{
					if ( $type == "photo" )
					{
						$filelimit = $lphoto;
					}
					if ( $type == "video" )
					{
						$filelimit = $lvideo;
					}
					if ( $type == "audio" )
					{
						$filelimit = $laudio;
					}
					if ( $type == "vector" )
					{
						$filelimit = $lvector;
					}
				}

				if ( ! isset( $filetypes ) or $filetypes == "" )
				{
					$filetypes = $filetypes2;
				}
				if ( ! $flag_jquery )
				{
					$res .= pvs_get_jquery_uploader_code( $filelimit, $filetypes );
					$flag_jquery = true;
				}
			}
		}

		if ( $id != 0 )
		{
			//Define server
			$server1 = $site_server_activ;
			$sql = "select server1 from " . PVS_DB_PREFIX . "media where id=" . ( int ) $id;
			$dd->open( $sql );
			if ( ! $dd->eof )
			{
				$server1 = $dd->row["server1"];
			}

			$sql = "select url,shipped from " . PVS_DB_PREFIX . "items where id_parent=" . ( int )
				$id . " and price_id=" . $rights_managed;
			$dd->open( $sql );
			if ( ! $dd->eof )
			{
				if ( $dd->row["shipped"] != 1 )
				{
					$remote_filesize = 0;
					$flag_storage = false;
					$remote_file = "";

					$sql = "select url,filename1,filename2,width,height,item_id,filesize from " .
						PVS_DB_PREFIX . "filestorage_files where id_parent=" . ( int )$id .
						" and filename1='" . $dd->row["url"] . "'";
					$dn->open( $sql );
					if ( ! $dn->eof )
					{
						$flag_storage = true;
						$remote_filesize = $dn->row["filesize"];
						$remote_file = $dn->row["url"] . "/" . $dn->row["filename2"];
					}

					if ( ! $flag_storage )
					{

						$url = $site_servers[$server1] . "/" . ( int )$id . "/" . $dd->row["url"];
						if ( file_exists( pvs_upload_dir() . $url ) )
						{
							if ( $type != "photo" )
							{
								$res .= "<tr><td colspan='2'><a href='" . pvs_upload_dir('baseurl') . $url .
									"' class='btn btn-default'><i class='icon-download fa fa-download'></i> " .
									pvs_word_lang( "download" ) . " " . $dd->row["url"] .
									"</a><div style='margin:7px 0px 0px 12px'>" . pvs_price_format( ( filesize( pvs_upload_dir() .
									$url ) / 1024 ), 2 ) . "Kb.</div></td></tr>";
							} else
							{
								$res .= "<tr><td colspan='2'><div><a href='" . pvs_upload_dir('baseurl') . $url .
									"' class='btn btn-default'><i class='icon-download fa fa-download'></i> " .
									pvs_word_lang( "download" ) . " " . $dd->row["url"] .
									"</a><div style='margin:7px 0px 0px 12px'>" . pvs_get_exif( pvs_upload_dir() .
									$url, false, ( int )$id ) . "</div></div></td></tr>";
							}
						}
					} else
					{
						if ( $type != "photo" )
						{
							$res .= "<tr><td colspan='2'><a href='" . $remote_file .
								"' class='btn'><i class='icon-download'></i> " . pvs_word_lang( "download" ) .
								" " . $dd->row["url"] . "</a><div style='margin:7px 0px 0px 12px'>" .
								pvs_price_format( ( $remote_filesize / 1024 ), 2 ) . "Kb.</div>";
						} else
						{
							$res .= "<tr><td colspan='2'><div style='margin-top:2px'><a href='" . $remote_file .
								"' class='btn'><i class='icon-download'></i> " . pvs_word_lang( "download" ) .
								" " . $dd->row["url"] . "</a><div style='margin:7px 0px 0px 12px'>[" .
								pvs_price_format( ( $remote_filesize / 1024 ), 2 ) .
								"Kb.]</div></div></td></tr>";
						}
					}
				}
			}
		}

		$res .= pvs_get_preview_form( $type, true );

		$res .= "</table>";
	} else
	{
		$res .= "<div style='padding:20px;width:630px'>There are no available rights-managed prices for <b>" .
			$type . "</b>.</div>";
	}
	return $res;
}
//End rights-managed upload form

//The function creates temp folder for jquery uploader
function pvs_create_temp_folder()
{
	$tmp_folder = "user_" . get_current_user_id();

	if ( file_exists( pvs_upload_dir() . "/content/" . $tmp_folder ) )
	{
		pvs_remove_files_from_folder( $tmp_folder );
	} else
	{
		mkdir( pvs_upload_dir() . "/content/" . $tmp_folder );
	}
}
//End. The function creates temp folder for jquery uploader

//Build photo upload form
function pvs_photo_upload_form( $id, $admin_session )
{
	global $ds;
	global $rs;
	global $dr;
	global $dd;
	global $dn;
	global $file_form;
	global $pvs_global_settings;
	global $lphoto;
	global $site_server_activ;
	global $site_servers;
	global $flag_jquery;

	$res = "";
	$filetypes = "jpe?g|png|gif|raw|tif?f|eps";

	$photo_formats = array();
	$sql = "select id,photo_type from " . PVS_DB_PREFIX .
		"photos_formats where enabled=1 order by id";
	$dr->open( $sql );
	while ( ! $dr->eof )
	{
		$photo_formats[$dr->row["id"]] = $dr->row["photo_type"];
		$dr->movenext();
	}

	if ( $pvs_global_settings["rights_managed"] == 1 )
	{
		$sql = "select formats from " . PVS_DB_PREFIX . "rights_managed";
		$dr->open( $sql );
		while ( ! $dr->eof )
		{
			$filetypes .= "|" . str_replace( ",", "|", str_replace( " ", "", strtolower( $dr->
				row["formats"] ) ) );
			$dr->movenext();
		}
	}

	$server1 = $site_server_activ;
	$rurl = "";
	if ( $id != 0 and pvs_is_user_admin () )
	{
		$sql = "select server1,url_jpg,url_png,url_gif,url_raw,url_tiff,url_eps from " .
			PVS_DB_PREFIX . "media where id=" . ( int )$id;
		$dd->open( $sql );
		if ( ! $dd->eof )
		{
			$server1 = $dd->row["server1"];
			foreach ( $photo_formats as $key => $value )
			{
				if ( $dd->row["url_" . $value] != "" )
				{
					$remote_filesize = 0;
					$flag_storage = false;
					$remote_file = "";

					$sql = "select url,filename1,filename2,width,height,item_id,filesize from " .
						PVS_DB_PREFIX . "filestorage_files where id_parent=" . ( int )$id .
						" and filename1='" . $dd->row["url_" . $value] . "'";
					$dn->open( $sql );
					if ( ! $dn->eof )
					{
						$flag_storage = true;
						$remote_filesize = $dn->row["filesize"];
						$remote_file = $dn->row["url"] . "/" . $dn->row["filename2"];
					}

					if ( ! $flag_storage )
					{
						$url = $site_servers[$server1] . "/" . ( int )$id . "/" . $dd->row["url_" .
							$value];

						$size = @getimagesize( pvs_upload_dir() . $url );
						$file_details = "";

						if ( $size[0] != "" and $size[1] != "" )
						{
							$file_details = $size[0] . "x" . $size[1] . "px&nbsp;@&nbsp;";
						}
						$file_details .= pvs_price_format( filesize( pvs_upload_dir() . $url ) /
							( 1024 * 1024 ), 2 ) . "Mb.";

						$rurl .= "<div style='margin-bottom:20px'><a href='" . pvs_upload_dir('baseurl') . $url .
							"' class='btn btn-default'><i class='icon-download fa  fa-download'></i> " .
							pvs_word_lang( "download" ) . " <b>" . $dd->row["url_" . $value] .
							"</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>[" . $file_details . "]</small></a> ";

						if ( pvs_is_user_admin () )
						{
							$rurl .= "<a href='" . pvs_plugins_admin_url('catalog/index.php') . "&action=photo_delete&id=" . ( int )$id . "&file=" . $value .
								"' class='btn btn-danger'><i class='icon-remove icon-white'></i> " .
								pvs_word_lang( "delete" ) . "</a>";
						}
						$rurl .= "</div>";
					} else
					{
						$rurl .= "<div style='margin-bottom:20px'><a href='" . $remote_file .
							"' class='btn btn-default'><i class='icon-download fa fa-download'></i> " .
							pvs_word_lang( "download" ) . " " . $dd->row["url_" . $value] . " <small>[" .
							pvs_price_format( ( $remote_filesize / 1024 ), 2 ) . "Kb.]</small></a> ";

						if ( pvs_is_user_admin () )
						{
							$rurl .= "<a href='photo_delete.php?id=" . ( int )$id . "&file=" . $value .
								"' class='btn btn-danger'><i class='icon-remove icon-white'></i> " .
								pvs_word_lang( "delete" ) . "</a>";
						}
						$rurl .= "</div>";
					}
				}
			}
		}
	}

	$res .= "<table border='0' cellpadding='5' cellspacing='1' class='profile_table table table-striped table-hover'>";
	if ( $file_form )
	{
		$res .= "<tr class='snd'>
			<td colspan='5'>";

		if ( $pvs_global_settings["photo_uploader"] == "usual uploader" )
		{
			foreach ( $photo_formats as $key => $value )
			{
				$margin = "20";
				if ( $value == "jpg" )
				{
					$margin = "0";
				}

				$res .= "<div style='margin-top:" . $margin . "px'><b>" . strtoupper( $value ) .
					":</b><br><input name='photo_" . strtolower( $value ) .
					"' type='file' style='width:400px' class='ibox form-control'></div>";
			}
		}

		if ( $pvs_global_settings["photo_uploader"] == "jquery uploader" )
		{
			foreach ( $photo_formats as $key => $value )
			{
				$margin = "20";
				if ( $value == "jpg" )
				{
					$margin = "0";
				}

				$res .= "<div style='margin-top:" . $margin . "px'><b>" . strtoupper( $value ) .
					":</b><br><span class=\"btn btn-success fileinput-button\">
        					<i class=\"icon-plus icon-white\" style=\"float:left\"></i> " .
					pvs_word_lang( "select files" ) . "...
        					<!-- The file input field used as target for the file upload widget -->
        					<input type=\"file\" name=\"files[]\" onClick='change_bar(" . $key .
					")'>
        					<input type=\"hidden\" id='file_sale" . $key . "' name='file_sale" .
					$key . "' value=''>
    					</span>
    					<div class='progress'>
						  <div  id=\"bar" . $key . "\" class='bar progress-bar progress-bar-info progress-bar-striped' role='progressbar' style='width: 0%'>
							<span class='sr-only'></span>
						  </div>
						</div>
    					<div id=\"files" . $key . "\" class=\"files\"></div></div>
    					";
			}
		}

		$res .= "</td>
			</tr>";

		if ( $rurl != "" )
		{
			$res .= "<tr>
				<td colspan='5'>" . $rurl . "</td>
				</tr>";
		}

		$res .= "<tr>
			<td colspan='5'>" . pvs_word_lang( "use iptc info" ) .
			": <input name='photo_iptc' type='checkbox' checked></td>
			</tr>";
	}
	if ( ! $pvs_global_settings["printsonly"] )
	{
		$res .= "<tr>
			<th>" . pvs_word_lang( "enabled" ) . ":</th>
			<th><b>" . pvs_word_lang( "title" ) . ":</b></th>
			<th><b>" . pvs_word_lang( "file types" ) . ":</b></th>
			<th><b>Max " . pvs_word_lang( "width" ) . "/" . pvs_word_lang( "height" ) .
			":</b></th>
			<th><b>" . pvs_word_lang( "price" ) . ":</b></th>
			</tr>";

		$sql = "select id_parent,name from " . PVS_DB_PREFIX .
			"licenses order by priority";
		$ds->open( $sql );
		while ( ! $ds->eof )
		{
			$res .= "<tr class='snd'><td colspan='5'><b>" . pvs_word_lang( "license" ) .
				": </b>" . $ds->row["name"] . "</td></tr>";

			$sql = "select id_parent,size,title,price,jpg,png,gif,raw,tiff,eps from " .
				PVS_DB_PREFIX . "sizes where license=" . $ds->row["id_parent"] .
				" order by priority";
			$rs->open( $sql );
			while ( ! $rs->eof )
			{
				$price = $rs->row["price"];
				$title = $rs->row["title"];
				$checked = "";

				if ( $id != 0 )
				{
					$sql = "select price,name from " . PVS_DB_PREFIX . "items where id_parent=" . ( int )
						$id . " and price_id=" . $rs->row["id_parent"];
					$dd->open( $sql );
					if ( ! $dd->eof )
					{
						$price = $dd->row["price"];
						$title = $dd->row["name"];
						$checked = "checked";
					}
				} else
				{
					$checked = "checked";
				}

				$readonly = "readonly";
				if ( $admin_session or $pvs_global_settings["seller_prices"] )
				{
					$readonly = "";
				}

				$res .= "<tr>
					<td><input name='photo_chk" . $rs->row["id_parent"] . "' type='checkbox' " .
					$checked . "></td>";
				//$res.="<td><b>".$rs->row["title"]."</b></td>";
				$res .= "<td><input  name='title" . $rs->row["id_parent"] . "' value='" . $title .
					"' type='text' class='ibox form-control'  style='width:150px' " . $readonly .
					"></td>";
				$res .= "<td>";

				$formats = "";
				foreach ( $photo_formats as $key => $value )
				{
					if ( $rs->row[$value] == 1 )
					{
						if ( $formats != "" )
						{
							$formats .= ", ";
						}
						$formats .= strtoupper( $value );
					}
				}
				$res .= $formats;

				$res .= "</td>
					<td>";

				if ( $rs->row["size"] != 0 )
				{
					$res .= $rs->row["size"] . "px";
				} else
				{
					$res .= pvs_word_lang( "Original size" );
				}

				$res .= "</td>
					<td><input name='photo_price" . $rs->row["id_parent"] . "' value='" .
					pvs_price_format( $price, 2 ) . "' type='text' style='width:60px' " . $readonly .
					" class='ibox form-control'></td>
					</tr>";

				$rs->movenext();
			}
			$ds->movenext();
		}
	}

	$res .= "</table>";

	if ( $pvs_global_settings["photo_uploader"] == "jquery uploader" )
	{
		$filelimit = $lphoto;
		if ( $admin_session )
		{
			$filelimit = 1000;
		}

		if ( ! $flag_jquery )
		{
			$res .= pvs_get_jquery_uploader_code( $filelimit, $filetypes );
			$flag_jquery = true;
		}
	}

	return $res;
}
//End photo upload form

//Build video,audio,vector upload form
function pvs_files_upload_form( $id, $type, $admin_session )
{
	global $ds;
	global $dr;
	global $dd;
	global $dn;
	global $dq;
	global $pvs_global_settings;
	global $flag_jquery;
	global $site_servers;
	global $site_server_activ;
	global $lvideo;
	global $lpreviewvideo;
	global $laudio;
	global $lpreviewaudio;
	global $lvector;

	$badge_colors = array();

	$random_colors = array(
		"#d83838",
		"#5e9de4",
		"#fd7405",
		"#f7e40d",
		"#30b716",
		"#4dc717",
		"#77480b",
		"#b80cc7",
		"#22aa9f",
		"#f4a445",
		"56b5d8" );
	$random_colors_number = 0;

	$res = "";

	if ( ( $type == "video" and $pvs_global_settings["video_uploader"] ==
		"jquery uploader" ) or ( $type == "audio" and $pvs_global_settings["audio_uploader"] ==
		"jquery uploader" ) or ( $type == "vector" and $pvs_global_settings["vector_uploader"] ==
		"jquery uploader" ) )
	{
		pvs_create_temp_folder();
	}

	if ( $type == "video" )
	{
		$filetypes = "jpe?g|mp4|flv";
	}

	if ( $type == "audio" )
	{
		$filetypes = "jpe?g|mp3";
	}

	if ( $type == "vector" )
	{
		$filetypes = "jpe?g|zip";
	}

	if ( $pvs_global_settings["rights_managed"] == 1 )
	{
		$sql = "select formats from " . PVS_DB_PREFIX . "rights_managed";
		$dr->open( $sql );
		while ( ! $dr->eof )
		{
			$filetypes .= "|" . str_replace( ",", "|", str_replace( " ", "", strtolower( $dr->
				row["formats"] ) ) );
			$dr->movenext();
		}
	}

	$res .= "<table border='0' cellpadding='5' cellspacing='1' class='profile_table table table-striped table-hover'>";

	$res .= "
	<tr>
	<th></td>
	<th><b>" . pvs_word_lang( "title" ) . ":</b></th>
	<th><b>" . pvs_word_lang( "price" ) . ":</b></th>
	<th><b>" . pvs_word_lang( "file" ) . ":</b></th>
	</tr>";

	$sql = "select id_parent,name from " . PVS_DB_PREFIX .
		"licenses order by priority";
	$dr->open( $sql );
	while ( ! $dr->eof )
	{
		$res .= "<tr class='snd'><td colspan='4'><b>" . pvs_word_lang( "license" ) .
			": </b>" . $dr->row["name"] . "</td></tr>";

		if ( $type == "video" )
		{
			$sql = "select * from " . PVS_DB_PREFIX . "video_types where license=" . $dr->
				row["id_parent"] . " order by priority";
		}
		if ( $type == "audio" )
		{
			$sql = "select * from " . PVS_DB_PREFIX . "audio_types where license=" . $dr->
				row["id_parent"] . " order by priority";
		}
		if ( $type == "vector" )
		{
			$sql = "select * from " . PVS_DB_PREFIX . "vector_types where license=" . $dr->
				row["id_parent"] . " order by priority";
		}
		$ds->open( $sql );
		while ( ! $ds->eof )
		{
			$price = $ds->row["price"];
			$title = $ds->row["title"];
			$uploaded_file = "";
			$checked = "";

			if ( $id != 0 )
			{
				$sql = "select price,url,shipped,name from " . PVS_DB_PREFIX .
					"items where id_parent=" . ( int )$id . " and price_id=" . $ds->row["id_parent"];
				$dd->open( $sql );
				if ( ! $dd->eof )
				{
					$price = $dd->row["price"];
					$title = $dd->row["name"];
					$checked = "checked";

					if ( $dd->row["shipped"] != 1 )
					{
						//Define server
						$server1 = $site_server_activ;

						$sql = "select server1 from " . PVS_DB_PREFIX . "media where id=" . ( int ) $id;
						$dq->open( $sql );
						if ( ! $dq->eof )
						{
							$server1 = $dq->row["server1"];
						}

						$remote_filesize = 0;
						$flag_storage = false;
						$remote_file = "";

						$sql = "select url,filename1,filename2,width,height,item_id,filesize from " .
							PVS_DB_PREFIX . "filestorage_files where id_parent=" . ( int )$id .
							" and filename1='" . $dd->row["url"] . "'";
						$dn->open( $sql );
						if ( ! $dn->eof )
						{
							$flag_storage = true;
							$remote_filesize = $dn->row["filesize"];
							$remote_file = $dn->row["url"] . "/" . $dn->row["filename2"];
						}

						if ( ! $flag_storage )
						{
							$url = $site_servers[$server1] . "/" . ( int )$id . "/" . $dd->row["url"];
							if ( file_exists( pvs_upload_dir() . $url ) )
							{
								$uploaded_file = "<br><a href='" . pvs_upload_dir('baseurl') . $url .
									"' class='btn btn-default' style='margin:7px 0px 0px -12px'><i class='icon-download fa fa-download'></i> " .
									pvs_word_lang( "download" ) . " " . $dd->row["url"] . " - " . pvs_price_format( ( filesize
									( pvs_upload_dir() . $url ) / 1024 ), 2 ) . "Kb.</a>";
							}
						} else
						{
							$uploaded_file = "<br><a href='" . $remote_file .
								"' class='btn btn-default'><i class='icon-download fa fa-download'></i> " .
								pvs_word_lang( "download" ) . " " . $dd->row["url"] . " - " . pvs_price_format( ( $remote_filesize /
								1024 ), 2 ) . "Kb.</a>";
						}
					}
				}
			} else
			{
				$checked = "";
			}

			$res .= "<tr>
			<td><input name='" . $type . "_chk" . $ds->row["id_parent"] .
				"' type='checkbox' " . $checked . "></td>
			<td nowrap>";

			$badge = "";
			if ( $ds->row["thesame"] > 0 )
			{
				if ( isset( $badge_colors[$ds->row["thesame"]] ) )
				{
					$bcolor = $badge_colors[$ds->row["thesame"]];
				} else
				{
					if ( $random_colors_number > count( $random_colors ) - 1 )
					{
						$random_colors_number = 0;
					}
					$bcolor = $random_colors[$random_colors_number];
					$random_colors_number++;
					$badge_colors[$ds->row["thesame"]] = $bcolor;
				}

				$badge = "<span class='label' style='display:inline;background-color:" . $bcolor .
					";float:left;margin-right:5px'>&nbsp;&nbsp;</span> ";
			}

			$readonly = "readonly";
			if ( $admin_session or $pvs_global_settings["seller_prices"] )
			{
				$readonly = "";
			}

			$res .= $badge . "<input type='text' value='" . $title . "' name='title" . $ds->
				row["id_parent"] . "'  class='ibox form-control'  style='width:150px' " . $readonly .
				">";

			if ( $ds->row["shipped"] != 1 )
			{
				$res .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(";
				$uphoto = explode( ",", str_replace( " ", "", $ds->row["types"] ) );
				for ( $i = 0; $i < count( $uphoto ); $i++ )
				{
					if ( $i != 0 )
					{
						$res .= ",";
					}
					$res .= "*." . $uphoto[$i];
					$filetypes .= "|" . $uphoto[$i];
				}

				$res .= ")";
			}

			$res .= $uploaded_file;

			$res .= "</td>
			<td><input class='ibox form-control' name='" . $type . "_price" . $ds->row["id_parent"] .
				"' value='" . pvs_price_format( $price, 2 ) . "' type='text' " . $readonly .
				" style='width:70px'></td>
			<td>";

			if ( $ds->row["shipped"] != 1 )
			{
				if ( ( $type == "video" and $pvs_global_settings["video_uploader"] ==
					"usual uploader" ) or ( $type == "audio" and $pvs_global_settings["audio_uploader"] ==
					"usual uploader" ) or ( $type == "vector" and $pvs_global_settings["vector_uploader"] ==
					"usual uploader" ) )
				{
					$res .= "<input name='video_sale" . $ds->row["id_parent"] .
						"' type='file' style='width:200px' class='ibox form-control'>";
				}

				if ( ( $type == "video" and $pvs_global_settings["video_uploader"] ==
					"jquery uploader" ) or ( $type == "audio" and $pvs_global_settings["audio_uploader"] ==
					"jquery uploader" ) or ( $type == "vector" and $pvs_global_settings["vector_uploader"] ==
					"jquery uploader" ) )
				{
					$res .= "<span class=\"btn btn-success fileinput-button\">
        					<i class=\"icon-plus icon-white\" style=\"float:left\"></i> " .
						pvs_word_lang( "select files" ) . "...
        					<!-- The file input field used as target for the file upload widget -->
        					<input type=\"file\" name=\"files[]\" onClick='change_bar(" . $ds->
						row["id_parent"] . ")'>
        					<input type=\"hidden\" id='file_sale" . $ds->row["id_parent"] .
						"' name='file_sale" . $ds->row["id_parent"] . "' value=''>
    					</span>
    					<div class='progress'  style=\"margin-top:15px\">
						  <div  id=\"bar" . $ds->row["id_parent"] . "\" class='bar progress-bar progress-bar-info progress-bar-striped' role='progressbar' style='width: 0%'>
							<span class='sr-only'></span>
						  </div>
						</div>
    					<div id=\"files" . $ds->row["id_parent"] . "\" class=\"files\"></div>
    					";

				}
			} else
			{
				$res .= pvs_word_lang( "shipped" );
			}

			$res .= "</td>
			</tr>";

			$ds->movenext();
		}
		$dr->movenext();
	}

	if ( ( $type == "video" and $pvs_global_settings["video_uploader"] ==
		"jquery uploader" ) or ( $type == "audio" and $pvs_global_settings["audio_uploader"] ==
		"jquery uploader" ) or ( $type == "vector" and $pvs_global_settings["vector_uploader"] ==
		"jquery uploader" ) )
	{
		if ( $type == "video" )
		{
			$filelimit = $lvideo;
		}
		if ( $type == "audio" )
		{
			$filelimit = $laudio;
		}
		if ( $type == "vector" )
		{
			$filelimit = $lvector;
		}
		if ( $admin_session )
		{
			$filelimit = 100000;
		}

		if ( ! $flag_jquery )
		{
			$res .= pvs_get_jquery_uploader_code( $filelimit, $filetypes );
			$flag_jquery = true;
		}
	}

	$res .= pvs_get_preview_form( $type, false );

	if ( count( $badge_colors ) > 0 )
	{
		$res .= "<tr class='snd'><td colspan='4'>";

		foreach ( $badge_colors as $key => $value )
		{
			$res .= "<span class='label' style='display:inline;background-color:" . $value .
				";'>&nbsp;&nbsp;</span> ";
		}

		$res .= " &mdash; " . pvs_word_lang( "one color files are the same" ) .
			"</td></tr>";
	}

	$res .= "</table>";

	return $res;
}
//End video,audio,vector upload form

//The function update prices
function pvs_price_update( $id, $type )
{
	global $ds;
	global $dr;
	global $db;
	global $dd;
	global $site_servers;
	global $site_server_activ;

	if ( $type == "photo" )
	{
		$table_name = "sizes";
	}
	if ( $type == "video" )
	{
		$table_name = "video_types";
	}
	if ( $type == "audio" )
	{
		$table_name = "audio_types";
	}
	if ( $type == "vector" )
	{
		$table_name = "vector_types";
	}

	$sql = "select id_parent,name from " . PVS_DB_PREFIX .
		"licenses order by priority";
	$dr->open( $sql );
	while ( ! $dr->eof )
	{
		$sql = "select * from " . PVS_DB_PREFIX . $table_name . "  where license=" . $dr->
			row["id_parent"] . "  order by priority";
		$ds->open( $sql );
		while ( ! $ds->eof )
		{
			$sql = "select price,url,shipped from " . PVS_DB_PREFIX .
				"items where id_parent=" . ( int )$id . " and price_id=" . $ds->row["id_parent"];
			$dd->open( $sql );
			if ( ! $dd->eof )
			{
				if ( isset( $_POST[$type . "_chk" . $ds->row["id_parent"]] ) )
				{
					$sql = "update " . PVS_DB_PREFIX . "items set price=" . ( float )$_POST[$type .
						"_price" . $ds->row["id_parent"]] . ",name='" . pvs_result($_POST["title" . $ds->row["id_parent"]]) .
						"' where id_parent=" . ( int )$id . " and price_id=" . $ds->row["id_parent"];
					$db->execute( $sql );
				} else
				{
					$sql = "delete from " . PVS_DB_PREFIX . "items where id_parent=" . ( int )$id .
						" and price_id=" . $ds->row["id_parent"];
					$db->execute( $sql );

					if ( $dd->row["shipped"] != 1 )
					{
						if ( $type != "photo" )
						{
							$url = $site_servers[$site_server_activ] . "/" . ( int )$id . "/" .
								$dd->row["url"];
							if ( file_exists( pvs_upload_dir() . $url ) )
							{
								@unlink( pvs_upload_dir() . $url );
							}
						}
					}
				}
			} else
			{
				if ( $type == "photo" )
				{
					$photo_file = pvs_get_photo_file( $id );
					if ( $photo_file != "" and isset( $_POST[$type . "_chk" . $ds->row["id_parent"]] ) )
					{
						$sql = "insert into " . PVS_DB_PREFIX .
							"items (id_parent,name,url,price,priority,shipped,price_id) values (" . $id .
							",'" . pvs_result( @$_POST["title" . $ds->row["id_parent"]] ) . "','" . $photo_file .
							"'," . ( float )$_POST[$type . "_price" . $ds->row["id_parent"]] . "," . $ds->
							row["priority"] . ",0," . $ds->row["id_parent"] . ")";
						$db->execute( $sql );
					}
				}
			}

			$ds->movenext();
		}
		$dr->movenext();
	}
}
//End. The function update prices

//The function gets file name of the photo publication
function pvs_get_photo_file( $id )
{
	global $db;
	$dp = new TMySQLQuery;
	$dp->connection = $db;
	$photo_file = "";

	$sql = "select url from " . PVS_DB_PREFIX . "items where url<>'' and id_parent=" .
		$id;
	$dp->open( $sql );
	if ( ! $dp->eof )
	{
		$photo_file = $dp->row["url"];
	} else
	{
		$sql = "select server1 from " . PVS_DB_PREFIX . "media where id=" . ( int )
			$id;
		$dp->open( $sql );
		if ( ! $dp->eof )
		{
			$dir = opendir( pvs_upload_dir() . pvs_server_url( $dp->
				row["server1"] ) . "/" . $id );
			while ( $file = readdir( $dir ) )
			{
				if ( $file <> "." && $file <> ".." && $file <> ".DS_Store" )
				{
					if ( preg_match( "/.jpg$|.jpeg$/i", $file ) and ! preg_match( "/thumb/", $file ) and
						! preg_match( "/photo_[0-9]+/", $file ) )
					{
						$photo_file = $file;
					}
				}
			}
			closedir( $dir );
		}
	}

	return $photo_file;
}
//End. The function gets file name of the photo publication

//Build prints upload form
function pvs_prints_upload_form()
{
	global $ds;
	global $dr;
	global $pvs_global_settings;
	$res = "";

	$res .= "<script>function change_quantity(print,value)
	{
		if(value == -1)
		{
			$('#quantity'+print).css('display','none');
		}
		else
		{
			$('#quantity'+print).css('display','block');
		}
	}</script>
	<table border='0' cellpadding='5' cellspacing='1' class='profile_table table table-striped table-hover'>
	<tr>
	<th></th>
	<th><b>" . pvs_word_lang( "title" ) . ":</b></th>
	<th><b>" . pvs_word_lang( "price" ) . ":</b></th>";

	if ( pvs_is_user_admin () or $pvs_global_settings["seller_prints_quantity"] )
	{
		$res .= "<th>" . pvs_word_lang( "In stock" ) . "</th>";
	}

	$res .= "</tr>";

	$sql = "select id,title from " . PVS_DB_PREFIX .
		"prints_categories where active=1 order by priority";
	$dr->open( $sql );
	while ( ! $dr->eof )
	{
		$res .= "<tr><th colspan='4'>" . $dr->row["title"] . "</th></tr>";

		$sql = "select id_parent,title,price,priority,in_stock from " . PVS_DB_PREFIX .
			"prints where photo=1 and category=" . $dr->row["id"] . " order by priority";
		$ds->open( $sql );
		while ( ! $ds->eof )
		{
			$readonly = "readonly";
			if ( pvs_is_user_admin () )
			{
				$readonly = "";
			}

			$res .= "<tr>
			<td><input name='prints_chk" . $ds->row["id_parent"] .
				"' type='checkbox' checked></td>
			<td>" . $ds->row["title"] . "</td>
			<td><input class='ibox form-control' name='prints_price" . $ds->row["id_parent"] .
				"' value='" . pvs_price_format( $ds->row["price"], 2 ) . "' type='text' " . $readonly .
				" style='width:100px'></td>";

			if ( pvs_is_user_admin () or $pvs_global_settings["seller_prints_quantity"] )
			{

				if ( $ds->row["in_stock"] == -1 )
				{
					$sel1 = 'selected';
					$sel2 = '';
					$quantity = 0;
					$style = 'none';
				} else
				{
					$sel1 = '';
					$sel2 = 'selected';
					$quantity = $ds->row["in_stock"];
					$style = 'block';
				}

				$res .= "<td><select id='quantity_type" . $ds->row["id_parent"] .
					"' name='quantity_type" . $ds->row["id_parent"] .
					"' class='form-control' onChange=\"change_quantity(" . $ds->row["id_parent"] .
					",this.value)\" style='width:150px'>
							<option value='-1' " . $sel1 . ">" . pvs_word_lang( "Unlimited" ) .
					"</option>
							<option value='0' " . $sel2 . ">" . pvs_word_lang( "Value" ) . "</option>
							</select>
							<input type='text'  id='quantity" . $ds->row["id_parent"] .
					"' name='quantity" . $ds->row["id_parent"] . "' value='" . $quantity .
					"'  style='width:150px;margin-top:3px;display:" . $style .
					"' class='form-control'></td>";
			}

			$res .= "</tr>";
			$ds->movenext();
		}
		$dr->movenext();
	}

	$res .= "</table>";

	return $res;
}
//End prints upload form

//Build a table of current prints for the ID
function pvs_prints_live( $id )
{
	global $dd;
	global $ds;
	global $dr;
	global $pvs_global_settings;

	$res = "<script>function change_quantity(print,value)
	{
		if(value == -1)
		{
			$('#quantity'+print).css('display','none');
		}
		else
		{
			$('#quantity'+print).css('display','block');
		}
	}</script>
	<table border='0' cellpadding='5' cellspacing='1' class='profile_table table table-striped table-hover'>
	<tr>
	<th></th>
	<th><b>" . pvs_word_lang( "title" ) . ":</b></th>
	<th><b>" . pvs_word_lang( "price" ) . ":</b></th>";

	if ( pvs_is_user_admin () or $pvs_global_settings["seller_prints_quantity"] )
	{
		$res .= "<th>" . pvs_word_lang( "In stock" ) . "</th>";
	}

	$res .= "</tr>";

	$sql = "select id,title from " . PVS_DB_PREFIX .
		"prints_categories where active=1 order by priority";
	$dd->open( $sql );
	while ( ! $dd->eof )
	{
		$res .= "<tr><th colspan='4'>" . $dd->row["title"] . "</th></tr>";

		$sql = "select id_parent,title,price,priority,in_stock from " . PVS_DB_PREFIX .
			"prints where photo=1 and category=" . $dd->row["id"] . " order by priority";
		$ds->open( $sql );
		while ( ! $ds->eof )
		{
			$checked = "";
			$price = $ds->row["price"];

			if ( $ds->row["in_stock"] == -1 )
			{
				$sel1 = 'selected';
				$sel2 = '';
				$quantity = 0;
				$style = 'none';
			} else
			{
				$sel1 = '';
				$sel2 = 'selected';
				$quantity = $ds->row["in_stock"];
				$style = 'block';
			}

			$sql = "select id_parent,title,price,priority,in_stock from " . PVS_DB_PREFIX .
				"prints_items where itemid=" . ( int )$id . " and printsid=" . $ds->row["id_parent"] .
				" order by priority";
			$dr->open( $sql );
			if ( ! $dr->eof )
			{
				$checked = "checked";
				$price = $dr->row["price"];

				if ( $dr->row["in_stock"] == -1 )
				{
					$sel1 = 'selected';
					$sel2 = '';
					$quantity = 0;
					$style = 'none';
				} else
				{
					$sel1 = '';
					$sel2 = 'selected';
					$quantity = $dr->row["in_stock"];
					$style = 'block';
				}
			}

			$readonly = "readonly";
			if ( pvs_is_user_admin () )
			{
				$readonly = "";
			}

			$row_style = "";
			if ( $quantity == 0 and $sel1 == '' )
			{
				$row_style = "class='danger'";
			}

			$res .= "<tr " . $row_style . ">
			<td><input name='prints_chk" . $ds->row["id_parent"] . "' type='checkbox' " .
				$checked . "></td>
			<td>" . $ds->row["title"] . "</td>
			<td><input class='ibox form-control' name='prints_price" . $ds->row["id_parent"] .
				"' " . $readonly . " value='" . pvs_price_format( $price, 2 ) .
				"' type='text' style='width:100px'></td>";

			if ( pvs_is_user_admin () or $pvs_global_settings["seller_prints_quantity"] )
			{

				$res .= "<td><select id='quantity_type" . $ds->row["id_parent"] .
					"' name='quantity_type" . $ds->row["id_parent"] .
					"' class='form-control' onChange=\"change_quantity(" . $ds->row["id_parent"] .
					",this.value)\" style='width:150px'>
							<option value='-1' " . $sel1 . ">" . pvs_word_lang( "Unlimited" ) .
					"</option>
							<option value='0' " . $sel2 . ">" . pvs_word_lang( "Value" ) . "</option>
							</select>
							<input type='text'  id='quantity" . $ds->row["id_parent"] .
					"' name='quantity" . $ds->row["id_parent"] . "' value='" . $quantity .
					"'  style='width:150px;margin-top:3px;display:" . $style .
					"' class='form-control'></td>";
			}

			$res .= "</tr>";

			$ds->movenext();
		}
		$dd->movenext();
	}

	$res .= "</table>";

	return $res;
}
//End. Build a table of current prints for the ID

//The function updates prints
function pvs_prints_update( $id )
{
	global $ds;
	global $dr;
	global $db;
	global $_POST;
	global $pvs_global_settings;

	$sql = "select id_parent,title,priority,in_stock from " . PVS_DB_PREFIX .
		"prints where photo=1 order by priority";
	$ds->open( $sql );
	while ( ! $ds->eof )
	{
		$sql = "select id_parent,title,price,priority,in_stock from " . PVS_DB_PREFIX .
			"prints_items where itemid=" . ( int )$id . " and printsid=" . $ds->row["id_parent"] .
			" order by priority";
		$dr->open( $sql );

		if ( ! $dr->eof )
		{
			if ( isset( $_POST["prints_chk" . $ds->row["id_parent"]] ) )
			{
				$quantity = $dr->row["in_stock"];

				if ( ( pvs_is_user_admin () or $pvs_global_settings["seller_prints_quantity"] ) and
					isset( $_POST["quantity_type" . $ds->row["id_parent"]] ) and isset( $_POST["quantity" .
					$ds->row["id_parent"]] ) )
				{
					if ( $_POST["quantity_type" . $ds->row["id_parent"]] == -1 )
					{
						$quantity = -1;
					} else
					{
						$quantity = ( int )$_POST["quantity" . $ds->row["id_parent"]];
					}
				}

				$sql = "update " . PVS_DB_PREFIX . "prints_items set price=" . ( float )$_POST["prints_price" .
					$ds->row["id_parent"]] . ",in_stock=" . $quantity . " where itemid=" . ( int )$id .
					" and printsid=" . $ds->row["id_parent"];
				$db->execute( $sql );
			} else
			{
				$sql = "delete from " . PVS_DB_PREFIX . "prints_items where itemid=" . ( int )$id .
					" and printsid=" . $ds->row["id_parent"];
				$db->execute( $sql );
			}
		} else
		{
			if ( isset( $_POST["prints_chk" . $ds->row["id_parent"]] ) )
			{
				$quantity = $ds->row["in_stock"];

				if ( ( pvs_is_user_admin () or $pvs_global_settings["seller_prints_quantity"] ) and
					isset( $_POST["quantity_type" . $ds->row["id_parent"]] ) and isset( $_POST["quantity" .
					$ds->row["id_parent"]] ) )
				{
					if ( $_POST["quantity_type" . $ds->row["id_parent"]] == -1 )
					{
						$quantity = -1;
					} else
					{
						$quantity = ( int )$_POST["quantity" . $ds->row["id_parent"]];
					}
				}

				$sql = "insert into " . PVS_DB_PREFIX .
					"prints_items (title,price,itemid,priority,printsid,in_stock) values ('" . $ds->
					row["title"] . "'," . ( float )$_POST["prints_price" . $ds->row["id_parent"]] .
					"," . $id . "," . $ds->row["priority"] . "," . $ds->row["id_parent"] . "," . $quantity .
					")";
				$db->execute( $sql );
			}
		}

		$ds->movenext();
	}

}
//End The function updates prints

//Build <form> in admin panel
function pvs_build_admin_form( $url, $type )
{
	global $admin_fields;
	global $admin_meanings;
	global $admin_types;
	global $admin_names;
	global $id;
	global $dd;
	global $dn;
	global $lvideo;
	global $lpreviewvideo;
	global $laudio;
	global $lpreviewaudio;
	global $lvector;
	global $pvs_global_settings;
	global $lng;
	global $lang_name;
	global $lang_symbol;
	global $table_prefix;
	global $category_list_collection;

	$form_result = "";

	$border_header = "";

	$border_footer = "";
	
	$pvs_setting_group_name['files'] = pvs_word_lang( 'files' );
	$pvs_setting_group_name['description'] = pvs_word_lang( 'description' );
	$pvs_setting_group_name['categories'] = pvs_word_lang( 'categories' );

	if ( $type == 'photo' and $pvs_global_settings["prints"] ) {
		$pvs_setting_group_name['prints'] = pvs_word_lang( 'prints' );
	}

	$pvs_setting_group_name['other'] = pvs_word_lang( 'settings' );

	if ( $type != 'audio' ) {
		$pvs_setting_group_name['models'] = pvs_word_lang( 'models' );
	}
	
	if ( $pvs_global_settings["collections"] ) {
		$pvs_setting_group_name['collections'] = pvs_word_lang( 'Collections' );
	}

	$pvs_setting_group_name['stats'] = pvs_word_lang( 'stats' );

	if ( $pvs_global_settings["google_coordinates"] ) {
		$pvs_setting_group_name['google'] = pvs_word_lang( 'Google map' );
	}

	$pvs_setting_group['category'] = 'categories';
	$pvs_setting_group['title'] = 'description';
	$pvs_setting_group['description'] = 'description';
	$pvs_setting_group['keywords'] = 'description';
	$pvs_setting_group['author'] = 'description';
	$pvs_setting_group['file'] = 'files';
	$pvs_setting_group['data'] = 'other';
	$pvs_setting_group['published'] = 'other';
	$pvs_setting_group['viewed'] = 'stats';
	$pvs_setting_group['downloaded'] = 'stats';
	$pvs_setting_group['free'] = 'other';
	$pvs_setting_group['exclusive'] = 'other';
	$pvs_setting_group['contacts'] = 'other';
	$pvs_setting_group['content_type'] = 'other';
	$pvs_setting_group['model'] = 'models';
	$pvs_setting_group['adult'] = 'other';
	$pvs_setting_group['vote_like'] = 'stats';
	$pvs_setting_group['vote_dislike'] = 'stats';
	$pvs_setting_group['color'] = 'other';
	$pvs_setting_group['duration'] = 'other';
	$pvs_setting_group['format'] = 'other';
	$pvs_setting_group['ratio'] = 'other';
	$pvs_setting_group['rendering'] = 'other';
	$pvs_setting_group['frames'] = 'other';
	$pvs_setting_group['holder'] = 'other';
	$pvs_setting_group['usa'] = 'other';
	$pvs_setting_group['source'] = 'other';
	$pvs_setting_group['google_x'] = 'google';
	$pvs_setting_group['google_y'] = 'google';
	$pvs_setting_group['collections'] = 'collections';

	$pvs_group_default = 'files';

	$id = 0;
	if ( isset( $_GET["id"] ) )
	{
		$id = ( int )$_GET["id"];
	}



	$form_result .= "<form method='post' Enctype='multipart/form-data' id='uploadform' name='uploadform' action='" .
		$url . "&type=" . $type .
		"' style='margin:0' class='gllpLatlonPicker'><div class='content_edit'>";

		if ( $type == "photo" or $type == "video" or $type == "audio" or $type ==
		"vector" ) {

		//Show thumb
		$clarifai_file = "";
		if ( $id != 0 and pvs_is_user_admin () ) {
			$form_result .= "<div class='row'><div class='col-md-6'>"; 
			
			if ( $type == 'audio' ) {
				$form_result .= "<div style='margin-bottom:10px'>" . pvs_show_preview( ( int )$_GET["id"], $type, 3, 0 ) . '</div>' . pvs_show_preview( $id, $type, 2, 0 );
			} else {
				$form_result .=pvs_show_preview( $id, $type, 2, 0 );
			}
				
			$form_result .= "</div><div class='col-md-6'>";

			if ( $pvs_global_settings["clarifai"] or $pvs_global_settings["imagga"] ) {
				$recognition_file = pvs_upload_dir('baseurl') . pvs_show_preview( $id, $type, 2, 1 );
				$recognition_file_clarifai = $recognition_file;
				$recognition_file_imagga = $recognition_file;

				if ( $type == 'video' and $pvs_global_settings["imagga"] ) {
					$recognition_file_imagga = pvs_upload_dir('baseurl') . pvs_show_preview( $id, $type, 3, 1 );
				}

				if ( $type == 'audio' ) {
					$recognition_file_clarifai = pvs_upload_dir('baseurl') . pvs_show_preview( $id, $type, 3,
						1 );
					$recognition_file_imagga = pvs_upload_dir('baseurl') . pvs_show_preview( $id, $type, 3, 1 );
				}

				$form_result .= "<p><b>" . pvs_word_lang( "Image recognition" ) . ":</b></p>";

				$form_result .= "<p><select style='width:140px' name='recognition_lang' id='recognition_lang' class='form-control'>";
				$sql = "select name,activ from " . PVS_DB_PREFIX .
					"languages where display=1 order by name";
				$dd->open( $sql );
				while ( ! $dd->eof ) {
					$sel = "";
					if ( $dd->row["activ"] == 1 ) {
						$sel = "selected";
					}
					$form_result .= "<option value='" . $lang_symbol[$dd->row["name"]] . "' " . $sel .
						">" . $dd->row["name"] . "</option>";
					$dd->movenext();
				}
				$form_result .= "</select></p>";
			}

			if ( $pvs_global_settings["clarifai"] ) {
				$form_result .= "<a href=\"javascript:get_clarifai('" . $recognition_file_clarifai .
					"','keywords_clarifai','" . $pvs_global_settings["clarifai_language"] .
					"',false)\"  class='btn btn-warning'>Clarifai</a> ";
			}

			if ( $pvs_global_settings["imagga"] ) {
				$form_result .= "<a href=\"javascript:get_imagga('" . $recognition_file_imagga .
					"','keywords_imagga','" . $pvs_global_settings["imagga_language"] . "',false)\"  class='btn btn-primary'>Imagga</a> ";
			}

			if ( $pvs_global_settings["clarifai"] ) {
				$form_result .= '<div id="keywords_clarifai_box" style="display:none;margin-top:20px"><p><b>Clarifai - ' .
					pvs_word_lang( "keywords" ) .
					':</b></p><textarea id="keywords_clarifai" style="width:400px;height:150px;margin:5px 0px 8px 0px;display:block"></textarea><a href="javascript:apply_keywords(\'keywords_clarifai\',\'field_keywords\')" class="btn btn-default">' .
					pvs_word_lang( 'Apply' ) . '</a></div>';
			}

			if ( $pvs_global_settings["imagga"] ) {
				$form_result .= '<div id="keywords_imagga_box" style="display:none;margin-top:20px"><p><b>Imagga - ' .
					pvs_word_lang( "keywords" ) .
					':</b></p><textarea id="keywords_imagga" style="width:400px;height:150px;display:block;margin:5px 0px 8px 0px"></textarea><a href="javascript:apply_keywords(\'keywords_imagga\',\'field_keywords\')" class="btn btn-default">' .
					pvs_word_lang( 'Apply' ) . '</a></div>';
			}
			
			$sql = "select color from " . PVS_DB_PREFIX . "colors where publication_id = " . $id . " order by priority";
			$dd -> open($sql);
			if(!$dd->eof) {
				$form_result .= "<br><br><p><b>" . pvs_word_lang( "color" ) . ":</b></p>";
				while (!$dd->eof) {
					$form_result .= '<div class="color_tab" style="background-color:#' . $dd->row['color'] . '">&nbsp;</div>';
					$dd -> movenext();
				}
				$form_result .= '<div class="clearfix"></div>';
			}

			$form_result .= "</div></div><br><br>";
		}

		$form_result .= "<h2 class='nav-tab-wrapper'>";

		foreach ( $pvs_setting_group_name as $key => $value ) {
			$sel = '';
			if ( $key == $pvs_group_default )
			{
				$sel = "nav-tab-active";
			}
			//$form_result .= "<li class='menu_settings menu_settings_" . $key . " " . $sel . "'><a href=\"javascript:change_group('" . $key . "')\">" . $value . "</a></li>";
			$form_result .= "<a href=\"javascript:change_group('" . $key . "')\" class='menu_settings menu_settings_" . $key . " nav-tab " . $sel . "'>" . $value . "</a>";
		}

		$form_result .= "</h2><br>";
	}


	for ( $i = 0; $i < count( $admin_fields ); $i++ )
	{
		if ( isset( $pvs_setting_group[$admin_fields[$i]] ) ) {
			$style = "group_settings group_" . $pvs_setting_group[$admin_fields[$i]];
		} else {
			$style = "group_settings group_other";
		}

		$form_result .= "<div class='admin_field " . $style . "'>";

		if ( ( $type == "photo" or $type == "video" or $type == "audio" or $type ==
			"vector" ) and $admin_types[$i] == "file" ) {

		} else {
			$form_result .= "<span>" . pvs_word_lang( $admin_names[$i] ) . ":</span>";
		}

		if ( $admin_types[$i] == "text" )
		{
			$form_result .= "<input type='text' name='" . $admin_fields[$i] .
				"' style='width:400px' class='ibox form-control' value='" . $admin_meanings[$i] .
				"'>";
		}

		if ( $admin_types[$i] == "text_translation" or $admin_types[$i] ==
			"textarea_translation" )
		{
			$lng_translation = $lng;
			$lng_list = "";
			$input_list = "";
			$sql = "select name,activ from " . PVS_DB_PREFIX .
				"languages where display=1 order by name";
			$dd->open( $sql );
			while ( ! $dd->eof )
			{
				if ( $dd->row["activ"] == 1 )
				{
					$lng_translation = $dd->row["name"];
				} else
				{
					$lng3 = strtolower( $dd->row["name"] );
					$lng_symbol = $lang_symbol[$dd->row["name"]];
					if ( $lng3 == "chinese traditional" )
					{
						$lng3 = "chinese";
						$lng_symbol = "zh1";
					}
					if ( $lng3 == "chinese simplified" )
					{
						$lng3 = "chinese";
						$lng_symbol = "zh2";
					}
					if ( $lng3 == "afrikaans formal" )
					{
						$lng3 = "afrikaans";
						$lng_symbol = "af1";
					}
					if ( $lng3 == "afrikaans informal" )
					{
						$lng3 = "afrikaans";
						$lng_symbol = "af2";
					}

					$sql = "select title,keywords,description from " . PVS_DB_PREFIX .
						"translations where id=" . $id . " and lang='" . $lng_symbol . "'";
					$dn->open( $sql );
					if ( ! $dn->eof )
					{
						if ( $dn->row[$admin_fields[$i]] != "" )
						{
							if ( $admin_types[$i] == "text_translation" )
							{
								$input_code = "<input type='text' name='translate_" . $admin_fields[$i] . "_" .
									$lng_symbol . "' style='width:400px' class='ibox form-control' value='" . $dn->
									row[$admin_fields[$i]] . "'>";
							} else
							{
								$input_code = "<textarea name='translate_" . $admin_fields[$i] . "_" . $lng_symbol .
									"' style='width:400px;height:120px' class='ibox form-control'>" . $dn->row[$admin_fields[$i]] .
									"</textarea>";
							}

							$input_list .= "<div class='clear' id='div_" . $admin_fields[$i] . "_" . $lng_symbol .
								"' style='padding-top:20px'><div class='input-append' style='float:left;margin-right:4px'>" .
								$input_code . "<span class='add-on' style='width:120px;text-align:left'><img src='" .
								pvs_plugins_url() . '/includes/admin/includes/img/languages/' . $lng3 .
								".gif'>&nbsp;<font class='langtext'>" . $dd->row["name"] .
								"</font></span></div><button class='btn btn-danger' type='button' onClick=\"translation_delete('" .
								$admin_fields[$i] . "','" . $lng_symbol . "');\">" . pvs_word_lang( "delete" ) .
								"</button></div>";
						} else
						{
							$lng_list .= "<li id='li_" . $admin_fields[$i] . "_" . $lng_symbol .
								"' style='float:left;width:170px'><a href=\"javascript:translation_add('" . $admin_fields[$i] .
								"','" . $dd->row["name"] . "','" . $lng3 . "','" . $lng_symbol . "','" . $admin_types[$i] .
								"');\"><img src='" . pvs_plugins_url() .
								'/includes/admin/includes/img/languages/' . $lng3 . ".gif'>&nbsp;" . $dd->row["name"] .
								"</a></li>";
						}
					} else
					{
						$lng_list .= "<li id='li_" . $admin_fields[$i] . "_" . $lng_symbol .
							"' style='float:left;width:170px'><a href=\"javascript:translation_add('" . $admin_fields[$i] .
							"','" . $dd->row["name"] . "','" . $lng3 . "','" . $lng_symbol . "','" . $admin_types[$i] .
							"');\"><img src='" . pvs_plugins_url() .
							'/includes/admin/includes/img/languages/' . $lng3 . ".gif'>&nbsp;" . $dd->row["name"] .
							"</a></li>";
					}
				}
				$dd->movenext();
			}

			$lng3 = strtolower( $lng_translation );
			if ( $lng3 == "chinese traditional" )
			{
				$lng3 = "chinese";
			}
			if ( $lng3 == "chinese simplified" )
			{
				$lng3 = "chinese";
			}
			if ( $lng3 == "afrikaans formal" )
			{
				$lng3 = "afrikaans";
			}
			if ( $lng3 == "afrikaans informal" )
			{
				$lng3 = "afrikaans";
			}

			if ( $admin_types[$i] == "text_translation" )
			{
				$input_code = "<input type='text' name='" . $admin_fields[$i] .
					"' style='width:400px' class='ibox form-control' value='" . $admin_meanings[$i] .
					"'>";
			} else
			{
				$input_code = "<textarea id='field_" . $admin_fields[$i] . "' name='" . $admin_fields[$i] .
					"' style='width:400px;height:120px' class='ibox form-control'>" . $admin_meanings[$i] .
					"</textarea>";
			}

			$form_result .= "
		<div class='clear '>
			<div class='input-append' style='float:left;margin-right:4px'>
				" . $input_code . "
				<span class='add-on' style='width:120px;text-align:left'><img src='" .
				pvs_plugins_url() . "/includes/admin/includes/img/languages/" . $lng3 .
				".gif'>&nbsp;<font class='langtext'>" . $lang_name[$lng_translation] .
				"</font></span>
			</div>

			<div class='btn-group'>
    			<a class='btn btn-success' href='#'>" . pvs_word_lang( "add language" ) .
				"</a>
    			<a class='btn btn-success dropdown-toggle' data-toggle='dropdown' href='#'><span class='caret' style='margin:8px 2px 8px 2px'></span></a>
    			<ul class='dropdown-menu' style='width:520px'>
    				" . $lng_list . "
   				</ul>
    		</div>
		</div>
		<div class='clear' id='trans_" . $admin_fields[$i] . "'>
			" . $input_list . "
		</div><div class='clear'></div>";
		}

		if ( $admin_types[$i] == "filepdf" )
		{
			$form_result .= "<input type='file' name='" . $admin_fields[$i] .
				"' style='width:400px' class='ibox form-control'><br>(*.jpg or *.pdf or *.zip)";
			if ( $admin_meanings[$i] . "" != "" )
			{
				$form_result .= "<div style='padding-top:3px'><a 	href='" . pvs_upload_dir( 'baseurl' ) .
					$admin_meanings[$i] . "' class='btn btn-default'>" . pvs_word_lang( "download" ) .
					"</a> <a href='" . str_replace( "action=content", "action=delete_thumb", $_SERVER['REQUEST_URI'] ) .
					"&type=file'  class='btn btn-default'>" . pvs_word_lang( "delete" ) .
					"</a></div>";
			}
		}

		if ( $admin_types[$i] == "file" )
		{
			if ( $type == "category")
			{
				$form_result .= "<input type='file' name='" . $admin_fields[$i] .
					"' style='width:400px' class='ibox form-control'><small>(*.jpg)</small>";

				if ( $admin_meanings[$i] . "" != "" )
				{
					$form_result .= "<div style='padding-top:3px'><div  style='padding-bottom:3px'><img src='" . pvs_upload_dir( 'baseurl' ) .
						$admin_meanings[$i] . "'></div><a href='" . str_replace( "action=content",
						"action=delete_thumb", $_SERVER['REQUEST_URI'] ) .
						"'  class='btn btn-default btn-sm'>" . pvs_word_lang( "delete" ) . "</a></div>";
				}
			}

			if ( $type == "photo" or $type == "video" or $type == "audio" or $type ==
				"vector" )
			{
				$rights_managed = 0;
				$active1 = "checked";
				$active1_style = 'block';
				$active2 = "";
				$active2_style = 'none';

				$flag_jquery = false;

				if ( $id != 0 )
				{
					$sql = "select rights_managed from " . PVS_DB_PREFIX . "media where id=" . ( int ) $id;
					$dd->open( $sql );
					if ( ! $dd->eof )
					{
						$rights_managed = $dd->row["rights_managed"];
						if ( $pvs_global_settings["rights_managed"] and $rights_managed != 0 )
						{
							$active1 = "";
							$active1_style = 'none';
							$active2 = "checked";
							$active2_style = 'block';
						}
					}
				} else
				{
					if ( ! $pvs_global_settings["royalty_free"] )
					{
						$rights_managed = 1;
						$active1 = "";
						$active1_style = 'none';
						$active2 = "checked";
						$active2_style = 'block';
					}
				}
				
				if ( $pvs_global_settings["royalty_free"] and $pvs_global_settings["rights_managed"] ) {
					$form_result .= "<script>function set_license(value) 
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
					}</script>";
				
					$form_result .= '<div style="margin-bottom:20px"><input type="radio" name="license_type"  id="license_type1" value="0" ' . $active1 . ' onClick="set_license(1)">&nbsp;<label for="license_type1" style="display:inline;font-size:12px">' . pvs_word_lang( "royalty free" ) . '</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="license_type"  id="license_type2" value="1" ' . $active2 . ' onClick="set_license(2)">&nbsp;<label for="license_type2"  style="display:inline;font-size:12px">' . pvs_word_lang( "rights managed" ). '</label></div>';
				} else {
					$form_result .= '<input type="hidden" id="license_type" name="license_type" value="' . $rights_managed . '">';
				}
			}

			if ( $type == "photo" )
			{
				if ( $pvs_global_settings["royalty_free"] )
				{
					$form_result .= '<div id="box_license1" style="display:' . $active1_style . '">';

					$form_result .= $border_header . pvs_photo_upload_form( $id, true ) . $border_footer;

					$form_result .= '</div>';
				}

				if ( $pvs_global_settings["rights_managed"] )
				{
					$form_result .= '<div id="box_license2" style="display:' . $active2_style . '">';

					$form_result .= $border_header . pvs_rights_managed_upload_form( $type, $rights_managed,
						$id, true ) . $border_footer;

					$form_result .= '</div>';
				}

				if ( $pvs_global_settings["prints"] )
				{
					$form_result .= "</div><div class='admin_field group_settings group_prints'>";
					if ( $id == 0 )
					{
						$form_result .= $border_header . pvs_prints_upload_form() . $border_footer;
					} else
					{
						$form_result .= $border_header . pvs_prints_live( $id ) . $border_footer;
					}
				}
			}

			if ( $type == "video" )
			{
				if ( $pvs_global_settings["royalty_free"] )
				{
					$form_result .= '<div  id="box_license1" style="display:' . $active1_style . '">';
					$form_result .= $border_header . pvs_files_upload_form( $id, "video", true ) . $border_footer;
					$form_result .= '</div>';
				}

				if ( $pvs_global_settings["rights_managed"] )
				{
					$form_result .= '<div  id="box_license2" style="display:' . $active2_style . '">';
					$form_result .= $border_header . pvs_rights_managed_upload_form( $type, $rights_managed,
						$id, true ) . $border_footer;
					$form_result .= '</div>';
				}
			}

			if ( $type == "audio" )
			{
				if ( $pvs_global_settings["royalty_free"] )
				{
					$form_result .= '<div  id="box_license1" style="display:' . $active1_style . '">';
					$form_result .= $border_header . pvs_files_upload_form( $id, "audio", true ) . $border_footer;
					$form_result .= '</div>';
				}

				if ( $pvs_global_settings["rights_managed"] )
				{
					$form_result .= '<div  id="box_license2" style="display:' . $active2_style . '">';
					$form_result .= $border_header . pvs_rights_managed_upload_form( $type, $rights_managed,
						$id, true ) . $border_footer;
					$form_result .= '</div>';
				}
			}

			if ( $type == "vector" )
			{
				if ( $pvs_global_settings["royalty_free"] )
				{
					$form_result .= '<div  id="box_license1" style="display:' . $active1_style . '">';
					$form_result .= $border_header . pvs_files_upload_form( $id, "vector", true ) .
						$border_footer;
					$form_result .= '</div>';
				}

				if ( $pvs_global_settings["rights_managed"] )
				{
					$form_result .= '<div id="box_license2" style="display:' . $active2_style . '">';
					$form_result .= $border_header . pvs_rights_managed_upload_form( $type, $rights_managed,
						$id, true ) . $border_footer;
					$form_result .= '</div>';
				}
			}
		}

		if ( $admin_types[$i] == "int" )
		{
			$form_result .= "<input type='text' name='" . $admin_fields[$i] .
				"' style='width:200px' class='ibox form-control' value='" . $admin_meanings[$i] .
				"'>";
		}

		if ( $admin_types[$i] == "float" )
		{
			if ( $admin_fields[$i] == "google_x" )
			{
				$form_result .= "<input type='text' name='" . $admin_fields[$i] .
					"' style='width:200px' class='ibox form-control gllpLatitude' value='" . $admin_meanings[$i] .
					"'>";
			} elseif ( $admin_fields[$i] == "google_y" )
			{
				$form_result .= "<input type='text' name='" . $admin_fields[$i] .
					"' style='width:200px' class='ibox form-control gllpLongitude' value='" . $admin_meanings[$i] .
					"'><div class='gllpMap' style='width: 500px; height: 250px;margin-top:10px'></div><input type='hidden' class='gllpZoom' value='8'/><input type='hidden' class='gllpUpdateButton' value='update map'><div style='margin-top:10px'><input type='text' class='gllpSearchField ibox form-control' style='width:200px;display:inline'>
			<input type='button' class='gllpSearchButton btn btn-default' value='" .
					pvs_word_lang( "search" ) . "'></div>";
			} else
			{
				$form_result .= "<input type='text' name='" . $admin_fields[$i] .
					"' style='width:200px' class='ibox form-control' value='" . $admin_meanings[$i] .
					"'>";
			}
		}

		if ( $admin_types[$i] == "textarea" )
		{
			$form_result .= "<textarea name='" . $admin_fields[$i] .
				"' style='width:400px;height:200px' class='ibox form-control'>" . $admin_meanings[$i] .
				"</textarea>";
		}

		if ( $admin_types[$i] == "data" )
		{
			$form_result .= pvs_admin_date( $admin_meanings[$i], $admin_fields[$i] );
		}

		if ( $admin_types[$i] == "data_expire" )
		{
			$form_result .= "<select name='" . $admin_fields[$i] .
				"'  style='width:100px;margin-bottom:6px' class='ibox form-control' onChange=\"set_expire_date('" .
				$admin_fields[$i] . "',this.value)\">";
			if ( $admin_meanings[$i] == 0 )
			{
				$sel1 = 'selected';
				$sel2 = '';
				$style_display = 'none';
			} else
			{
				$sel1 = '';
				$sel2 = 'selected';
				$style_display = 'block';
			}

			$form_result .= "<option value='0' " . $sel1 . ">" . pvs_word_lang( "Never" ) .
				"</option>";
			$form_result .= "<option value='1' " . $sel2 . ">" . pvs_word_lang( "date" ) .
				"</option>";
			$form_result .= "</select><div id='ed_" . $admin_fields[$i] .
				"' style='display:" . $style_display . "'>";
			if ( $admin_meanings[$i] == 0 )
			{
				$form_result .= pvs_admin_date( pvs_get_time(), $admin_fields[$i] );
			} else
			{
				$form_result .= pvs_admin_date( $admin_meanings[$i], $admin_fields[$i] );
			}
			$form_result .= "</div>";
		}

		if ( $admin_types[$i] == "checkbox" )
		{
			$sel = "";
			if ( $admin_meanings[$i] == 1 )
			{
				$sel = "checked";
			}
			$form_result .= "<input type='checkbox' value='1' name='" . $admin_fields[$i] . "'   " . $sel .
				">";
		}

		if ( $admin_types[$i] == "category_tree" ) {
			$form_result .= $admin_meanings[$i];
		}

		if ( $admin_types[$i] == "category" ) {
			$form_result .= "<select name='" . $admin_fields[$i] .
				"' style='width:400px' class='ibox form-control'><option value='0'></option>" .
				$admin_meanings[$i] . "</select>";
		}

		if ( $admin_types[$i] == "commission" )
		{
			$commission_value = round( $admin_meanings[$i] );
			$commission_type1 = "selected";
			$commission_type2 = "";
			$sql = "select " . $admin_fields[$i] . "_type from " . PVS_DB_PREFIX .
				"user_category where id_parent=" . $id;
			$dn->open( $sql );
			if ( ! $dn->eof )
			{
				if ( $dn->row[$admin_fields[$i] . "_type"] == 1 )
				{
					$commission_value = pvs_price_format( $admin_meanings[$i], 2 );
					$commission_type2 = "selected";
					$commission_type1 = "";
				}
			}

			$form_result .= "<input name='" . $admin_fields[$i] .
				"' type='text' style='width:50px' value='" . $commission_value .
				"'><select name='" . $admin_fields[$i] . "_type' style='width:70px'>
				<option value='0' " . $commission_type1 . ">%</option>
				<option value='1' " . $commission_type2 . ">" . pvs_get_currency_code(1) . "</option>
			</select>";
		}
		
		
		if ( $admin_types[$i] == "collection_type" ) {
			$collection_type1 = "selected";
			$collection_type2 = "";
			if ( $admin_meanings[$i] == 1 )
			{
				$collection_type2 = "selected";
				$collection_type1 = "";
			}

			$form_result .= "<select name='" . $admin_fields[$i] . "' style='width:250px' onChange='collection_change(this.value)' class='form-control'>
				<option value='0' " . $collection_type1 . ">" . pvs_word_lang ('Based on the categories') . "</option>
				<option value='1' " . $collection_type2 . ">" . pvs_word_lang ('Based on the items') . "</option>
			</select><div style='display:none;margin-top:20px' id='category_list_collection'>" . $category_list_collection . "</div><script>collection_change(".$admin_meanings[$i].")</script>";
		}
		
		
		if ( $admin_types[$i] == "collections" ) {

			$sql = "select id, title from " . PVS_DB_PREFIX . "collections where types=1 order by title";
			$dd->open( $sql );
			while ( ! $dd->eof )
			{
				$checked = '';
				$sql = "select id from " . PVS_DB_PREFIX . "collections_items where collection_id = " . $dd->row["id"] . " and publication_id = " . $id;
				$dn->open($sql);
				if (!$dn -> eof) {
					$checked = 'checked';
				}
				
				$form_result .= "<div class='collection_box'><input type='checkbox' name='collection" . $dd->row["id"] . "' " . $checked . " value='1'> " . $dd->row["title"] . "</div>";
				$dd->movenext();
			}
			$form_result .= "<div class='clearfix'></div>";
		}
		

		if ( $admin_types[$i] == "model" ) {
			$form_result .= pvs_show_models( $id );
		}

		if ( $admin_types[$i] == "author" )
		{
			$form_result .= "<select name='" . $admin_fields[$i] .
				"' style='width:400px' class='ibox form-control'>";
			$sql = "select ID, user_login from " . $table_prefix .
				"users  order by user_login";
			$dd->open( $sql );
			while ( ! $dd->eof )
			{
				$sel = "";
				if ( $dd->row["user_login"] == $admin_meanings[$i] )
				{
					$sel = "selected";
				}
				$form_result .= "<option value='" . $dd->row["user_login"] . "' " . $sel . ">" .
					$dd->row["user_login"] . "</option>";
				$dd->movenext();
			}
			$form_result .= "</select>";
		}

		if ( $admin_types[$i] == "content_type" )
		{
			$form_result .= "<select name='" . $admin_fields[$i] .
				"' style='width:400px' class='ibox form-control'>";
			$sql = "select id_parent,name from " . PVS_DB_PREFIX .
				"content_type order by priority";
			$dd->open( $sql );
			while ( ! $dd->eof )
			{
				$sel = "";
				if ( $dd->row["name"] == $admin_meanings[$i] )
				{
					$sel = "selected";
				}
				$form_result .= "<option value='" . $dd->row["name"] . "' " . $sel . ">" . $dd->
					row["name"] . "</option>";
				$dd->movenext();
			}
			$form_result .= "</select>";
		}

		if ( $admin_types[$i] == "format" )
		{
			$form_result .= "<select name='" . $admin_fields[$i] .
				"' style='width:400px' class='ibox form-control'>";
			$sql = "select name from " . PVS_DB_PREFIX . "video_format";
			$dd->open( $sql );
			while ( ! $dd->eof )
			{
				$sel = "";
				if ( $dd->row["name"] == $admin_meanings[$i] )
				{
					$sel = "selected";
				}
				$form_result .= "<option value='" . $dd->row["name"] . "' " . $sel . ">" . $dd->
					row["name"] . "</option>";
				$dd->movenext();
			}
			$form_result .= "</select>";
		}

		if ( $admin_types[$i] == "ratio" )
		{
			$form_result .= "<select name='" . $admin_fields[$i] .
				"' style='width:400px' class='ibox form-control'>";
			$sql = "select name from " . PVS_DB_PREFIX . "video_ratio";
			$dd->open( $sql );
			while ( ! $dd->eof )
			{
				$sel = "";
				if ( $dd->row["name"] == $admin_meanings[$i] )
				{
					$sel = "selected";
				}
				$form_result .= "<option value='" . $dd->row["name"] . "' " . $sel . ">" . $dd->
					row["name"] . "</option>";
				$dd->movenext();
			}
			$form_result .= "</select>";
		}

		if ( $admin_types[$i] == "rendering" )
		{
			$form_result .= "<select name='" . $admin_fields[$i] .
				"' style='width:400px' class='ibox form-control'>";
			$sql = "select name from " . PVS_DB_PREFIX . "video_rendering";
			$dd->open( $sql );
			while ( ! $dd->eof )
			{
				$sel = "";
				if ( $dd->row["name"] == $admin_meanings[$i] )
				{
					$sel = "selected";
				}
				$form_result .= "<option value='" . $dd->row["name"] . "' " . $sel . ">" . $dd->
					row["name"] . "</option>";
				$dd->movenext();
			}
			$form_result .= "</select>";
		}

		if ( $admin_types[$i] == "frames" )
		{
			$form_result .= "<select name='" . $admin_fields[$i] .
				"' style='width:400px' class='ibox form-control'>";
			$sql = "select name from " . PVS_DB_PREFIX . "video_frames";
			$dd->open( $sql );
			while ( ! $dd->eof )
			{
				$sel = "";
				if ( $dd->row["name"] == $admin_meanings[$i] )
				{
					$sel = "selected";
				}
				$form_result .= "<option value='" . $dd->row["name"] . "' " . $sel . ">" . $dd->
					row["name"] . "</option>";
				$dd->movenext();
			}
			$form_result .= "</select>";
		}

		if ( $admin_types[$i] == "source" )
		{
			$form_result .= "<select name='" . $admin_fields[$i] .
				"' style='width:400px' class='ibox form-control'>";
			$sql = "select name from " . PVS_DB_PREFIX . "audio_source";
			$dd->open( $sql );
			while ( ! $dd->eof )
			{
				$sel = "";
				if ( $dd->row["name"] == $admin_meanings[$i] )
				{
					$sel = "selected";
				}
				$form_result .= "<option value='" . $dd->row["name"] . "' " . $sel . ">" . $dd->
					row["name"] . "</option>";
				$dd->movenext();
			}
			$form_result .= "</select>";
		}

		if ( $admin_types[$i] == "track_format" )
		{
			$form_result .= "<select name='" . $admin_fields[$i] .
				"' style='width:400px' class='ibox form-control'>";
			$sql = "select name from " . PVS_DB_PREFIX . "audio_format";
			$dd->open( $sql );
			while ( ! $dd->eof )
			{
				$sel = "";
				if ( $dd->row["name"] == $admin_meanings[$i] )
				{
					$sel = "selected";
				}
				$form_result .= "<option value='" . $dd->row["name"] . "' " . $sel . ">" . $dd->
					row["name"] . "</option>";
				$dd->movenext();
			}
			$form_result .= "</select>";
		}

		if ( $admin_types[$i] == "color" )
		{
			$form_result .= pvs_color_set( $admin_meanings[$i] );
		}

		if ( $admin_types[$i] == "duration" )
		{
			$form_result .= pvs_duration_form( $admin_meanings[$i], $admin_fields[$i] );
		}

		if ( $admin_types[$i] == "editor" )
		{
			$form_result .= "<script type='text/javascript' src='" . pvs_plugins_url() .
				"/includes/plugins/tiny_mce/tiny_mce.js'></script>
		<script type='text/javascript'>
	tinyMCE.init({
		// General options
		mode : 'exact',
		elements : '" . $admin_fields[$i] . "',
		theme : 'advanced',
		plugins : 'autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks',
		document_base_url : '" . pvs_plugins_url() . "/',
		convert_urls : false,
		relative_urls : false,

		// Theme options
		theme_advanced_buttons1 : 'bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect',
		theme_advanced_buttons2 : 'cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor',
		theme_advanced_buttons3 : 'tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen',
		theme_advanced_buttons4 : 'insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks',
		theme_advanced_toolbar_location : 'top',
		theme_advanced_toolbar_align : 'left',
		theme_advanced_statusbar_location : 'bottom',
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : '" . pvs_plugins_url() .
				"/includes/plugins/tiny_mce/css/content.css',

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : '" . pvs_plugins_url() .
				"/includes/plugins/tiny_mce/lists/template_list.js',
		external_link_list_url : '" . pvs_plugins_url() .
				"/includes/plugins/tiny_mce/lists/link_list.js',
		external_image_list_url : '" . pvs_plugins_url() .
				"/includes/plugins/tiny_mce/lists/image_list.js',
		media_external_list_url : '" . pvs_plugins_url() .
				"/includes/plugins/tiny_mce/lists/media_list.js',

		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'}
		],


	});
	</script>
	<textarea name='" . $admin_fields[$i] . "' style='width:800px;height:600px'>" .
				$admin_meanings[$i] . "</textarea>
	";
		}

		$form_result .= "</div>";
	}



	$form_result .= "<div id='button_bottom_static'>
		<div id='button_bottom_layout'></div>
		<div id='button_bottom'><input type='submit' value='" . pvs_word_lang( "Save" ) .
		"' class='btn btn-primary' id='savebutton'></div></div>";

	if ( $type != "photo" and $type != "video" and $type != "audio" and $type !=
		"vector" ) {
		$form_result .= "</div>";
	}

	$form_result .= "</form>";

	return $form_result;
}

//Redirect function when a file is being uploaded
function pvs_redirect_file( $s, $swait )
{
	if ( $swait == false )
	{
		header( "location:" . $s );
		exit();
	} else
	{
		echo ( "<html>
		<head>
		<title>" . pvs_word_lang( "upload" ) . "</title>
		</head>
		<body bgcolor='#525151'>
		<script language='javascript'>
		function ff()
		{
		location.href='" . $s . "';
		}
		function cc()
		{
		hid = setTimeout('ff();',5000);
		} 
		cc()
		</script><div style='margin:250px auto 0px auto;width:310px;background-color:#373737;border: #4a4a4a 4px solid;padding:20px;font: 15pt Arial;color:#ffffff'>" .
			pvs_word_lang( "wait" ) . "<div><center><img src='" . pvs_plugins_url() .
			"/assets/images/upload_loading.gif'></center></div></div>
		</body>
		</html>" );
	}
}

//Add/update category
function pvs_add_update_category( $id, $userid, $upload, $published )
{
	global $_POST;
	global $_SERVER;
	global $db;
	global $dr;
	global $pvs_global_settings;

	$category_upload = $upload;
	if ( isset( $_POST["upload"] ) )
	{
		$category_upload = 1;
	}

	$category_published = $published;
	if ( isset( $_POST["published"] ) )
	{
		$category_published = 1;
	}

	$category_priority = 0;
	if ( isset( $_POST["priority"] ) )
	{
		$category_priority = ( int )$_POST["priority"];
	}

	$category_featured = 0;
	if ( isset( $_POST["featured"] ) )
	{
		$category_featured = 1;
	}

	$flag_new = false;

	//Get ID for a new category
	if ( $id == 0 )
	{
		$flag_new = true;
	}

	//Change database
	$creation_date = pvs_get_time( ( int )@$_POST["creation_date_hour"], ( int )@$_POST["creation_date_minute"],
		( int )@$_POST["creation_date_second"], ( int )@$_POST["creation_date_month"], ( int )
		@$_POST["creation_date_day"], ( int )@$_POST["creation_date_year"] );

	$activation_date = pvs_get_time( ( int )@$_POST["activation_date_hour"], ( int )
		@$_POST["activation_date_minute"], ( int )@$_POST["activation_date_second"], ( int )
		@$_POST["activation_date_month"], ( int )@$_POST["activation_date_day"], ( int )
		@$_POST["activation_date_year"] );

	$expiration_date = pvs_get_time( ( int )@$_POST["expiration_date_hour"], ( int )
		@$_POST["expiration_date_minute"], ( int )@$_POST["expiration_date_second"], ( int )
		@$_POST["expiration_date_month"], ( int )@$_POST["expiration_date_day"], ( int )
		@$_POST["expiration_date_year"] );

	if ( @$_POST["expiration_date"] == 0 )
	{
		$expiration_date = 0;
	}
	
	$com = "";

	if ( $flag_new )
	{
		//Add a new category
		$sql = "insert into " . PVS_DB_PREFIX .
			"category (id_parent,title,description,keywords,photo,upload,userid,published,priority,password,featured, creation_date, activation_date, expiration_date, location, google_x,google_y) values (" . ( int )
			$_POST["id_parent"] . ",'" . pvs_result( $_POST["title"] ) . "','" . pvs_result( $_POST["description"] ) .
			"','" . pvs_result( $_POST["keywords"] ) . "',''," . $category_upload . "," . ( int )
			$userid . "," . $category_published . "," . $category_priority . ",'" .
			pvs_result( $_POST["password"] ) . "'," . $category_featured . "," . $creation_date .
			"," . $activation_date . "," . $expiration_date . ",'" . pvs_result( @$_POST["location"] ) .
			"'," . ( float )@$_POST["google_x"] . "," . ( float )@$_POST["google_y"] . ")";
		$db->execute( $sql );

		$sql = "select id from " . PVS_DB_PREFIX . "category where title='" . pvs_result( $_POST["title"] ) .
			"' order by id desc";
		$dr->open( $sql );
		$id = $dr->row['id'];

		pvs_category_url( $id );
	} else
	{
		//Update the category

		
		if ( $userid != 0 )
		{
			$com = " and userid=" . ( int )$userid;
		}

		$sql = "update " . PVS_DB_PREFIX . "category set id_parent=" . ( int )$_POST["id_parent"] .
			", title='" . pvs_result( $_POST["title"] ) . "',description='" . pvs_result( $_POST["description"] ) .
			"',keywords='" . pvs_result( $_POST["keywords"] ) . "',password='" . pvs_result( $_POST["password"] ) .
			"',priority=" . $category_priority . ",upload=" . $category_upload .
			",published=" . $category_published . ",featured=" . $category_featured .
			", creation_date=" . $creation_date . ",activation_date=" . $activation_date .
			",expiration_date=" . $expiration_date . ",location='" . pvs_result( @$_POST["location"] ) .
			"',google_x=" . ( float )@$_POST["google_x"] . ",google_y=" . ( float )@$_POST["google_y"] .
			" where id=" . $id . $com;
		$db->execute( $sql );
	}

	//Upload photo
	$photo = "";
	$swait = false;
	$flag = true;

	if ( preg_match( "/text/i", $_FILES["photo"]["type"] ) )
	{
		$flag = false;
	}
	if ( ! preg_match( "/\.jpg$/i", $_FILES["photo"]["name"] ) )
	{
		$flag = false;
	}

	$_FILES["photo"]['name'] = pvs_result_file( $_FILES["photo"]['name'] );

	if ( $_FILES["photo"]['size'] > 0 and $_FILES["photo"]['size'] < 10048 * 1024 )
	{
		if ( $flag == true )
		{
			$photo = "/content/categories/category_" . $id . ".jpg";
			move_uploaded_file( $_FILES["photo"]['tmp_name'], pvs_upload_dir() . $photo );

			//make thumb
			pvs_easyResize( pvs_upload_dir() . $photo, pvs_upload_dir() . $photo, 100, ( int )
				$pvs_global_settings["category_preview"] );

			$swait = true;
		}
	}

	if ( $photo != "" )
	{
		$sql = "update " . PVS_DB_PREFIX . "category set photo='" . pvs_result( $photo ) .
			"' where id=" . $id . $com;
		$db->execute( $sql );
	}

	//Update translation
	if ( $pvs_global_settings["multilingual_categories"] )
	{
		$sql = "delete from " . PVS_DB_PREFIX . "translations where id=" . $id;
		$db->execute( $sql );
	}

	foreach ( $_POST as $key => $value )
	{
		if ( preg_match( "/translate/i", $key ) )
		{
			$temp_mass = explode( "_", $key );
			if ( isset( $temp_mass[1] ) and isset( $temp_mass[2] ) )
			{
				$sql = "select id from " . PVS_DB_PREFIX . "translations where id=" . $id .
					" and lang='" . pvs_result( $temp_mass[2] ) . "'";
				$dr->open( $sql );
				if ( $dr->eof )
				{
					$sql = "insert into " . PVS_DB_PREFIX .
						"translations (id,title,keywords,description,lang,types) values (" . $id .
						",'','','','" . pvs_result( $temp_mass[2] ) . "',0)";
					$db->execute( $sql );
				}

				$sql = "update " . PVS_DB_PREFIX . "translations set " . pvs_result( $temp_mass[1] ) .
					"='" . pvs_result( $value ) . "' where id=" . $id . " and lang='" . pvs_result( $temp_mass[2] ) .
					"'";
				$db->execute( $sql );
			}
		}
	}

	return $swait;
}

//Delete category
function pvs_delete_category( $id, $userid )
{
	global $db;
	global $rs;
	global $_SERVER;

	$com = "";
	if ( $userid != 0 )
	{
		$com = " and userid=" . ( int )$userid;
	}

	$sql = "select id,photo from " . PVS_DB_PREFIX . "category where id=" . ( int )
		$id . $com;
	$rs->open( $sql );
	if ( ! $rs->eof )
	{
		if ( $rs->row["photo"] != "" and file_exists( pvs_upload_dir() . $rs->row["photo"] ) )
		{
			unlink( pvs_upload_dir() . $rs->row["photo"] );
		}

		$sql = "delete from " . PVS_DB_PREFIX . "category where id=" . ( int )$id;
		$db->execute( $sql );

		$sql = "delete from " . PVS_DB_PREFIX . "translations where id=" . ( int )$id;
		$db->execute( $sql );
	}
}

//The function uploads model property release
function pvs_model_upload( $id )
{
	global $_FILES;
	global $_SERVER;
	global $pvs_global_settings;
	global $db;

	$swait = false;

	//upload photo
	$_FILES["modelphoto"]['name'] = pvs_result_file( $_FILES["modelphoto"]['name'] );
	$ext = strtolower( pvs_get_file_info( $_FILES["modelphoto"]['name'], "extention" ) );
	if ( $_FILES["modelphoto"]['size'] > 0 and $_FILES["modelphoto"]['size'] < 1024 *
		1024 * 1 and ! preg_match( "/text/i", $_FILES["modelphoto"]['type'] ) and
		preg_match( "/.jpg$|.jpeg$/i", $_FILES["modelphoto"]['name'] ) )
	{
		$swait = true;
		$photo = pvs_upload_dir() . "/content/models/modelphoto" . $id . "." . $ext;
		move_uploaded_file( $_FILES["modelphoto"]['tmp_name'], $photo );

		$size = getimagesize( $photo );

		$wd1 = $pvs_global_settings["thumb_width"];
		if ( isset( $size[1] ) )
		{
			if ( $size[0] < $size[1] )
			{
				$wd1 = $size[0] * $pvs_global_settings["thumb_height"] / $size[1];
			}
		}

		pvs_easyResize( $photo, $photo, 100, $wd1 );

		$sql = "update " . PVS_DB_PREFIX .
			"models set modelphoto='/content/models/modelphoto" . $id . "." . $ext .
			"' where id_parent=" . $id;
		$db->execute( $sql );
	}

	//upload release
	$_FILES["model"]['name'] = pvs_result_file( $_FILES["model"]['name'] );
	$ext = strtolower( pvs_get_file_info( $_FILES["model"]['name'], "extention" ) );
	if ( $_FILES["model"]['size'] > 0 and $_FILES["model"]['size'] < 1024 * 1024 * 5 and
		! preg_match( "/text/i", $_FILES["model"]['type'] ) and preg_match( "/.pdf$|.zip$|.jpg$|.jpeg$/i",
		$_FILES["model"]['name'] ) )
	{
		$swait = true;
		$photo = pvs_upload_dir() . "/content/models/model" . $id . "." . $ext;
		move_uploaded_file( $_FILES["model"]['tmp_name'], $photo );

		$sql = "update " . PVS_DB_PREFIX . "models set model='/content/models/model" . $id .
			"." . $ext . "' where id_parent=" . $id;
		$db->execute( $sql );
	}

	return $swait;
}
//End. The function uploads model property release

//The function deletes model property release
function pvs_model_delete( $id, $user )
{
	global $db;
	global $rs;

	if ( $user == "" )
	{
		$sql = "select * from " . PVS_DB_PREFIX . "models where id_parent=" . ( int )$id;
	} else
	{
		$sql = "select * from " . PVS_DB_PREFIX . "models where id_parent=" . ( int )$id .
			" and user='" . pvs_result( $user ) . "'";
	}
	$rs->open( $sql );
	if ( ! $rs->eof )
	{
		$sql = "delete from " . PVS_DB_PREFIX . "models where id_parent=" . ( int )$id;
		$db->execute( $sql );

		if ( $rs->row["modelphoto"] != "" and file_exists( pvs_upload_dir() . $rs->row["modelphoto"] ) )
		{
			@unlink( pvs_upload_dir() . $rs->row["modelphoto"] );
		}

		if ( $rs->row["model"] != "" and file_exists( pvs_upload_dir() . $rs->row["model"] ) )
		{
			@unlink( pvs_upload_dir() . $rs->row["model"] );
		}
	}
}
//End. The function deletes model property release

//The function deletes files of model property release
function pvs_model_delete_file( $id, $type, $user )
{
	global $db;
	global $rs;

	if ( $user == "" )
	{
		$sql = "select * from " . PVS_DB_PREFIX . "models where id_parent=" . ( int )$id;
	} else
	{
		$sql = "select * from " . PVS_DB_PREFIX . "models where id_parent=" . ( int )$id .
			" and user='" . pvs_result( $user ) . "'";
	}
	$rs->open( $sql );
	if ( ! $rs->eof )
	{
		if ( $type == "photo" )
		{
			$sql = "update " . PVS_DB_PREFIX . "models set modelphoto='' where id_parent=" . ( int )
				$id;
			$db->execute( $sql );
			if ( $rs->row["modelphoto"] != "" and file_exists( pvs_upload_dir() . $rs->row["modelphoto"] ) )
			{
				@unlink( pvs_upload_dir() . $rs->row["modelphoto"] );
			}
		} else
		{
			$sql = "update " . PVS_DB_PREFIX . "models set model='' where id_parent=" . ( int )
				$id;
			$db->execute( $sql );
			if ( $rs->row["model"] != "" and file_exists( pvs_upload_dir() . $rs->row["model"] ) )
			{
				@unlink( pvs_upload_dir() . $rs->row["model"] );
			}
		}
	}
}
//End. The function deletes files of model property release

//The function adds a new media to the database
function pvs_publication_media_add($media_type)
{
	global $site_servers;
	global $site_server_activ;
	global $pub_vars;
	global $dr;
	global $db;
	$id = 0;

	$license_type = 0;
	if ( isset( $_POST["license_type"] ) and ( int )$_POST["license_type"] > 0 )
	{
		if ( isset( $_POST["rights_id"] ) )
		{
			$license_type = ( int )$_POST["rights_id"];
		}
	} else
	{
		$license_type = 0;
	}

	//add to photo database
	$sql = "insert into " . PVS_DB_PREFIX .
		"media (media_id,title,description,keywords,userid,published,viewed,data,author,content_type,downloaded,examination,server1,free,featured,google_x,google_y,server2,editorial,adult,rights_managed,contacts,exclusive,vote_like,vote_dislike,orientation,rating,server3,refuse_reason,url,url_jpg,url_png,url_gif,url_raw,url_tiff,url_eps,watermark,duration,format,ratio,rendering,frames,holder,usa,source) values (" .
		(int)$media_type . ",'" . $pub_vars["title"] . "','" . $pub_vars["description"] . "','" . $pub_vars["keywords"] .
		"'," . $pub_vars["userid"] . "," . $pub_vars["published"] . "," . $pub_vars["viewed"] .
		"," . $pub_vars["data"] . ",'" . $pub_vars["author"] . "','" . $pub_vars["content_type"] .
		"'," . $pub_vars["downloaded"] . ",'" . $pub_vars["examination"] .
		"','" . $pub_vars["server1"] . "'," . (int) @ $pub_vars["free"] . "," . (int) @ $pub_vars["featured"] . "," . $pub_vars["google_x"] .
		"," . $pub_vars["google_y"] . ",0," . (int) @ $pub_vars["editorial"] .
		"," . (int) @ $pub_vars["adult"] . "," . $license_type . "," . (int) @ $pub_vars["contacts"] . "," . (int) @ $pub_vars["exclusive"] .
		"," . ( int )@$pub_vars["vote_like"] . "," . ( int )@$pub_vars["vote_dislike"] .
		",0,0,0,'','','','','','','','',5," . (int)@$pub_vars["duration"] . ",'" . @$pub_vars["format"] . "' ,'" . @$pub_vars["ratio"] . "','" . @$pub_vars["rendering"] . "', '" . @$pub_vars["frames"] . "','" . @$pub_vars["holder"] . "','" . @$pub_vars["usa"] . "','" . @$pub_vars["source"] . "')";
	$db->execute( $sql );
	
	//define id
	$sql = "select id from " . PVS_DB_PREFIX . "media where title='" . $pub_vars["title"] . "' order by id desc";
	$dr->open( $sql );
	$id = $dr->row['id'];
	
	//create new folder
	if ( ! file_exists( pvs_upload_dir() . $site_servers[$site_server_activ] . "/" . $id ) )
	{
		mkdir( pvs_upload_dir() . $site_servers[$site_server_activ] . "/" . $id );
		file_put_contents( pvs_upload_dir() . $site_servers[$site_server_activ] . "/" . $id . "/index.html", "" );
	}
	
	pvs_add_categories( $id );

	return $id;
}
//End. The function adds a new media to the database


//The function adds categories for a publication
function pvs_add_categories( $id, $category_prefix = '' ) {
	global $db;
	global $_POST;

	$dp = new TMySQLQuery;
	$dp->connection = $db;

	$dt = new TMySQLQuery;
	$dt->connection = $db;

	$sql = "delete from " . PVS_DB_PREFIX . "category_items where publication_id=" .
		$id;
	$db->execute( $sql );

	$sql = "select id from " . PVS_DB_PREFIX . "category";
	$dp->open( $sql );
	while ( ! $dp->eof ) {
		if ( isset( $_POST[$category_prefix . "category" . $dp->row["id"]] ) ) {
			$sql = "insert into " . PVS_DB_PREFIX .
				"category_items (category_id,publication_id) values (" . $dp->row["id"] .
				"," . $id . ")";
			$db->execute( $sql );
		}
		$dp->movenext();
	}
}
//End. The function adds categories for a publication

//The function adds photo sizes to the database
function pvs_publication_photo_sizes_add( $id, $file, $without_post, $price_license =
	"royalty_free", $price_license_id = 0 )
{
	global $dr;
	global $rs;
	global $db;
	global $_POST;

	if ( $price_license == "royalty_free" )
	{
		$sql = "select * from " . PVS_DB_PREFIX . "sizes order by priority";
		$dr->open( $sql );
		while ( ! $dr->eof )
		{
			$sql = "select id,id_parent,url,name,price from " . PVS_DB_PREFIX .
				"items where id_parent=" . $id . " and price_id=" . $dr->row["id_parent"];
			$rs->open( $sql );
			if ( $rs->eof )
			{
				$flag = false;
				if ( $without_post )
				{
					$flag = true;
				}

				if ( isset( $_POST["photo_chk" . $dr->row["id_parent"]] ) )
				{
					$flag = true;
				}

				$price = $dr->row["price"];
				if ( isset( $_POST["photo_price" . $dr->row["id_parent"]] ) )
				{
					$price = ( float )$_POST["photo_price" . $dr->row["id_parent"]];
				}

				$title = $dr->row["title"];
				if ( isset( $_POST["title" . $dr->row["id_parent"]] ) )
				{
					$title = pvs_result( $_POST["title" . $dr->row["id_parent"]] );
				}

				if ( $flag )
				{
					$sql = "insert into " . PVS_DB_PREFIX .
						"items (id_parent,name,url,price,priority,shipped,price_id) values (" . $id .
						",'" . $title . "','" . pvs_result( $file ) . "'," . $price . "," . $dr->row["priority"] .
						",0," . $dr->row["id_parent"] . ")";
					$db->execute( $sql );
				}
			}
			$dr->movenext();
		}
	}

	if ( $price_license == "rights_managed" )
	{
		$sql = "select title,price from " . PVS_DB_PREFIX . "rights_managed where id=" . ( int )
			$price_license_id;
		$dr->open( $sql );
		if ( ! $dr->eof )
		{
			$sql = "insert into " . PVS_DB_PREFIX .
				"items (id_parent,name,url,price,priority,shipped,price_id) values (" . $id .
				",'" . $dr->row["title"] . "','" . pvs_result( $file ) . "'," . $dr->row["price"] .
				",0,0," . ( int )$price_license_id . ")";
			$db->execute( $sql );
		}
	}

}
//End. The function adds photo sizes to the database

//The function adds photo watermark/color info  to the database
function pvs_publication_watermark_add( $id, $file )
{
	global $pvs_global_settings;
	global $site_server_activ;
	global $site_servers;
	global $db;
	
	pvs_define_color($id, $file, $pvs_global_settings['colors_number']);

	if ( $pvs_global_settings["watermark_photo"] != "" and file_exists( pvs_upload_dir() .
		$pvs_global_settings["watermark_photo"] ) )
	{
		pvs_watermark( $file, pvs_upload_dir() . $pvs_global_settings["watermark_photo"] );
	}

	$size = getimagesize( $file );
	$orientation = 0;
	if ( $size[1] > $size[0] )
	{
		$orientation = 1;
	}

	$sql = "update " . PVS_DB_PREFIX . "media set watermark=" . $pvs_global_settings["watermark_position"] .
		",orientation=" . $orientation .
		" where id=" . $id;
	$db->execute( $sql );

}
//End. The function adds photo watermark/color info  to the database

//The function defines google gps coordinates

function pvs_getGps( $exifCoord, $hemi )
{
	$degrees = count( $exifCoord ) > 0 ? pvs_gps2Num( $exifCoord[0] ) : 0;
	$minutes = count( $exifCoord ) > 1 ? pvs_gps2Num( $exifCoord[1] ) : 0;
	$seconds = count( $exifCoord ) > 2 ? pvs_gps2Num( $exifCoord[2] ) : 0;

	$flip = ( $hemi == 'W' or $hemi == 'S' ) ? -1 : 1;

	return $flip * ( $degrees + $minutes / 60 + $seconds / 3600 );

}

function pvs_gps2Num( $coordPart )
{
	$parts = explode( '/', $coordPart );

	if ( count( $parts ) <= 0 )
		return 0;

	if ( count( $parts ) == 1 )
		return $parts[0];

	return floatval( $parts[0] ) / floatval( $parts[1] );
}
//End. The function defines google gps coordinates

//The function adds IPTC info to the database
function pvs_publication_iptc_add( $id, $photo )
{
	global $rs;
	global $db;

	$size = getimagesize( $photo, $info );
	if ( isset( $info["APP13"] ) )
	{
		$iptc = iptcparse( $info["APP13"] );

		//Title
		if ( isset( $iptc["2#005"][0] ) and $iptc["2#005"][0] != "" )
		{
			$sql = "update " . PVS_DB_PREFIX . "media set title='" . pvs_result( $iptc["2#005"][0] ) .
				"' where id=" . $id;
			$db->execute( $sql );
		} else
		{
			if ( isset( $iptc["2#105"][0] ) and $iptc["2#105"][0] != "" )
			{
				$sql = "update " . PVS_DB_PREFIX . "media set title='" . pvs_result( $iptc["2#105"][0] ) .
					"' where id=" . $id;
				$db->execute( $sql );
			}
		}

		//Description
		if ( isset( $iptc["2#120"][0] ) and $iptc["2#120"][0] != "" )
		{
			$iptc_description = pvs_result( $iptc["2#120"][0] );

			/*
			if(isset($iptc["2#090"][0]) and $iptc["2#090"][0]!="")
			{
			$iptc_description.="\nCity: ".pvs_result($iptc["2#090"][0]);
			}
			
			if(isset($iptc["2#095"][0]) and $iptc["2#095"][0]!="")
			{
			$iptc_description.="\nState: ".pvs_result($iptc["2#095"][0]);
			}
			
			if(isset($iptc["2#101"][0]) and $iptc["2#101"][0]!="")
			{
			$iptc_description.="\nCountry: ".pvs_result($iptc["2#101"][0]);
			}
			
			if(isset($iptc["2#055"][0]) and $iptc["2#055"][0]!="")
			{			
			$date_created=pvs_result($iptc["2#055"][0]);
			if(strlen($date_created)==8)
			{
			$date_created=substr($date_created,4,2)."/".substr($date_created,6,2)."/".substr($date_created,0,4);
			}
			
			$iptc_description.="\nDate created: ".$date_created;
			}
			*/

			$sql = "update " . PVS_DB_PREFIX . "media set description='" . $iptc_description .
				"' where id=" . $id;
			$db->execute( $sql );
		}

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
				$sql = "update " . PVS_DB_PREFIX . "media set keywords='" . pvs_result( $iptc_kw ) .
					"' where id=" . $id;
				$db->execute( $sql );
			}
		}
	}

	//Google coordinates
	$exif_info = @exif_read_data( $photo, 0, true );
	if ( isset( $exif_info["GPS"]["GPSLongitude"] ) and isset( $exif_info["GPS"]['GPSLongitudeRef'] ) and
		isset( $exif_info["GPS"]["GPSLatitude"] ) and isset( $exif_info["GPS"]['GPSLatitudeRef'] ) )
	{
		$lon = pvs_getGps( $exif_info["GPS"]["GPSLongitude"], $exif_info["GPS"]['GPSLongitudeRef'] );
		$lat = pvs_getGps( $exif_info["GPS"]["GPSLatitude"], $exif_info["GPS"]['GPSLatitudeRef'] );

		$sql = "update " . PVS_DB_PREFIX . "media set google_x=" . $lat . ",google_y=" .
			$lon . " where id=" . $id;
		$db->execute( $sql );
	}

	//EXIF
	pvs_add_exif_to_database( $id, $photo );
}
//End. The function adds IPTC info to the database

//The function adds a new print to the database
function pvs_publication_prints_add( $id, $without_post )
{
	global $rs;
	global $db;
	global $pvs_global_settings;

	$sql = "select id_parent,title,price,priority,in_stock from " . PVS_DB_PREFIX .
		"prints order by priority";
	$rs->open( $sql );
	while ( ! $rs->eof )
	{

		$flag = false;
		if ( $without_post )
		{
			$flag = true;
		}
		if ( isset( $_POST["prints_chk" . $rs->row["id_parent"]] ) )
		{
			$flag = true;
		}

		$price = $rs->row["price"];
		if ( isset( $_POST["prints_price" . $rs->row["id_parent"]] ) )
		{
			$price = ( float )$_POST["prints_price" . $rs->row["id_parent"]];
		}

		$quantity = $rs->row["in_stock"];

		if ( ( pvs_is_user_admin () or $pvs_global_settings["seller_prints_quantity"] ) and
			isset( $_POST["quantity_type" . $rs->row["id_parent"]] ) and isset( $_POST["quantity" .
			$rs->row["id_parent"]] ) )
		{
			if ( $_POST["quantity_type" . $rs->row["id_parent"]] == -1 )
			{
				$quantity = -1;
			} else
			{
				$quantity = ( int )$_POST["quantity" . $rs->row["id_parent"]];
			}
		}

		if ( $flag )
		{
			$sql = "insert into " . PVS_DB_PREFIX .
				"prints_items (title,price,itemid,priority,printsid,in_stock) values ('" . $rs->
				row["title"] . "'," . $price . "," . $id . "," . $rs->row["priority"] . "," . $rs->
				row["id_parent"] . "," . $quantity . ")";
			$db->execute( $sql );
		}

		$rs->movenext();
	}
}
//End. The function adds a new print to the database



//The function uploads a video, audio, vector.
function pvs_publication_files_upload( $id, $type )
{
	global $_POST;
	global $_FILES;
	global $ds;
	global $dr;
	global $rs;
	global $db;
	global $lvideo;
	global $lpreview;
	global $laudio;
	global $lpreviewaudio;
	global $lvector;
	global $site_servers;
	global $site_server_activ;
	global $folder;
	global $swait;
	global $pvs_global_settings;

	$dp = new TMySQLQuery;
	$dp->connection = $db;

	$dt = new TMySQLQuery;
	$dt->connection = $db;

	$tmp_folder = "user_" . get_current_user_id();

	$server_id = $site_server_activ;

	$sql = "select server1 from " . PVS_DB_PREFIX . "media where id=" . ( int )
		$id;
	$ds->open( $sql );
	if ( ! $ds->eof )
	{
		$server_id = $ds->row["server1"];
	}

	$price_license = "";
	$price_license_id = 0;

	if ( ( int )$_POST["license_type"] == 0 )
	{
		$price_license = "royalty_free";

		$sql = "update " . PVS_DB_PREFIX . 
			"media set rights_managed=0 where id=" . $id;
		$db->execute( $sql );
	} else
	{
		$price_license = "rights_managed";
	}

	if ( $price_license == "royalty_free" )
	{
		$sql = "select * from " . PVS_DB_PREFIX . $type . "_types order by priority";
		$ds->open( $sql );
		while ( ! $ds->eof )
		{
			if ( $ds->row["shipped"] != 1 )
			{
				$flag = false;

				if ( ( $type == "video" and $pvs_global_settings["video_uploader"] ==
					"usual uploader" ) or ( $type == "audio" and $pvs_global_settings["audio_uploader"] ==
					"usual uploader" ) or ( $type == "vector" and $pvs_global_settings["vector_uploader"] ==
					"usual uploader" ) )
				{
					$uphoto = explode( ",", str_replace( " ", "", $ds->row["types"] ) );

					$file_fullname = pvs_result_file( $_FILES["video_sale" . $ds->row["id_parent"]]['name'] );
					$file_name = pvs_get_file_info( $file_fullname, "filename" );
					$file_extention = pvs_get_file_info( $file_fullname, "extention" );

					for ( $i = 0; $i < count( $uphoto ); $i++ )
					{
						if ( strtolower( $uphoto[$i] ) == strtolower( $file_extention ) )
						{
							$flag = true;
						}
					}

					if ( preg_match( "/text/i", $_FILES["video_sale" . $ds->row["id_parent"]]['type'] ) )
					{
						$flag = false;
					}

					if ( $type == "video" )
					{
						if ( $_FILES["video_sale" . $ds->row["id_parent"]]['size'] == 0 or $_FILES["video_sale" .
							$ds->row["id_parent"]]['size'] > 1024 * 1024 * $lvideo )
						{
							$flag = false;
						}
					}
					if ( $type == "audio" )
					{
						if ( $_FILES["video_sale" . $ds->row["id_parent"]]['size'] == 0 or $_FILES["video_sale" .
							$ds->row["id_parent"]]['size'] > 1024 * 1024 * $laudio )
						{
							$flag = false;
						}
					}
					if ( $type == "vector" )
					{
						if ( $_FILES["video_sale" . $ds->row["id_parent"]]['size'] == 0 or $_FILES["video_sale" .
							$ds->row["id_parent"]]['size'] > 1024 * 1024 * $lvector )
						{
							$flag = false;
						}
					}
				}

				if ( ( $type == "video" and $pvs_global_settings["video_uploader"] ==
					"jquery uploader" ) or ( $type == "audio" and $pvs_global_settings["audio_uploader"] ==
					"jquery uploader" ) or ( $type == "vector" and $pvs_global_settings["vector_uploader"] ==
					"jquery uploader" ) )
				{
					if ( isset( $_POST["file_sale" . $ds->row["id_parent"]] ) and $_POST["file_sale" .
						$ds->row["id_parent"]] != "" and file_exists( pvs_upload_dir() . "/content/" . $tmp_folder . "/" . pvs_result_file( $_POST["file_sale" .
						$ds->row["id_parent"]] ) ) )
					{
						$uphoto = explode( ",", str_replace( " ", "", $ds->row["types"] ) );
						$file_fullname = pvs_result_file( $_POST["file_sale" . $ds->row["id_parent"]] );
						$file_name = pvs_get_file_info( $file_fullname, "filename" );
						$file_extention = pvs_get_file_info( $file_fullname, "extention" );

						for ( $i = 0; $i < count( $uphoto ); $i++ )
						{
							if ( strtolower( $uphoto[$i] ) == strtolower( $file_extention ) )
							{
								$flag = true;
							}
						}
					}
				}

				if ( $flag == true )
				{
					if ( ( $type == "video" and $pvs_global_settings["video_uploader"] ==
						"usual uploader" ) or ( $type == "audio" and $pvs_global_settings["audio_uploader"] ==
						"usual uploader" ) or ( $type == "vector" and $pvs_global_settings["vector_uploader"] ==
						"usual uploader" ) )
					{
						$videopath = $site_servers[$server_id] . "/" . $folder . "/" . $file_fullname;
						move_uploaded_file( $_FILES["video_sale" . $ds->row["id_parent"]]['tmp_name'], pvs_upload_dir() .
							$videopath );
					}

					if ( ( $type == "video" and $pvs_global_settings["video_uploader"] ==
						"jquery uploader" ) or ( $type == "audio" and $pvs_global_settings["audio_uploader"] ==
						"jquery uploader" ) or ( $type == "vector" and $pvs_global_settings["vector_uploader"] ==
						"jquery uploader" ) )
					{
						$videopath = $site_servers[$server_id] . "/" . $folder . "/" . $file_fullname;
						@copy( pvs_upload_dir() . "/content/" . $tmp_folder . "/" .
							$file_fullname, pvs_upload_dir() . $videopath );
					}

					$swait = true;

					$sql = "select id,id_parent,url,name,price from " . PVS_DB_PREFIX .
						"items where id_parent=" . $id . " and price_id=" . $ds->row["id_parent"];
					$rs->open( $sql );
					if ( $rs->eof )
					{
						$sql = "insert into " . PVS_DB_PREFIX .
							"items (id_parent,name,url,price,priority,shipped,price_id) values (" . $id .
							",'" . pvs_result( $_POST["title" . $ds->row["id_parent"]] ) . "','" . $file_fullname .
							"'," . floatval( $_POST[$type . "_price" . $ds->row["id_parent"]] ) . "," . $ds->
							row["priority"] . ",0," . $ds->row["id_parent"] . ")";
						$db->execute( $sql );
					} else
					{
						$sql = "update " . PVS_DB_PREFIX . "items set name='" . pvs_result( $_POST["title" .
							$ds->row["id_parent"]] ) . "',url='" . $file_fullname . "',price=" . floatval( $_POST[$type .
							"_price" . $ds->row["id_parent"]] ) . " where id_parent=" . $id .
							" and price_id=" . $ds->row["id_parent"];
						$db->execute( $sql );
					}

					//Synchronize related prices
					if ( $ds->row["thesame"] > 0 )
					{
						$sql = "select * from " . PVS_DB_PREFIX . $type . "_types where id_parent<>" . $ds->
							row["id_parent"] . " and thesame=" . $ds->row["thesame"] . " order by priority";
						$dp->open( $sql );
						while ( ! $dp->eof )
						{
							$sql = "select id,id_parent,url,name,price from " . PVS_DB_PREFIX .
								"items where id_parent=" . $id . " and price_id=" . $dp->row["id_parent"];
							$dt->open( $sql );
							if ( $dt->eof )
							{
								$sql = "insert into " . PVS_DB_PREFIX .
									"items (id_parent,name,url,price,priority,shipped,price_id) values (" . $id .
									",'" . pvs_result( $_POST["title" . $dp->row["id_parent"]] ) . "','" . $file_fullname .
									"'," . floatval( $_POST[$type . "_price" . $dp->row["id_parent"]] ) . "," . $dp->
									row["priority"] . ",0," . $dp->row["id_parent"] . ")";
								$db->execute( $sql );
							} else
							{
								$sql = "update " . PVS_DB_PREFIX . "items set name='" . pvs_result( $_POST["title" .
									$dp->row["id_parent"]] ) . "',url='" . $file_fullname . "',price=" . floatval( $_POST[$type .
									"_price" . $dp->row["id_parent"]] ) . " where id_parent=" . $id .
									" and price_id=" . $dp->row["id_parent"];
								$db->execute( $sql );
							}

							$dp->movenext();
						}
					}
					//End. Synchronize related prices
				}
			} else
			{
				//Shipped
				if ( isset( $_POST[$type . "_chk" . $ds->row["id_parent"]] ) )
				{
					$sql = "select id,id_parent,url,name,price from " . PVS_DB_PREFIX .
						"items where id_parent=" . $id . " and price_id=" . $ds->row["id_parent"];
					$rs->open( $sql );
					if ( $rs->eof )
					{
						$sql = "insert into " . PVS_DB_PREFIX .
							"items (id_parent,name,url,price,priority,shipped,price_id) values (" . $id .
							",'" . pvs_result( $_POST["title" . $ds->row["id_parent"]] ) . "',''," .
							floatval( $_POST[$type . "_price" . $ds->row["id_parent"]] ) . "," . $ds->row["priority"] .
							",1," . $ds->row["id_parent"] . ")";
						$db->execute( $sql );
						$swait = true;
					} else
					{
						$sql = "update " . PVS_DB_PREFIX . "items set name='" . pvs_result( $_POST["title" .
							$ds->row["id_parent"]] ) . "',price=" . floatval( $_POST[$type . "_price" . $ds->
							row["id_parent"]] ) . " where id_parent=" . $id . " and price_id=" . $ds->row["id_parent"];
						$db->execute( $sql );
					}
				}
				//End. Shipped
			}
			$ds->movenext();
		}
	}

	if ( $price_license == "rights_managed" )
	{
		$sql = "select formats,id,price,title from " . PVS_DB_PREFIX .
			"rights_managed where id=" . ( int )@$_POST["rights_id"];
		$ds->open( $sql );
		if ( ! $ds->eof )
		{
			$flag = false;

			if ( ( $type == "video" and $pvs_global_settings["video_uploader"] ==
				"usual uploader" ) or ( $type == "audio" and $pvs_global_settings["audio_uploader"] ==
				"usual uploader" ) or ( $type == "vector" and $pvs_global_settings["vector_uploader"] ==
				"usual uploader" ) )
			{
				$uphoto = explode( ",", str_replace( " ", "", $ds->row["formats"] ) );

				$file_fullname = pvs_result_file( $_FILES["video_rights"]['name'] );
				$file_name = pvs_get_file_info( $file_fullname, "filename" );
				$file_extention = pvs_get_file_info( $file_fullname, "extention" );

				for ( $i = 0; $i < count( $uphoto ); $i++ )
				{
					if ( strtolower( $uphoto[$i] ) == strtolower( $file_extention ) )
					{
						$flag = true;
					}
				}

				if ( preg_match( "/text/i", $_FILES["video_rights"]['type'] ) )
				{
					$flag = false;
				}

				if ( $_FILES["video_rights"]['size'] == 0 and $_FILES["video_rights"]['size'] >
					1024 * 1024 * $lvideo )
				{
					$flag = false;
				}
			}

			if ( ( $type == "video" and $pvs_global_settings["video_uploader"] ==
				"jquery uploader" ) or ( $type == "audio" and $pvs_global_settings["audio_uploader"] ==
				"jquery uploader" ) or ( $type == "vector" and $pvs_global_settings["vector_uploader"] ==
				"jquery uploader" ) )
			{
				if ( isset( $_POST["file_sale100"] ) and $_POST["file_sale100"] != "" and
					file_exists( pvs_upload_dir() . "/content/" . $tmp_folder .
					"/" . pvs_result_file( $_POST["file_sale100"] ) ) )
				{
					$uphoto = explode( ",", str_replace( " ", "", $ds->row["formats"] ) );
					$file_fullname = pvs_result_file( $_POST["file_sale100"] );
					$file_name = pvs_get_file_info( $file_fullname, "filename" );
					$file_extention = pvs_get_file_info( $file_fullname, "extention" );

					for ( $i = 0; $i < count( $uphoto ); $i++ )
					{
						if ( strtolower( $uphoto[$i] ) == strtolower( $file_extention ) )
						{
							$flag = true;
						}
					}
				}
			}

			if ( $flag == true )
			{
				if ( ( $type == "video" and $pvs_global_settings["video_uploader"] ==
					"usual uploader" ) or ( $type == "audio" and $pvs_global_settings["audio_uploader"] ==
					"usual uploader" ) or ( $type == "vector" and $pvs_global_settings["vector_uploader"] ==
					"usual uploader" ) )
				{
					$videopath = $site_servers[$server_id] . "/" . $folder . "/" . $file_fullname;
					move_uploaded_file( $_FILES["video_rights"]['tmp_name'], pvs_upload_dir() .
						$videopath );
				}

				if ( ( $type == "video" and $pvs_global_settings["video_uploader"] ==
					"jquery uploader" ) or ( $type == "audio" and $pvs_global_settings["audio_uploader"] ==
					"jquery uploader" ) or ( $type == "vector" and $pvs_global_settings["vector_uploader"] ==
					"jquery uploader" ) )
				{
					$videopath = $site_servers[$server_id] . "/" . $folder . "/" . $file_fullname;
					@copy( pvs_upload_dir() . "/content/" . $tmp_folder . "/" .
						$file_fullname, pvs_upload_dir() . $videopath );
				}

				$swait = true;

				$sql = "update " . PVS_DB_PREFIX . "media set rights_managed=" . ( int )@$_POST["rights_id"] . " where id=" . $id;
				$db->execute( $sql );

				$sql = "select id,id_parent,url,name,price from " . PVS_DB_PREFIX .
					"items where id_parent=" . $id . " and price_id=" . $ds->row["id"];
				$rs->open( $sql );

				if ( $rs->eof )
				{
					$sql = "insert into " . PVS_DB_PREFIX .
						"items (id_parent,name,url,price,priority,shipped,price_id) values (" . $id .
						",'" . $ds->row["title"] . "','" . $file_fullname . "'," . $ds->row["price"] .
						",0,0," . $ds->row["id"] . ")";
					$db->execute( $sql );
				} else
				{
					$sql = "update " . PVS_DB_PREFIX . "items set url='" . $file_fullname .
						"' where id_parent=" . $id . " and price_id=" . $ds->row["id"];
					$db->execute( $sql );
				}
			}
		}
	}

	//Upload video previews for usual uploader
	if ( ! $pvs_global_settings["ffmpeg"] and $type == "video" )
	{
		if ( $pvs_global_settings["video_uploader"] == "usual uploader" )
		{
			//upload video preview
			$mass_preview = array( "preview", "preview_rights" );
			foreach ( $mass_preview as $key => $value )
			{
				if ( isset( $_FILES[$value]['name'] ) )
				{
					$file_fullname = pvs_result_file( $_FILES[$value]['name'] );
					$file_name = pvs_get_file_info( $file_fullname, "filename" );
					$file_extention = pvs_get_file_info( $file_fullname, "extention" );

					if ( ( strtolower( $file_extention ) == "flv" or strtolower( $file_extention ) ==
						"wmv" or strtolower( $file_extention ) == "mov" or strtolower( $file_extention ) ==
						"mp4" ) and ! preg_match( "/text/i", $_FILES[$value]['type'] ) )
					{
						if ( $_FILES[$value]['size'] > 0 and $_FILES[$value]['size'] < 1024 * 1024 * $lpreview )
						{
							$vp = $site_servers[$server_id] . "/" . $folder . "/thumb." . $file_extention;
							move_uploaded_file( $_FILES[$value]['tmp_name'], pvs_upload_dir() . $vp );

							$swait = true;
						}
					}
				}
			}
		}
	}
	//End. Upload video previews for usual uploader

	//Upload audio previews for usual uploader
	if ( ! $pvs_global_settings["sox"] and $type == "audio" )
	{
		if ( $pvs_global_settings["audio_uploader"] == "usual uploader" )
		{
			$mass_preview = array( "preview", "preview_rights" );
			foreach ( $mass_preview as $key => $value )
			{
				if ( isset( $_FILES[$value]['name'] ) )
				{
					$file_fullname = pvs_result_file( $_FILES[$value]['name'] );
					$file_name = pvs_get_file_info( $file_fullname, "filename" );
					$file_extention = pvs_get_file_info( $file_fullname, "extention" );

					if ( strtolower( $file_extention ) == "mp3" and ! preg_match( "/text/i", $_FILES[$value]['type'] ) )
					{
						if ( $_FILES[$value]['size'] > 0 and $_FILES[$value]['size'] < 1024 * 1024 * $lpreview )
						{
							$vp = $site_servers[$server_id] . "/" . $folder . "/thumb." . $file_extention;
							move_uploaded_file( $_FILES[$value]['tmp_name'], pvs_upload_dir() . $vp );

							$swait = true;
						}
					}
				}
			}
		}
	}
	//End. Upload audio previews for usual uploader

	//Upload video and audio jpg previews for usual uploader
	if ( ( ! $pvs_global_settings["ffmpeg"] and $type == "video" ) or $type ==
		"audio" )
	{
		if ( ( $pvs_global_settings["video_uploader"] == "usual uploader" and $type ==
			"video" ) or ( $pvs_global_settings["audio_uploader"] == "usual uploader" and $type ==
			"audio" ) )
		{
			//upload photo preview
			$mass_preview2 = array( "preview2", "preview2_rights" );
			foreach ( $mass_preview2 as $key => $value )
			{
				if ( isset( $_FILES[$value]['name'] ) )
				{
					$file_fullname = pvs_result_file( $_FILES[$value]['name'] );
					$file_name = pvs_get_file_info( $file_fullname, "filename" );
					$file_extention = pvs_get_file_info( $file_fullname, "extention" );

					if ( ( strtolower( $file_extention ) == "jpg" or strtolower( $file_extention ) ==
						"jpeg" ) and ! preg_match( "/text/i", $_FILES[$value]['type'] ) )
					{
						if ( $_FILES[$value]['size'] > 0 and $_FILES[$value]['size'] < 12048 * 1024 )
						{
							$vp = $site_servers[$server_id] . "/" . $folder . "/thumb." . $file_extention;
							$vp_big = $site_servers[$server_id] . "/" . $folder . "/thumb100." .
								$file_extention;

							move_uploaded_file( $_FILES[$value]['tmp_name'], pvs_upload_dir() . $vp );
							copy( pvs_upload_dir() . $vp, pvs_upload_dir() . $vp_big );

							pvs_photo_resize( pvs_upload_dir() . $vp, pvs_upload_dir() . $vp,
								1 );
							pvs_photo_resize( pvs_upload_dir() . $vp_big, pvs_upload_dir() .
								$vp_big, 2 );
						}
					}
				}
			}
		}
	}
	//End. Upload video and audio previews for usual uploader

	//Upload vector jpg and zip previews for usual uploader
	if ( $pvs_global_settings["vector_uploader"] == "usual uploader" and $type ==
		"vector" )
	{
		//upload photo preview
		$mass_preview2 = array( "preview2", "preview2_rights" );
		foreach ( $mass_preview2 as $key => $value )
		{
			if ( isset( $_FILES[$value]['name'] ) )
			{
				$file_fullname = pvs_result_file( $_FILES[$value]['name'] );
				$file_name = pvs_get_file_info( $file_fullname, "filename" );
				$file_extention = pvs_get_file_info( $file_fullname, "extention" );

				if ( ( strtolower( $file_extention ) == "jpg" or strtolower( $file_extention ) ==
					"jpeg" ) and ! preg_match( "/text/i", $_FILES[$value]['type'] ) )
				{
					if ( $_FILES[$value]['size'] > 0 and $_FILES[$value]['size'] < 12048 * 1024 )
					{
						$vp = $site_servers[$server_id] . "/" . $folder . "/1." . $file_extention;
						move_uploaded_file( $_FILES[$value]['tmp_name'], pvs_upload_dir() . $vp );
						$swait = true;

						pvs_photo_resize( pvs_upload_dir() . $vp, pvs_upload_dir() . $site_servers[$server_id] . "/" . $folder . "/thumb1.jpg", 1 );

						pvs_photo_resize( pvs_upload_dir() . $vp, pvs_upload_dir() . $site_servers[$server_id] . "/" . $folder . "/thumb2.jpg", 2 );

						pvs_publication_watermark_add( $id, pvs_upload_dir() . $site_servers[$server_id] . "/" . $folder . "/thumb2.jpg" );

						pvs_publication_iptc_add( $id, pvs_upload_dir() . $vp );

						copy( pvs_upload_dir() . $vp, pvs_upload_dir() . $site_servers[$server_id] . "/" . $folder . "/thumb_original.jpg" );

						@unlink( pvs_upload_dir() . $vp );
					}
				}
			}

			//Upload zip preview
			if ( strtolower( $file_extention ) == "zip" and ! preg_match( "/text/i", $_FILES[$value]['type'] ) )
			{
				if ( $_FILES[$value]['size'] > 0 and $_FILES[$value]['size'] < 12048 * 1024 )
				{
					move_uploaded_file( $_FILES[$value]['tmp_name'], pvs_upload_dir() . $site_servers[$server_id] . "/" . $folder . "/temp." . $file_extention );
					pvs_publication_zip_preview( $site_servers[$server_id] . "/" . $folder .
						"/temp." . $file_extention );
					$swait = true;
				}
			}
			//End Upload zip preview
		}
	}
	//End. Upload vector jpg and zip previews for usual uploader

	//Upload video previews for jquery uploader
	if ( ! $pvs_global_settings["ffmpeg"] and $type == "video" )
	{
		if ( $pvs_global_settings["video_uploader"] == "jquery uploader" )
		{
			if ( $price_license == "rights_managed" )
			{
				$file_video_name = "file_sale2";
				$file_photo_name = "file_sale3";
			} else
			{
				$file_video_name = "file_sale0";
				$file_photo_name = "file_sale1";
			}

			//upload video preview
			if ( isset( $_POST[$file_video_name] ) and $_POST[$file_video_name] != "" and
				file_exists( pvs_upload_dir(). "/content/" . $tmp_folder . "/" . pvs_result_file( $_POST[$file_video_name] ) ) )
			{
				$file_fullname = pvs_result_file( $_POST[$file_video_name] );
				$file_name = pvs_get_file_info( $file_fullname, "filename" );
				$file_extention = pvs_get_file_info( $file_fullname, "extention" );

				if ( ( strtolower( $file_extention ) == "flv" or strtolower( $file_extention ) ==
					"wmv" or strtolower( $file_extention ) == "mov" or strtolower( $file_extention ) ==
					"mp4" ) )
				{
					$vp = $site_servers[$server_id] . "/" . $folder . "/thumb." . $file_extention;
					@copy( pvs_upload_dir() . "/content/" . $tmp_folder . "/" . pvs_result_file( $_POST[$file_video_name] ), pvs_upload_dir() . $vp );

					$swait = true;
				}
			}
		}
	}
	//End. Upload video previews for jquery uploader

	//Upload audio previews for jquery uploader
	if ( $type == "audio" )
	{
		if ( $pvs_global_settings["audio_uploader"] == "jquery uploader" )
		{
			if ( $price_license == "rights_managed" )
			{
				$file_video_name = "file_sale2";
				$file_photo_name = "file_sale3";
			} else
			{
				$file_video_name = "file_sale0";
				$file_photo_name = "file_sale1";
			}
		}
	}

	if ( ! $pvs_global_settings["sox"] and $type == "audio" )
	{
		if ( $pvs_global_settings["audio_uploader"] == "jquery uploader" )
		{
			//upload video preview
			if ( isset( $_POST[$file_video_name] ) and $_POST[$file_video_name] != "" and
				file_exists( pvs_upload_dir() . "/content/" . $tmp_folder .
				"/" . pvs_result_file( $_POST[$file_video_name] ) ) )
			{
				$file_fullname = pvs_result_file( $_POST[$file_video_name] );
				$file_name = pvs_get_file_info( $file_fullname, "filename" );
				$file_extention = pvs_get_file_info( $file_fullname, "extention" );

				if ( strtolower( $file_extention ) == "mp3" )
				{
					$vp = $site_servers[$server_id] . "/" . $folder . "/thumb." . $file_extention;
					@copy( pvs_upload_dir() . "/content/" . $tmp_folder . "/" . pvs_result_file( $_POST[$file_video_name] ), pvs_upload_dir() . $vp );

					$swait = true;
				}
			}
		}
	}
	//End. Upload video previews for jquery uploader

	//Upload video and audio jpg previews for jquery uploader
	if ( ( ! $pvs_global_settings["ffmpeg"] and $type == "video" ) or $type ==
		"audio" )
	{
		if ( ( $pvs_global_settings["video_uploader"] == "jquery uploader" and $type ==
			"video" ) or ( $pvs_global_settings["audio_uploader"] == "jquery uploader" and $type ==
			"audio" ) )
		{
			//upload photo preview
			if ( isset( $_POST[$file_photo_name] ) and $_POST[$file_photo_name] != "" and
				file_exists( pvs_upload_dir() . "/content/" . $tmp_folder . "/" . pvs_result_file( $_POST[$file_photo_name] ) ) )
			{
				$file_fullname = pvs_result_file( $_POST[$file_photo_name] );
				$file_name = pvs_get_file_info( $file_fullname, "filename" );
				$file_extention = pvs_get_file_info( $file_fullname, "extention" );

				if ( ( strtolower( $file_extention ) == "jpg" or strtolower( $file_extention ) ==
					"jpeg" ) )
				{
					$vp = $site_servers[$server_id] . "/" . $folder . "/thumb." . $file_extention;
					$vp_big = $site_servers[$server_id] . "/" . $folder . "/thumb100." . $file_extention;

					@copy( pvs_upload_dir() . "/content/" . $tmp_folder . "/" . pvs_result_file( $_POST[$file_photo_name] ), pvs_upload_dir() . $vp );
					@copy( pvs_upload_dir() . "/content/" . $tmp_folder . "/" . pvs_result_file( $_POST[$file_photo_name] ), pvs_upload_dir() . $vp_big );

					pvs_photo_resize( pvs_upload_dir() . $vp, pvs_upload_dir() . $vp, 1 );
					pvs_photo_resize( pvs_upload_dir() . $vp_big, pvs_upload_dir() . $vp_big, 2 );

					$swait = true;
				}
			}
		}
	}
	//End. Upload video and audio jpg previews for jquery uploader

	//Upload vector jpg and zip previews for jquery uploader
	if ( $type == "vector" and $pvs_global_settings["vector_uploader"] ==
		"jquery uploader" )
	{
		$mass_preview2 = array(
			"file_sale0",
			"file_sale1",
			"file_sale2",
			"file_sale3" );
		foreach ( $mass_preview2 as $key => $value )
		{
			//upload photo preview
			if ( isset( $_POST[$value] ) and $_POST[$value] != "" and file_exists( pvs_upload_dir() . "/content/" . $tmp_folder . "/" . pvs_result_file( $_POST[$value] ) ) )
			{
				$file_fullname = pvs_result_file( $_POST[$value] );
				$file_name = pvs_get_file_info( $file_fullname, "filename" );
				$file_extention = pvs_get_file_info( $file_fullname, "extention" );

				if ( $value == "file_sale0" or $value == "file_sale2" )
				{
					if ( ( strtolower( $file_extention ) == "jpg" or strtolower( $file_extention ) ==
						"jpeg" ) )
					{
						$vp = $site_servers[$server_id] . "/" . $folder . "/thumb1." . $file_extention;
						$vp_big = $site_servers[$server_id] . "/" . $folder . "/thumb2." . $file_extention;

						@copy( pvs_upload_dir() . "/content/" . $tmp_folder . "/" . pvs_result_file( $_POST[$value] ), pvs_upload_dir() . $vp );
						@copy( pvs_upload_dir() . "/content/" . $tmp_folder . "/" . pvs_result_file( $_POST[$value] ), pvs_upload_dir() . $vp_big );
						@copy( pvs_upload_dir() . "/content/" . $tmp_folder . "/" . pvs_result_file( $_POST[$value] ), pvs_upload_dir() . $site_servers[$server_id] . "/" . $folder . "/thumb_original.jpg" );

						pvs_publication_iptc_add( $id, pvs_upload_dir() . $vp );

						pvs_photo_resize( pvs_upload_dir() . $vp, pvs_upload_dir() . $vp,
							1 );
						pvs_photo_resize( pvs_upload_dir() . $vp_big, pvs_upload_dir() . $vp_big, 2 );

						pvs_publication_watermark_add( $id, pvs_upload_dir() . $vp_big );

						$swait = true;
					}

					if ( strtolower( $file_extention ) == "zip" )
					{
						copy( pvs_upload_dir() . "/content/" . $tmp_folder . "/" . pvs_result_file( $_POST[$value] ), pvs_upload_dir() . $site_servers[$server_id] . "/" . $folder . "/" . pvs_result_file( $_POST[$value] ) );
						pvs_publication_zip_preview( $site_servers[$server_id] . "/" . $folder . "/" . pvs_result_file( $_POST[$value] ) );
						$swait = true;
					}
				}
			}
		}
	}
	//End. Upload vector jpg and zip previews for jquery uploader

	//Generate video previews by ffmpeg
	if ( $type == "video" and $pvs_global_settings["ffmpeg"] and $pvs_global_settings["ffmpeg_cron"] )
	{
		$sql = "select filename1 from " . PVS_DB_PREFIX .
			"filestorage_files where id_parent=" . $id;
		$ds->open( $sql );
		if ( $ds->eof )
		{
			if ( ! file_exists( pvs_upload_dir() . $site_servers[$server_id] . "/" . $folder . "/thumb.flv" ) and ! file_exists( pvs_upload_dir() . $site_servers[$server_id] . "/" . $folder . "/thumb.mp4" ) )
			{
				$sql = "insert into " . PVS_DB_PREFIX .
					"ffmpeg_cron (id,data1,data2,generation) values (" . $id . "," . pvs_get_time( date
					( "H" ), date( "i" ), date( "s" ), date( "m" ), date( "d" ), date( "Y" ) ) .
					",0," . ( int )@$_POST["generation"] . ")";
				$db->execute( $sql );

				$sql = "update " . PVS_DB_PREFIX . "media set published=0 where id=" . $id;
				$db->execute( $sql );
			}
		}
	}

	if ( $type == "video" and $pvs_global_settings["ffmpeg"] and ! $pvs_global_settings["ffmpeg_cron"] )
	{
		//FFMPEG generation
		if ( $price_license == "royalty_free" )
		{
			//Define a source file for generation
			$generation_file = "";
			$generation_file2 = "";
			$sql = "select * from " . PVS_DB_PREFIX . "video_types order by priority";
			$ds->open( $sql );
			while ( ! $ds->eof )
			{
				if ( $pvs_global_settings["video_uploader"] == "usual uploader" )
				{
					if ( $_FILES["video_sale" . $ds->row["id_parent"]]['name'] != "" )
					{
						if ( file_exists( pvs_upload_dir() . $site_servers[$server_id] .
							"/" . $folder . "/" . $_FILES["video_sale" . $ds->row["id_parent"]]['name'] ) )
						{
							$generation_file2 = pvs_upload_dir() . $site_servers[$server_id] .
								"/" . $folder . "/" . $_FILES["video_sale" . $ds->row["id_parent"]]['name'];

							if ( isset( $_POST["generation"] ) and ( int )$_POST["generation"] == $ds->row["id_parent"] )
							{
								$generation_file = pvs_upload_dir() . $site_servers[$server_id] .
									"/" . $folder . "/" . $_FILES["video_sale" . $ds->row["id_parent"]]['name'];
							}
						}
					}
				}

				if ( $pvs_global_settings["video_uploader"] == "jquery uploader" )
				{
					if ( isset( $_POST["file_sale" . $ds->row["id_parent"]] ) and $_POST["file_sale" .
						$ds->row["id_parent"]] != "" and file_exists( pvs_upload_dir() . "/content/" . $tmp_folder . "/" . pvs_result_file( $_POST["file_sale" .
						$ds->row["id_parent"]] ) ) )
					{
						$generation_file2 = pvs_upload_dir() . $site_servers[$server_id] . "/" . $folder . "/" . pvs_result_file( $_POST["file_sale" . $ds->row["id_parent"]] );

						if ( isset( $_POST["generation"] ) and ( int )$_POST["generation"] == $ds->row["id_parent"] )
						{
							$generation_file = pvs_upload_dir() . $site_servers[$server_id] . "/" . $folder . "/" . pvs_result_file( $_POST["file_sale" . $ds->row["id_parent"]] );
						}
					}
				}

				$ds->movenext();
			}

			if ( $generation_file == "" )
			{
				$generation_file = $generation_file2;
			}

			if ( $generation_file != "" )
			{
				$fln = pvs_generate_video_preview( $generation_file, 0, 0 );
			}
		}

		if ( $price_license == "rights_managed" )
		{
			if ( $pvs_global_settings["video_uploader"] == "usual uploader" )
			{
				if ( $_FILES["video_rights"]['name'] != "" )
				{
					if ( file_exists( pvs_upload_dir() . $site_servers[$server_id] . "/" . $folder . "/" . $_FILES["video_rights"]['name'] ) )
					{
						$generation_file = pvs_upload_dir() . $site_servers[$server_id] . "/" . $folder . "/" . $_FILES["video_rights"]['name'];

						$fln = pvs_generate_video_preview( $generation_file, 0, 0 );
					}
				}
			}

			if ( $pvs_global_settings["video_uploader"] == "jquery uploader" )
			{
				if ( isset( $_POST["file_sale100"] ) and $_POST["file_sale100"] != "" and file_exists( pvs_upload_dir() . "/content/" . $tmp_folder . "/" . pvs_result_file( $_POST["file_sale100"] ) ) )
				{
					$generation_file = pvs_upload_dir() . $site_servers[$server_id] . "/" . $folder . "/" . pvs_result_file( $_POST["file_sale100"] );

					$fln = pvs_generate_video_preview( $generation_file, 0, 0 );
				}
			}
		}
	}
	//End. Generate video previews by ffmpeg

	//Generate audio previews by sox
	if ( $type == "audio" and $pvs_global_settings["sox"] )
	{
		//Sox generation
		if ( $price_license == "royalty_free" )
		{
			//Define a source file for generation
			$generation_file = "";
			$generation_file2 = "";
			$sql = "select * from audio_types order by priority";
			$ds->open( $sql );
			while ( ! $ds->eof )
			{
				if ( $pvs_global_settings["audio_uploader"] == "usual uploader" )
				{
					if ( $_FILES["video_sale" . $ds->row["id_parent"]]['name'] != "" )
					{
						if ( file_exists( pvs_upload_dir() . $site_servers[$server_id] .
							"/" . $folder . "/" . $_FILES["video_sale" . $ds->row["id_parent"]]['name'] ) )
						{
							$generation_file2 = pvs_upload_dir() . $site_servers[$server_id] .
								"/" . $folder . "/" . $_FILES["video_sale" . $ds->row["id_parent"]]['name'];

							if ( isset( $_POST["generation"] ) and ( int )$_POST["generation"] == $ds->row["id_parent"] )
							{
								$generation_file = pvs_upload_dir() . $site_servers[$server_id] .
									"/" . $folder . "/" . $_FILES["video_sale" . $ds->row["id_parent"]]['name'];
							}
						}
					}
				}

				if ( $pvs_global_settings["audio_uploader"] == "jquery uploader" )
				{
					if ( isset( $_POST["file_sale" . $ds->row["id_parent"]] ) and $_POST["file_sale" .
						$ds->row["id_parent"]] != "" and file_exists( pvs_upload_dir() . "/content/" . $tmp_folder . "/" . pvs_result_file( $_POST["file_sale" .
						$ds->row["id_parent"]] ) ) )
					{
						$generation_file2 = pvs_upload_dir() . $site_servers[$server_id] .
							"/" . $folder . "/" . pvs_result_file( $_POST["file_sale" . $ds->row["id_parent"]] );

						if ( isset( $_POST["generation"] ) and ( int )$_POST["generation"] == $ds->row["id_parent"] )
						{
							$generation_file = pvs_upload_dir() . $site_servers[$server_id] . "/" . $folder . "/" . pvs_result_file( $_POST["file_sale" . $ds->row["id_parent"]] );
						}
					}
				}

				$ds->movenext();
			}

			if ( $generation_file == "" )
			{
				$generation_file = $generation_file2;
			}

			if ( $generation_file != "" )
			{
				pvs_generate_mp3( $generation_file, pvs_upload_dir() . $site_servers[$server_id] . "/" . $folder . "/thumb.mp3" );
			}
		}

		if ( $price_license == "rights_managed" )
		{
			if ( $pvs_global_settings["audio_uploader"] == "usual uploader" )
			{
				if ( $_FILES["video_rights"]['name'] != "" )
				{
					if ( file_exists( pvs_upload_dir() . $site_servers[$server_id] .
						"/" . $folder . "/" . $_FILES["video_rights"]['name'] ) )
					{
						$generation_file = pvs_upload_dir() . $site_servers[$server_id] .
							"/" . $folder . "/" . $_FILES["video_rights"]['name'];

						pvs_generate_mp3( $generation_file, pvs_upload_dir() . $site_servers[$server_id] .
							"/" . $folder . "/thumb.mp3" );
					}
				}
			}

			if ( $pvs_global_settings["audio_uploader"] == "jquery uploader" )
			{
				if ( isset( $_POST["file_sale100"] ) and $_POST["file_sale100"] != "" and
					file_exists( pvs_upload_dir() . "/content/" . $tmp_folder .
					"/" . pvs_result_file( $_POST["file_sale100"] ) ) )
				{
					$generation_file = pvs_upload_dir() . $site_servers[$server_id] .
						"/" . $folder . "/" . pvs_result_file( $_POST["file_sale100"] );

					pvs_generate_mp3( $generation_file, pvs_upload_dir() . $site_servers[$server_id] .
						"/" . $folder . "/thumb.mp3" );
				}
			}
		}
	}
	//End. Generate audio previews by sox

}
//End. The function uploads a video, audio, vector.





//The function updates media into the database
function pvs_publication_media_update( $id, $userid )
{
	global $pub_vars;
	global $dr;
	global $db;

	$com = "";
	if ( $userid != 0 )
	{
		$com = "  and (userid=" . $pub_vars["userid"] . " or author='" . $pub_vars["author"] .
			"')";
	}

	$license_type = 0;
	if ( isset( $_POST["license_type"] ) and ( int )$_POST["license_type"] > 0 )
	{
		if ( isset( $_POST["rights_id"] ) )
		{
			$license_type = ( int )$_POST["rights_id"];
		}
	} else
	{
		$license_type = 0;
	}

	$sql = "update " . PVS_DB_PREFIX . "media set title='" . $pub_vars["title"] .
		"',description='" . $pub_vars["description"] . "',keywords='" . $pub_vars["keywords"] .
		"',free=" . (int)@$pub_vars["free"] . ",downloaded=" .
		$pub_vars["downloaded"] . ",viewed=" . $pub_vars["viewed"] . ",data=" . $pub_vars["data"] .
		",content_type='" . $pub_vars["content_type"] . "',featured=" . (int)@$pub_vars["featured"] .
		",published=" . (int)@$pub_vars["published"] . ",author='" . $pub_vars["author"] .
		"',google_x=" . $pub_vars["google_x"] . ",google_y=" . $pub_vars["google_y"] .
		",editorial=" . (int)@$pub_vars["editorial"] .
		",adult=" . (int)@$pub_vars["adult"] . ",rights_managed=" . $license_type .
		",contacts=" . (int)@$pub_vars["contacts"] . ",exclusive=" . (int)@$pub_vars["exclusive"] .
		",vote_like=" . ( int )@$pub_vars["vote_like"] . ",vote_dislike=" . ( int )@$pub_vars["vote_dislike"] .
		",usa='" . @$pub_vars["usa"] . "',duration='" . (int)@$pub_vars["duration"] .
		"',format='" . @$pub_vars["format"] . "',ratio='" . @$pub_vars["ratio"] .
		"',rendering='" . @$pub_vars["rendering"] . "',frames='" . @$pub_vars["frames"] .
		"',holder='" . @$pub_vars["holder"] . "',source='" . @$pub_vars["source"] . "' where id=" . $id . $com;
	$db->execute( $sql );
	
	pvs_add_categories( $id );
}
//End. The function updates media into the database

//The function makes previews from zip archive of jpg photos
function pvs_publication_zip_preview( $zarc )
{
	global $_POST;
	global $_FILES;
	global $site_servers;
	global $site_server_activ;
	global $folder;

	$vp = $zarc;


	$archive = new PclZip( pvs_upload_dir() . $vp );
	if ( $archive->extract( PCLZIP_OPT_PATH, pvs_upload_dir() .
		$site_servers[$site_server_activ] . "/" . $folder ) == true )
	{
		$afiles = array();

		$dir = opendir( pvs_upload_dir() . $site_servers[$site_server_activ] .
			"/" . $folder );
		while ( $file = readdir( $dir ) )
		{
			if ( $file <> "." && $file <> ".." )
			{
				if ( preg_match( "/.jpg$|.jpeg$/i", $file ) and ! preg_match( "/thumb/i", $file ) )
				{
					$file = pvs_result_file( $file );
					$afiles[count( $afiles )] = $file;
				} else
				{
					@unlink( pvs_upload_dir() . $site_servers[$site_server_activ] .
						"/" . $folder . "/" . $file );
				}
				if ( preg_match( "/php/i", $file ) )
				{
					@unlink( pvs_upload_dir() . $site_servers[$site_server_activ] .
						"/" . $folder . "/" . $file );
				}
			}
		}
		closedir( $dir );
		@unlink( pvs_upload_dir() . $vp );

		sort( $afiles );
		reset( $afiles );

		for ( $n = 0; $n < count( $afiles ); $n++ )
		{
			$file = $afiles[$n];

			pvs_photo_resize( pvs_upload_dir() . $site_servers[$site_server_activ] .
				"/" . $folder . "/" . $file, pvs_upload_dir() . $site_servers[$site_server_activ] .
				"/" . $folder . "/thumbs" . $n . ".jpg", 1 );
			pvs_photo_resize( pvs_upload_dir() . $site_servers[$site_server_activ] .
				"/" . $folder . "/" . $file, pvs_upload_dir() . $site_servers[$site_server_activ] .
				"/" . $folder . "/thumbz" . $n . ".jpg", 2 );

			pvs_publication_watermark_add( 0, pvs_upload_dir() . $site_servers[$site_server_activ] .
				"/" . $folder . "/thumbz" . $n . ".jpg" );

			if ( $n == 0 )
			{
				pvs_photo_resize( pvs_upload_dir() . $site_servers[$site_server_activ] .
					"/" . $folder . "/" . $file, pvs_upload_dir() . $site_servers[$site_server_activ] .
					"/" . $folder . "/thumb1.jpg", 1 );
				pvs_photo_resize( pvs_upload_dir() . $site_servers[$site_server_activ] .
					"/" . $folder . "/" . $file, pvs_upload_dir() . $site_servers[$site_server_activ] .
					"/" . $folder . "/thumb2.jpg", 2 );
				pvs_publication_watermark_add( 0, pvs_upload_dir() . $site_servers[$site_server_activ] .
					"/" . $folder . "/thumb2.jpg" );
			}

			@unlink( pvs_upload_dir() . $site_servers[$site_server_activ] .
				"/" . $folder . "/" . $file );
		}

	}

}
//End. The function makes previews from zip archive of jpg photos

//The function uploads a photo.
function pvs_publication_photo_upload( $id )
{
	global $_POST;
	global $_FILES;
	global $site_servers;
	global $site_server_activ;
	global $folder;
	global $swait;
	global $db;
	global $ds;
	global $pvs_global_settings;

	$tmp_folder = "user_" . get_current_user_id();

	$server_id = $site_server_activ;
	$sql = "select server1 from " . PVS_DB_PREFIX . "media where id=" . ( int )
		$id;
	$ds->open( $sql );
	if ( ! $ds->eof )
	{
		$server_id = $ds->row["server1"];
	}

	$price_license = "";
	$price_license_id = 0;

	if ( ( int )$_POST["license_type"] == 0 )
	{
		$price_license = "royalty_free";
		$photo_formats = array();
		$sql = "select id,photo_type from " . PVS_DB_PREFIX .
			"photos_formats where enabled=1 order by id";
		$ds->open( $sql );
		while ( ! $ds->eof )
		{
			$photo[$ds->row["id"]] = "";
			$photo_formats[$ds->row["id"]] = $ds->row["photo_type"];
			$flag[$ds->row["id"]] = true;
			$ds->movenext();
		}
	} else
	{
		$photo[0] = "";
		$flag[0] = true;
		$photo_formats[0] = "jpg";
		$price_license = "rights_managed";
	}

	if ( $price_license == "royalty_free" )
	{
		foreach ( $photo_formats as $key => $value )
		{
			if ( $pvs_global_settings["photo_uploader"] == "usual uploader" )
			{
				$file_fullname[$key] = pvs_result_file( $_FILES["photo_" . $value]['name'] );
				$file_name[$key] = pvs_get_file_info( $file_fullname[$key], "filename" );
				$file_extention[$key] = pvs_get_file_info( $file_fullname[$key], "extention" );

				$_FILES["photo_" . $value]['name'] = pvs_result_file( $_FILES["photo_" . $value]['name'] );

				if ( preg_match( "/text/i", $_FILES["photo_" . $value]["type"] ) )
				{
					$flag[$key] = false;
				}

				if ( ! preg_match( "/\.jpg$|\.jpeg$|\.gif$|\.png$|\.raw$|\.eps$|\.tif$|\.tiff$/i",
					$file_fullname[$key] ) )
				{
					$flag[$key] = false;
				}

				if ( $_FILES["photo_" . $value]["size"] <= 0 )
				{
					$flag[$key] = false;
				}

				if ( $flag[$key] == true )
				{
					$photo[$key] = $site_servers[$server_id] . "/" . $folder . "/" . $file_fullname[$key];
					move_uploaded_file( $_FILES["photo_" . $value]['tmp_name'], pvs_upload_dir() .
						$photo[$key] );
					$swait = true;
				}
			}

			if ( $pvs_global_settings["photo_uploader"] == "jquery uploader" )
			{
				if ( isset( $_POST["file_sale" . $key] ) and $_POST["file_sale" . $key] != "" and
					file_exists( pvs_upload_dir() . "/content/" . $tmp_folder .
					"/" . pvs_result_file( $_POST["file_sale" . $key] ) ) )
				{
					$file_fullname[$key] = pvs_result_file( $_POST["file_sale" . $key] );
					$file_name[$key] = pvs_get_file_info( $file_fullname[$key], "filename" );
					$file_extention[$key] = pvs_get_file_info( $file_fullname[$key], "extention" );

					if ( strtolower( $file_extention[$key] ) != "jpg" and strtolower( $file_extention[$key] ) !=
						"jpeg" and strtolower( $file_extention[$key] ) != "png" and strtolower( $file_extention[$key] ) !=
						"gif" and strtolower( $file_extention[$key] ) != "raw" and strtolower( $file_extention[$key] ) !=
						"tif" and strtolower( $file_extention[$key] ) != "tiff" and strtolower( $file_extention[$key] ) !=
						"eps" )
					{
						$flag[$key] = false;
					} else
					{
						$photo[$key] = $site_servers[$server_id] . "/" . $folder . "/" . $file_fullname[$key];
						@copy( pvs_upload_dir() . "/content/" . $tmp_folder . "/" .
							$file_fullname[$key], pvs_upload_dir() . $photo[$key] );
					}
				} else
				{
					$flag[$key] = false;
				}
			}

			if ( @$flag[$key] == true and @$photo[$key] != "" )
			{
				//If reupload
				if ( strtolower( $file_extention[$key] ) != "jpg" or strtolower( $file_extention[$key] ) !=
					"jpeg" )
				{
					$sql = "update " . PVS_DB_PREFIX . "items set url='" . $file_fullname[$key] .
						"' where id_parent=" . $id;
					$db->execute( $sql );
				}

				$sql = "update " . PVS_DB_PREFIX . "media set rights_managed=0,url_" . $value .
					"='" . $file_fullname[$key] . "' where id=" . $id;
				$db->execute( $sql );

				$swait = true;
			}
		}
	}

	if ( $price_license == "rights_managed" )
	{
		if ( $pvs_global_settings["photo_uploader"] == "usual uploader" )
		{
			$file_fullname[0] = pvs_result_file( $_FILES["video_rights"]['name'] );

			if ( preg_match( "/text/i", $_FILES["video_rights"]["type"] ) )
			{
				$flag[0] = false;
			}

			if ( ! preg_match( "/\.jpg$|\.jpeg$|\.gif$|\.png$|\.raw$|\.tif$|\.tiff$|\.eps$/i",
				$file_fullname[0] ) )
			{
				$flag[0] = false;
			}

			if ( $_FILES["video_rights"]["size"] <= 0 )
			{
				$flag[0] = false;
			}

			if ( $flag[0] == true )
			{
				$photo[0] = $site_servers[$server_id] . "/" . $folder . "/" . $file_fullname[0];
				move_uploaded_file( $_FILES["video_rights"]['tmp_name'], pvs_upload_dir() .
					$photo[0] );
				$swait = true;
			}
		}

		if ( $pvs_global_settings["photo_uploader"] == "jquery uploader" )
		{
			if ( isset( $_POST["file_sale100"] ) and $_POST["file_sale100"] != "" and
				file_exists( pvs_upload_dir() . "/content/" . $tmp_folder .
				"/" . pvs_result_file( $_POST["file_sale100"] ) ) )
			{
				$file_fullname[0] = pvs_result_file( $_POST["file_sale100"] );
				$file_name[0] = pvs_get_file_info( $file_fullname[0], "filename" );
				$file_extention[0] = pvs_get_file_info( $file_fullname[0], "extention" );

				if ( strtolower( $file_extention[0] ) != "jpg" and strtolower( $file_extention[0] ) !=
					"jpeg" and strtolower( $file_extention[0] ) != "gif" and strtolower( $file_extention[0] ) !=
					"png" and strtolower( $file_extention[0] ) != "raw" and strtolower( $file_extention[0] ) !=
					"tif" and strtolower( $file_extention[0] ) != "tiff" and strtolower( $file_extention[0] ) !=
					"eps" )
				{
					$flag[0] = false;
				} else
				{
					$photo[0] = $site_servers[$server_id] . "/" . $folder . "/" . $file_fullname[0];
					@copy( pvs_upload_dir() . "/content/" . $tmp_folder . "/" .
						$file_fullname[0], pvs_upload_dir() . $photo[0] );
				}
			} else
			{
				$flag[0] = false;
			}
		}

		if ( @$flag[0] == true and @$photo[0] != "" )
		{
			//If reupload
			$sql = "update " . PVS_DB_PREFIX . "items set url='" . $file_fullname[0] .
				"' where id_parent=" . $id;
			$db->execute( $sql );

			$ext = strtolower( $file_extention[0] );
			if ( $ext == "jpeg" )
			{
				$ext = "jpg";
			}
			if ( $ext == "tif" )
			{
				$ext = "tiff";
			}

			$sql = "update " . PVS_DB_PREFIX . "media set rights_managed=" . ( int )@$_POST["rights_id"] .
				",url_" . $ext . "='" . $file_fullname[0] . "' where id=" . $id;
			$db->execute( $sql );

			$price_license_id = ( int )@$_POST["rights_id"];

			$swait = true;
		}
	}

	foreach ( $photo as $key => $value )
	{
		if ( $photo[$key] != "" and $file_fullname[$key] != "" )
		{
			//create different dimensions
			if ( $price_license == "royalty_free" )
			{
				pvs_publication_photo_sizes_add( $id, $file_fullname[$key], false,
					"royalty_free", 0 );

				//IPTC support
				if ( isset( $_POST["photo_iptc"] ) )
				{
					pvs_publication_iptc_add( $id, pvs_upload_dir() . $photo[$key] );
				}
			}

			if ( $price_license == "rights_managed" )
			{
				pvs_publication_photo_sizes_add( $id, $file_fullname[$key], false,
					"rights_managed", $price_license_id );

				//IPTC support
				if ( isset( $_POST["photo_iptc_rights"] ) )
				{
					pvs_publication_iptc_add( $id, pvs_upload_dir() . $photo[$key] );
				}
			}

			//Create thumbs
			if ( ! $pvs_global_settings["upload_previews"] and ( strtolower( $file_extention[$key] ) ==
				"jpg" or strtolower( $file_extention[$key] ) == "jpeg" or strtolower( $file_extention[$key] ) ==
				"gif" or strtolower( $file_extention[$key] ) == "png" ) )
			{
				pvs_photo_resize( pvs_upload_dir() . $photo[$key], pvs_upload_dir() . $site_servers[$server_id] . "/" . $folder . "/thumb1.jpg", 1 );
				pvs_photo_resize( pvs_upload_dir() . $photo[$key], pvs_upload_dir() . $site_servers[$server_id] . "/" . $folder . "/thumb2.jpg", 2 );
				pvs_publication_watermark_add( $id, pvs_upload_dir() . $site_servers[$server_id] .
					"/" . $folder . "/thumb2.jpg" );

				if ( $pvs_global_settings["prints"] and $pvs_global_settings["prints_previews"] and
					$pvs_global_settings["prints_previews_thumb"] and $pvs_global_settings["prints_previews_width"] >
					$pvs_global_settings["thumb_width2"] )
				{
					pvs_photo_resize( pvs_upload_dir() . $photo[$key], pvs_upload_dir() . $site_servers[$server_id] . "/" . $folder . "/thumb_print.jpg", 3 );
					pvs_publication_watermark_add( $id, pvs_upload_dir() . $site_servers[$server_id] .
						"/" . $folder . "/thumb_print.jpg" );
				}
			}
			if ( ! $pvs_global_settings["upload_previews"] and ( strtolower( $file_extention[$key] ) ==
				"png" or strtolower( $file_extention[$key] ) == "gif" ) and ( ! file_exists( pvs_upload_dir() . $site_servers[$server_id] . "/" . $folder . "/thumb1.jpg" ) or !
				file_exists( pvs_upload_dir() . $site_servers[$server_id] .
				"/" . $folder . "/thumb2.jpg" ) ) )
			{
				pvs_photo_resize( pvs_upload_dir() . $photo[$key], pvs_upload_dir() . $site_servers[$server_id] . "/" . $folder . "/thumb1.jpg", 1 );
				pvs_photo_resize( pvs_upload_dir() . $photo[$key], pvs_upload_dir() . $site_servers[$server_id] . "/" . $folder . "/thumb2.jpg", 2 );
				pvs_publication_watermark_add( $id, pvs_upload_dir() . $site_servers[$server_id] . "/" . $folder . "/thumb2.jpg" );

				if ( $pvs_global_settings["prints"] and $pvs_global_settings["prints_previews"] and
					$pvs_global_settings["prints_previews_thumb"] and $pvs_global_settings["prints_previews_width"] >
					$pvs_global_settings["thumb_width2"] )
				{
					pvs_photo_resize( pvs_upload_dir() . $photo[$key], pvs_upload_dir() . $site_servers[$server_id] . "/" . $folder . "/thumb_print.jpg", 3 );
					pvs_publication_watermark_add( $id, pvs_upload_dir() . $site_servers[$server_id] . "/" . $folder . "/thumb_print.jpg" );
				}
			}
		}
	}
}
//End. The function uploads a photo.

//Search all included for the category
function pvs_get_included_publications( $t_id )
{
	global $db;
	$dp = new TMySQLQuery;
	$dp->connection = $db;
	$dt = new TMySQLQuery;
	$dt->connection = $db;
	global $nlimit;
	global $res_id;
	global $res_module;
	global $res_category;
	global $res_photo;
	global $res_video;
	global $res_audio;
	global $res_vector;
	
	$sql = "select id,id_parent from " . PVS_DB_PREFIX .
		"category where id_parent=" . ( int )$t_id;
	$dt->open( $sql );
	while ( ! $dt->eof )
	{
		$res_id[] = $dt->row["id"];
		$res_module[] = 0;
		$res_category++;
		
		$sql = "select id,media_id from " . PVS_DB_PREFIX .
			"media where id in (select publication_id from " . PVS_DB_PREFIX .
		"category_items where category_id=" . ( int )$t_id . ")";
		$dp->open( $sql );
		if ( ! $dp->eof )
		{	
			if ( pvs_media_type ($dp->row["media_id"]) == 'photo' )
			{
				$res_id[] = $dp->row["id"];
				$res_module[] = $dp->row["media_id"];
				$res_photo++;
			}
	
			if ( pvs_media_type ($dp->row["media_id"]) == 'video' )
			{
				$res_id[] = $dp->row["id"];
				$res_module[] = $dp->row["media_id"];
				$res_video++;
			}
	
			if ( pvs_media_type ($dp->row["media_id"]) == 'audio' )
			{
				$res_id[] = $dp->row["id"];
				$res_module[] = $dp->row["media_id"];
				$res_audio++;
			}
	
			if ( pvs_media_type ($dp->row["media_id"]) == 'vector' )
			{
				$res_id[] = $dp->row["id"];
				$res_module[] = $dp->row["media_id"];
				$res_vector++;
			}
		}

		if ( $nlimit < 10000 )
		{
			pvs_get_included_publications( $dt->row["id"] );
		}

		$nlimit++;
		$dt->movenext();
	}
}
//End. Search all included for the category

//Search all included sybcategories for the category
function pvs_get_included_categories( $t_id )
{
	global $db;
	$dp = new TMySQLQuery;
	$dp->connection = $db;
	global $nlimit;
	global $res_id;

	$sql = "select id,id_parent from " . PVS_DB_PREFIX .
		"category where id_parent=" . $t_id;
	$dp->open( $sql );
	while ( ! $dp->eof )
	{
		$res_id[] = $dp->row["id"];

		if ( $nlimit < 1000 )
		{
			pvs_get_included_categories( $dp->row["id"] );
		}

		$nlimit++;
		$dp->movenext();
	}
}
//End. Search all included subcategories for the category

//The function returns javascript code for the jquery uploader
function pvs_get_jquery_uploader_code( $filelimit, $filetypes )
{
	$jquery_code = "<script src='" . pvs_plugins_url() .
		"/includes/plugins/jquery-file-upload-9.5.7/js/vendor/jquery.ui.widget.js'></script>
				<script src='" . pvs_plugins_url() .
		"/includes/plugins/jquery-file-upload-9.5.7/js/jquery.iframe-transport.js'></script>
				<script src='" . pvs_plugins_url() .
		"/includes/plugins/jquery-file-upload-9.5.7/js/jquery.fileupload.js'></script>
				<script src='" . pvs_plugins_url() .
		"/includes/plugins/jquery-file-upload-9.5.7/js/jquery.fileupload.js'></script>
				<script src='" . pvs_plugins_url() .
		"/includes/plugins/jquery-file-upload-9.5.7/js/jquery.fileupload-process.js'></script>
				<script src='" . pvs_plugins_url() .
		"/includes/plugins/jquery-file-upload-9.5.7/js/jquery.fileupload-validate.js'></script>
				<link rel='stylesheet' href='" . pvs_plugins_url() .
		"/includes/plugins/jquery-file-upload-9.5.7/css/jquery.fileupload.css'>
    			<script>
    			
    			bar_number=0;
    			files_massive=new Array();
    			files_massive2=new Array();
    			
    			
    			function change_bar(x)
    			{
    				bar_number=x;
    			}
    			
				/*jslint unparam: true */
				/*global window, $ */
				$(function () {
  				  	'use strict';
   				 	// Change this to the location of your server-side upload handler:
   					var url = '" . site_url( ) . "/upload_files_jquery/';
   					
   					
   				 	$('#uploadform').fileupload({
     			  		url: url,
     			   		dataType: 'json',
     			   		maxFileSize: " . ( $filelimit * 1000 * 1000 ) . ", 
     			  		acceptFileTypes: /(\.|\/)(" . $filetypes . ")$/i,
     			  		
     			  		send: function (e, data) {
     			  			$.each(data.files, function (index, file) {
          						var flag_exist=false;
          						for(var i=0;i<files_massive.length;i++)
          						{
          							if(files_massive[i]==file.name)
          							{
          								flag_exist=true;
          							}
          						}
          						if(flag_exist==false)
          						{
          							files_massive[files_massive.length]=file.name;
          							files_massive2[files_massive2.length]=bar_number;
          						}
        					});
     			  		},

    			    	done: function (e, data) {
    	        			$.each(data.result.files, function (index, file) {  
                				for(var i=0;i<files_massive.length;i++)
          						{
                					if(files_massive[i]==file.name)
          							{
                						document.getElementById('file_sale'+files_massive2[i]).value=file.name;
                						document.getElementById('files'+files_massive2[i]).innerHTML=file.name+' [ '+(file.size/(1024*1024)).toFixed(3)+'MB ]';
                					}
                				}
            				});
        				},
        				
        				progress: function (e, data) {
        						var filess = data.files;
								var filenam = filess[0].name;
        				
                				for(var i=0;i<files_massive.length;i++)
          						{
            						if(files_massive[i]==filenam)
          							{
            							var progress = parseInt(data.loaded / data.total * 100, 10);
            							$('#bar'+files_massive2[i]).css('width',progress + '%');
            							document.getElementById('files'+files_massive2[i]).innerHTML=filenam +' '+(data.loaded/(1024*1024)).toFixed(2)+' from ' +(data.total/(1024*1024)).toFixed(2) +'MB ('+progress+ '%)';
            						}
            					}
        				}
        				
    			}).prop('disabled', !$.support.fileInput)
        			.parent().addClass($.support.fileInput ? undefined : 'disabled');
			});
	</script>";

	return $jquery_code;
}

//The function returns preview form for video, audio and vector files
function pvs_get_preview_form( $type, $flag_rights_managed )
{
	global $lvideo;
	global $lpreviewvideo;
	global $laudio;
	global $lpreviewaudio;
	global $lvector;
	global $pvs_global_settings;
	global $db;
	$dp = new TMySQLQuery;
	$dp->connection = $db;
	$dt = new TMySQLQuery;
	$dt->connection = $db;

	$res = "";

	if ( $flag_rights_managed )
	{
		$number_field0 = 2;
		$number_field1 = 3;
		$rights_field = "_rights";
	} else
	{
		$number_field0 = 0;
		$number_field1 = 1;
		$rights_field = "";
	}

	if ( $type == "video" )
	{

		$res .= "<tr class='snd'><td colspan='4'>(" . pvs_word_lang( "size" ) . " < " .
			$lvideo . "Mb.)</td></tr>";

		if ( ! $pvs_global_settings["ffmpeg"] )
		{
			$res .= "<tr><th colspan=4><b>" . pvs_word_lang( "preview" ) . " " .
				pvs_word_lang( "video" ) . ":</b></th></tr><tr><td colspan='4'>";

			if ( $pvs_global_settings["video_uploader"] == "usual uploader" )
			{
				$res .= "<input class='ibox form-control' name='preview" . $rights_field .
					"' type='file' style='width:400px'>";
			}

			if ( $pvs_global_settings["video_uploader"] == "jquery uploader" )
			{
				$res .= "<span class=\"btn btn-success fileinput-button\">
        					<i class=\"icon-plus icon-white\" style=\"float:left\"></i> " .
					pvs_word_lang( "select files" ) . "...
        					<!-- The file input field used as target for the file upload widget -->
        					<input type=\"file\" name=\"files[]\" onClick='change_bar(" . $number_field0 .
					")'>
        					<input type=\"hidden\" id='file_sale" . $number_field0 .
					"' name='file_sale" . $number_field0 . "' value=''>
    					</span>
    					<div class='progress'  style=\"margin-top:15px\">
						  <div  id=\"bar" . $number_field0 . "\" class='bar progress-bar progress-bar-info progress-bar-striped' role='progressbar' style='width: 0%'>
							<span class='sr-only'></span>
						  </div>
						</div>
    					<div id=\"files" . $number_field0 . "\" class=\"files\"></div>
    					";

			}

			$res .= "<span class='smalltext'>(*.mp4 or *.flv " . pvs_word_lang( "size" ) .
				" < " . $lpreviewvideo . "Mb.)</span></td></tr>";

			$res .= "<tr><th colspan=4><b>" . pvs_word_lang( "preview" ) . " " .
				pvs_word_lang( "photo" ) . ":</th></tr><tr><td colspan='4'>";

			if ( $pvs_global_settings["video_uploader"] == "usual uploader" )
			{
				$res .= "<input class='ibox form-control' name='preview2" . $rights_field .
					"' type='file' style='width:400px'>";
			}

			if ( $pvs_global_settings["video_uploader"] == "jquery uploader" )
			{
				$res .= "<span class=\"btn btn-success fileinput-button\">
        					<i class=\"icon-plus icon-white\" style=\"float:left\"></i> " .
					pvs_word_lang( "select files" ) . "...
        					<!-- The file input field used as target for the file upload widget -->
        					<input type=\"file\" name=\"files[]\" onClick='change_bar(" . $number_field1 .
					")'>
        					<input type=\"hidden\" id='file_sale" . $number_field1 .
					"' name='file_sale" . $number_field1 . "' value=''>
    					</span>
    					<div class='progress'  style=\"margin-top:15px\">
						  <div  id=\"bar" . $number_field1 . "\" class='bar progress-bar progress-bar-info progress-bar-striped' role='progressbar' style='width: 0%'>
							<span class='sr-only'></span>
						  </div>
						</div>
    					<div id=\"files" . $number_field1 . "\" class=\"files\"></div>
    					";

			}

			$res .= "<br><span class='smalltext'>(*.jpg,*.jpeg)</span></td></tr>";
		} else
		{
			if ( ! $flag_rights_managed )
			{
				$res .= "<tr><th colspan=4><b>" . pvs_word_lang( "Generate video preview from" ) .
					":</b></th></tr><tr><td colspan='4'>
				<select name='generation' style='width:400px' class='ibox form-control'>";

				$sql = "select id_parent,name from " . PVS_DB_PREFIX .
					"licenses order by priority";
				$dp->open( $sql );
				while ( ! $dp->eof )
				{
					$sql = "select id_parent,title from " . PVS_DB_PREFIX .
						"video_types where license = " . $dp->row["id_parent"] .
						" and shipped<>1 order by priority";
					$dt->open( $sql );
					while ( ! $dt->eof )
					{
						$res .= "<option value='" . $dt->row["id_parent"] . "'>" . $dp->row["name"] .
							" - " . $dt->row["title"] . "</option>";

						$dt->movenext();
					}

					$dp->movenext();
				}

				$res .= "</select>
				</td></tr>";
			}
		}
	}

	if ( $type == "audio" )
	{
		if ( $pvs_global_settings["sox"] == 0 )
		{
			$res .= "<tr class='snd'><td colspan=4><span class='smalltext'>(" .
				pvs_word_lang( "size" ) . " < " . $laudio . "Mb.)</span></td></tr>";

			$res .= "<tr><th colspan=4><b>" . pvs_word_lang( "preview" ) . " " .
				pvs_word_lang( "audio" ) . ":</b></th></tr><tr><td colspan='4'>";

			if ( $pvs_global_settings["audio_uploader"] == "usual uploader" )
			{
				$res .= "<input class='ibox form-control' name='preview" . $rights_field .
					"' type='file' style='width:400px'>";
			}

			if ( $pvs_global_settings["audio_uploader"] == "jquery uploader" )
			{
				$res .= "<span class=\"btn btn-success fileinput-button\">
        					<i class=\"icon-plus icon-white\" style=\"float:left\"></i> " .
					pvs_word_lang( "select files" ) . "...
        					<!-- The file input field used as target for the file upload widget -->
        					<input type=\"file\" name=\"files[]\" onClick='change_bar(" . $number_field0 .
					")'>
        					<input type=\"hidden\" id='file_sale" . $number_field0 .
					"' name='file_sale" . $number_field0 . "' value=''>
    					</span>
    					<div class='progress'  style=\"margin-top:15px\">
						  <div  id=\"bar" . $number_field0 . "\" class='bar progress-bar progress-bar-info progress-bar-striped' role='progressbar' style='width: 0%'>
							<span class='sr-only'></span>
						  </div>
						</div>
    					<div id=\"files" . $number_field0 . "\" class=\"files\"></div>
    					";
			}

			$res .= "<span class='smalltext'>(*.mp3 " . pvs_word_lang( "size" ) . " < " . $lpreviewaudio .
				"Mb.)</span></td></tr>";
		} else
		{
			if ( ! $flag_rights_managed )
			{
				$res .= "<tr><th colspan=4><b>" . pvs_word_lang( "Generate *.mp3 audio preview from" ) .
					":</b></th></tr><tr><td colspan='4'>
				<select name='generation' style='width:400px' class='ibox form-control'>";

				$sql = "select id_parent,name from " . PVS_DB_PREFIX .
					"licenses order by priority";
				$dp->open( $sql );
				while ( ! $dp->eof )
				{
					$sql = "select id_parent,title from " . PVS_DB_PREFIX .
						"audio_types where license = " . $dp->row["id_parent"] .
						" and shipped<>1 order by priority";
					$dt->open( $sql );
					while ( ! $dt->eof )
					{
						$res .= "<option value='" . $dt->row["id_parent"] . "'>" . $dp->row["name"] .
							" - " . $dt->row["title"] . "</option>";

						$dt->movenext();
					}
					$dp->movenext();
				}

				$res .= "</select>
					</td></tr>";
			}
		}

		$res .= "<tr><th colspan=4><b>" . pvs_word_lang( "preview" ) . " " .
			pvs_word_lang( "photo" ) . ":</th></tr><tr><td colspan='4'>";

		if ( $pvs_global_settings["audio_uploader"] == "usual uploader" )
		{
			$res .= "<input class='ibox form-control' name='preview2" . $rights_field .
				"' type='file' style='width:400px'>";
		}

		if ( $pvs_global_settings["audio_uploader"] == "jquery uploader" )
		{
			$res .= "<span class=\"btn btn-success fileinput-button\">
        					<i class=\"icon-plus icon-white\" style=\"float:left\"></i> " .
				pvs_word_lang( "select files" ) . "...
        					<!-- The file input field used as target for the file upload widget -->
        					<input type=\"file\" name=\"files[]\" onClick='change_bar(" . $number_field1 .
				")'>
        					<input type=\"hidden\" id='file_sale" . $number_field1 .
				"' name='file_sale" . $number_field1 . "' value=''>
    					</span>
    					<div class='progress'  style=\"margin-top:15px\">
						  <div  id=\"bar" . $number_field1 . "\" class='bar progress-bar progress-bar-info progress-bar-striped' role='progressbar' style='width: 0%'>
							<span class='sr-only'></span>
						  </div>
						</div>
    					<div id=\"files" . $number_field1 . "\" class=\"files\"></div>
    					";
		}

		$res .= "<br><span class='smalltext'>(*.jpg,*.jpeg)</span></td></tr>";
	}

	if ( $type == "vector" )
	{
		$res .= "<tr class='snd'><td colspan=4><span class='smalltext'>(" .
			pvs_word_lang( "size" ) . " < " . $lvector . "Mb.)</span></td></tr>";

		$res .= "<tr><th colspan=4><b>" . pvs_word_lang( "preview" ) . " " .
			pvs_word_lang( "photo" ) . ":</th></tr><tr><td colspan='4'>";

		if ( $pvs_global_settings["vector_uploader"] == "usual uploader" )
		{
			$res .= "<input class='ibox form-control' name='preview2" . $rights_field .
				"' type='file' style='width:400px'>";
		}

		if ( $pvs_global_settings["vector_uploader"] == "jquery uploader" )
		{
			$res .= "<span class=\"btn btn-success fileinput-button\">
        					<i class=\"icon-plus icon-white\" style=\"float:left\"></i> " .
				pvs_word_lang( "select files" ) . "...
        					<!-- The file input field used as target for the file upload widget -->
        					<input type=\"file\" name=\"files[]\" onClick='change_bar(" . $number_field0 .
				")'>
        					<input type=\"hidden\" id='file_sale" . $number_field0 .
				"' name='file_sale" . $number_field0 . "' value=''>
    					</span>
    					<div class='progress'  style=\"margin-top:15px\">
						  <div  id=\"bar" . $number_field0 . "\" class='bar progress-bar progress-bar-info progress-bar-striped' role='progressbar' style='width: 0%'>
							<span class='sr-only'></span>
						  </div>
						</div>
    					<div id=\"files" . $number_field0 . "\" class=\"files\"></div>
    					";
		}

		$res .= "<br><span class='smalltext'>(*.jpg,*.jpeg or *.zip archive of jpgs)</span></td></tr>";
	}

	return $res;
}
//End. The function returns preview form for video, audio and vector files

//The function removes all files and subfolders from the temp folder
function pvs_remove_files_from_folder( $tmp_folder )
{
	if ( file_exists( pvs_upload_dir() . "/content/" . $tmp_folder ) and
		$tmp_folder != "" )
	{
		$dir = opendir( pvs_upload_dir() . "/content/" . $tmp_folder );
		while ( $file = readdir( $dir ) )
		{
			if ( $file <> "." && $file <> ".." )
			{
				if ( is_file( pvs_upload_dir() . "/content/" . $tmp_folder . "/" .
					$file ) )
				{
					@unlink( pvs_upload_dir() . "/content/" . $tmp_folder . "/" . $file );
				}
				if ( is_dir( pvs_upload_dir() . "/content/" . $tmp_folder . "/" .
					$file ) )
				{
					$dir2 = opendir( pvs_upload_dir() . "/content/" . $tmp_folder .
						"/" . $file );
					while ( $file2 = readdir( $dir2 ) )
					{
						if ( $file2 <> "." && $file2 <> ".." )
						{
							if ( is_file( pvs_upload_dir() . "/content/" . $tmp_folder . "/" .
								$file . "/" . $file2 ) )
							{
								@unlink( pvs_upload_dir() . "/content/" . $tmp_folder . "/" . $file .
									"/" . $file2 );
							}
						}
					}
					rmdir( pvs_upload_dir() . "/content/" . $tmp_folder . "/" . $file );
				}
			}
		}
	}
}
//End. The function removes all files and subfolders from the temp folder


//Build model's list
function pvs_show_models( $id ) {
	global $dn;
	global $dd;

	$model_list = "";
	$model_ids = array();

	$models_text = "";
	$models_text2 = "";
	
	if ( ! pvs_is_user_admin () ) {
		$com = " where user='" . pvs_result(pvs_get_user_login ()) . "' ";
	} else {
		$com = '';
	}
	
	$sql = "select publication_id,model_id,models from " . PVS_DB_PREFIX .
		"models_files where publication_id=" . $id;
	$dn->open( $sql );
	while ( ! $dn->eof )
	{
		$sql = "select name from " . PVS_DB_PREFIX . "models where id_parent=" . $dn->row["model_id"];
		$dd->open( $sql );
		if ( ! $dd->eof )
		{
			$models_text2 .= "<div class='clear' id='div_" . $dn->row["model_id"] .
				"' style='margin-bottom:5px'><div class='input-append' style='float:left;margin-right:4px'><a href='../models/content.php?id=" .
				$dn->row["model_id"] . "' class='btn btn-default btn-small'><i class='fa fa-check' aria-hidden='true'></i> ";

			if ( $dn->row["models"] == 0 )
			{
				$models_text2 .= "<b>" . pvs_word_lang( "Model release" ) . ":</b> ";
			} else
			{
				$models_text2 .= "<b>" . pvs_word_lang( "Property release" ) . ":</b> ";
			}

			$models_text2 .= $dd->row["name"] . "</a>";

			$models_text2 .= "</div><button class='btn btn-danger btn-small' type='button' onClick=\"pvs_model_delete('" .
				$dn->row["model_id"] . "');\">" . pvs_word_lang( "delete" ) .
				"</button><input type='hidden' name='model" . $dn->row["model_id"] . "' value='" .
				$dn->row["models"] . "'></div>";

			$model_ids[$dn->row["model_id"]] = 1;
		}

		$dn->movenext();
	}

	$sql = "select name,id_parent from " . PVS_DB_PREFIX . "models " . $com . " order by name";
	$dd->open( $sql );
	while ( ! $dd->eof )
	{
		if ( isset( $model_ids[$dd->row["id_parent"]] ) )
		{
			$model_style = "style='display:none'";
		} else
		{
			$model_style = "style='display:block'";
		}

		$model_list .= "<li id='model{TYPE}_" . $dd->row["id_parent"] . "' " . $model_style .
			"><a href=\"javascript:model_add(" . $dd->row["id_parent"] . ",{TYPE},'" .
			addslashes( $dd->row["name"] ) . "');\">" . $dd->row["name"] . "</a></li>";

		$dd->movenext();
	}

	$models_text .= "<div class='btn-group'>
		<a class='btn btn-default btn-small' href='#'><i class='icon-plus-sign'></i> " .
		pvs_word_lang( "Model release" ) . "</a>
		<a class='btn btn-default dropdown-toggle btn-small' data-toggle='dropdown' href='#'><span class='caret' style='margin:8px 2px 8px 2px'></span></a>
		<ul class='dropdown-menu' style='width:250px'>
			" . str_replace( "{TYPE}", "0", $model_list ) . "
		</ul>
	</div>&nbsp;<div class='btn-group'>
		<a class='btn btn-default btn-small' href='#'><i class='icon-plus-sign'></i> " .
		pvs_word_lang( "Property release" ) . "</a>
		<a class='btn btn-default dropdown-toggle btn-small' data-toggle='dropdown' href='#'><span class='caret' style='margin:8px 2px 8px 2px'></span></a>
		<ul class='dropdown-menu' style='width:250px'>
			" . str_replace( "{TYPE}", "1", $model_list ) . "
		</ul>
	</div><div class='clear'></div><br>";
	
	$models_text .= $models_text2;
	
	$models_text .= "<div id='models_list'></div>";
	
	return $models_text;
}


?>