<?php

    $user_portraits = null;
    
    class User_Controller {

        public function log_in() {
            $conn = Database::get_connection();
            $sql = "SELECT * FROM `user`";// WHERE NOT `userPK` = 1";
            $result = $conn->query($sql);
            $user_portraits = $result->fetch_all(MYSQLI_ASSOC);
            require_once("views/userlogin.php");
        }

        public function sign_up() {
            //$newUserPK = User::insert_tuple(["Name" => $_GET["Name"]]);
            header("Location: ?userPK=1&controller=album&action=show_all");
        }

        public function settings() {
            require_once("views/settings.php");
        }
    }
?>