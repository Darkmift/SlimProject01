<?php 

class DB {
	private static $conn;
	private function __construct() {}

	public static function getConnection () {
		if (!self::$conn) {			
			self::$conn = new mysqli('localhost', 'root', '', 'store');
			return self::$conn;
		} else {
			return self::$conn;
		}
	}
}