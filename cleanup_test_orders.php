<?php
// Script để xóa các đơn hàng test
require_once 'Model/DBConfig.php';

echo "<h2>Cleanup Test Orders</h2>";

try {
    $db = new connect();
    
    // Xóa chi tiết đơn hàng test
    $detailsResult = $db->exec("DELETE FROM details_order WHERE order_id LIKE 'TEST-%'");
    echo "✅ Đã xóa $detailsResult chi tiết đơn hàng test<br>";
    
    // Xóa đơn hàng test
    $ordersResult = $db->exec("DELETE FROM orders WHERE order_id LIKE 'TEST-%'");
    echo "✅ Đã xóa $ordersResult đơn hàng test<br>";
    
    // Xóa đơn hàng COD test
    $codDetailsResult = $db->exec("DELETE FROM details_order WHERE order_id LIKE 'COD-%'");
    echo "✅ Đã xóa $codDetailsResult chi tiết đơn hàng COD test<br>";
    
    $codOrdersResult = $db->exec("DELETE FROM orders WHERE order_id LIKE 'COD-%'");
    echo "✅ Đã xóa $codOrdersResult đơn hàng COD test<br>";
    
    echo "<br><strong>Hoàn thành cleanup!</strong><br>";
    
} catch (Exception $e) {
    echo "❌ Lỗi: " . $e->getMessage() . "<br>";
}

echo "<br><a href='index.php'>← Quay lại trang chủ</a>";
?>
