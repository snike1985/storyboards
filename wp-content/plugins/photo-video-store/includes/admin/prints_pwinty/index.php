<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "prints_pwinty" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

if ( @$_REQUEST["action"] == 'change' )
{
	include ( "change.php" );
}

if ( @$_REQUEST["action"] == 'change_prints' )
{
	include ( "change_prints.php" );
}

if ( @$_REQUEST["action"] == 'send_to_pwinty' )
{
	include ( "send_to_pwinty.php" );
}

if ( @$_REQUEST["action"] == 'send' )
{
	include ( "send.php" );
}
?>




<h1><?php
echo pvs_word_lang( "pwinty prints service" )
?></h1>


<?php
if ( isset( $_REQUEST["d"] ) )
{
	$d = ( int )$_REQUEST["d"];
} else
{
	$d = 1;
}
?>






<h2 class="nav-tab-wrapper">
    <a href="<?php
echo ( pvs_plugins_admin_url( 'prints_pwinty/index.php' ) );
?>&d=1" class="nav-tab <?php
if ( $d == 1 )
{
	echo ( "nav-tab-active" );
}
?>"><?php
echo pvs_word_lang( "settings" )
?></a>
    <a href="<?php
echo ( pvs_plugins_admin_url( 'prints_pwinty/index.php' ) );
?>&d=2" class="nav-tab <?php
if ( $d == 2 )
{
	echo ( "nav-tab-active" );
}
?>"><?php
echo pvs_word_lang( "orders" )
?></a>
    <a href="<?php
echo ( pvs_plugins_admin_url( 'prints_pwinty/index.php' ) );
?>&d=3" class="nav-tab <?php
if ( $d == 3 )
{
	echo ( "nav-tab-active" );
}
?>"><?php
echo pvs_word_lang( "Cron" )
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
	include ( "order.php" );
}

if ( $d == 3 )
{
	include ( "cron.php" );
}
?>










<?php
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );
?>