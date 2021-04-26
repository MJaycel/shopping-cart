<?php require_once '../config.php'; ?>
<?php 

if ($request->is_logged_in()) {
    $role = $request->session()->get("role");
    if ($role !== "customer") {
        $request->redirect("/views"."/"/$role."/home.php");
    }
}

use BookWorms\Model\Cart;
use BookWorms\Model\Image;
use BookWorms\Model\Artist;
use BookWorms\Model\Order;

$cart = Cart::get($request);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Amry Chambers Prints</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" 
  integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">

  <link  rel="stylesheet" href="../assets/css/mystyle.css"/>

  <script>
      function selectChange(val) {
          //Set the value of action in action attribute of form element.
          //Submit the form
          $('#myForm').submit();
      }
  </script>

</head>
<body>


    <?php require 'include/navbar.php' ;?>
    <?php require 'include/flash.php'; ?>

  <main role="main">
  <div>
    <?php if($cart->empty()) { ?> 
    <div class="container-fluid d-flex justify-content-center">
    <div class="row">
      <div class="col">
        <div class="card p-5 m-5 cart__empty">
        <div class="card-body">
          <img src="<?= APP_URL?>/images/empty.svg" alt="" style="width:100%">
          <p class="empty__cart">Your shopping cart is empty</p> 
          
          <div class="d-flex justify-content-center p-2">
            <form action="<?= APP_URL?>/prints.php">
          <button class="continue__shopping">
              Continue Shopping
            </button>
          </form>
                        
          </div>

        </div>
        </div>
      </div>
    </div>
  </div>
    <?php } else { ?>

  <div class="container">
    <div class="row d-flex justify-content-center">
      <div class="card">
        <div class="col d-flex align-items-start flex-wrap">

          <div class="col-sm-8" style="padding-right:0px!important">
            <div class="card cart__items">
              <div class="card-body">
                <div class="container">
                <div class="row">
                  <table class="table">
                    <thead>
                      <tr>
                        <th class="col-sm-4 cart__head cart__heading-hidden" style="padding:0px!important"></th>
                        <th class="col-sm-3 cart__heading-hidden"></th>

                        <th class="col-sm-2 cart__head cart__heading-hidden">Quantity</th>
                        <th class="col-sm-2 cart__head cart__heading-hidden">Price</th>
                        <th class="col-sm-1 cart__head cart__heading-hidden">Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                        $subtotal = 0;
                        foreach ($cart->items as $item) {
                          $subtotal += ($item->product->price * $item->quantity);

                          $images = Image::findById($item->product->img_id); 
                          $artists = Artist::findById($item->product->artist_id);
                      ?>  

                      <tr>
                        <td class="d-flex justify-content-end">
                        <img class="cart__item-img" src="<?= APP_URL ?>/images/<?= $images->filename?>" alt="">
                        </td>

                        <td>
                        <ul class="list__nostyle d-flex align-items-start flex-column">
                              <div class="">
                              <li class="cart_body-heading"><?= $item->product->name?></li>
                              <li class="cart_body-text"><?= $artists->name ?></li>
                              </div>

                              <li class="cart_avail-text mt-auto">
                                <?php 
                                  $outOfStock = "Out of Stock";
                                  $inStock = "In stock";
                                  if($item->product->availability == $outOfStock) { ?>
                                  <p class="out-of-stock__cart upper"><?= $item->product->availability?></p>
                                  <?php } elseif($item->product->availability == $inStock) { ?> 
                                    <p class="in-stock__cart upper"><?= $item->product->availability?></p>
                                <?php }?>
                              </li>
                          </ul>
                        </td>
                        
                        <td>
                          <div class="cart__quantity">
                            <div class="mt-1">
                              <form method="post" style="width:50px;background:rgba(196, 196, 196, 0.19);" class="d-flex align-items-center">
                                <input type="hidden" name="id" value="<?= $item->product->id ?>">
                                  <p style="width:30px;" class="d-flex justify-content-center cart__qty"><?=$item->quantity?></p>
                                  <div class="btn-group-vertical">
                                    <button class="qty__update-btn" type="submit" formaction="<?= APP_URL ?>/actions/cart-add.php" style="width:25px;"> 
                                    <span><img src="<?= APP_URL ?>/images/arrow_up.svg" alt=""></span>
                                    </button>
                                    <button class="qty__update-btn down__btn" type="submit" formaction="<?= APP_URL ?>/actions/cart-delete.php" style="width:25px;"> 
                                    <span><img src="<?= APP_URL ?>/images/arrow_down.svg" alt=""></span>
                                    </button> 
                                  </div>
                              </form>
                            </div>
                          </div>                      
                        </td>

                        <td> 
                          <p class="cart__price cart__heading-hidden text-muted">€<?= $item->product->price?></p>
                        </td>

                        <td>
                          <p class="cart__total">€<?= $item->product->price * $item->quantity?> </p> 
                      
                        </td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
                </div>
              </div>
            </div>          
          </div>

          <div class="col-sm-3" style="padding-left:0!important;">
              <div class="card cart__summary bg-transparent">
                <div class="card-body">
                  <table class="table borderless">
                    <thead>
                        <tr>
                          <th class="cart__summary__heading">
                            ORDER SUMMARY
                          </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                          <th class="cart_sub">Subtotal</th>
                          <td>€<?=  $subtotal ?></td>
                        </tr>
                        <tr>
                          <th class="cart_sub">Delivery
                              <form method="post" id="myForm">
                                  <select name="select" class="select__delivery"  onchange="this.form.submit();">
                                  <?php
                                  $example = $_POST["select"];
                                  $shipping = 0;
                              ?>
                                      <option selected = "selected">Please choose delivery option</option>

                                      <option <?php if (isset($example) && $example=="Standard Delivery $6.00") echo "selected";?>>Standard Delivery $6.00</option>
                                      <option <?php if (isset($example) && $example=="Next Day Delivery $15.00") echo "selected";?>>Next Day Delivery $15.00</option>
                                      <option <?php if (isset($example) && $example=="International Tracked $20.00") echo "selected";?>>International Tracked $20.00</option>
                                  </select>
                                  <!-- <input type="submit" name="submit" value="submit" /> -->
                              </form>
                              <p class="delivery_info mt-1">Dispatched in 7-10 business days</p>
                            <?php 
                              $shipping_price = 0;
                              if(isset($_POST['select'])){
                                $getOption=$_POST['select'];
                                if($getOption == "Standard Delivery $6.00"){
                                  $_SESSION['shipping'] = $shipping_price  = 6.00;
                                } elseif($getOption == "Next Day Delivery $15.00"){
                                  $_SESSION['shipping'] = $shipping_price  = 15.00;
                                } elseif($getOption == "International Tracked $20.00"){
                                  $_SESSION['shipping'] = $shipping_price  =20.00;
                                } else{
                                  $_SESSION['shipping'] = $shipping_price  = 0;
                                }
                              }
                            ?>
                          </th>     
                        </tr>
                        <tr>
                          <th class="cart_sub">Total</th>
                          <td class="cart-total fw-bold">
                          €<?= $total = ($subtotal + $shipping_price);?>
                          </td>
                        </tr>
                    </tbody>
                  </table>
                  <div class="mt-4 d-flex justify-content-center">
                    <form method="post" action="<?= APP_URL ?>/views/cart-checkout.php">
                      <input type="hidden" name="shipping_price" value="<?= $shipping_price?>">
                      <input class="add_btn-cart" type="submit" value="Checkout">
                    </form>
                  </div> 
                </div>
              </div>  
            </div>

        </div>
      </div>
    </div>
  </div>
  </div>
  <?php } ?>
  </div>
  </main>
  <?php require 'include/footer.php'?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>
</html>