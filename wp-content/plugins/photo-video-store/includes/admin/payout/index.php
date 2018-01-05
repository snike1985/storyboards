<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_payout" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

//Change
if ( @$_REQUEST["action"] == 'change' )
{
	include ( "change.php" );
}

//Change2
if ( @$_REQUEST["action"] == 'change2' )
{
	include ( "change2.php" );
}

//Settings Change
if ( @$_REQUEST["action"] == 'settings_change' )
{
	include ( "settings_change.php" );
}

//Add
if ( @$_REQUEST["action"] == 'add' )
{
	include ( "add.php" );
}



if ( isset( $_REQUEST["action"] ) )
{
	//Update settings
	pvs_get_settings();
}

if ( isset( $_GET["d"] ) )
{
	$d = ( int )$_GET["d"];
} else
{
	$d = 1;
}
?>

<h1><?php
echo pvs_word_lang( "refund" )
?></h1>





<h2 class="nav-tab-wrapper">
    <a href="<?php
echo ( pvs_plugins_admin_url( 'payout/index.php' ) );
?>&d=1" class="nav-tab <?php
if ( $d == 1 )
{
	echo ( "nav-tab-active" );
}
?>"><?php
echo pvs_word_lang( "settings" )
?></a>
    <a href="<?php
echo ( pvs_plugins_admin_url( 'payout/index.php' ) );
?>&d=2" class="nav-tab <?php
if ( $d == 2 )
{
	echo ( "nav-tab-active" );
}
?>"><?php
echo pvs_word_lang( "price" )
?></a>
</h2>
<br>



<?php
if ( $d == 1 )
{
	include ( "settings.php" );
}

if ( $d == 2 )
{
	include ( "price.php" );
}


?>









<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>