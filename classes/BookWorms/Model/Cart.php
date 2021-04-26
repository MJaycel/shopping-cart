<?php
namespace BookWorms\Model;

class Cart {

  public static function get($request) {
    $session = $request->session();
    if ($session->has("cart")) {
      $cart = $session->get("cart");
    }
    else {
      $cart = new Cart();
      $session->set("cart", $cart);
    }
    return $cart;
  }

  public $items;

  public function __construct() {
    $this->items = array();
  }

  public function add($product, $quantity) {
    if (!$product instanceof Product || $quantity <= 0) {
      throw new Exception("Illegal argument");
    }
    if (array_key_exists($product->id, $this->items)) {
      $item = $this->items[$product->id];
      $item->quantity = ($item->quantity + $quantity);
    }
    else {
      $item = new CartItem($product, $quantity);
      $this->items[$product->id] = $item;
    }
  }

  public function remove($product, $quantity) {
    if (!$product instanceof Product || $quantity <= 0) {
      throw new Exception("Illegal argument");
    }
    if (!array_key_exists($product->id, $this->items)) {
      throw new Exception("Illegal argument");
    }
    $item = $this->items[$product->id];
    $item->quantity = ($item->quantity - $quantity);
    if ($item->quantity <= 0) {
      unset($this->items[$product->id]);
    }
  }

  public function set($product, $quantity) {
    if (!$product instanceof Product || $quantity < 0) {
      throw new Exception("Illegal argument");
    }
    if (!array_key_exists($product->id, $this->items)) {
      throw new Exception("Illegal argument");
    }
    $item = $this->items[$product->id];
    $item->quantity = $quantity;
    if ($item->quantity <= 0) {
      unset($this->items[$product->id]);
    }
  }

  public function empty() {
    return count($this->items) === 0;
  }

  public function size() {
    return count($this->items);
  }
  public function clear() {
    $this->items = array();
  }
}