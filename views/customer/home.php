<?php require_once '../../config.php'; ?>
<?php 

use BookWorms\Model\Image;
use BookWorms\Model\Product;
use BookWorms\Model\Artist;
use BookWorms\Model\Category;
$products = Product::findAll();
$categories = Category::findAll();
$artists = Artist::findAll();

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

  <link  rel="stylesheet" href="<?= APP_URL ?>assets/css/mystyle.css"/>

  <script>
      function selectChange(val) {
          //Set the value of action in action attribute of form element.
          //Submit the form
          $('#myForm').submit();
      }
  </script>
</head>
<body>

<div class="container-fluid">
<?php require 'include/navbar.php'; ?>
<?php require 'include/flash.php'; ?>

  <div class="row row__header">
    <div class="header__prints" style="padding:0px;">
      <img class="header__img-scale"src="<?= APP_URL ?>images/image1.jpg" alt="Prints Header Image">
      <div class="header__texts align-self-end">
        <h1 class="print__header-style">PRINTS</h1>
        <p class="header__prints-text">CHESHIRE CAT DUSK (PRINT)</p>
        <p  class="header__prints-text">Kristin Kwan</p>
      </div>
    </div>    
  </div>
  <?php require 'include/flash.php'; ?>

  <div class="container filter__search">
    <div class="row d-flex justify-content-between bd-highlight mb-3">
      <div class="col-md-1 p-2">
        <form id="myForm" method="post" style="width:">
          <select class="filter__width filter" name="select" onchange="this.form.submit();">
            <?php $selected = $_POST['select'] ?>
            <option selected="selected" value="0" disabled>Subject</option>

            <?php foreach($categories as $category) { ?> 
            <option value="<?= $category->id?>"><?= $category->title ?></option>
            <?php } ?>

          </select>
        </form>
      </div>

      <div class="col-md-1 p-2">
        <form id="myForm" method="post">
          <select class="filter__width filter" name="selectArtist" onchange="this.form.submit();">
            <?php $selected = $_POST['selectArtist'] ?>
            <option selected="selected" value="0" disabled>Artist</option>
            <?php foreach($artists as $artist) { ?> 
            <option value="<?= $artist->id?>"><?= $artist->name ?></option>
            <?php } ?>
          </select>
        </form>
      </div>

      <div class="col-md-1 p-2">
        <form id="myForm" method="post">
          <select class="filter__width filter" name="select">
            <option selected="selected" value="0" disabled>Price</option>
            <option value="">$0-$30</option>
            <option value="">$31-$60</option>
            <option value="">$61-$90</option>
            <option value="">$91-$120</option>
            <option value="">$121+</option>
          </select>
        </form>
      </div>

      <div class="col-md-1 p-2">
        <form id="myForm" method="post">
          <select class="filter__width filter" name="select">
            <option selected="selected" value="0" disabled>Availability</option>

            <option value="">In Stock</option>
            <option value="">Out of Stock</option>

          </select>
        </form>
      </div>

      <div class="col-md-1 d-flex justify-content-inline">
        <form id="myForm" method="post" style="width">
          <input type="hidden" name="filter" value="All">
          <button  style="padding-top:5px;padding-left:5px;">
            <img src="<?= APP_URL?>/images/close.svg" alt="">
            </button>
        </form>
      </div>
    </div>
  </div>

  <?php 
  $selected = $_POST['select'] ?? "";
  if (isset($_POST['select'])) {
    $category_id = $selected;
    $products = Product::findByCat($category_id);
  }

  $selected = $_POST['selectArtist'] ?? "";
  if (isset($_POST['selectArtist'])) {
    $artist_id = $selected;
    $products = Product::findByArtist($artist_id);
  }
  ?>

<div class="container">
  <div class="row align-items-end">
    <?php foreach ($products as $product) { 
      $images = Image::findById($product->img_id);
      $artists = Artist::findById($product->artist_id);
    ?>  

      <div class="col-md-6 col-lg-4 col-xl-3 col-sm-9">
        <div class="card prints__card" style="width:100%;margin-bottom:0px!important;margin-top:0.6rem;" >
          <form action="<?= APP_URL ?>/views/view-product.php">
            <input type="hidden" name="id" value="<?= $product->id?>">
            <input type="image" name="id" id="<?= $product->id?>" src="<?= APP_URL?>/images/<?= $images->filename?>" class="card-img-top" style="width:100%">
          </form>
          <div class="card-body" style="padding-top:0px!important">
            <div class="card-title d-flex justify-content-between" style="margin-bottom:0px!important;">
              <h6 class="col-9"><?= $product->name?></h6>
              <form type="hidden" action="<?= APP_URL?>/actions/cart-add.php">
                      <input type="hidden" name="id" value="<?= $product->id?>">
                      <input type="image" name="id" id="<?= $product->id?>" src="<?= APP_URL?>/images/bag.svg">
              </form>
              <a href="#">
                <img src="<?= APP_URL?>/images/black-heart.svg" alt="favorite">
              </a>
            </div>
            <h6 class="card__artist-name text-muted"><?= $artists->name?></h6>
            <h6 class="card__price">€<?= $product->price?></h6>
          </div>
        </div>
      </div>
      <?php }?>
    </div>
  </div>
</div>
<?php require 'include/footer.php'?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>
</html>
