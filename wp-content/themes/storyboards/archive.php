<?php

get_header(); ?>
<br>
    <section id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

        <?php if ( have_posts() ) : ?>

            <div class="container">
                <header class="page-header">
                <h1 class="page-title">
                    <?php
                        if ( is_category() ) :
                            single_cat_title();

                        elseif ( is_author() ) :
                            /* Queue the first post, that way we know
                             * what author we're dealing with (if that is the case).
                            */
                            the_post();
                            printf( __( 'Author: %s', 'photo-video-store' ), '<span class="vcard">' . get_the_author() . '</span>' );
                            /* Since we called the_post() above, we need to
                             * rewind the loop back to the beginning that way
                             * we can run the loop properly, in full.
                             */
                            rewind_posts();

                        elseif ( is_day() ) :
                            printf( __( 'Day: %s', 'photo-video-store' ), '<span>' . get_the_date() . '</span>' );

                        elseif ( is_month() ) :
                            printf( __( 'Month: %s', 'photo-video-store' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

                        elseif ( is_year() ) :
                            printf( __( 'Year: %s', 'photo-video-store' ), '<span>' . get_the_date( 'Y' ) . '</span>' );
                        elseif ( is_tax( 'pcategory' ) ) :
                            $term = $wp_query->queried_object;
                            printf( $term->name, '<span>' . get_the_date( 'Y' ) . '</span>' );
                        else :
                            _e( 'Archives', 'photo-video-store' );

                        endif;
                    ?>
                </h1>
                <?php
                    // Show an optional term description.
                    $term_description = term_description();
                    if ( ! empty( $term_description ) ) :
                        printf( '<div class="taxonomy-description">%s</div>', $term_description );
                    endif;
                ?>
                </header><!-- .page-header -->
            </div>

            <?php /* Start the Loop */ ?>
            <div class="container">
                <?php while ( have_posts() ) : the_post(); ?>

                    <?php
                        /* Include the Post-Format-specific template for the content.
                         * If you want to override this in a child theme, then include a file
                         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                         */
                        get_template_part( 'content', get_post_format() );
                    ?>

                <?php endwhile; ?>
            </div>

            <div class="container">
                <div class="full-width">

                </div>
            </div>

        <?php else : ?>

            <?php get_template_part( 'content', 'none' ); ?>

        <?php endif; ?>

        </main><!-- #main -->
    </section><!-- #primary -->

<?php get_footer(); ?>
