<?php

$logo = get_field('logo', 'options');
$copyrights = do_shortcode(get_field('copyrights', 'options'));
$pay_panel = get_field('pay_panel', 'options');
$help_title = get_field('help_title', 'options');
$help_button = get_field('help_button', 'options');
?>
<footer>
    <div class="overlay"></div>
    <div class="footer-bar">
        <div class="storyboards-logo">

            <?php if(!empty($logo)) { ?>
            <a href="#">
                <img src="<?= $logo['url']; ?>" alt="<?= $logo['alt']; ?>" title="<?= $logo['title']; ?>">
            </a>
            <?php } ?>

            <?php if($copyrights) { ?>
            <div class="rights"><?= $copyrights; ?></div>
            <?php } ?>

        </div>
        <div class="footer-menu">
            <div class="navbar-menu">
                <div class="menu-element"><a href="index.html">HOME</a></div>
                <div class="menu-element"><a href="ourartists.html">ARTISTS</a></div>
                <div class="menu-element"><a href="video-production.html">VIDEO-PRODUCTION</a></div>
                <div class="menu-element"><a href="aboutus.html">ABOUT</a></div>
                <div class="menu-element"><a href="blog.html">BLOG</a></div>
                <div class="menu-element"><a href="contactus.html">CONTACT US</a></div>
                <div class="menu-element"><a href="#">LOGIN</a></div>
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
    </div>
</footer>
</div>

<?php wp_footer(); ?>
</body>
</html>
