<?php require_once '../../config.php'; ?>
<?php
if ($request->is_logged_in()) {
  $role = $request->session()->get("role");
  $request->redirect("/views"."/".$role."/home.php");
}
?>
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
<?php require 'include/flash.php'; ?>
<?php require 'include/navbar.php' ;?>

<div class="container">
<div class="row d-flex justify-content-center">
  <div class="col-md-5">
    <div class="card sing__card">
      <div class="card-body login__body">
      <h1 class="login__heading">Sign in</h1>
      <div class="login__form p-4">
        <form name='login' action="<?= APP_URL . '/actions/login.php' ?>" method="post">
            <div class="form-field m-1">
              <label for="email" class="cart_sub">Email:</label>
              <input type="text" class="form-control" name="email" id="email" value="<?= old("email") ?>" />
              <span class="error"><?= error("email") ?></span>
            </div>
            <div class="form-field m-1">
              <label for="password" class="cart_sub">Password:</label>
              <input type="password"  class="form-control" name="password" id="password">
              <span class="error"><?= error("password") ?></span>
            </div>
            <div class="form-field d-flex justify-content-center p-2">
              <label></label>
              <a class="cancel__btn" style="text-decoration:none;color:black;padding-right:20px;" href="<?= APP_URL . "/" ?>" >Cancel</a>

              <input class="sign__in" style="padding-right:20px;" class="form-control" type="submit" name="submit" value="Login" />
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