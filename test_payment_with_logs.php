<?php
// Script test thanh toán với logging chi tiết
session_start();

echo "<h2>Test Payment with Detailed Logs</h2>";

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Kiểm tra session
if (!isset($_SESSION['user_id'])) {
    echo "<div style='color: red;'>❌ Bạn cần đăng nhập trước!</div>";
    echo "<a href='index.php?action=User'>← Đăng nhập</a>";
    exit;
}

echo "<h3>Session Data:</h3>";
echo "<pre>";
echo "user_id: " . $_SESSION['user_id'] . "\n";
echo "fullname: " . ($_SESSION['fullname'] ?? 'NULL') . "\n";
echo "email: " . ($_SESSION['email'] ?? 'NULL') . "\n";
echo "</pre>";

// Tạo giỏ hàng test
echo "<h3>Creating Test Cart:</h3>";
$_SESSION['cart'] = [
    [
        'name' => 'TEST PAYMENT PRODUCT',
        'size' => '42',
        'quantity' => 1,
        'img' => 'test.jpg',
        'price' => 50000,
        'idsp' => 'test_payment_' . time()
    ]
];

$_SESSION['fullname'] = $_SESSION['fullname'] ?? 'Test User';
$_SESSION['number_phone'] = '0123456789';
$_SESSION['address'] = 'Test Address';
$_SESSION['province_id'] = 1;
$_SESSION['district_id'] = 1;
$_SESSION['wards_id'] = 1;
$_SESSION['email'] = $_SESSION['email'] ?? 'test@example.com';

echo "✅ Cart created with 1 item (50,000đ)<br>";

// Test COD với logging
echo "<h3>Testing COD Payment:</h3>";
echo "<div id='payment-result'></div>";

echo "<button onclick='testPayment()' class='btn btn-primary'>Test COD Payment</button>";

?>

<script>
function testPayment() {
    const resultDiv = document.getElementById('payment-result');
    resultDiv.innerHTML = '<div class="spinner-border" role="status">Testing payment...</div>';
    
    // Log request details
    console.log('Starting payment test...');
    
    fetch('Controller/paypal.php?act=cod', { 
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);
        return response.text(); // Get as text first to see raw response
    })
    .then(text => {
        console.log('Raw response:', text);
        try {
            const data = JSON.parse(text);
            console.log('Parsed response:', data);
            
            if (data.status === 'OK') {
                resultDiv.innerHTML = '<div class="alert alert-success">✅ Payment successful! Order ID: ' + data.order_id + '</div>';
                
                // Redirect to check orders after 2 seconds
                setTimeout(() => {
                    window.location.href = 'check_user_orders.php';
                }, 2000);
            } else {
                resultDiv.innerHTML = '<div class="alert alert-danger">❌ Payment failed: ' + (data.message || 'Unknown error') + '</div>';
            }
        } catch (e) {
            console.error('JSON parse error:', e);
            resultDiv.innerHTML = '<div class="alert alert-warning">⚠️ Invalid JSON response: ' + text + '</div>';
        }
    })
    .catch(error => {
        console.error('Payment error:', error);
        resultDiv.innerHTML = '<div class="alert alert-danger">❌ Network error: ' + error.message + '</div>';
    });
}
</script>

<br><br>
<h3>Debug Links:</h3>
<a href="debug_insert_issue.php" class="btn btn-info">Debug Insert Issue</a>
<a href="check_user_orders.php" class="btn btn-success">Check User Orders</a>
<a href="index.php?action=cart" class="btn btn-primary">Go to Cart</a>
