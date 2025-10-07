<?php
// Ensure BASE_URL exists even if not defined in index.php
if (!defined('BASE_URL')) {
   $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
   $host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
   $base   = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
   define('BASE_URL', $scheme . '://' . $host . ($base === '/' ? '' : $base));
}
//Lấy ra thông tin người đăng nhập nếu tồn tại
if (isset($_SESSION['user_id'])) {
   $user = new User();
   $is_SS = false;
   $users = $user->getUserInfoPDW_ByID($_SESSION['user_id'])->fetchAll();
   foreach ($users as $userss) {
      if ($userss['role'] == 1) {
         $_SESSION['fullname'] = $userss['fullname'];
         $_SESSION['number_phone'] = $userss['number_phone'];
         $_SESSION['address'] = $userss['address'];
         $_SESSION['province'] = $userss['province'];
         $_SESSION['district'] = $userss['district'];
         $_SESSION['wards'] = $userss['wards'];
         $_SESSION['district_id'] = $userss['province_id'];
         $_SESSION['district_id'] = $userss['district_id'];
         $_SESSION['wards_id'] = $userss['wards_id'];
         $is_SS = true;
      }
   }

   if ($is_SS == false) {
      unset($_SESSION['fullname']);
      unset($_SESSION['number_phone']);
      unset($_SESSION['address']);
      unset($_SESSION['province']);
      unset($_SESSION['district']);
      unset($_SESSION['wards']);
      unset($_SESSION['province_id']);
      unset($_SESSION['district_id']);
      unset($_SESSION['wards_id']);
   }
}
?>

<!-- Start Premium Top Nav -->
<nav class="navbar navbar-expand-lg navbar-light d-none d-lg-block premium-top-nav" id="templatemo_nav_top">
   <div class="container">
      <div class="w-100 d-flex justify-content-between align-items-center">
         <div class="d-flex align-items-center">
            <div class="contact-info d-flex align-items-center">
               <div class="contact-icon">
                  <i class="fas fa-envelope"></i>
               </div>
               <a class="contact-link" href="mailto:haidangattt@gmail.com">haidangattt@gmail.com</a>
            </div>
            <div class="contact-info d-flex align-items-center">
               <div class="contact-icon">
                  <i class="fas fa-phone"></i>
               </div>
               <a class="contact-link" href="tel:0983785604 ">0983785604</a>
            </div>
         </div>
         <div class="social-links d-flex align-items-center">
            <span class="social-text">Theo dõi chúng tôi:</span>
            <div class="social-icons">
               <a class="social-link" href="https://fb.com/templatemo" target="_blank" rel="sponsored">
                  <i class="fab fa-facebook-f"></i>
               </a>
               <a class="social-link" href="https://www.instagram.com/" target="_blank">
                  <i class="fab fa-instagram"></i>
               </a>
               <a class="social-link" href="https://twitter.com/" target="_blank">
                  <i class="fab fa-twitter"></i>
               </a>
               <a class="social-link" href="https://www.linkedin.com/" target="_blank">
                  <i class="fab fa-linkedin"></i>
               </a>
            </div>
         </div>
      </div>
   </div>
</nav>
<!-- Close Premium Top Nav -->


<!-- Premium Header -->
<nav class="navbar navbar-expand-lg navbar-light premium-header">
   <div class="container">
      <!-- Premium Logo -->
      <a class="navbar-brand premium-logo" href="index.php?action=home">
         <div class="logo-container">
            <div class="logo-main">
               <span class="logo-text">SPORT</span>
               <span class="logo-accent">SHOES</span>
            </div>
            <div class="logo-tagline">Premium Quality</div>
         </div>
      </a>

      <!-- Mobile Toggle Button -->
      <button class="navbar-toggler premium-toggler" type="button" data-bs-toggle="collapse"
         data-bs-target="#premium_main_nav" aria-controls="navbarSupportedContent" aria-expanded="false"
         aria-label="Toggle navigation">
         <span class="hamburger">
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
         </span>
      </button>

      <!-- Navigation Menu -->
      <div class="collapse navbar-collapse" id="premium_main_nav">
         <?php
         if (isset($_GET['action'])) {
            $action = $_GET['action'];
         }
         ?>
         <ul class="navbar-nav mx-auto premium-nav">
            <li class="nav-item">
               <a class="nav-link premium-nav-link <?php echo (isset($_GET['action']) && $_GET['action'] == 'home') ? 'active' : '' ?>"
                  href="index.php?action=home">
                  <div class="nav-icon">
                     <i class="fas fa-home"></i>
                  </div>
                  <span class="nav-text">Trang chủ</span>
                  <div class="nav-indicator"></div>
               </a>
            </li>
            <li class="nav-item">
               <a class="nav-link premium-nav-link <?php echo (isset($_GET['action']) && $_GET['action'] == 'shop') ? 'active' : '' ?>"
                  href="index.php?action=shop">
                  <div class="nav-icon">
                     <i class="fas fa-shopping-bag"></i>
                  </div>
                  <span class="nav-text">Sản phẩm</span>
                  <div class="nav-indicator"></div>
               </a>
            </li>
            <li class="nav-item">
               <a class="nav-link premium-nav-link <?php echo (isset($_GET['action']) && $_GET['action'] == 'contact') ? 'active' : '' ?>"
                  href="index.php?action=contact">
                  <div class="nav-icon">
                     <i class="fas fa-envelope"></i>
                  </div>
                  <span class="nav-text">Liên hệ</span>
                  <div class="nav-indicator"></div>
               </a>
            </li>
         </ul>
         
         <!-- Premium Actions -->
         <div class="navbar-nav premium-actions">
            <!-- Shopping Cart -->
            <div class="action-item cart-container">
               <a class="nav-link premium-cart" href="index.php?action=cart">
                  <div class="cart-icon-wrapper">
                     <i class="fas fa-shopping-cart"></i>
                     <span id="totalCart" class="cart-badge"></span>
                  </div>
                  <span class="cart-text">Giỏ hàng</span>
               </a>
            </div>
            
            <!-- User Menu -->
            <?php if (isset($_SESSION['lastname'])) { ?>
               <div class="action-item user-container">
                  <div class="dropdown premium-user-dropdown">
                     <a class="nav-link premium-user" data-bs-toggle="dropdown" href="#">
                        <div class="user-avatar">
                           <i class="fas fa-user-circle"></i>
                        </div>
                        <div class="user-info">
                           <span class="user-name"><?php echo $_SESSION['lastname'] ?></span>
                           <span class="user-status">Thành viên</span>
                        </div>
                        <div class="dropdown-arrow">
                           <i class="fas fa-chevron-down"></i>
                        </div>
                     </a>
                     <ul class="dropdown-menu premium-dropdown">
                        <li class="dropdown-header">
                           <div class="user-profile-summary">
                              <i class="fas fa-user-circle"></i>
                              <span><?php echo $_SESSION['lastname'] ?></span>
                           </div>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                           <a class="dropdown-item premium-dropdown-item" href="index.php?action=info_user">
                              <i class="fas fa-user"></i>
                              <span>Thông tin cá nhân</span>
                           </a>
                        </li>
                        <li>
                           <a class="dropdown-item premium-dropdown-item" href="index.php?action=order_history">
                              <i class="fas fa-history"></i>
                              <span>Lịch sử mua hàng</span>
                           </a>
                        </li>
                        <li>
                           <a href="index.php?action=change_password" id="change_password" class="dropdown-item premium-dropdown-item">
                              <i class="fas fa-key"></i>
                              <span>Đổi mật khẩu</span>
                           </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                           <a class="dropdown-item premium-dropdown-item logout-item" href="index.php?action=user&act=logout_User">
                              <i class="fas fa-sign-out-alt"></i>
                              <span>Đăng xuất</span>
                           </a>
                        </li>
                     </ul>
                  </div>
               </div>
            <?php } else { ?>
               <div class="action-item auth-container">
                  <div class="dropdown premium-auth-dropdown">
                     <a class="nav-link premium-auth" data-bs-toggle="dropdown" href="#">
                        <div class="auth-icon">
                           <i class="fas fa-user"></i>
                        </div>
                        <span class="auth-text">Tài khoản</span>
                        <div class="dropdown-arrow">
                           <i class="fas fa-chevron-down"></i>
                        </div>
                     </a>
                     <ul class="dropdown-menu premium-dropdown">
                        <li>
                           <a class="dropdown-item premium-dropdown-item" href="index.php?action=User&act=login">
                              <i class="fas fa-sign-in-alt"></i>
                              <span>Đăng nhập</span>
                           </a>
                        </li>
                        <li>
                           <a class="dropdown-item premium-dropdown-item" href="index.php?action=User&act=register">
                              <i class="fas fa-user-plus"></i>
                              <span>Đăng ký</span>
                           </a>
                        </li>
                     </ul>
                  </div>
               </div>
            <?php } ?>
         </div>
      </div>
   </div>
</nav>

<!-- Header CSS -->
<link rel="stylesheet" href="<?= BASE_URL ?>/View/assets/css/header.css">
<!-- Footer CSS -->
<link rel="stylesheet" href="<?= BASE_URL ?>/View/assets/css/footer.css">