<?php
	class Database {
		private static $connection = null;

		private function __construct() {}

		private function __clone() {}

		public static function get_connection() {

			$host = '127.0.0.1';
			$db   = 'media_collection';
			$user = 'root';
			$pass = '';
			$charset = 'utf8mb4';

			if (!isset(self::$connection)) {

				mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

				try {
					self::$connection = new mysqli($host, $user, $pass, $db);
					self::$connection->set_charset($charset);
				} catch (\mysqli_sql_exception $e) {
					throw new \mysqli_sql_exception($e->getMessage(), $e->getCode());
				}

				unset($host, $db, $user, $pass, $charset); // we don't need them anymore
			}
			return self::$connection;
		}

		public static function escape_mysql_identifier($field){
			return "`".str_replace("`", "``", $field)."`";
		}

		public static function get_field_subset($table, $fields) {

			$fields = array_map(self::escape_mysql_identifier(), $fields);
			$fieldset = implode(",", $fields);
			$table = self::escape_mysql_identifier($table);
			self::get_connection();
			$sql = "SELECT $fieldset FROM $table";
			$result = self::$connection->query($sql);
			return $result->fetch_all(MYSQLI_ASSOC);
		}

		public static function get_by_keys_core($table, $key_fields) {

			$where_clause = array();

			foreach ($key_fields as $key => $value) {
				$where_clause[] = self::escape_mysql_identifier($key) . " = ?";
			}

			self::get_connection();
            $sql = "SELECT * FROM `$table` WHERE " . implode(" AND ", $where_clause);
			$stmt = self::$connection->prepare($sql);
            $stmt->bind_param(str_repeat("s", count($key_fields)), ...array_values($key_fields));
            $stmt->execute();
			$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
			if(count($result) == 1) {
				return $result[0];
			}else {
				return $result;
			}
		}

		public static function get_by_pk_core($table, $field, $pk) {

			self::get_connection();
            $sql = "SELECT * FROM $table WHERE $field = ?";
			$stmt = self::$connection->prepare($sql);
            $stmt->bind_param("i", $pk);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
		}

		public static function get_all_core($table) {//V

            self::get_connection();
            $sql = "SELECT * FROM `$table`";
			$result = self::$connection->query($sql);
            return $result->fetch_all(MYSQLI_ASSOC);
		}
		
		public static function insert_tuple_core($table, $tuple_data) {

			self::get_connection();
			$keys = array_keys($tuple_data);
			$keys = array_map(self::escape_mysql_identifier(), $keys);
			$fields = implode(",", $keys);
			$placeholders = str_repeat('?,', count($keys) - 1) . '?';
			$sql = "INSERT INTO `$table` ($fields) VALUES ($placeholders)";
            $stmt = self::$connection->prepare($sql);
            $stmt->bind_param(str_repeat("s", count($tuple_data)), ...array_values($tuple_data));
			
			if($stmt->execute()) {
                return self::$connection->insert_id;
            }
            return false;
		}

		public static function delete_tuple_core($table, $key_fields) {
			
			$where_clause = array();

			foreach ($key_fields as $key => $value) {
				$where_clause[] = self::escape_mysql_identifier($key) . " = ?";
			}

            self::get_connection();
            $sql = "DELETE FROM `$table` WHERE " . implode(" AND ", $where_clause);
            $stmt = self::$connection->prepare($sql);
            $stmt->bind_param(str_repeat("s", count($key_fields)), ...array_values($key_fields));
            return $stmt->execute();
		}
		
		public static function update_tuple_core ($table, $key_fields, $post_data) {
			
			self::get_connection();
			$changes = array();
			$where_clause = array();

            foreach ($post_data as $field => $value) {
                $changes[] = self::escape_mysql_identifier($field) . " = ?";
			}
			
			foreach ($key_fields as $key => $value) {
				$where_clause[] = self::escape_mysql_identifier($key) . " = ?";
			}    

			$all_data = array_merge($post_data, $key_fields);
            $sql = "UPDATE `$table` SET " . implode(",", $changes) . " WHERE " . implode(" AND ", $where_clause);
            $stmt = self::$connection->prepare($sql);
            $stmt->bind_param(str_repeat("s", count($all_data)), ...array_values($all_data));
			return $stmt->execute();      
		}
		
		//up to here works	
	}
?>
