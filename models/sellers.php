<?php

$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__). $ds . '..') . $ds;

require_once("{$base_dir}includes{$ds}database.php"); // Including database
require_once("{$base_dir}includes{$ds}bcrypt.php"); // Including Bcrypt

Class Seller{

	private $table = 'sellers';
	public $id;
	public $name;
	public $email;
	public $password;
	public $gender;
	public $address;
	public $image;

	public function __construct(){}

	public function validate_params($value)
	{
		return (!empty($value));
	}

	public function check_unique_email()
    {
        global $database;

        $this->email = trim(htmlspecialchars(strip_tags($this->email)));

        $sql = "SELECT id FROM $this->table WHERE email = '" .$database->escape_value($this->email). "'";

        $result = $database->query($sql);
        $seller_id = $database->fetch_row($result);

        return empty($seller_id);
    }

     public function register_seller()
    {
        global $database;

        $this->name = trim(htmlspecialchars(strip_tags($this->name)));
        $this->email = trim(htmlspecialchars(strip_tags($this->email)));
        $this->password = trim(htmlspecialchars(strip_tags($this->password)));
        $this->gender = trim(htmlspecialchars(strip_tags($this->gender)));
        $this->image = trim(htmlspecialchars(strip_tags($this->image)));
        $this->address = trim(htmlspecialchars(strip_tags($this->address)));

        $sql = "INSERT INTO $this->table (name, email, password, gender, image, address) VALUES (
            '" .$database->escape_value($this->name). "',
            '" .$database->escape_value($this->email). "',
            '" .$database->escape_value(Bcrypt::hashPassword($this->password)). "',
            '" .$database->escape_value($this->gender). "',
            '" .$database->escape_value($this->image). "',
            '" .$database->escape_value($this->address). "'
        )";

        $seller_saved = $database->query($sql);

        $sql_2 = "SELECT id FROM $this->table where email ='".$database->escape_value($this->email)."'";
        $seller_id_result= $database->query($sql_2);

        if ($seller_saved) {
            $seller_id = $database->fetch_row($seller_id_result);
            return $seller_id;
        } else {
            return false;
        }
    }

    public function login()
    {
        global $database;

        $this->email = trim(htmlspecialchars(strip_tags($this->email)));
        $this->password = trim(htmlspecialchars(strip_tags($this->password)));

        $sql = "SELECT id,name,email,password,gender,image,address FROM $this->table WHERE email = '" .$database->escape_value($this->email). "'";

        $result = $database->query($sql);
        $seller = $database->fetch_row($result);

        if (empty($seller)) {
            return "Seller doesn't exist.";
        } else {
            if (Bcrypt::checkPassword($this->password, $seller['password'])) {
                return $seller;
            } else {
                return "Password doesn't match.";
            }
        }
    }

    public function all_sellers() {
        global $database;

        $sql = "SELECT id, name, email, gender, image, address FROM $this->table";

        $result = $database->query($sql);

        return $database->fetch_array($result);
    }



}
$seller = new Seller();
