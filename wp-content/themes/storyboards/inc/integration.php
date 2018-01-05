<?php

add_theme_support( 'automatic-feed-links' );

if ( defined( 'PVS_NAME' ) ) {
	//Rewrite rules
	add_action( 'after_switch_theme', 'pvs_rewrite_rules');

	//Include template file
	add_filter('template_include', 'pvs_template_include');

	//Box categories
	pvs_box_categories();

	//Box prints
	pvs_box_prints();

	//Box site info
	pvs_box_site_info();

	//Box languages
	pvs_box_languages();

	//Box stats
	pvs_box_stats();

	//Box shopping cart
	pvs_box_shopping_cart();


}