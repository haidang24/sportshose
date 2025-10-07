<?php
/**
 * VNPay Configuration
 */
class VNPayConfig {
    // VNPay API URL
    const VNPAY_URL = 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html';
    const VNPAY_RETURN_URL = 'http://localhost/GIAYTHETHAO-main/vnpay_return.php';
    
    // VNPay Configuration
    const VNPAY_TMN_CODE = 'KI2458K4'; // TMN Code từ VNPay
    const VNPAY_HASH_SECRET = 'df8f38b198f921a92d82567febfbbbc4'; // Hash Secret từ VNPay
    
    // VNPay Parameters
    const VNPAY_VERSION = '2.1.0';
    const VNPAY_COMMAND = 'pay';
    const VNPAY_CURRENCY_CODE = 'VND';
    const VNPAY_LOCALE = 'vn';
    
    /**
     * Tạo URL thanh toán VNPay
     */
    public static function createPaymentUrl($orderId, $amount, $orderDescription, $returnUrl = null) {
        $vnp_TmnCode = self::VNPAY_TMN_CODE;
        $vnp_HashSecret = self::VNPAY_HASH_SECRET;
        $vnp_Url = self::VNPAY_URL;
        $vnp_Returnurl = $returnUrl ?: self::VNPAY_RETURN_URL;
        
        $vnp_TxnRef = $orderId; // Mã đơn hàng
        $vnp_OrderInfo = $orderDescription; // Mô tả đơn hàng
        $vnp_OrderType = 'other';
        $vnp_Amount = $amount * 100; // VNPay yêu cầu số tiền nhân 100
        $vnp_Locale = self::VNPAY_LOCALE;
        $vnp_BankCode = '';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $vnp_ExpireDate = date('YmdHis', strtotime('+45 minutes')); // Thời gian hết hạn: 45 phút
        
        $inputData = array(
            "vnp_Version" => self::VNPAY_VERSION,
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => self::VNPAY_COMMAND,
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => self::VNPAY_CURRENCY_CODE,
            "vnp_ExpireDate" => $vnp_ExpireDate,
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );
        
        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        
        return $vnp_Url;
    }
    
    /**
     * Xác thực callback từ VNPay
     */
    public static function validateCallback($data) {
        $vnp_HashSecret = self::VNPAY_HASH_SECRET;
        $vnp_SecureHash = $data['vnp_SecureHash'];
        
        unset($data['vnp_SecureHash']);
        ksort($data);
        
        $i = 0;
        $hashdata = "";
        foreach ($data as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }
        
        $secureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        
        return $secureHash === $vnp_SecureHash;
    }
    
    /**
     * Lấy thông báo kết quả thanh toán
     */
    public static function getResponseMessage($responseCode) {
        $messages = array(
            '00' => 'Giao dịch thành công',
            '07' => 'Trừ tiền thành công. Giao dịch bị nghi ngờ (liên quan tới lừa đảo, giao dịch bất thường).',
            '09' => 'Giao dịch không thành công do: Thẻ/Tài khoản của khách hàng chưa đăng ký dịch vụ InternetBanking',
            '10' => 'Xác thực thông tin thẻ/tài khoản không đúng quá 3 lần',
            '11' => 'Đã hết hạn chờ thanh toán. Xin vui lòng thực hiện lại giao dịch',
            '12' => 'Thẻ/Tài khoản bị khóa',
            '13' => 'Nhập sai mật khẩu xác thực giao dịch (OTP) quá số lần quy định. Xin vui lòng thực hiện lại giao dịch',
            '24' => 'Giao dịch đã quá thời gian chờ thanh toán. Vui lòng thực hiện lại giao dịch',
            '51' => 'Tài khoản không đủ số dư để thực hiện giao dịch',
            '65' => 'Tài khoản đã vượt quá hạn mức giao dịch trong ngày',
            '75' => 'Ngân hàng thanh toán đang bảo trì',
            '79' => 'Nhập sai mật khẩu thanh toán quá số lần quy định. Xin vui lòng thực hiện lại giao dịch',
            '99' => 'Lỗi không xác định'
        );
        
        return isset($messages[$responseCode]) ? $messages[$responseCode] : 'Lỗi không xác định';
    }
}
?>
