<?php

    $logging_users = null;
    
    class User_Controller {

        public function log_in() {
            $logging_users = User::get_loggable();
            require_once("views/userlogin.php");
        }

        public function sign_up() {
            //$newUserPK = User::insert_data(["Name" => $_GET["Name"]]);
            header("Location: ?userPK=1&controller=album&action=show_all");
        }

        public function settings() {
            require_once("views/settings.php");
        }
    }
?>