<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_stockapi" );

if ( @$_REQUEST["action"] == 'change_settings' )
{
	include ( "settings_change.php" );
}

if ( @$_REQUEST["action"] == 'change_123rf' )
{
	include ( "123rf_change.php" );
}

if ( @$_REQUEST["action"] == 'change_bigstockphoto' )
{
	include ( "bigstockphoto_change.php" );
}

if ( @$_REQUEST["action"] == 'bigstockphoto_categories' )
{
	include ( "bigstockphoto_categories.php" );
}

if ( @$_REQUEST["action"] == 'change_depositphotos' )
{
	include ( "depositphotos_change.php" );
}

if ( @$_REQUEST["action"] == 'depositphotos_categories' )
{
	include ( "depositphotos_categories.php" );
}

if ( @$_REQUEST["action"] == 'change_fotolia' )
{
	include ( "fotolia_change.php" );
}

if ( @$_REQUEST["action"] == 'fotolia_categories' )
{
	include ( "fotolia_categories.php" );
}

if ( @$_REQUEST["action"] == 'change_istockphoto' )
{
	include ( "istockphoto_change.php" );
}

if ( @$_REQUEST["action"] == 'change_pixabay' )
{
	include ( "pixabay_change.php" );
}

if ( @$_REQUEST["action"] == 'change_shutterstock' )
{
	include ( "shutterstock_change.php" );
}

if ( @$_REQUEST["action"] == 'shutterstock_categories' )
{
	include ( "shutterstock_categories.php" );
}

if ( isset( $_REQUEST["action"] ) )
{
	//Update settings
	pvs_get_settings();
}

include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );
?>



<h1><?php
echo pvs_word_lang( "Stock API" )
?></h1>

<?php
if ( isset( $_GET["d"] ) )
{
	$d = $_GET["d"];
} else
{
	$d = 0;
}
?>








<h2 class="nav-tab-wrapper">
<a href="<?php
echo ( pvs_plugins_admin_url( 'stock_api/index.php' ) );
?>&d=0" class="nav-tab <?php
if ( $d == 0 )
{
	echo ( "nav-tab-active" );
}
?>"><?php
echo pvs_word_lang( "settings" )
?></a>
    <a href="<?php
echo ( pvs_plugins_admin_url( 'stock_api/index.php' ) );
?>&d=1" class="nav-tab <?php
if ( $d == 1 )
{
	echo ( "nav-tab-active" );
}
?>">Getty/iStock</a>
    <a href="<?php
echo ( pvs_plugins_admin_url( 'stock_api/index.php' ) );
?>&d=2" class="nav-tab <?php
if ( $d == 2 )
{
	echo ( "nav-tab-active" );
}
?>">Shutterstock</a>
    <a href="<?php
echo ( pvs_plugins_admin_url( 'stock_api/index.php' ) );
?>&d=3" class="nav-tab <?php
if ( $d == 3 )
{
	echo ( "nav-tab-active" );
}
?>">Fotolia</a>
    <a href="<?php
echo ( pvs_plugins_admin_url( 'stock_api/index.php' ) );
?>&d=4" class="nav-tab <?php
if ( $d == 4 )
{
	echo ( "nav-tab-active" );
}
?>">Depositphotos</a>
	<a href="<?php
echo ( pvs_plugins_admin_url( 'stock_api/index.php' ) );
?>&d=5" class="nav-tab <?php
if ( $d == 5 )
{
	echo ( "nav-tab-active" );
}
?>">123rf</a>
    <a href="<?php
echo ( pvs_plugins_admin_url( 'stock_api/index.php' ) );
?>&d=6" class="nav-tab <?php
if ( $d == 6 )
{
	echo ( "nav-tab-active" );
}
?>">Bigstockphoto</a>
    <a href="<?php
echo ( pvs_plugins_admin_url( 'stock_api/index.php' ) );
?>&d=7" class="nav-tab <?php
if ( $d == 7 )
{
	echo ( "nav-tab-active" );
}
?>">Pixabay</a>
</h2>

<br>

<?php
if ( $d == 0 )
{
	include ( "settings.php" );
}

if ( $d == 1 )
{
	include ( "istockphoto.php" );
}

if ( $d == 2 )
{
	include ( "shutterstock.php" );
}

if ( $d == 3 )
{
	include ( "fotolia.php" );
}

if ( $d == 4 )
{
	include ( "depositphotos.php" );
}

if ( $d == 5 )
{
	include ( "123rf.php" );
}

if ( $d == 6 )
{
	include ( "bigstockphoto.php" );
}

if ( $d == 7 )
{
	include ( "pixabay.php" );
}
?>






<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>