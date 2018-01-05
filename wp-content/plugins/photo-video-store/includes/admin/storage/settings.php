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

<p>
The script can store files on the <b>Local Server</b> where the software is installed or on clouds hostings such as <a href="http://www.rackspacecloud.com/2361.html"><b>Rackspace cloud files</b></a> and <a href="http://aws.amazon.com/s3/"><b>Amazon S3</b></a>.
</p>

<p>
The clouds hosting is cheap, easy and safe way to store media files and distribute them faster in Internet.
</p>

<p>
When you use <b>Rackspace clouds</b> or <b>Amazom S3</b> all files are stored on the <b>local server first</b> and then they are moved to a clouds hosting. 
</p>
</div>
<div class="subheader"><?php
echo pvs_word_lang( "stats" )
?></div>
<div class="subheader_text">



<?php
$sql = "select id from " . PVS_DB_PREFIX . "filestorage where types=1";
$rs->open( $sql );
if ( ! $rs->eof )
{
	$rackspace_server = $rs->row["id"];
}

$sql = "select id from " . PVS_DB_PREFIX . "filestorage where types=2";
$rs->open( $sql );
if ( ! $rs->eof )
{
	$amazon_server = $rs->row["id"];
}

$pub_count = 0;
$pub_files = 0;
$pub_storage = 0;

$rackspace_count = 0;
$rackspace_files = 0;
$rackspace_storage = 0;

$amazon_count = 0;
$amazon_files = 0;
$amazon_storage = 0;

$sql = "select server1,filesize,id_parent from " . PVS_DB_PREFIX .
	"filestorage_files";
$rs->open( $sql );
while ( ! $rs->eof )
{
	if ( $rs->row["server1"] == $rackspace_server )
	{
		$rackspace_files++;
		$rackspace_storage += $rs->row["filesize"];
	}

	if ( $rs->row["server1"] == $amazon_server )
	{
		$amazon_files++;
		$amazon_storage += $rs->row["filesize"];
	}

	$rs->movenext();
}

$mass_tables = array(
	"media" );
for ( $i = 0; $i < count( $mass_tables ); $i++ )
{
	$sql = "select server2,id from " . PVS_DB_PREFIX . $mass_tables[$i];
	$rs->open( $sql );
	while ( ! $rs->eof )
	{
		if ( $rs->row["server2"] == $rackspace_server )
		{
			$rackspace_count++;
		} elseif ( $rs->row["server2"] == $amazon_server )
		{
			$amazon_count++;
		} else
		{
			$pub_count++;
		}
		$rs->movenext();
	}
}

$sql = "select * from " . PVS_DB_PREFIX . "filestorage where types=0";
$rs->open( $sql );
while ( ! $rs->eof )
{
	$dir = opendir( pvs_upload_dir() . $rs->row["url"] );
	while ( $file = readdir( $dir ) )
	{
		if ( is_dir( pvs_upload_dir() . $rs->row["url"] . "/" . $file ) and $file * 1 >
			1 )
		{
			$dir2 = opendir( pvs_upload_dir() . $rs->row["url"] . "/" . $file );
			while ( $file2 = readdir( $dir2 ) )
			{
				if ( $file2 <> "." and $file2 <> ".." )
				{
					$pub_files++;
					$pub_storage += filesize( pvs_upload_dir() . $rs->row["url"] . "/" . $file . "/" .
						$file2 );
				}
			}
			closedir( $dir2 );
		}
	}
	closedir( $dir );
	$rs->movenext();
}
?>


<table class="wp-list-table widefat fixed striped posts">
<thead>
<tr>
<th><b>Server</b></th>
<th><b>Publications</b></th>
<th><b>Files (with previews)</b></th>
<th><b>Disk Space</b></th>
</tr>
</thead>
<tr>
<td class="big">Local server</td>


<td class="gray"><?php
echo $pub_count
?></td>
<td class="gray"><?php
echo $pub_files
?></td>
<td class="gray"><?php
echo pvs_price_format( ( $pub_storage / 1024 / 1024 ), 3 )
?> Mb.</td>
</tr>
<tr class="snd">
<td class="big">Rackspace clouds</td>
<td class="gray"><?php
echo $rackspace_count
?></td>
<td class="gray"><?php
echo $rackspace_files
?></td>
<td class="gray"><?php
echo pvs_price_format( ( $rackspace_storage / 1024 / 1024 ), 3 )
?> Mb.</td>
</tr>
<tr>
<td class="big">Amazon S3</td>
<td class="gray"><?php
echo $amazon_count
?></td>
<td class="gray"><?php
echo $amazon_files
?></td>
<td class="gray"><?php
echo pvs_price_format( ( $amazon_storage / 1024 / 1024 ), 3 )
?> Mb.</td>
</tr>



</table>


</div>