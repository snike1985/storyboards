<?php
/*
Template Name: Home
*/
get_header();

$post_id = 124;
$about_id = 103;

$hero_back = get_the_post_thumbnail_url( $post_id );
$hero_images = get_field('hero_images', $post_id);
$hero_title = get_field('hero_title', $post_id);
$storyboards_template = get_field('storyboards_template', $post_id);
$team_title = get_field('team_title', $post_id);
$our_team = get_field('our_team', $about_id);
$hero_backs = array();

if( $hero_back ) {
	$hero_backs[] = $hero_back;
}

if( ! empty( $hero_images ) ) {
    foreach ( $hero_images as $row ) {
        if( ! $row['image'] ) { continue; }
	    $hero_backs[] = $row['image']['url'];
    }
}
$count_backs = count($hero_backs);

?>
    <section class="head-back" style="<?= $count_backs ? 'background-image: url(' . $hero_backs[random_int(0, $count_backs - 1)] . ')': ''; ?>">

		<div class="overlay"></div>


			<div class="main-header">
				<?= $hero_title; ?>
			</div>

		<form class="search-element" role="search" method="get" action="<?= get_site_url(); ?>/index.php">
			<input name="search" class="search-field" type="text" placeholder="<?= __('Search storyboards', 'storyboards'); ?>">
			<button type="submit" class="search-button"><img src="<?= get_template_directory_uri(); ?>/assets/images/svg/search.svg" alt="search"><span><?= __('SEARCH', 'storyboards'); ?></span></button>
		</form>

		<div class="contactUsBtn">
			<a href="<?= get_permalink(6); ?>">
				<img src="<?= get_template_directory_uri(); ?>/assets/images/svg/mail_icon.svg" alt="contact">
				<div class="contactUsBtn-text"><?= __('CONTACT US', 'storyboards'); ?></div>
			</a>
		</div>

	</section>

	<?php if( ! empty( $storyboards_template ) ) { ?>

		<section class="most-downloads">
			<div class="container">

				<?php if( $storyboards_template[0]['title'] ) { ?>
					<h2 class="content-header">
						<?= $storyboards_template[0]['title']; ?>
					</h2>
				<?php } ?>

				<?php if( $storyboards_template[0]['url'] ) { ?>
				<div class="content-more">
					<a href="<?= $storyboards_template[0]['url']; ?>"><?= __('SEE MORE', 'storyboards'); ?></a>
				</div>
				<?php } ?>

				<?php if( ! empty( $storyboards_template[0]['storyboards'] ) ) {
					$counter = 0; ?>
				<div class="main-content">

					<?php foreach ( $storyboards_template[0]['storyboards'] as $row ) {
						$post_author_id = get_post_field( 'post_author', $row['storyboard'] );
						$count_download = get_field('count_download', $row['storyboard'] );
						$gallery = get_field('gallery', $row['storyboard'] );
						$gallery_string = array();
						if( ! empty( $gallery ) ) {

						    foreach ($gallery as $row_2) {
							    $gallery_string[] =$row_2['sizes']['storyboard'];
                            }

							$gallery_string = '["' . implode('","', $gallery_string) . '"]';

                        }

						if($counter === 4) { ?>
							</div>
							<div class="main-content">
						<?php } ?>

						<div class="content-element" data-gallery='<?= $gallery_string ? $gallery_string : ''; ?>'>
							<a href="<?= get_permalink( $row['storyboard'] ); ?>">
								<?= get_the_post_thumbnail( $row['storyboard'], 'storyboard' ); ?>
								<div class="board">

									<div class="board-info">
										<div class="board-name"><?= get_the_title(  $row['storyboard'] ); ?></div>
										<div class="board-downloads"><?= $count_download.' '._n( 'download' , 'downloads' , $count_download ); ?></div>
									</div>

									<div class="board-author">
									    <?= get_avatar( $post_author_id, 30 ); ?>
									</div>

								</div>
							</a>
						</div>

					<?php $counter++; } ?>

				</div>
				<?php } ?>
			</div>
		</section>

		<?php if( $storyboards_template[1] ) { ?>
			<section class="recent-downloads">
			<div class="container">

				<?php if( $storyboards_template[1]['title'] ) { ?>
					<h2 class="content-header">
						<?= $storyboards_template[1]['title']; ?>
					</h2>
				<?php } ?>

				<?php if( $storyboards_template[1]['url'] ) { ?>
					<div class="content-more">
						<a href="<?= $storyboards_template[1]['url']; ?>"><?= __('SEE MORE', 'storyboards'); ?></a>
					</div>
				<?php } ?>

				<?php if( ! empty( $storyboards_template[1]['storyboards'] ) ) {
					$counter = 0; ?>
					<div class="main-content">

					<?php foreach ( $storyboards_template[1]['storyboards'] as $row ) {
						$post_author_id = get_post_field( 'post_author', $row['storyboard'] );
						$count_download = get_field('count_download', $row['storyboard'] );
                        $gallery = get_field('gallery', $row['storyboard'] );
                        $gallery_string = array();
                        if( ! empty( $gallery ) ) {

                          foreach ($gallery as $row_2) {
                            $gallery_string[] =$row_2['sizes']['storyboard'];
                          }

                          $gallery_string = '["' . implode('","', $gallery_string) . '"]';

                        }

						if($counter === 4) {?>
							</div>
							<div class="main-content">
						<?php } ?>

						<div class="content-element" data-gallery='<?= $gallery_string ? $gallery_string : ''; ?>'>
							<a href="<?= get_permalink( $row['storyboard'] ); ?>">
								<?= get_the_post_thumbnail( $row['storyboard'], 'storyboard' ); ?>
								<div class="board">
									<div class="board-info">
										<div class="board-name"><?= get_the_title(  $row['storyboard'] ); ?></div>
										<div class="board-downloads"><?= $count_download.' '._n( 'download' , 'downloads' , $count_download ); ?></div>
									</div>

									<div class="board-author">
									    <?= get_avatar($post_author_id, 30); ?>
									</div>

								</div>
							</a>
						</div>

						<?php $counter++; } ?>

					</div>
				<?php } ?>

			</div>
		</section>
		<?php } ?>

	<?php } ?>

    <?php if( ! empty( $our_team ) ) { ?>
	<section class="artists">
		<div class="container">
			<h2 class="content-header"><?= $team_title; ?></h2>
			<div class="content-more">
				<a href="<?= get_permalink( 112 ); ?>"><?= __('SEE MORE', 'storyboards'); ?></a>
			</div>

			<div class="artistblock">
			<?php foreach ($our_team as $row) {
				$count_storyboards = get_count_storyboards($row['ID']);
			?>
				<div class="artistcard">
					<a href="<?= get_author_posts_url($row['ID']); ?>">
						<?= get_avatar($row['ID'], 150); ?>
						<div class="artistname"><?= $row['user_firstname'].' '.$row['user_lastname']; ?></div>
						<div class="artiststory"><?= $count_storyboards.' '._n( 'storyboard' , 'storyboards' , $count_storyboards ); ?></div>
					</a>
				</div>
			<?php } ?>
			</div>

		</div>
	</section>
    <?php } ?>

<?php
get_footer();