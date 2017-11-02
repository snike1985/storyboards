<?php
show_admin_bar( false );
define( 'TEMPLATEPATH', get_template_directory_uri() );
define( 'TEMPLATEINC', TEMPLATEPATH . '/inc' );

require_once( TEMPLATEINC . '/actions.php' );
require_once( TEMPLATEINC . '/cpt.php' );
require_once( TEMPLATEINC . '/shortcode.php' );
require_once( TEMPLATEINC . '/ajax.php' );

