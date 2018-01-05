<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Add
if ( @$_REQUEST["action"] == 'add' )
{
	$sql = "select id from " . PVS_DB_PREFIX . "filestorage order by id desc";

	$rs->open( $sql );

	$id = $rs->row["id"] + 1;

	$sql = "insert into " . PVS_DB_PREFIX .
		"filestorage (id,url,types,name) values (" . $id . ",'/content" . $id .
		"',0,'Local server')";

	$db->execute( $sql );

	if ( ! file_exists( pvs_upload_dir() . "/content" . $id ) )
	{
		mkdir( pvs_upload_dir() . "/content" . $id );
		@copy( pvs_upload_dir() . "/content/.htaccess", pvs_upload_dir() . "/content" .
			$id . "/.htaccess" );
	}
}

//Change
if ( @$_REQUEST["action"] == 'change' )
{
	$sql = "update " . PVS_DB_PREFIX . "filestorage set activ=0";
	$db->execute( $sql );

	$sql = "update " . PVS_DB_PREFIX . "filestorage set activ=1 where id=" . ( int )
		$_POST["activ"];
	$db->execute( $sql );
}

//Delete
if ( @$_REQUEST["action"] == 'delete' )
{
	if ( $_GET["id"] != 1 )
	{
		$sql = "select id,url from " . PVS_DB_PREFIX . "filestorage where id=" . ( int )
			$_GET["id"] . " and types=0";

		$rs->open( $sql );

		if ( ! $rs->eof )
		{
			$dir_amount = -2;
			$dir = opendir( pvs_upload_dir() . $rs->row["url"] );
			while ( $file = readdir( $dir ) )
			{
				if ( is_dir( pvs_upload_dir() . $rs->row["url"] . "/" . $file ) )
				{
					$dir_amount++;
				}
			}
			closedir( $dir );

			if ( file_exists( pvs_upload_dir() . "/" . $rs->row["url"] ) and $dir_amount ==
				0 and $rs->row["url"] != "" )
			{
				@unlink( pvs_upload_dir() . "/" . $rs->row["url"] . "/.htaccess" );
				@rmdir( pvs_upload_dir() . "/" . $rs->row["url"] );

				$sql = "delete from " . PVS_DB_PREFIX . "filestorage where id=" . ( int )$_GET["id"];

				$db->execute( $sql );
			}
		}
	}
}
?>

<div class="subheader"><?php
echo pvs_word_lang( "overview" )
?></div>
<div class="subheader_text">

<p>

By default all files are stored into the <b>/wp-content/uploads/content/</b> folder.

</p><p>

Every publication has the next directory's structure: <b>/wp-content/uploads/content/[publication ID]/</b>

</p><p>

In Linux system a directory may have only <b>31998</b> subdirectories. So when you will have <b>31998 publications</b> you should add a new folder for the file's storage.

</p><p>

To <b>add a new file storage folder</b> you should create a new directory for example <b>/wp-content/uploads/content2/</b> and copy <b>/wp-content/uploads/content/.htaccess</b> file there.

</p><p>

Please <b>not to forget to copy /wp-content/uploads/content/.htaccess</b> file to the new file storage directory. It is very important for <b>security reasons</b>.

</p>

</div>
<div class="subheader"><?php
echo pvs_word_lang( "Folders" )
?></div>
<div class="subheader_text">

<p>
<a class="button button-secondary button-large toright" href="<?php
echo ( pvs_plugins_admin_url( 'storage/index.php' ) );
?>&d=2&action=add"><i class="icon-folder-open icon-white"></i> <?php
echo pvs_word_lang( "Add  New  Folder" )
?></a>
</p>

<p>
Here you can select where you would like to store files on the local server:
</p>

<?php
$sql = "select * from " . PVS_DB_PREFIX . "filestorage where types=0";
$rs->open( $sql );
if ( ! $rs->eof )
{
?>
<form method="post">
<input type="hidden" name="action" value="change">
<table class="wp-list-table widefat fixed striped posts">
<thead>
<tr>
<th><b>Enabled</b></th>
<th style="width:60%"><b>URL</b></th>
<th><b><?php
	echo pvs_word_lang( "quantity" )
?></b></th>
<th><b><?php
	echo pvs_word_lang( "delete" )
?></b></th>
</tr>
</thead>
<?php
	while ( ! $rs->eof )
	{
?>
<tr>
<td align="center"><input name="activ" type="radio" value="<?php
		echo $rs->row["id"]
?>" <?php
		if ( $rs->row["activ"] == 1 )
		{
			echo ( "checked" );
		}
?>></td>
<td><?php
		echo ( pvs_upload_dir() );
?><b><?php
		echo $rs->row["url"]
?>/</b></td>
<td>

<?php
		$dir_amount = -2;
		$dir = opendir( pvs_upload_dir() . $rs->row["url"] );
		while ( $file = readdir( $dir ) )
		{
			if ( is_dir( pvs_upload_dir() . $rs->row["url"] . "/" . $file ) )
			{
				$dir_amount++;
			}
		}
		closedir( $dir );

		if ( $dir_amount < 0 )
		{
			$dir_amount = 0;
		}

		echo ( $dir_amount );
?>




</td>
<td><?php
		if ( $rs->row["id"] != 1 and $dir_amount <= 0 )
		{
?><a href="<?php
			echo ( pvs_plugins_admin_url( 'storage/index.php' ) );
?>&d=2&action=delete&id=<?php
			echo $rs->row["id"]
?>"><b><?php
			echo pvs_word_lang( "delete" )
?></b></a><?php
		} else
		{
			echo ( "You may not delete the directory because it is not empty." );
		}
?></td>
</tr>
<?php
		$rs->movenext();
	}
?>
</table>
<p><input type="submit" class="button button-primary button-large" value="<?php
	echo pvs_word_lang( "save" )
?>"></p>
</form><br>
<?php
}
?>

</div>
