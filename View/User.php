<div class="container mt-5 mb-5">
   <div class="form-container">
      <?php
      if (isset($_GET['action']) && isset($_GET['act']) && $_GET['act'] == 'register') {
         echo "<form id='register' class='form'>";
         echo '<h2 class="form-title text-success">Đăng ký</h2>';
      } else {
         echo "<form id='formLogin_User' class='form'>";
         echo '<h2 class="form-title text-success">Đăng nhập</h2>';
      }

      ?>
      <div class="auth-brand text-center mb-3">
         <div class="logo-text">SPORT <span>SHOES</span></div>
      </div>
      <p class="form-subtitle text-center mb-4">Chào mừng trở lại! Vui lòng đăng nhập hoặc tạo tài khoản mới.</p>

      <div class="wallet-login mb-3">
         <button type="button" id="userMetaMaskLogin" class="btn btn-metamask w-100 d-flex align-items-center justify-content-center">
            <svg class="me-2" width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path d="M20.5 8.5L13 3L5.5 8.5L8 13.5L13 15.5L18 13.5L20.5 8.5Z" fill="#E17726" stroke="#E17726" stroke-width="0.5"/>
               <path d="M8 13.5L5.5 18L11 21L13 19.5V15.5L8 13.5Z" fill="#E27625"/>
               <path d="M18 13.5L13 15.5V19.5L15 21L20.5 18L18 13.5Z" fill="#E27625"/>
               <path d="M13 3L8 13.5L13 15.5L18 13.5L13 3Z" fill="#E27625"/>
            </svg>
            <span class="fw-semibold">Đăng nhập bằng MetaMask</span>
         </button>
      </div>
      <div class="divider"><span>Hoặc tiếp tục với email</span></div>
      <?php

      if (isset($_GET['action']) && isset($_GET['act']) && $_GET['act'] == 'register'):
         ?>
         <div class="row">
            <div class="col-md-6">
               <div class="input-container">
                  <label for="firstname">Họ</label>
                  <input id="firstname" name="firstname" type="text" placeholder="Nhập họ">
                  <small id="firstname_error" class="text-danger badge"></small>
               </div>
            </div>
            <div class="col-md-6">
               <div class="input-container">
                  <label for="lastname">Tên</label>
                  <input id="lastname" name="lastname" type="text" placeholder="Nhập tên">
                  <small id="lastname_error" class="text-danger badge"></small>
               </div>
            </div>
         </div>
      <?php endif; ?>
      <div class="input-container">
         <label for="email">Gmail</label>
         <input id="email" name="email" type="text" placeholder="Nhập email">
         <small id="email_error" class="text-danger badge"></small>
      </div>
      <div class="input-container">
         <label for="password">Mật khẩu</label>
         <input id="password" name="password" type="password" placeholder="Nhập password">
         <small id="password_error" class="text-danger badge"></small>
      </div>
      <?php
      if (isset($_GET['action']) && isset($_GET['act']) && $_GET['act'] == 'register') {
         ?>
         <div class="input-container">
            <label for="confirm_password">Nhập Lại Mật khẩu</label>
            <input id="confirm_password" name="confirm_password" type="password" placeholder="Nhập lại password">
            <small id="confirm_password_error" class="text-danger badge"></small>
         </div>
      <?php } ?>

      <div class="form-check">
         <input class="form-check-input" type="checkbox" id="show_password">
         <label class="form-check-label" for="show_password">
            Hiện mật khẩu
         </label>
      </div>

      <div class="social-login mb-3">
         <button type="button" class="btn btn-social google"><i class="fab fa-google me-2"></i>Google</button>
         <button type="button" class="btn btn-social facebook"><i class="fab fa-facebook-f me-2"></i>Facebook</button>
      </div>

      <div class="divider"><span>Hoặc</span></div>

      <?php
      if (isset($_GET['action']) && isset($_GET['act']) && $_GET['act'] == 'register') {
         echo '<button type="submit" class="submit">Đăng ký</button>';
      } else {
         echo '<button name="login_submit" type="submit" class="submit">Đăng nhập</button>';
      }
      ?>

      <p class="signup-link">
         Bạn đã có tài khoản?
         <?php
         if (isset($_GET['action']) && isset($_GET['act']) && $_GET['act'] == 'register') {
            ?>
            <a class="fw-bolder text-dark" href="index.php?action=user&act=login">Đăng nhập</a>
         <?php } else { ?>
            <a class="fw-bolder text-dark" href="index.php?action=user&act=register">Đăng ký</a>
         <div class="d-flex justify-content-center">
            <a type="button" class="text-dark fw-bolder" data-bs-toggle="modal"
               data-bs-target="#exampleModal">Quên mật khẩu?</a>
         </div>
      <?php } ?>
      </p>


      </form>
   </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Lấy lại mật khẩu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <form id="Form_Mail">
               <div class="mb-3">
                  <label for="confirm_email" class="form-label">Email</label>
                  <input id="confirm_email" type="text" class="form-control" placeholder="Nhập email của bạn">
                  <small id="confirm_email_error" class="badge text-danger"></small>
                  <small id="confirm_email_success" class="badge text-success"></small>
               </div>
               <div class="d-flex justify-content-end">
                  <button type="submit" class="btn btn-outline-success">Gửi</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>


<style>
   body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
   }

   .form-container {
      max-width: 500px;
      margin: 50px auto;
      padding: 30px;
      background-color: #ffffff;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      border-top: 5px solid green;
      /* Bright orange for sports theme */
   }

   .form-title {
      font-size: 28px;
      font-weight: bold;
      margin-bottom: 20px;
      text-align: center;
      /* color: green; */
      /* Bright orange for sports theme */
   }

   .input-container {
      margin-bottom: 20px;
   }

   .input-container label {
      display: block;
      margin-bottom: 8px;
      font-weight: 600;
      color: #495057;
   }

   .input-container input {
      width: 100%;
      padding: 12px;
      border: 2px solid #e2e8f0;
      border-radius: 12px;
      transition: border-color 0.3s;
      background: #f7fafc;
   }

   .input-container input:focus {
      border-color: #667eea;
      box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
      background: #fff;
      outline: none;
   }

   .form-check {
      margin-bottom: 20px;
   }

   .form-check label {
      cursor: pointer;
      color: #495057;
   }

   .submit {
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 12px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: #ffffff;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
   }

   .submit:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(102, 126, 234, 0.45);
      background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
   }

   .signup-link {
      text-align: center;
      margin-top: 20px;
      color: #495057;
   }

   .signup-link a {
      color: #667eea;
      font-weight: bold;
      transition: color 0.3s;
   }

   .signup-link a:hover { color: #764ba2; text-decoration: underline; }

   .modal-content {
      border-radius: 10px;
   }

   .modal-header {
      border-bottom: none;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: #ffffff;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
   }

   .btn-metamask {
      background: linear-gradient(135deg, #f6851b 0%, #e2761b 100%);
      color: #fff;
      border: none;
      border-radius: 12px;
      padding: 12px 16px;
      font-size: 15px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(246, 133, 27, 0.25);
   }
   .btn-metamask:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(246,133,27,0.35); }

   .modal-body {
      padding: 30px;
   }

   .modal-footer {
      border-top: none;
      padding-bottom: 20px;
   }
</style>
<!-- Font Awesome for social icons (already loaded in header normally) -->