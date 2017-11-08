<?php
add_action('wp_ajax_image', 'image_ajax');
add_action('wp_ajax_nopriv_ima  ge', 'image_ajax');
function image_ajax() {
	$page = $_GET['page']+1;
	$author = $_GET['author'];

	$args = array(
		'post_type'      => 'storyboard',
		'paged' => $page,
		'posts_per_page' => 8,
		'orderby'        => 'menu_order',
		'post_status'    => 'publish',
		'fields'         => 'ids',
		'suppress_filters' => 0,
		'author'      =>  $author
	);

	$query = new WP_Query();
	$posts = $query->query($args);
	$items = '';
	foreach ($posts as $post) {
		$items .= '{"href":"'.get_the_post_thumbnail_url($post, 'full').'", "img":"'.get_the_post_thumbnail_url($post).'", "board-name":"'.get_the_title($post).'", "board-downloads":"'.get_field('count_download', $post).'", "author":"'.get_field('image', 'user_'.get_post_field( 'post_author', $post ))['url'].'"}, ';
	}
	$items = substr($items,0, -2);

	if($query->max_num_pages > $page) {
		$has_items = 1;
	} else {
		$has_items = 0;
	}
	echo '{"items": ['.$items.'], "has_items": '.$has_items.'}';
	exit;
}
