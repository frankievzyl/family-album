<?php

    class Tag {

        private $data = array('tagPK' => null, 'Name' => null, `mediaPK` => null, `userPK` => null, `PosX` => null, `PosY` => null);

        public function __construct($tag_data) {
            
            $this->data = array_replace($this->data, $tag_data);            
        }

        public static function insert($post_data) {
    
            $tag_pk = Database::do_insert('tag', array("Name"), array($post_data["Name"]));
            
            if ($tag_pk) {
                
                unset($post_data["Name"]);
                $post_data["tagPK"] = $tag_pk;
                return Database::do_insert('media_tag', array_keys($post_data), array_values($post_data));
            } else {
                return false;
            }
        }
    
        public function delete() {
            
            return  Database::do_delete('media_tag', "`tagPK` = ? AND `mediaPK` = ? AND `userPK` = ?", "iii", $this->data['tagPK'], $this->data['mediaPK'], $this->data['userPK']);
        }

        public function delete_loose() {# run once before app close

            return Database::do_delete('tag', "`tagPK` NOT IN (SELECT DISTINCT `tagPK` FROM `media_tag`)")
        }
    
        public function update($post_data) {
                       
            if (array_key_exists('Name', $post_data)) {
                
                return Database::do_update('tag', $post_data, "`tagPK` = ?", "i", $this->data['mediaPK']);
                
            }else {
                return Database::do_update('media_tag', $post_data, "`tagPK` = ? AND `mediaPK` = ? AND `userPK` = ?", "iii", $this->data['tagPK'], $this->data['mediaPK'], $this->data['userPK']);
            }
            
            if( ) {
                $this->data = array_replace($this->data, $post_data);
                return true;
            }
        
            return false;
        }

        public static function get_media_tags($media_pk) {

            return Database::do_select("SELECT `media_tag`.*, `tag`.`Name` FROM `media_tag` INNER JOIN `tag` ON `media_tag`.`tagPK` = `tag`.`tagPK` WHERE `media_tag`.`mediaPK` = ?", "i", $media_pk);
        }

        public static function get_active() {

            return Database::do_select("SELECT * FROM `tag` WHERE `tagPK` IN (SELECT DISTINCT `tagPK` FROM `media_tag`)");
        }
    }
?>