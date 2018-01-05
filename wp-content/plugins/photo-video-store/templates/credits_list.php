<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}
?>
<p><b><?php echo pvs_word_lang( "balance" )?>: <span class="price"><?php echo pvs_price_format( pvs_credits_balance(), 2 )?> <?php echo pvs_word_lang( "credits" )?></span></b></p>

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

$sql = "select quantity,data,title,approved,payment,expiration_date,id_parent,total from " .
	PVS_DB_PREFIX . "credits_list where user='" . pvs_result( pvs_get_user_login () ) .
	"' order by data desc";
$rs->open( $sql );
if ( ! $rs->eof ) {
?>
<table border="0" cellpadding="0" cellspacing="0"  class="profile_table" width="100%">
<tr>
<th class='hidden-phone hidden-tablet'><?php echo pvs_word_lang( "date" )?></th>
<th><?php echo pvs_word_lang( "title" )?></th>
<th class='hidden-phone hidden-tablet'><?php echo pvs_word_lang( "quantity" )?></th>
<th class='hidden-phone hidden-tablet'><?php echo pvs_word_lang( "expiration date" )?></th>
<th><?php echo pvs_word_lang( "approved" )?></th>
<?php
if ( $pvs_global_settings["invoices"] )
{
?>
<th><?php echo pvs_word_lang( "Invoice" )?></th>
<?php
}
?>
</tr>
<?php
	$tr = 1;
	$n = 0;
	while ( ! $rs->eof ) {
		if ( $n >= $kolvo * ( $str - 1 ) and $n < $kolvo * $str ) {
?>
<tr <?php
			if ( $tr % 2 == 0 )
			{
				echo ( "class='snd'" );
			}
?>>
<td class='hidden-phone hidden-tablet'><div class="link_date"><?php
			echo date( date_format, $rs->row["data"] )?></div></td>
<td nowrap>
<div class="link_order">

<?php
			echo $rs->row["title"] ?>
<?php
			if ( $rs->row["quantity"] > 0 )
			{
?>
</a>
<?php
			}
?>
</div>
</td>
<td nowrap class='hidden-phone hidden-tablet'><?php
			echo pvs_price_format( $rs->row["quantity"], 2 )?></td>
<td class='hidden-phone hidden-tablet'>
<?php
			if ( $rs->row["quantity"] > 0 )
			{
				if ( $rs->row["expiration_date"] == 0 )
				{
					echo ( pvs_word_lang( "never" ) );
				} else
				{
					echo ( "<div class='link_date'>" . date( date_format, $rs->row["expiration_date"] ) .
						"</div>" );
				}
			} else
			{
				echo ( "&#8212;" );
			}
?>
</td>
<td><?php
			if ( $rs->row["approved"] == 1 )
			{
				echo ( "<div class='link_approved'>" . pvs_word_lang( "approved" ) . "</div>" );
			} else
			{
				echo ( "<div class='link_pending'>" . pvs_word_lang( "pending" ) . "</div>" );
			}
?></td>

<?php
if ( $pvs_global_settings["invoices"] )
{
?>
<td>
<?php
			if ( $rs->row["quantity"] > 0 and $rs->row["total"] > 0 )
			{
				$invoice_number = "";

				$sql = "select invoice_number,status,refund from " . PVS_DB_PREFIX .
					"invoices where order_type='credits' and order_id=" . $rs->row["id_parent"] .
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
			}
?>

</td>
<?php
}
?>
</tr>
<?php
		}
		$tr++;
		$rs->movenext();
	}
?>
</table>
<?php echo ( pvs_paging( $n, $str, $kolvo, $kolvo2, site_url() . "/credits/", "&d=2" ) );
} else
{
?>
<p><?php echo pvs_word_lang( "not found" )?>.</p>
<?php
}
?>