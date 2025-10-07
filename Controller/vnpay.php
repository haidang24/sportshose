<?php
require_once __DIR__ . '/../config/vnpay.php';
require_once __DIR__ . '/../Model/DBConfig.php';
require_once __DIR__ . '/../Model/API.php';
require_once __DIR__ . '/../Model/Order.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Set JSON header for API responses (only if not already sent)
if (!headers_sent()) {
    header('Content-Type: application/json');
}

$act = $_POST['act'] ?? $_GET['act'] ?? '';

switch ($act) {
    case 'create_payment':
        createVNPayPayment();
        break;
    case 'return':
        handleVNPayReturn();
        break;
    case 'ipn':
        handleVNPayIPN();
        break;
    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        break;
}

/**
 * Tạo URL thanh toán VNPay
 */
function createVNPayPayment() {
    try {
        // Lấy dữ liệu từ POST
        $orderId = $_POST['order_id'] ?? '';
        $amount = $_POST['amount'] ?? 0;
        $orderDescription = $_POST['order_description'] ?? 'Thanh toan don hang';
        
        if (empty($orderId) || $amount <= 0) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Thông tin đơn hàng không hợp lệ'
            ]);
            return;
        }
        
        // Tạo URL thanh toán VNPay
        $paymentUrl = VNPayConfig::createPaymentUrl(
            $orderId,
            $amount,
            $orderDescription
        );
        
        // Lưu thông tin đơn hàng vào session để xử lý sau
        $_SESSION['vnpay_order_id'] = $orderId;
        $_SESSION['vnpay_amount'] = $amount;
        
        echo json_encode([
            'status' => 'success',
            'payment_url' => $paymentUrl
        ]);
        
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Lỗi tạo thanh toán: ' . $e->getMessage()
        ]);
    }
}

/**
 * Xử lý callback từ VNPay
 */
function handleVNPayReturn() {
    try {
        // Lấy dữ liệu từ VNPay
        $vnp_ResponseCode = $_GET['vnp_ResponseCode'] ?? '';
        $vnp_TxnRef = $_GET['vnp_TxnRef'] ?? '';
        $vnp_Amount = $_GET['vnp_Amount'] ?? 0;
        $vnp_TransactionStatus = $_GET['vnp_TransactionStatus'] ?? '';
        $vnp_SecureHash = $_GET['vnp_SecureHash'] ?? '';
        
        // Xác thực callback
        if (!VNPayConfig::validateCallback($_GET)) {
            redirectToOrderHistory('Lỗi xác thực thanh toán');
            return;
        }
        
        // Kiểm tra kết quả thanh toán
        if ($vnp_ResponseCode == '00' && $vnp_TransactionStatus == '00') {
            // Thanh toán thành công
            updateOrderPaymentStatus($vnp_TxnRef, 'VNPay', 'success');
            redirectToOrderHistory('Thanh toán thành công!');
        } else {
            // Thanh toán thất bại
            $message = VNPayConfig::getResponseMessage($vnp_ResponseCode);
            redirectToOrderHistory('Thanh toán thất bại: ' . $message);
        }
        
    } catch (Exception $e) {
        redirectToOrderHistory('Lỗi xử lý thanh toán: ' . $e->getMessage());
    }
}

/**
 * Xử lý IPN từ VNPay (nếu cần)
 */
function handleVNPayIPN() {
    // Xử lý IPN nếu VNPay gửi
    echo json_encode(['status' => 'success']);
}

/**
 * Cập nhật trạng thái thanh toán đơn hàng
 */
function updateOrderPaymentStatus($orderId, $paymentMethod, $status) {
    try {
        $connect = new connect();
        $Order = new Order();
        
        // Cập nhật phương thức thanh toán
        $sql = "UPDATE orders SET payment_method = ? WHERE order_id = ? AND deleted_at IS NULL";
        $stmt = $connect->db->prepare($sql);
        $stmt->execute([$paymentMethod, $orderId]);
        
        // Nếu thanh toán thành công, có thể cập nhật trạng thái đơn hàng
        if ($status === 'success') {
            // Có thể chuyển đơn hàng sang trạng thái "Đang giao" nếu muốn
            // $Order->updateOrderStatus($orderId, 2);
        }
        
        return true;
    } catch (Exception $e) {
        error_log('Error updating payment status: ' . $e->getMessage());
        return false;
    }
}

/**
 * Chuyển hướng đến trang lịch sử đơn hàng
 */
function redirectToOrderHistory($message = '') {
    $url = 'index.php?action=order_history';
    if (!empty($message)) {
        $url .= '&message=' . urlencode($message);
    }
    header('Location: ' . $url);
    exit;
}
?>
