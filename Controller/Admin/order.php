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
      // Load order details
      include_once('../../Model/DBConfig.php');
      include_once('../../Model/API.php');
      include_once('../../Model/Order.php');
      
      $connect = new connect();
      $Order = new Order();
      
      // Get order ID from parameter
      $order_id = $_GET['order_id'] ?? '';
      
      if ($order_id) {
         // Get order details
         $order_details = $Order->getOrderDetails($order_id);
         
         // Get order items
         $order_items = $Order->getOrderItems($order_id);
         
         // Store in session for the view
         $_SESSION['order_details'] = $order_details;
         $_SESSION['order_items'] = $order_items;
      }
      
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
      $Result_Orders = $Order->getAll_Order();
      if ($Result_Orders) {
         $orders = $Result_Orders->fetchAll(PDO::FETCH_ASSOC);
         echo json_encode($orders);
      } else {
         echo json_encode([]);
      }
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
   
   // Đếm đơn hàng đang giao
   case 'count_shipping_orders':
      include_once('../../Model/DBConfig.php');
      include_once('../../Model/API.php');
      include_once('../../Model/Order.php');
      $connect = new connect();
      $API = new API();
      $Order = new Order();
      $result = $Order->count_shipping_orders();
      echo json_encode($result['dem']);
      break;
   
   // Đếm đơn hàng đã giao
   case 'count_delivered_orders':
      include_once('../../Model/DBConfig.php');
      include_once('../../Model/API.php');
      include_once('../../Model/Order.php');
      $connect = new connect();
      $API = new API();
      $Order = new Order();
      $result = $Order->count_delivered_orders();
      echo json_encode($result['dem']);
      break;
   
   // Đếm đơn hàng đã hủy
   case 'count_cancelled_orders':
      include_once('../../Model/DBConfig.php');
      include_once('../../Model/API.php');
      include_once('../../Model/Order.php');
      $connect = new connect();
      $API = new API();
      $Order = new Order();
      $result = $Order->count_cancelled_orders();
      echo json_encode($result['dem']);
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
      
      // Kiểm tra quy trình hợp lệ
      $current_status = $Order->getOrderStatus($order_id);
      $payment_method = $Order->getOrderPaymentMethod($order_id);
      
      if (!$Order->isValidStatusTransition($current_status, $status_id, $payment_method)) {
         $errorMessage = 'Quy trình xử lý đơn hàng không cho phép chuyển từ trạng thái này sang trạng thái khác';
         
         // Thông báo cụ thể cho trường hợp PayPal
         if ($payment_method === 'PayPal' && $status_id == 4) {
            $errorMessage = 'Đơn hàng thanh toán bằng PayPal không thể hủy. Chỉ có thể chuyển sang "Đang giao" hoặc "Đã giao".';
         }
         
         $res = [
            'status' => 400,
            'message' => $errorMessage,
         ];
         echo json_encode($res);
         break;
      }
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
         
         // Cập nhật status thành 4 (đã hủy) thay vì xóa đơn hàng
         $result_status = $Order->updateOrderStatus($order_id, 4);
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