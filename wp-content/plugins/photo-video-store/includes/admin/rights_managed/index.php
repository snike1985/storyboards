<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_rightsmanaged" );
include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );

if ( @$_REQUEST["action"] == 'price_add' )
{
	include ( "price_add.php" );
}

if ( @$_REQUEST["action"] == 'price_delete' )
{
	include ( "price_delete.php" );
}

if ( @$_REQUEST["action"] == 'collapse' )
{
	include ( "collapse.php" );
}

if ( @$_REQUEST["action"] == 'groups_add' )
{
	include ( "groups_add.php" );
}

if ( @$_REQUEST["action"] == 'groups_delete' )
{
	include ( "groups_delete.php" );
}

if ( @$_REQUEST["action"] == 'step_add' )
{
	include ( "step_add.php" );
}

if ( @$_REQUEST["action"] == 'step_edit' )
{
	include ( "step_edit.php" );
}

if ( @$_REQUEST["action"] == 'step_delete' )
{
	include ( "step_delete.php" );
}

if ( @$_REQUEST["action"] == 'group_add' )
{
	include ( "group_add.php" );
}

if ( @$_REQUEST["action"] == 'option_edit' )
{
	include ( "option_edit.php" );
}

if ( @$_REQUEST["action"] == 'conditions_edit' )
{
	include ( "conditions_edit.php" );
}

if ( @$_REQUEST["action"] == 'groups_content' )
{
	include ( "groups_content.php" );
} else
	if ( @$_REQUEST["action"] == 'price_content' )
	{
		include ( "price_content.php" );
	} else
		if ( @$_REQUEST["action"] == 'content' or @$_REQUEST["action"] == 'step_add' or
			@$_REQUEST["action"] == 'step_edit' or @$_REQUEST["action"] == 'step_delete' or
			@$_REQUEST["action"] == 'group_add' or @$_REQUEST["action"] == 'option_edit' or
			@$_REQUEST["action"] == 'conditions_edit' or @$_REQUEST["action"] == 'collapse' )
		{
			include ( "content.php" );
		} else
		{
?>

	<h1><?php
			echo pvs_word_lang( "rights managed files" )
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
			echo ( pvs_plugins_admin_url( 'rights_managed/index.php' ) );
?>&d=1" class="nav-tab <?php
			if ( $d == 1 )
			{
				echo ( "nav-tab-active" );
			}
?>"><?php
			echo pvs_word_lang( "prices" )
?></a>
		<a href="<?php
			echo ( pvs_plugins_admin_url( 'rights_managed/index.php' ) );
?>&d=2" class="nav-tab <?php
			if ( $d == 2 )
			{
				echo ( "nav-tab-active" );
			}
?>"><?php
			echo pvs_word_lang( "groups" )
?></a>
	</h2>
	<br>
	
	
	<?php
			if ( $d == 1 )
			{
				include ( "prices.php" );
			}
?>
	<?php
			if ( $d == 2 )
			{
				include ( "groups.php" );
			}
?>

	<?php
		}
		include ( plugin_dir_path( __FILE__ ) . "../includes/header.php" );
?>