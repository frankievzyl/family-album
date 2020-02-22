<?php 

    class Media_Album {

        private $tuple = array('albumPK' => null, 'mediaPK' => null, 'Position' => null, 'Bookmarked' => null);
        private $primary_key;

        public function __construct($user_data) {
            
            $this->tuple = array_replace($this->tuple, $user_data);
            $this->primary_key = $user_data['userPK'];             
        }

        public function get_pk () { return $this->primary_key; }

        public function get_tuple() { return $this->tuple; }

        public static function get_all() {

            return Database::get_all_core('user');
        }

        public static function get_by_pk($user_pk) {

            return Database::get_by_keys_core('user', 'userPK', $user_pk);
        }

        public static function insert_tuple($post_data) {

            return Database::insert_tuple_core('user', $post_data);
        }

        public function delete_tuple() {
            
            return Database::delete_tuple_core('user', 'userPK', $primary_key);
        }

        public function update_tuple($post_data) {
            
            if(Database::update_tuple_core('user', 'userPK', $primary_key, $post_data)) {
                $this->tuple = array_replace($this->tuple, $post_data);
                return true;
            }
            return false;
        }
    }
    session_start();

    $result = $_SESSION["connection"]->query("SELECT * FROM `media` WHERE `PK` IN (SELECT `Media_pk` FROM `media_album` WHERE `Album_pk` = " . $_GET["albumPK"] . ")");
    
    /*1. get and apply settings
    2. load all media in album and display
    3. go to media */
    
   
    while($row = $result->fetch_assoc()) { 
        if($row["Player"]){
            echo '<div class="grid-item"><a href="http://localhost/familyalbum/pages/media.php?albumPK='.$_GET["albumPK"].'&mediaPK='.$row["PK"].'&Player=true"><img src="../media/icons/mediaplayer.png" alt="Media Player Icon"></a></div>';
        }
        else{
            echo '<div class="grid-item"><a href="http://localhost/familyalbum/pages/media.php?albumPK='.$_GET["albumPK"].'&mediaPK='.$row["PK"].'&Player=false"><img src="../media/icons/'.$row["Filename"].'" alt="'.$row["Filename"].' Icon"></a></div>';
        }
    } 
?>