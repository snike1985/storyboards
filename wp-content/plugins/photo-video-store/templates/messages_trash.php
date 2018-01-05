<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

$type = "trash";

include ( "profile_top.php" );

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
?>
<input type="button" value="<?php echo pvs_word_lang( "new message" )?>" class="profile_button" onClick="location.href='<?php echo (site_url( ) );?>/messages-new/'">
<h1><?php echo pvs_word_lang( "messages" )?> - <?php echo pvs_word_lang( "trash" )?></h1>



<script language="javascript">
function publications_select_all(sel_form) {
    if(sel_form.selector.checked)
   	{
        $("input:checkbox", sel_form).attr("checked",true);
    }
    else
    {
        $("input:checkbox", sel_form).attr("checked",false);
    }
}
</script>



<?php
$sql = "select id_parent,touser,fromuser,subject,data,viewed,trash,del from " .
	PVS_DB_PREFIX . "messages where touser='" . pvs_result( pvs_get_user_login () ) .
	"' and trash=1 and del=0 order by data desc";
$rs->open( $sql );
if ( ! $rs->eof ) {
?>
	<form method="post" action="<?php echo (site_url( ) );?>/messages-delete/" id="commentsform" name="commentsform">
	<table border="0" cellpadding="0" cellspacing="0" class="profile_table" width="100%">
	<tr>
	<th><input type="checkbox" id="selector" name="selector" onClick="publications_select_all(document.commentsform);"></th>
	<th><?php echo pvs_word_lang( "from" )?>:</th>
	<th width="50%"><?php echo pvs_word_lang( "subject" )?>:</th>
	<th class='hidden-phone hidden-tablet'><?php echo pvs_word_lang( "date" )?>:</th>
	</tr>
	<?php
	$n = 0;
	$tr = 1;
	while ( ! $rs->eof ) {
		if ( $n >= $kolvo * ( $str - 1 ) and $n < $kolvo * $str ) {
?>
			<tr <?php
			if ( $tr % 2 == 0 )
			{
				echo ( "class='snd'" );
			}
?>>
			<td><input type="checkbox" id="m<?php
			echo $rs->row["id_parent"] ?>" name="m<?php
			echo $rs->row["id_parent"] ?>" value="1"></td>
			<td nowrap><?php
			if ( $rs->row["fromuser"] != "Site Administration" )
			{
				echo ( pvs_show_user_avatar( $rs->row["fromuser"], "login" ) );
			} else
			{
				echo ( "<b>" . $rs->row["fromuser"] . "</b>" );
			}
?></td>
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
	</table><input class='isubmit' type="submit" value="<?php echo pvs_word_lang( "delete" )?>" style="margin-top:4px"></form>
	<?php echo ( pvs_paging( $n, $str, $kolvo, $kolvo2, site_url() . "/messages-trash/", "" ) );
} else
{
	echo ( "<b>" . pvs_word_lang( "not found" ) . "</b>" );
}
?>

<?php
include ( "profile_bottom.php" );
?>