<?php 

namespace BookWorms\Model;

use Exception;
use PDO;

class Card {
    public $id;
    public $card_type;
    public $name;
    public $card_number;
    public $exp_date;
    public $cvv;
    public $user_id;

    public function __construct() {
        $this->id = null;
    }

    public function save() {
      try {
        $db = new DB();
        $db->open();
        $conn = $db->get_connection();
        
        $select_params = [
            "card_type" => $this->card_type,
            ":name" => $this->name,
            ":card_number" => $this->card_number,
            ":exp_date" => $this->exp_date,
            ":cvv" => $this->cvv,
            ":user_id" =>$this->user_id
        ];
        if ($this->id === null) {
          $select_sql = "INSERT INTO card ( card_type, name, card_number, exp_date, cvv, user_id) VALUES (:card_type, :name, :card_number, :exp_date, :cvv,  :user_id)";
        }
        else {
          $select_sql = "UPDATE card SET card_type = :card_type,  name = :name, card_number = :card_number, exp_date = :exp_date, cvv = :cvv, user_id = :user_id WHERE id = :id";
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
          throw new Exception("Failed to save card.");
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

    public static function findByUserId($user_id) {
      $cards = null;
  
      try {
        $db = new DB();
        $db->open();
        $conn = $db->get_connection();
  
        $select_sql = "SELECT * FROM card WHERE user_id = :id";
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
                $card = new Card();
                $card->id = $row['id'];
                $card->name = $row['name'];
                $card->card_number = $row['card_number'];
                $card->exp_date = $row['exp_date'];
                $card->cvv = $row['cvv'];
                $card->card_type = $row['card_type'];
                $card->user_id = $row['user_id'];

                $cards[] = $card;
                $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

        }
      }
    }
      finally {
        if ($db !== null && $db->is_open()) {
          $db->close();
        }
      }
  
      return $cards;
    }
    
    // $cards = array();

    // try {
    //     $db = new DB();
    //     $db->open();
    //     $conn = $db->get_connection();

    //     $select_sql = "SELECT * FROM card WHERE user_id = :id";
    //     $select_params = [
    //       ":id" => $user_id
    //     ];
    //     $select_stmt = $conn->prepare($select_sql);
    //     $select_status = $select_stmt->execute();

    //     if(!$select_status) {
    //         $error_info = $select_stmt->errorInfo();
    //         $message = "SQLSTATE error code = ".$error_info[0]."; error message = ".$error_info[2];
    //         throw new Exception("Database error executing database query: " . $message);
    //     } 

    //     if ($select_stmt->rowCount() !== 0 ) {
    //         $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
    //         while ($row !== FALSE) {
    //             $card = new Card();
    //             $card->id = $row['id'];
    //             $card->name = $row['name'];
    //             $card->card_number = $row['card_number'];
    //             $card->exp_date = $row['exp_date'];
    //             $card->cvv = $row['cvv'];
    //             $card->card_type = $row['card_type'];
    //             $card->user_id = $row['user_id'];

    //             $cards[] = $card;

    //             $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
    //         }
    //     }
    // }
    // finally {
    //     if ($db !== null && $db->is_open()) {
    //         $db->close();
    //     }
    // }

    // return $cards;
  // }

  public static function findById($id) {
    $card = null;

    try {
        $db = new DB();
        $db->open();
        $conn = $db->get_connection();

        $select_sql = "SELECT * FROM card WHERE id = :id";
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
            $card = new card();
            $card->id = $row['id'];
            $card->name = $row['name'];
            $card->card_number = $row['card_number'];
            $card->exp_date = $row['exp_date'];
            $card->cvv = $row['cvv'];
            $card->card_type = $row['card_type'];
            $card->user_id = $row['user_id'];
        }
    }
      finally {
          if ($db !== null && $db->is_open()) {
              $db->close();
          }
      }

      return $card;
  }

}
?>