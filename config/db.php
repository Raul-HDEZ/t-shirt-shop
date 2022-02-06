<?php

class Database{
	public static function connect(){
		//$db = new mysqli($_SERVER["endpoint"], $_SERVER["user"], $_SERVER["password"], $_SERVER["db"]);
		$db = new mysqli('localhost', 'raul', 'raul', 'camisetas_master');
		//$db = new mysqli('localhost', 'root', 'root', 'tienda_master');
		$db->query("SET NAMES 'utf8'");
		return $db;
	}
}