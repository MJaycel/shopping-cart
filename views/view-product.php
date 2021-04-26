<?php require_once '../config.php' ?>
<?php 

use BookWorms\Model\Image;
use BookWorms\Model\Artist;
use BookWorms\Model\Product;
use BookWorms\Model\Cart;
use BookWorms\Model\ProductCategory;

try{
    $rules = [
        'id' => 'present|integer|min:1'
    ];
    $request->validate($rules);
    if(!$request->is_valid()) {
        throw new Exception("Request illegal");
    }
    $product_id = $request->input('id');

    $product = Product::findById($product_id);
    if($product === null) {
        throw new Exception("No item found");
    }
}
catch (Exception $ex) {
    $request->session()->set("flash_message", $ex->getMessage());
    $request->session()->set("flash_message_class", "alert-warning");

    $request->redirect("prints.php");
}

$images = Image::findById($product->img_id); 
$artist = Artist::findById($product->artist_id);
$products = Product::findByArtist($artist->id);
// $products = array_slice($products,0,6);
// $products = Product::findByCat($category_id)

$category_id = ProductCategory::findCategory($product->id);

// echo $category_id;
$product_cats = Product::findByCat($category_id->cat_id);

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

</head>
<body>
<?php require 'include/flash.php'; ?>
<?php require 'include/navbar.php'?>  

<div class="main">
  <div class="container">
    <div class="row item__detail d-flex justify-content-center">
      <div class="col-md-5">
        <img src="<?= APP_URL ?>/images/<?= $images->filename?>" alt="" style="width:100%;">
      </div>
      <div class="col-md-7 col-lg-5 col-xl-4">
        <div class="card col-md-5 item__details" style="margin-bottom:0px;">
          <div class="card-body" style="padding-top:0px;">
            <!-- <div class="card-title"> -->
              <h4 class="item__title upper mt-3"><?= $product->name?></h4>
            <!-- </div> -->
            <h6 class="item__artist">Artist: <?= $artist->name?></h6>
            <h6 class="item__price mt-3">€<?= $product->price?></h6>

            <div class="item__quantity__add-btn">
              <div class="mt-4">
                <form method="post" action="<?= APP_URL ?>/actions/add.php">
                  <input class="input__qty" type="number" name="qty" value="1"  min="1">
                  <input type="hidden" name="id" value="<?= $product->id ?>" />
                  <input class="add_btn" type="submit" value="Add to cart">
                </form>
              </div> 
            </div>
            <div class="row sec__info mt-5">
              <div class="col-sm">
                <table>
                <h6 class="desc__head">Description</h6> 
                      <thead>
                        <th class="desc__body"></th>
                      </thead>
                    <tbody>
                      <tr>
                      <th class="desc__body-heading">Height:</th>
                      <td class="desc__body-text"><?= $product->height ?></td>
                      </tr>
                      <tr>
                      <th class="desc__body-heading">Width:</th>
                      <td class="desc__body-text"><?= $product->width ?></td>
                      </tr>
                      <tr>
                      <th class="desc__body-heading">Paper Type:</th>
                      <td class="desc__body-text"><?= $product->paper_type ?></td>
                      </tr>
                      <tr >
                          <th class="stock__padding">
                        <?php 
                        // $product->availability; 
                        // echo $product->availability ;
                         $outOfStock = "Out of Stock";
                         $inStock = "In stock";
                        if($product->availability == $outOfStock) { ?>
                         <p class="out-of-stock upper"><?= $product->availability?></p>
                        <?php } elseif($product->availability == $inStock) { ?> 
                          <p class="in-stock upper"><?= $product->availability?></p>
                        <?php }?>
                      </tr>
                    </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row align-items-end all__prints">
      <h2 class="more__tag">More by <?= $artist->name ?></h2>
      <?php foreach ($products as $product) { 
        $images = Image::findById($product->img_id);
        $artists = Artist::findById($product->artist_id);
      ?> 
      <div class="col-md-6 col-lg-4 col-xl-3 col-sm-9">
        <div class="card" style="width:90%;margin-bottom:0px!important;margin-top:0.6rem;" >
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

    <div class="row align-items-end all__prints">
      <h2 class="more__tag">Similar Subject</h2>
      <?php foreach ($product_cats as $product_cat) { 
        $images = Image::findById($product_cat->img_id);
        $artists = Artist::findById($product_cat->artist_id);
      ?> 
      <div class="col-md-6 col-lg-4 col-xl-3 col-sm-9">
        <div class="card" style="width:100%;margin-bottom:0px!important;margin-top:0.6rem;" >
          <form action="<?= APP_URL ?>/views/view-product.php">
            <input type="hidden" name="id" value="<?= $$product_cat->id?>">
            <input type="image" name="id" id="<?= $product_cat->id?>" src="<?= APP_URL?>/images/<?= $images->filename?>" class="card-img-top" style="width:100%">
          </form>
          <div class="card-body" style="padding-top:0px!important">
            <div class="card-title d-flex justify-content-between" style="margin-bottom:0px!important;">
              <h6 class="col-9" style="margin-bottom:0px!important;"><?= $product_cat->name?></h6>
              <form type="hidden" action="<?= APP_URL?>/actions/cart-add.php">
                      <input type="hidden" name="id" value="<?= $product_cat->id?>">
                      <input type="image" name="id" id="<?= $product_cat->id?>" src="<?= APP_URL?>/images/bag.svg">
              </form>
              <a href="#">
                <img src="<?= APP_URL?>/images/black-heart.svg" alt="favorite">
              </a>
            </div>
            <h6 class="card__artist-name text-muted"><?= $artists->name?></h6>
            <h6 class="card__price">€<?= $product_cat->price?></h6>
          </div>
        </div>
      </div>
      <?php }?>
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