<?php 
   $act = 'contact';
   if(isset($_GET['act'])) {
      $act = $_GET['act'];
   }

   switch($act) {
      case 'contact': 
         include_once './View/contact.php';
         break;
      case 'form_Contact':
         header('Content-Type: application/json');
         $fullname = trim($_POST['fullname'] ?? '');
         $email = trim($_POST['email'] ?? '');
         $number_phone = trim($_POST['number_phone'] ?? '');
         $content = trim($_POST['content'] ?? '');

         if ($fullname === '' || $email === '' || $number_phone === '' || $content === '') {
            echo json_encode(['status' => 400, 'message' => 'Vui lòng điền đầy đủ thông tin']);
            break;
         }
         if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['status' => 400, 'message' => 'Email không hợp lệ']);
            break;
         }
         include "../Model/DBConfig.php";
         include "../Model/Contact.php";
         include "../Model/API.php";
         $connect = new connect();
         $API = new API();
         $Contact = new Contact();
         $result = $Contact->add_Contact($fullname, $number_phone, $email, $content);
         if($result) {
            echo json_encode(['status' => 200, 'message' => 'Cảm ơn bạn! Chúng tôi đã nhận được liên hệ.']);
         } else {
            echo json_encode(['status' => 500, 'message' => 'Gửi liên hệ thất bại, vui lòng thử lại.']);
         }
         break;
   }