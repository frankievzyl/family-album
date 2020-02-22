<?php

    class User {

        private $tuple = array('userPK' => null, 'Name' => null, 'Theme' => null, 'StripSize' => null, 'GridSize' => null, 'ReverseNote' => null, 'BookmarkStart' => null);
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
    /*enter name, check availability, choose icon
    2. create user
    3. go to userlogin. */
    if(isset($_POST['submit']))
    {
        
    }
    
    session_start();
    $result = $_SESSION["connection"]->query("SELECT `PK`,`Name` FROM `user` WHERE NOT `PK` IN (1)");
    
    while($row = $result->fetch_assoc()) { 
        
        //<button class='login-button' type='submit' value='$row['PK']" name="userPK"><?php echo $row=["Name"]; </button>
    } 

   
/**1. load user settings and display
 * 2. validate changes and apply or cancel
 */
    if(isset($_POST['submit']))
    {

    }
    
    //if valid; return to previous page; else show errors
?>
?>