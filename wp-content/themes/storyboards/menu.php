<?php
$menu_name = 'menu';
$menu_name_mobile = 'menu-mobile';
$locations = get_nav_menu_locations();
$logo = get_field('logo', 'options');
$cart_url = get_field('cart_url', 'options');
$sign_up_url = get_field('sign_up_url', 'options');
?>
<span class="menu-btn"><span></span></span>

<?php if(!empty($logo)) { ?>

    <div class="storyboards-logo">

        <a href="<?= get_site_url(); ?>">
            <img src="<?= $logo['url']; ?>" alt="<?= $logo['alt']; ?>" title="<?= $logo['title']; ?>">
        </a>

    </div>
<?php } ?>


<div class="header__wrap">

    <div class="menu">

	    <?php if( $locations && isset($locations[ $menu_name ]) ){
	    $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
	    $menu_items = wp_get_nav_menu_items( $menu ); ?>

        <nav class="menu__links">
            <?php foreach ( (array) $menu_items as $key => $menu_item ) { ?>
                <a class="menu__item" href="<?= $menu_item->url; ?>"><?= $menu_item->title; ?></a>
            <?php } ?>
        </nav>

		<?php } ?>

        <div class="entrance">
            <?php if (is_user_logged_in()) { ?>
                <a class="entrance__link" href="<?= wp_logout_url(site_url()); ?>"><?= __('LOGOUT', 'storyboards'); ?></a>
            <?php } else { ?>
            <a class="entrance__link" href="<?= get_site_url('', 'login'); ?>"><?= __('LOGIN', 'storyboards'); ?></a>
            <a class="site-btn" href="<?= get_site_url('', 'signup'); ?>">
                <span class="sign-up"><?= __('SIGN-UP', 'storyboards'); ?></span>
            </a>
	        <?php } ?>

        </div>

    </div>

    <a class="cart" href="<?= get_site_url('', 'cart'); ?>">
        <img src="<?= get_template_directory_uri(); ?>/assets/images/svg/Cart.svg" alt="cart">
    </a>

	<?php echo( pvs_get_theme_content('shopping_cart_lite') ); ?>

</div>


