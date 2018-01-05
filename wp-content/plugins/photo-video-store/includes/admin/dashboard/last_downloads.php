<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

?>
<div class="postbox" id="box_orders">
                  <h4 class="hndle ui-sortable-handle" style="padding:0px 0px 5px 20px"><span><?php echo pvs_word_lang( "Last downloads" )?></span></h4>

                <div class="inside">
	<div class="main">
                  <table class="table no-margin">

                    <?php
	$sql = "select id_parent,link,tlimit,ulimit,publication_id,id_parent,user_id,collection_id from " .
		PVS_DB_PREFIX . "downloads order by data desc limit 0,5";
	$rs->open( $sql );

	if ( ! $rs->eof ) {
		while ( ! $rs->eof ) {
			if ((int)$rs->row["collection_id"] == 0) { 
				$preview = "";
				$preview_size = "";
	
				$sql = "select server1,title,media_id from " . PVS_DB_PREFIX . "media where id=" . ( int )
					$rs->row["publication_id"];
				$ds->open( $sql );
				if ( ! $ds->eof )
				{
					if ($ds->row["media_id"] == 1) {
						$preview = pvs_show_preview( $rs->row["publication_id"], "photo", 1, 1, $ds->
							row["server1"], $rs->row["publication_id"] );
						$preview_title = $ds->row["title"];
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
	
				if ($ds->row["media_id"] == 2) {
					$preview = pvs_show_preview( $rs->row["publication_id"], "video", 1, 1, $ds->
						row["server1"], $rs->row["publication_id"] );
					$preview_title = $ds->row["title"];
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
	
				if ($ds->row["media_id"] == 3) {
					$preview = pvs_show_preview( $rs->row["publication_id"], "audio", 1, 1, $ds->
						row["server1"], $rs->row["publication_id"] );
					$preview_title = $ds->row["title"];
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
	
				if ($ds->row["media_id"] == 4) {
					$preview = pvs_show_preview( $rs->row["publication_id"], "vector", 1, 1, $ds->
						row["server1"], $rs->row["publication_id"] );
					$preview_title = $ds->row["title"];
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
				if ( ! $ds->eof )
				{
					$item_name = $ds->row["name"];
				}
	
				if ( $preview != "" )
				{
	?>
									<tr>
									  <td>
										<a href="<?php echo(pvs_plugins_admin_url('catalog/index.php'));?>&action=content&id=<?php
					echo $rs->row["publication_id"] ?>"><img src="<?php
					echo $preview
	?>" /></a>
									  </td>
									  <td>
										<a href="<?php echo(pvs_plugins_admin_url('catalog/index.php'));?>&action=content&id=<?php
					echo $rs->row["publication_id"] ?>" class="product-title"><?php
					echo $preview_title
	?></a> <span class="label label-warning pull-right"><?php
					echo pvs_user_id_to_login( $rs->row["user_id"] )?></span>
										<span class="product-description">
										  <?php
					echo $item_name
	?>
										</span>
									  </td>
									</tr>
									<?php
				}
			} else {
				$sql = "select id, title, price, description from " . PVS_DB_PREFIX . "collections where active = 1 and id = " . (int)$rs->row["collection_id"];
				$dd->open( $sql );
				if ( ! $dd->eof ) {
					$collection_result = pvs_show_collection_preview($dd->row["id"]);
	?>
									<tr>
									  <td>
										<a href="<?php echo(pvs_plugins_admin_url('collections/index.php'));?>&action=content&id=<?php
					echo $rs->row["collection_id"] ?>"><img src="<?php echo $collection_result["photo"]; ?>"></a>
									  </td>
									  <td>
										<a href="<?php echo(pvs_plugins_admin_url('collections/index.php'));?>&action=content&id=<?php
					echo $rs->row["collection_id"] ?>" class="product-title"><?php
					echo pvs_word_lang("Collection") . ": " .  $dd->row["title"] . " (" . pvs_count_files_in_collection($dd->row["id"]) . ")";
	?></a> <span class="label label-warning pull-right"><?php
					echo pvs_user_id_to_login( $rs->row["user_id"] )?></span>
										<span class="product-description">
										  
										</span>
									  </td>
									</tr>
									<?php					
				}
			}
			$rs->movenext();
		}
	} else {
		echo ( pvs_word_lang( "not found" ) );
	}
?>



                  </table>
                                  <div class="box-footer text-center">
                  <a href="<?php echo(pvs_plugins_admin_url('downloads/index.php'));?>" class="btn btn-default"><?php echo pvs_word_lang( "All downloads" )?></a>
                </div>
                </div>
</div>
              </div>
