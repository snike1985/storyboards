<?php
$logo = get_field('logo', 'options');
$copyrights = do_shortcode(get_field('copyrights', 'options'));
$pay_panel = get_field('pay_panel', 'options');
$help_title = get_field('help_title', 'options');
$help_button = get_field('help_button', 'options');

$menu_name = 'menu-footer';
$locations = get_nav_menu_locations();
?>

</div>
<footer style="bottom:inherit; margin-top:-173px">
    <div class="footer-bar">

        <div class="storyboards-logo">

            <?php if(!empty($logo)) { ?>
            <a href="<?= get_site_url(); ?>">
                <img src="<?= $logo['url']; ?>" alt="<?= $logo['alt']; ?>" title="<?= $logo['title']; ?>">
            </a>
            <?php } ?>

            <?php if($copyrights) { ?>
            <div class="rights"><?= $copyrights; ?></div>
            <?php } ?>

        </div>

	    <?php if( $locations && isset($locations[ $menu_name ]) ){
	    $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
	    $menu_items = wp_get_nav_menu_items( $menu ); ?>
        <div class="footer-menu">
            <div class="footer-menu__wrap">
                <div class="footer-menu__links">
                    <?php foreach ( (array) $menu_items as $key => $menu_item ){ ?>
                        <a href="<?= $menu_item->url; ?>"><?= $menu_item->title; ?></a>
                    <?php } ?>
                </div>
	            <?php if (is_user_logged_in()) { ?>
                    <a href="<?= wp_logout_url(site_url()); ?>"><?= __('LOGOUT', 'storyboards'); ?></a>
	            <?php } else { ?>
                    <a href="<?= get_site_url('', 'login'); ?>"><?= __('LOGIN', 'storyboards'); ?></a>
		        <?php } ?>
            </div>
            <div class="bottom-panel">

                <?php if(!empty($pay_panel)) { ?>
                <div class="pay-panel">

                    <?php foreach ($pay_panel as $row) { ?>
                    <a href="<?= $row['url']; ?>"><img src="<?= $row['image']['url']; ?>" alt="<?= $row['image']['alt']; ?>" title="<?= $row['image']['title']; ?>"></a>
                    <?php } ?>

                </div>
                <?php } ?>

                <?php if($help_title) { ?>
                <div class="bottom-text"><?= $help_title; ?></div>
                <?php } ?>

                <?php if(!empty($help_button)) { ?>
                <a href="<?= $help_button['url']; ?>" target="<?= $help_button['target']; ?>"><div class="bottom-button"><div class="button-text"><?= $help_button['title']; ?></div></div></a>
                <?php } ?>

            </div>
        </div>
		<?php } ?>

    </div>
</footer>

<?php if( is_page_template('page-video.php') ) { ?>
    <div class="popup">

        <!-- popup__wrap -->
        <div class="popup__wrap">

            <!-- popup__content -->
            <div class="popup__content popup__video">

                <div class="popup__close"></div>

                <div class="video">
                    <iframe src="#" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                </div>

            </div>
            <!-- /popup__content -->

        </div>
        <!-- /popup__wrap -->

    </div>
<?php } ?>
<script>check_carts('');</script>
<?php wp_footer(); ?>

<?php if ( get_query_var('pvs_page') === 'signup') { ?>
    <script>
        var context = '<div class="form_field">' +
            '<input value="1" type="checkbox"> ' +
            '<b>ext will be given later</b>' +
            '<div></div>' +
            '</div>';
        $('.page_internal').find('form .row>div').eq(1).append(context);
    </script>
<?php } ?>
</body>
</html>
