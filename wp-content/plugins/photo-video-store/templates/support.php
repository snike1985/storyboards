<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

include ( "profile_top.php" );?>

<input type="button" value="<?php echo pvs_word_lang( "open a support request" );?>" class="profile_button" onClick="location.href='<?php echo (site_url( ) );?>/support-new/'">
<h1><?php echo pvs_word_lang( "support" );?></h1>


<?php
if ( isset( $_GET["d"] ) ) {
?>
	<p><b>
    <?php echo pvs_word_lang( "sent" );?>
    </b></p>
	<?php
}
?>

<?php
$sql = "select id,id_parent,admin_id,user_id,subject,message,data,viewed_admin,viewed_user,rating,closed from " .
	PVS_DB_PREFIX . "support_tickets where id_parent=0 and user_id=" . get_current_user_id() .
	" order by data desc";
$rs->open( $sql );
if ( ! $rs->eof ) {
?>

	<table border='0' cellpadding='0' cellspacing='0' style="margin-bottom:20px" class="profile_table" width="100%">
	<tr>
	<th class='hidden-phone hidden-tablet'><?php echo pvs_word_lang( "date" );?></th>
	<th style="width:70%"><?php echo pvs_word_lang( "subject" );?></th>
	<th class='hidden-phone hidden-tablet'><?php echo pvs_word_lang( "status" );?></th>
	</tr>
	<?php
	while ( ! $rs->eof ) {

		$new_messages = 0;
		$total_messages = 1;

		if ( $rs->row["viewed_user"] == 0 ) {
			$new_messages++;
		}

		$sql = "select id,viewed_user,user_id from " . PVS_DB_PREFIX .
			"support_tickets where id_parent=" . $rs->row["id"];
		$ds->open( $sql );
		while ( ! $ds->eof ) {
			if ( $ds->row["viewed_user"] == 0 and $ds->row["user_id"] == 0 )
			{
				$new_messages++;
			}

			$total_messages++;
			$ds->movenext();
		}

		if ( $new_messages > 0 ) {
			$style = "badge-important";
		} else {
			$style = "";
		}
?>
			<tr <?php
		if ( $new_messages > 0 ) {
			echo ( "class='snd2'" );
		}
?>>
	<td class='hidden-phone hidden-tablet'><div class='link_date'><?php echo pvs_show_time_ago( $rs->row["data"] );?></div></tb>
	<td><span class="badge <?php echo $style;
?>"><?php echo $total_messages;
?></span>  <a href="<?php echo (site_url( ) );?>/support-content/?id=<?php echo $rs->row["id"];
?>"><?php echo $rs->row["subject"];
?></a> [ID: <?php echo $rs->row["id"];
?>]</td>		
	<td class='hidden-phone hidden-tablet'>
		<?php
		if ( $rs->row["closed"] == 1 ) {
			echo ( '<span class="label label-success">' . pvs_word_lang( "closed" ) .
				'</span>' );
		} else {
			echo ( '<span class="label label-danger">' . pvs_word_lang( "in progress" ) .
				'</span>' );
		}
?>
	</td>
			</tr>
		<?php
		$rs->movenext();
	}
?>

	</table>
<?php
} else
{
	echo ( pvs_word_lang( "not found" ) );
}
?>



<?php
include ( "profile_bottom.php" );
?>