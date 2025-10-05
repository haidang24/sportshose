<?php
// Script test database connection cơ bản
echo "<h2>Database Connection Test</h2>";

// Test 1: Basic PDO connection
echo "<h3>1. Basic PDO Connection Test:</h3>";
try {
    $dsn = 'mysql:host=localhost;dbname=ecoshop';
    $user = 'root';
    $pass = '';
    
    $pdo = new PDO($dsn, $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8'));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ PDO connection successful<br>";
    
    // Test basic query
    $stmt = $pdo->query("SELECT 1 as test");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result['test'] == 1) {
        echo "✅ Basic query test passed<br>";
    }
    
    // Test insert
    echo "<h3>2. Direct Insert Test:</h3>";
    $testId = 'CONNECTION-TEST-' . time();
    
    $sql = "INSERT INTO orders(fullname, number_phone, address, order_id, user_id, create_at) 
           VALUES ('Connection Test', '0123456789', 'Test Address', '$testId', 999, NOW())";
    
    echo "SQL: " . htmlspecialchars($sql) . "<br>";
    
    $affectedRows = $pdo->exec($sql);
    echo "Affected rows: " . $affectedRows . "<br>";
    
    if ($affectedRows > 0) {
        echo "✅ Direct insert successful!<br>";
        
        // Verify insert
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE order_id = ?");
        $stmt->execute([$testId]);
        $inserted = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($inserted) {
            echo "✅ Insert verification successful<br>";
            echo "Inserted data: " . json_encode($inserted) . "<br>";
        }
        
        // Clean up
        $pdo->exec("DELETE FROM orders WHERE order_id = '$testId'");
        echo "✅ Test record cleaned up<br>";
    } else {
        echo "❌ Direct insert failed<br>";
        
        // Check error info
        $errorInfo = $pdo->errorInfo();
        echo "PDO Error: " . $errorInfo[2] . "<br>";
    }
    
} catch (PDOException $e) {
    echo "❌ PDO Error: " . $e->getMessage() . "<br>";
    echo "Error Code: " . $e->getCode() . "<br>";
} catch (Exception $e) {
    echo "❌ General Error: " . $e->getMessage() . "<br>";
}

// Test 2: Using our connect class
echo "<h3>3. Connect Class Test:</h3>";
try {
    require_once 'Model/DBConfig.php';
    
    $connect = new connect();
    echo "✅ Connect class instantiated<br>";
    
    // Test query
    $result = $connect->getInstance("SELECT 1 as test");
    if ($result && $result['test'] == 1) {
        echo "✅ Connect class query test passed<br>";
    }
    
    // Test insert
    $testId2 = 'CLASS-TEST-' . time();
    $sql = "INSERT INTO orders(fullname, number_phone, address, order_id, user_id, create_at) 
           VALUES ('Class Test', '0987654321', 'Class Address', '$testId2', 998, NOW())";
    
    echo "SQL: " . htmlspecialchars($sql) . "<br>";
    
    $result = $connect->exec($sql);
    echo "Connect class insert result: " . $result . "<br>";
    
    if ($result > 0) {
        echo "✅ Connect class insert successful!<br>";
        
        // Clean up
        $connect->exec("DELETE FROM orders WHERE order_id = '$testId2'");
        echo "✅ Connect class test record cleaned up<br>";
    } else {
        echo "❌ Connect class insert failed<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Connect class error: " . $e->getMessage() . "<br>";
}

// Test 3: Check database info
echo "<h3>4. Database Info:</h3>";
try {
    $stmt = $pdo->query("SELECT DATABASE() as current_db, USER() as current_user, VERSION() as mysql_version");
    $info = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "Current Database: " . $info['current_db'] . "<br>";
    echo "Current User: " . $info['current_user'] . "<br>";
    echo "MySQL Version: " . $info['mysql_version'] . "<br>";
    
    // Check table info
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM orders");
    $count = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Orders table count: " . $count['count'] . "<br>";
    
} catch (Exception $e) {
    echo "❌ Database info error: " . $e->getMessage() . "<br>";
}

echo "<br><a href='index.php'>← Home</a>";
?>
