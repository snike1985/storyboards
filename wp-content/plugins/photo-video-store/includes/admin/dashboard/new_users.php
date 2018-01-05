<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

?>
<div class="postbox" id="box_orders">
                  <h4 class="hndle ui-sortable-handle" style="padding:0px 0px 5px 20px"><span><?php echo pvs_word_lang( "Latest Members" )?></span></h4>

                <div class="inside">
	<div class="main">
                      <table class="table no-margin">
                      <?php
	$sql = "select ID,user_login,user_registered from " . $table_prefix . "users order by ID desc limit 0,8";
	$rs->open( $sql );
	while ( ! $rs->eof ) {
?>
                        <tr>
                          <td><a href="<?php echo(pvs_plugins_admin_url('customers/index.php'));?>&action=content&id=<?php echo $rs->row["ID"] ?>"><?php echo get_avatar($rs->row["ID"], 50);
?></a></td>
<td><a class="users-list-name" href="<?php echo(pvs_plugins_admin_url('customers/index.php'));?>&action=content&id=<?php echo $rs->row["ID"] ?>" style="white-space:nowrap"><?php echo $rs->row["user_login"] ?></a></td>
                          <td><span class="users-list-date" style="white-space:nowrap"><?php echo $rs->row["user_registered"]?></span></td>
                        </tr>
					<?php
		$rs->movenext();
	}
?>
                      </table><!-- /.users-list -->
                                          <div class="box-footer text-center">
                      <a href="<?php echo(pvs_plugins_admin_url('customers/index.php'));?>" class="btn btn-default"><?php echo pvs_word_lang( "View All Users" )?></a>
                    </div><!-- /.box-footer -->
                    </div><!-- /.box-body -->

                  </div><!--/.box -->
</div>