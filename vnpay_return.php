<?php
require_once 'config/vnpay.php';
require_once 'Model/DBConfig.php';
require_once 'Model/API.php';
require_once 'Model/Order.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Lấy dữ liệu từ VNPay
$vnp_ResponseCode = $_GET['vnp_ResponseCode'] ?? '';
$vnp_TxnRef = $_GET['vnp_TxnRef'] ?? '';
$vnp_Amount = $_GET['vnp_Amount'] ?? 0;
$vnp_TransactionStatus = $_GET['vnp_TransactionStatus'] ?? '';
$vnp_SecureHash = $_GET['vnp_SecureHash'] ?? '';

// Xác thực callback
$isValid = VNPayConfig::validateCallback($_GET);

if (!$isValid) {
    $message = 'Lỗi xác thực thanh toán';
    $status = 'error';
} else {
    // Kiểm tra kết quả thanh toán
    if ($vnp_ResponseCode == '00' && $vnp_TransactionStatus == '00') {
        // Idempotent update + đối chiếu số tiền
        try {
            $connect = new connect();
            $API = new API();
            $Order = new Order();

            // Tính tổng tiền từ chi tiết đơn
            $sumRow = $API->get_one("SELECT COALESCE(SUM(total_price),0) AS total FROM details_order WHERE order_id='$vnp_TxnRef' AND deleted_at IS NULL");
            $expected = (int)($sumRow ? $sumRow['total'] : 0) * 100; // VNPay dùng đơn vị x100

            if ($expected != (int)$vnp_Amount) {
                error_log("VNPay amount mismatch for order {$vnp_TxnRef}: expected {$expected}, got {$vnp_Amount}");
                $message = 'Số tiền không khớp. Giao dịch bị từ chối.';
                $status = 'error';
            } else {
                // Chỉ cập nhật nếu chưa có payment_method hoặc là COD
                $sql = "UPDATE orders SET payment_method = 'VNPay' WHERE order_id = ? AND deleted_at IS NULL AND (payment_method IS NULL OR payment_method='' OR payment_method='COD')";
                $stmt = $connect->db->prepare($sql);
                $stmt->execute([$vnp_TxnRef]);

                $message = 'Thanh toán thành công!';
                $status = 'success';
            }
        } catch (Exception $e) {
            error_log('Error updating payment status: ' . $e->getMessage());
            $message = 'Lỗi xử lý thanh toán';
            $status = 'error';
        }
    } else {
        // Thanh toán thất bại
        if ($vnp_ResponseCode == '24') {
            $message = 'Giao dịch đã quá thời gian chờ thanh toán. Vui lòng thực hiện lại giao dịch.';
        } else {
            $message = VNPayConfig::getResponseMessage($vnp_ResponseCode);
        }
        $status = 'error';
    }
}

// Chuyển hướng với thông báo
$redirectUrl = 'index.php?action=order_history&payment_status=' . $status . '&message=' . urlencode($message);
header('Location: ' . $redirectUrl);
exit;
?>
