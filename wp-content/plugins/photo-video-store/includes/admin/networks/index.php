<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "settings_networks" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

if ( @$_REQUEST["action"] == 'change' )
{
	include ( "change.php" );
}
?>

<h1>Social Networks QAuth</h1>


<?php
$d = 1;
if ( isset( $_GET["d"] ) ) {
	$d = $_GET["d"];
}
?>

<h2 class="nav-tab-wrapper">
<a href="<?php echo(pvs_plugins_admin_url('networks/index.php'));?>&d=1" class="nav-tab <?php
if ( $d == 1 )
{
	echo ( "nav-tab-active" );
}
?>">Facebook</a>
<a href="<?php echo(pvs_plugins_admin_url('networks/index.php'));?>&d=2" class="nav-tab <?php
if ( $d == 2 )
{
	echo ( "nav-tab-active" );
}
?>">Twitter</a>
<a href="<?php echo(pvs_plugins_admin_url('networks/index.php'));?>&d=4" class="nav-tab <?php
if ( $d == 4 )
{
	echo ( "nav-tab-active" );
}
?>">Instagram</a>
<a href="<?php echo(pvs_plugins_admin_url('networks/index.php'));?>&d=3" class="nav-tab <?php
if ( $d == 3 )
{
	echo ( "nav-tab-active" );
}
?>">Vkontakte</a>
<a href="<?php echo(pvs_plugins_admin_url('networks/index.php'));?>&d=5" class="nav-tab <?php
if ( $d == 5 )
{
	echo ( "nav-tab-active" );
}
?>">Google</a>
<a href="<?php echo(pvs_plugins_admin_url('networks/index.php'));?>&d=6" class="nav-tab <?php
if ( $d == 6 )
{
	echo ( "nav-tab-active" );
}
?>">Yandex</a>
    	</h2>
<br>


<?php
if ( $d == 1 ) {
	include ( "facebook.php" );
}

if ( $d == 2 ) {
	include ( "twitter.php" );
}

if ( $d == 4 ) {
	include ( "instagram.php" );
}

if ( $d == 3 ) {
	include ( "vk.php" );
}

if ( $d == 5 ) {
	include ( "google.php" );
}

if ( $d == 6 ) {
	include ( "yandex.php" );
}
?>


<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/footer.php" );
?>