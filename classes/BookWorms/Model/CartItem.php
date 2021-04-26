<?php

namespace BookWorms\Model;

class CartItem {
  public $product;
  public $quantity;

  public function __construct($product, $qty) {
    $this->product = $product;
    $this->quantity = $qty;
  }
}