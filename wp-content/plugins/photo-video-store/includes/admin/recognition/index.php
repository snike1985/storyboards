<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_recognition" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

if ( @$_REQUEST["action"] == 'change_clarifai' )
{
	include ( "change_clarifai.php" );
}

if ( @$_REQUEST["action"] == 'change_imagga' )
{
	include ( "change_imagga.php" );
}

if ( isset( $_REQUEST["action"] ) )
{
	//Update settings
	pvs_get_settings();
}
?>


<h1><?php
echo pvs_word_lang( "Image recognition" )
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
echo ( pvs_plugins_admin_url( 'recognition/index.php' ) );
?>&d=1" class="nav-tab <?php
if ( $d == 1 )
{
	echo ( "nav-tab-active" );
}
?>">Clarifai</a>
    <a href="<?php
echo ( pvs_plugins_admin_url( 'recognition/index.php' ) );
?>&d=2" class="nav-tab <?php
if ( $d == 2 )
{
	echo ( "nav-tab-active" );
}
?>">Imagga</a>
</h2>

<br>



<?php
if ( $d == 1 )
{
	include ( "clarifai.php" );
}

if ( $d == 2 )
{
	include ( "imagga.php" );
}
?>







<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>