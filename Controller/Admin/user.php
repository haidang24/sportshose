<?php
$act = 'user';
if (isset($_GET['act'])) {
   $act = $_GET['act'];
}

switch ($act) {
   case 'user':
      include_once "./View/Admin/User.php";
      break;
   case 'khoiphuc':
      include_once "./View/Admin/restore_user.php";
      break;
   // Lấy tất cả User chưa đưa vào restore
   case 'getAll_User':
      include_once ('../../Model/DBConfig.php');
      include_once ('../../Model/API.php');
      include_once ('../../Model/User.php');
      $connect = new connect();
      $API = new API();
      $user = new User();
      $users = $user->getAll_User()->fetchAll();
      echo json_encode($users);
      break;
   // Lấy user đã đưa vào thùng rác
   case 'get_restore_user':
      include_once ('../../Model/DBConfig.php');
      include_once ('../../Model/API.php');
      include_once ('../../Model/User.php');
      $connect = new connect();
      $API = new API();
      $user = new User();
      $users = $user->getAllClear_User()->fetchAll();
      echo json_encode($users);
      break;
   // Lấy dữ liệu theo LIMIT
   case 'get_user_limit':
      include_once ('../../Model/DBConfig.php');
      include_once ('../../Model/API.php');
      include_once ('../../Model/User.php');
      $connect = new connect();
      $API = new API();
      $user = new User();
      $start = $_POST['start'];
      $users = $user->getAll_UserLimit($start, 10)->fetchAll();
      echo json_encode($users);
      break;
   case 'revise_password':
      $user_id = $_POST['user_id'];
      include_once ('../../Model/DBConfig.php');
      include_once ('../../Model/API.php');
      include_once ('../../Model/User.php');
      $connect = new connect();
      $API = new API();
      $user = new User();
      $result = $user->getOne_User($user_id);
      echo json_encode($result);
      break;
   case 'revise_password_action':
      $user_id = $_POST['user_id'];
      $pass_new = $_POST['pass_new'];
      include_once ('../../Model/DBConfig.php');
      include_once ('../../Model/API.php');
      include_once ('../../Model/User.php');
      $connect = new connect();
      $API = new API();
      $user = new User();
      $kq = $user->updatePass_User($pass_new, $user_id);
      if ($kq) {
         $res = [
            'status' => 200,
            'message' => 'Cập nhật thành công',
         ];
         echo json_encode($res);
      }
      break;
   // Bỏ chỗ này
   case 'update_user':
      include_once "./View/Admin/Edit_User.php";
      break;
   // ///
   case 'delete_user':
      $user_id = $_POST['user_id'];
      include_once ('../../Model/DBConfig.php');
      include_once ('../../Model/API.php');
      include_once ('../../Model/User.php');
      $connect = new connect();
      $API = new API();
      $user = new User();
      $kq = $user->delete_User($user_id);
      if ($kq) {
         $res = [
            'status' => 200,
            'message' => 'Đã chuyển vào thùng rác'
         ];
         echo json_encode($res);
      }
      break;
   case 'clear_user':
      $user_id = $_POST['user_id'];
      include_once ('../../Model/DBConfig.php');
      include_once ('../../Model/API.php');
      include_once ('../../Model/User.php');
      $connect = new connect();
      $API = new API();
      $user = new User();
      $kq = $user->clear_User($user_id);
      if ($kq) {
         $res = [
            'status' => 200,
            'message' => 'Xóa tài khoản thành công'
         ];
         echo json_encode($res);
      }
      break;
   case 'restore_user':
      $user_id = $_POST['user_id'];
      include_once ('../../Model/DBConfig.php');
      include_once ('../../Model/API.php');
      include_once ('../../Model/User.php');
      $connect = new connect();
      $API = new API();
      $user = new User();
      $kq = $user->Restore_User($user_id);
      if ($kq) {
         $res = [
            'status' => 200,
            'message' => 'Khôi phục tài khoản thành công'
         ];
         echo json_encode($res);
      }
      break;
   case 'info_user':
      include_once ('../../Model/DBConfig.php');
      include_once ('../../Model/API.php');
      include_once ('../../Model/User.php');
      $connect = new connect();
      $API = new API();
      $user = new User();
      $user_id = $_POST['user_id'];
      $users = $user->getUserInfoPDW_ByID($user_id);
      echo json_encode($users);
      break;
}