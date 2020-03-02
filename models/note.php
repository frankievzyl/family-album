<?php

    class Note {

        private $data = array('notePK' => null, 'NoteText' => null, 'userPK' => null, 'mediaPK' => null);
        
        public function __construct($note_data) {
            
            $this->data = array_replace($this->data, $note_data);            
        }

        public static function insert($post_data) {
    
            $note_pk = Database::do_insert('note', array("NoteText"), array($post_data["NoteText"]));
            
            if ($note_pk) {
                
                unset($post_data["NoteText"]);
                $post_data["notePK"] = $note_pk;
                return Database::do_insert('media_note', array_keys($post_data), array_values($post_data));

            } else {

                return false;
            }
        }
    
        public function delete() {
            
            return  Database::do_delete('media_note', "`notePK` = ? AND `mediaPK` = ?", "ii", $this->data['notePK'], $this->data['mediaPK']);
        }

        public function delete_loose() {# run once before app close

            return Database::do_delete('note', "`notePK` NOT IN (SELECT DISTINCT `notePK` FROM `media_note`)");
        }
    
        public function update($post_data) {
                       
            if (Database::do_update('note', $post_data, "`notePK` = ? AND `userPK` = ?", "ii", $this->data['notePK'], $this->data['userPK'])) {
                
                $this->data = array_replace($this->data, $post_data);
                return true;
            }
        
            return false;
        }
    }
?>