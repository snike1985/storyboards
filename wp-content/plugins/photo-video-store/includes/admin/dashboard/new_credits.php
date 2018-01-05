<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( $pvs_global_settings["credits"]) {
?>
<div class="postbox" id="box_orders">
                  <h4 class="hndle ui-sortable-handle" style="padding:0px 0px 5px 20px"><span><?php echo pvs_word_lang( "new credits" )?></span></h4>

                <div class="inside">
	<div class="main">
                    <table class="table no-margin">
                      <thead>
                        <tr>
							<th><b><?php echo pvs_word_lang( "id" )?></b></th>
							<th><b><?php echo pvs_word_lang( "date" )?></b></th>
							<th><b><?php echo pvs_word_lang( "user" )?></b></th>
							<th><b><?php echo pvs_word_lang( "quantity" )?></b></th>
							<th><b><?php echo pvs_word_lang( "status" )?></b></th>
                        </tr>
                      </thead>
                      <tbody>                   
						<?php
	$tr = 1;
	$sql = "select id_parent,user,data,quantity,approved from " . PVS_DB_PREFIX .
		"credits_list where quantity>0 order by data desc limit 6";
	$rs->open( $sql );
	while ( ! $rs->eof ) {

		$cl = "success";
		if ( $rs->row["approved"] != 1 ) {
			$cl = "danger";
		}
?>
						<tr <?php
		if ( $tr % 2 == 0 ) {
			echo ( "class='snd'" );
		}
?> valign="top">
						<td>
						<?php
		if ( $rs->row["quantity"] > 0 ) {
?>
						<a href="<?php echo(pvs_plugins_admin_url('credits/index.php'));?>&search=<?php echo $rs->row["id_parent"] ?>&search_type=id">
						<?php
		}
?>
						
						<b>#<?php echo $rs->row["id_parent"] ?></b></a></td>
						<td><?php echo date( date_format, $rs->row["data"] )?></td>
						<td>
<div class="link_user"><a href="<?php echo(pvs_plugins_admin_url('customers/index.php'));?>&action=content&id=<?php
			echo pvs_user_login_to_id($rs->row["user"]) ?>"><?php
			echo $rs->row["user"] ?></a></div>
						</td>
						<td><?php echo $rs->row["quantity"] ?></td>
						<td>
						
						
						<div id="cstatus<?php echo $rs->row["id_parent"] ?>" name="cstatus<?php echo $rs->row["id_parent"] ?>"><a href="javascript:pvs_credits_status(<?php echo $rs->row["id_parent"] ?>);"><span class="label label-<?php echo $cl
?>"><?php
		if ( $rs->row["approved"] == 1 ) {
			echo ( pvs_word_lang( "approved" ) );
		} else {
			echo ( pvs_word_lang( "pending" ) );
		}
?></span></a></div>

						</td>
						</tr>
						<?php
		$tr++;
		$rs->movenext();
	}
?>
                      </tbody>
                    </table>
                                    <div class="box-footer clearfix">
                  <a href="<?php echo(pvs_plugins_admin_url('credits/index.php'));?>" class="btn btn-sm btn-default btn-flat pull-right"><?php echo pvs_word_lang( "All Credits" )?></a>
                </div>
                  </div>
                </div>
              </div>
              
<?php
}
?>