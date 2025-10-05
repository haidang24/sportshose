<?php
session_start();

// Setup test session data
$_SESSION['user_id'] = 1;
$_SESSION['fullname'] = 'Test User';
$_SESSION['number_phone'] = '123456789';
$_SESSION['address'] = '123 Test Street, Test Ward, Test District, Test Province';
$_SESSION['email'] = 'test@example.com';
$_SESSION['province_id'] = 1;
$_SESSION['district_id'] = 1;
$_SESSION['wards_id'] = 1;

// Setup test cart
$_SESSION['cart'] = [
    [
        'idsp' => '1',
        'name' => 'Nike Air Max 90',
        'size' => '42',
        'quantity' => 1,
        'price' => 2500000,
        'img' => 'nike-air-max-90.jpg',
        'shoes_type' => 'Giày chạy',
        'brand' => 'Nike'
    ]
];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Order Flow</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <h1>Test Order Flow</h1>
    
    <div style="margin: 20px 0;">
        <button onclick="testFullOrderFlow()" style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
            Test Full Order Flow
        </button>
    </div>
    
    <div id="result" style="margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; background: #f9f9f9;"></div>
    
    <script>
    function testFullOrderFlow() {
        $('#result').html('<p>Testing full order flow...</p>');
        $('#result').append('<p>✅ Session already setup in PHP</p>');
        
        // Step 1: Create COD order directly
        createTestOrder();
    }
    
    function createTestOrder() {
        $('#result').append('<p>Step 1: Creating test COD order...</p>');
        
        $.ajax({
            url: 'Controller/paypal.php?act=cod',
            method: 'POST',
            dataType: 'json',
            success: function(response) {
                console.log('COD order result:', response);
                
                if (response.status === 'OK') {
                    $('#result').append('<p style="color: green;">✅ Step 1: COD order created successfully!</p>');
                    $('#result').append('<p>Order ID: ' + response.order_id + '</p>');
                    
                    // Step 2: Check order history
                    setTimeout(() => {
                        checkOrderHistory();
                    }, 1000);
                } else {
                    $('#result').append('<p style="color: red;">❌ Step 1: COD order failed - ' + response.message + '</p>');
                }
            },
            error: function(xhr, status, error) {
                console.error('COD order error:', error, xhr.responseText);
                $('#result').append('<p style="color: red;">❌ Step 1: COD order error - ' + error + '</p>');
                $('#result').append('<p>Response: ' + xhr.responseText + '</p>');
            }
        });
    }
    
    function checkOrderHistory() {
        $('#result').append('<p>Step 2: Checking order history...</p>');
        
        $.ajax({
            url: 'Controller/order_history.php?act=get_all_order',
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            data: 'user_id=1', // Test user ID
            success: function(response) {
                console.log('Order history result:', response);
                
                if (Array.isArray(response) && response.length > 0) {
                    $('#result').append('<p style="color: green;">✅ Step 2: Order history loaded successfully!</p>');
                    $('#result').append('<p>Found ' + response.length + ' orders</p>');
                    
                    // Show latest order
                    const latestOrder = response[0];
                    $('#result').append('<p>Latest order: ' + latestOrder.order_id + ' (Status: ' + latestOrder.status + ')</p>');
                    
                    // Step 3: Test order details
                    setTimeout(() => {
                        testOrderDetails(latestOrder.order_id);
                    }, 1000);
                } else {
                    $('#result').append('<p style="color: red;">❌ Step 2: No orders found in history</p>');
                    $('#result').append('<p>Response: ' + JSON.stringify(response) + '</p>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Order history error:', error, xhr.responseText);
                $('#result').append('<p style="color: red;">❌ Step 2: Order history error - ' + error + '</p>');
                $('#result').append('<p>Response: ' + xhr.responseText + '</p>');
            }
        });
    }
    
    function testOrderDetails(orderId) {
        $('#result').append('<p>Step 3: Testing order details for ' + orderId + '...</p>');
        
        $.ajax({
            url: 'Controller/order_history.php?act=get_order_details',
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            data: 'order_id=' + encodeURIComponent(orderId),
            success: function(response) {
                console.log('Order details result:', response);
                
                if (Array.isArray(response) && response.length > 0) {
                    $('#result').append('<p style="color: green;">✅ Step 3: Order details loaded successfully!</p>');
                    $('#result').append('<p>Found ' + response.length + ' items in order</p>');
                    
                    // Show order details
                    let total = 0;
                    response.forEach(item => {
                        total += parseInt(item.total_price);
                        $('#result').append('<p>- ' + item.name_product + ' x' + item.quantity + ' = ' + parseInt(item.total_price).toLocaleString() + 'đ</p>');
                    });
                    $('#result').append('<p><strong>Total: ' + total.toLocaleString() + 'đ</strong></p>');
                    
                    $('#result').append('<p style="color: green; font-weight: bold;">🎉 Full order flow test completed successfully!</p>');
                } else {
                    $('#result').append('<p style="color: red;">❌ Step 3: No order details found</p>');
                    $('#result').append('<p>Response: ' + JSON.stringify(response) + '</p>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Order details error:', error, xhr.responseText);
                $('#result').append('<p style="color: red;">❌ Step 3: Order details error - ' + error + '</p>');
                $('#result').append('<p>Response: ' + xhr.responseText + '</p>');
            }
        });
    }
    
    $(document).ready(function() {
        console.log('Test page loaded');
    });
    </script>
</body>
</html>
