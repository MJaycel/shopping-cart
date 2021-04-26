<?php require_once 'config.php'; ?>
<?php 

use BookWorms\Model\Image;
use BookWorms\Model\Product;
use BookWorms\Model\Artist;
use BookWorms\Model\Category;
$products = Product::findAll();
$categories = Category::findAll();
$artists = Artist::findAll();

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Welcome to Book Worms</title>

    <link href="<?= APP_URL ?>/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?= APP_URL ?>/assets/css/template.css" rel="stylesheet">
    <script src="jquery-1.7.1.min.js"></script>

    <script>
      function selectChange(val) {
          //Set the value of action in action attribute of form element.
          //Submit the form
          $('#myForm').submit();
      }
      </script>

  </head>
  <body>
    <div class="container">
      <?php require 'include/header.php'; ?>
      <?php require 'include/navbar.php'; ?>
      <?php require 'include/flash.php'; ?>
      <main role="main">
        <div>
          <h1>Welcome to Book Worms</h1>

          <form id="myForm" method="post">          
          <select name='select' onchange="this.form.submit();">
            <?php  $selected = $_POST['select'] ?>
                <option selected="selected" value= "0"disabled>Subject</option>
                <?php foreach($categories as $cat) { 
                  ?> 
                  <option value='<?= $cat->id?>'> <?= $cat->title?> </option>
                <?php }?>
            </select>
            <!-- <input type="submit" id="submit" name="submit" value="submit"/> -->
            </form>
            <form method="post">  
            <select name='artistSelect' onchange="this.form.submit();">
            <?php  $selected = $_POST['artistSelect'] ?>
                <option selected="selected" disabled>Artist</option>
                <?php foreach($artists as $artist) { 
                  ?> 
                  <option value='<?= $artist->id?>'> <?= $artist->name?> </option>
                <?php }?>
            </select>
            <!-- <input type="submit" name="artistFilter" value="submit"/> -->
            <input type="submit" name="filter" value="All">
          </form>


                  
          <?php 
          $selected = $_POST['select'] ?? "";
          if (isset($_POST['select'])) {
            $category_id = $selected;
            $products = Product::findByCat($category_id);
            echo $category_id;
            // echo $products;
            // $products = Product::findByCat($category->id);
          }

          $selected = $_POST['artistSelect'] ?? "";
          if (isset($_POST['artistSelect'])) {
            $artist_id = $selected;
            echo $artist_id;
            $products = Product::findByArtist($artist_id);
            // echo $products;
            // $products = Product::findByCat($category->id);
          }
          ?>
          
          

          <div class="row">
              <?php 
              foreach ($products as $product) { 
                $images = Image::findById($product->img_id); 
                $artists = Artist::findById($product->artist_id);
              ?> 
              
            <div class="col mb-5">
              <div class="card" style="width:18rem;">
              <form type="hidden" action="<?= APP_URL?>/views/view-product.php">
                    <input type="hidden" name="id" value="<?= $product->id?>">
                    <input type="image" name="id" value="<?= $product->id?>" src="images/<?= $images->filename?>" class="card-img-top"/>
                    <!-- <button type="submit" class="btn btn-primary">Add to cart</button> -->
                <div class="card-body">
                  <h5 class="card-title"><?= $product->name ?></h5>
                </div>
                
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">Author: <?= $artists->name ?></li>
                  <li class="list-group-item">Price: €<?= $product->price ?></li>
                </ul>

                <!-- <button type="button" class="btn btn-primary">Add to Cart</button> -->
                <li class="list-group-item">
                  <form type="hidden" action="<?= APP_URL?>/actions/cart-add.php">
                    <input type="hidden" name="id" value="<?= $product->id?>">
                    <button type="submit" class="btn btn-primary">Add to cart</button>
                  </form>
                  
                </li>

              </div>
            </div>
            <?php } ?> 
          </div>
        </div>

      </main>
      <?php require 'include/footer.php'; ?>
    </div>
    <script src="<?= APP_URL ?>/assets/js/jquery-3.5.1.min.js"></script>
    <script src="<?= APP_URL ?>/assets/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
