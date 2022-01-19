<?php

$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__). $ds . '..') . $ds;

require_once("{$base_dir}includes{$ds}database.php"); // Including database
require_once("{$base_dir}includes{$ds}bcrypt.php"); // Including Bcrypt

// Class Users Start
class User
{
    private $table = 'users';

    public $id;
    public $name;
    public $email;
    public $password;
    public $gender;
    public $image;
    public $address;

    // contructor
    public function __construct()
    {
    }

    // validating if params exists or not
    public function validate_params($value)
    {
        return (!empty($value));
    }

    // to check if email is unique or not
    public function check_unique_email()
    {
        global $database;

        $this->email = trim(htmlspecialchars(strip_tags($this->email)));

        $sql = "SELECT id FROM $this->table WHERE email = '" .$database->escape_value($this->email). "'";

        $result = $database->query($sql);
        $user_id = $database->fetch_row($result);

        return empty($user_id);
    }

    // saving new data in our database
    public function register_user()
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

        $users_saved = $database->query($sql);

        $sql_2 = "SELECT id FROM $this->table where email ='".$database->escape_value($this->email)."'";
        $user_id_retrived= $database->query($sql_2);

        if ($users_saved) {
            $user_id = $database->fetch_row($user_id_retrived);
            return $user_id;
        } else {
            return false;
        }
    }

    public function getUserDetails(){
        global $database;
        $this->id = trim(htmlspecialchars(strip_tags($this->id)));
        $sql= "SELECT id,name,email,password,gender,image,address FROM $this->table WHERE id ='".$database->escape_value($this->id)."'";
        $result= $database->query($sql);
        $user=$database->fetch_row_list($result);
        return $user;
    }
    // login function
    public function login()
    {
        global $database;

        $this->email = trim(htmlspecialchars(strip_tags($this->email)));
        $this->password = trim(htmlspecialchars(strip_tags($this->password)));

        $sql = "SELECT id,name,email,password,gender,image,address FROM $this->table WHERE email = '" .$database->escape_value($this->email). "'";

        $result = $database->query($sql);
        $user = $database->fetch_row($result);

        if (empty($user)) {
            return "User doesn't exist.";
        } else {
            if (Bcrypt::checkPassword($this->password, $user['password'])) {
                return $user;
            } else {
                return "Password doesn't match.";
            }
        }
    }

    // method to return the list of Users
    public function all_users() {
        global $database;

        $sql = "SELECT id, name,email,password, gender, image, address FROM $this->table";

        $result = $database->query($sql);

        return $database->fetch_array($result);
    }
} // Class Ends

// User object
$user = new User();