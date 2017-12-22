<?php
get_header();

$author = get_query_var( 'author' );

$info = get_the_author_meta('user_description', $author);
$first_name = get_the_author_meta('first_name', $author);
$last_name = get_the_author_meta('last_name', $author);
$twitter = get_the_author_meta('twitter', $author);
$facebook = get_the_author_meta('facebook', $author);
$image = get_field('image', 'user_'.$author);
$count_storyboards = get_count_storyboards($author);

$args = array(
	'posts_per_page' => 8,
	'orderby'     => 'menu_order',
	'fields'      => 'ids',
	'post_status' => 'publish',
	'suppress_filters' => false,
	'post_type'   => 'storyboard',
	'author'      =>  $author,
);

$posts = get_posts( $args );
?>

	<section class="profile">
		<div class="container">
			<div class="artist-profile">

				<?php if(!empty($image)) { ?>
				<div class="artist-photo">
					<img src="<?= $image['url']; ?>" alt="<?= $image['alt']; ?>" title="<?= $image['title']; ?>">
				</div>
				<?php } ?>

				<div class="artist-info">

					<div class="artist-about">

						<h2 class="about">
							About Artist
						</h2>

						<?php if($twitter || $facebook) { ?>
						<div class="social">

							<?php if($twitter) { ?>
							<a href="https://twitter.com/<?= $twitter; ?>">
								<svg width="26px" height="20px" viewBox="0 0 26 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">									<path d="M25.6431373,2.35 C24.7254902,2.75 23.7058824,3 22.6862745,3.15 C23.7568627,2.55 24.572549,1.55 24.9294118,0.35 C23.9098039,0.95 22.8392157,1.35 21.6666667,1.6 C20.6980392,0.6 19.372549,0 17.8941176,0 C15.0392157,0 12.745098,2.25 12.745098,5.05 C12.745098,5.45 12.7960784,5.85 12.8980392,6.2 C8.61568627,6 4.79215686,4 2.24313725,0.9 C1.83529412,1.65 1.58039216,2.55 1.58039216,3.45 C1.58039216,5.2 2.49803922,6.75 3.8745098,7.65 C3.00784314,7.6 2.24313725,7.4 1.52941176,7 C1.52941176,7 1.52941176,7.05 1.52941176,7.05 C1.52941176,9.5 3.31372549,11.55 5.65882353,12 C5.25098039,12.1 4.79215686,12.2 4.28235294,12.2 C3.9254902,12.2 3.61960784,12.15 3.31372549,12.1 C3.97647059,14.1 5.8627451,15.55 8.10588235,15.6 C6.32156863,16.95 4.12941176,17.75 1.68235294,17.75 C1.2745098,17.75 0.866666667,17.75 0.458823529,17.7 C2.80392157,19.2 5.50588235,20 8.41176471,20 C17.8941176,20 23.0941176,12.3 23.0941176,5.6 C23.0941176,5.4 23.0941176,5.15 23.0941176,4.95 C24.0627451,4.25 24.9294118,3.4 25.6431373,2.35 Z" id="Shape"></path>								</svg>
							</a>
							<?php } ?>

							<?php if($facebook) { ?>
							<a href="<?= $facebook; ?>">
								<svg width="11px" height="20px" fill="#111" viewBox="0 0 11 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M10.5875,0 L6.9575,0 C6.9575,0 6.93,0 6.93,0 C3.2725,0 2.805,2.58333333 2.7775,4.86111111 C2.7775,4.88888889 2.7775,4.91666667 2.7775,4.91666667 L2.7775,6.5 L0.275,6.5 C0.11,6.5 0,6.61111111 0,6.77777778 L0,10.6944444 C0,10.8611111 0.11,10.9722222 0.275,10.9722222 L2.7775,10.9722222 L2.7775,19.5555556 C2.7775,19.7222222 2.8875,19.8333333 3.0525,19.8333333 L6.71,19.8333333 C6.875,19.8333333 6.985,19.7222222 6.985,19.5555556 L6.985,10.9722222 L10.5875,10.9722222 C10.7525,10.9722222 10.8625,10.8611111 10.8625,10.6944444 L10.8625,6.77777778 C10.8625,6.61111111 10.7525,6.5 10.5875,6.5 L6.71,6.5 L6.71,4.38888889 L10.5875,4.38888889 C10.7525,4.38888889 10.8625,4.27777778 10.8625,4.11111111 L10.8625,0.277777778 C10.8625,0.111111111 10.7525,0 10.5875,0 Z" id="Shapes"></path></svg>
							</a>
							<?php } ?>

						</div>
						<?php } ?>

					</div>

					<?php if($first_name || $last_name) { ?>
					<div class="profile-name"><?= $first_name.' '.$last_name; ?></div>
					<?php } ?>

					<div class="storyboards-quantity">
						<?= $count_storyboards.' '._n( 'Storyboard' , 'Storyboards' , $count_storyboards ); ?>
					</div>

					<?php if($info) { ?>
					<div class="about-profile"><?= $info; ?></div>
					<?php } ?>

				</div>
			</div>
		</div>
	</section>

<?php if(!empty($posts)) { ?>
	<section class="main-section">
		<div class="container" data-page="1" data-author="<?= $author; ?>">

			<h2 class="content-header" style="margin:0 0 35px">

				<?php if($first_name) {echo $first_name.'\'s';} echo ' '._n( 'Storyboard' , 'Storyboards' , $count_storyboards );?>

			</h2>

			<div class="main-content">

				<?php for ($i = 0; $i < count($posts); $i++) {

					$count_download = get_field('count_download', $posts[$i]);

					if($i === 4){ ?>
                        </div><div class="main-content">
                    <?php } ?>
				<div class="content-element">
					<a href="<?= get_the_post_thumbnail_url( $posts[$i], 'full' ); ?>" class="popup__open" data-popup="image">

						<?= get_the_post_thumbnail( $posts[$i], 'storyboard' ); ?>

						<div class="board">
							<div class="board-info">
								<div class="board-name"><?= get_the_title($posts[$i]); ?></div>

								<?php if($count_download) { ?>
								<div class="board-downloads"><?= $count_download.' '._n( 'download' , 'downloads' , $count_download ); ?></div>
								<?php } ?>

							</div>
							<?php if(!empty($image)) { ?>
							<div class="board-author">
								<img src="<?= $image['url']; ?>" width="30" height="30" alt="<?= $image['alt']; ?>" title="<?= $image['title']; ?>">
							</div>
							<?php } ?>
						</div>
					</a>
				</div>
		<?php } ?>

			</div>

            <?php if($count_storyboards > 8) { ?>
			<div class="content-more" style="margin-top:40px">
				<a href="#">SEE MORE</a>
			</div>
            <?php } ?>

		</div>
	</section>
	<?php } ?>

<?php
get_footer();