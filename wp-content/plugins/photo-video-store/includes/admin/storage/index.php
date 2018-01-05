<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_storage" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );
?>


<h1><?php
echo pvs_word_lang( "file storage" )
?></h1>

<?php
if ( isset( $_GET["d"] ) )
{
	$d = ( int )$_GET["d"];
} else
{
	$d = 1;
}
?>


<h2 class="nav-tab-wrapper">
    <a href="<?php
echo ( pvs_plugins_admin_url( 'storage/index.php' ) );
?>&d=1" class="nav-tab <?php
if ( $d == 1 )
{
	echo ( "nav-tab-active" );
}
?>"><?php
echo pvs_word_lang( "stats" )
?></a>

    <a href="<?php
echo ( pvs_plugins_admin_url( 'storage/index.php' ) );
?>&d=2" class="nav-tab <?php
if ( $d == 2 )
{
	echo ( "nav-tab-active" );
}
?>"><?php
echo pvs_word_lang( "local server" )
?></a>

    <a href="<?php
echo ( pvs_plugins_admin_url( 'storage/index.php' ) );
?>&d=3" class="nav-tab <?php
if ( $d == 3 )
{
	echo ( "nav-tab-active" );
}
?>">Rackspace clouds</a>

    <a href="<?php
echo ( pvs_plugins_admin_url( 'storage/index.php' ) );
?>&d=4" class="nav-tab <?php
if ( $d == 4 )
{
	echo ( "nav-tab-active" );
}
?>">Amazon S3</a>

    <a href="<?php
echo ( pvs_plugins_admin_url( 'storage/index.php' ) );
?>&d=6" class="nav-tab <?php
if ( $d == 6 )
{
	echo ( "nav-tab-active" );
}
?>">Backblaze B2</a>

    <a href="<?php
echo ( pvs_plugins_admin_url( 'storage/index.php' ) );
?>&d=5" class="nav-tab <?php
if ( $d == 5 )
{
	echo ( "nav-tab-active" );
}
?>">Cron job</a>
</h2>
<br>

<?php
if ( $d == 1 )
{
	include ( plugin_dir_path( __FILE__ ) . "settings.php" );
}

if ( $d == 2 )
{
	include ( plugin_dir_path( __FILE__ ) . "local.php" );
}

if ( $d == 3 )
{
	include ( plugin_dir_path( __FILE__ ) . "rackspace.php" );
}

if ( $d == 4 )
{
	include ( plugin_dir_path( __FILE__ ) . "amazon.php" );
}

if ( $d == 5 )
{
	include ( plugin_dir_path( __FILE__ ) . "cron.php" );
}

if ( $d == 6 )
{
	include ( plugin_dir_path( __FILE__ ) . "backblaze.php" );
}
?>





<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>