<?php
/*
Template Name: About
*/
get_header();
$post_id = get_the_ID();

$our_team_title = get_field('our_team_title', $post_id);
$our_team = get_field('our_team', $post_id);
?>

<section class="main-section">
	<div class="container">
		<h2 class="content-header" style="margin:0 0 40px">
			<?= get_the_title($post_id); ?>
		</h2>
		<p class="greytext"><?= get_the_content($post_id); ?></p>

		<?php if(!empty($our_team)) { ?>

		<?php if($our_team_title) { ?>
		<h2 class="content-header" style="margin:70px 0 40px"><?= $our_team_title; ?></h2>
		<?php } ?>

		<div class="artistblock">

			<?php foreach ($our_team as $row) {
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
		<?php } ?>

		<?php get_template_part( '/contents/content', 'contact'); ?>

	</div>
</section>

<?php
get_footer();