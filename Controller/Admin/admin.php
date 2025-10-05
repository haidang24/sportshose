<?php
$act = 'admin';
if (isset($_GET['act'])) {
   $act = $_GET['act'];
}

switch ($act) {
   case 'admin':
      include_once "./View/Admin/admin.php";
      break;
   case 'get_all_admin':
      include_once ('../../Model/DBConfig.php');
      include_once ('../../Model/API.php');
      include_once ('../../Model/Admin.php');
      $connect = new connect();
      $API = new API();
      $admin = new admin();
      $result = $admin->get_all_admin()->fetchAll(PDO::FETCH_ASSOC);
      echo json_encode($result);
      break;
   case 'get_admin_id':
      include_once ('../../Model/DBConfig.php');
      include_once ('../../Model/API.php');
      include_once ('../../Model/Admin.php');
      $connect = new connect();
      $API = new API();
      $admin = new admin();
      $admin_id = $_POST['admin_id'];
      $result = $admin->get_admin_id($admin_id)->fetch(PDO::FETCH_ASSOC);
      echo json_encode($result);
      break;
   case 'add_admin':
      include_once ('../../Model/DBConfig.php');
      include_once ('../../Model/API.php');
      include_once ('../../Model/Admin.php');
      $connect = new connect();
      $API = new API();
      $admin = new admin();
      $fullname = $_POST['emp_name'];
      $start_date = $_POST['emp_start_date'];
      $username = $_POST['emp_username'];
      $password = $_POST['emp_password'];
      $phone = $_POST['emp_phone'];
      $position = $_POST['emp_position'];
      $feature = $_POST['feature'];
      
      $feature_string = implode('-', $feature);

      $result = $admin->add_admin($fullname, $username, $password, $phone, $start_date, $position, $feature_string);
      if ($result) {
         $res = [
            'status' => 200,
            'message' => 'Thêm nhân viên thành công'
         ];
      }
      echo json_encode($res);
      break;
   case 'edit_admin':
      include_once ('../../Model/DBConfig.php');
      include_once ('../../Model/API.php');
      include_once ('../../Model/Admin.php');
      $connect = new connect();
      $API = new API();
      $admin = new admin();
      $fullname = $_POST['emp_name1'];
      $start_date = $_POST['emp_start_date1'];
      $username = $_POST['emp_username1'];
      $password = $_POST['emp_password1'];
      $phone = $_POST['emp_phone1'];
      $position = $_POST['emp_position1'];
      $feature = $_POST['feature'];
      $admin_id = $_POST['emp_admin_id'];

      // Chuyển mảng thành chuỗi 
      $feature_string = implode('-', $feature);

      // $result = $admin->update_admin($fullname, $username, $password, $phone, $start_date, $position, $feature_string, $admin_id);
      $result = $admin->update_admin($fullname, $username, $password, $phone, $start_date, $position, $feature_string, $admin_id);
      if ($result) {
         $res = [
            'status' => 200,
            'message' => 'Cập nhật nhân viên thành công'
         ];
      }else {
         $res = [
            'status' => 404, 
            'message' => 'Hãy thay đổi thông tin',
         ];
      }
      echo json_encode($res);
      break;
   case 'delete_admin':
      include_once ('../../Model/DBConfig.php');
      include_once ('../../Model/API.php');
      include_once ('../../Model/Admin.php');
      $connect = new connect();
      $API = new API();
      $admin = new admin();
      $admin_id = $_POST['admin_id'];
      $result = $admin->delete_admin($admin_id);
      if ($result) {
         $res = [
            'status' => 200,
            'message' => 'Xóa nhân viên thành công'
         ];
      }
      echo json_encode($res);
      break;
   case 'update_info_admin':
      include_once ('../../Model/DBConfig.php');
      include_once ('../../Model/API.php');
      include_once ('../../Model/Admin.php');
      $connect = new connect();
      $API = new API();
      $admin = new admin();
      $email = $_POST['email'];
      $address = $_POST['address'];
      $date_of_birth = $_POST['date_of_birth'];
      $gender = $_POST['gender'];
      $avatar = $_POST['avatar'];
      $admin_id = $_POST['admin_id'];
      $result = $admin->update_info_admin($email, $address, $date_of_birth, $gender, $avatar, $admin_id);
      if ($result) {
         $res = [
            'status' => 200,
            'message' => 'Cập nhật thông tin thành công'
         ];
      }else {
         $res = [
            'status' => 404,
            'message' => 'Hãy thay đổi thông tin'
         ];
      }
      echo json_encode($res);
      break;
}