<?php
namespace BookWorms\Model;

use Exception;
use PDO;

class Category {
    public $id;
    public $title;

    function __construct() {
        $this->id = null;
    }

    public static function findAll() {
        $categorys = array();

        try {
            $db = new DB();
            $db->open();
            $conn = $db->get_connection();

            $select_sql = "SELECT * FROM category";
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
                    $category = new Category();
                    $category->id = $row['id'];
                    $category->title = $row['title'];

                    $categorys[] = $category;

                    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
                }
            }
        }
        finally {
            if ($db !== null && $db->is_open()) {
                $db->close();
            }
        }

        return $categorys;
    }

    public static function findById($id) {
        $category = null;

        try {
            $db = new DB();
            $db->open();
            $conn = $db->get_connection();

            $select_sql = "SELECT * FROM category WHERE id = :id";
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
                $category = new Category();
                $category->id = $row['id'];
                $category->title = $row['title'];
            }
        }
        finally {
            if ($db !== null && $db->is_open()) {
                $db->close();
            }
        }

        return $category;
    }

    public static function findByArtist($artist_id) {
        $categorys = null;
  
        try {
          $db = new DB();
          $db->open();
          $conn = $db->get_connection();
    
          $select_sql = "SELECT * FROM categorys WHERE artist_id = :artist_id";
          $select_params = [
            ":artist_id" => $artist_id
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
              while ($row !== FALSE) {
                  $category = new Category();
                  $category->id = $row['id'];
                  $category->name = $row['name'];
                  $category->price = $row['price'];
                  $category->availability = $row['availability'];
                  $category->height = $row['height'];
                  $category->width = $row['width'];
                  $category->paper_type = $row['paper_type'];
                  $category->img_id = $row['img_id'];
                  $category->artist_id = $row['artist_id'];
  
                  $categorys[] = $category;
                  $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
  
          }
        }
      }
        finally {
          if ($db !== null && $db->is_open()) {
            $db->close();
          }
        }
    
        return $categorys;
    }

}

?>
