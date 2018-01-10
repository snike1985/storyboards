<div class="content-element">
    <a href="<?php echo(@$related_url);?>">
        <img src="<?php echo(@$related_preview);?>" alt="<?php echo(@$related_title);?>">
        <div class="board">
            <div class="board-info">
                <div class="board-name"><?php echo(@$related_title);?></div>
                <div class="board-downloads"><?php echo(@$related_downloaded);?> downloads</div>
            </div>
            <div class="board-author">
	            <?php echo get_avatar(@$related_author, 30);?>
            </div>
        </div>
    </a>
</div>
