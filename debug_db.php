<?php
// Debug script để kiểm tra kết nối database và bảng orders
require_once 'Model/DBConfig.php';

echo "<h2>Debug Database Connection</h2>";

try {
    $db = new connect();
    echo "✅ Kết nối database thành công<br>";
    
    // Kiểm tra bảng orders
    $result = $db->getInstance("SHOW TABLES LIKE 'orders'");
    if ($result) {
        echo "✅ Bảng 'orders' tồn tại<br>";
        
        // Kiểm tra cấu trúc bảng orders
        $structure = $db->getList("DESCRIBE orders");
        echo "<h3>Cấu trúc bảng orders:</h3>";
        echo "<table border='1' style='border-collapse: collapse;'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        while ($row = $structure->fetch()) {
            echo "<tr>";
            echo "<td>" . $row['Field'] . "</td>";
            echo "<td>" . $row['Type'] . "</td>";
            echo "<td>" . $row['Null'] . "</td>";
            echo "<td>" . $row['Key'] . "</td>";
            echo "<td>" . ($row['Default'] ?? 'NULL') . "</td>";
            echo "<td>" . ($row['Extra'] ?? '') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Kiểm tra bảng details_order
        $result2 = $db->getInstance("SHOW TABLES LIKE 'details_order'");
        if ($result2) {
            echo "✅ Bảng 'details_order' tồn tại<br>";
        } else {
            echo "❌ Bảng 'details_order' không tồn tại<br>";
        }
        
        // Test insert đơn giản
        $testOrderId = 'TEST-' . time();
        $testSql = "INSERT INTO orders(fullname, number_phone, address, order_id, user_id, create_at) 
                   VALUES ('Test User', '0123456789', 'Test Address', '$testOrderId', 1, CURRENT_TIMESTAMP)";
        
        $insertResult = $db->exec($testSql);
        if ($insertResult > 0) {
            echo "✅ Test insert thành công<br>";
            
            // Xóa test record
            $db->exec("DELETE FROM orders WHERE order_id = '$testOrderId'");
            echo "✅ Test record đã được xóa<br>";
        } else {
            echo "❌ Test insert thất bại<br>";
        }
        
    } else {
        echo "❌ Bảng 'orders' không tồn tại<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Lỗi: " . $e->getMessage() . "<br>";
}

echo "<br><a href='index.php'>← Quay lại trang chủ</a>";
?>
