<?php
$act = 'order';
if (isset($_GET['act'])) {
   $act = $_GET['act'];
}

switch ($act) {
   case 'order':
      include_once './View/Admin/Order.php';
      break;
   case 'deliveried':
      include_once './View/Admin/order_deliveried.php';
   case 'cancel_order':
      include_once './View/Admin/cancel_order.php';
      break;
   case 'details':
      include_once './View/Admin/Order_Details.php';
      break;
   // Đổ đơn hàng đã chờ xử lý và đang giao 
   case 'get_order_delivery':
      include_once('../../Model/DBConfig.php');
      include_once('../../Model/API.php');
      include_once('../../Model/Status.php');
      include_once('../../Model/Order.php');
      $connect = new connect();
      $API = new API();
      $status = new Status();
      $Order = new Order();
      $Result_Orders = $Order->getAll_Order()->fetchAll(PDO::FETCH_ASSOC);
      echo json_encode($Result_Orders);
      break;
   // Đếm tổng số đơn chờ xử lý 
   case 'count_order_wating':
      include_once('../../Model/DBConfig.php');
      include_once('../../Model/API.php');
      include_once('../../Model/Status.php');
      include_once('../../Model/Order.php');
      $connect = new connect();
      $API = new API();
      $status = new Status();
      $Order = new Order();
      $Result_Orders = $Order->getAll_WaitOrder();
      echo json_encode($Result_Orders['total_orders']);
      break;
   case 'get_order_id':
      include_once('../../Model/DBConfig.php');
      include_once('../../Model/API.php');
      include_once('../../Model/Status.php');
      include_once('../../Model/Order.php');
      $connect = new connect();
      $API = new API();
      $status = new Status();
      $Order = new Order();
      $order_id = $_POST['order_id'];
      $result = $Order->getAll_DetailsOrderByID($order_id)->fetchAll(PDO::FETCH_ASSOC);
      echo json_encode($result);
      break;
   //Chuyển trạng thái đang giao
   case 'delivery_status':
      include_once ('../../Model/DBConfig.php');
      include_once ('../../Model/API.php');
      include_once ('../../Model/Status.php');
      include_once ('../../Model/Order.php');
      include_once ('../../Model/Goods_sold.php');
      $connect = new connect();
      $API = new API();
      $status = new Status();
      $Order = new Order();
      $goods_sold = new Goods_sold();
      $order_id = $_POST['order_id'];
      $status_id = $_POST['status_id'];
      if ($status_id == 2) {
         $result_status = $status->delivery_status($status_id, $order_id);
      } else if ($status_id == 3) {
         $result_status = $status->deliveried_status($status_id, $order_id);
      } else if ($status_id == 4) {
         // Chức năng cộng lại số lượng tồn khi hủy đơn bằng order_id
         $array = array();
         // Từ order ID lấy ra tên, size, quantity
         $product = $Order->getDetailsProduct_ByOrderID($order_id);
         while ($product_set = $product->fetchAll(PDO::FETCH_ASSOC)) {
            $array = $product_set;
         }
         // Từ tên và size cộng lại số lượng  bảng details_product
         foreach ($array as $arr) {
            $Order->increase_DetailsProduct($arr['name_product'], $arr['size'], $arr['quantity']);
         }

         // Từ tên và size trừ đi số lượng bảng goods_sold
         foreach ($array as $arr) {
            $Order->decrease_Goods_Sold($arr['name_product'], $arr['size'], $arr['quantity']);

            // Lấy ra bảng good_sold từ tên sản phẩm kiểm tra nếu nào = 0 thì xóa khỏi bảng
            $all_goods = $goods_sold->get_all_byname($arr['name_product']);
            while($set = $all_goods->fetch()) {
               // Thì kiểm nó có bằng 0 hay không 
               if($set['quantity_sold'] == 0) {
                  $goods_sold->delete_goods_sold($set['id']);
               }
            }
         }
         

         // $Order->delete_Details_Order($order_id);
         $result_status = $Order->delete_Order($order_id);
      };

      if ($result_status) {
         $res = [
            'status' => 200,
            'message' => 'Đã chuyển trạng thái',
         ];
      }
      echo json_encode($res);
      break;
}