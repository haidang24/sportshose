<?php
class Contact
{
   function add_Contact($fullname, $number_phone, $email, $contact)
   {
      $API = new API();
      return $API->add_delete_update("INSERT INTO contact(fullname, number_phone, email, content, status) 
         VALUES ('$fullname','$number_phone','$email','$contact', 'Chờ xử lý')");
   }

   function getAll_Contact()
   {
      $API = new API();
      return $API->get_All('SELECT * FROM contact GROUP BY id DESC');
   }

   function update_status($id)
   {
      $API = new API();
      return $API->add_delete_update("UPDATE contact SET status ='Đã xử lý' WHERE id=$id");
   }

   // Đếm số lượng liên hệ chưa xử lý
   function count_contact()
   {
      $API = new API();
      return $API->get_one("SELECT COUNT(*) as dem FROM contact WHERE status='Chờ xử lý'");
   }
}