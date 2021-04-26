<?php 
namespace BookWorms\Model;

use Exception;
use PDO;

class OrderProduct {

    public $id;
    public $quantity;
    public $order_id;
    public $prod_id;

    function __construct() {
        $this->id = null;
    }

    public function save() {
        try {
            $db = new DB();
            $db->open();
            $conn = $db->get_connection();

            $params = [
                ":quantity" => $this->quantity,
                ":order_id" => $this->order_id,
                ":prod_id" => $this->prod_id,

            ];
            if ($this->id === null) {
                $sql = "INSERT INTO orderproduct (quantity, order_id, prod_id) 
                VALUES (:quantity, :order_id, :prod_id)";
            }
            else {
                $sql = "UPDATE orderproduct SET quantity = :quantity, order_id = :order_id , prod_id = :prod_id WHERE id = :id" ;
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
                throw new Exception("Failed to save Product Order.");
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

     public static function findByUser($user_id){
        $orderproducts = null;
  
        try {
          $db = new DB();
          $db->open();
          $conn = $db->get_connection();
    
          $select_sql = "SELECT orders.ord_date, orders.status, orderproduct.quantity,products.name FROM `orders` JOIN orderproduct ON orderproduct.order_id = orders.id 
          JOIN products ON orderproduct.prod_id = products.id JOIN card ON  orders.card_id = card.id WHERE card.user_id =:id";
          $select_params = [
            ":id" => $user_id
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
                  $orderproduct = new OrderProduct();
                //   $orderproduct->id = $row['id'];
                  $orderproduct->quantity = $row['quantity'];
                //   $orderproduct->order_id = $row['order_id'];
                //   $orderproduct->prod_id = $row['prod_id'];
  
                  $orderproducts[] = $orderproduct;
                  $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
  
          }
        }
      }
        finally {
          if ($db !== null && $db->is_open()) {
            $db->close();
          }
        }
    
        return $orderproducts;
    }


}
?>