<?php
namespace BookWorms\Model;

use Exception;
use PDO;

class Product {
    public $id;
    public $name;
    public $price;
    public $availability;
    public $height;
    public $width;
    public $paper_type;
    public $img_id;
    public $artist_id;

    function __construct() {
        $this->id = null;
    }

    public static function findAll() {
        $products = array();

        try {
            $db = new DB();
            $db->open();
            $conn = $db->get_connection();

            $select_sql = "SELECT * FROM products";
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
                    $product = new Product();
                    $product->id = $row['id'];
                    $product->name = $row['name'];
                    $product->price = $row['price'];
                    $product->availability = $row['availability'];
                    $product->height = $row['height'];
                    $product->width = $row['width'];
                    $product->paper_type = $row['paper_type'];
                    $product->img_id = $row['img_id'];
                    $product->artist_id = $row['artist_id'];

                    $products[] = $product;

                    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
                }
            }
        }
        finally {
            if ($db !== null && $db->is_open()) {
                $db->close();
            }
        }

        return $products;
    }

    public static function findById($id) {
        $product = null;

        try {
            $db = new DB();
            $db->open();
            $conn = $db->get_connection();

            $select_sql = "SELECT * FROM products WHERE id = :id";
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
                $product = new Product();
                $product->id = $row['id'];
                $product->name = $row['name'];
                $product->price = $row['price'];
                $product->availability = $row['availability'];
                $product->height = $row['height'];
                $product->width = $row['width'];
                $product->paper_type = $row['paper_type'];
                $product->img_id = $row['img_id'];
                $product->artist_id = $row['artist_id'];
            }
        }
        finally {
            if ($db !== null && $db->is_open()) {
                $db->close();
            }
        }

        return $product;
    }

    public static function findByArtist($artist_id) {
        $products = null;
  
        try {
          $db = new DB();
          $db->open();
          $conn = $db->get_connection();
    
          $select_sql = "SELECT * FROM products WHERE artist_id = :artist_id";
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
                  $product = new Product();
                  $product->id = $row['id'];
                  $product->name = $row['name'];
                  $product->price = $row['price'];
                  $product->availability = $row['availability'];
                  $product->height = $row['height'];
                  $product->width = $row['width'];
                  $product->paper_type = $row['paper_type'];
                  $product->img_id = $row['img_id'];
                  $product->artist_id = $row['artist_id'];
  
                  $products[] = $product;
                  $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
  
          }
        }
      }
        finally {
          if ($db !== null && $db->is_open()) {
            $db->close();
          }
        }
    
        return $products;
    }

    public static function findByCat($catId) {
        $products = null;
  
        try {
          $db = new DB();
          $db->open();
          $conn = $db->get_connection();
          $select_sql = "SELECT * FROM products JOIN prod_cat ON prod_cat.prod_id = products.id WHERE cat_id = :catId";
          $select_params = [
            ":catId" => $catId
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
                  $product = new Product();
                  $product->id = $row['id'];
                  $product->name = $row['name'];
                  $product->price = $row['price'];
                  $product->availability = $row['availability'];
                  $product->height = $row['height'];
                  $product->width = $row['width'];
                  $product->paper_type = $row['paper_type'];
                  $product->img_id = $row['img_id'];
                  $product->artist_id = $row['artist_id'];
  
                  $products[] = $product;
                  $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
  
          }
        }
      }
        finally {
          if ($db !== null && $db->is_open()) {
            $db->close();
          }
        }
    
        return $products;
    }

    public static function findByOrder($id){
      $product = null;

      try {
        $db = new DB();
        $db->open();
        $conn = $db->get_connection();
  
        $select_sql = "SELECT * FROM products JOIN orderproduct ON orderproduct.prod_id = products.id WHERE order_id = :id";
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
          $product = new Product();
          $product->id = $row['id'];
          $product->name = $row['name'];
          $product->price = $row['price'];
          $product->availability = $row['availability'];
          $product->height = $row['height'];
          $product->width = $row['width'];
          $product->paper_type = $row['paper_type'];
          $product->img_id = $row['img_id'];
          $product->artist_id = $row['artist_id'];
      }
    }
      finally {
        if ($db !== null && $db->is_open()) {
          $db->close();
        }
      }
  
      return $product;
  }
    

}

?>
