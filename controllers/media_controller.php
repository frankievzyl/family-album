<?php

    $album_media = null;

    class Media_Controller {
        //position, media.filename
        function show_all() {
            $album_media = Media_Album::get_by_pk(["albumPK" => $_GET["albumPK"]]);
            $
            require_once("views/mediagrid.php");
        }

        public function select_all() {

        }

        public function upload_media() {

        }

        public function add_media() {

        }

        public function remove_media() {

        }
    }
?>