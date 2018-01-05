<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

$subscription_limit = $pvs_global_settings["subscription_limit"];

$sql = "select title,user,data1,data2,bandwidth,bandwidth_limit,subscription,approved,id_parent,bandwidth_daily,bandwidth_daily_limit,bandwidth_date,total from " .
	PVS_DB_PREFIX . "subscription_list where user='" . pvs_result( pvs_get_user_login () ) .
	"' order by data2 desc";
$ds->open( $sql );
if ( ! $ds->eof ) {
?>

<table border="0" cellpadding="0" cellspacing="0"   class="profile_table" width="100%">
<tr>
<th><b><?php echo pvs_word_lang( "subscription" );?>:</b></th>
<th class='hidden-phone hidden-tablet'><b><?php echo pvs_word_lang( "limit" );?> (<?php echo $subscription_limit;
?>):</b></th>
<th class='hidden-phone hidden-tablet'><b><?php echo pvs_word_lang( "daily limit" );?>:</b></th>
<th class='hidden-phone hidden-tablet'><b><?php echo pvs_word_lang( "content type" );?>:</b></th>
<th class='hidden-phone hidden-tablet'><b><?php echo pvs_word_lang( "setup date" );?>:</b></th>
<th><b><?php echo pvs_word_lang( "expiration date" );?>:</b></th>
<th><b><?php echo pvs_word_lang( "status" );?>:</b></th>
<?php
if ( $pvs_global_settings["invoices"] )
{
?>
<th><b><?php echo pvs_word_lang( "Invoice" )?></b></th>
<?php
}
?>
</tr>

<?php
	$tr = 1;
	while ( ! $ds->eof ) {
?>
<tr <?php
		if ( $tr % 2 == 0 ) {
			echo ( "class='snd'" );
		}
?>>
<td><div class="link_subscription"><?php echo $ds->row["title"];
?></div></td>
<td class='hidden-phone hidden-tablet'><?php
		$bandwidth = $ds->row["bandwidth"];
		$bandwidth_text = "";
		if ( $subscription_limit == "Bandwidth" ) {
			$bandwidth = pvs_price_format( $ds->row["bandwidth"], 3 );
			$bandwidth_text = "Mb.";
		}
		if ( $subscription_limit == "Credits" ) {
			$bandwidth = pvs_price_format( $ds->row["bandwidth"], 2 );
		}
		echo ( $bandwidth );?>(<?php echo $ds->row["bandwidth_limit"];
?>) <?php echo $bandwidth_text;
?></td>
<td class='hidden-phone hidden-tablet'>
<?php
		if ( $ds->row["bandwidth_daily_limit"] != 0 ) {
			if ( date( "j" ) == $ds->row["bandwidth_date"] )
			{
?><?php
				echo $ds->row["bandwidth_daily"];
?> (<?php
				echo $ds->row["bandwidth_daily_limit"];
?>) <?php
				echo $bandwidth_text;
?><?php
			} else
			{
?>0 (<?php
				echo $ds->row["bandwidth_daily_limit"];
?>) <?php
				echo $bandwidth_text;
?><?php
			}
		} else {
			echo ( pvs_word_lang( "no" ) );
		}
?>
</td>
<td class='hidden-phone hidden-tablet'><?php
		$sql = "select * from " . PVS_DB_PREFIX . "subscription where id_parent=" . $ds->
			row["subscription"];
		$rs->open( $sql );
		if ( ! $rs->eof ) {
			echo ( str_replace( "|", "&nbsp;+&nbsp;", $rs->row["content_type"] ) );
		}
?></td>
<td class='hidden-phone hidden-tablet'><div class="link_date"><?php echo date( datetime_format, $ds->row["data1"] );?></div></td>
<td><div class="link_date"><?php echo date( datetime_format, $ds->row["data2"] );?></div></td>
<td><?php
		if ( $ds->row["approved"] == 1 ) {
			echo ( "<div class='link_approved'>" . pvs_word_lang( "approved" ) . "</div>" );
		} else {
			echo ( "<div class='link_pending'>" . pvs_word_lang( "pending" ) . "</div>" );
		}
?></td>
<?php
if ( $pvs_global_settings["invoices"] )
{
?>
<td>
<?php
		if ( $ds->row["total"] > 0 ) {
			$invoice_number = "";

			$sql = "select invoice_number,status,refund from " . PVS_DB_PREFIX .
				"invoices where order_type='subscription' and order_id=" . $ds->row["id_parent"] .
				" order by id";
			$dr->open( $sql );
			while ( ! $dr->eof )
			{
				if ( $dr->row["status"] )
				{
					if ( $dr->row["refund"] == 1 )
					{
						$invoice_number = pvs_word_lang( "Refund money" ) . ": #" . $pvs_global_settings["credit_notes_prefix"] .
							$dr->row["invoice_number"];
						$link_class = "style='color:red'";
					} else
					{
						$invoice_number = "#" . $pvs_global_settings["invoice_prefix"] . $dr->row["invoice_number"];
						$link_class = "";
					}
?>
			<a href="<?php echo (site_url( ) );?>/invoice/?id=<?php
					echo $dr->row["invoice_number"];
?>" <?php
					echo $link_class;
?>>
			 <?php
					echo $invoice_number;
?></a><br>
			<?php
				}

				$dr->movenext();
			}
		}
?>
</td>
<?php
}
?>
</tr>
<?php
		$tr++;
		$ds->movenext();
	}
?>
</table>

<?php
}
?>
<br><br><br>