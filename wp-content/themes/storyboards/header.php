<?php
$help_title = get_field('help_title', 'options');
$help_button = get_field('help_button', 'options');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Title</title>

    <?php wp_head(); ?>

</head>
<body data-action="<?php echo admin_url( 'admin-ajax.php' );?>" <?php body_class( 'homepage' ); ?>>

    <?php pvs_create_page_elements();?>

    <div class="wrapper">

        <header class="<?= $post->ID === 38 && ! isset( $_GET['search'] ) && get_query_var('pvs_page') !== 'profile' ? 'main' : 'back'; ?>">

            <?php get_template_part('menu'); ?>

            <?php if( ! $post->ID === 38 ) { ?>
            <div class="search-nav">
                <div class="top-search-bar">

                    <form class="search-element" role="search" method="get" action="/index.php">
                        <input name="search" type="text" class="search-field" placeholder="<?= __('Search storyboard', 'storyboards'); ?>">
                        <button type="submit" class="search-button"><img src="<?= get_template_directory_uri(); ?>/assets/images/svg/search.svg" alt=""><span><?= __('SEARCH', 'storyboards'); ?></span></button>
                    </form>

                    <div class="search-option">
                        <div class="option-element active"><a href="#"><?= __('popular', 'storyboards'); ?></a></div>
                        <div class="option-element"><a href="#"><?= __('newest', 'storyboards'); ?></a></div>
                    </div>

                    <div class="search-help">

                        <?php if( $help_title ) { ?>
                          <div class="bottom-text"><?= $help_title; ?></div>
                        <?php } ?>

                        <?php if(!empty( $help_button )) { ?>
                          <a href="<?= $help_button['url']; ?>" target="<?= $help_button['target']; ?>"><div class="bottom-button"><div class="button-text"><?= $help_button['title']; ?></div></div></a>
                        <?php } ?>

                    </div>

                </div>
            </div>
            <?php } ?>

        </header>

        <?php if( is_front_page() || is_author() ) { ?>
        <div class="popup_overlay"></div>
        <div class="popup">
            <div class="closer">
                <img src="<?= get_template_directory_uri(); ?>/assets/images/svg/close.svg" alt="">
            </div>
            <div class="newslider" data-slider="first"></div>

            <div class="slider-nav"></div>
        </div>
        <?php } ?>