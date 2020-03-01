<?php

    $user_albums = null;
    $current_user = null;

    class Album_Controller {

        public function show_all() {
            $user_data = User::get_by_pk(["userPK" => $_GET["userPK"]]);
            $current_user = new User($user_data);
            $current_user = $current_user->get_tuple();
            $user_albums = Album::get_by_pk(["userPK" => $_GET["userPK"]]);
            require_once("views/albums.php");
        }

        public function select_all() {

        }

        public function delete() {

        }

        public function edit() {

        }

        public function create() {

        }
    }
?>