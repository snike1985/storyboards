<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_video" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

if ( @$_REQUEST["action"] == 'fields_change' )
{
	include ( "fields_change.php" );
}

if ( @$_REQUEST["action"] == 'format_add' )
{
	include ( "format_add.php" );
}

if ( @$_REQUEST["action"] == 'format_delete' )
{
	include ( "format_delete.php" );
}

if ( @$_REQUEST["action"] == 'frames_add' )
{
	include ( "frames_add.php" );
}

if ( @$_REQUEST["action"] == 'frames_delete' )
{
	include ( "frames_delete.php" );
}

if ( @$_REQUEST["action"] == 'ratio_add' )
{
	include ( "ratio_add.php" );
}

if ( @$_REQUEST["action"] == 'ratio_delete' )
{
	include ( "ratio_delete.php" );
}

if ( @$_REQUEST["action"] == 'rendering_add' )
{
	include ( "rendering_add.php" );
}

if ( @$_REQUEST["action"] == 'rendering_delete' )
{
	include ( "rendering_delete.php" );
}
?>







<h1><?php
echo pvs_word_lang( "video settings" )
?></h1>






<?php
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
echo ( pvs_plugins_admin_url( 'video/index.php' ) );
?>&d=0" class="nav-tab <?php
if ( $d == 0 )
{
	echo ( "nav-tab-active" );
}
?>"><?php
echo pvs_word_lang( "upload form" )
?></a>
    <a href="<?php
echo ( pvs_plugins_admin_url( 'video/index.php' ) );
?>&d=1" class="nav-tab <?php
if ( $d == 1 )
{
	echo ( "nav-tab-active" );
}
?>"><?php
echo pvs_word_lang( "clip format" )
?></a>
    <a href="<?php
echo ( pvs_plugins_admin_url( 'video/index.php' ) );
?>&d=2" class="nav-tab <?php
if ( $d == 2 )
{
	echo ( "nav-tab-active" );
}
?>"><?php
echo pvs_word_lang( "aspect ratio" )
?></a>
    <a href="<?php
echo ( pvs_plugins_admin_url( 'video/index.php' ) );
?>&d=3" class="nav-tab <?php
if ( $d == 3 )
{
	echo ( "nav-tab-active" );
}
?>"><?php
echo pvs_word_lang( "field rendering" )
?></a>
	<a href="<?php
echo ( pvs_plugins_admin_url( 'video/index.php' ) );
?>&d=4" class="nav-tab <?php
if ( $d == 4 )
{
	echo ( "nav-tab-active" );
}
?>"><?php
echo pvs_word_lang( "frames per second" )
?></a>
</h2>
<br>

<?php
if ( $d == 0 )
{
	include ( "fields.php" );
}

if ( $d == 1 )
{
	include ( "format.php" );
}

if ( $d == 2 )
{
	include ( "ratio.php" );
}

if ( $d == 3 )
{
	include ( "rendering.php" );
}

if ( $d == 4 )
{
	include ( "frames.php" );
}
?>














<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>