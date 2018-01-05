<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

pvs_update_setting('api_key', pvs_result( $_POST[ 'api_key' ] ) );
pvs_update_setting('api_secret', pvs_result( $_POST[ 'api_secret' ] ) );

pvs_get_settings();
?>
