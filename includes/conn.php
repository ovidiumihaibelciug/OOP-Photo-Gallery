<?php 

require_once LIB_PATH.DS.'config.php';

class MySqlDatabase {
	public $conn; 

	public function __construct() {
		$this->open_connection();
	}

	public function open_connection() {
		$this->conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME) or die(mysqli_error($this->conn));
	}

	public function close_connection() {
		if (isset($this->conn)) {
			mysqli_close($this->conn);
			unset($this->conn);
		}
	} 

	public function query($query) {
		$result = mysqli_query($this->conn, $query);
		$this->confirm_query($result);
		return $result;
	}

	private function confirm_query($result_set) {
		if(!$result_set) {
			die('Database query failed');
		}
	}

	public function escape_string($string) {
		$escaped_string = mysqli_real_escape_string($this->conn, $string);
		return $escaped_string;
	}

	public function fetch_assoc($result_set) {
		return mysqli_fetch_assoc($result_set);
	}

	public function num_rows($result_set) {
		return mysqli_num_rows($result_set);
	}
	public function insert_id() {
		return mysqli_insert_id($this->conn);
	}
	public function affected_rows() {
		return mysqli_affected_rows($this->conn);
	}
}

$db = new MySqlDatabase();

?>