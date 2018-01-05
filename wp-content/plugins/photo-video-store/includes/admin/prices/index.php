<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_prices" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

//Photo add
if ( @$_REQUEST["action"] == 'photo_add' )
{
	include ( "photo_add.php" );
}

//Photo change
if ( @$_REQUEST["action"] == 'photo_change' )
{
	include ( "photo_change.php" );
}

//Photo formats
if ( @$_REQUEST["action"] == 'photo_formats' )
{
	include ( "photo_formats_change.php" );
}

//Video add
if ( @$_REQUEST["action"] == 'video_add' )
{
	include ( "video_add.php" );
}

//Video change
if ( @$_REQUEST["action"] == 'video_change' )
{
	include ( "video_change.php" );
}

//Audio add
if ( @$_REQUEST["action"] == 'audio_add' )
{
	include ( "audio_add.php" );
}

//Audio change
if ( @$_REQUEST["action"] == 'audio_change' )
{
	include ( "audio_change.php" );
}

//Vector add
if ( @$_REQUEST["action"] == 'vector_add' )
{
	include ( "vector_add.php" );
}

//Vector change
if ( @$_REQUEST["action"] == 'vector_change' )
{
	include ( "vector_change.php" );
}
?>





<h1><?php
echo pvs_word_lang( "prices" )
?></h1>


<?php
if ( isset( $_GET["d"] ) )
{
	$d = $_GET["d"];
} else
{
	$d = 1;
}
?>





<h2 class="nav-tab-wrapper">
    <a href="<?php
echo ( pvs_plugins_admin_url( 'prices/index.php' ) );
?>&d=1" class="nav-tab <?php
if ( $d == 1 )
{
	echo ( "nav-tab-active" );
}
?>"><?php
echo pvs_word_lang( "photo" )
?></a>
    <a href="<?php
echo ( pvs_plugins_admin_url( 'prices/index.php' ) );
?>&d=2" class="nav-tab <?php
if ( $d == 2 )
{
	echo ( "nav-tab-active" );
}
?>"><?php
echo pvs_word_lang( "video" )
?></a>
    <a href="<?php
echo ( pvs_plugins_admin_url( 'prices/index.php' ) );
?>&d=3" class="nav-tab <?php
if ( $d == 3 )
{
	echo ( "nav-tab-active" );
}
?>"><?php
echo pvs_word_lang( "audio" )
?></a>
    <a href="<?php
echo ( pvs_plugins_admin_url( 'prices/index.php' ) );
?>&d=4" class="nav-tab <?php
if ( $d == 4 )
{
	echo ( "nav-tab-active" );
}
?>"><?php
echo pvs_word_lang( "vector" )
?></a>
</h2>
<br>

<?php
if ( $d == 1 )
{
	include ( "photo.php" );
}

if ( $d == 2 )
{
	include ( "video.php" );
}

if ( $d == 3 )
{
	include ( "audio.php" );
}

if ( $d == 4 )
{
	include ( "vector.php" );
}
?>






<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>