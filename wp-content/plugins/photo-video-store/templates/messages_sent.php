<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}
$type = "sent";

include ( "profile_top.php" );

//������� ��������
if ( ! isset( $_GET["str"] ) ) {
	$str = 1;
} else
{
	$str = ( int )$_GET["str"];
}

//���������� �������� �� ��������
$kolvo = $pvs_global_settings["k_str"];

//���������� ������� �� ��������
$kolvo2 = PVS_PAGE_NUMBER;
?>
<input type="button" value="<?php echo pvs_word_lang( "new message" )?>" class="profile_button" onClick="location.href='<?php echo (site_url( ) );?>/messages-new/'">
<h1><?php echo pvs_word_lang( "messages" )?> - <?php echo pvs_word_lang( "sentbox" )?></h1>

<?php
$sql = "select id_parent,touser,fromuser,subject,data,viewed from " .
	PVS_DB_PREFIX . "messages where fromuser='" . pvs_result( pvs_get_user_login () ) .
	"' order by data desc";
$rs->open( $sql );
if ( ! $rs->eof ) {
?>
	<table border="0" cellpadding="0" cellspacing="0" class="profile_table" width="100%">
	<tr>
	<th><?php echo pvs_word_lang( "to" )?>:</th>
	<th width="50%"><?php echo pvs_word_lang( "subject" )?>:</th>
	<th class='hidden-phone hidden-tablet'><?php echo pvs_word_lang( "date" )?>:</th>
	</tr>
	<?php
	$n = 0;
	$tr = 1;
	while ( ! $rs->eof ) {
		if ( $n >= $kolvo * ( $str - 1 ) and $n < $kolvo * $str ) {
?>
			<tr  <?php
			if ( $tr % 2 == 0 )
			{
				echo ( "class='snd'" );
			}
?>>
			<td nowrap><?php
			echo pvs_show_user_avatar( $rs->row["touser"], "login" )?></td>
			<td><div class="link_message"><a href="<?php echo (site_url( ) );?>/messages-content/?m=<?php
			echo $rs->row["id_parent"] ?>"><?php
			if ( $rs->row["viewed"] == 0 )
			{
				echo ( "<b>" );
			}
?><?php
			echo $rs->row["subject"] ?></a></div></td>
			<td nowrap class='hidden-phone hidden-tablet'><div class="link_date"><?php
			echo pvs_show_time_ago( $rs->row["data"] )?></div></td>
			</tr>
			<?php
		}
		$n++;
		$tr++;
		$rs->movenext();
	}
?>
	</table>
	<?php echo ( pvs_paging( $n, $str, $kolvo, $kolvo2, site_url() . "/messages-sent/", "" ) );
} else
{
	echo ( "<b>" . pvs_word_lang( "not found" ) . "</b>" );
}

include ( "profile_bottom.php" );
?>