<?php
namespace BookWorms\Model;

use Exception;
use PDO;

class User {
    public $id;
    public $name;
    public $email;
    public $password;
    public $address_1;
    public $address_2;
    public $city;
    public $country;
    public $postcode;
    public $phone;
    public $role_id;

    function __construct() {
        $this->id = null;
    }

    public function save() {
        try {
            $db = new DB();
            $db->open();
            $conn = $db->get_connection();

            $params = [
                ":name" => $this->name,
                ":email" => $this->email,
                ":password" => $this->password,
                ":address_1" => $this->address_1,
                ":address_2" => $this->address_2,
                ":city" => $this->city,
                ":country" => $this->country,
                ":postcode" => $this->postcode,
                ":phone" => $this->phone,
                ":role_id" => $this->role_id
            ];
            if ($this->id === null) {
                $sql = "INSERT INTO users (name, email, password, address_1, address_2, city, country, postcode, phone, role_id) VALUES (:name, :email, :password, :address_1, :address_2, :city, :country, :postcode, :phone, :role_id)";
            }
            else {
                $sql = "UPDATE users SET name = :name, email = :email, password = :password, address_1 = :address_1, address_2 = :address_2, city = :city, country = :country, postcode = :postcode, phone = :phone, role_id = :role_id WHERE id = :id" ;
                $params[":id"] = $this->id;
            }
            $stmt = $conn->prepare($sql);
            $status = $stmt->execute($params);

            if (!$status) {
                $error_info = $stmt->errorInfo();
                $message = "SQLSTATE error code = ".$error_info[0]."; error message = ".$error_info[2];
                throw new Exception("Database error executing database query: " . $message);
            }

            if ($stmt->rowCount() !== 1) {
                throw new Exception("Failed to save user.");
            }

            if ($this->id === null) {
                $this->id = $conn->lastInsertId();
            }
        }
        finally {
            if ($db !== null && $db->is_open()) {
                $db->close();
            }
        }
    }

    public function saveAdd() {
        try {
            $db = new DB();
            $db->open();
            $conn = $db->get_connection();

            $params = [
                ":address_1" => $this->address_1,
                ":address_2" => $this->address_2,
                ":city" => $this->city,
                ":country" => $this->country,
                ":postcode" => $this->postcode,
                ":phone" => $this->phone
            ];
            if ($this->id === null) {
                $sql = "INSERT INTO users (address_1, address_2, city, country, postcode, phone) VALUES (:address_1, :address_2, :city, :country, :postcode, :phone)";
            }
            else {
                $sql = "UPDATE users SET address_1 = :address_1, address_2 = :address_2, city = :city, country = :country, postcode = :postcode, phone = :phone WHERE id = :id" ;
                $params[":id"] = $this->id;
            }
                
            $stmt = $conn->prepare($sql);
            $status = $stmt->execute($params);

            if (!$status) {
                $error_info = $stmt->errorInfo();
                $message = "SQLSTATE error code = ".$error_info[0]."; error message = ".$error_info[2];
                throw new Exception("Database error executing database query: " . $message);
            }

            if ($stmt->rowCount() !== 1) {
                throw new Exception("Failed to save address.");
            }

            if ($this->id === null) {
                $this->id = $conn->lastInsertId();
            }
        }
        finally {
            if ($db !== null && $db->is_open()) {
                $db->close();
            }
        }
    }

    public function delete() {
        $db = null;
        try {
            if ($this->id !== null) {
                $db = new DB();
                $db->open();
                $conn = $db->get_connection();

                $sql = "DELETE FROM users WHERE id = :id" ;
                $params = [
                    ":id" => $this->id
                ];
                $stmt = $conn->prepare($sql);
                $status = $stmt->execute($params);

                if (!$status) {
                    $error_info = $stmt->errorInfo();
                    $message = "SQLSTATE error code = ".$error_info[0]."; error message = ".$error_info[2];
                    throw new Exception("Database error executing database query: " . $message);
                }

                if ($stmt->rowCount() !== 1) {
                    throw new Exception("Failed to delete user.");
                }
            }
        }
        finally {
            if ($db !== null && $db->is_open()) {
                $db->close();
            }
        }
    }

    public static function findAll() {
        $users = array();

        try {
            $db = new DB();
            $db->open();
            $conn = $db->get_connection();

            $select_sql = "SELECT * FROM users";
            $select_stmt = $conn->prepare($select_sql);
            $select_status = $select_stmt->execute();

            if (!$select_status) {
                $error_info = $select_stmt->errorInfo();
                $message = "SQLSTATE error code = ".$error_info[0]."; error message = ".$error_info[2];
                throw new Exception("Database error executing database query: " . $message);
            }

            if ($select_stmt->rowCount() !== 0) {
                $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
                while ($row !== FALSE) {
                    $user = new User();
                    $user->id = $row['id'];
                    $user->name = $row['name'];
                    $user->email = $row['email'];
                    $user->password = $row['password'];
                    $user->address_1 = $row['address_1'];
                    $user->address_2 = $row['address_2'];
                    $user->city = $row['city'];
                    $user->country = $row['country'];
                    $user->postcode = $row['postcode'];
                    $user->phone = $row['phone'];
                    $user->role_id = $row['role_id'];
                    $users[] = $user;

                    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
                }
            }
        }
        finally {
            if ($db !== null && $db->is_open()) {
                $db->close();
            }
        }

        return $users;
    }

    public static function findById($id) {
        $user = null;

        try {
            $db = new DB();
            $db->open();
            $conn = $db->get_connection();

            $select_sql = "SELECT * FROM users WHERE id = :id";
            $select_params = [
                ":id" => $id
            ];
            $select_stmt = $conn->prepare($select_sql);
            $select_status = $select_stmt->execute($select_params);

            if (!$select_status) {
                $error_info = $select_stmt->errorInfo();
                $message = "SQLSTATE error code = ".$error_info[0]."; error message = ".$error_info[2];
                throw new Exception("Database error executing database query: " . $message);
            }

            if ($select_stmt->rowCount() !== 0) {
                $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
                $user = new User();
                $user->id = $row['id'];
                $user->name = $row['name'];
                $user->email = $row['email'];
                $user->password = $row['password'];
                $user->address_1 = $row['address_1'];
                $user->address_2 = $row['address_2'];
                $user->city = $row['city'];
                $user->country = $row['country'];
                $user->postcode = $row['postcode'];
                $user->phone = $row['phone'];
                $user->role_id = $row['role_id'];
            }
        }
        finally {
            if ($db !== null && $db->is_open()) {
                $db->close();
            }
        }

        return $user;
    }

    public static function findByEmail($email) {
        $user = null;

        try {
            $db = new DB();
            $db->open();
            $conn = $db->get_connection();

            $select_sql = "SELECT * FROM users WHERE email = :email";
            $select_params = [
                ":email" => $email
            ];
            $select_stmt = $conn->prepare($select_sql);
            $select_status = $select_stmt->execute($select_params);

            if (!$select_status) {
                $error_info = $select_stmt->errorInfo();
                $message = "SQLSTATE error code = ".$error_info[0]."; error message = ".$error_info[2];
                throw new Exception("Database error executing database query: " . $message);
            }

            if ($select_stmt->rowCount() !== 0) {
                $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
                $user = new User();
                $user->id = $row['id'];
                $user->name = $row['name'];
                $user->email = $row['email'];
                $user->password = $row['password'];
                $user->address_1 = $row['address_1'];
                $user->address_2 = $row['address_2'];
                $user->city = $row['city'];
                $user->country = $row['country'];
                $user->postcode = $row['postcode'];
                $user->phone = $row['phone'];
                $user->role_id = $row['role_id'];
            }
        }
        finally {
            if ($db !== null && $db->is_open()) {
                $db->close();
            }
        }

        return $user;
    }

    public function updateEmail() {
        try {
            $db = new DB();
            $db->open();
            $conn = $db->get_connection();

            $params = [
                ":email" => $this->email,
            ];

                $sql = "UPDATE users SET email = :email WHERE id = :id" ;
                $params[":id"] = $this->id;
                
            $stmt = $conn->prepare($sql);
            $status = $stmt->execute($params);

            if (!$status) {
                $error_info = $stmt->errorInfo();
                $message = "SQLSTATE error code = ".$error_info[0]."; error message = ".$error_info[2];
                throw new Exception("Database error executing database query: " . $message);
            }

            if ($stmt->rowCount() !== 1) {
                throw new Exception("Failed to save email.");
            }

            if ($this->id === null) {
                $this->id = $conn->lastInsertId();
            }
        }
        finally {
            if ($db !== null && $db->is_open()) {
                $db->close();
            }
        }
    }
}
