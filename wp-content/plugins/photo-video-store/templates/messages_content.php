<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

include ( "profile_top.php" );

$type = "content";
?>

<h1><?php echo pvs_word_lang( "messages" )?></h1>





<?php
$sql = "select touser,fromuser,subject,content,data,viewed,id_parent from " .
	PVS_DB_PREFIX . "messages where id_parent=" . ( int )@$_GET["m"] .
	" and (touser='" . pvs_result( pvs_get_user_login () ) . "' or fromuser='" .
	pvs_result( pvs_get_user_login () ) . "')";
$rs->open( $sql );
if ( ! $rs->eof ) {
?>



<table border="0" cellpadding="0" cellspacing="0">
<tr>

<td><?php
	if ( $rs->row["fromuser"] != "Site Administration" ) {
		echo ( pvs_show_user_avatar( $rs->row["fromuser"], "login" ) );
	} else {
		echo ( "<b>" . $rs->row["fromuser"] . "</b>" );
	}
?></td>



<td style="padding-left:80px">
<div class="link_message"> <?php echo $rs->row["subject"] ?></div>
</td>


<td style="padding-left:80px"><div class="link_date"><?php echo date( datetime_format, $rs->row["data"] )?></div></td>
</tr>
</table>

<hr />

<div style="width:700px"><?php echo str_replace( "\n", "<br>", $rs->row["content"] )?></div>

<hr />

<?php
	if ( $rs->row["touser"] == pvs_get_user_login () ) {

		$sql = "update " . PVS_DB_PREFIX . "messages set viewed=1 where id_parent=" . $rs->
			row["id_parent"];
		$db->execute( $sql );?>
<input class='isubmit' type="button" value="<?php echo pvs_word_lang( "reply" )?>" onclick="location.href='<?php echo (site_url( ) );?>/messages-new/?m=<?php echo $rs->row["id_parent"] ?>'" style="margin-top:4px">
<?php
	}
?>

<?php
}

include ( "profile_bottom.php" );
?>