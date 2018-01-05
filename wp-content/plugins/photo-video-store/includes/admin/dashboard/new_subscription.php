<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( $pvs_global_settings["subscription"]) {
?>
<div class="postbox" id="box_orders">
                  <h4 class="hndle ui-sortable-handle" style="padding:0px 0px 5px 20px"><span><?php echo pvs_word_lang( "new subscriptions" )?></span></h4>

                <div class="inside">
	<div class="main">
                    <table class="table no-margin">
                      <thead>
                        <tr>
							<th><b><?php echo pvs_word_lang( "id" )?></b></th>
							<th><b><?php echo pvs_word_lang( "date" )?></b></th>
							<th><b><?php echo pvs_word_lang( "user" )?></b></th>
							<th><b><?php echo pvs_word_lang( "title" )?></b></th>
							<th><b><?php echo pvs_word_lang( "status" )?></b></th>
                        </tr>
                      </thead>
                      <tbody>

                        
                        <?php
	$tr = 1;
	$sql = "select id_parent,user,data1,title,approved,payments from " .
		PVS_DB_PREFIX . "subscription_list order by data1 desc limit 5";
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
						<td nowrap><a href="<?php echo(pvs_plugins_admin_url('subscription_list/index.php'));?>&action=content&id=<?php echo $rs->row["id_parent"] ?>"><b>#<?php echo $rs->row["id_parent"] ?></b></a></td>
						<td nowrap><?php echo date( date_format, $rs->row["data1"] )?></td>
						<td>
<div class="link_user"><a href="<?php echo(pvs_plugins_admin_url('customers/index.php'));?>&action=content&id=<?php
			echo pvs_user_login_to_id($rs->row["user"]) ?>"><?php
			echo $rs->row["user"] ?></a></div>
						</td>
						<td><?php
		if ( $rs->row["payments"] > 1 ) {
			echo ( "<font color='red'>" . $rs->row["payments"] . "&nbsp;x&nbsp;</font>" );
		}
?><?php echo $rs->row["title"] ?></td>
						<td>
						
						
						<div id="sstatus<?php echo $rs->row["id_parent"] ?>" name="sstatus<?php echo $rs->row["id_parent"] ?>"><a href="javascript:pvs_subscription_status(<?php echo $rs->row["id_parent"] ?>);"><span class="label label-<?php echo $cl
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
                  <a href="<?php echo(pvs_plugins_admin_url('subscription_list/index.php'));?>" class="btn btn-sm btn-default btn-flat pull-right"><?php echo pvs_word_lang( "All Subscriptions" )?></a>
                </div>
                  </div>
                </div>

              </div>
              
<?php
}
?>