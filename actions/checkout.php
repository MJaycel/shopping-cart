<?php require_once '../config.php'; ?>
<?php 

if (!$request->is_logged_in()) {
    $request->redirect("/views/auth/login-form.php");
  }
  else {
    $role = $request->session()->get("role");
    if($role !== "customer") {
      $request->redirect("/views"."/".$role."/home.php");
    }
  }

use BookWorms\Model\Cart;
use BookWorms\Model\Card;
use BookWorms\Model\User;
use BookWorms\Model\Order;
use BookWorms\Model\OrderProduct;

$email = $request->session()->get("email");
$user = User::findByEmail($email);

try {
    $cart = Cart::get($request);
    if ($cart->empty()) {
        throw new Exception ("Your cart is empty");
    }
    $rules = [
        "card_id" => "present|integer|min:0|maxlength:15"
    ];
    $request->validate($rules);
    if (!$request->is_valid()) {
        throw new Exception("Please select a payment method//ILLEGAL REQUEST");
    }

    $card_id = intval($request->input("card_id"));

    if ($card_id === 0) {
        $rules = [
            "card_type" => "present|in:visa,master-card,american-express",
            "name" => "present|minlength:6|maxlength:90",
            "card_number"  => "present|minlength:10|maxlength:32",
            "exp_date" => "present|match:/\A[0-9]{2}\/[0-9]{2}\Z/",
            // "exp_date" => "present|date",
            "cvv" => "present|match:/\A[0-9]{3}\Z/",
        ];
        $request->validate($rules);
        if(!$request->is_valid()) {
            throw new Exception("Please check your credit card details");
        }

        $card = new Card();
        $card->card_type = $request->input("card_type");
        $card->name = $request->input("name");
        $card->card_number = $request->input("card_number");
        $card->exp_date = $request->input("exp_date");
        $card->cvv = $request->input("cvv");
        $card->user_id = $user->id;

        $card->save();
    }
    else {
        $card = Card::findById($card_id);
        if($card === null || $card->user_id !== $user->id) {
            throw new Exception ("Invalid credit card");
        }
    }

    $order = new Order();
    $order->ord_date = date("Y-m-d");
    $order->status = 'new';
    $order->card_id = $card->id;
    $order->save();

    foreach ($cart->items as $item) {
        $orderProduct = new OrderProduct();
        $orderProduct->quantity = $item->quantity;
        $orderProduct->order_id = $order->id;
        $orderProduct->prod_id = $item->product->id;
        $orderProduct->save();
    }

    $cart->clear();

    $request->session()->forget("flash_data");
    $request->session()->forget("flash_errors");

    $request->redirect("/views"."/".$role."/home.php");

}catch (Exception $ex){
    $request->session()->set("flash_message", $ex->getMessage());
    $request->session()->set("flash_message_class", "alert-warning");
    $request->session()->set("flash_data", $request->all());
    $request->session()->set("flash_errors", $request->errors());

    $request->redirect("/views/cart-payment.php");
}

?>