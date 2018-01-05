<?php
//Check access
pvs_admin_panel_access( "orders_commission" );




if ( ! isset( $_GET["str"] ) ) {
	$str = 1;
} else
{
	$str = ( int )$_GET["str"];
}


$kolvo = $pvs_global_settings["k_str"];


$kolvo2 = PVS_PAGE_NUMBER;

$sql = "select user,sum(total) as sum_total from " . PVS_DB_PREFIX .
	"commission group by user order by sum_total desc";
$rs->open( $sql );
if ( ! $rs->eof ) {
?>
	<script>
		function change_threshold() {
			if($("#threshold").prop("checked"))
			{
				$(".threshold_no").css("display","none");
			}
			else
			{
				$(".threshold_no").css("display","table-row");
			}
		}
	</script>
	<p><input type="checkbox" id="threshold" onClick="change_threshold()">&nbsp;&nbsp;<?php echo ( pvs_word_lang( "Show user where balance more than payout's threshold" ) );
?></p>
	<br>
	
	<table class="wp-list-table widefat fixed striped posts">
<thead>
	<tr>
	<th><b><?php echo pvs_word_lang( "user" )?></b></th>

	<th class="hidden-phone hidden-tablet"><b><?php echo pvs_word_lang( "earning" )?></b></th>
	<th class="hidden-phone hidden-tablet"><b><?php echo pvs_word_lang( "refund" )?></b></th>
	<th><b><?php echo pvs_word_lang( "balance" )?></b></th>
	<th><b><?php echo pvs_word_lang( "Balance threshold for payout" )?></b></th>
	<th style="width:20%"><b><?php echo pvs_word_lang( "payout method" )?></b></th>
	</tr>
	</thead>
	<?php
	
	$n = 0;
	while ( ! $rs->eof ) {
		if ( $n >= $kolvo * ( $str - 1 ) and $n < $kolvo * $str ) {

			$total1 = 0;
			$sql = "select user,total from " . PVS_DB_PREFIX .
				"commission where total>0 and user=" . $rs->row["user"];
			$ds->open( $sql );
			while ( ! $ds->eof )
			{
				$total1 += $ds->row["total"];
				$ds->movenext();
			}

			$total2 = 0;
			$sql = "select user,total,status from " . PVS_DB_PREFIX .
				"commission where total<0 and user=" . $rs->row["user"];
			$ds->open( $sql );
			while ( ! $ds->eof )
			{
				if ( $ds->row["status"] == 1 )
				{
					$total2 += $ds->row["total"];
				}
				$ds->movenext();
			}

			$payout_limit = 0;
			
			$user_info = get_userdata($rs->row["user"]);

			$payout_limit = @$user_info -> payout_limit;

			$style = 'threshold_no';
			if ( $payout_limit <= $total1 + $total2 )
			{
				$style = 'threshold_yes';
			}
?>
			<tr class="<?php
			echo ( $style );
?>" valign="top">
			<td><a href="<?php
	echo ( pvs_plugins_admin_url( 'customers/index.php' ) );
?>&action=content&id=<?php
			echo $rs->row["user"]?>"><?php
			echo pvs_user_id_to_login( $rs->row["user"] )?></a></td>
			<td class="hidden-phone hidden-tablet">
			<?php
			echo pvs_currency( 1, false );
?><?php
			echo pvs_price_format( $total1, 2 )?> <?php
			echo pvs_currency( 2, false );
?>
			</td>
			<td class="hidden-phone hidden-tablet">
			<?php
			echo pvs_currency( 1, false );
?><?php
			echo pvs_price_format( ( -1 * $total2 ), 2 )?> <?php
			echo pvs_currency( 2, false );
?>
			</td>
			<td><span class="price"><b><?php
			echo pvs_currency( 1, false );
?><?php
			echo pvs_price_format( $total1 + $total2, 2 )?> <?php
			echo pvs_currency( 2, false );
?></b></span></td>
			<td>
			<?php
			if ( $payout_limit <= $total1 + $total2 )
			{
				echo ( "<span class='label label-danger'>" );
			}
?>
			<?php
			echo pvs_currency( 1, false )?><?php
			echo pvs_price_format( $payout_limit, 2 )?> <?php
			echo pvs_currency( 2, false )?>
			</td>
			<td>
				<?php
				$color_number = 0;
				$sql = "select * from " . PVS_DB_PREFIX . "payout where activ=1";
				$ds->open( $sql );
				while ( ! $ds->eof )
				{
					$payout_method = get_user_meta( $rs->row["user"], $ds->row["svalue"], true );
					
					if ( $payout_method != "" )
					{
?>
									<a href="<?php echo(pvs_plugins_admin_url('commission/index.php'));?>&action=payout&d=3&user=<?php
						echo $rs->row["user"] ?>&method=<?php
						echo $ds->row["svalue"] ?>"  class="link_gateway" style="background-color:<?php echo(@$payment_colors[$color_number]);?>"><?php
						echo str_replace( " account", "", $ds->row["title"] )?>&#187;</a>&nbsp;&nbsp;&nbsp;
								<?php
						$color_number++;
					}
					$ds->movenext();
				}
?>
				<a href="<?php echo(pvs_plugins_admin_url('commission/index.php'));?>&action=payout&d=3&user=<?php
			echo $rs->row["user"] ?>&method=other" class="link_other"><?php
			echo pvs_word_lang( "other" )?> &#187;</a>&nbsp;&nbsp;&nbsp;
			</td>
			</tr>
			<?php
		}
		
		$n++;
		$rs->movenext();
	}
?>
	</table>
	<br>
	<?php echo ( pvs_paging( $n, $str, $kolvo, $kolvo2, pvs_plugins_admin_url('commission/index.php'), "&d=3" ) );
} else
{
	echo ( "<b>" . pvs_word_lang( "not found" ) . "</b>" );
}
?>