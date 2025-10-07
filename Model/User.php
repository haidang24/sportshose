<?php 
   class User {
      // Lấy khách hàng chưa vào thùng rác
      function getAll_User() {
         $API = new API();
         return $API->get_All("SELECT * FROM user WHERE user.delete_at IS NULL");
      }

      // Lấy khách hàng vào thùng rác
      function getAllClear_User() {
         $API = new API();
         return $API->get_All("SELECT * FROM `user` WHERE user.delete_at IS NOT NULL");
      }

      // Lấy khách hàng LIMIT
      function getAll_UserLimit($start, $end) {
         $API = new API();
         return $API->get_All("SELECT * FROM `user` WHERE user.delete_at IS NULL LIMIT $start, $end");
      }

      function getOne_User($id) {
         $API = new API();
         return $API->get_one("SELECT * FROM user WHERE id=$id");
      }

      // Login (Admin) with salted SHA-256 verification (fallback to bcrypt if present)
      function login_Employee($user, $password) {
         $API = new API();
         // Fetch admin by username then verify hash
         $admin = $API->get_one("SELECT * FROM admin WHERE username='$user'");
         if ($admin && isset($admin['password'])) {
            // Prefer salted SHA-256 if salt column exists
            if (isset($admin['salt']) && $admin['salt']) {
               $expected = hash('sha256', $admin['salt'] . $password);
               if (hash_equals($admin['password'], $expected)) {
                  return $admin;
               }
            }
            // Fallback: support existing bcrypt passwords until fully migrated/purged
            if (strlen($admin['password']) > 0 && str_starts_with($admin['password'], '$2y$')) {
               if (password_verify($password, $admin['password'])) {
                  return $admin;
               }
            }
         }
         return false;
      } 

      // Lấy User theo email
      function getOne_UserByEmail($email) {
         $API = new API();
         return $API->get_one("SELECT user.email FROM user WHERE email='$email'");
      }

      function login_User($email, $password) {
         $API = new API();
         // Fetch user by email and verify password using salted SHA-256 (fallback to bcrypt)
         $user = $API->get_one("SELECT id, lastname, firstname, email, password, salt FROM user WHERE email='$email' AND delete_at is null");
         if ($user && isset($user['password'])) {
            if (isset($user['salt']) && $user['salt']) {
               $expected = hash('sha256', $user['salt'] . $password);
               if (hash_equals($user['password'], $expected)) {
                  return $user;
               }
            }
            if (strlen($user['password']) > 0 && str_starts_with($user['password'], '$2y$')) {
               if (password_verify($password, $user['password'])) {
                  return $user;
               }
            }
         }
         return false;
      }

      function add_User($lastname, $firstname, $email, $password) {
         $API = new API();
         $salt = bin2hex(random_bytes(16));
         $hashedPassword = hash('sha256', $salt . $password);
         return $API->add_delete_update("INSERT INTO `user`(`lastname`, `firstname`, `email`, `password`, `salt`) VALUES ('$lastname','$firstname','$email','$hashedPassword','$salt')");
      }

      function updatePass_User($newpass, $id) {
         $API = new API();
         $salt = bin2hex(random_bytes(16));
         $hashedPassword = hash('sha256', $salt . $newpass);
         return $API->add_delete_update("UPDATE `user` SET `password`='$hashedPassword', `salt`='$salt' WHERE id=$id");
      }

      // Chỉ đưa vào thùng rác không xóa 
      function delete_User($id) {
         $API = new API();
         return $API ->add_delete_update("UPDATE user SET delete_at = CURRENT_TIMESTAMP WHERE id=$id");
      }

      // Khôi phục
      function Restore_User($id) {
         $API = new API();
         return $API ->add_delete_update("UPDATE user SET delete_at = NULL WHERE id=$id");
      }

      // Xóa Vĩnh Viễn
      function clear_User($id) {
         $API = new API();
         return $API ->add_delete_update("DELETE FROM user WHERE id=$id");
      }

      // Kiểm tra mail tồn 
      function check_Mail($email) {
         $API = new API();
         return $API->get_All("SELECT email FROM user WHERE email='$email' AND delete_at IS NULL");
      }

      // Update password User (by email) with new salt
      function update_Password($email, $newpass) {
         $API = new API();
         $salt = bin2hex(random_bytes(16));
         $hashedPassword = hash('sha256', $salt . $newpass);
         return $API->add_delete_update("UPDATE user SET password='$hashedPassword', salt='$salt' WHERE email='$email'");
      }

      // Lấy ra thông tin của khách hàng bằng ID
      function getUserInfo_ID($id) {
         $API = new API();
         return $API->get_All("SELECT * FROM user_address WHERE user_id=$id");
      }

      // Thêm thông tin khách hàng
      function add_user_address($user_id, $fullname, $number_phone, $address, $wards, $district, $province) {
         $API = new API();
         return $API->add_delete_update("INSERT INTO user_address(user_id, fullname, number_phone, address, wards, district, province, role) 
         VALUES ('$user_id', '$fullname', '$number_phone', '$address', '$wards', '$district', '$province', 1)");
      }

      // Cập nhật thông tin khách hàng
      function updateUserInfo_ID($user_id, $fullname, $number_phone, $address, $wards, $district, $province) {
         $API = new API();
         return $API->add_delete_update("UPDATE user_address 
         SET fullname='$fullname',number_phone='$number_phone',address='$address',wards='$wards',district='$district',province='$province' 
         WHERE user_id=$user_id");
      }

      // Lấy thông tin khách hàng với bảng province, district, wards bằng ID
      function delete_user_address($id) {
         $API = new API();
         return $API->add_delete_update("DELETE FROM user_address WHERE user_address.id=$id");
      }

      function getUserInfoPDW_ByID($user_id) {
         $API = new API();
         return $API->get_All("SELECT user_address.id, user_address.user_id, user_address.fullname, user_address.number_phone, user_address.address, province.name as province, district.name as district, wards.name as wards , province.province_id as province_id, district.district_id as district_id, wards.wards_id as wards_id, user_address.role
         FROM user_address, province, district, wards 
         WHERE user_address.wards = wards.wards_id AND user_address.district = district.district_id AND user_address.province = province.province_id AND user_address.user_id = $user_id ORDER BY user_address.id DESC");
      }

      // Lấy bảng user_address bằng id
      function get_user_adress_id($id) {
         $API = new API();
         return $API->get_one("SELECT * FROM user_address WHERE id=$id");
      }

      // Chọn địa chỉ giao hàng cho user
      function chose_address($id) {
         $API = new API();
         return $API->add_delete_update("UPDATE user_address SET role=1 WHERE id=$id");
      }

      // Chuyển tất cả role về 0 cho theo user_id
      function chose_address_isZero($user_id) {
         $API = new API();
         return $API->add_delete_update("UPDATE user_address SET role=0 WHERE user_id=$user_id");
      }

      // Thêm hình ảnh 
      function save_avatar($user_id, $avatar) {
         $API = new API();
         return $API->add_delete_update("INSERT INTO `user_avatar`(`user_id`, `avatar`) 
         VALUES ('$user_id','$avatar')");
      }

      // Cập nhật avatar
      function update_avatar($user_id, $avatar) {
         $API = new API();
         return $API->add_delete_update("UPDATE user_avatar 
         SET avatar='$avatar' WHERE user_id = '$user_id'");
      }

      // Lấy hình ảnh theo ID 
      function get_avatar_id($user_id) {
         $API = new API();
         return $API->get_one("SELECT * FROM user_avatar WHERE user_id='$user_id'");
      }

      // Cập nhật thông tin cho user
      function update_info_user($user_id, $lastname, $firstname, $gender, $day, $month, $year, $number_phone) {
         try {
            $API = new API();
            
            // Debug input parameters
            error_log("update_info_user called with: " . json_encode([
               'user_id' => $user_id,
               'lastname' => $lastname,
               'firstname' => $firstname,
               'gender' => $gender,
               'day' => $day,
               'month' => $month,
               'year' => $year,
               'number_phone' => $number_phone
            ]));
            
            // Escape strings để tránh SQL injection
            $lastname = addslashes($lastname);
            $firstname = addslashes($firstname);
            $gender = addslashes($gender);
            $number_phone = addslashes($number_phone);
            $user_id = (int)$user_id;
            
            // Format birthday
            $birthday = '';
            if ($year && $month && $day) {
               $birthday = sprintf('%04d-%02d-%02d', $year, $month, $day);
            }
            
            $sql = "UPDATE user 
                    SET lastname='$lastname',firstname='$firstname',gender='$gender',birthday='$birthday',number_phone='$number_phone' 
                    WHERE id=$user_id";
            
            error_log("Executing SQL: " . $sql);
            
            $result = $API->add_delete_update($sql);
            
            error_log("Update result: " . var_export($result, true));
            
            return $result;
            
         } catch (Exception $e) {
            error_log("Exception in update_info_user: " . $e->getMessage());
            throw $e;
         }
      }

      // Lấy ra mật khẩu và salt của user
      function get_password_user($user_id) {
         $API = new API();
         return $API->get_one("SELECT password, salt FROM user WHERE id=$user_id");
      }

      // Lấy ra mật khẩu và salt của admin
      function get_password_admin($admin_id) {
         $API = new API();
         return $API->get_one("SELECT password, salt FROM admin WHERE admin_id=$admin_id");
      }

      // Thực hiện việc thay đổi mật khẩu user (hash new password with new salt)
      function update_password_user($user_id, $password_new) {
         $API = new API();
         $salt = bin2hex(random_bytes(16));
         $hashedPassword = hash('sha256', $salt . $password_new);
         return $API->add_delete_update("UPDATE user SET password='$hashedPassword', salt='$salt' WHERE id='$user_id'");
      }

      // Thực hiện việc thay đổi mật khẩu admin (hash new password with new salt)
      function update_password_admin($admin_id, $password_new) {
         $API = new API();
         $salt = bin2hex(random_bytes(16));
         $hashedPassword = hash('sha256', $salt . $password_new);
         return $API->add_delete_update("UPDATE admin SET password='$hashedPassword', salt='$salt' WHERE admin_id='$admin_id'");
      }

      // Đếm tổng số khách hàng
      function count_users()
      {
         $API = new API();
         $result = $API->get_one("SELECT COUNT(*) as dem FROM user WHERE delete_at IS NULL");
         return $result;
      }
   }