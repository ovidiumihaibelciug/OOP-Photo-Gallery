<?php 

require_once LIB_PATH.DS.'conn.php';

class User extends DatabaseObject{
	public $id;
	public $username;
	public $firstname;
	public $lastname;
	public $password;
	protected static $table_name = "users";
	protected static $db_fields = array('id','username','lastname','firstname','password');

	public function full_name() {
	    if(isset($this->firstname) && isset($this->lastname)) {
      		return $this->firstname . " " . $this->lastname;
	    } else {
	      return "";
	    }   
	}

	public static function authenticate($username, $password) {
		global $db;
		$username = $db->escape_string($username);
		$password = $db->escape_string($password);

		$query = "SELECT * FROM `users` WHERE `username` = '$username' AND `password` = '$password' LIMIT 1";
		$result_set = self::find_by_sql($query);
		return !empty($result_set) ? array_shift($result_set) : false;
	}

}

?>