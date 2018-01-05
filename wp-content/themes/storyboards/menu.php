<?php
$menu_name = 'menu';
$menu_name_mobile = 'menu-mobile';
$locations = get_nav_menu_locations();
$logo = get_field('logo', 'options');
$cart_url = get_field('cart_url', 'options');
$sign_up_url = get_field('sign_up_url', 'options');
?>
<nav>

	<div class="navbar">

		<?php if(!empty($logo)) { ?>
			<div class="storyboards-logo">
				<a href="<?= get_site_url(); ?>">
					<img src="<?= $logo['url']; ?>" alt="<?= $logo['alt']; ?>" title="<?= $logo['title']; ?>">
				</a>
			</div>
		<?php } ?>

		<?php if( $locations && isset($locations[ $menu_name ]) ){
			$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
			$menu_items = wp_get_nav_menu_items( $menu ); ?>
			<div class="navbar-menu">

				<?php foreach ( (array) $menu_items as $key => $menu_item ){ ?>
					<a href="<?= $menu_item->url; ?>"> <div class="menu-element"><?= $menu_item->title; ?></div></a>
				<?php } ?>

			</div>
		<?php } ?>

		<?php if( $sign_up_url ) { ?>
			<div class="btn"><a href="<?= $sign_up_url; ?>"><div class="sign-up"><?= __('SIGN-UP', 'storyboards'); ?></div></a></div>
		<?php } ?>

		<?php if( $cart_url ) { ?>
			<div class="cart"><a href="<?= $cart_url; ?>"><img src="<?= get_template_directory_uri(); ?>/assets/images/svg/Cart.svg" alt="cart"></a>
                <div class="btn-group dropdown"  id="cart_desktop"></div>
				<?php echo(pvs_get_theme_content ('shopping_cart'));?>
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
            </div>
		<?php } ?>

	</div>

	<?php if( $locations && isset($locations[ $menu_name_mobile ]) ){
		$menu = wp_get_nav_menu_object( $locations[ $menu_name_mobile ] );
		$menu_items = wp_get_nav_menu_items( $menu ); ?>
		<div class="mobile-navbar">

			<div class="mobile-button">
				<button class="c-hamburger c-hamburger--htx">
					<span>toggle menu</span>
				</button>

				<ul class="navbar-mobile-menu" id="navi">
					<?php foreach ( (array) $menu_items as $key => $menu_item ){ ?>
						<li><a href="<?= $menu_item->url; ?>"><?= $menu_item->title; ?></a></li>
					<?php } ?>
				</ul>

			</div>

			<?php if(!empty($logo)) { ?>
				<div class="storyboards-logo">
					<a href="<?= get_site_url(); ?>">
						<img src="<?= $logo['url']; ?>" alt="<?= $logo['alt']; ?>" title="<?= $logo['title']; ?>">
					</a>
				</div>
			<?php } ?>

			<?php if( $cart_url ) { ?>
				<div class="cart">
					<a href="<?= $cart_url; ?>">
						<svg width="50px" height="50px" viewBox="0 0 18 18" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">

							<g id="Symbols" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<g id="header" transform="translate(-1123.000000, -10.000000)" stroke="#FFFFFF" stroke-width="0.5" fill="#FFFFFF">
									<g id="Cart" transform="translate(1124.000000, 11.000000)">
										<path d="M4.48788495,15.2456386 C4.90725047,15.2490108 5.25159237,14.9072932 5.24814543,14.4912113 C5.24483919,14.0906907 4.9123857,13.7592653 4.50765208,13.7529073 C4.0972908,13.746479 3.75301925,14.0806794 3.7493261,14.4890685 C3.74563296,14.8999165 4.07991543,15.2423718 4.48788495,15.2456386 M3.00000437,14.5045947 C2.9980347,13.6756977 3.66160509,13.004838 4.4883422,13.0000255 C5.32074213,12.9952131 6.00059754,13.6708501 5.99999961,14.5023115 C5.99940167,15.3226726 5.31877245,16.0019629 4.49938647,15.9999957 C3.67201625,15.9979584 3.00197405,15.3297683 3.00000437,14.5045947" id="Fill-4"></path>
										<path d="M12.4929633,15.2465734 C12.9029106,15.2497713 13.2436657,14.9154339 13.2485553,14.5051907 C13.2534448,14.098567 12.9137098,13.7555145 12.5037273,13.7530897 C12.0934282,13.7506298 11.7518641,14.0863728 11.7493665,14.4946833 C11.746869,14.9049266 12.0815737,15.2433755 12.4929633,15.2465734 M11.0000008,14.4966513 C10.9991566,13.6718071 11.6733148,12.9979314 12.4971141,13.0000048 C13.3253105,13.0021484 13.9982024,13.6710692 13.9999964,14.4940156 C14.0017904,15.3188597 13.3318885,15.9952657 12.5085465,15.9999746 C11.6744405,16.0047539 11.0008099,15.3334787 11.0000008,14.4966513" id="Fill-7"></path>
										<path d="M2.78857125,2.36228465 C2.79736329,2.41922826 2.79610165,2.43851621 2.80335607,2.45445453 C3.48511346,3.95442372 4.16600349,5.45476099 4.85544899,6.95163821 C4.88158854,7.00836097 4.99064134,7.06556225 5.06125362,7.06574629 C7.29458866,7.07167255 9.52796313,7.07097318 11.7612982,7.07001614 C12.0485573,7.06990572 12.285548,6.9654048 12.4592992,6.74933562 C13.2992344,5.70476812 14.1408255,4.6613049 14.9728754,3.61132647 C15.0582725,3.50358635 15.1169387,3.35800652 15.1319601,3.22446325 C15.1888915,2.71771293 14.8014899,2.36283678 14.2091905,2.36272636 C10.4781339,2.36199018 6.74711681,2.36232146 3.0160997,2.36228465 L2.78857125,2.36228465 Z M14.2953761,10.2110436 L14.2953761,10.9997145 C13.9700707,10.9997145 13.6565932,10.9997514 13.3430763,10.9997145 C10.5965701,10.9995673 7.85006402,11.0011133 5.10359733,10.9982422 C4.24552608,10.9973956 3.5677113,10.4916391 3.4039744,9.7314952 C3.32803959,9.37912208 3.37889935,9.0367242 3.55343902,8.71192106 C3.7448531,8.35579341 3.93670086,7.99970256 4.11490717,7.6378327 C4.15039072,7.56583418 4.15610752,7.45562785 4.1235415,7.38351891 C3.15223828,5.23225022 2.17348351,3.08392626 1.199933,0.933540998 C1.15143881,0.826463443 1.09095906,0.785789432 0.966530051,0.789617575 C0.697406989,0.797936422 0.427731959,0.788034785 0.158490618,0.793850616 C0.0372157073,0.796427251 -0.00351153028,0.753691932 0.000233956239,0.643080708 C0.0069364058,0.447182893 0.00212641258,0.250953795 0.00212641258,0.0287006932 C0.0641832102,0.0200505641 0.123361897,0.00495884968 0.182619437,0.00466437721 C0.622812668,0.00238221551 1.06312418,0.00757229292 1.50319913,0.000100053808 C1.64107246,-0.00225572601 1.71401088,0.0365778319 1.76719679,0.160256272 C1.94808408,0.580983824 2.14805363,0.99453361 2.3292169,1.41518754 C2.38192969,1.53757767 2.45226599,1.57611675 2.5913221,1.57596952 C6.33657206,1.57236223 10.0817826,1.57284075 13.8270326,1.57276713 C14.0044503,1.57276713 14.1823018,1.56625192 14.3591676,1.57578547 C15.0259037,1.6116375 15.5255516,1.9054106 15.816083,2.46542363 C16.1064568,3.025179 16.053192,3.57735171 15.6548694,4.07979537 C14.8301921,5.12009302 13.9945544,6.15277119 13.164594,7.18946154 C12.8045147,7.63926825 12.3251319,7.86019623 11.7245136,7.85993856 C9.53651861,7.85909196 7.34848424,7.86122688 5.1604893,7.85607361 C5.00061616,7.85570552 4.91348432,7.89851446 4.84685408,8.03577544 C4.69250061,8.35380572 4.51918315,8.66381162 4.35576166,8.97805056 C4.00751027,9.64790183 4.38608039,10.2118166 5.18430271,10.2118166 C8.14765278,10.2118902 11.1109634,10.2113381 14.0743135,10.2110436 L14.2953761,10.2110436 Z" id="Fill-1"></path>
									</g>
								</g>
							</g>
						</svg>
					</a>
                </div>
			<?php } ?>

		</div>
	<?php } ?>

</nav>