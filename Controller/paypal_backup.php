<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Set headers to prevent caching and CORS issues
header('Content-Type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
require_once __DIR__ . '/../Model/DBConfig.php';
require_once __DIR__ . '/../config/paypal.php';
require_once __DIR__ . '/../Model/API.php';
require_once __DIR__ . '/../Model/Order.php';
require_once __DIR__ . '/../Model/Product.php';
require_once __DIR__ . '/../mail/setup.php';

function paypal_base_url() {
  return PAYPAL_MODE === 'live' ? 'https://api-m.paypal.com' : 'https://api-m.sandbox.paypal.com';
}

function paypal_get_access_token() {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, paypal_base_url() . '/v1/oauth2/token');
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_USERPWD, PAYPAL_CLIENT_ID . ':' . PAYPAL_SECRET);
  curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($ch);
  if ($response === false) {
    http_response_code(500);
    echo json_encode(['error' => curl_error($ch)]);
    exit;
  }
  curl_close($ch);
  $data = json_decode($response, true);
  return $data['access_token'] ?? null;
}

function get_cart_total_vnd() {
  // Calculate server-side total from session cart
  session_start();
  $total = 0;
  if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
      $qty = isset($item['quantity']) ? (int)$item['quantity'] : 1;
      $total += ((int)$item['price']) * $qty; // price in VND
    }
  }
  return $total; // VND
}

function create_order() {
  $accessToken = paypal_get_access_token();
  if (!$accessToken) {
    http_response_code(500);
    echo json_encode(['error' => 'Cannot get PayPal access token']);
    exit;
  }

  // Convert VND -> USD (rounded to 2 decimals)
  $totalVnd = get_cart_total_vnd();
  $amountUsd = max(0.01, round($totalVnd / EXCHANGE_RATE_VND_TO_USD, 2));

  $body = [
    'intent' => 'CAPTURE',
    'purchase_units' => [[
      'amount' => [
        'currency_code' => PAYPAL_CURRENCY,
        'value' => number_format($amountUsd, 2, '.', ''),
      ]
    ]]
  ];

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, paypal_base_url() . '/v2/checkout/orders');
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $accessToken,
  ]);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($ch);
  if ($response === false) {
    http_response_code(500);
    echo json_encode(['error' => curl_error($ch)]);
    exit;
  }
  curl_close($ch);
  echo $response;
}

function capture_order() {
  $input = json_decode(file_get_contents('php://input'), true);
  $orderId = $input['orderID'] ?? null;
  if (!$orderId) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing orderID']);
    exit;
  }

  $accessToken = paypal_get_access_token();
  if (!$accessToken) {
    http_response_code(500);
    echo json_encode(['error' => 'Cannot get PayPal access token']);
    exit;
  }

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, paypal_base_url() . '/v2/checkout/orders/' . $orderId . '/capture');
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $accessToken,
  ]);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($ch);
  if ($response === false) {
    http_response_code(500);
    echo json_encode(['error' => curl_error($ch)]);
    exit;
  }
  curl_close($ch);

  $data = json_decode($response, true);

  // Persist order if completed
  if (($data['status'] ?? '') === 'COMPLETED') {
    try {
      session_start();
      $orderModel = new Order();
      $productModel = new Product();
      $orderId = $data['id'];

      $fullname = $_SESSION['fullname'] ?? 'Khách hàng';
      $number_phone = isset($_SESSION['number_phone']) ? ('0' . $_SESSION['number_phone']) : '';
      $address = $_SESSION['address'] ?? '';
      $province = $_SESSION['province_id'] ?? 0;
      $district = $_SESSION['district_id'] ?? 0;
      $wards = $_SESSION['wards_id'] ?? 0;
      $user_id = $_SESSION['user_id'] ?? 0;
      
      // Debug log để kiểm tra session data
      error_log("PayPal order processing - user_id: " . $user_id . ", fullname: " . $fullname . ", order_id: " . $orderId);

      // Idempotent insert order
      $exists = $orderModel->exists_OrderId($orderId);
      if (!($exists && (int)$exists['cnt'] > 0)) {
        $orderResult = $orderModel->add_Order($fullname, $number_phone, $address, $province, $district, $wards, $orderId, $user_id);
        if (!$orderResult) {
          error_log("Failed to create order in database for PayPal order: " . $orderId);
          throw new Exception("Không thể tạo đơn hàng trong database");
        }
      }

      $orderTotalVnd = 0;
      if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
          $name = $item['name'];
          $size = $item['size'];
          $qty = (int)$item['quantity'];
          $img = $item['img'];
          $price = (int)$item['price'];
          $total = $qty * $price;
          
          $detailResult = $orderModel->add_DetailsOrder($name, $size, $qty, $img, $price, $total, $orderId);
          if (!$detailResult) {
            error_log("Failed to add order detail for order: " . $orderId);
            throw new Exception("Không thể tạo chi tiết đơn hàng");
          }
          
          $productModel->decrease_quantity($name, $size, $qty);
          $orderTotalVnd += $total;
        }
      }
      $_SESSION['cart'] = [];

      // Gửi email xác nhận (không chặn flow nếu lỗi SMTP)
      $email = $_SESSION['email'] ?? null;
      if ($email) {
        try {
          $mailer = new Mailer();
          $title = 'Xác nhận đơn hàng #' . $orderId;
          $content = '<h3>Cảm ơn bạn đã đặt hàng</h3>'
            . '<p>Mã đơn: <b>' . htmlspecialchars($orderId) . '</b></p>'
            . '<p>Tổng tiền: <b>' . number_format($orderTotalVnd) . 'đ</b></p>'
            . '<p>Chúng tôi sẽ xử lý và giao hàng sớm nhất.</p>';
          $mailer->sendMail($title, $content, $email);
        } catch (\Throwable $e) {
          error_log("Failed to send confirmation email: " . $e->getMessage());
        }
      }
    } catch (\Throwable $e) {
      error_log("PayPal order processing error: " . $e->getMessage());
      // Log error but don't break the response to PayPal
      $data['internal_error'] = $e->getMessage();
    }
  }

  echo json_encode($data);
}

// Handle OPTIONS request for CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Get act from both GET and POST
$act = $_GET['act'] ?? $_POST['act'] ?? '';

// Debug logging
error_log("PayPal Controller - Method: " . $_SERVER['REQUEST_METHOD']);
error_log("PayPal Controller - Act: " . $act);
error_log("PayPal Controller - GET: " . json_encode($_GET));
error_log("PayPal Controller - POST: " . json_encode($_POST));

switch ($act) {
  case 'create':
    // PayPal: Create real PayPal order and redirect to PayPal
    try {
      // Session is already started at the top of the file
      
      // Debug session data
      error_log("PayPal Session Data: " . json_encode([
        'user_id' => $_SESSION['user_id'] ?? 'not_set',
        'fullname' => $_SESSION['fullname'] ?? 'not_set',
        'number_phone' => $_SESSION['number_phone'] ?? 'not_set',
        'address' => $_SESSION['address'] ?? 'not_set',
        'cart_count' => isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0,
        'session_id' => session_id()
      ]));
      
      // Check if user is logged in
      if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
        throw new Exception("Vui lòng đăng nhập để đặt hàng");
      }
      
      // Check if cart exists and has items
      if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        throw new Exception("Giỏ hàng trống, vui lòng thêm sản phẩm vào giỏ hàng");
      }
      
      $orderModel = new Order();
      $productModel = new Product();
      $orderId = 'PAYPAL-' . strtoupper(bin2hex(random_bytes(5)));

      $fullname = $_SESSION['fullname'] ?? '';
      $number_phone = $_SESSION['number_phone'] ?? '';
      $address = $_SESSION['address'] ?? '';
      $province = $_SESSION['province_id'] ?? 0;
      $district = $_SESSION['district_id'] ?? 0;
      $wards = $_SESSION['wards_id'] ?? 0;
      $user_id = $_SESSION['user_id'] ?? 0;
      
      // Format phone number - add leading 0 if not present
      if (!empty($number_phone) && !str_starts_with($number_phone, '0')) {
          $number_phone = '0' . $number_phone;
      }
      
      // Debug log để kiểm tra session data
      error_log("PayPal order processing - user_id: " . $user_id . ", fullname: " . $fullname . ", phone: " . $number_phone . ", address: " . $address . ", order_id: " . $orderId);

      // Validate required fields with more specific error messages
      if (empty($fullname)) {
        throw new Exception("Thiếu họ tên khách hàng. Vui lòng cập nhật thông tin cá nhân.");
      }
      
      if (empty($number_phone)) {
        throw new Exception("Thiếu số điện thoại. Vui lòng cập nhật thông tin cá nhân.");
      }
      
      if (empty($address)) {
        throw new Exception("Thiếu địa chỉ giao hàng. Vui lòng cập nhật thông tin cá nhân.");
      }
      
      // Validate phone number format
      if (!preg_match('/^[0-9]{10,11}$/', preg_replace('/\D/', '', $number_phone))) {
        throw new Exception("Số điện thoại không hợp lệ");
      }

      // Try to create order
      error_log("Attempting to create PayPal order with data: " . json_encode([
        'fullname' => $fullname,
        'number_phone' => $number_phone,
        'address' => $address,
        'province' => $province,
        'district' => $district,
        'wards' => $wards,
        'order_id' => $orderId,
        'user_id' => $user_id
      ]));

      $orderResult = $orderModel->add_Order($fullname, $number_phone, $address, $province, $district, $wards, $orderId, $user_id);
      if (!$orderResult) {
        error_log("Failed to create order in database");
        throw new Exception("Không thể tạo đơn hàng trong database");
      }
      
      error_log("Order created successfully with ID: " . $orderId);

      $orderTotalVnd = 0;
      foreach ($_SESSION['cart'] as $item) {
        $name = $item['name'];
        $size = $item['size'];
        $qty = (int)$item['quantity'];
        $img = $item['img'];
        $price = (int)$item['price'];
        $total = $qty * $price;
        
        $detailResult = $orderModel->add_DetailsOrder($name, $size, $qty, $img, $price, $total, $orderId);
        if (!$detailResult) {
          error_log("Failed to add order detail for order: " . $orderId);
          throw new Exception("Không thể tạo chi tiết đơn hàng");
        }
        
        $productModel->decrease_quantity($name, $size, $qty);
        $orderTotalVnd += $total;
      }
      $_SESSION['cart'] = [];
      error_log("Cart cleared after successful order creation");

      // Send email notification (optional, don't fail order if email fails)
      $email = $_SESSION['email'] ?? null;
      if ($email) {
        try {
          $mailer = new Mailer();
          $title = 'Xác nhận đơn hàng (PayPal) #' . $orderId;
          $content = '<h3>Đơn hàng PayPal của bạn đã được tạo</h3>'
            . '<p>Mã đơn: <b>' . htmlspecialchars($orderId) . '</b></p>'
            . '<p>Tổng tiền: <b>' . number_format($orderTotalVnd) . 'đ</b></p>'
            . '<p>Vui lòng thanh toán qua PayPal.</p>';
          $mailer->sendMail($title, $content, $email);
          error_log("Confirmation email sent to: " . $email);
        } catch (\Throwable $e) {
          error_log("Failed to send PayPal confirmation email: " . $e->getMessage());
        }
      }

      error_log("PayPal order completed successfully: " . $orderId);
      echo json_encode(['status' => 'OK', 'order_id' => $orderId]);
      
    } catch (\Throwable $e) {
      error_log("PayPal order creation error: " . $e->getMessage());
      error_log("Stack trace: " . $e->getTraceAsString());
      http_response_code(500);
      echo json_encode(['status' => 'ERROR', 'message' => $e->getMessage()]);
    }
    break;
  case 'capture':
    capture_order();
    break;
  case 'cod':
    // Cash on Delivery: persist order immediately
    try {
      // Session is already started at the top of the file
      
      // Debug session data
      error_log("COD Session Data: " . json_encode([
        'user_id' => $_SESSION['user_id'] ?? 'not_set',
        'fullname' => $_SESSION['fullname'] ?? 'not_set',
        'number_phone' => $_SESSION['number_phone'] ?? 'not_set',
        'address' => $_SESSION['address'] ?? 'not_set',
        'cart_count' => isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0,
        'session_id' => session_id()
      ]));
      
      // Check if user is logged in
      if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
        throw new Exception("Vui lòng đăng nhập để đặt hàng");
      }
      
      // Check if cart exists and has items
      if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        throw new Exception("Giỏ hàng trống, vui lòng thêm sản phẩm vào giỏ hàng");
      }
      
      $orderModel = new Order();
      $productModel = new Product();
      $orderId = 'COD-' . strtoupper(bin2hex(random_bytes(5)));

      $fullname = $_SESSION['fullname'] ?? '';
      $number_phone = $_SESSION['number_phone'] ?? '';
      $address = $_SESSION['address'] ?? '';
      $province = $_SESSION['province_id'] ?? 0;
      $district = $_SESSION['district_id'] ?? 0;
      $wards = $_SESSION['wards_id'] ?? 0;
      $user_id = $_SESSION['user_id'] ?? 0;
      
      // Format phone number - add leading 0 if not present
      if (!empty($number_phone) && !str_starts_with($number_phone, '0')) {
          $number_phone = '0' . $number_phone;
      }
      
      // Debug log để kiểm tra session data
      error_log("COD order processing - user_id: " . $user_id . ", fullname: " . $fullname . ", phone: " . $number_phone . ", address: " . $address . ", order_id: " . $orderId);

      // Validate required fields with more specific error messages
      if (empty($fullname)) {
        throw new Exception("Thiếu họ tên khách hàng. Vui lòng cập nhật thông tin cá nhân.");
      }
      
      if (empty($number_phone)) {
        throw new Exception("Thiếu số điện thoại. Vui lòng cập nhật thông tin cá nhân.");
      }
      
      if (empty($address)) {
        throw new Exception("Thiếu địa chỉ giao hàng. Vui lòng cập nhật thông tin cá nhân.");
      }
      
      // Validate phone number format
      if (!preg_match('/^[0-9]{10,11}$/', preg_replace('/\D/', '', $number_phone))) {
        throw new Exception("Số điện thoại không hợp lệ");
      }

      // Try to create order
      error_log("Attempting to create COD order with data: " . json_encode([
        'fullname' => $fullname,
        'number_phone' => $number_phone,
        'address' => $address,
        'province' => $province,
        'district' => $district,
        'wards' => $wards,
        'order_id' => $orderId,
        'user_id' => $user_id
      ]));

      $orderResult = $orderModel->add_Order($fullname, $number_phone, $address, $province, $district, $wards, $orderId, $user_id);
      if (!$orderResult) {
        error_log("Failed to create order in database");
        throw new Exception("Không thể tạo đơn hàng trong database");
      }
      
      error_log("Order created successfully with ID: " . $orderId);

      $orderTotalVnd = 0;
      foreach ($_SESSION['cart'] as $item) {
        $name = $item['name'];
        $size = $item['size'];
        $qty = (int)$item['quantity'];
        $img = $item['img'];
        $price = (int)$item['price'];
        $total = $qty * $price;
        
        error_log("Adding order detail: " . json_encode([
          'name' => $name,
          'size' => $size,
          'qty' => $qty,
          'price' => $price,
          'total' => $total,
          'order_id' => $orderId
        ]));
        
        $detailResult = $orderModel->add_DetailsOrder($name, $size, $qty, $img, $price, $total, $orderId);
        if (!$detailResult) {
          error_log("Failed to add order detail for: " . $name);
          throw new Exception("Không thể tạo chi tiết đơn hàng cho sản phẩm: " . $name);
        }
        
        // Update product quantity
        try {
        $productModel->decrease_quantity($name, $size, $qty);
          error_log("Updated quantity for product: " . $name . ", size: " . $size . ", qty: " . $qty);
        } catch (Exception $e) {
          error_log("Failed to update product quantity: " . $e->getMessage());
          // Don't fail the order for quantity update issues
        }
        
        $orderTotalVnd += $total;
      }
      
      // Clear cart
      $_SESSION['cart'] = [];
      error_log("Cart cleared after successful order creation");

      // Send email notification (optional, don't fail order if email fails)
      $email = $_SESSION['email'] ?? null;
      if ($email) {
        try {
          $mailer = new Mailer();
          $title = 'Xác nhận đơn hàng (COD) #' . $orderId;
          $content = '<h3>Đơn hàng COD của bạn đã được tạo</h3>'
            . '<p>Mã đơn: <b>' . htmlspecialchars($orderId) . '</b></p>'
            . '<p>Tổng tiền: <b>' . number_format($orderTotalVnd) . 'đ</b></p>'
            . '<p>Vui lòng chuẩn bị tiền mặt khi nhận hàng.</p>';
          $mailer->sendMail($title, $content, $email);
          error_log("Confirmation email sent to: " . $email);
        } catch (\Throwable $e) {
          error_log("Failed to send COD confirmation email: " . $e->getMessage());
        }
      }

      error_log("COD order completed successfully: " . $orderId);
      echo json_encode(['status' => 'OK', 'order_id' => $orderId]);
      
    } catch (\Throwable $e) {
      error_log("COD order creation error: " . $e->getMessage());
      error_log("Stack trace: " . $e->getTraceAsString());
      http_response_code(500);
      echo json_encode(['status' => 'ERROR', 'message' => $e->getMessage()]);
    }
    break;
  case 'vnpay':
    // VNPay: process similar to COD
    try {
      // Session is already started at the top of the file
      
      // Debug session data
      error_log("VNPay Session Data: " . json_encode([
        'user_id' => $_SESSION['user_id'] ?? 'not_set',
        'fullname' => $_SESSION['fullname'] ?? 'not_set',
        'number_phone' => $_SESSION['number_phone'] ?? 'not_set',
        'address' => $_SESSION['address'] ?? 'not_set',
        'cart_count' => isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0,
        'session_id' => session_id()
      ]));
      
      // Check if user is logged in
      if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
        throw new Exception("Vui lòng đăng nhập để đặt hàng");
      }
      
      // Check if cart exists and has items
      if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        throw new Exception("Giỏ hàng trống, vui lòng thêm sản phẩm vào giỏ hàng");
      }
      
      $orderModel = new Order();
      $productModel = new Product();
      $orderId = 'VNPAY-' . strtoupper(bin2hex(random_bytes(5)));

      $fullname = $_SESSION['fullname'] ?? '';
      $number_phone = $_SESSION['number_phone'] ?? '';
      $address = $_SESSION['address'] ?? '';
      $province = $_SESSION['province_id'] ?? 0;
      $district = $_SESSION['district_id'] ?? 0;
      $wards = $_SESSION['wards_id'] ?? 0;
      $user_id = $_SESSION['user_id'] ?? 0;
      
      // Format phone number - add leading 0 if not present
      if (!empty($number_phone) && !str_starts_with($number_phone, '0')) {
          $number_phone = '0' . $number_phone;
      }
      
      // Debug log để kiểm tra session data
      error_log("VNPay order processing - user_id: " . $user_id . ", fullname: " . $fullname . ", phone: " . $number_phone . ", address: " . $address . ", order_id: " . $orderId);

      // Validate required fields with more specific error messages
      if (empty($fullname)) {
        throw new Exception("Thiếu họ tên khách hàng. Vui lòng cập nhật thông tin cá nhân.");
      }
      
      if (empty($number_phone)) {
        throw new Exception("Thiếu số điện thoại. Vui lòng cập nhật thông tin cá nhân.");
      }
      
      if (empty($address)) {
        throw new Exception("Thiếu địa chỉ giao hàng. Vui lòng cập nhật thông tin cá nhân.");
      }
      
      // Validate phone number format
      if (!preg_match('/^[0-9]{10,11}$/', preg_replace('/\D/', '', $number_phone))) {
        throw new Exception("Số điện thoại không hợp lệ");
      }

      // Try to create order
      error_log("Attempting to create VNPay order with data: " . json_encode([
        'fullname' => $fullname,
        'number_phone' => $number_phone,
        'address' => $address,
        'province' => $province,
        'district' => $district,
        'wards' => $wards,
        'order_id' => $orderId,
        'user_id' => $user_id
      ]));

      $orderResult = $orderModel->add_Order($fullname, $number_phone, $address, $province, $district, $wards, $orderId, $user_id);
      if (!$orderResult) {
        error_log("Failed to create order in database");
        throw new Exception("Không thể tạo đơn hàng trong database");
      }
      
      error_log("Order created successfully with ID: " . $orderId);

      $orderTotalVnd = 0;
      foreach ($_SESSION['cart'] as $item) {
        $name = $item['name'];
        $size = $item['size'];
        $qty = (int)$item['quantity'];
        $img = $item['img'];
        $price = (int)$item['price'];
        $total = $qty * $price;
        
        $detailResult = $orderModel->add_DetailsOrder($name, $size, $qty, $img, $price, $total, $orderId);
        if (!$detailResult) {
          error_log("Failed to add order detail for order: " . $orderId);
          throw new Exception("Không thể tạo chi tiết đơn hàng");
        }
        
        $productModel->decrease_quantity($name, $size, $qty);
        $orderTotalVnd += $total;
      }
      $_SESSION['cart'] = [];
      error_log("Cart cleared after successful order creation");

      // Send email notification (optional, don't fail order if email fails)
      $email = $_SESSION['email'] ?? null;
      if ($email) {
        try {
          $mailer = new Mailer();
          $title = 'Xác nhận đơn hàng (VNPay) #' . $orderId;
          $content = '<h3>Đơn hàng VNPay của bạn đã được tạo</h3>'
            . '<p>Mã đơn: <b>' . htmlspecialchars($orderId) . '</b></p>'
            . '<p>Tổng tiền: <b>' . number_format($orderTotalVnd) . 'đ</b></p>'
            . '<p>Vui lòng thanh toán qua VNPay.</p>';
          $mailer->sendMail($title, $content, $email);
          error_log("Confirmation email sent to: " . $email);
        } catch (\Throwable $e) {
          error_log("Failed to send VNPay confirmation email: " . $e->getMessage());
        }
      }

      error_log("VNPay order completed successfully: " . $orderId);
      echo json_encode(['status' => 'OK', 'order_id' => $orderId]);
      
    } catch (\Throwable $e) {
      error_log("VNPay order creation error: " . $e->getMessage());
      error_log("Stack trace: " . $e->getTraceAsString());
      http_response_code(500);
      echo json_encode(['status' => 'ERROR', 'message' => $e->getMessage()]);
    }
    break;
  case 'clear_cart':
    $_SESSION['cart'] = [];
    echo json_encode(['status' => 'OK']);
    break;
  default:
    http_response_code(404);
    echo json_encode(['error' => 'Not found']);
}


