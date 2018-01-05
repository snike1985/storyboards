<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

?>
<div class="postbox" id="box_orders">
                  <h4 class="hndle ui-sortable-handle" style="padding:0px 0px 5px 20px"><span><?php echo pvs_word_lang( "Recent comments" )?></span></h4>

                <div class="inside">
	<div class="main">
                      <!-- Conversations are loaded here -->
                      <table class="table no-margin">
                      
                      
						 <?php
	$sql = "select data,id_parent,fromuser,content from " . PVS_DB_PREFIX .
		"reviews order by data desc limit 0,6";
	$rs->open( $sql );
	while ( ! $rs->eof ) {

?>
<tr>
<td><a href="<?php echo(pvs_plugins_admin_url('customers/index.php'));?>&action=content&id=<?php echo pvs_user_login_to_id($rs->row["fromuser"]) ?>"><?php echo get_avatar(pvs_user_login_to_id($rs->row["fromuser"]), 50);
?></a></td>
<td><a href="<?php echo(pvs_plugins_admin_url('customers/index.php'));?>&action=content&id=<?php echo pvs_user_login_to_id($rs->row["fromuser"]) ?>"><?php echo $rs->row["fromuser"] ?></a><br>
<small><?php echo pvs_show_time_ago( $rs->row["data"] )?></small>
</td>
<td style="width:60%"><?php echo $rs->row["content"] ?></td>
</tr>
							<?php
		$rs->movenext();
	}
?>                     
</table>
                    <div class="box-footer  text-center">
                    	<a href="<?php echo(pvs_plugins_admin_url('comments/index.php'));?>" class="btn btn-default"><?php echo pvs_word_lang( "All comments" )?></a>
                    </div>

					</div>
                    </div>

                  </div>
