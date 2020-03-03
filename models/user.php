<?php

    class User {

        private $data = array('userPK' => null, 'Name' => null, 'Theme' => null, 'StripSize' => null, 'AlbumSize' => null, 'MediaSize' => null, 'ReverseNote' => null, 'BookmarkStart' => null);
        private $albums = array();

        public function __construct($user_data) {
            
            $this->data = array_replace($this->data, $user_data);            
        }
        
        public static function get_loggable() {
            
            $result = Database::do_select("SELECT * FROM `user`");
            #$result = Database::do_select("SELECT * FROM `user` WHERE `userPK` != ?", "i", 1);
            $all_users = array();    
        
            foreach($result as $row) {
                $all_users[] = new User($row);
            }

            return $all_users;
        }
    
        public static function insert($post_data) {
    
            return Database::do_insert('user', array_keys($post_data), array_values($post_data));
        }
    
        public function delete() {
            
            $consensus = Database::do_delete('user', "`userPK` = ?", "i", $this->data['userPK']);

            foreach ($this->albums as $album) {
                $consensus = $consensus && $album->delete();
            }
            
            return $consensus;
        }
    
        public function update($post_data) {
            
            if( Database::do_update('user', $post_data, "`userPK` = ?", "i", $this->data['userPK'])) {
                $this->data = array_replace($this->data, $post_data);
                return true;
            }
            return false;
        }
        
        public function get_albums() {
            
            $result = Album::get_user_albums($this->data['userPK']);

            foreach($result as $row) {
                $this->albums[] = new Album($row);
            }

            return $this->albums;
        }
    }
?>