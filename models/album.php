<?php 

    class Album {
        private $tuple = array('albumPK' => null, 'Name' => null, 'Icon' => null, 'userPK' => null);
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
    $result = $_SESSION["connection"]->query("SELECT * FROM `album` WHERE `PK` = 1 OR `Owner` = " . $_SESSION["userData"]["PK"]);

    while($row = $result->fetch_assoc()) { 
        if($row["Icon"]){
            echo '<div class="grid-item"><a href="http://localhost/familyalbum/pages/mediagrid.php?albumPK='.$row["PK"].'&albumName='.$row["Name"].'"><img src="../media/icons/'.$row["Icon"].'" alt="'.$row["Name"].' Icon"></a></div>';
        }
        else{
            echo '<div class="grid-item"><a href="http://localhost/familyalbum/pages/mediagrid.php?albumPK='.$row["PK"].'&albumName='.$row["Name"].'"></a></div>';
        }
    } 
?>