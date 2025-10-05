<?php
$act = 'PHPMailer';
if (isset($_GET['act'])) {
   $act = $_GET['act'];
}

switch ($act) {
   case 'PHPMailer':
      session_start();
      $email = $_POST['mail'];
      include "../Model/DBConfig.php";
      include "../Model/User.php";
      include "../Model/API.php";
      include "../mail/setup.php";
      $connect = new connect();
      $API = new API();
      $user = new User();
      $mail = new Mailer();
      $check_result = $user->check_Mail($email)->fetch();
      $result = array();
      if ($check_result) {
         $code = substr(rand(0, 999999), 0, 6);
         $title = 'Quên mật khẩu';
         $content = "Mã xác nhận của bạn là: <span class='text-success'>" . $code . "</span>";
         $_SESSION['code'] = $code;
         $_SESSION['mail'] = $email;
         $result = $mail->sendMail($title, $content, $email);
      } else {
         $result = array('status' => 404, 'message' => 'Email không tồn tại');
      }
      echo json_encode($result);
      break;
   case 'confirm_code':
      session_start();
      $code = $_POST['code'];

      if ($code == $_SESSION['code']) {
         $res = [
            'status' => 200,
            'message' => 'Xác nhận thành công',
         ];
         echo json_encode($res);
      } else {
         if (!isset($_SESSION['count'])) {
            $_SESSION['count'] = 0; // Khởi tạo biến count nếu chưa tồn tại
         }

         // Nếu người dùng nhập quá 3 lần sẽ reload lại trang
         if ($_SESSION['count'] < 3) {
            // Cho user nhập 3 lần 
            $_SESSION['count']++;
         }
         
         // reset count
         if($_SESSION['count'] > 3) {
            unset($_SESSION['count']);
            unset($_SESSION['mail']);
         }

         $res = [
            'status' => 404,
            'message' => 'Mã xác nhận không hợp lệ',
            'count' => $_SESSION['count']++,
         ];
         echo json_encode($res);
      }
      break;  
   case 'changepass':
      session_start();
      include "../Model/DBConfig.php";
      include "../Model/User.php";
      include "../Model/API.php";
      $connect = new connect();
      $API = new API();
      $user = new User();
      $newpass = $_POST['newpass'];
      $result_user = $user->update_Password($_SESSION['mail'],$newpass);
      if ($result_user) {
         $res = [
            'status' => 200,
            'message' => 'Đổi mật khẩu thành công'
         ];
         unset($_SESSION['mail']);
         unset($_SESSION['code']);
      }
      echo json_encode($res);
      break;
}