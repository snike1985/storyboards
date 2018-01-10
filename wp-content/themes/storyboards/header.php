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
    <script>
         cart_word='<?php echo(pvs_word_lang("Cart"));?>';
         cart_word_checkout='<?php echo(pvs_word_lang("Checkout"));?>';
         cart_word_view='<?php echo(pvs_word_lang("View Cart"));?>';
         cart_word_subtotal='<?php echo(pvs_word_lang("Subtotal"));?>';
         cart_word_total='<?php echo(pvs_word_lang("Total"));?>';
         cart_word_qty='<?php echo(pvs_word_lang("Quantity"));?>';
         cart_word_item='<?php echo(pvs_word_lang("Item"));?>';
         cart_word_delete='<?php echo(pvs_word_lang("Delete"));?>';
         cart_currency1='<?php echo(pvs_currency(1));?>';
         cart_currency2='<?php echo(pvs_currency(2));?>';
         cart_site_root='<?php echo (site_url( ) );?>/';
    </script>
</head>
<body data-action="<?php echo admin_url( 'admin-ajax.php' );?>" <?php body_class( 'homepage' ); ?>>

    <?php pvs_create_page_elements(); //var_dump(get_query_var('pvs_page'));?>

    <div class="wrapper">

        <header class="header <?= $post->ID === 38 &&
        ! isset( $_GET['search'] ) &&
        ! isset( $_GET['user'] ) &&
        (get_query_var('pvs_page') !== 'profile' &&
        get_query_var('pvs_page') !== 'cart' &&
        get_query_var('pvs_page') !== 'orders' &&
        get_query_var('pvs_page') !== 'coupons' &&
        get_query_var('pvs_page') !== 'category' &&
        get_query_var('pvs_page') !== 'contacts' &&
        get_query_var('pvs_page') !== 'login' &&
        get_query_var('pvs_page') !== 'checkout' &&
        get_query_var('pvs_page') !== 'signup' &&
        get_query_var('pvs_page') !== 'photo' &&
        get_query_var('pvs_page') !== 'stockapi' &&
        get_query_var('pvs_page') !== 'orders-content' &&
        get_query_var('pvs_page') !== 'lightbox' &&
        get_query_var('pvs_page') !== 'lightbox-content' &&
        get_query_var('pvs_page') !== 'my-favorite-list' &&
        get_query_var('pvs_page') !== 'profile-about' &&
        get_query_var('pvs_page') !== 'profile-downloads-table' &&
        get_query_var('pvs_page') !== 'user' &&
        ! is_author() &&
        ! is_singular('post') &&
        get_query_var('pvs_page') !== 'profile-downloads') ?
        'header_main' : 'header_back'; ?>">

            <?php get_template_part('menu'); ?>

        </header>

        <?php if( $post->ID !== 38 ) { ?>
            <div class="search-nav">
                <form class="top-search-bar" role="search" method="get" action="<?= get_site_url(); ?>/index.php">

                    <div class="search-element">
                        <input name="search" type="text" class="search-field" placeholder="<?= __('Search storyboard', 'storyboards'); ?>">
                        <button type="submit" class="search-button"><img src="<?= get_template_directory_uri(); ?>/assets/images/svg/search.svg" alt=""><span><?= __('SEARCH', 'storyboards'); ?></span></button>
                    </div>

                    <div class="search-option">
                        <div class="option-element">
                            <input type="radio" id="option1" name="vd" value="popular" checked>
                            <label for="option1"><?= __('popular', 'storyboards'); ?></label>
                        </div>
                        <div class="option-element">
                            <input type="radio" id="option2" name="vd" value="date">
                            <label for="option2"><?= __('newest', 'storyboards'); ?></label>
                        </div>
                    </div>

                    <div class="search-help">

                        <?php if( $help_title ) { ?>
                          <div class="bottom-text"><?= $help_title; ?></div>
                        <?php } ?>

                        <?php if(!empty( $help_button )) { ?>
                          <a href="<?= $help_button['url']; ?>" target="<?= $help_button['target']; ?>"><div class="bottom-button"><div class="button-text"><?= $help_button['title']; ?></div></div></a>
                        <?php } ?>

                    </div>

                </form>
            </div>
            <?php } ?>

        <?php if( $post->ID === 38 || is_author() ) { ?>
        <div class="popup_overlay"></div>

        <div class="popup">

            <div class="closer">
                <img src="<?= get_template_directory_uri(); ?>/assets/images/svg/close.svg" alt="">
            </div>

            <div class="newslider" data-slider="first"></div>

            <div class="slider-nav"></div>

        </div>
        <?php } ?>