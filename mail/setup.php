<?php
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
   public function sendMail($title, $content, $addressMail)
   {
      $mail = new PHPMailer(true);
      // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
      $mail->isSMTP();
      $mail->CharSet = 'utf-8';
      //Send using SMTP
      $mail->Host = 'smtp.gmail.com';        
      $mail->SMTPAuth = true;                  
      $mail->Username = 'chuongtoan1602@gmail.com';  
      $mail->Password = 'hmfpofkuwgfvwxhz';        
      $mail->SMTPSecure = 'tls';
      $mail->Port = '587';
      //Recipients
      $mail->setFrom('chuongtoan1602@gmail.com', 'ShopGiay');
      $mail->addAddress($addressMail); 
      //Content
      $mail->isHTML(true);                       
      $mail->Subject = $title;
      $mail->Body = $content;

      if ($mail->Send()) {
         return array('status' => 200, 'mes' => 'Đã gửi mã thành công.');
      } else {
         return array('status' => 403, 'mes' => 'Gửi không thành công.');

      }
   }
}