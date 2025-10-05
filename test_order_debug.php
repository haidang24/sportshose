<?php
session_start();
require_once 'Model/DBConfig.php';
require_once 'Model/API.php';
require_once 'Model/Order.php';

echo "<h2>Debug Order System</h2>";

// Check session data
echo "<h3>Session Data:</h3>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    echo "<h3>User ID: $user_id</h3>";
    
    // Get orders for this user
    try {
        $connect = new connect();
        $API = new API();
        $Order = new Order();
        
        $result = $Order->get_all_order($user_id)->fetchAll(PDO::FETCH_ASSOC);
        echo "<h3>Orders found: " . count($result) . "</h3>";
        
        if (count($result) > 0) {
            echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
            echo "<tr><th>ID</th><th>Order ID</th><th>Fullname</th><th>Phone</th><th>Address</th><th>Status</th><th>Created</th></tr>";
            
            foreach ($result as $order) {
                echo "<tr>";
                echo "<td>" . $order['id'] . "</td>";
                echo "<td>" . $order['order_id'] . "</td>";
                echo "<td>" . $order['fullname'] . "</td>";
                echo "<td>" . $order['number_phone'] . "</td>";
                echo "<td>" . $order['address'] . "</td>";
                echo "<td>" . $order['status'] . "</td>";
                echo "<td>" . $order['create_at'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No orders found for this user.</p>";
        }
        
    } catch (Exception $e) {
        echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
    }
    
} else {
    echo "<p style='color: red;'>User not logged in.</p>";
}

// Check database connection
echo "<h3>Database Connection Test:</h3>";
try {
    $connect = new connect();
    echo "<p style='color: green;'>Database connection successful.</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>Database connection failed: " . $e->getMessage() . "</p>";
}

// Check if orders table exists
echo "<h3>Orders Table Check:</h3>";
try {
    $connect = new connect();
    $API = new API();
    $result = $API->get_All("SHOW TABLES LIKE 'orders'");
    if (count($result) > 0) {
        echo "<p style='color: green;'>Orders table exists.</p>";
        
        // Show table structure
        $structure = $API->get_All("DESCRIBE orders");
        echo "<h4>Orders table structure:</h4>";
        echo "<table border='1' style='border-collapse: collapse;'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        foreach ($structure as $field) {
            echo "<tr>";
            echo "<td>" . $field['Field'] . "</td>";
            echo "<td>" . $field['Type'] . "</td>";
            echo "<td>" . $field['Null'] . "</td>";
            echo "<td>" . $field['Key'] . "</td>";
            echo "<td>" . $field['Default'] . "</td>";
            echo "<td>" . $field['Extra'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color: red;'>Orders table does not exist.</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>Error checking table: " . $e->getMessage() . "</p>";
}
?>
