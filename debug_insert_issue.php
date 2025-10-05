<?php
// Script debug chuyên sâu cho vấn đề insert vào MySQL
session_start();

echo "<h2>Debug MySQL Insert Issue</h2>";

// 1. Kiểm tra database connection
echo "<h3>1. Database Connection Test:</h3>";
try {
    require_once 'Model/DBConfig.php';
    $db = new connect();
    echo "✅ Database connection successful<br>";
    
    // Test basic query
    $testQuery = $db->getInstance("SELECT 1 as test");
    if ($testQuery && $testQuery['test'] == 1) {
        echo "✅ Basic query test passed<br>";
    } else {
        echo "❌ Basic query test failed<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
    exit;
}

// 2. Kiểm tra cấu trúc bảng orders
echo "<h3>2. Orders Table Structure:</h3>";
try {
    $structure = $db->getList("DESCRIBE orders");
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
} catch (Exception $e) {
    echo "❌ Error getting table structure: " . $e->getMessage() . "<br>";
}

// 3. Test insert trực tiếp
echo "<h3>3. Direct Insert Test:</h3>";
$testOrderId = 'DEBUG-' . time();
try {
    // Test với dữ liệu tối thiểu
    $sql = "INSERT INTO orders(fullname, number_phone, address, order_id, user_id, create_at) 
           VALUES ('Test User', '0123456789', 'Test Address', '$testOrderId', 1, NOW())";
    
    echo "SQL: " . htmlspecialchars($sql) . "<br>";
    
    $result = $db->exec($sql);
    echo "Insert result: " . $result . "<br>";
    
    if ($result > 0) {
        echo "✅ Direct insert successful!<br>";
        
        // Xóa test record
        $db->exec("DELETE FROM orders WHERE order_id = '$testOrderId'");
        echo "✅ Test record cleaned up<br>";
    } else {
        echo "❌ Direct insert failed (result = $result)<br>";
        
        // Kiểm tra lỗi MySQL
        $errorInfo = $db->db->errorInfo();
        echo "MySQL Error: " . $errorInfo[2] . "<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Direct insert exception: " . $e->getMessage() . "<br>";
}

// 4. Test với Order model
echo "<h3>4. Order Model Test:</h3>";
try {
    require_once 'Model/API.php';
    require_once 'Model/Order.php';
    
    $orderModel = new Order();
    $testOrderId2 = 'MODEL-TEST-' . time();
    
    echo "Testing Order model insert...<br>";
    $result = $orderModel->add_Order(
        'Model Test User',
        '0987654321', 
        'Model Test Address',
        1, 1, 1,
        $testOrderId2,
        1
    );
    
    echo "Order model insert result: " . $result . "<br>";
    
    if ($result > 0) {
        echo "✅ Order model insert successful!<br>";
        
        // Xóa test record
        $db->exec("DELETE FROM orders WHERE order_id = '$testOrderId2'");
        echo "✅ Model test record cleaned up<br>";
    } else {
        echo "❌ Order model insert failed<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Order model exception: " . $e->getMessage() . "<br>";
}

// 5. Test với session data thực tế
echo "<h3>5. Real Session Data Test:</h3>";
if (isset($_SESSION['user_id'])) {
    try {
        $orderModel = new Order();
        $testOrderId3 = 'SESSION-TEST-' . time();
        
        $fullname = $_SESSION['fullname'] ?? 'Session User';
        $phone = $_SESSION['number_phone'] ?? '0123456789';
        $address = $_SESSION['address'] ?? 'Session Address';
        $user_id = $_SESSION['user_id'];
        
        echo "Using session data:<br>";
        echo "- user_id: $user_id<br>";
        echo "- fullname: $fullname<br>";
        echo "- phone: $phone<br>";
        echo "- address: $address<br>";
        
        $result = $orderModel->add_Order(
            $fullname,
            $phone,
            $address,
            1, 1, 1,
            $testOrderId3,
            $user_id
        );
        
        echo "Session data insert result: " . $result . "<br>";
        
        if ($result > 0) {
            echo "✅ Session data insert successful!<br>";
            
            // Xóa test record
            $db->exec("DELETE FROM orders WHERE order_id = '$testOrderId3'");
            echo "✅ Session test record cleaned up<br>";
        } else {
            echo "❌ Session data insert failed<br>";
        }
        
    } catch (Exception $e) {
        echo "❌ Session data exception: " . $e->getMessage() . "<br>";
    }
} else {
    echo "⚠️ No session data available for testing<br>";
}

// 6. Kiểm tra quyền database
echo "<h3>6. Database Permissions Check:</h3>";
try {
    $permissions = $db->getList("SHOW GRANTS FOR CURRENT_USER()");
    echo "Current user grants:<br>";
    while ($grant = $permissions->fetch()) {
        echo "- " . $grant[0] . "<br>";
    }
} catch (Exception $e) {
    echo "❌ Cannot check permissions: " . $e->getMessage() . "<br>";
}

// 7. Kiểm tra MySQL variables
echo "<h3>7. MySQL Variables:</h3>";
try {
    $variables = $db->getList("SHOW VARIABLES LIKE 'sql_mode'");
    while ($var = $variables->fetch()) {
        echo "sql_mode: " . $var['Value'] . "<br>";
    }
} catch (Exception $e) {
    echo "❌ Cannot check MySQL variables: " . $e->getMessage() . "<br>";
}

echo "<br><a href='index.php'>← Home</a>";
?>
