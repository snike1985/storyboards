<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

?>
<div class="postbox" id="box_orders">
                  <h4 class="hndle ui-sortable-handle" style="padding:0px 0px 5px 20px"><span><?php echo pvs_word_lang( "Last uploads" )?></span></h4>

                <div class="inside">
	<div class="main">
                  <table class="table no-margin">

                    <?php
	$sql = "select id,title,description,server1,userid,data,media_id from " .
		PVS_DB_PREFIX . "media where userid<>0 order by data desc limit 0,5";
	$rs->open( $sql );

	if ( ! $rs->eof ) {
		while ( ! $rs->eof ) {
			if ($rs->row["media_id"] == 1) {
				$type = 'photo';
			}
			if ($rs->row["media_id"] == 2) {
				$type = 'video';
			}
			if ($rs->row["media_id"] == 3) {
				$type = 'audio';
			}
			if ($rs->row["media_id"] == 4) {
				$type = 'vector';
			}
?>
								<tr>
								  <td><div class="product-img">
									<a href="<?php echo(pvs_plugins_admin_url('catalog/index.php'));?>&action=content&id=<?php
			echo $rs->row["id"] ?>"><img src="<?php
			echo pvs_show_preview( $rs->row["id"], $type, 1, 1, $rs->row["server1"],
				$rs->row["id"] )?>" /></a>
								  </div></td>
								  <td><div class="product-info">
									<a href="<?php echo(pvs_plugins_admin_url('catalog/index.php'));?>&action=content&id=<?php
			echo $rs->row["id"] ?>" class="product-title"><?php
			echo $rs->row["title"] ?> <span class="label label-warning pull-right"><?php
			echo pvs_word_lang( $type )?></span></a>
									<span class="product-description">
									  <?php
			echo $rs->row["description"] ?>
									</span>
								  </div></td>
								</tr>
								<?php
			$rs->movenext();
		}
	} else {
		echo ( pvs_word_lang( "not found" ) );
	}
?>



                  </table>
                                  <div class="box-footer text-center">
                  <a href="<?php echo(pvs_plugins_admin_url('upload/index.php'));?>" class="btn btn-default"><?php echo pvs_word_lang( "All uploads" )?></a>
                </div>
                </div>
</div>
              </div>
