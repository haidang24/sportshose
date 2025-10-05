<?php
// Script để test thanh toán thực tế
session_start();

echo "<h2>Test Live Payment</h2>";

// Đảm bảo user đã đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo "<div style='color: red;'>❌ Bạn cần đăng nhập trước khi test thanh toán!</div>";
    echo "<a href='index.php?action=User'>← Đăng nhập</a>";
    exit;
}

echo "<h3>Thông tin user hiện tại:</h3>";
echo "<pre>";
echo "user_id: " . $_SESSION['user_id'] . "\n";
echo "fullname: " . ($_SESSION['fullname'] ?? 'Chưa có') . "\n";
echo "email: " . ($_SESSION['email'] ?? 'Chưa có') . "\n";
echo "</pre>";

// Tạo giỏ hàng test
echo "<h3>Tạo giỏ hàng test:</h3>";
$_SESSION['cart'] = [
    [
        'name' => 'GIÀY TEST THANH TOÁN',
        'size' => '42',
        'quantity' => 1,
        'img' => 'test.jpg',
        'price' => 100000,
        'idsp' => 'test_live_' . time()
    ]
];

$_SESSION['fullname'] = $_SESSION['fullname'] ?? 'Mai Hai Dang';
$_SESSION['number_phone'] = '983785604';
$_SESSION['address'] = 'VietNam Test Address';
$_SESSION['province_id'] = 1;
$_SESSION['district_id'] = 1;
$_SESSION['wards_id'] = 1;

echo "✅ Đã tạo giỏ hàng test với giá 100,000đ<br>";

// Test COD
echo "<h3>Test COD Payment:</h3>";
echo "<button onclick='testCOD()' class='btn btn-primary'>Test COD</button>";
echo "<div id='result'></div>";

echo "<br><br><a href='index.php?action=cart'>← Đi đến giỏ hàng để test thực tế</a>";
?>

<script>
function testCOD() {
    const resultDiv = document.getElementById('result');
    resultDiv.innerHTML = '<div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>';
    
    fetch('Controller/paypal.php?act=cod', { 
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'OK') {
            resultDiv.innerHTML = '<div class="alert alert-success">✅ COD thành công! Order ID: ' + data.order_id + '</div>';
            setTimeout(() => {
                window.location.href = 'debug_orders.php';
            }, 2000);
        } else {
            resultDiv.innerHTML = '<div class="alert alert-danger">❌ Lỗi: ' + (data.message || 'Unknown error') + '</div>';
        }
    })
    .catch(error => {
        resultDiv.innerHTML = '<div class="alert alert-danger">❌ Lỗi network: ' + error.message + '</div>';
    });
}
</script>
