<?php 

    class Album {
        private $data = array('albumPK' => null, 'Name' => null, 'Icon' => null, 'userPK' => null);
        private $media = array();

        public function __construct($album_data) {

            $this->data = array_replace($this->data, $album_data);            
        }
    
        public static function insert($post_data) {
    
            return Database::do_insert('album', array_keys($post_data), array_values($post_data));
        }
    
        public function delete() {
            
            return  Database::do_delete('album', "`albumPK` = ?", "i", $this->data['albumPK']) &&
                    Database::do_delete('media_album', "`albumPK` = ?", "i", $this->data['albumPK']);
        }
    
        public function update($post_data) {
            
            if( Database::do_update('album', $post_data, "`albumPK` = ?", "i", $this->data['albumPK'])) {
                $this->data = array_replace($this->data, $post_data);
                return true;
            }
            return false;
        }

        public static function get_user_albums($user_pk) {

            return Database::do_select("SELECT * FROM `album` WHERE `userPK` IN (?, ?)", "ii", 1, $user_pk);
        }

        public function get_media() {

            $result = Media::get_album_media($this->data['albumPK']);

            foreach($result as $row) {
                $this->media[] = new Media($row);
            }

            return $this->media;
        }

        public function add_media() {
            #TODO
        }
    }
?>