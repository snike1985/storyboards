<?php
/*
Template Name: About
*/
get_header();
$post_id = 8;

$args = array(
	'post_type'   => 'team',
	'posts_per_page' => -1,
	'orderby'     => 'menu_order',
	'fields'      => 'ids',
	'post_status' => 'publish',
	'suppress_filters' => false
);
$posts = get_posts( $args );

$work = get_field('work', $post_id);
$links = get_field('links', $post_id);
$links_title = get_field('links_title', $post_id);
?>
    <!-- site__content -->
    <main class="site__content">

        <!-- about-us__title -->
        <h1 class="about-us__title"><?= get_the_title($post_id); ?></h1>
        <!-- /about-us__title -->

        <?php if ($posts) { ?>
        <!-- team -->
        <div class="team">

            <div class="team__topic">The Design Squad</div>

            <!-- team__list -->
            <div class="team__list swiper-container">

                <div class="swiper-wrapper">

                    <?php foreach ( $posts as $row ) { ?>
                    <!-- team__item -->
                    <div class="team__item swiper-slide">

                        <!-- team__item-pic -->
                        <div class="team__item-pic show">
                            <img src="<?= get_the_post_thumbnail_url($row); ?>" alt="<?= get_post_meta($row, '_wp_attachment_image_alt', true); ?>">
                        </div>
                        <!-- /team__item-pic -->

                        <!-- team__item-footer -->
                        <div class="team__item-footer">

                            <!-- team__item-name -->
                            <strong class="team__item-name">
                                <?= '<span>'.implode('</span><span>', explode(' ', get_the_title($row))).'</span>'; ?>
                            </strong>
                            <!-- /team__item-name -->

                            <!-- team__item-proffesion -->
                            <div class="team__item-proffesion"><?= get_field('position', $row); ?></div>
                            <!-- /team__item-proffesion -->

                        </div>
                        <!-- /team__item-footer -->
                    </div>
                    <!-- /team__item -->
                    <?php } ?>

                </div>

            </div>
            <!-- /team__list -->

        </div>
        <!-- /team -->
        <?php } ?>

        <?php if(get_the_content(get_the_ID())) { ?>
        <!-- about-us -->
        <section class="about-us">

            <!-- about-us__content -->
            <div class="about-us__content">

                <?php the_content(get_the_ID()); ?>

            </div>
            <!-- /about-us__content -->

        </section>
        <!-- /about-us -->
        <?php } ?>

        <?php if (!empty($links) ) { ?>
        <!-- toolset -->
        <div class="toolset">

            <?php if($links_title) { ?>
            <h2><?= $links_title; ?></h2>
            <?php } ?>

            <!-- toolset__wrap -->
            <div class="toolset__wrap">

                <?php foreach ($links as $row) { ?>
                <!-- toolset__item -->
                <a href="<?= $row['link']; ?>" class="toolset__item"><img src="<?= $row['image']['url']; ?>" title="<?= $row['image']['title']; ?>" alt="<?= $row['image']['alt']; ?>"></a>
                <!-- /toolset__item -->
                <?php } ?>

            </div>
            <!-- /toolset__wrap -->

        </div>
        <!-- /toolset -->
        <?php } ?>

        <?php if (!empty($work) ) { ?>
        <!-- cases -->
        <section class="cases">

            <!-- cases__title -->
            <strong class="cases__title"><?= get_field('title_work', $post_id); ?></strong>
            <!-- /cases__title -->

            <!-- cases__list -->
            <div class="cases__list swiper-container">

                <!-- swiper-wrapper -->
                <div class="swiper-wrapper">

                    <?php foreach ($work as $row) { $work_item_category = get_the_terms($row,'work_cat'); ?>

                    <!-- cases__item -->
                    <a href="<?= get_permalink($row); ?>" class="cases__item swiper-slide show">

                        <span class="cases__item-pic">
                            <img src="<?= get_the_post_thumbnail_url($row); ?>" alt="<?= get_post_meta($row, '_wp_attachment_image_alt', true); ?>">
                        </span>

                        <!-- cases__item-footer -->
                        <div class="cases__item-footer">

                            <!-- cases__item-text -->
                            <ul class="cases__item-text">
                                <?= get_the_excerpt($row); ?>
                            </ul>
                            <!-- /cases__item-text -->

                            <?php if(!empty($work_item_category)) { ?>
                            <!-- cases__item-data -->
                            <ul class="cases__item-data">

                                <?php foreach ($work_item_category as $rows) { ?>
                                <li><?= $rows->name; ?></li>
                                <?php } ?>

                            </ul>
                            <!-- /cases__item-data -->
                            <?php } ?>

                        </div>
                        <!-- /cases__item-footer -->

                    </a>
                    <!-- /cases__item -->

                    <?php } ?>

                </div>
                <!-- /swiper-wrapper -->

            </div>
            <!-- /cases__list -->

            <div class="cases__list-control">

                <a href="#" class="case__slider-prev">
                    <svg width="35px" height="31px" viewBox="0 0 35 31">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g transform="translate(-637.000000, -3118.000000)" fill="#3F4551">
                                <g transform="translate(637.000000, 3118.000000)">
                                    <path d="M26.8997883,13.9866839 L-2.84217094e-13,13.9866839 L-2.84217094e-13,17.9571312 L25.8762578,17.9571312 L15.6550927,28.1782963 L18.4626229,30.9858265 L34.0070334,15.4414161 L18.5656173,-2.62900812e-13 L15.7393608,2.82625644 L26.8997883,13.9866839 Z" id="arrow-def" transform="translate(17.003517, 15.492913) scale(-1, 1) translate(-17.003517, -15.492913) "></path>
                                </g>
                            </g>
                        </g>
                    </svg>
                </a>

                <a href="#" class="case__slider-next">
                    <svg width="34px" height="31px" viewBox="0 0 34 31">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g transform="translate(-717.000000, -3118.000000)" fill="#3F4551">
                                <g transform="translate(637.000000, 3118.000000)">
                                    <path d="M106.859379,13.9751839 L80,13.9751839 L80,17.9668204 L105.876154,17.9668204 L95.6551883,28.1877866 L98.4674777,31.0000759 L113.999962,15.4675914 L98.5323708,-1.42108547e-14 L95.7082827,2.82408809 L106.859379,13.9751839 Z" id="arrow-hover"></path>
                                </g>
                            </g>
                        </g>
                    </svg>
                </a>

            </div>

            <a href="<?= get_permalink(5); ?>" class="btn cases__btn"><span><?= get_field('title_button_work', $post_id); ?></span></a>

        </section>
        <!-- /cases -->
        <?php } ?>

       <?php get_template_part( '/contents/content', 'form-2'); ?>

    </main>
    <!-- /site__content -->

<?php
get_footer();