<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_ffmpeg" );
?>



<div class="subheader"><?php
echo pvs_word_lang( "overview" )
?></div>
<div class="subheader_text">

<p>FFMPEG's preview's generation takes a few seconds or minutes if the video files are large. Sometimes it makes sense to move the generation to a separate process so that the users don't wait until the server creates the previews. </p>


<p>How it works:</p>
<ul>
<li>A seller uploads a video. The previews are not created.</li> 
<li>The video is placed in the queue. The publication isn't active.</li>
<li>The server's cron script generates *.jpg and *.mp4 previews file by file. When the previews are ready the video is published on the site.</li>
</ul>


<p>
You can find the cron script here:<br>
<b><?php
echo site_url()
?>/cron-ffmpeg/</b>
</p>

<p>
You can <b>rename</b> the scripts for <b>security reasons</b> on ftp.
</p>

<p>The cron command's syntax depends on the server's settings.
We advice to use the commands which ping cron's URL - not physical path to the cron php file. </br>
</p>

<p><b>Examples of the cron commands:</b></p>

<ul>
<li>/usr/bin/lynx -source <?php
echo site_url()
?>/cron-ffmpeg/</li>
<li>GET <?php
echo site_url()
?>/cron-ffmpeg/ > /dev/null</li>
</ul>

<form method="post">
<input type="hidden" name="action" value="enable_cron">
<div class="form_field">
<input type="checkbox" value="1" name="cron" <?php
if ( $pvs_global_settings["ffmpeg_cron"] )
{
	echo ( "checked" );
}
?>> <b>Enable</b> FFMPEG queue.
</div>

<div class="form_field">
<input type="submit" value="<?php
echo pvs_word_lang( "save" )
?>" class="btn btn-primary">
</div>
</form>

</div>

<div class="subheader"><?php
echo pvs_word_lang( "Queue" )
?></div>
<div class="subheader_text">






<?php
//Get Search
$search = "";
if ( isset( $_REQUEST["search"] ) )
{
	$search = pvs_result( $_REQUEST["search"] );
}

//Get Search type
$search_type = "";
if ( isset( $_REQUEST["search_type"] ) )
{
	$search_type = pvs_result( $_REQUEST["search_type"] );
}

//Items
$items = 30;
if ( isset( $_REQUEST["items"] ) )
{
	$items = ( int )$_REQUEST["items"];
}

//Search variable
$var_search = "search=" . $search . "&search_type=" . $search_type . "&items=" .
	$items;

//Sort by date
$adate = 0;
if ( isset( $_GET["adate"] ) )
{
	$adate = ( int )$_GET["adate"];
}

//Sort by ID
$aid = 0;
if ( isset( $_GET["aid"] ) )
{
	$aid = ( int )$_GET["aid"];
}

//Sort by default
if ( $adate == 0 and $aid == 0 )
{
	$adate = 2;
}

//Add sort variable
$com = "";

if ( $adate != 0 )
{
	$var_sort = "&adate=" . $adate;
	if ( $adate == 1 )
	{
		$com = " order by data1 ";
	}
	if ( $adate == 2 )
	{
		$com = " order by data1 desc ";
	}
}

if ( $aid != 0 )
{
	$var_sort = "&aid=" . $aid;
	if ( $aid == 1 )
	{
		$com = " order by id ";
	}
	if ( $aid == 2 )
	{
		$com = " order by id desc ";
	}
}

//Items on the page
$items_mass = array(
	10,
	20,
	30,
	50,
	75,
	100 );

//Search parameter
$com2 = "";

if ( $search != "" )
{
	if ( $search_type == "id" )
	{
		$com2 .= " and id=" . ( int )$search . " ";
	}
}

//Item's quantity
$kolvo = $items;

//Pages quantity
$kolvo2 = PVS_PAGE_NUMBER;

//Page number
if ( ! isset( $_GET["str"] ) )
{
	$str = 1;
} else
{
	$str = ( int )$_GET["str"];
}

$n = 0;

$sql = "select id,data1,data2 from " . PVS_DB_PREFIX . "ffmpeg_cron where id>0 ";

$sql .= $com2 . $com;

$rs->open( $sql );
$record_count = $rs->rc;

//limit
$lm = " limit " . ( $kolvo * ( $str - 1 ) ) . "," . $kolvo;

$sql .= $lm;

//echo($sql);
$rs->open( $sql );
?>
<div id="catalog_menu card">


<form method="post">
<input type="hidden" name="d" value="2">
<div class="toleft">
<span><?php
echo pvs_word_lang( "search" )
?>:</span>
<input type="text" name="search" style="width:200px" class="ft" value="<?php
echo $search
?>" onClick="this.value=''"  value="Publication ID">
<input type="hidden" name="search_type" value="id">
</div>


<div class="toleft">
<span><?php
echo pvs_word_lang( "page" )
?>:</span>
<select name="items" style="width:70px" class="ft">
<?php
for ( $i = 0; $i < count( $items_mass ); $i++ )
{
	$sel = "";
	if ( $items_mass[$i] == $items )
	{
		$sel = "selected";
	}
?>
<option value="<?php
	echo $items_mass[$i]
?>" <?php
	echo $sel
?>><?php
	echo $items_mass[$i]
?></option>
<?php
}
?>

</select>
</div>

<div class="toleft">
<span>&nbsp;</span>
<input type="submit" class="btn btn-danger" value="<?php
echo pvs_word_lang( "search" )
?>">
</div>

<div class="toleft_clear"></div>
</form>


</div>



<?php
if ( ! $rs->eof )
{
?>


<div style="padding-bottom:15px"><?php
	echo ( pvs_paging( $record_count, $str, $kolvo, $kolvo2, pvs_plugins_admin_url( 'ffmpeg/index.php' ),
		"&d=2" . $var_search . $var_sort ) );
?></div>

<script language="javascript">
function publications_select_all(sel_form)
{
    if(sel_form.selector.checked)
   	{
        $("input:checkbox", sel_form).attr("checked",true);
    }
    else
    {
        $("input:checkbox", sel_form).attr("checked",false);
    }
}
</script>



<form method="post">
<input type="hidden" name="action" value="delete">
<input type="hidden" name="d" value="2">
<table class="wp-list-table widefat fixed striped posts">
<thead>
<tr>
<th><input type="checkbox"  name="selector" value="1" onClick="publications_select_all(document.adminform);"></th>
<th><?php
	echo pvs_word_lang( "preview" )
?></th>
<th>
<a href="<?php
	echo ( pvs_plugins_admin_url( 'ffmpeg/index.php' ) );
?>&d=2&<?php
	echo $var_search
?>&aid=<?php
	if ( $aid == 2 )
	{
		echo ( 1 );
	} else
	{
		echo ( 2 );
	}
?>">ID</a> <?php
	if ( $aid == 1 )
	{
?><img src="<?php
		echo pvs_plugins_url()
?>/assets/images/sort_up.gif" width="11" height="8"><?php
	}
?><?php
	if ( $aid == 2 )
	{
?><img src="<?php
		echo pvs_plugins_url()
?>/assets/images/sort_down.gif" width="11" height="8"><?php
	}
?>
</th>



<th>
<a href="<?php
	echo ( pvs_plugins_admin_url( 'ffmpeg/index.php' ) );
?>&d=2&<?php
	echo $var_search
?>&adate=<?php
	if ( $adate == 2 )
	{
		echo ( 1 );
	} else
	{
		echo ( 2 );
	}
?>"><?php
	echo pvs_word_lang( "date" )
?></a> <?php
	if ( $adate == 1 )
	{
?><img src="<?php
		echo pvs_plugins_url()
?>/assets/images/sort_up.gif" width="11" height="8"><?php
	}
?><?php
	if ( $adate == 2 )
	{
?><img src="<?php
		echo pvs_plugins_url()
?>/assets/images/sort_down.gif" width="11" height="8"><?php
	}
?>

</th>
<th><?php
	echo pvs_word_lang( "Creation date" )
?></th>
	
</tr>
</thead>
<?php
	while ( ! $rs->eof )
	{
?>
<tr valign="top">
<td><input type="checkbox" name="delete<?php
		echo $rs->row["id"]
?>" value="1"></td>
<td>
<?php
		$item_img = pvs_show_preview( $rs->row["id"], "video", 1, 1, "", $rs->row["id"] );
?>
<img src="<?php
		echo $item_img
?>" width="50">
</td>
<td>

<a href="<?php
		echo ( pvs_plugins_admin_url( 'catalog/index.php' ) );
?>&action=content&id=<?php
		echo $rs->row["id"]
?>"><?php
		echo $rs->row["id"]
?></a></td>


<td><?php
		echo date( datetime_format, $rs->row["data1"] )
?></td>
<td>
<?php
		if ( $rs->row["data2"] != 0 )
		{
			echo ( date( datetime_format, $rs->row["data2"] ) );
		} else
		{
			echo ( "&mdash;" );
		}
?>
</td>



</tr>
<?php
		$n++;
		$rs->movenext();
	}
?>
</table>
<input type="submit" value="<?php
	echo pvs_word_lang( "delete" )
?>" style="margin:10px 0px 0px 6px" class="btn btn-danger">


</form>




<div style="padding-top:25px;"><?php
	echo ( pvs_paging( $record_count, $str, $kolvo, $kolvo2, pvs_plugins_admin_url( 'ffmpeg/index.php' ),
		"&d=2" . $var_search . $var_sort ) );
?></div>
<?php
} else
{
	echo ( "<p><b>" . pvs_word_lang( "not found" ) . "</b></p>" );
}
?>






</div>



