<?php 
        
    class Media {

        private $data = array('mediaPK' => null, 'Created' => null, 'Filename' => null, 'Player' => null, 'userPK' => null, 'albumPK' => null, 'Position' => null, 'Bookmarked' => null);
        private $tags = array();
        private $notes = array();

        public function __construct($media_data) {
        
            $this->data = array_replace($this->data, $media_data);            
        }
    
        public function delete() {
            
            $consensus =    Database::do_delete('media', "`mediaPK` = ? AND `userPK` = ?", "ii", $this->data['mediaPK']. $this->data['userPK']) &&
                            Database::do_delete('media_album', "`mediaPK` = ? AND `albumPK` = ?", "ii", $this->data['mediaPK'], $this->data['albumPK']);
            
            foreach ($tags as $tag) {
                $consensus = $consensus && $tag->delete();
            }

            foreach ($notes as $note) {
                $consensus = $consensus && $note->delete();
            }

            return $consensus;
        }
    
        public function update($post_data) {
            
            if (array_key_exists('Position', $post_data) || array_key_exists('Bookmarked', $post_data)) {
                
                if (Database::do_update('media_album', $post_data, "`mediaPK` = ? AND `albumPK` = ?", "ii", $this->data['mediaPK'], $this->data['albumPK'])) {
                    
                    $this->data = array_replace($this->data, $post_data);
                    return true;
                }

            } else {
                
                if (Database::do_update('media', $post_data, "`mediaPK` = ? AND `userPK` = ?", "ii", $this->data['mediaPK']. $this->data['userPK'])) {

                    $this->data = array_replace($this->data, $post_data);
                    return true;
                }
            }
        
            return false;
        }

        public static function get_album_media($album_pk) {

            if ($album_pk == 1) {# public collection album
                return Database::do_select("SELECT `media`.*, `ma`.`albumPK`, `ma`.`Position`, `ma`.`Bookmarked` FROM `media` LEFT JOIN `media_album` AS `ma` ON `media`.`mediaPK` = `ma`.`mediaPK`");    
            }else {
                return Database::do_select("SELECT `media`.*, `ma`.`albumPK`, `ma`.`Position`, `ma`.`Bookmarked` FROM `media` INNER JOIN `media_album` AS `ma` ON `media`.`mediaPK` = `ma`.`mediaPK` WHERE `media_album`.`albumPK` = ?", "i", $album_pk);
            }
        }
#TODO add the two get functions below
        public function get_notes() {
            return Note::get_media_notes($this->data['mediaPK']);
        }

        public function get_tags() {
            return Media::get_media_tags($this->data['mediaPK']);
        }

        public static function insert($file_data, $user_pk) {

            if ($uploadedFiles = $file_data)//$_FILES["mediaFiles"]
            {
                $target_dir = "media/";
                $uploadOk = 1;
                $fields = array("Created", "Filename", "userPK", "Player");
                $values = array();

                foreach ($uploadedFiles as $file) {
                    $target_file = $target_dir . basename($file["name"]);

                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                    $check = getimagesize($file["tmp_name"]);

                    $uploadOk = $check !== false ? 1 : 0;
                    
                    if(file_exists($target_file))
                    {
                        echo basename($file["name"]) . "- file already exists.";
                        $uploadOk = 0;
                        //do overwrite question
                    }

                    if($uploadOk)
                    {
                        if(move_uploaded_file($file["tmp_name"], $target_file))
                        {
                            array_push($values, date('Y m d H:i:s',filectime("media/". $file["name"])), $file["name"], $user_pk);
                            
                            if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif")
                            {
                                $values[] =  1;
                            }
                            else
                            {
                                $values[] = 0;
                            }       
                        }
                    }
                }
    
                return Database::do_insert('media', $fields, $values);
            }
            
        }
    }
?>