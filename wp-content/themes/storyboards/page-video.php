<?php
/*
Template Name: Video
*/
get_header();
$post_id = get_the_ID();

$args = array(
	'post_type'   => 'video',
	'posts_per_page' => 24,
	'orderby'     => 'menu_order',
	'fields'      => 'ids',
	'post_status' => 'publish',
	'suppress_filters' => false
);
$posts = get_posts( $args );
?>

    <section class="main-section">
        <div class="container">

            <h2 class="content-header" style="margin:0 0 35px"><?= get_the_title( $post_id ); ?></h2>

            <h2 class="content-header" style="margin:0 0 35px"><?= __('Search Results', 'storyboards'); ?></h2>

            <?php if( ! empty( $posts ) ) {
                $counter = 0; ?>
            <div class="main-content">
                <?php foreach ($posts as $post) {
	                $post_author_id = get_post_field( 'post_author', $post );
	                $iframe = get_field('video');
	                if( ! $iframe ) { continue; }
	                preg_match('/src="(.+?)"/', $iframe, $matches);
	                $src = $matches[1];
	                if(strripos($src, 'vimeo.com')) {
                      $url = "http://vimeo.com/api/oembed.xml?url=".$src;
                      $vimeo = simplexml_load_string(curl_get($url));
                      $image_url = $vimeo->thumbnail_url;
                    } else {
                      preg_match('/(http(s|):|)\/\/(www\.|)yout(.*?)\/(embed\/|watch.*?v=|)([a-z_A-Z0-9\-]{11})/i', $src, $results);
                      $image_url = 'http://i1.ytimg.com/vi/' . $results[6] . '/mqdefault.jpg';
                    }

	                if($counter%4 == 0 && $counter > 0 ) {
                        echo '</div><div class="main-content">';
                    }
                    ?>
                <div class="content-element">
                    <a href="#" class="popup__open" data-popup="video" data-iframe="<?= $src; ?>">
                       <img src="<?= $image_url; ?>" alt="">
                        <div class="board">
                            <div class="board-info">
                                <div class="board-name"><?= get_the_title( $post ); ?></div>
                                <div class="board-downloads"></div>
                            </div>
                            <div class="board-author">
                                <?= get_avatar($post_author_id, 30); ?>
                            </div>
                        </div>
                    </a>
                </div>
                <?php $counter++; } ?>
            </div>

            <!--<div class="content-more" style="margin-top:40px">
                <a href="searchresult.html">SEE MORE</a>
            </div>-->

            <?php } ?>

        </div>

    </section>

<?php
get_footer();