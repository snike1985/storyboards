<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

?>
<div class="postbox" id="box_orders">
                  <h4 class="hndle ui-sortable-handle" style="padding:0px 0px 5px 20px"><span><?php echo pvs_word_lang( "new orders" )?></span></h4>

                <div class="inside">
	<div class="main">
                    <table class="table no-margin">
                      <thead>
                        <tr>
							<th><b><?php echo pvs_word_lang( "id" )?></b></th>
							<th><b><?php echo pvs_word_lang( "date" )?></b></th>
							<th><b><?php echo pvs_word_lang( "user" )?></b></th>
							<th><b><?php echo pvs_word_lang( "total" )?></b></th>
							<th><b><?php echo pvs_word_lang( "status" )?></b></th>
							<th><b><?php echo pvs_word_lang( "shipping" )?></b></th>
                        </tr>
                      </thead>
                      <tbody>

                        
                        <?php
	$tr = 1;
	$sql = "select id,user,data,total,status,shipped,shipping from " . PVS_DB_PREFIX .
		"orders order by data desc limit 5";
	$rs->open( $sql );
	while ( ! $rs->eof ) {

		$cl = "success";
		if ( $rs->row["status"] != 1 ) {
			$cl = "danger";
		}

		$cl2 = "info";
		if ( $rs->row["shipped"] != 1 ) {
			$cl2 = "warning";
		}
?>
						<tr <?php
		if ( $tr % 2 == 0 ) {
			echo ( "class='snd'" );
		}
?> valign="top">
						<td><a href="<?php echo(pvs_plugins_admin_url('orders/index.php'));?>&action=order_content&id=<?php echo $rs->row["id"] ?>"><b>#<?php echo $rs->row["id"] ?></b></a></td>
						<td><?php echo date( date_format, $rs->row["data"] )?></td>
						<td>
<div class="link_user"><a href="<?php echo(pvs_plugins_admin_url('customers/index.php'));?>&action=content&id=<?php
			echo $rs->row["user"] ?>"><?php
			echo pvs_user_id_to_login($rs->row["user"]) ?></a></div>
						</td>
						<td><?php echo pvs_price_format( $rs->row["total"], 2 )?></td>
						<td>
						
						
						<div id="status<?php echo $rs->row["id"] ?>" name="status<?php echo $rs->row["id"] ?>"><a href="javascript:pvs_order_status(<?php echo $rs->row["id"] ?>);"><span class="label label-<?php echo $cl
?>"><?php
		if ( $rs->row["status"] == 1 ) {
			echo ( pvs_word_lang( "approved" ) );
		} else {
			echo ( pvs_word_lang( "pending" ) );
		}
?></span></a></div>
			
						</td>
						<td>
						<?php
		if ( $rs->row["shipping"] * 1 != 0 ) {
?>
						
						<div class="link_status" id="shipping<?php
			echo $rs->row["id"] ?>" name="shipping<?php
			echo $rs->row["id"] ?>"><a href="javascript:pvs_order_shipping_status(<?php
			echo $rs->row["id"] ?>);"><span class="label label-<?php
			echo $cl2
?>"><?php
			if ( $rs->row["shipped"] == 1 )
			{
				echo ( pvs_word_lang( "shipped" ) );
			} else
			{
				echo ( pvs_word_lang( "not shipped" ) );
			}
?></span></a></div>
						
						
						
						<?php
		} else {
			echo ( "<span class='label label-default'>" . pvs_word_lang( "digital" ) .
				"</span>" );
		}
?>
						
						
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
                  <a href="<?php echo(pvs_plugins_admin_url('orders/index.php'));?>" class="btn btn-sm btn-default btn-flat pull-right"><?php echo pvs_word_lang( "All Orders" )?></a>
                </div>
              </div>
                                </div>
                </div>
