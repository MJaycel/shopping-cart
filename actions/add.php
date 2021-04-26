<?php require_once '../config.php'?>
<?php 

if ($request->is_logged_in()) {
    $role = $request->session()->get("role");
    if ($role !== "customer") {
        $request->redirect("/views" . "/". $role ."/index.php");
    }
}

use BookWorms\Model\Product;
use BookWorms\Model\Cart;

try {
    $rules = [
        "id" => "present|integer|min:1",
        "qty" => "present|integer|min:1"
    ];
    $request->validate($rules);
    if(!$request->is_valid()) {
        throw new Exception("Something went wrong!");
    }
    $quantity = intval($request->input("qty"));
    $id = intval($request->input("id"));

    $product = Product::findById($id);
    if($product === null) {
        throw new Exception("Cant find Product!");
    }

    $cart = Cart::get($request);
    $cart->add($product, $quantity);

    $request->session()->set("flash_message", "A copy of '".$product->title."' added to your cart");
    $request->session()->set("flash_message_class", "alert-info");

    $referer = $_SERVER['HTTP_REFERER'];
    header("Location: $referer");
}
catch (Exception $ex){
    $request->session()->set("flash_message", $ex->getMessage());
    $request->session()->set("flash_message_class", "alert-warning");

    $referer = $_SERVER['HTTP_REFERER'];
    header("Location: $referer");
}

?>