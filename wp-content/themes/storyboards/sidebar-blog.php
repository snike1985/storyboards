<?php
$sidebar_title = get_field('sidebar_title', 'options');
$sidebar_button = get_field('sidebar_button', 'options');
?>
<div class="right-contact">
	<div class="get-in-touch">

		<?php if($sidebar_title) { echo $sidebar_title; } ?>

		<?php if(!empty($sidebar_button)) { ?>
		<a href="<?= $sidebar_button['url']; ?>" target="<?= $sidebar_button['target']; ?>">
			<div class="bottom-button contact-button">
				<div class="bottom-text">
					<?= $sidebar_button['title']; ?>
				</div>
			</div>
		</a>
		<?php } ?>

	</div>
</div>