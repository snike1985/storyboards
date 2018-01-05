<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

pvs_show_payment_page( 'header' );

if ( $pvs_global_settings["jvzoo_active"] ) {
?>
<h1>JVZoo langing page</h1>

Place JVZoo products here.
<?php
}

pvs_show_payment_page( 'footer' );
?>