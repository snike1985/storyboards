<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

include ( "profile_top.php" );?>
<h1><?php echo pvs_word_lang( "orders" )?></h1>




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

$sql = "select * from " . PVS_DB_PREFIX . "orders where user=" . get_current_user_id() .
	" order by data desc,id desc";
$rs->open( $sql );
if ( ! $rs->eof ) {
?>
<table border='0' cellpadding='0' cellspacing='0' style="margin-bottom:20px" class="profile_table" width="100%">
<tr>
<th>ID</th>
<th class='hidden-phone hidden-tablet'><?php echo pvs_word_lang( "date" )?></th>

<th class='hidden-phone hidden-tablet'><?php echo pvs_word_lang( "subtotal" )?></th>
<?php
	if ( ! $pvs_global_settings["credits"] or $pvs_global_settings["credits_currency"] ) {
?>
<th class='hidden-phone hidden-tablet'><?php echo pvs_word_lang( "discount" )?></th>
<?php
	}
?>
<th class='hidden-phone hidden-tablet'><?php echo pvs_word_lang( "shipping" )?></th>
<?php
	if ( ! $pvs_global_settings["credits"] or $pvs_global_settings["credits_currency"] ) {
?>
<th class='hidden-phone hidden-tablet'><?php echo pvs_word_lang( "taxes" )?></th>
<?php
	}
?>
<th class='hidden-phone hidden-tablet'><?php echo pvs_word_lang( "total" )?></th>
<th><?php echo pvs_word_lang( "status" )?></th>
<th><?php echo pvs_word_lang( "shipping" )?></th>
<?php
	if ( ( ! $pvs_global_settings["credits"] or $pvs_global_settings["credits_currency"] ) and $pvs_global_settings["invoices"] ) {
?>
<th><?php echo pvs_word_lang( "invoice" )?></th>
<?php
	}
?>
</tr>
<?php
	$tr = 1;
	$n = 0;
	while ( ! $rs->eof ) {
		if ( $n >= $kolvo * ( $str - 1 ) and $n < $kolvo * $str ) {

			$method = "";
			if ( $pvs_global_settings["credits_currency"] )
			{
				if ( $rs->row["credits"] == 1 )
				{
					$method = "credits";
				} else
				{
					$method = "currency";
				}
			}
?>
<tr <?php
			if ( $tr % 2 == 0 )
			{
				echo ( "class='snd'" );
			}
?>>
<td><div class="link_order"><a href="<?php echo (site_url( ) );?>/orders-content/?id=<?php
			echo $rs->row["id"] ?>"><?php
			echo pvs_word_lang( "order" )?> #<?php
			echo $rs->row["id"] ?></a></div></td>
<td class='hidden-phone hidden-tablet'><div class="link_date"><?php
			echo date( date_format, $rs->row["data"] )?></div></td>

<td class='hidden-phone hidden-tablet'><?php
			echo pvs_currency( 1, true, $method );?><?php
			echo pvs_price_format( $rs->row["subtotal"], 2 )?> <?php
			echo pvs_currency( 2, true, $method );?></td>
<?php
			if ( ! $pvs_global_settings["credits"] or $pvs_global_settings["credits_currency"] )
			{
?>
<td class='hidden-phone hidden-tablet'><?php
				echo pvs_currency( 1, true, $method );?><?php
				echo pvs_price_format( $rs->row["discount"], 2 )?> <?php
				echo pvs_currency( 2, true, $method );?></td>
<?php
			}
?>
<td class='hidden-phone hidden-tablet'><?php
			echo pvs_currency( 1, true, $method );?><?php
			echo pvs_price_format( $rs->row["shipping"], 2 )?> <?php
			echo pvs_currency( 2, true, $method );?></td>
<?php
			if ( ( ! $pvs_global_settings["credits"] or $pvs_global_settings["credits_currency"] )  and $pvs_global_settings["invoices"] )
			{
?>
<td class='hidden-phone hidden-tablet'>
<?php
				if ( $rs->row["credits"] != 1 )
				{
?>
	<?php
					echo pvs_currency( 1, true, $method );?><?php
					echo pvs_price_format( $rs->row["tax"], 2 )?> <?php
					echo pvs_currency( 2, true, $method );?>
	<?php
				} else
				{
					echo ( "&mdash;" );
				}
?>
</td>
<?php
			}
?>
<td class='hidden-phone hidden-tablet'><b><?php
			echo pvs_currency( 1, true, $method );?><?php
			echo pvs_price_format( $rs->row["total"], 2 )?> <?php
			echo pvs_currency( 2, true, $method );?></b></td>
<td><?php
			if ( $rs->row["status"] == 1 )
			{
				echo ( "<div class='link_approved'>" . pvs_word_lang( "approved" ) . "</div>" );
			} else
			{
				echo ( "<div class='link_pending'>" . pvs_word_lang( "pending" ) . "</div>" );
			}
?></td>

<td>
<?php
			if ( $rs->row["shipped"] == 0 and $rs->row["shipping"] * 1 != 0 )
			{
				echo ( "<div class='link_pending'>" . pvs_word_lang( "not shipped" ) . "</div>" );
			}
			if ( $rs->row["shipped"] == 1 and $rs->row["shipping"] * 1 != 0 )
			{
				echo ( "<div class='link_approved'>" . pvs_word_lang( "shipped" ) . "</div>" );
			}
			if ( $rs->row["shipped"] == 0 and $rs->row["shipping"] * 1 == 0 )
			{
				echo ( "&mdash;" );
			}
?>
</td>

<?php
			if ( ! $pvs_global_settings["credits"] or $pvs_global_settings["credits_currency"] )
			{
?>
<td>
<?php
				if ( $rs->row["credits"] != 1 )
				{
					$invoice_number = "";

					$sql = "select invoice_number,status,refund from " . PVS_DB_PREFIX .
						"invoices where order_type='orders' and order_id=" . $rs->row["id"] .
						" order by id";
					$ds->open( $sql );
					while ( ! $ds->eof )
					{
						if ( $ds->row["status"] )
						{
							if ( $ds->row["refund"] == 1 )
							{
								$invoice_number = pvs_word_lang( "Refund money" ) . ": #" . $pvs_global_settings["credit_notes_prefix"] .
									$ds->row["invoice_number"];
								$link_class = "style='color:red'";
							} else
							{
								$invoice_number = "#" . $pvs_global_settings["invoice_prefix"] . $ds->row["invoice_number"];
								$link_class = "";
							}
?>
			<a href="<?php echo (site_url( ) );?>/invoice/?id=<?php
							echo $ds->row["invoice_number"] ?>" <?php
							echo $link_class
?>>
			 <?php
							echo $invoice_number
?></a><br>
			<?php
						}

						$ds->movenext();
					}
				} else
				{
					echo ( "&mdash;" );
				}
?>
</td>
<?php
			}
?>


</tr>
<?php
		}
		$n++;
		$tr++;
		$rs->movenext();
	}
?>
</table>
<?php echo ( pvs_paging( $n, $str, $kolvo, $kolvo2, site_url() . "/orders/", "" ) );
} else
{
?>
<p><?php echo pvs_word_lang( "not found" )?>.</p>
<?php
}

include ( "profile_bottom.php" );
?>