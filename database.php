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

				unset($host, $db, $user, $pass, $charset);
			}
			return self::$connection;
		}

		public static function do_select($sql, $types = null, ...$values){

			self::get_connection();
			$stmt = self::$connection->prepare($sql);
			
			if($types && $values) {
				$stmt->bind_param($types, ...$values);
			}

            $stmt->execute();
			$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
			if(count($result) == 0) {
				return false;
			}else {
				return $result;
			}
		}

		public static function get_last_inserted($table, $field, $top = null) {

			if($top) {
				return do_select("SELECT `$field` FROM `$table` ORDER BY `$field` DESC LIMIT ?", "i", $top);
			}else {
				return do_select("SELECT MAX(`$field`) FROM `$table`"); 
			}	
		}
		
		public static function escape_field($field){
			return "`".str_replace("`", "``", $field)."`";
		}

		public static function do_insert($table, $fields, $values) {

			self::get_connection();
			$multiplier = count($fields) - 1;
			$escaped = array_map(escape_field($fields));
			$escaped = implode(",",$escaped);
			$placeholders = "(" . str_repeat("?,", $multiplier) . "?)";
			$sql = "INSERT INTO `$table` ($escaped) VALUES " . str_repeat($placeholders.",", $multiplier) . $placeholders;
            $stmt = self::$connection->prepare($sql);
            $stmt->bind_param(str_repeat("s", $multiplier + 1), ...$values);
			
			if($stmt->execute()) {
				return self::$connection->insert_id;
            }
            return false;
		}

		public static function do_delete($table, $where, $types, ...$where_values) {
			
			self::get_connection();
			$sql = "DELETE FROM `$table` WHERE " . $where;
            $stmt = self::$connection->prepare($sql);
            $stmt->bind_param($types, ...$where_values);
            return $stmt->execute();
		}
		
		public static function do_update($table, $post_data, $where = null, $types = "", ...$where_values) {
			
			self::get_connection();
			$changes = array();

            foreach ($post_data as $field => $value) {
                $changes[] = self::escape_field($field) . " = ?";
			}  

			$all_data = array_merge($post_data, $where_values);
			$sql = "UPDATE `$table` SET " . implode(",", $changes);
			
			if ($where) {
				$sql .= " WHERE $where"; 
			}

			$stmt = self::$connection->prepare($sql);
            $stmt->bind_param(str_repeat("s", count($post_data)) . $types, ...array_values($all_data));
			return $stmt->execute();      
		}
	}
?>
