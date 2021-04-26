<?php require_once '../config.php'?>
<?php 

if (!$request->is_logged_in()) {
    $request->redirect("/views/auth/login-form.php");
  }
  else {
    $role = $request->session()->get("role");
    if($role !== "customer") {
      $request->redirect("/views"."/".$role."/index.php");
    }
  }
  
  use BookWorms\Model\Cart;
  use BookWorms\Model\Card;
  use BookWorms\Model\User;
  use BookWorms\Model\Image;
  use BookWorms\Model\Artist;
  
  $shipping_price =  $_SESSION['shipping'];
  
  
  $email = $request->session()->get("email");
  $user = User::findByEmail($email);
  $cards = Card::findByUserId($user->id);
  $cart = Cart::get($request);
  if ($cart->empty()) {
      $request->redirect("/views/cart-view.php");
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Amry Chambers Checkout</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" 
  integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">

  <link  rel="stylesheet" href="<?= APP_URL ?>/assets/css/mystyle.css"/>
</head>
<body>
 
<?php require 'include/flash.php'?>
<?php require 'include/navbar.php'?>

<main role="main">
  <div class="container">
    <div class="row d-flex justify-content-center">
      <div class="card">
        <div class="col d-flex align-items-start flex-wrap">
            
          <div class="col-sm-6" style="padding-right:0px!important">
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
                      <tr class="borderless">
                        <th class="cart__head" style="font-weight:500;" colspan="4">Subtotal</th>
                        <td class="cart__total">€<?=$subtotal?></td>
                      </tr>
                      <tr class="borderless">
                        <th class="cart__head" style="font-weight:500;" colspan="4">Delivery</th>
                        <td class="cart__total">€<?= $shipping_price ?></td>
                      </tr>
                      <tr class="borderless">
                        <th class="cart__head" style="font-weight:500;" colspan="4">Total</th>
                        <td class="cart__total">€<?= $total = ($subtotal + $shipping_price)?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                </div>
              </div>
            </div>          
          </div>

          <div class="col-sm-5" style="padding-left:0px!important;">
            <div class="card cart__summary pt-2 pb-4">
              <div class="card-body">
                <form id="form-checkout" action="<?= APP_URL?>/actions/checkout.php" method="post">
                    <div class="collapse show pt-2" id="collapseExample">
                    <p class="cart__summary__heading upper d-flex justify-content-start">
                    Payment Method
                </p>
                    <?php if (!is_null($cards)) { ?>
                        <?php foreach ($cards as $card) { ?> 
                        <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="card_id" value="<?= $card->id ?>" id="<?= $card->card_number?>">
                        <label class="form-check-label" for="<?= $card->card_number?>">
                            <div class="card">
                                <div class="card-header d-flex align-items-center m-2">
                                    <img class="user__card-img" src="<?=APP_URL?>/images/visa.svg" alt="">

                                    <span class="user_card p-1 m-1"><?= $card->name . ", card number ending in " . substr($card->card_number, -4)  ?></span>
                                </div>
                            </div>
                        </label>
                        </div>
                    <?php } ?>
                    <div class="form-check mb-2">
                        <input type="radio" class="form-check-input" name="card_id" value="0" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" id="new-card" <?= (count($cards) === 0) ? "checked" :  ''  ?>>
                        <label class="form-check-label" for="new-card">
                            <div class="card" style="">
                                <div class="card-header  d-flex align-items-center m-2">
                                    <span class="user_card p-1 m-1"> Enter Card details</span>
                                </div>
                            </div>
                        </label>
                    </div>   
                    <div class="mt-5 d-flex justify-content-evenly">
                            <a class="cancel__btn"data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" style="text-decoration:none!important;color:black;padding-left:5px;">
                                Cancel
                            </a>  

                            <input class="add_btn-cart" name="submit" type="submit" value="Checkout">

                            </div>     
                    </div>

                    

                    <div class="card cart__summary collapse" id="collapseExample">
                        <div class="card-body">
                            <div class="d-flex justify-content-start">
                            <h5 class="cart__summary__heading upper">Enter card details</h5>
                            </div>
                            <div class="form-row">
                            <div class="form-group">
                                <label for="inputState"></label>
                                <input class="form-check-input" name="card_type" type="radio" id="card_type" value= "visa">
                                <label class="form-check-label" for="inlineCheckbox1">Visa</label>
                                <span class="error"><?= error('card_type') ?></span>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" name="card_type" type="radio" id="card_type" value="master-card">
                                <label class="form-check-label" for="inlineCheckbox2">Master Card</label>
                                <span class="error"><?= error('card_type') ?></span>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" name="card_type" type="radio" id="card_type" value="american-express">
                                <label class="form-check-label" for="inlineCheckbox3">American Express</label>
                                <span class="error"><?= error('card_type') ?></span>
                            </div>

                            <div class="form-group">
                                <label for="inputState"></label>

                                <input type="text" class="form-control" name="name" id="name" value="<?= old("name") ?>"  placeholder="Name">
                                <span class="error"><?= error('name') ?></span>

                            </div>
                            <div class="form-group">
                                <label for="inputState"></label>

                                <input type="text" class="form-control" name="card_number" id="card_number" value="<?=  old("card_number") ?>" placeholder="Card Number" />
                                    <span class="error"><?= error('card_number') ?></span>

                            </div>


                            <div class="form-row d-flex justify-content-between">
                                <div class="form-group col"  style="margin-right:6px;">
                                    <label for="inputState"></label>
                                    <input type="text" class="form-control" name="exp_date" id="exp_date" value="<?=  old("exp_date")  ?>" placeholder="Expire Date"/>
                                    <span class="error"><?= error('exp_date') ?></span>
                                </div>
                                <div class="form-group col">
                                    <label for="inputState"></label>
                                    <input type="text" class="form-control"  name="cvv" id="cvv"  value="<?=  old("cvv")  ?>" placeholder="CVV"/>
                                    <span class="error"><?= error('cvv') ?></span>  
                                </div>
                            </div>

                            <div class="mt-5 d-flex justify-content-evenly">
                            <a class="cancel__btn"data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" style="text-decoration:none!important;color:black;padding-left:5px;">
                                Cancel
                            </a>  

                            <input class="add_btn-cart" name="submit" type="submit" value="Checkout">

                            </div>                                 
                        </div>
                    </div>

                    <?php } else { ?>

                    <div class="card cart__summary collapse" id="collapseExample">
                        <div class="card-body">
                            <input type="hidden" class="form-check-input" name="card_id" value="0" id="new-card" >

                            <div class="d-flex justify-content-start">
                            <h5 class="cart__summary__heading upper">Enter card details</h5>
                            </div>
                            <div class="form-row">
                            <div class="form-group">
                                <label for="inputState"></label>
                                <input class="form-check-input" name="card_type" type="radio" id="card_type" value= "visa">
                                <label class="form-check-label" for="inlineCheckbox1">Visa</label>
                                <span class="error"><?= error('card_type') ?></span>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" name="card_type" type="radio" id="card_type" value="master-card">
                                <label class="form-check-label" for="inlineCheckbox2">Master Card</label>
                                <span class="error"><?= error('card_type') ?></span>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" name="card_type" type="radio" id="card_type" value="american-express">
                                <label class="form-check-label" for="inlineCheckbox3">American Express</label>
                                <span class="error"><?= error('card_type') ?></span>
                            </div>

                            <div class="form-group">
                                <label for="inputState"></label>

                                <input type="text" class="form-control" name="name" id="name" value="<?= old("name") ?>"  placeholder="Name">
                                <span class="error"><?= error('name') ?></span>

                            </div>
                            <div class="form-group">
                                <label for="inputState"></label>
                                <input type="text" class="form-control" name="card_number" id="card_number" value="<?=  old("card_number") ?>" placeholder="Card Number" />
                                <span class="error"><?= error('card_number') ?></span>
                            </div>

                            <div class="form-row d-flex justify-content-between">
                                <div class="form-group col"  style="margin-right:6px;">
                                    <label for="inputState"></label>
                                    <input type="text" class="form-control" name="exp_date" id="exp_date" value="<?=  old("exp_date")  ?>" placeholder="Expire Date"/>
                                    <span class="error"><?= error('exp_date') ?></span>
                                </div>
                                <div class="form-group col">
                                <label for="inputState"></label>
                                    <input type="text" class="form-control"  name="cvv" id="cvv"  value="<?=  old("cvv")  ?>" placeholder="CVV"/>
                                    <span class="error"><?= error('cvv') ?></span>  
                                </div>
                            </div>

                            <?php } ?>


                            <form action="<?= APP_URL?>/actions/checkout.php">
                             <button type="submit" class="add_btn-cart">Checkout</button>   
                            </form>    

                            </div>                                 
                        </div>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<?php require 'include/footer.php'?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
<script src="<?= APP_URL ?>/assets/js/jquery-3.5.1.min.js"></script>
<script src="<?= APP_URL ?>/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>