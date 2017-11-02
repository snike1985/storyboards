<?php
get_header();

$post_item_category = get_the_terms( $post->ID, 'post_tag' );

$args = array(
	'post_type'   => 'work',
	'posts_per_page' => 4,
	'orderby'     => 'rand',
	'fields'      => 'ids',
	'post_status' => 'publish',
	'suppress_filters' => false,
    'exclude' => $post->ID
);
$posts = get_posts( $args );

$constructor = get_field( 'constructor', $post->ID );
?>

    <!-- site__content -->
    <main class="site__content">

			<?php if ( ! empty( $constructor ) ) { ?>
          <!-- case -->
          <section class="case">

						<?php foreach ( $constructor as $row ) {
							switch ( $row['show_template'] ) {

								case '0': ?>
                    <!-- case__head -->
                    <div class="case__head">

                        <!-- case__info -->
                        <div class="case__info">

													<?php if ( $row['title'] ) { ?>
                              <!-- case__title -->
                              <h1 class="case__title"><?= $row['title']; ?></h1>
                              <!-- /case__title -->
													<?php } ?>

													<?php if ( ! empty( $post_item_category ) ) { ?>
                              <!-- labels -->
                              <div class="labels">
																<?php foreach ( $post_item_category as $rows ) { ?>
                                    <span class="labels__item"><?= $rows->name; ?></span>
																<?php } ?>
                              </div>
                              <!-- /labels -->
													<?php } ?>

                        </div>
                        <!-- /case__info -->

											<?php if ( ! empty( $row['image'] ) ) { ?>
                          <div class="case__preview">
                              <img src="<?= $row['image']['url']; ?>" alt="<?= $row['image']['alt']; ?>"
                                   title="<?= $row['image']['title']; ?>">
                          </div>
											<?php } ?>

                    </div>
                    <!-- /case__head -->
									<?php break; ?>

								<?php case '1':
								if ( $row['content'] ) { ?>
                    <!-- case__content -->
                    <article class="case__content case__content-small">

											<?= $row['content']; ?>

                    </article>
                    <!-- /case__content -->
								<?php }
								break; ?>

							<?php case '2':
								if ( ! empty( $row['image'] ) ) { ?>
                                  <div class="case__img">
                                        <img src="<?= $row['image']['url']; ?>" alt="<?= $row['image']['alt']; ?>"
                                             title="<?= $row['image']['title']; ?>">
                                  </div>

								<?php }
								break; ?>

							<?php case '3': ?>
                  <!-- case__content -->
                  <article class="case__content">

										<?= $row['content']; ?>

										<?php if ( ! empty( $row['gallery'] ) ) { ?>
                        <!-- case__swiper -->
                        <div class="case__swiper">

                            <!-- case__swiper -->
                            <div class="case__slider container">

                                <!-- swiper-wrapper -->
                                <div class="swiper-wrapper">

																	<?php foreach ( $row['gallery'] as $row_2 ) { ?>
                                      <div class="case__item swiper-slide">
                                          <img src="<?= $row_2['url']; ?>" alt="<?= $row_2['alt']; ?>"
                                               title="<?= $row_2['title']; ?>">
                                      </div>
																	<?php } ?>

                                </div>
                                <!-- /swiper-wrapper -->

                            </div>
                            <!-- /case__swiper -->

                            <div class="case__prev">
                                <svg width="35px" height="31px" viewBox="0 0 35 31">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g transform="translate(-637.000000, -3118.000000)" fill="#3F4551">
                                            <g transform="translate(637.000000, 3118.000000)">
                                                <path d="M26.8997883,13.9866839 L-2.84217094e-13,13.9866839 L-2.84217094e-13,17.9571312 L25.8762578,17.9571312 L15.6550927,28.1782963 L18.4626229,30.9858265 L34.0070334,15.4414161 L18.5656173,-2.62900812e-13 L15.7393608,2.82625644 L26.8997883,13.9866839 Z"
                                                      id="arrow-def"
                                                      transform="translate(17.003517, 15.492913) scale(-1, 1) translate(-17.003517, -15.492913) "></path>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <div class="case__pagination"></div>
                            <div class="case__next">
                                <svg width="34px" height="31px" viewBox="0 0 34 31">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g transform="translate(-717.000000, -3118.000000)" fill="#3F4551">
                                            <g transform="translate(637.000000, 3118.000000)">
                                                <path d="M106.859379,13.9751839 L80,13.9751839 L80,17.9668204 L105.876154,17.9668204 L95.6551883,28.1877866 L98.4674777,31.0000759 L113.999962,15.4675914 L98.5323708,-1.42108547e-14 L95.7082827,2.82408809 L106.859379,13.9751839 Z"
                                                      id="arrow-hover"></path>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </div>

                        </div>
                        <!-- /case__swiper -->
										<?php } ?>

                  </article>
                  <!-- /case__content -->
								<?php break; ?>

							<?php case '4': ?>
                  <!-- case__content -->
                  <article class="case__feedback">

										<?php if ( $row['title'] ) { ?>
                        <h2><?= $row['title']; ?></h2>
										<?php } ?>

										<?php if ( ! empty( $row['image'] ) ) { ?>
                        <div class="case__ava">
                            <img src="<?= $row['image']['url']; ?>" alt="<?= $row['image']['alt']; ?>"
                                 title="<?= $row['image']['title']; ?>">
                        </div>
										<?php } ?>

										<?= $row['content']; ?>

										<?php if ( $row['content_2'] ) { ?>
                        <div class="case__client">

													<?= $row['content_2']; ?>

                        </div>
										<?php } ?>

                  </article>
								<?php break; ?>

							<?php case '5': ?>

                              <?php if(!empty($posts)) { ?>
                  <!-- cases -->
                  <article class="cases">

                      <!-- cases__title -->
                      <strong class="cases__title">Other cases</strong>
                      <!-- /cases__title -->

                      <!-- cases__list -->
                      <div class="cases__list swiper-container">

                          <!-- swiper-wrapper -->
                          <div class="swiper-wrapper">
                              <?php foreach ($posts as $row_2) {
	                              $category = get_the_terms($row_2, 'work_cat');
                                  ?>
                              <!-- cases__item -->
                              <a href="<?= get_permalink($row_2); ?>" class="cases__item swiper-slide show">
                                <span class="cases__item-pic">
                                    <?php the_post_thumbnail($row_2); ?>
                                </span>
                                  <!-- cases__item-footer -->
                                  <div class="cases__item-footer">

                                      <!-- cases__item-text -->
                                      <ul class="cases__item-text">
                                          <?php get_the_excerpt($row_2); ?>
                                      </ul>
                                      <!-- /cases__item-text -->

                                      <?php if(!empty($category)) { ?>
                                      <!-- cases__item-data -->
                                      <ul class="cases__item-data">
                                          <?php foreach ($category as $row_3) { ?>
                                          <li><?= $row_3->name; ?></li>
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
                                              <path d="M26.8997883,13.9866839 L-2.84217094e-13,13.9866839 L-2.84217094e-13,17.9571312 L25.8762578,17.9571312 L15.6550927,28.1782963 L18.4626229,30.9858265 L34.0070334,15.4414161 L18.5656173,-2.62900812e-13 L15.7393608,2.82625644 L26.8997883,13.9866839 Z"
                                                    id="arrow-def"
                                                    transform="translate(17.003517, 15.492913) scale(-1, 1) translate(-17.003517, -15.492913) "></path>
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
                                              <path d="M106.859379,13.9751839 L80,13.9751839 L80,17.9668204 L105.876154,17.9668204 L95.6551883,28.1877866 L98.4674777,31.0000759 L113.999962,15.4675914 L98.5323708,-1.42108547e-14 L95.7082827,2.82408809 L106.859379,13.9751839 Z"
                                                    id="arrow-hover"></path>
                                          </g>
                                      </g>
                                  </g>
                              </svg>
                          </a>

                      </div>

                      <a href="<?= get_permalink( 5 ); ?>" class="btn cases__btn"><span>SEE all</span></a>

                  </article>
                  <!-- /cases -->
                                <?php } ?>
								<?php break; ?>


							<?php }
						} ?>

          </section>
          <!-- /case -->
			<?php } ?>

			<?php get_template_part( '/contents/content', 'form-2' ); ?>

    </main>
    <!-- /site__content -->

<?php get_footer();

/*

	<main class="site__content">
		<section class="article">
			<?= $post_image; ?>
			<div class="article__wrap">
				<div class="article__info">
					<?= $post_item_tags; ?>
					<data value="<?= get_the_time('Y-m-d'); ?>"><?= get_the_time('F d, Y'); ?></data>
				</div>
				<div class="article__content">
					<h1><?= get_the_title($post->ID); ?></h1>
					<?php the_content($post->ID); ?>
				</div>
			</div>
            <?php if($next_post_string || $previous_post_string){ ?>
			<nav class="article__pagination show">
				<?= $previous_post_string.$next_post_string; ?>
			</nav>
			<?php } ?>
		</section>
        <?php get_template_part( '/contents/content', 'form'); ?>
	</main>*/