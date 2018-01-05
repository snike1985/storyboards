<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "affiliates_payout" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

//Payout send
if ( @$_REQUEST["action"] == 'payout_send' )
{
	include ( "payout_send.php" );
}

//Payout delete
if ( @$_REQUEST["action"] == 'payout_delete' )
{
	include ( "payout_delete.php" );
}
?>

<h1><?php echo pvs_word_lang( "refund" )?></h1>



<script>
function pvs_affiliates_status(value1,value2) 
{
	jQuery.ajax({
		type:'POST',
		url:ajaxurl,
		data:'action=pvs_affiliates_status&data=' + value1+'&user=' + value2,
		success:function(data){
			if(data.charAt(data.length-1) == '0')
			{
				data = data.substring(0,data.length-1)
			}
			document.getElementById('status'+value1+"_"+value2).innerHTML =data;
		}
	});
}
</script>


<?php
if ( isset( $_GET["t"] ) ) {
	if ( $_GET["t"] == 1 ) {
		echo ( "<p><b>The payment has been sent successfully. You should approve the transaction.</b></p>" );
	} else {
		echo ( "<p><b>Error. The transaction has been declined.</b></p>" );
	}
}

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

$sql = "select aff_referal,total,data,status,description,gateway from " .
	PVS_DB_PREFIX . "affiliates_signups where total<0 order by data desc";
$rs->open( $sql );
if ( ! $rs->eof ) {
?>
	<table class="wp-list-table widefat fixed striped posts">
	<thead>
	<tr>
	<th><b><?php echo pvs_word_lang( "user" )?></b></th>
	<th><b><?php echo pvs_word_lang( "date" )?></b></th>
	<th><b><?php echo pvs_word_lang( "refund" )?></b></th>
	<th><b><?php echo pvs_word_lang( "payment gateways" )?></b></th>
	<th><b><?php echo pvs_word_lang( "description" )?></b></th>
	<th><b><?php echo pvs_word_lang( "status" )?></b></th>
	<th><b><?php echo pvs_word_lang( "delete" )?></b></th>
	</tr>
	</thead>
	<?php
	$n = 0;
	$total = 0;
	while ( ! $rs->eof ) {
		if ( $n >= $kolvo * ( $str - 1 ) and $n < $kolvo * $str ) {
?>
			<tr valign="top">
			<td><a href="<?php echo ( pvs_plugins_admin_url( 'customers/index.php' ) ); ?>&action=content&id=<?php echo $rs->row["aff_referal"]?>"><?php
			echo pvs_user_id_to_login( $rs->row["aff_referal"] )?></a></td>
			<td class="gray"><?php
			echo date( date_format, $rs->row["data"] )?></td>
			<td><span class="price"><b><?php
			echo pvs_currency( 1, false );
?><?php
			echo pvs_price_format( ( -1 * $rs->row["total"] ), 2 )?> <?php
			echo pvs_currency( 2, false );
?></b></span></td>
			<td>
			<?php
			if ( $rs->row["gateway"] == "" )
			{
				$rs->row["gateway"] = "other";
			}
			echo ( "<div style='display:inline;' class='text_" . $rs->row["gateway"] . "'>" .
				ucfirst( $rs->row["gateway"] ) . "</div>" );
?>
			</td>
			<td><?php
			echo $rs->row["description"] ?></td>
			<td>
			<?php
			$cl = "";
			if ( $rs->row["status"] != 1 )
			{
				$cl = "class='red'";
			}
?>
				<div id="status<?php
			echo $rs->row["data"] ?>_<?php
			echo $rs->row["aff_referal"] ?>" name="status<?php
			echo $rs->row["data"] ?>_<?php
			echo $rs->row["aff_referal"] ?>" class="link_status"><a href="javascript:pvs_affiliates_status(<?php
			echo $rs->row["data"] ?>,<?php
			echo $rs->row["aff_referal"] ?>);" <?php
			echo $cl
?>><?php
			if ( $rs->row["status"] == 1 )
			{
				echo ( pvs_word_lang( "approved" ) );
			} else
			{
				echo ( pvs_word_lang( "pending" ) );
			}
?></a></div>
			</td>
			<td>
			<div class="link_delete"><a href='<?php echo(pvs_plugins_admin_url('affiliates/payout.php'));?>&action=payout_delete&data=<?php
			echo $rs->row["data"] ?>&aff_referal=<?php
			echo $rs->row["aff_referal"] ?>' onClick="return confirm('<?php
			echo pvs_word_lang( "delete" )?>?');"><?php
			echo pvs_word_lang( "delete" )?></a></div>
			</td>
			</tr>
			<?php
		}
		$n++;
		if ( $rs->row["status"] == 1 ) {
			$total += $rs->row["total"];
		}
		$rs->movenext();
	}
?>
	</table>
<br>
	<p><b><?php echo pvs_word_lang( "total" )?>:</b> <span class="price"><b><?php echo pvs_currency( 1, false );
?><?php echo pvs_price_format( ( -1 * $total ), 2 )?> <?php echo pvs_currency( 2, false );
?></b></span></p>
	<?php echo ( "<p>" . pvs_paging( $n, $str, $kolvo, $kolvo2, pvs_plugins_admin_url('affiliates/payout.php'), "" ) .
		"</p>" );
} else
{
	echo ( "<p><b>" . pvs_word_lang( "not found" ) . "</b></p>" );
}
?>

<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>