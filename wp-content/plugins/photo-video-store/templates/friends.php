<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

include ( "profile_top.php" );?>

<h1><?php echo pvs_word_lang( "friends" )?></h1>



<?php
$n = 1;
$sql = "select friend1,friend2 from " . PVS_DB_PREFIX .
	"friends where friend1='" . pvs_result( pvs_get_user_login () ) .
	"' order by friend2";
$rs->open( $sql );
if ( ! $rs->eof ) {
	while ( ! $rs->eof ) {
?>
		<div style="margin-right:50px;padding-bottom:20px;width:200px;float:left">
		<?php echo pvs_show_user_avatar( $rs->row["friend2"], "login" )?> [<a href="<?php echo (site_url( ) );?>/friends-remove/?user=<?php echo $rs->row["friend2"] ?>"  onClick="return confirm('<?php echo pvs_word_lang( "delete" )?>?');"><?php echo pvs_word_lang( "delete" )?></a>]
		</div>
		<?php
		$n++;
		$rs->movenext();
	}
} else
{
?>
	<p><b><?php echo pvs_word_lang( "not found" )?></b></p>
	<?php
}
?>



<?php
include ( "profile_bottom.php" );
?>