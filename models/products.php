<?php

$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__). $ds . '..') . $ds;

require_once("{$base_dir}includes{$ds}database.php"); // Including database

class Product{

	private $table = 'products';

	public $id;
	public $sellerId;
	public $subCategoryId;
	public $name;
	public $price;
	public $quantity;
	public $description;
	public $image;
	public $popularityCount;

	public function __construct(){

	}

	public function validate_params($value)
	{
		return (!empty($value));
	}

	public function check_unique_product(){
		global $database;
		$this->sellerId = trim(htmlspecialchars(strip_tags($this->sellerId)));
		$this->subCategoryId = trim(htmlspecialchars(strip_tags($this->subCategoryId)));
		$this->name = trim(htmlspecialchars(strip_tags($this->name)));

		$sql= "SELECT name FROM $this->table WHERE sellerId='".$database->escape_value($this->sellerId)."' AND subCategoryId ='".$database->escape_value($this->subCategoryId)."' AND name='".$database->escape_value($this->name)."'";
		$result = $database->query($sql);
		$product_name = $database->fetch_row($result);
		return empty($product_name);
	}

	public function add_products(){
		global $database;

		$this->sellerId = trim(htmlspecialchars(strip_tags($this->sellerId)));
		$this->subCategoryId = trim(htmlspecialchars(strip_tags($this->subCategoryId)));
		$this->name = trim(htmlspecialchars(strip_tags($this->name)));
		$this->price = trim(htmlspecialchars(strip_tags($this->price)));
		$this->quantity = trim(htmlspecialchars(strip_tags($this->quantity)));
		$this->description = trim(htmlspecialchars(strip_tags($this->description)));
		$this->image = trim(htmlspecialchars(strip_tags($this->image)));

		$sql = "INSERT INTO $this->table (sellerId, subCategoryId,name,price, quantity, description, image) VALUES (
			'".$database->escape_value($this->sellerId)."',
			'".$database->escape_value($this->subCategoryId)."',
			'".$database->escape_value($this->name)."',
			'".$database->escape_value($this->price)."',
			'".$database->escape_value($this->quantity)."',
			'".$database->escape_value($this->description)."',
			'".$database->escape_value($this->image)."'

			)";
		$result = $database->query($sql);

		if($result){
			return true;
		}else {
			return false;
		}
	}

	public function update_product(){
		global $database;

		$this->id = trim(htmlspecialchars(strip_tags($this->id)));
		$this->sellerId = trim(htmlspecialchars(strip_tags($this->sellerId)));
		$this->subCategoryId = trim(htmlspecialchars(strip_tags($this->subCategoryId)));
		$this->name = trim(htmlspecialchars(strip_tags($this->name)));
		$this->price = trim(htmlspecialchars(strip_tags($this->price)));
		$this->quantity = trim(htmlspecialchars(strip_tags($this->quantity)));
		$this->description = trim(htmlspecialchars(strip_tags($this->description)));
		$this->image = trim(htmlspecialchars(strip_tags($this->image)));
	}


	public function get_products_per_seller(){
		global $database;

		$this->sellerId= trim(htmlspecialchars(strip_tags($this->sellerId)));

		$sql = "SELECT products.id, products.sellerId,sellers.name as 'sellerName', sellers.address as 'sellerAddress', sellers.image as 'sellerImage' , sellers.gender, products.subCategoryId,products.name as 'productName', products.price, products.quantity, products.description, products.image as 'productImage' , products.popularityCount, categories.category, sub_categories.categoryId, sub_categories.subCategory FROM sellers join $this->table  on sellers.id = products.sellerId join sub_categories on products.subCategoryId = sub_categories.id join categories on sub_categories.categoryId = categories.id where products.sellerId='".$database->escape_value($this->sellerId)."'";
		$result = $database->query($sql);
		return $database->fetch_array($result);
	}

	public function get_product_per_sub_category(){
		global $database;
		$this->subCategoryId = trim(htmlspecialchars(strip_tags($this->subCategoryId)));
		$sql = "SELECT products.id, products.sellerId,sellers.name as 'sellerName', sellers.address as 'sellerAddress', sellers.image as 'sellerImage' , sellers.gender, products.subCategoryId,products.name as 'productName', products.price, products.quantity, products.description, products.image as 'productImage' , products.popularityCount, categories.category, sub_categories.categoryId, sub_categories.subCategory FROM sellers join $this->table on sellers.id = products.sellerId join sub_categories on products.subCategoryId = sub_categories.id join categories on sub_categories.categoryId = categories.id where products.subCategoryId='".$database->escape_value($this->subCategoryId)."'";
		$result = $database->query($sql);
		return $database->fetch_array($result);

	}

}

$product = new Product();