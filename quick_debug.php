<?php
// Script debug nhanh
session_start();

echo "<h2>Quick Debug</h2>";

// Kiểm tra session
echo "<h3>Session Info:</h3>";
echo "<pre>";
echo "user_id: " . ($_SESSION['user_id'] ?? 'NULL') . "\n";
echo "fullname: " . ($_SESSION['fullname'] ?? 'NULL') . "\n";
echo "email: " . ($_SESSION['email'] ?? 'NULL') . "\n";
echo "</pre>";

// Kiểm tra database connection
echo "<h3>Database Test:</h3>";
try {
    require_once 'Model/DBConfig.php';
    $db = new connect();
    echo "✅ Database connection OK<br>";
    
    // Đếm tổng số đơn hàng
    $totalOrders = $db->getInstance("SELECT COUNT(*) as total FROM orders");
    echo "📊 Tổng số đơn hàng: " . $totalOrders['total'] . "<br>";
    
    // Đếm đơn hàng của user hiện tại
    if (isset($_SESSION['user_id'])) {
        $userOrders = $db->getInstance("SELECT COUNT(*) as total FROM orders WHERE user_id = " . $_SESSION['user_id']);
        echo "👤 Đơn hàng của user " . $_SESSION['user_id'] . ": " . $userOrders['total'] . "<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Database error: " . $e->getMessage() . "<br>";
}

// Test Order model
echo "<h3>Order Model Test:</h3>";
try {
    require_once 'Model/API.php';
    require_once 'Model/Order.php';
    $orderModel = new Order();
    echo "✅ Order model loaded OK<br>";
    
    if (isset($_SESSION['user_id'])) {
        $userOrders = $orderModel->get_all_order($_SESSION['user_id']);
        if ($userOrders) {
            $orders = $userOrders->fetchAll(PDO::FETCH_ASSOC);
            echo "✅ Found " . count($orders) . " orders for user " . $_SESSION['user_id'] . "<br>";
            
            if (count($orders) > 0) {
                echo "<h4>Latest Order:</h4>";
                $latest = $orders[0];
                echo "<pre>";
                echo "Order ID: " . $latest['order_id'] . "\n";
                echo "Fullname: " . $latest['fullname'] . "\n";
                echo "Status: " . $latest['status'] . "\n";
                echo "Create At: " . $latest['create_at'] . "\n";
                echo "</pre>";
            }
        } else {
            echo "❌ No orders found for user<br>";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Order model error: " . $e->getMessage() . "<br>";
}

echo "<br><a href='index.php'>← Home</a> | ";
echo "<a href='check_user_orders.php'>Check Orders</a> | ";
echo "<a href='test_live_payment.php'>Test Payment</a>";
?>
