<?php
//  include "../Model/DBConfig.php";
//  include "../Model/User.php";
//  include "../Model/API.php";
$act = 'login';
if (isset($_GET['act'])) {
   $act = $_GET['act'];
}

switch ($act) {
   case 'login':
      include_once "./View/User.php";
      break;
   case 'register':
      include_once "./View/User.php";
      break;
   // link đến trang xác nhận mã
   case 'confirm_code':
      include_once './View/confirm_code.php';
      break;
   // link đến trang thay đổi mật khẩu
   case 'reset_pass':
      include_once './View/reset_pass.php';
      break;
   // Thực hiện việc đăng nhập user
   case 'login_action':
      session_start();
      include "../Model/DBConfig.php";
      include "../Model/User.php";
      include "../Model/API.php";
      $connect = new connect();
      $API = new API();
      $user = new User();
      $email = $_POST['email'];
      $password = $_POST['password'];
      $result = $user->login_User($email, $password);
      if($result) {
         $_SESSION['user_id'] = $result['id'];
         $_SESSION['lastname'] = $result['lastname'];
         $_SESSION['firstname'] = $result['firstname'];
         $_SESSION['fullname'] = $result['firstname'] . ' ' . $result['lastname'];
         $_SESSION['email'] = $result['email'];
         $res = [
            'status' => 200,
            'message' => 'Đăng nhập thành công',
         ];
      }else {
         $res = [
            'status' => 404,
            'message' => 'Đăng nhập thất bại',
         ];
      }
      echo json_encode($res);
      break;
   case 'metamask_login':
      // Basic MetaMask login (improve later with nonce store/verify)
      session_start();
      $address = $_POST['address'] ?? '';
      $signature = $_POST['signature'] ?? '';
      $message = $_POST['message'] ?? '';
      if ($address && $signature && $message) {
         // For now, accept and create a lightweight session
         $_SESSION['user_wallet'] = $address;
         $_SESSION['login_method'] = 'metamask';
         $res = [ 'status' => 200, 'message' => 'MetaMask authentication successful', 'address' => $address ];
      } else {
         $res = [ 'status' => 400, 'message' => 'Invalid MetaMask payload' ];
      }
      header('Content-Type: application/json');
      echo json_encode($res);
      break;
   // Thực hiệc việc đăng ký
   case 'register_action':
      include "../Model/DBConfig.php";
      include "../Model/User.php";
      include "../Model/API.php";

      $firstname = $_POST['firstname'];
      $lastname = $_POST['lastname'];
      $email = $_POST['email'];
      $password = $_POST['password'];
      $connect = new connect();
      $API = new API();
      $user = new User();
      $kq = $user->getOne_UserByEmail($email);
      if ($kq) {
         $res = [
            'status' => 422,
            'message' => 'Tài khoản đã tồn tại',
         ];
         echo json_encode($res); // Gửi chuyển dữ liệu JSON
      } else {
         $user->add_User($lastname, $firstname, $email, $password);
         $res = [
            'status' => 200,
            'message' => 'Bạn đã tạo tài khoản thành công'
         ];
         echo json_encode($res); // Gửi chuyển dữ liệu JSON
      }
      break;
   // thực hiện việc đăng xuất
   case 'logout_User':
      unset($_SESSION['user_id']);
      unset($_SESSION['lastname']);
      unset($_SESSION['fullname']);
      unset($_SESSION['number_phone']);
      unset($_SESSION['address']);
      unset($_SESSION['wards']);
      unset($_SESSION['district']);
      unset($_SESSION['province']);
      unset($_SESSION['province_id']);
      unset($_SESSION['district_id']);
      unset($_SESSION['wards_id']);

      echo '<meta http-equiv="refresh" content="0;url=index.php?action=user"/>';
      break;
}