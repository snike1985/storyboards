<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_audio" );
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

if ( @$_REQUEST["action"] == 'source_add' )
{
	include ( "source_add.php" );
}

if ( @$_REQUEST["action"] == 'source_delete' )
{
	include ( "source_delete.php" );
}
?>




<h1><?php
echo pvs_word_lang( "audio settings" )
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
echo ( pvs_plugins_admin_url( 'audio/index.php' ) );
?>&d=0" class="nav-tab <?php
if ( $d == 0 )
{
	echo ( "nav-tab-active" );
}
?>"><?php
echo pvs_word_lang( "upload form" )
?></a>
    <a href="<?php
echo ( pvs_plugins_admin_url( 'audio/index.php' ) );
?>&d=1" class="nav-tab <?php
if ( $d == 1 )
{
	echo ( "nav-tab-active" );
}
?>"><?php
echo pvs_word_lang( "track source" )
?></a>
    <a href="<?php
echo ( pvs_plugins_admin_url( 'audio/index.php' ) );
?>&d=2" class="nav-tab <?php
if ( $d == 2 )
{
	echo ( "nav-tab-active" );
}
?>"><?php
echo pvs_word_lang( "track format" )
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
	include ( "source.php" );
}

if ( $d == 2 )
{
	include ( "format.php" );
}
?>











<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>