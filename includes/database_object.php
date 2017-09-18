<?php 

require_once LIB_PATH.DS.'conn.php';

class DatabaseObject {

	private static function instantiate($row) {
		$object = new static;
		foreach ($row as $attribute=>$value) {
			if ($object->has_attribute($attribute))
				$object->$attribute = $value;
		}
		return $object;
	}

	private function has_attribute($attribute) {
		$object_vars = get_object_vars($this);
		return array_key_exists($attribute, $object_vars);
	}

	public static function count_all() {
		global $db;
		$query = "SELECT COUNT(*) FROM " . static::$table_name;
		$result_set = $db->query($query);
		$row = $db->fetch_assoc($result_set);
		return array_shift($row);
	}

	public static function find_all() {
		
		$query = "SELECT * FROM ".static::$table_name;
		$result_set = static::find_by_sql($query);
		return $result_set;
	}

	public static function find_by_id($id) {
		$query = "SELECT * FROM ".static::$table_name." WHERE `id`='$id' LIMIT 1";
		$result_array = static::find_by_sql($query);
		return !empty($result_array) ? array_shift($result_array) : false;
	}	

	public static function find_by_sql($query) {
		global $db;
		$result_set = $db->query($query);
		$object_array = array();

		while ($row = $db->fetch_assoc($result_set)) {
			$object_array[] = static::instantiate($row);
		}

		return $object_array;
	}

	protected function attributes() {
		$attributes = array();
		foreach (static::$db_fields as $field) {
			$attributes[$field] = $this->$field;
		}
		return $attributes;
	}

	protected function sanitized_attributes() {
		global $db;
		$attributes = static::attributes();
		foreach ($attributes as $key => $value) {
			$attributes[$key] = $db->escape_string($value);
		}
		return $attributes;
	}


	public function create() {
		global $db;
		$attributes = $this->sanitized_attributes();
		$sql = "INSERT INTO ".static::$table_name." (";
		$sql .= join(", ", array_keys($attributes));
	  	$sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
		if ($db->query($sql)) {
			$this->id = $db->insert_id();
			return true;
		}else {
			return false;
		}
	}

	public function update() {
		global $db;
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
		  $attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE ".static::$table_name." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE id=". $db->escape_string($this->id);
	  $db->query($sql);
	  return ($db->affected_rows() == 1) ? true : false;
	}

	public function delete() {
		global $db;
		
		$query = "DELETE FROM ".static::$table_name." WHERE id =".$db->escape_string($this->id); 
		$db->query($query);
		if ($db->affected_rows() == 1) {
			return true;
		}else {
			return false;
		}
	}

	public function save() {
	  return isset($this->id) ? $this->update() : $this->create();
	}

}


?>