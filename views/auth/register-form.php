<?php require_once '../../config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" 
  integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">

  <link  rel="stylesheet" href="<?= APP_URL?>/assets/css/mystyle.css"/>
</head>
<body>
<?php require 'include/navbar.php' ;?>
<?php require 'include/flash.php'; ?>
<div class="container">
<div class="row d-flex justify-content-center">
  <div class="col-md-5">
    <div class="card pt-5">
    <div class="card-body">
                <div class="d-flex justify-content-start">
                  <h5 class="cart__summary__heading upper">Shipping Address</h5>
                </div>

                <form name='update' action="<?= APP_URL ?>/actions/update-address.php"  method="post">

                    <div class="form-group col" style="margin-right:6px;">
                    <label for="inputState"></label>
                      <input type="text" class="form-control" name="name" id="name" value="<?= old("name") ?>"  placeholder="Name">
                      <span class="error"><?= error('name') ?></span>

                    </div>

                  <div class="form-group">
                    <label for="inputState"></label>

                    <input type="text" class="form-control" name="email" id="email" value="<?= old("email") ?>"  placeholder="Email Address">
                    <span class="error"><?= error('address_1') ?></span>

                  </div>
                  <div class="form-group">
                    <label for="inputState"></label>

                    <input type="password" class="form-control" name="password" id="password" value="<?= old("password") ?>"  placeholder="Password">
                    <span class="error"><?= error('password') ?></span>

                  </div>

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
<?php require 'include/footer.php'?>

<script src="<?= APP_URL ?>/assets/js/jquery-3.5.1.min.js"></script>
  <script src="<?= APP_URL ?>/assets/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>
</html>