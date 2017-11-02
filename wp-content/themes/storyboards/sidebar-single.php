<?php
$post_id = get_the_ID();
$args = array(
	'post_type'   => 'post',
	'posts_per_page' => 5,
	'orderby'     => 'date',
	'fields'      => 'ids',
	'post_status' => 'publish',
	'suppress_filters' => false,
	'exclude' => $post_id
);
$posts = get_posts( $args );

$terms = get_terms( 'category', array(
	'hide_empty' => false,
    'orderby' => 'term_order'
) );

if(!empty($posts) || !empty($terms)) { ?>
<div class="right-contact bloger">

    <?php if(!empty($posts)) { ?>
    <div class="articles-blog">
        <div class="recent-articles-header"><?= __('RESENT ARTICLES', 'storyboards'); ?></div>

        <?php foreach ($posts as $id) { ?>
        <div class="recent-articles">
            <a href="<?= get_permalink($id); ?>">
                <?= get_the_post_thumbnail($id,'preview');?>
                <div class="greytext"><?= get_the_title($id); ?></div>
            </a>
        </div>
      <?php } ?>

    </div>
    <?php } ?>

    <?php if(!empty($terms)) { ?>
    <div class="articlesUl">
        <div class="recent-articles-header"><?= __('CATEGORIES', 'storyboards') ?></div>
        <ul>
            <?php foreach ($terms as $term) { if($term->term_id === 1) { continue; } ?>
                <li><a href="<?= get_term_link($term->term_id);?>"><?= $term->name; ?></a></li>
            <?php } ?>
        </ul>
    </div>
    <?php } ?>

</div>
<?php }