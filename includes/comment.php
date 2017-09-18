<?php 
require_once LIB_PATH.DS.'conn.php';


class Comment extends DatabaseObject {
	public $id;
	public $photograph_id;
	public $author;
	public $body;
	public $created;

	protected static $db_fields = array('id', 'photograph_id', 'author', 'body', 'created');
	protected static $table_name = 'comments';

	public static function make($photo_id, $author, $body) {
		if(!empty($photo_id) && !empty($author) && !empty($body)) {
			$comment = new Comment();
			$comment->body = $body;
			$comment->photograph_id = $photo_id;
			$comment->author = $author;
			$comment->created = strftime("%Y-%m-%d %H:%M:%S", time());
			return $comment;
		} else {
			return false;
		}
	}

	public static function find_comments_on($photo_id) {
		global $db;
		$photo_id = $db->escape_string($photo_id); 
		$query = "SELECT * FROM " . static::$table_name;
		$query .= " WHERE `photograph_id` = '$photo_id'";
		$query .= " ORDER BY `created` ASC";
		return static::find_by_sql($query);
	}
	
}