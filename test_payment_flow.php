<?php
// Script test để kiểm tra quy trình thanh toán
session_start();

echo "<h2>Test Payment Flow</h2>";

// Kiểm tra session hiện tại
echo "<h3>1. Session hiện tại:</h3>";
echo "<pre>";
echo "user_id: " . ($_SESSION['user_id'] ?? 'Không có') . "\n";
echo "fullname: " . ($_SESSION['fullname'] ?? 'Không có') . "\n";
echo "email: " . ($_SESSION['email'] ?? 'Không có') . "\n";
echo "cart: " . (isset($_SESSION['cart']) ? count($_SESSION['cart']) . ' items' : 'Không có') . "\n";
echo "</pre>";

// Tạo giỏ hàng test
echo "<h3>2. Tạo giỏ hàng test:</h3>";
$_SESSION['cart'] = [
    [
        'name' => 'Giày Test',
        'size' => '42',
        'quantity' => 1,
        'img' => 'test.jpg',
        'price' => 500000,
        'idsp' => 'test123'
    ]
];
$_SESSION['fullname'] = 'Nguyễn Văn Test';
$_SESSION['number_phone'] = '0123456789';
$_SESSION['address'] = '123 Đường Test';
$_SESSION['province_id'] = 1;
$_SESSION['district_id'] = 1;
$_SESSION['wards_id'] = 1;
$_SESSION['email'] = 'test@example.com';

echo "✅ Đã tạo giỏ hàng test<br>";

// Test COD
echo "<h3>3. Test COD:</h3>";
$testOrderId = 'TEST-' . time();
$_POST = []; // Clear POST data

// Simulate COD request
ob_start();
$_GET['act'] = 'cod';
include 'Controller/paypal.php';
$output = ob_get_clean();

echo "Response: <pre>" . htmlspecialchars($output) . "</pre>";

// Kiểm tra database
echo "<h3>4. Kiểm tra database:</h3>";
require_once 'Model/DBConfig.php';
$db = new connect();
$orders = $db->getList("SELECT * FROM orders WHERE order_id LIKE 'TEST-%' ORDER BY create_at DESC LIMIT 5");
echo "<table border='1'>";
echo "<tr><th>Order ID</th><th>Fullname</th><th>User ID</th><th>Create At</th></tr>";
while ($order = $orders->fetch()) {
    echo "<tr>";
    echo "<td>" . $order['order_id'] . "</td>";
    echo "<td>" . htmlspecialchars($order['fullname']) . "</td>";
    echo "<td>" . $order['user_id'] . "</td>";
    echo "<td>" . $order['create_at'] . "</td>";
    echo "</tr>";
}
echo "</table>";

// Test lấy lịch sử đơn hàng
echo "<h3>5. Test lịch sử đơn hàng:</h3>";
if (isset($_SESSION['user_id'])) {
    require_once 'Model/API.php';
    require_once 'Model/Order.php';
    $orderModel = new Order();
    $userOrders = $orderModel->get_all_order($_SESSION['user_id']);
    if ($userOrders) {
        $orders = $userOrders->fetchAll(PDO::FETCH_ASSOC);
        echo "✅ Tìm thấy " . count($orders) . " đơn hàng cho user_id: " . $_SESSION['user_id'] . "<br>";
        if (count($orders) > 0) {
            echo "<table border='1'>";
            echo "<tr><th>Order ID</th><th>Fullname</th><th>Status</th></tr>";
            foreach ($orders as $order) {
                echo "<tr>";
                echo "<td>" . $order['order_id'] . "</td>";
                echo "<td>" . htmlspecialchars($order['fullname']) . "</td>";
                echo "<td>" . $order['status'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    } else {
        echo "❌ Không tìm thấy đơn hàng nào<br>";
    }
} else {
    echo "❌ Không có user_id trong session<br>";
}

echo "<br><a href='index.php'>← Quay lại trang chủ</a>";
?>
