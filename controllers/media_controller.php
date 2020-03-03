<?php

    $album_media = null;

    class Media_Controller {
        //position, media.filename
        function show_all() {
            $album_media = Media_Album::get_by_pk(["albumPK" => $_GET["albumPK"]]);
            $
            require_once("views/albummedia.php");
        }

        public function select_all() {

        }

        public function upload_media() {

        }

        public function add_media() {

        }

        public function remove_media() {

        }

        #format date from db:
        # $date = mktime(hour, minute, second, month, day, year)
        # date(format, $date)
    }   
?>