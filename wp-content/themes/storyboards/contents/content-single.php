<?php
get_header();
?>

    <section class="main-section">
        <div class="container">
            <div class="blog-main-page">
                <div class="page-blog">
                    <div class="blog-element">
	                    <?php the_post_thumbnail($post->ID); ?>
                        <div class="blog-info">
                            <div class="blog-data">
                                <img src="<?= get_template_directory_uri(); ?>/assets/images/svg/calendar.svg" alt="">
	                            <?= get_the_date('M d, Y', $post->ID); ?>
                            </div>
                            <div class="blog-author">
                                <img src="<?= get_template_directory_uri(); ?>/assets/images/svg/user_icon.svg" alt="">
	                            <?= get_the_author_meta( 'first_name', $post->post_author).' '.get_the_author_meta( 'last_name', $post->post_author); ?>
                            </div>
                        </div>
                        <h3 class="blog-header" style="font-weight:300;">
	                        <?= get_the_title($post->ID); ?>
                        </h3>
                        <div class="blog-preview greytext">
                            <?= get_the_content($post->ID); ?>
                        </div>
                    </div>
                </div>

                <?php get_sidebar('single'); ?>

            </div>
        </div>
    </section>

<?php get_footer();