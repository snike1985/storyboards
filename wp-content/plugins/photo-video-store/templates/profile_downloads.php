<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}
include ( "profile_top.php" );?>

<div class="btn-group" role="group" style="float:right">
  <button type="button" class="btn btn-primary" onClick="location.href='<?php echo (site_url( ) );?>/profile-downloads/'"><i class="glyphicon glyphicon-th"></i> <?php echo pvs_word_lang( "grid" );?></button>
  <button type="button" class="btn btn-default" onClick="location.href='<?php echo (site_url( ) );?>/profile-downloads-table/'"><i class="glyphicon glyphicon-list"></i> <?php echo pvs_word_lang( "Table" );?></button>
</div>

<h1><?php echo pvs_word_lang( "my downloads" );?></h1>

<?php
$sql = "select id_parent,link,tlimit,ulimit,publication_id from " .
	PVS_DB_PREFIX . "downloads where user_id=" . get_current_user_id() .
	" and tlimit<ulimit and data>" . pvs_get_time( date( "H" ), date( "i" ), date( "s" ),
	date( "m" ), date( "d" ), date( "Y" ) ) . " order by data desc";
$rs->open( $sql );

if ( ! $rs->eof ) {
	while ( ! $rs->eof ) {
		$preview = "";
		$preview_size = "";

		$sql = "select server1,title,media_id from " . PVS_DB_PREFIX . "media where id=" . ( int )
			$rs->row["publication_id"];
		$ds->open( $sql );
		if ( ! $ds->eof ) {
			if ( pvs_media_type ($ds->row["media_id"]) == 'photo' )
			{
				$preview = pvs_show_preview( $rs->row["publication_id"], "photo", 1, 1, $ds->
					row["server1"], $rs->row["publication_id"] );
				$translate_results = pvs_translate_publication( $rs->row["publication_id"], $ds->
					row["title"], "", "" );
				$preview_title = $translate_results["title"];
				$preview_class = 1;
	
				$image_width = 0;
				$image_height = 0;
				$image_filesize = 0;
				$flag_storage = false;
	
				if ( pvs_is_remote_storage() )
				{
					$sql = "select url,filename1,filename2,width,height,item_id,filesize from " .
						PVS_DB_PREFIX . "filestorage_files where id_parent=" . $rs->row["publication_id"];
					$ds->open( $sql );
					while ( ! $ds->eof )
					{
						if ( $ds->row["item_id"] != 0 )
						{
							$image_width = $ds->row["width"];
							$image_height = $ds->row["height"];
							$image_filesize = $ds->row["filesize"];
						}
	
						$flag_storage = true;
						$ds->movenext();
					}
				}

				$sql = "select url,price_id from " . PVS_DB_PREFIX . "items where id=" . $rs->
					row["id_parent"];
				$dr->open( $sql );
				if ( ! $dr->eof )
				{
					if ( ! $flag_storage )
					{
						if ( file_exists( pvs_upload_dir() . pvs_server_url( $ds->row["server1"] ) . "/" .
							$rs->row["publication_id"] . "/" . $dr->row["url"] ) )
						{
							$size = @getimagesize( pvs_upload_dir() . pvs_server_url( $ds->row["server1"] ) .
								"/" . $rs->row["publication_id"] . "/" . $dr->row["url"] );
							$image_width = $size[0];
							$image_height = $size[1];
							$image_filesize = filesize( pvs_upload_dir() . pvs_server_url( $ds->row["server1"] ) .
								"/" . $rs->row["publication_id"] . "/" . $dr->row["url"] );
						}
					}
	
					$sql = "select size from " . PVS_DB_PREFIX . "sizes where id_parent=" . $dr->
						row["price_id"];
					$dn->open( $sql );
					if ( ! $dn->eof )
					{
						if ( $dn->row["size"] != 0 and $image_width != 0 and $image_height != 0 )
						{
							if ( $image_width > $image_height )
							{
								$image_height = round( $image_height * $dn->row["size"] / $image_width );
								$image_width = $dn->row["size"];
							} else
							{
								$image_width = round( $image_width * $dn->row["size"] / $image_height );
								$image_height = $dn->row["size"];
							}
							$image_filesize = 0;
						}
					}
				}
	
				$preview_size = "<br>" . $image_width . "x" . $image_height;
				if ( $image_filesize != 0 )
				{
					$preview_size .= " " . strval( pvs_price_format( $image_filesize / ( 1024 * 1024 ),
						3 ) ) . " Mb.";
				}
			}
		}		

		if ( pvs_media_type ($ds->row["media_id"]) == 'video' )
		{
			$preview = pvs_show_preview( $rs->row["publication_id"], "video", 1, 1, $ds->
				row["server1"], $rs->row["publication_id"] );
			$translate_results = pvs_translate_publication( $rs->row["publication_id"], $ds->
				row["title"], "", "" );
			$preview_title = $translate_results["title"];
			$preview_class = 2;

			$flag_storage = false;
			$file_filesize = 0;

			if ( pvs_is_remote_storage() )
			{
				$sql = "select filename1,filename2,url,item_id,filesize from " . PVS_DB_PREFIX .
					"filestorage_files where id_parent=" . $rs->row["publication_id"] .
					" and item_id=" . $rs->row["id_parent"];
				$dr->open( $sql );
				if ( ! $dr->eof )
				{
					$file_filesize = $dr->row["filesize"];
					$flag_storage = true;
				}
			}

			if ( ! $flag_storage )
			{
				$sql = "select url,price_id from " . PVS_DB_PREFIX . "items where id=" . $rs->
					row["id_parent"];
				$dr->open( $sql );
				if ( ! $dr->eof )
				{
					if ( file_exists( pvs_upload_dir() . pvs_server_url( $ds->row["server1"] ) . "/" .
						$rs->row["publication_id"] . "/" . $dr->row["url"] ) )
					{
						$file_filesize = filesize( pvs_upload_dir() . pvs_server_url( $ds->row["server1"] ) .
							"/" . $rs->row["publication_id"] . "/" . $dr->row["url"] );
					}
				}
			}

			$preview_size .= "<br>" . strval( pvs_price_format( $file_filesize / ( 1024 *
				1024 ), 3 ) ) . " Mb.";
		}

		if ( pvs_media_type ($ds->row["media_id"]) == 'audio' )
		{
			$preview = pvs_show_preview( $rs->row["publication_id"], "audio", 1, 1, $ds->
				row["server1"], $rs->row["publication_id"] );
			$translate_results = pvs_translate_publication( $rs->row["publication_id"], $ds->
				row["title"], "", "" );
			$preview_title = $translate_results["title"];
			$preview_class = 3;

			$flag_storage = false;
			$file_filesize = 0;

			if ( pvs_is_remote_storage() )
			{
				$sql = "select filename1,filename2,url,item_id,filesize from " . PVS_DB_PREFIX .
					"filestorage_files where id_parent=" . $rs->row["publication_id"] .
					" and item_id=" . $rs->row["id_parent"];
				$dr->open( $sql );
				if ( ! $dr->eof )
				{
					$file_filesize = $dr->row["filesize"];
					$flag_storage = true;
				}
			}

			if ( ! $flag_storage )
			{
				$sql = "select url,price_id from " . PVS_DB_PREFIX . "items where id=" . $rs->
					row["id_parent"];
				$dr->open( $sql );
				if ( ! $dr->eof )
				{
					if ( file_exists( pvs_upload_dir() . pvs_server_url( $ds->row["server1"] ) . "/" .
						$rs->row["publication_id"] . "/" . $dr->row["url"] ) )
					{
						$file_filesize = filesize( pvs_upload_dir() . pvs_server_url( $ds->row["server1"] ) .
							"/" . $rs->row["publication_id"] . "/" . $dr->row["url"] );
					}
				}
			}

			$preview_size .= "<br>" . strval( pvs_price_format( $file_filesize / ( 1024 *
				1024 ), 3 ) ) . " Mb.";
		}

		if ( pvs_media_type ($ds->row["media_id"]) == 'vector' )
		{
			$preview = pvs_show_preview( $rs->row["publication_id"], "vector", 1, 1, $ds->
				row["server1"], $rs->row["publication_id"] );
			$translate_results = pvs_translate_publication( $rs->row["publication_id"], $ds->
				row["title"], "", "" );
			$preview_title = $translate_results["title"];
			$preview_class = 4;

			$flag_storage = false;
			$file_filesize = 0;

			if ( pvs_is_remote_storage() )
			{
				$sql = "select filename1,filename2,url,item_id,filesize from " . PVS_DB_PREFIX .
					"filestorage_files where id_parent=" . $rs->row["publication_id"] .
					" and item_id=" . $rs->row["id_parent"];
				$dr->open( $sql );
				if ( ! $dr->eof )
				{
					$file_filesize = $dr->row["filesize"];
					$flag_storage = true;
				}
			}

			if ( ! $flag_storage )
			{
				$sql = "select url,price_id from " . PVS_DB_PREFIX . "items where id=" . $rs->
					row["id_parent"];
				$dr->open( $sql );
				if ( ! $dr->eof )
				{
					if ( file_exists( pvs_upload_dir() . pvs_server_url( $ds->row["server1"] ) . "/" .
						$rs->row["publication_id"] . "/" . $dr->row["url"] ) )
					{
						$file_filesize = filesize( pvs_upload_dir() . pvs_server_url( $ds->row["server1"] ) .
							"/" . $rs->row["publication_id"] . "/" . $dr->row["url"] );
					}
				}
			}

			$preview_size .= "<br>" . strval( pvs_price_format( $file_filesize / ( 1024 *
				1024 ), 3 ) ) . " Mb.";
		}

		$item_name = "";
		$sql = "select name from " . PVS_DB_PREFIX . "items where id=" . ( int )$rs->
			row["id_parent"];
		$ds->open( $sql );
		if ( ! $ds->eof ) {
			$item_name = "<br>[" . $ds->row["name"] . "]";
		}

		if ( $preview != "" ) {
?>
			<div class="item_list">
	<div  class="item_list_img">
		<div  class="item_list_img2">
		<a href="<?php
			echo site_url();
?>/download/?f=<?php
			echo $rs->row["link"];
?>"><img src="<?php
			echo $preview;
?>"></a>
		</div>
	</div>
	<div  class="item_list_text<?php
			echo $preview_class;
?>">
		<div><a href="<?php
			echo site_url();
?>/download/?f=<?php
			echo $rs->row["link"];
?>"><?php
			echo $preview_title;
?></a><small><?php
			echo $item_name;
?><?php
			echo $preview_size;
?></small></div>
		<div class="idownloaded"><?php
			echo pvs_word_lang( "downloads" );?>: <?php
			echo $rs->row["tlimit"];
?>(<?php
			echo $rs->row["ulimit"];
?>)</div>
	</div>
			</div>
			<?php
		}
		$rs->movenext();
	}
} else
{
	echo ( pvs_word_lang( "not found" ) );
}

include ( "profile_bottom.php" );
?>