<?php
// Script để kiểm tra đơn hàng của user cụ thể
session_start();

echo "<h2>Kiểm tra đơn hàng của User</h2>";

if (!isset($_SESSION['user_id'])) {
    echo "<div style='color: red;'>❌ Bạn cần đăng nhập!</div>";
    echo "<a href='index.php?action=User'>← Đăng nhập</a>";
    exit;
}

$userId = $_SESSION['user_id'];
echo "<h3>Đơn hàng của User ID: $userId</h3>";

require_once 'Model/DBConfig.php';
require_once 'Model/API.php';
require_once 'Model/Order.php';

try {
    $orderModel = new Order();
    $userOrders = $orderModel->get_all_order($userId);
    
    if ($userOrders) {
        $orders = $userOrders->fetchAll(PDO::FETCH_ASSOC);
        echo "<p>✅ Tìm thấy " . count($orders) . " đơn hàng</p>";
        
        if (count($orders) > 0) {
            echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
            echo "<tr><th>Order ID</th><th>Fullname</th><th>Phone</th><th>Address</th><th>Status</th><th>Create At</th></tr>";
            
            foreach ($orders as $order) {
                echo "<tr>";
                echo "<td>" . $order['order_id'] . "</td>";
                echo "<td>" . htmlspecialchars($order['fullname']) . "</td>";
                echo "<td>" . $order['number_phone'] . "</td>";
                echo "<td>" . htmlspecialchars($order['address']) . "</td>";
                echo "<td>" . $order['status'] . "</td>";
                echo "<td>" . $order['create_at'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            
            // Hiển thị chi tiết đơn hàng gần nhất
            if (count($orders) > 0) {
                $latestOrder = $orders[0];
                echo "<h4>Chi tiết đơn hàng gần nhất: " . $latestOrder['order_id'] . "</h4>";
                
                $details = $orderModel->getAll_DetailsOrderByID($latestOrder['order_id']);
                if ($details) {
                    $detailsArray = $details->fetchAll(PDO::FETCH_ASSOC);
                    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
                    echo "<tr><th>Product Name</th><th>Size</th><th>Quantity</th><th>Price</th><th>Total</th></tr>";
                    
                    foreach ($detailsArray as $detail) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($detail['name_product']) . "</td>";
                        echo "<td>" . $detail['size'] . "</td>";
                        echo "<td>" . $detail['quantity'] . "</td>";
                        echo "<td>" . number_format($detail['price']) . "đ</td>";
                        echo "<td>" . number_format($detail['total_price']) . "đ</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                }
            }
        }
    } else {
        echo "<p>❌ Không tìm thấy đơn hàng nào</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Lỗi: " . $e->getMessage() . "</p>";
}

echo "<br><a href='index.php'>← Quay lại trang chủ</a>";
?>
