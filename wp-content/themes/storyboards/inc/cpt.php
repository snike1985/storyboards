<?php
add_action('init', 'custom_post_type', 0);

function custom_post_type() {

	$storyboard_labels = array(
		'name' => 'Storyboards',
		'singular_name' => 'Storyboard',
		'menu_name' => 'Storyboards',
		'all_items' => 'All Storyboards',
		'view_item' => 'View Storyboard',
		'add_new_item' => 'Add Storyboard',
		'add_new' => 'Add Storyboard',
		'edit_item' => 'Edit Storyboard',
		'update_item' => 'Update Storyboard',
		'search_items' => 'Search Storyboard'
	);

	$storyboard_args = array(
		'labels' => $storyboard_labels,
		'supports' => array('title','thumbnail','author'),
		'hierarchical' => false,
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_admin_bar' => true,
		'can_export' => true,
		'has_archive' => false,
		'exclude_from_search' => true,
		'publicly_queryable' => true,
		'capability_type' => 'post',
		'menu_icon' => 'dashicons-format-gallery',
		'rewrite' => array(
			'with_front' => true
		)
	);
	register_post_type('storyboard', $storyboard_args);


	$video_labels = array(
		'name' => 'Video',
		'singular_name' => 'Video',
		'menu_name' => 'Video',
		'all_items' => 'All Video',
		'view_item' => 'View Video',
		'add_new_item' => 'Add Video',
		'add_new' => 'Add Video',
		'edit_item' => 'Edit Video',
		'update_item' => 'Update Video',
		'search_items' => 'Search Video'
	);

	$video_args = array(
		'labels' => $video_labels,
		'supports' => array('title','author'),
		'hierarchical' => false,
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_admin_bar' => true,
		'can_export' => true,
		'has_archive' => false,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'capability_type' => 'post',
		'menu_icon' => 'dashicons-video-alt3',
		'rewrite' => array(
			'with_front' => true
		)
	);
	register_post_type('video', $video_args);

}
