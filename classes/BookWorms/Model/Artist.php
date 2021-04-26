<?php
namespace BookWorms\Model;

use Exception;
use PDO;

class Artist {
    public $id;
    public $name;

    function __construct() {
        $this->id = null;
    }

    public static function findAll() {
        $artist = array();

        try {
            $db = new DB();
            $db->open();
            $conn = $db->get_connection();

            $select_sql = "SELECT * FROM artists";
            $select_stmt = $conn->prepare($select_sql);
            $select_status = $select_stmt->execute();

            if(!$select_status) {
                $error_info = $select_stmt->errorInfo();
                $message = "SQLSTATE error code = ".$error_info[0]."; error message = ".$error_info[2];
                throw new Exception("Database error executing database query: " . $message);
            } 

            if ($select_stmt->rowCount() !== 0 ) {
                $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
                while ($row !== FALSE) {
                    $artist = new Product();
                    $artist->id = $row['id'];
                    $artist->name = $row['name'];

                    $artists[] = $artist;

                    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
                }
            }
        }
        finally {
            if ($db !== null && $db->is_open()) {
                $db->close();
            }
        }

        return $artists;
    }

    public static function findById($id) {
        $product = null;

        try {
            $db = new DB();
            $db->open();
            $conn = $db->get_connection();

            $select_sql = "SELECT * FROM artists WHERE id = :id";
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
                $artist = new Artist();
                $artist->id = $row['id'];
                $artist->name = $row['name'];
            }
        }
        finally {
            if ($db !== null && $db->is_open()) {
                $db->close();
            }
        }

        return $artist;
    }

}

?>
