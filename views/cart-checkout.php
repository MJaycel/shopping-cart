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
            <div class="card cart__summary">
              <div class="card-body">
                <div class="collapse show" id="collapseExample">
                  <table class="table borderless">
                    <thead>
                      <tr>
                        <th class="cart__summary__heading upper d-flex justify-content-start">
                          Shipping Address
                          <a data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" style="padding-top:5px;padding-left:5px;">
                          <img src="<?= APP_URL?>/images/edit.svg" alt="">
                          </a>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th class="deliver__add-head">Address Line 1</th>
                        <td  class="deliverAdd"><?= $user->address_1?></td>
                      </tr>
                      <tr>
                        <th class="deliver__add-head">Address Line 2</th>
                        <td  class="deliverAdd"><?= $user->address_2?></td>
                      </tr>                    <tr>
                        <th class="deliver__add-head">City</th>
                        <td  class="deliverAdd"><?= $user->city?></td>
                      </tr>                    <tr>
                        <th class="deliver__add-head">Country</th>
                        <td  class="deliverAdd"><?= $user->country?></td>
                      </tr>                    <tr>
                        <th class="deliver__add-head">Postcode</th>
                        <td  class="deliverAdd"><?= $user->postcode?></td>
                      </tr>                    <tr>
                        <th class="deliver__add-head">Phone</th>
                        <td  class="deliverAdd"><?= $user->phone?></td>
                      </tr>
                    </tbody>
                  </table>

                  <div class="mt-4 d-flex justify-content-evenly">
                    <form type="hidden" action="<?= APP_URL ?>/views/cart-view.php">
                        <input type="hidden" name="shipping_price" value="<?= $shipping_price?>">
                        <input class="cancel__btn" type="submit" value="Cancel">
                    </form>
                    <form type="hidden" action="cart-payment.php">
                      <input type="hidden" name="shipping_price" value="<?= $shipping_price?>">
                      <input class="add_btn-cart" type="submit" value="Continue">
                    </form>
                  </div> 
                </div>
              </div>
            </div>
           <div class="card cart__summary collapse" id="collapseExample">
              <div class="card-body">
                <div class="d-flex justify-content-start">
                  <h5 class="cart__summary__heading upper">Shipping Address</h5>
                </div>

                <form name='update' action="<?= APP_URL ?>/actions/update-address.php"  method="post">
                  <div class="form-row">
                  <div class="form-group">
                    <label for="inputState"></label>

                    <input type="text" class="form-control" name="address_1" id="address_1" value="<?= old("address_1") ?>"  placeholder="Address Line 1">
                    <span class="error"><?= error('address_1') ?></span>

                  </div>
                  <div class="form-group">
                    <label for="inputState"></label>

                    <input type="text" class="form-control" name="address_2" id="address_2" value="<?= old("address_2") ?>"  placeholder="Address Line 2">
                    <span class="error"><?= error('address_2') ?></span>

                  </div>

                  <div class="form-row d-flex justify-content-between">
                    <div class="form-group col"  style="margin-right:6px;">
                        <label for="inputState"></label>

                        <input type="text" class="form-control" name="city" id="city" value="<?= old("city") ?>"  placeholder="City" >
                        <span class="error"><?= error('city') ?></span>

                    </div>
                    <div class="form-group col">
                      <label for="country"></label>
                      <select name="country" id="country" class="form-control">
                        <option value="Germany"          <?= chosen("country", "Germany") ? "selected" : ""            ?>>Germany</option>
                        <option value="France"           <?= chosen("country", "France") ? "selected" : ""             ?>>France</option>
                        <option value="Italy"            <?= chosen("country", "Italy") ? "selected" : ""              ?>>Italy</option>
                        <option value="United Kingdom"   <?= chosen("country", "United Kingdom") ? "selected" : ""     ?>>United Kingdon</option>
                        <option value="Netherlands"      <?= chosen("country", "Netherlands") ? "selected" : ""        ?>>Netherlands</option>
                        <option value="Sweden"           <?= chosen("country", "Sweden") ? "selected" : ""             ?>>Sweden</option>
                        <option value="Switzerland"      <?= chosen("country", "Switzerland") ? "selected" : ""        ?>>Switzerland</option>
                        <option value="Greece"           <?= chosen("country", "Greece") ? "selected" : ""             ?>>Greece</option>
                        <option value="Poland"           <?= chosen("country", "Poland") ? "selected" : ""             ?>>Poland</option>
                        <option value="Austria"          <?= chosen("country", "Austria") ? "selected" : ""            ?>>Austria</option>
                        <option value="Czechia"          <?= chosen("country", "Czechia" ) ? "selected" : ""           ?>>Czechia</option>
                        <option value="Denmark"          <?= chosen("country", "Denmark") ? "selected" : ""            ?>>Denmark</option>
                        <option value="Ireland"          <?= chosen("country", "Ireland") ? "selected" : ""            ?>>Ireland</option>
                        <option value="Norway"           <?= chosen("country", "Norway") ? "selected" : ""             ?>>Norway</option>
                        <option value="Finland"          <?= chosen("country", "Finland") ? "selected" : ""            ?>>Finland</option>
                        <option value="Luxemberg"        <?= chosen("country", "Luxemberg") ? "selected" : ""          ?>>Luxemberg</option>
                        <option value="Belgium"          <?= chosen("country", "Belgium") ? "selected" : ""            ?>>Belgium</option>
                        <option value="Bulgaria"         <?= chosen("country", "Bulgaria" ) ? "selected" : ""          ?>>Bulgaria</option>
                        <option value="Spain"            <?= chosen("country", "Spain"  ) ? "selected" : ""            ?>>Spain</option>
                        <option value="Portugal"         <?= chosen("country", "Portugal" ) ? "selected" : ""          ?>>Portugal</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-row d-flex justify-content-between">
                    <div class="form-group col" style="margin-right:6px;">
                    <label for="inputState"></label>
                      <input type="text" class="form-control" name="postcode" id="postcode" value="<?= old("postcode") ?>"  placeholder="Postcode">
                      <span class="error"><?= error('postcode') ?></span>

                    </div>

                  <div class="form-group col">
                      <label for="inputState"></label>
                      <input type="text" class="form-control" name="phone" id="phone" value="<?= old("phone") ?>"  placeholder="Phone">
                      <span class="error"><?= error('phone') ?></span>
                    </div>
                  </div>

                  <div class="mt-5 d-flex justify-content-evenly">
                  <a class="cancel__btn"data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" style="text-decoration:none!important;color:black;padding-left:5px;">
                      Cancel
                    </a>  

                    <input class="add_btn-cart" name="submit" type="submit" value="Continue">

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
</body>
</html>