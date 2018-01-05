<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "settings_signup" );

pvs_update_setting('signup_terms', ( int )$_POST["signup_terms"]);

?>