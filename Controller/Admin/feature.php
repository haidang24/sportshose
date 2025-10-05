<?php
if (isset($_GET['act'])) {
   $act = $_GET['act'];
}
switch ($act) {
   case 'get_feature_id':
      include_once ('../../Model/DBConfig.php');
      include_once ('../../Model/API.php');
      include_once ('../../Model/Admin.php');
      $connect = new connect();
      $API = new API();
      $admin = new admin();
      $admin_id = $_POST['admin_id'];
      $result = $admin->get_admin_id($admin_id)->fetchAll(PDO::FETCH_ASSOC);
      echo json_encode($result);
      break;
}