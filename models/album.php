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

            return Database::do_select("SELECT * FROM `album` WHERE `userPK` IN (?, ?) ORDER BY `Name`", "ii", 1, $user_pk);
        }

        public function get_media() {

            $result = Media::get_album_media($this->data['albumPK']);

            foreach($result as $row) {
                $this->media[] = new Media($row);
            }

            return $this->media;
        }

        public function add_media($media_pks) {

            $with_album_pks = array();

            foreach ($media_pks as $value) {
                $with_album_pks[] = $value;
                $with_album_pks[] = $this->data["albumPK"];
            }
            
            return Database::do_insert('media_album', array("mediaPK", "albumPK"), $with_album_pks);
        }

        public function remove_media($media_pks) {

            $media_pks[] = $this->data["albumPK"];
            return Database::do_delete('media_album', "`mediaPK` IN (" . str_repeat("?,", count($media_pks) - 2) . "?) AND `albumPK` = ?", str_repeat("i", count($media_pks)), $media_pks);
        }

        public function find_by_tag($tag_pk) {
            $matches = array();

            foreach ($media as $m) {
                
                if ($m->data['tagPK'] == $tag_pk) {
                    $matches[] = $m;
                }
            }

            return $matches;
        }

        public function get_last_bookmarked() {

            $bookmarked_pks = Database::do_select("SELECT `mediaPK` FROM `media_album` WHERE `albumPK` = ? AND `Bookmarked` IS NOT NULL ORDER BY `Bookmarked` DESC", "i", $this->data["albumPK"]);
            $media_subset = array();

            foreach ($media as $m) {    
                
                $pos = array_search($m->data["mediaPK"], $bookmarked_pks);

                if ($pos || $pos == 0) {
                    
                    $media_subset[$pos] = $m;
                }
            }

            return $media_subset;
        }
    }
?>