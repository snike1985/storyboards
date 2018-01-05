<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

$type = "for me";

include ( "profile_top.php" );?>



<h1><?php echo pvs_word_lang( "testimonials" );?> - <?php echo pvs_word_lang( "for me" );?></h1>

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
?>




<?php
$n = 0;
$tr = 1;
$sql = "select id_parent,touser,fromuser,data,content from " . PVS_DB_PREFIX .
	"testimonials where touser='" . pvs_result( pvs_get_user_login () ) .
	"' order by data desc";
$rs->open( $sql );
if ( ! $rs->eof ) {
?>
	<table border="0" cellpadding="0" cellspacing="0" class="profile_table" width="100%">
	<tr>
	<th><?php echo pvs_word_lang( "from" );?>:</th>
	<th class='hidden-phone hidden-tablet'><?php echo pvs_word_lang( "date" );?>:</th>
	<th width="60%"><?php echo pvs_word_lang( "content" );?>:</th>
	</tr>
	<?php
	while ( ! $rs->eof ) {
		if ( $n >= $kolvo * ( $str - 1 ) and $n < $kolvo * $str ) {
?>
			<tr <?php
			if ( $tr % 2 == 0 )
			{
				echo ( "class='snd'" );
			}
?>>
			<td><?php
			echo pvs_show_user_avatar( $rs->row["fromuser"], "login" );?></td>
			<td nowrap class='hidden-phone hidden-tablet'><div class="link_date"><?php
			echo pvs_show_time_ago( $rs->row["data"] );?></div></td>
			<td nowrap><div id="c<?php
			echo $rs->row["id_parent"];
?>" name="c<?php
			echo $rs->row["id_parent"];
?>"><?php
			echo str_replace( "\n", "<br>", $rs->row["content"] );?></div></td>
			</tr>
			<?php
		}
		$n++;
		$tr++;
		$rs->movenext();
	}
?>
	</table>
	<?php echo ( pvs_paging( $n, $str, $kolvo, $kolvo2, site_url() . "/testimonials-for-me/", "" ) );
} else
{
	echo ( "<b>" . pvs_word_lang( "not found" ) . "</b>" );
}
?>


<?php
include ( "profile_bottom.php" );
?>