<?php
$act = 'order_deliveried';
if (isset($_GET['act'])) {
   $act = $_GET['act'];
}

switch ($act) {
   case "order_deliveried":
      include_once "./View/Admin/order_deliveried.php";
      break;
   // Đổ đơn hàng đã giao
   case 'get_order_deliveried':
      include_once ('../../Model/DBConfig.php');
      include_once ('../../Model/API.php');
      include_once ('../../Model/Status.php');
      include_once ('../../Model/Order.php');
      $connect = new connect();
      $API = new API();
      $status = new Status();
      $Order = new Order();
      $start = $_POST['start'];
      $Result_Orders = $Order->getAll_OrderedLimit($start, 10)->fetchAll(PDO::FETCH_ASSOC);
      echo json_encode($Result_Orders);
      break;
}