<?php
// Debug script để kiểm tra đơn hàng trong database
require_once 'Model/DBConfig.php';
require_once 'Model/API.php';
require_once 'Model/Order.php';

echo "<h2>Debug Orders in Database</h2>";

try {
    $db = new connect();
    $orderModel = new Order();
    
    echo "✅ Kết nối database thành công<br><br>";
    
    // Lấy tất cả đơn hàng
    $allOrders = $db->getList("SELECT * FROM orders ORDER BY create_at DESC LIMIT 10");
    echo "<h3>10 đơn hàng gần nhất:</h3>";
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>ID</th><th>Order ID</th><th>Fullname</th><th>Phone</th><th>Address</th><th>User ID</th><th>Create At</th><th>Status</th></tr>";
    
    $orderCount = 0;
    while ($order = $allOrders->fetch()) {
        $orderCount++;
        echo "<tr>";
        echo "<td>" . $order['id'] . "</td>";
        echo "<td>" . $order['order_id'] . "</td>";
        echo "<td>" . htmlspecialchars($order['fullname']) . "</td>";
        echo "<td>" . $order['number_phone'] . "</td>";
        echo "<td>" . htmlspecialchars($order['address']) . "</td>";
        echo "<td>" . $order['user_id'] . "</td>";
        echo "<td>" . $order['create_at'] . "</td>";
        echo "<td>" . $order['status'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    if ($orderCount == 0) {
        echo "<p style='color: red;'>❌ Không có đơn hàng nào trong database!</p>";
    } else {
        echo "<p>✅ Tìm thấy $orderCount đơn hàng</p>";
    }
    
    echo "<br><h3>Chi tiết đơn hàng:</h3>";
    $detailsOrders = $db->getList("SELECT * FROM details_order ORDER BY order_id DESC LIMIT 10");
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Order ID</th><th>Product Name</th><th>Size</th><th>Quantity</th><th>Price</th><th>Total Price</th></tr>";
    
    $detailCount = 0;
    while ($detail = $detailsOrders->fetch()) {
        $detailCount++;
        echo "<tr>";
        echo "<td>" . $detail['order_id'] . "</td>";
        echo "<td>" . htmlspecialchars($detail['name_product']) . "</td>";
        echo "<td>" . $detail['size'] . "</td>";
        echo "<td>" . $detail['quantity'] . "</td>";
        echo "<td>" . number_format($detail['price']) . "đ</td>";
        echo "<td>" . number_format($detail['total_price']) . "đ</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    if ($detailCount == 0) {
        echo "<p style='color: red;'>❌ Không có chi tiết đơn hàng nào trong database!</p>";
    } else {
        echo "<p>✅ Tìm thấy $detailCount chi tiết đơn hàng</p>";
    }
    
    // Kiểm tra session hiện tại
    echo "<br><h3>Session hiện tại:</h3>";
    session_start();
    echo "<pre>";
    echo "user_id: " . ($_SESSION['user_id'] ?? 'Không có') . "\n";
    echo "fullname: " . ($_SESSION['fullname'] ?? 'Không có') . "\n";
    echo "number_phone: " . ($_SESSION['number_phone'] ?? 'Không có') . "\n";
    echo "address: " . ($_SESSION['address'] ?? 'Không có') . "\n";
    echo "email: " . ($_SESSION['email'] ?? 'Không có') . "\n";
    echo "cart: " . (isset($_SESSION['cart']) ? count($_SESSION['cart']) . ' items' : 'Không có') . "\n";
    echo "</pre>";
    
    // Test query lịch sử đơn hàng
    if (isset($_SESSION['user_id'])) {
        echo "<br><h3>Test query lịch sử cho user_id = " . $_SESSION['user_id'] . ":</h3>";
        $userOrders = $orderModel->get_all_order($_SESSION['user_id']);
        if ($userOrders) {
            $orders = $userOrders->fetchAll(PDO::FETCH_ASSOC);
            echo "<p>✅ Tìm thấy " . count($orders) . " đơn hàng cho user này</p>";
            if (count($orders) > 0) {
                echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
                echo "<tr><th>Order ID</th><th>Fullname</th><th>Create At</th><th>Status</th></tr>";
                foreach ($orders as $order) {
                    echo "<tr>";
                    echo "<td>" . $order['order_id'] . "</td>";
                    echo "<td>" . htmlspecialchars($order['fullname']) . "</td>";
                    echo "<td>" . $order['create_at'] . "</td>";
                    echo "<td>" . $order['status'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        } else {
            echo "<p style='color: red;'>❌ Không tìm thấy đơn hàng nào cho user này</p>";
        }
    } else {
        echo "<p style='color: orange;'>⚠️ Không có user_id trong session</p>";
    }
    
} catch (Exception $e) {
    echo "❌ Lỗi: " . $e->getMessage() . "<br>";
}

echo "<br><a href='index.php'>← Quay lại trang chủ</a>";
?>
