<div class="interface">
    <form class="menu" method="get" name="menuform">
        <input type="hidden" name="controller" value="album">
        <div class="menu-item"><button class="menu-btn" name="action" value="upload_media"><img src="themes/default/icons/create.png" alt="upload new photos" class="menu-btn-icon"></button><span class="expand-right"></span></div>
        <div class="menu-item"><button class="menu-btn" name="action" value="add_media"><img src="themes/default/icons/edit.png" alt="add photos to album" class="menu-btn-icon"></button><span class="expand-right"></span></div>
        <div class="menu-item"><button class="menu-btn" name="action" value="remove_media"><img src="themes/default/icons/delete.png" alt="remove photos from album" class="menu-btn-icon"></button><span class="expand-right"></span></div>
        <div class="menu-item"></div>
        <div class="menu-item"><button class="menu-btn" name="action" value="settings"><img src="themes/default/icons/settings.png" alt="go to user settings" class="menu-btn-icon"></button><span class="expand-right"></span></div>
    </form>
    <div class="view">
    <div class="top-bar"><input type="range" class="zoom-slider" name="mediaszoom" id="mediaszoom" min="20" max="80" value="20" onchange="zoom_media_icons(this,'media')"></div>
    <form class="grid-container medias" name="mediasform" method="GET">
            <input type="hidden" name="action" value="show_single">
            <input type="hidden" name="controller" value="media">
            <?php foreach($album_media as $media) { ?> 
                <div class="media">
                    <button class="media-btn" name="mediaPK" value="<?php echo $album['mediaPK']; ?>">
                        <img src="media/icons/<?php echo $media['']; ?>.png" alt="" class="medias-icon">
                        <!--<img src="" alt="album folder icon" class="icon-folder">-->
                    </button>
                    <span><?php echo $album['Name']; ?></span>
                </div>
            <?php } ?>
        </form>
        <script>
            zoom_folder_icons(document.getElementById("mediaszoom"));
            set_page_title($current_user['Name'] + "'s Albums");
        </script>
    </div>
</div>
