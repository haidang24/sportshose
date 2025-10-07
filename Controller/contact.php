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

         // Sanitize and validate input
         $fullname = htmlspecialchars(trim($_POST['fullname'] ?? ''), ENT_QUOTES, 'UTF-8');
         $email = trim($_POST['email'] ?? '');
         $number_phone = trim($_POST['number_phone'] ?? '');
         $content = htmlspecialchars(trim($_POST['content'] ?? ''), ENT_QUOTES, 'UTF-8');

         // Validation checks
         if ($fullname === '' || $email === '' || $number_phone === '' || $content === '') {
            echo json_encode(['status' => 400, 'message' => 'Vui lòng điền đầy đủ thông tin']);
            exit;
         }

         if (strlen($fullname) < 2 || strlen($fullname) > 100) {
            echo json_encode(['status' => 400, 'message' => 'Họ tên phải từ 2-100 ký tự']);
            exit;
         }

         if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['status' => 400, 'message' => 'Email không hợp lệ']);
            exit;
         }

         if (!preg_match('/^[0-9]{10,11}$/', $number_phone)) {
            echo json_encode(['status' => 400, 'message' => 'Số điện thoại không hợp lệ (10-11 số)']);
            exit;
         }

         if (strlen($content) < 10 || strlen($content) > 1000) {
            echo json_encode(['status' => 400, 'message' => 'Nội dung phải từ 10-1000 ký tự']);
            exit;
         }

         // Include models - fix path (called from index.php, not from Controller/)
         include_once "./Model/DBConfig.php";
         include_once "./Model/Contact.php";
         include_once "./Model/API.php";

         try {
            $connect = new connect();
            $API = new API();
            $Contact = new Contact();
            $result = $Contact->add_Contact($fullname, $number_phone, $email, $content);

            if($result) {
               echo json_encode(['status' => 200, 'message' => 'Cảm ơn bạn! Chúng tôi đã nhận được liên hệ và sẽ phản hồi sớm nhất.']);
            } else {
               echo json_encode(['status' => 500, 'message' => 'Gửi liên hệ thất bại, vui lòng thử lại.']);
            }
         } catch (Exception $e) {
            error_log("Contact form error: " . $e->getMessage());
            echo json_encode(['status' => 500, 'message' => 'Có lỗi xảy ra, vui lòng thử lại sau.']);
         }
         exit;
         break;
   }