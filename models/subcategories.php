<?php

$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__). $ds . '..') . $ds;

require_once("{$base_dir}includes{$ds}database.php"); // Including database

Class Sub_Category{
	private $table= 'sub_categories';
	public $id;
	public $sub_category;
	public $category_id;

	public function __construct(){}
	public function validate_params($value){
		return (!empty($value));
	}

	public function check_unique_sub_category(){
		global $database;
		$this->sub_category = trim(htmlspecialchars(strip_tags($this->sub_category)));
		$sql= "SELECT id FROM $this->table WHERE subcategory='".$database->escape_value($this->sub_category)."'";
		$result = $database->query($sql);
		$sub_category_id = $database->fetch_row($result);
		return empty($sub_category_id);
	}

	public function add_sub_category(){
		global $database;
		$this->sub_category = trim(htmlspecialchars(strip_tags($this->sub_category)));
		$this->category_id=trim(htmlspecialchars(strip_tags($this->category_id)));

		$sql = "INSERT INTO $this->table(subCategory, categoryId) VALUES (
			'".$database->escape_value($this->sub_category)."',
			'".$database->escape_value($this->category_id)."'
		)";
		$result = $database->query($sql);

		if($result){
			return true;
		}else{
			return false;
		}
	}

	public function all_sub_categories(){
		global $database;
		$this->category_id = trim(htmlspecialchars(strip_tags($this->category_id)));
		$sql = "SELECT * FROM $this->table  WHERE categoryId ='".$database->escape_value($this->category_id)."' ";
		$result = $database->query($sql);

		return $database->fetch_array($result);
	}
}

$sub_category = new Sub_Category();