<?php

$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__). $ds . '..') . $ds;

require_once("{$base_dir}includes{$ds}database.php"); // Including database

CLass Category{
	private $table= 'categories';
	public $id;
	public $category;
	public $name;

	public function __construct(){}

	public function validate_params($value){
		return (!empty($value));
	}
	public function check_unique_category(){
		global $database;
		$this->category = trim(htmlspecialchars(strip_tags($this->category)));
		$sql= "SELECT id FROM $this->table WHERE category='".$database->escape_value($this->category)."'";
		$result = $database->query($sql);
		$category_id=$database->fetch_row($result);
		return empty($category_id);
	}
	public function add_category(){
		global $database;
		$this->category = trim(htmlspecialchars(strip_tags($this->category)));
		$this->name = trim(htmlspecialchars(strip_tags($this->name)));

		$sql= "INSERT INTO $this->table (category,name) VALUES (
			'".$database->escape_value($this->category)."','".$database->escape_value($this->name)."')";
		$category_saved = $database->query($sql);

		if ($category_saved){
			return true;
		}else{
			return false;
		}
	}

	public function all_categories(){
		global $database;
		$sql = "SELECT * FROM $this->table";
		$result = $database->query($sql);

		return $database->fetch_array($result);
	}
}

$category = new Category();