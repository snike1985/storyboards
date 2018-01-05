<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

?>
<div class="page_internal">

<?php
//Текущая страница
if ( ! isset( $_GET["str"] ) ) {
	$str = 1;
} else
{
	$str = ( int )$_GET["str"];
}

//Количество новостей на странице
$kolvo = 60;

//Количество страниц на странице
$kolvo2 = PVS_PAGE_NUMBER;
?>


<h1><?php echo pvs_word_lang( "users" );?></h1>

<div class="seller_menu">
<?php
$alfavit = array(
	'A',
	'B',
	'C',
	'D',
	'E',
	'F',
	'G',
	'H',
	'I',
	'J',
	'K',
	'L',
	'M',
	'N',
	'O',
	'P',
	'Q',
	'R',
	'S',
	'T',
	'U',
	'V',
	'W',
	'X',
	'Y',
	'Z' );
//$alfavit=array('А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Э','Ю','Я','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');

foreach ( $alfavit as $key => $value ) {
	$sel = "";
	if ( isset( $_GET["letter"] ) and ( int )$_GET["letter"] == $key ) {
		$sel = "class='seller_menu_active'";
	}
?>
	<a href="<?php echo (site_url( ) );?>/users/?letter=<?php echo strtolower( $key );?>" <?php echo $sel;
?>><?php echo $value;
?></a>
	<?php
}
?>
</div>

<div class="vertical_line">&nbsp;</div>



<?php
$com = "";
$com2 = "";
$aletter = "";
if ( isset( $_GET["letter"] ) ) {
	$com = " where user_login like '" . $alfavit[( int )$_GET["letter"]] . "%'";
	$aletter = "&letter=" . ( int )$_GET["letter"];
}

$com2 = " order by user_login";


$n = 0;
$sql = "select ID, user_login from " . $table_prefix .
	"users " . $com . $com2;
$rs->open( $sql );
if ( ! $rs->eof ) {
?>
	<div style="clear:both;">
	<?php
	while ( ! $rs->eof ) {
		$qty = 0;

		$sql = "select count(*) as count_rows from " . PVS_DB_PREFIX .
			"media where published=1 and author='" . $rs->row["user_login"] . "'";
		$ds->open( $sql );
		$qty += $ds->row["count_rows"];


		if ( $n >= $kolvo * ( $str - 1 ) and $n < $kolvo * $str ) {
			//if ( $qty > 0 )
			//{
?>
	<div style="padding-right:50px;width:300px;float:left;height:50px" class="seller_list">
	<?php
				echo pvs_show_user_avatar( $rs->row["user_login"], "login" );?>&nbsp;<span>(<?php
				echo $qty;
?> files)</span></div>
	<?php
			//}
		}
		$n++;

		$rs->movenext();
	}
?>
	</div>
	<div style="clear:both;"></div>
	<p><?php echo ( pvs_paging( $n, $str, $kolvo, $kolvo2, site_url() .
		"/users/", $aletter ) );?></p>
	<?php
} else
{
	echo ( "<p><b>" . pvs_word_lang( "not found" ) . "</b></p>" );
}
?>
</div>
<div style="clear:both;"></div>
