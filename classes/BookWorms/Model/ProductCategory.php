<?php 
namespace BookWorms\Model;

use Exception;
use PDO;

class ProductCategory {
    public $id;
    public $prod_id;
    public $cat_id;

    function __construct() {
        $this->id = null;
    }

public static function findCategory($product) {
    $category = null;

    try {
        $db = new DB();
        $db->open();
        $conn = $db->get_connection();

        $select_sql = "SELECT cat_id FROM prod_cat WHERE prod_id = :id ORDER BY RAND() LIMIT 1";
        $select_params = [
            ":id" => $product
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
            $category = new ProductCategory();
            $category->id = $row['id'] ?? "";
            $category->prod_id = $row['prod_id'] ?? "";
            $category->cat_id = $row['cat_id'];
        }
    }
    finally {
        if ($db !== null && $db->is_open()) {
            $db->close();
        }
    }

    return $category;
  }
}
?>
<!-- "SELECT cat_id FROM prod_cat WHERE prod_id = :id ORDER BY RAND() LIMIT 1"; -->
