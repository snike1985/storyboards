<?php
$contact_id = 14;
$social_links = get_field('social_links', $contact_id);
$social_links_list = '';
if(!empty($social_links)) {
	foreach ( $social_links as $row ) {
		if(is_array($row['show_in'])) {
			if(!in_array('1', $row['show_in']) || empty($row['image'])) {
				continue;
			}
		}else {
			if($row['show_in'] !== '1' || empty($row['image'])) {
				continue;
			}
		}
		$social_links_list .= '<a class="social__item" href="'.$row['url'].'" target="_blank">'.file_get_contents($row['image']['url']).'</a>';
	}
}

$title_social = get_field('title_social', $contact_id);
if($title_social) {
	$title_social = '<strong class="be-friends__title">'.$title_social.'</strong>';
}

$title_form = get_field('title_form', $contact_id);
if($title_form) {
	$title_form = '<strong class="contact-us__title">'.$title_form.'</strong>';
}
if(!is_page(14)){
?>
<div class="contact-us show">
	<?= $title_form.get_field('content_form', $contact_id); ?>
	<div class="contact-us__form">
		<?= do_shortcode('[contact-form-7 id="86" title="Contact"]'); ?>
	</div>
</div>
<?php } ?>
<div class="be-friends">
	<?= $title_social; ?>
	<div class="social">
		<?= $social_links_list; ?>
	</div>
</div>
<?php if(is_front_page()){ ?>
    <div class="instagramm-slider" data-limit="<?= get_field('instagram_count', 2)?>" data-user-id="<?= get_field('instagram_user_id', 2)?>" data-client-id="<?= get_field('instagram_client_id', 2)?>" data-access-token="<?= get_field('instagram_access_token', 2)?>">
        <div class="swiper-container">
            <div class="swiper-wrapper" id="instafeed"></div>
        </div>
    </div>
<?php } ?>