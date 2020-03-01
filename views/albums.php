
<div class="interface">
    <form class="menu" method="get" name="menuform">
        <input type="hidden" name="controller" value="album">
        <div class="menu-item"><button class="menu-btn" name="action" value="create"><img src="themes/default/icons/create.png" alt="create new album" class="menu-btn-icon"></button><span class="expand-right"></span></div>
        <div class="menu-item"><button class="menu-btn" name="action" value="edit"><img src="themes/default/icons/edit.png" alt="edit album properties" class="menu-btn-icon"></button><span class="expand-right"></span></div>
        <div class="menu-item"><button class="menu-btn" name="action" value="delete"><img src="themes/default/icons/delete.png" alt="delete chosen albums" class="menu-btn-icon"></button><span class="expand-right"></span></div>
        <div class="menu-item"></div>
        <div class="menu-item"><button class="menu-btn" name="action" value="settings"><img src="themes/default/icons/settings.png" alt="go to user settings" class="menu-btn-icon"></button><span class="expand-right"></span></div>
    </form>
    <div class="view">
        <div class="top-bar"><input type="range" class="zoom-slider" name="albumzoom" id="albumzoom" min="20" max="80" value="20" onchange="zoom_folder_icons(this,'album')"></div>
        <form class="grid-container albums" name="albumform" method="GET">
            <input type="hidden" name="action" value="show_all">
            <input type="hidden" name="controller" value="media_album">
            <?php foreach($user_albums as $album) { ?> 
                <div class="album">
                    <button class="album-btn" name="albumPK" value="<?php echo $album['albumPK']; ?>">
                        <img src="themes/<?php echo $current_user['Theme'] . '/' . $album['Icon']; ?>.png" alt="" class="folder-icon">
                        <!--<img src="" alt="album folder icon" class="icon-folder">-->
                    </button>
                    <span><?php echo $album['Name']; ?></span>
                </div>
            <?php } ?>
        </form>
        <script>
            zoom_folder_icons(document.getElementById("albumzoom"));
            set_page_title($current_user['Name'] + "'s Albums");
        </script>
    </div>
</div>
