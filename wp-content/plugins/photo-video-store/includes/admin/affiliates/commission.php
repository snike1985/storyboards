<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "affiliates_commission" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

$payment_colors = array(
		"#d83838",
		"#5e9de4",
		"#fd7405",
		"#f7e40d",
		"#30b716",
		"#4dc717",
		"#77480b",
		"#b80cc7",
		"#22aa9f",
		"#f4a445",
		"56b5d8",
		"#d83838",
		"#5e9de4",
		"#fd7405",
		"#f7e40d",
		"#30b716",
		"#4dc717",
		"#77480b",
		"#b80cc7",
		"#22aa9f",
		"#f4a445",
		"56b5d8" );
		
if ( @$_REQUEST["action"] == 'transaction' ) {
	include ( "transaction.php" );
} else {
	?>
	
	<h1><?php echo pvs_word_lang( "users earnings" )?>:</h1>
	
	<?php
	
	
	//Текущая страница
	if ( ! isset( $_GET["str"] ) ) {
		$str = 1;
	} else
	{
		$str = ( int )$_GET["str"];
	}
	
	//Количество новостей на странице
	$kolvo = $pvs_global_settings["k_str"];
	
	//Количество страниц на странице
	$kolvo2 = PVS_PAGE_NUMBER;
	
	$sql = "select aff_referal,sum(total) as sum_total,aff_referal from " .
		PVS_DB_PREFIX . "affiliates_signups group by aff_referal order by sum_total desc";
	$rs->open( $sql );
	if ( ! $rs->eof ) {
	?>
		<table class="wp-list-table widefat fixed striped posts">
		<thead>
		<tr>
		<th><b><?php echo pvs_word_lang( "user" )?></b></th>
		<th class="hidden-phone hidden-tablet"><b><?php echo pvs_word_lang( "earning" )?></b></th>
		<th class="hidden-phone hidden-tablet"><b><?php echo pvs_word_lang( "refund" )?></b></th>
		<th><b><?php echo pvs_word_lang( "balance" )?></b></th>
		<th><b><?php echo pvs_word_lang( "Balance threshold for payout" )?></b></th>
		<th><b><?php echo pvs_word_lang( "payout method" )?></b></th>
		</tr>
		</thead>
		<?php
		$n = 0;
		
		while ( ! $rs->eof ) {
			if ( $n >= $kolvo * ( $str - 1 ) and $n < $kolvo * $str ) {
	?>
				<tr valign="top">
				<td>
	<a href="<?php
		echo ( pvs_plugins_admin_url( 'customers/index.php' ) );
	?>&action=content&id=<?php
				echo $rs->row["aff_referal"]?>"><?php
				echo pvs_user_id_to_login( $rs->row["aff_referal"] )?></a>
				</td>
				<td  class="hidden-phone hidden-tablet">
				<?php
				$total1 = 0;
				$sql = "select total from " . PVS_DB_PREFIX .
					"affiliates_signups where total>0 and aff_referal=" . $rs->row["aff_referal"] .
					" and status=1";
				$ds->open( $sql );
				while ( ! $ds->eof )
				{
					$total1 += $ds->row["total"];
					$ds->movenext();
				}
	?>
				<b><?php
				echo pvs_currency( 1, false );
	?><?php
				echo pvs_price_format( $total1, 2 )?> <?php
				echo pvs_currency( 2, false );
	?></b>
				</td>
				<td class="hidden-phone hidden-tablet">
				<?php
				$total2 = 0;
				$sql = "select total from " . PVS_DB_PREFIX .
					"affiliates_signups where total<0 and aff_referal=" . $rs->row["aff_referal"] .
					" and status=1";
				$ds->open( $sql );
				while ( ! $ds->eof )
				{
					$total2 += $ds->row["total"];
					$ds->movenext();
				}
	?>
				<b><?php
				echo pvs_currency( 1, false );
	?><?php
				echo pvs_price_format( ( -1 * $total2 ), 2 )?> <?php
				echo pvs_currency( 2, false );
	?></b>
				</td>
				<td><span class="price"><b><?php
				echo pvs_currency( 1, false );
	?><?php
				echo pvs_price_format( $total1 + $total2, 2 )?> <?php
				echo pvs_currency( 2, false );
	?></b></span></td>
				<td>
				<?php
				$payout_limit = 0;
				
				$user_info = get_userdata($rs->row["aff_referal"]);
	
				$payout_limit = @$user_info -> payout_limit;
				
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
						$payout_method = get_user_meta( $rs->row["aff_referal"], $ds->row["svalue"], true );
						
						if ( $payout_method != "" )
						{
	?>
										<a href="<?php echo(pvs_plugins_admin_url('affiliates/commission.php'));?>&action=transaction&user=<?php
							echo $rs->row["aff_referal"] ?>&method=<?php
							echo $ds->row["svalue"] ?>"  class="link_gateway" style="background-color:<?php echo(@$payment_colors[$color_number]);?>"><?php
							echo str_replace( " account", "", $ds->row["title"] )?>&#187;</a>&nbsp;&nbsp;&nbsp;
									<?php
							$color_number++;
						}
						$ds->movenext();
					}
	?>
					<a href="<?php echo(pvs_plugins_admin_url('affiliates/commission.php'));?>&action=transaction&user=<?php
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
		<?php echo ( "<p>" . pvs_paging( $n, $str, $kolvo, $kolvo2, pvs_plugins_admin_url('affiliates/commission.php'), "" ) .
			"</p>" );
	} else
	{
		echo ( "<p><b>" . pvs_word_lang( "not found" ) . "</b></p>" );
	}
}
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>