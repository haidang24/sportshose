<?php 
   class admin {
      function get_all_role() {
         $API = new API();
         return $API->get_All("SELECT * FROM role");
      }

      function get_all_admin() {
         $API = new API();
         return $API->get_All("SELECT * FROM admin");
      }

      function get_admin_id($id) {
         $API = new API();
         return $API->get_All("SELECT * FROM admin WHERE admin_id=$id");
      }

      function add_admin($fullname, $username, $password, $number_phone, $start_date, $position, $feature) {
         $API = new API();
         return $API->add_delete_update("INSERT INTO admin(fullname, username, password, number_phone, start_date, position, feature) 
         VALUES ('$fullname','$username','$password','$number_phone','$start_date','$position','$feature')");
      }

      function update_admin($fullname, $username, $password, $number_phone, $start_date, $position, $feature, $admin_id) {
         $API = new API();
         return $API->add_delete_update("UPDATE admin 
         SET fullname='$fullname',username='$username',password='$password',number_phone='$number_phone',start_date='$start_date',position='$position',feature='$feature'
         WHERE admin_id=$admin_id");
      }

      function delete_admin($id) {
         $API = new API();
         return $API->add_delete_update("DELETE FROM admin WHERE admin_id=$id");
      }

      function update_info_admin($email, $address, $date_of_birth, $gender, $profile_picture, $admin_id) {
         $API = new API();
         return $API->add_delete_update("UPDATE admin SET email='$email',address='$address',date_of_birth='$date_of_birth',gender='$gender',profile_picture='$profile_picture',updated='1' WHERE admin_id=$admin_id");
      }
   }  