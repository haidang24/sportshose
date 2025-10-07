<?php
$act = 'change_password';
if (isset($_GET['act'])) {
   $act = $_GET['act'];
}

switch ($act) {
   case 'change_password';
      include_once './View/change_password.php';
      break;
   case 'update_password':
      include "../Model/DBConfig.php";
      include "../Model/API.php";
      include "../Model/user.php";
      $connect = new connect();
      $API = new API();
      $user = new User();
      $user_id = $_POST['user_id'];
      $password_old = $_POST['password_old'];
      $password_new = $_POST['password_new'];
      $confirm_password_new = $_POST['confirm_password_new'];
      $flag = false;
      if ($password_new == $confirm_password_new) {
         $check_password_user = $user->get_password_user($user_id);
         // Verify old password using salted SHA-256 if salt is present, fallback to bcrypt for legacy
         $is_valid = false;
         if ($check_password_user && isset($check_password_user['password'])) {
            if (isset($check_password_user['salt']) && $check_password_user['salt']) {
               $expected = hash('sha256', $check_password_user['salt'] . $password_old);
               $is_valid = hash_equals($check_password_user['password'], $expected);
            } elseif (strlen($check_password_user['password']) > 0 && str_starts_with($check_password_user['password'], '$2y$')) {
               $is_valid = password_verify($password_old, $check_password_user['password']);
            }
         }
         if ($is_valid) {
            $result_update = $user->update_password_user($user_id, $password_new);
            if ($result_update) {
               $res = [
                  'status' => 200,
                  'message' => 'Thay đổi mật khẩu thành công',
               ];
               $flag = true;
            }
         } else if ($check_password_user) {
            $res = [
               'status' => 404,
               'message' => 'Mật khẩu cũ không đúng',
            ];
            $flag = true;
         }
      } else {
         $res = [
            'status' => 403,
            'message' => 'Mật khẩu mới không khớp nhau',
         ];
         $flag = true;
      }

      if ($flag == false) {
         $res = [
            // 'status' => 201,
            'message' => 'Mật khẩu cũ và mật khẩu mới giống nhau'
         ];
      }
      echo json_encode($res);
      break;
   case 'update_password_admin':
      include "../Model/DBConfig.php";
      include "../Model/API.php";
      include "../Model/user.php";
      $connect = new connect();
      $API = new API();
      $user = new User();
      $admin_id = $_POST['admin_id'];
      $password_old = $_POST['password_old'];
      $password_new = $_POST['password_new'];
      $confirm_password = $_POST['confirm_password'];
      $flag = false;
      if ($password_new == $confirm_password) {
         $check_password_user = $user->get_password_admin($admin_id);
         $is_valid = false;
         if ($check_password_user && isset($check_password_user['password'])) {
            if (isset($check_password_user['salt']) && $check_password_user['salt']) {
               $expected = hash('sha256', $check_password_user['salt'] . $password_old);
               $is_valid = hash_equals($check_password_user['password'], $expected);
            } elseif (strlen($check_password_user['password']) > 0 && str_starts_with($check_password_user['password'], '$2y$')) {
               $is_valid = password_verify($password_old, $check_password_user['password']);
            }
         }
         if ($is_valid) {
            $result_update = $user->update_password_admin($admin_id, $password_new);
            if ($result_update) {
               $res = [
                  'status' => 200,
                  'message' => 'Thay đổi mật khẩu thành công',
               ];
               $flag = true;
            }
         } else if ($check_password_user) {
            $res = [
               'status' => 404,
               'message' => 'Mật khẩu cũ không đúng',
            ];
            $flag = true;
         }
      } else {
         $res = [
            'status' => 403,
            'message' => 'Mật khẩu mới không khớp nhau',
         ];
         $flag = true;
      }

      if ($flag == false) {
         $res = [
            // 'status' => 201,
            'message' => 'Mật khẩu cũ và mật khẩu mới giống nhau'
         ];
      }
      echo json_encode($res);
      break;
}