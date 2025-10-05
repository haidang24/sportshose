<?php
session_start();

// Simulate login for testing
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1; // Test user ID
    $_SESSION['fullname'] = 'Test User';
    $_SESSION['email'] = 'test@example.com';
    echo "<p>Simulated login for testing.</p>";
}

// Simulate cart for testing
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [
        [
            'idsp' => '1',
            'name' => 'Nike Air Max 90',
            'size' => '42',
            'quantity' => 1,
            'price' => 2500000,
            'img' => 'test.jpg',
            'shoes_type' => 'Giày chạy',
            'brand' => 'Nike'
        ]
    ];
    echo "<p>Simulated cart for testing.</p>";
}

echo "<h2>Test Checkout Flow</h2>";

// Test 1: Check session data
echo "<h3>1. Session Data:</h3>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

// Test 2: Load profile addresses
echo "<h3>2. Loading Profile Addresses:</h3>";
echo "<div id='profile-addresses'></div>";

// Test 3: Simulate COD order
echo "<h3>3. Test COD Order:</h3>";
echo "<button onclick='testCODOrder()'>Test COD Order</button>";
echo "<div id='cod-result'></div>";

?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Load profile addresses
    loadProfileAddresses();
});

function loadProfileAddresses() {
    $.ajax({
        url: 'Controller/info_user.php',
        method: 'GET',
        data: { act: 'get_address_user' },
        dataType: 'json',
        success: function(addresses) {
            console.log('Addresses loaded:', addresses);
            displayAddresses(addresses);
        },
        error: function(xhr, status, error) {
            console.error('Error loading addresses:', error);
            $('#profile-addresses').html('<p style="color: red;">Error loading addresses: ' + error + '</p>');
        }
    });
}

function displayAddresses(addresses) {
    const container = $('#profile-addresses');
    container.empty();
    
    if (addresses && addresses.length > 0) {
        container.html('<h4>Profile Addresses:</h4>');
        addresses.forEach(function(address, index) {
            const addressHtml = `
                <div style="border: 1px solid #ccc; padding: 10px; margin: 10px 0;">
                    <strong>${address.fullname}</strong><br>
                    Phone: ${address.number_phone}<br>
                    Address: ${address.address}, ${address.wards}, ${address.district}, ${address.province}
                </div>
            `;
            container.append(addressHtml);
        });
    } else {
        container.html('<p>No addresses found.</p>');
    }
}

function testCODOrder() {
    $('#cod-result').html('<p>Processing COD order...</p>');
    
    // First save shipping info
    const formData = new FormData();
    formData.append('fullname', 'Test User');
    formData.append('number_phone', '0123456789');
    formData.append('address', '123 Test Street');
    formData.append('province', '1');
    formData.append('district', '1');
    formData.append('wards', '1');
    
    $.ajax({
        url: 'Controller/checkout.php?act=set_info',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            console.log('Shipping info saved:', response);
            
            // Then process COD order
            $.ajax({
                url: 'Controller/paypal.php?act=cod',
                method: 'POST',
                dataType: 'json',
                success: function(response) {
                    console.log('COD order result:', response);
                    $('#cod-result').html('<p style="color: green;">COD Order Success: ' + JSON.stringify(response) + '</p>');
                },
                error: function(xhr, status, error) {
                    console.error('COD order error:', error);
                    $('#cod-result').html('<p style="color: red;">COD Order Error: ' + error + '</p>');
                }
            });
        },
        error: function(xhr, status, error) {
            console.error('Error saving shipping info:', error);
            $('#cod-result').html('<p style="color: red;">Error saving shipping info: ' + error + '</p>');
        }
    });
}
</script>
