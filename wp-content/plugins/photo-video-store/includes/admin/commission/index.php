<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "orders_commission" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

$payment_colors = array(
		"#d83838",
		"#5e9de4",
		"#fd7405",
		"#f7e40d",
		"#30b716",
		"#4dc717",
		"#77480b",
		"#b80cc7",
		"#22aa9f",
		"#f4a445",
		"56b5d8",
		"#d83838",
		"#5e9de4",
		"#fd7405",
		"#f7e40d",
		"#30b716",
		"#4dc717",
		"#77480b",
		"#b80cc7",
		"#22aa9f",
		"#f4a445",
		"56b5d8" );
		
		
//Refund send
if ( @$_REQUEST["action"] == 'refund_send' )
{
	include ( "refund_send.php" );
}

//Refund delete
if ( @$_REQUEST["action"] == 'refund_delete' )
{
	include ( "refund_delete.php" );
	$_GET["d"] = 2;
}

//Commission delete
if ( @$_REQUEST["action"] == 'commission_delete' )
{
	include ( "commission_delete.php" );
}
?>





<h1><?php echo pvs_word_lang( "commission manager" )?>:</h1>


<?php
if ( isset( $_GET["d"] ) ) {
	$d = $_GET["d"];
} else
{
	$d = 1;
}
?>


<h2 class="nav-tab-wrapper">

<a href=<?php echo(pvs_plugins_admin_url('commission/index.php'));?>&d=1" class="nav-tab <?php
if ( $d == 1 )
{
	echo ( "nav-tab-active" );
}
?>"><?php echo pvs_word_lang( "commission" )?></a>
<a href="<?php echo(pvs_plugins_admin_url('commission/index.php'));?>&d=2" class="nav-tab <?php
if ( $d == 2 )
{
	echo ( "nav-tab-active" );
}
?>"><?php echo pvs_word_lang( "refund" )?></a>
<a href="<?php echo(pvs_plugins_admin_url('commission/index.php'));?>&d=3" class="nav-tab <?php
if ( $d == 3 )
{
	echo ( "nav-tab-active" );
}
?>"><?php echo pvs_word_lang( "users earnings" )?></a>


</h2>
<br>

<?php
if ( $d == 1 ) {
	include ( "commission.php" );
}

if ( $d == 2 ) {
	include ( "refund.php" );
}

if ( $d == 3 ) {
	if ( @$_REQUEST["action"] == 'payout' ) {
		include ( "payout.php" );
	} else {
		include ( "balance.php" );
	}
}
?>









<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>