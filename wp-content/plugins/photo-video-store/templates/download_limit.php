<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

include ( "profile_top.php" );?>
<h1><?php echo pvs_word_lang( "downloads" )?></h1>

<div class="alert"><?php echo pvs_word_lang( "daily limit error" )?> <b>(<?php echo $pvs_global_settings["daily_download_limit"] ?>)</b></div>











<?php
include ( "profile_bottom.php" );
?>