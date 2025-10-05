<?php
$act = 'order_cancel';
if (isset($_GET['act'])) {
   $act = $_GET['act'];
}

switch ($act) {
   case "order_cancel":
      include_once "./View/Admin/order_cancel.php";
      break;
   //Đổ đơn hàng đã hủy
   case 'get_order_cancel':
      include_once('../../Model/DBConfig.php');
      include_once('../../Model/API.php');
      include_once('../../Model/Status.php');
      include_once('../../Model/Order.php');
      $connect = new connect();
      $API = new API();
      $status = new Status();
      $Order = new Order();
      $Result_Orders = $Order->get_cancel_order()->fetchAll(PDO::FETCH_ASSOC);
      echo json_encode($Result_Orders);
      break;
}