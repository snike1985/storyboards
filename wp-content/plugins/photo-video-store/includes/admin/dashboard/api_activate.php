<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

$activate_result = (int)@file_get_contents("https://www.cmsaccount.com/members/activate287.php?api_key=" . @$pvs_global_settings["api_key"] . "&api_secret=" . @$pvs_global_settings["api_secret"] . "&site=" . urlencode(site_url()));

pvs_update_setting('activation', pvs_result( $activate_result ) );

if ($activate_result == 0) {
	echo('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . pvs_word_lang("Error! The API key and API secret are incorrect.") . '</div>');
} else {
	echo('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . pvs_word_lang("The license has been successfully activated") . '</div>');
}

pvs_get_settings();
?>
