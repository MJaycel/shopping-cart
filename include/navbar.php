
<nav class="nav navbar navbar-expand-lg navbar-light nav__text-style">
    <div class="container-fluid">
      <a href="<?= APP_URL ?>/index.php" class="nav__logo navbar-brand">
        <img src="<?= APP_URL ?>/images/Asset 1.svg" alt="AmryChambers Logo">
      </a>
      <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navBar" 
        aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <img src="<?= APP_URL ?>/images/menu_white.svg" alt="AmryChambers Logo">
      </button>

      <div class="collapse navbar-collapse nav__link-list" id="navBar">

        <ul class="navbar-nav navbar__link">
          <li class="list__nostyle nav__links-padding nav-item upper">
            <a href="<?= APP_URL?>/prints.php" class="nav__link nav-link">Prints</a>
          </li>
          <li class="list__nostyle nav__links-padding nav-item upper">
            <a href="#" class="nav__link nav-link">Artworks</a>
          </li>
          <li class="list__nostyle nav__links-padding nav-item upper">
            <a href="#" class="nav__link nav-link">Artist</a>
          </li>
          <li class="list__nostyle nav__links-padding nav-item upper">
            <a href="#" class="nav__link nav-link">About</a>
          </li>
          <li class="list__nostyle nav__links-padding nav-item upper">
          <h2 class="link__acc_cart">My account</h2>   

            <div clas="dropdown">
              <a href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"  class="nav__link nav-link"> 
                <div class="logo__acc_cart">
              <img src="<?= APP_URL ?>/images/myAccount.svg" alt="AmryChambers Profile" >

                </div>
              </a>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <!-- <li><a class="dropdown-item" href="#">My Account</a></li> -->
                <li><a class="dropdown-item" href="<?= APP_URL ?>/actions/login.php">Login</a></li>
                <li><a class="dropdown-item" href="<?= APP_URL ?>/actions/logout.php">Logout</a></li>
                <li><a class="dropdown-item" href="<?= APP_URL ?>/actions/register.php">Register</a></li>

              </ul>
            </div>
          </li>
          <li class="list__nostyle nav__links-padding nav-item upper">
            <a href="<?= APP_URL ?>/views/cart-view.php" class="nav__link nav-link"> 
              <h2 class="link__acc_cart">View Cart</h2>   
              <div class="logo__acc_cart">
              <img src="<?= APP_URL ?>/images/cart.svg" alt="AmryChambers Profile">
              </div>
            </a>
          </li>
        </ul>
      </div>
  </nav>  