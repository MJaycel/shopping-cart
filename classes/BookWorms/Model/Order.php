<?php 
namespace BookWorms\Model;

use Exception;
use PDO;

class Order {

    public $id;
    public $ord_date;
    public $status;
    public $card_id;

    function __construct() {
        $this->id = null;
    }

    public function save() {
        try {
            $db = new DB();
            $db->open();
            $conn = $db->get_connection();

            $params = [
                ":ord_date" => $this->ord_date,
                ":status" => $this->status,
                ":card_id" => $this->card_id
            ];
            if ($this->id === null) {
                $sql = "INSERT INTO orders (ord_date,status, card_id) 
                VALUES (:ord_date,:status, :card_id)";
            }
            else {
                $sql = "UPDATE orders SET ord_date = :ord_date, status = :status, card_id = :card_id
                WHERE id = :id" ;
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
                throw new Exception("Failed to save Order.");
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

    public function delivery() {
        try {
            $db = new DB();
            $db->open();
            $conn = $db->get_connection();

            $params = [
                ":shipping_price" => $this->shipping_price,

            ];
            if ($this->id === null) {
                $sql = "INSERT INTO orders (shipping_price) 
                VALUES ( :shipping_price)";
            }
            else {
                $sql = "UPDATE orders SET shipping_price = :shipping_price
                WHERE id = :id" ;
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
                throw new Exception("Failed to save Order.");
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

    public static function findByUser($id){
        $orders = null;
  
        try {
          $db = new DB();
          $db->open();
          $conn = $db->get_connection();
    
          $select_sql = "SELECT * FROM `orders` JOIN card ON orders.card_id = card.id WHERE card.user_id = :id";
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
              while ($row !== FALSE) {
                  $order = new Order();
                  $order->id = $row['id'];
                  $order->ord_date = $row['ord_date'];
                  $order->status = $row['status'];
                  $order->card_id = $row['card_id'];
  
                  $orders[] = $order;
                  $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
  
          }
        }
      }
        finally {
          if ($db !== null && $db->is_open()) {
            $db->close();
          }
        }
    
        return $orders;
    }
    
    
}
?>