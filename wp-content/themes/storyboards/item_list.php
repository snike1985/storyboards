<?php
global $wpdb;
$newtable = $wpdb->get_results( "SELECT author FROM " . PVS_DB_PREFIX . "media WHERE id=" . $pvs_theme_content['item_id'] );
$user_data = get_user_by( 'slug', $newtable[0]->author );
?>

<div class="content-element">
    <a href="<?php echo($pvs_theme_content[ 'item_url' ]);?>">

        <img src="<?php echo($pvs_theme_content[ 'item_img' ]);?>" border="0" <?php echo($pvs_theme_content[ 'item_lightbox' ]);?> class="preview_listing">

        <div class="board">

            <div class="board-info">
                <div class="board-name"><?= $pvs_theme_content[ 'item_title' ]; ?></div>

				<?php if( $pvs_theme_content[ 'item_downloaded' ] ) { ?>
                  <div class="board-downloads"><?= $pvs_theme_content[ 'item_downloaded' ].' '._n( 'download' , 'downloads' , $pvs_theme_content[ 'item_downloaded' ] ); ?></div>
				<?php } ?>

            </div>

            <div class="board-author">
                <?= get_avatar($user_data->ID, 30); ?>
            </div>

        </div>

    </a>
</div>