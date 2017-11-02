<?php
$contact_id = 14;

$title_form = get_field('title_form_3', $contact_id);
$content_form = get_field('content_form_3', $contact_id);
?>
    <!-- contact-us -->
    <div class="contact-us show">

        <?php if($title_form) { ?>
        <!-- contact-us__title -->
        <strong class="contact-us__title">
            <?= $title_form; ?>
        </strong>
        <!-- /contact-us__title -->
        <?php } ?>

        <?= $content_form; ?>

        <!-- contact-us__form -->
        <div class="contact-us__form">
	        <?= do_shortcode('[contact-form-7 id="330" title="Contact_3"]'); ?>
        </div>
        <!-- /contact-us__form -->

    </div>
    <!-- /contact-us -->
