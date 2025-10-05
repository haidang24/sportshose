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
         $fullname = $_POST['fullname'];
         $email = $_POST['email'];
         $number_phone = $_POST['number_phone'];
         $content = $_POST['content'];
         include "../Model/DBConfig.php";
         include "../Model/Contact.php";
         include "../Model/API.php";
         $connect = new connect();
         $API = new API();
         $Contact = new Contact();
         $result = $Contact->add_Contact($fullname, $number_phone, $email, $content);
         if($result) {
            $res = [
               'status' => 200,
               'message' => 'Bạn đã liên hệ thành công'
            ];
         }
         echo json_encode($res);
         break;
   }