<?php 

namespace BookWorms\Model;

use Exception;
use PDO;

class Image {
    public $id;
    public $filename;

    public function __construct() {
        $this->id = null;
    }

    public function save() {
      try {
        $db = new DB();
        $db->open();
        $conn = $db->get_connection();
        
        $select_params = [
          ":filename" => $this->filename
        ];
        if ($this->id === null) {
          $select_sql = "INSERT INTO images (filename) VALUES (:filename)";
        }
        else {
          $select_sql = "UPDATE images SET filename = :filename WHERE id = :id";
          $select_params[":id"] = $this->id;
        }

        $select_stmt = $conn->prepare($select_sql);
        $select_status = $select_stmt->execute($select_params);

        if (!$select_status) {
          $error_info = $select_stmt->errorInfo();
          $message = "SQLSTATE error code = ".$error_info[0]."; error message = ".$error_info[2];
          throw new Exception("Database error executing database query: " . $message);
        }

        if ($select_stmt->rowCount() !== 1) { 
          throw new Exception("Failed to save image.");
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

    public static function findById($id) {
      $image = null;
  
      try {
        $db = new DB();
        $db->open();
        $conn = $db->get_connection();
  
        $select_sql = "SELECT * FROM images WHERE id = :id";
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
          $image = new Image();
          $image->id = $row['id'];
          $image->filename = $row['filename'];
        }
      }
      finally {
        if ($db !== null && $db->is_open()) {
          $db->close();
        }
      }
  
      return $image;
    }
}
?>