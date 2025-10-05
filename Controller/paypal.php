<?php
// PayPal payment controller
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

// EXCHANGE_RATE_VND_TO_USD is already defined in config/paypal.php

// Secure session management
class SecureSession {
    public static function start() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
}

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
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
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
  SecureSession::start();
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
  error_log("PayPal capture_order called");
  $input = json_decode(file_get_contents('php://input'), true);
  $orderId = $input['orderID'] ?? null;
  
  error_log("PayPal capture - Input: " . json_encode($input));
  error_log("PayPal capture - OrderID: " . $orderId);
  
  if (!$orderId) {
    error_log("PayPal capture - Missing orderID");
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
  curl_setopt($ch, CURLOPT_POSTFIELDS, '{}');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($ch);
  if ($response === false) {
    http_response_code(500);
    echo json_encode(['error' => curl_error($ch)]);
    exit;
  }
  curl_close($ch);

  $data = json_decode($response, true);
  
  error_log("PayPal capture - API Response: " . $response);
  error_log("PayPal capture - Decoded Data: " . json_encode($data));
  error_log("PayPal capture - Status: " . ($data['status'] ?? 'NO_STATUS'));

  // Persist order if completed OR already captured previously
  $isCompleted = (($data['status'] ?? '') === 'COMPLETED');
  $isAlreadyCaptured = (($data['name'] ?? '') === 'UNPROCESSABLE_ENTITY') && isset($data['details'][0]['issue']) && $data['details'][0]['issue'] === 'ORDER_ALREADY_CAPTURED';
  if ($isCompleted || $isAlreadyCaptured) {
    if ($isAlreadyCaptured) {
      error_log("PayPal capture - ORDER_ALREADY_CAPTURED, proceeding as success (idempotent)");
    }
    error_log("PayPal capture - Status is COMPLETED, proceeding with order creation");
    try {
      SecureSession::start();
      $orderModel = new Order();
      $productModel = new Product();

      $fullname = $_SESSION['fullname'] ?? 'Khách hàng';
      $number_phone = isset($_SESSION['number_phone']) ? ('0' . $_SESSION['number_phone']) : '';
      $address = $_SESSION['address'] ?? '';
      $province = isset($_SESSION['province_id']) && $_SESSION['province_id'] > 0 ? (int)$_SESSION['province_id'] : null;
      $district = isset($_SESSION['district_id']) && $_SESSION['district_id'] > 0 ? (int)$_SESSION['district_id'] : null;
      $wards = isset($_SESSION['wards_id']) && $_SESSION['wards_id'] > 0 ? (int)$_SESSION['wards_id'] : null;
      $user_id = isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0 ? (int)$_SESSION['user_id'] : null;
      
      // Debug log để kiểm tra session data
      error_log("PayPal order processing - user_id: " . $user_id . ", fullname: " . $fullname . ", order_id: " . $orderId);

      // Idempotent insert order
      $exists = $orderModel->exists_OrderId($orderId);
      error_log("PayPal capture - Order exists check: " . json_encode($exists));
      
      if (!($exists && (int)$exists['cnt'] > 0)) {
        error_log("PayPal capture - Creating new order in database");
        $orderResult = $orderModel->add_Order($fullname, $number_phone, $address, $province, $district, $wards, $orderId, $user_id, 2); // Status = 2 for PayPal
        error_log("PayPal capture - Order creation result: " . var_export($orderResult, true));
        
        if (!$orderResult) {
          error_log("Failed to create order in database for PayPal order: " . $orderId);
          throw new Exception("Không thể tạo đơn hàng trong database");
        }
      } else {
        error_log("PayPal capture - Order already exists, skipping creation");
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
          
          // Get product_id and size_id for decrease_quantity method
          $API = new API();
          
          // First get the size_id from size table
          $sizeResult = $API->get_one("SELECT id FROM size WHERE size = '$size'");
          if ($sizeResult) {
            $size_id = $sizeResult['id'];
            
            // Get product_id from product table
            $productResult = $API->get_one("SELECT id FROM product WHERE name = '$name'");
            if ($productResult) {
              $product_id = $productResult['id'];
              
              // Now decrease quantity
              $decreaseResult = $productModel->decrease_quantity($product_id, $size_id, $qty);
              if (!$decreaseResult) {
                error_log("Failed to decrease quantity for product_id: $product_id, size_id: $size_id, quantity: $qty");
              }
            } else {
              error_log("Could not find product with name: $name");
            }
          } else {
            error_log("Could not find size: $size");
          }
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

$act = $_GET['act'] ?? $_POST['act'] ?? '';
error_log("PayPal Controller - Method: " . $_SERVER['REQUEST_METHOD']);
error_log("PayPal Controller - Act: " . $act);

switch ($act) {
  case 'create':
    create_order();
    break;
  case 'capture':
    capture_order();
    break;
  case 'cod':
    // Cash on Delivery: persist order immediately
    try {
      SecureSession::start();
      $orderModel = new Order();
      $productModel = new Product();
      $orderId = 'COD-' . strtoupper(bin2hex(random_bytes(5)));

      $fullname = $_SESSION['fullname'] ?? 'Khách hàng';
      $number_phone = isset($_SESSION['number_phone']) ? ('0' . $_SESSION['number_phone']) : '';
      $address = $_SESSION['address'] ?? '';
      $province = isset($_SESSION['province_id']) && $_SESSION['province_id'] > 0 ? (int)$_SESSION['province_id'] : null;
      $district = isset($_SESSION['district_id']) && $_SESSION['district_id'] > 0 ? (int)$_SESSION['district_id'] : null;
      $wards = isset($_SESSION['wards_id']) && $_SESSION['wards_id'] > 0 ? (int)$_SESSION['wards_id'] : null;
      $user_id = isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0 ? (int)$_SESSION['user_id'] : null;
      
      // Debug log để kiểm tra session data
      error_log("COD order processing - user_id: " . $user_id . ", fullname: " . $fullname . ", order_id: " . $orderId);

      // Validate required fields
      if (empty($fullname) || empty($number_phone) || empty($address)) {
        throw new Exception("Thiếu thông tin bắt buộc");
      }

      if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        throw new Exception("Giỏ hàng trống");
      }

      $orderResult = $orderModel->add_Order($fullname, $number_phone, $address, $province, $district, $wards, $orderId, $user_id, 1); // Status = 1 for COD
      if (!$orderResult) {
        throw new Exception("Không thể tạo đơn hàng COD");
      }

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
          throw new Exception("Không thể tạo chi tiết đơn hàng COD");
        }
        
        // Get product_id and size_id for decrease_quantity method
        $API = new API();
        
        // First get the size_id from size table
        $sizeResult = $API->get_one("SELECT id FROM size WHERE size = '$size'");
        if ($sizeResult) {
          $size_id = $sizeResult['id'];
          
          // Get product_id from product table
          $productResult = $API->get_one("SELECT id FROM product WHERE name = '$name'");
          if ($productResult) {
            $product_id = $productResult['id'];
            
            // Now decrease quantity
            $decreaseResult = $productModel->decrease_quantity($product_id, $size_id, $qty);
            if (!$decreaseResult) {
              error_log("Failed to decrease quantity for product_id: $product_id, size_id: $size_id, quantity: $qty");
            }
          } else {
            error_log("Could not find product with name: $name");
          }
        } else {
          error_log("Could not find size: $size");
        }
        $orderTotalVnd += $total;
      }
      $_SESSION['cart'] = [];

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
        } catch (\Throwable $e) {
          error_log("Failed to send COD confirmation email: " . $e->getMessage());
        }
      }

      echo json_encode(['status' => 'OK', 'order_id' => $orderId]);
    } catch (\Throwable $e) {
      error_log("COD order creation error: " . $e->getMessage());
      http_response_code(500);
      echo json_encode(['status' => 'ERROR', 'message' => $e->getMessage()]);
    }
    break;
  case 'clear_cart':
    SecureSession::start();
    $_SESSION['cart'] = [];
    echo json_encode(['status' => 'OK']);
    break;
  default:
    http_response_code(404);
    echo json_encode(['error' => 'Not found']);
}
?>