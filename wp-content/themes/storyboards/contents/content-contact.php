<?php
$contact_id = 6;

$contact_info_title = get_field('contact_info_title', $contact_id);
$contact_info = get_field('contact_info', $contact_id);
?>
<h2 class="content-header" style="margin:0 0 35px">
    <?= get_the_title($contact_id); ?>
</h2>
<div class="main-contact">

    <?= do_shortcode('[gravityform id="1" title="false" description="false" ajax="true"]'); ?>

    <?php if(!empty($contact_info)) { ?>
    <div class="contact-adress">

        <?php if($contact_info_title){ ?>
        <div class="contact-form-header"><?= $contact_info_title; ?></div>
        <?php } ?>

        <?php foreach ($contact_info as $row) {
            $text = '';
            switch ($row['show']) {
              case 'text':
                  if(!$row['text']) { continue; }
                  $text = $row['text'];
              break;
              case 'link':
	              if(empty($row['link'])) { continue; }
	              $text = '<a href="'.$row['link']['url'].'" target="'.$row['link']['target'].'">'.$row['link']['title'].'</a>';
            }
            ?>
        <div class="contact-info">

            <?php if(!empty( $row['image']) ) { ?>
            <img src="<?= $row['image']['url']; ?>" alt="<?= $row['image']['alt']; ?>" title="<?= $row['image']['title']; ?>">
            <?php } ?>

          <?= $text; ?>
        </div>
        <?php } ?>

    </div>
    <?php } ?>

</div>