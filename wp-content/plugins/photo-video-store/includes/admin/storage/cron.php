<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
?>

<div class="subheader"><?php
echo pvs_word_lang( "overview" )
?></div>
<div class="subheader_text">

<p>When you use <b>Rackspace clouds</b> or <b>Amazom S3</b> all files are stored on the <b>local server</b> first.

<p>
You must set a <b>Cron task</b> in your hostings account and a special script will move the media files from the local server to the clouds one with some periodicity. It will work independantly and simplify a content upload process.</p>

<p>
You can find the cron script here:
</p>

<ul>
<li>
<b><?php
echo site_url()
?>/cron-rackspace/</b><br>for Rackspace Clouds
</li>

<li>
<b><?php
echo site_url()
?>/cron-amazon/</b></br>for Amazon S3
</li>
</ul>

<p>
You should <b>rename</b> the scripts for <b>security reasons</b> on ftp.
</p>

<p>The cron command's syntax depends on the server's settings.
We advice to use the commands which ping cron's URL - not physical path to the cron php file. </br>
</p>

<p><b>Examples of the cron commands:</b></p>

<ul>
<li>/usr/bin/lynx -source <?php
echo site_url()
?>/cron-amazon/</li>
<li>GET <?php
echo site_url()
?>/cron-amazon/ > /dev/null</li>
</ul>



<p>
Also you have to check the <b>php.ini settings</b>:<br>
<b>max_execution_time</b>
</p>

</div>
<div class="subheader">Cron Stats</div>
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
if ( isset( $_REQUEST["adate"] ) )
{
	$adate = ( int )$_REQUEST["adate"];
}

//Sort by ID
$aid = 0;
if ( isset( $_REQUEST["aid"] ) )
{
	$aid = ( int )$_REQUEST["aid"];
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
		$com = " order by data ";
	}
	if ( $adate == 2 )
	{
		$com = " order by data desc ";
	}
}

if ( $aid != 0 )
{
	$var_sort = "&aid=" . $aid;
	if ( $aid == 1 )
	{
		$com = " order by publication_id ";
	}
	if ( $aid == 2 )
	{
		$com = " order by publication_id desc ";
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
		$com2 .= " and publication_id=" . ( int )$search . " ";
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

$sql = "select publication_id,data,logs from " . PVS_DB_PREFIX .
	"filestorage_logs where publication_id>0 ";

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
	echo ( pvs_paging( $record_count, $str, $kolvo, $kolvo2, pvs_plugins_admin_url( 'storage/index.php' ),
		"&d=5&" . $var_search . $var_sort ) );
?></div>






<table class="wp-list-table widefat fixed striped posts">
<thead>
<tr>
<th>
<a href="<?php
	echo ( pvs_plugins_admin_url( 'storage/index.php' ) );
?>&d=5&<?php
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
	echo ( pvs_plugins_admin_url( 'storage/index.php' ) );
?>&d=5&<?php
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
	echo pvs_word_lang( "files" )
?></th>
<th width="60%">Logs</th>
	
</tr>
</thead>
<?php
	while ( ! $rs->eof )
	{

		$sql = "select id from " . PVS_DB_PREFIX . "media where id=" . $rs->row["publication_id"];
		$ds->open( $sql );
		if ( $ds->eof )
		{
			$sql = "delete from " . PVS_DB_PREFIX . "filestorage_logs where publication_id=" .
				$rs->row["publication_id"];
			$db->execute( $sql );
			$rs->movenext();
		}
?>
<tr valign="top">
<td>

<a href="<?php
		echo ( pvs_plugins_admin_url( 'catalog/index.php' ) );
?>&id=<?php
		echo $rs->row["publication_id"]
?>"><?php
		echo $rs->row["publication_id"]
?></a></td>


<td><?php
		echo date( datetime_format, $rs->row["data"] )
?></td>
<td>
<?php
		$sql = "select id_parent,filename2,filesize,url from " . PVS_DB_PREFIX .
			"filestorage_files where id_parent=" . $rs->row["publication_id"];
		$ds->open( $sql );
		while ( ! $ds->eof )
		{
?>
<a href="<?php
			echo $ds->row["url"]
?>/<?php
			echo $ds->row["filename2"]
?>"><?php
			echo $ds->row["filename2"]
?></a> [<?php
			echo pvs_price_format( ( $ds->row["filesize"] / 1024 / 1024 ), 3 )
?> Mb.]<br>
<?php
			$ds->movenext();
		}
?>
</td>
<td><small><?php
		echo $rs->row["logs"]
?></small></td>

</tr>
<?php
		$n++;
		$rs->movenext();
	}
?>
</table>




<div style="padding-top:25px;"><?php
	echo ( pvs_paging( $record_count, $str, $kolvo, $kolvo2, pvs_plugins_admin_url( 'storage/index.php' ),
		"&d=5" . $var_search . $var_sort ) );
?></div>
<?php
} else
{
	echo ( "<p><b>" . pvs_word_lang( "not found" ) . "</b></p>" );
}
?>
</div>