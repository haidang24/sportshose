<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$act = 'order_history';
if (isset($_GET['act'])) {
   $act = $_GET['act'];
}

switch ($act) {
   case 'order_history':
      // Sửa đúng tên thư mục View (chữ V hoa)
      include_once "View/order_history.php";
      break;
   case 'get_all_order':
      include "../Model/DBConfig.php";
      include "../Model/API.php";
      include "../Model/Order.php";
      $connect = new connect();
      $API = new API();
      $Order = new Order();
      $user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : (int)($_SESSION['user_id'] ?? 0);
      if ($user_id <= 0) {
         error_log("Undefined user_id when fetching order history");
         echo json_encode([]);
         break;
      }
      
      // Debug log
      error_log("Getting orders for user_id: " . $user_id);
      
      try {
         $result = $Order->get_all_order($user_id)->fetchAll(PDO::FETCH_ASSOC);
         error_log("Found " . count($result) . " orders for user_id: " . $user_id);
         echo json_encode($result);
      } catch (Exception $e) {
         error_log("Error getting orders: " . $e->getMessage());
         echo json_encode([]);
      }
      break;
   case 'get_order_details':
      include "../Model/DBConfig.php";
      include "../Model/API.php";
      include "../Model/Order.php";
      $connect = new connect();
      $API = new API();
      $Order = new Order();
      $order_id = $_POST['order_id'];
      $result = $Order->getAll_DetailsOrderByID($order_id)->fetchAll(PDO::FETCH_ASSOC);
      echo json_encode($result);
      break;
   case 'cancel_order':
      include "../Model/DBConfig.php";
      include "../Model/API.php";
      include "../Model/Order.php";
      $connect = new connect();
      $API = new API();
      $Order = new Order();
      $order_id = $_POST['order_id'];
      
      try {
         // Check if order exists and belongs to user
         $user_id = $_SESSION['user_id'] ?? null;
         if (!$user_id) {
            echo json_encode(['status' => 'error', 'message' => 'Vui lòng đăng nhập']);
            exit;
         }
         
         // Get order details
         $order = $API->get_one("SELECT * FROM orders WHERE order_id = '$order_id' AND user_id = $user_id");
         
         if (!$order) {
            echo json_encode(['status' => 'error', 'message' => 'Đơn hàng không tồn tại']);
            exit;
         }
         
         // Check if order can be cancelled (only status = 1)
         if ($order['status'] != 1) {
            echo json_encode(['status' => 'error', 'message' => 'Không thể hủy đơn hàng này']);
            exit;
         }
         
         // Cancel order (set status to 0 and deleted_at to current time)
         $sql = "UPDATE orders SET status = 0, deleted_at = CURRENT_TIMESTAMP WHERE order_id = '$order_id'";
         $result = $API->add_delete_update($sql);
         
         if ($result) {
            // Restore product quantities
            $details = $Order->getAll_DetailsOrderByID($order_id)->fetchAll(PDO::FETCH_ASSOC);
            include "../Model/Product.php";
            $Product = new Product();
            
            foreach ($details as $detail) {
               $Product->increase_quantity($detail['name_product'], $detail['size'], $detail['quantity']);
            }
            
            echo json_encode(['status' => 'success', 'message' => 'Đơn hàng đã được hủy thành công']);
         } else {
            echo json_encode(['status' => 'error', 'message' => 'Không thể hủy đơn hàng']);
         }
         
      } catch (Exception $e) {
         error_log("Error cancelling order: " . $e->getMessage());
         echo json_encode(['status' => 'error', 'message' => 'Có lỗi xảy ra khi hủy đơn hàng']);
      }
      break;
}