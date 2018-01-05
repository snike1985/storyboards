<?php
get_header();

$pagination = get_the_posts_pagination( array(
	'mid_size' => 2,
	'show_all'     => false,
	'prev_next'    => false,
	'screen_reader_text' => ' '
) );

?>

<section class="main-section">
	<div class="container">
		<div class="blog-main-page">
			<div class="page-blog">

				<?php while (have_posts()) : the_post(); ?>
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
						<h3 class="blog-header">
							<?= get_the_title($post->ID); ?>
						</h3>
						<div class="blog-preview greytext">
							<?= get_the_excerpt($post->ID); ?>
						</div>
						<div class="bottom-button">
							<a href="<?= get_permalink($post->ID); ?>"><div class="button-text"><?= __('READ ARTICLE', 'storyboards'); ?></div></a>
						</div>
					</div>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>

				<?= $pagination; ?>
			</div>

			<?php get_sidebar('blog'); ?>

		</div>
	</div>
</section>
<?php
get_footer();
