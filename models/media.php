<?php 
        
    class Media {

        private $tuple = array('mediaPK' => null, 'Created' => null, 'Filename' => null, 'Player' => null, 'userPK' => null);
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

        public static function insert_tuple($file_data) {

            if ($uploadedFiles = $file_data)//$_FILES["mediaFiles"]
            {
                $target_dir = "../media/";
                $uploadOk = 1;
                $stmnt = "INSERT INTO `media` (`Created`, `Filename`, `Owner`, 'Player') VALUES (";

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
                            echo "upload success";
                            if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif")
                            {
                                $stmnt .= "('" . date('Y m d H:i:s',filectime("../media/". $file["name"])) . "','" . $file["name"] . "', " . $_SESSION["userData"]["PK"] . "', 1)";
                            }
                            else
                            {
                                $stmnt .= "('" . date('Y m d H:i:s',filectime("../media/". $file["name"])) . "','" . $file["name"] . "', " . $_SESSION["userData"]["PK"] . "', 0)";
                            }       
                        }
                    }
                }

                $stmnt .= ")";
                //insert new media
                $_SESSION["connection"]->query($stmnt);
            }
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
        /*1. load settings and apply
        2. get post variables
        3. load media and rest of album in slider, wrapping around
        4. 'pop-up' for note and another for tags, validate each and IUD */
    }
?>