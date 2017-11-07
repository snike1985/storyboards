<?php
/*
Template Name: Artists
*/
get_header();
$post_id = get_the_ID();

$artists = get_field('artists', $post_id);

if(!empty($artists)) { ?>

    <section class="main-section">
        <div class="container">

            <h2 class="content-header" style="margin:0 0 35px">
              <?= get_the_title( $post_id ); ?>
            </h2>

            <div class="artistblock newartist">

                <?php foreach ($artists as $row) {
	                $image = get_field('image', 'user_'.$row['ID']);
	                $count_storyboards = get_count_storyboards($row['ID']);
	                if(empty($image)) { continue; }
	            ?>
                <div class="artistcard">
                    <a href="<?= get_author_posts_url($row['ID']); ?>">
                        <img src="<?= $image['url']; ?>" alt="<?= $image['alt']; ?>" title="<?= $image['title']; ?>">
                        <div class="artistname"><?= $row['user_firstname'].' '.$row['user_lastname']; ?></div>
                        <div class="artiststory"><?= $count_storyboards.' '._n( 'storyboard' , 'storyboards' , $count_storyboards ); ?></div>
                    </a>
                </div>
                <?php } ?>

            </div>
        </div>
    </section>

	<?php
}
get_footer();