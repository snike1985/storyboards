<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_ffmpeg" );
$section = "ffmpeg";

include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

if ( @$_REQUEST["action"] == 'change' )
{
	include ( "change.php" );
}

if ( @$_REQUEST["action"] == 'change_sox' )
{
	include ( "change_sox.php" );
}

if ( @$_REQUEST["action"] == 'sox_delete' )
{
	include ( "sox_delete.php" );
}

if ( @$_REQUEST["action"] == 'generate' )
{
	include ( "generate.php" );
}

if ( @$_REQUEST["action"] == 'generate_sox' )
{
	include ( "generate_sox.php" );
}

if ( @$_REQUEST["action"] == 'enable_cron' )
{
	include ( "enable_cron.php" );
}

if ( @$_REQUEST["action"] == 'delete' )
{
	include ( "delete.php" );
}

if ( isset( $_REQUEST["action"] ) )
{
	//Update settings
	pvs_get_settings();
}

if ( isset( $_REQUEST["d"] ) )
{
	$d = ( int )$_REQUEST["d"];
} else
{
	$d = 0;
}
?>


<h2 class="nav-tab-wrapper">
	<a href="<?php
echo ( pvs_plugins_admin_url( 'ffmpeg/index.php' ) );
?>&d=0" class="nav-tab <?php
if ( $d == 0 )
{
	echo ( "nav-tab-active" );
}
?>">FFMPEG <?php
echo pvs_word_lang( "video" )
?></a>
    <a href="<?php
echo ( pvs_plugins_admin_url( 'ffmpeg/index.php' ) );
?>&d=1" class="nav-tab <?php
if ( $d == 1 )
{
	echo ( "nav-tab-active" );
}
?>">Sox <?php
echo pvs_word_lang( "audio" )
?></a>
    <a href="<?php
echo ( pvs_plugins_admin_url( 'ffmpeg/index.php' ) );
?>&d=2" class="nav-tab <?php
if ( $d == 2 )
{
	echo ( "nav-tab-active" );
}
?>">FFMPEG <?php
echo pvs_word_lang( "Queue" )
?></a>
</h2>
<br>


<?php
if ( $d == 0 )
{
	include ( "ffmpeg.php" );
}

if ( $d == 1 )
{
	include ( "sox.php" );
}

if ( $d == 2 )
{
	include ( "ffmpeg_cron.php" );
}
?>







<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>