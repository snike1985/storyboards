<?php
$post_id = 11;

$category = get_terms(array(
	'taxonomy' => 'post_tag',
	'hide_empty' => false,
));
$category_string = '';
$active_category = 0;
if(!empty($category)) {
	foreach ($category as $row) {
		$active = '';
		if($row->term_id === get_queried_object()->term_id) {
			$active = ' active';
            $active_category++;
		}
		$category_string .= '<a href="'.get_tag_link($row->term_id).'" class="blog__menu-item'.$active.'" >'.$row->name.'</a>';
	}
}
if($active_category === 0) {
	$active_category = ' active';
} else {
	$active_category = '';
}

$post_string = '';
if ($posts) {
	$flag = 0;
	foreach ($posts as $row) {
		$post_item_category = get_the_terms($row->ID,'post_tag');
		$post_item_tags = '';
		$post_item_class = '';
		if(!empty($post_item_category)) {
			foreach ($post_item_category as $rows) {
				$post_item_tags .= '<li>'.$rows->name.'</li>';
			}
		}
		if($flag === 1) {
			$post_string .= '<div class="blog__list">';
		}
		if($flag === 0) {
			$post_string .= '<div class="blog__first">
                    <a href="'.get_permalink($row->ID).'" class="blog__first-pic">
                        <img src="'.get_the_post_thumbnail_url($row->ID).'" alt="'.get_post_meta($row->ID, '_wp_attachment_image_alt', true).'">
                    </a>
                    <div class="blog__first-wrap">
                        <ul class="blog__first-themes">
                           '.$post_item_tags.'
                        </ul>
                        <data value="'.get_the_time('Y-m-d').'">'.get_the_time('F d, Y').'</data>

                        <strong class="blog__first-title">
                            '.get_the_title($row->ID).'
                        </strong>

                        <p>'.get_the_excerpt($row->ID).'</p>

                        <a href="'.get_permalink($row->ID).'" class="btn"><span>READ ARTICLE</span></a>
                    </div>
                </div>';
		} else {
			$post_string .= '<div class="blog__list-item">
                            <a href="'.get_permalink($row->ID).'" class="blog__list-pic">
                               <img src="'.get_the_post_thumbnail_url($row->ID).'" alt="'.get_post_meta($row->ID, '_wp_attachment_image_alt', true).'">
                            </a>
                            <!-- /blog__list-pic -->
                            <ul class="blog__list-head">
                                '.$post_item_tags.'
                                <li><data value="'.get_the_time('Y-m-d').'">'.get_the_time('F d, Y').'</data></li>
                            </ul>
                            <strong class="blog__list-title">'.get_the_title($row->ID).'</strong>
                            <p>'.get_the_excerpt($row->ID).'</p>
                        </div>';
		}

		$flag++;
	}
	if ($flag > 1 ) {
		$post_string .= '</div>';
	}
}
?>
<main class="site__content">
    <section class="blog">
        <strong class="blog__title"><?= get_the_title($post_id); ?></strong>
        <nav class="blog__menu">
            <a href="<?= get_permalink($post_id); ?>" class="blog__menu-item<?= $active_category; ?>">All</a>
			<?= $category_string; ?>
        </nav>
        <div class="blog__wrap">
		<?= $post_string; ?>
        </div>
    </section>
	<?php get_template_part( '/contents/content', 'form'); ?>
</main>
<span class="circle circle_desktop" style="top: 80vh; right: 73vw"></span>
<span class="circle circle_min circle_mobile" style="top: 469px; left: 44vw"></span>