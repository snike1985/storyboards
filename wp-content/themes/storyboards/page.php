<?php
get_header();

$textpage=get_post();
?>
	<div class="container">
		<h1><?php echo($textpage -> post_title);?></h1>
		<?php echo($textpage -> post_content);?>
	</div>
<?php
get_footer();
?>