<?php
// Save checkout shipping info into session before payment
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$act = $_GET['act'] ?? '';

switch ($act) {
  case 'set_info':
    try {
        // Accept form-urlencoded
        $fullname = $_POST['fullname'] ?? '';
        $number_phone = $_POST['number_phone'] ?? '';
        $address = $_POST['address'] ?? '';
        $province = $_POST['province_id'] ?? $_POST['province'] ?? 0;
        $district = $_POST['district_id'] ?? $_POST['district'] ?? 0;
        $wards = $_POST['wards_id'] ?? $_POST['wards'] ?? 0;

        // Validate required fields
        if (empty($fullname) || empty($number_phone) || empty($address)) {
            throw new Exception('Vui lòng điền đầy đủ thông tin bắt buộc');
        }

        // Debug logging
        error_log("Setting shipping info - fullname: $fullname, phone: $number_phone, address: $address, province: $province, district: $district, wards: $wards");
        error_log("POST data: " . json_encode($_POST));

        // Clean phone number (remove leading 0 if present, then add it back)
        $clean_phone = preg_replace('/\D+/', '', $number_phone);
        if (strpos($clean_phone, '0') === 0) {
            $clean_phone = substr($clean_phone, 1); // Remove leading 0
        }

        // Validate phone number
        if (strlen($clean_phone) < 9 || strlen($clean_phone) > 11) {
            throw new Exception('Số điện thoại không hợp lệ');
        }

        $_SESSION['fullname'] = $fullname;
        $_SESSION['number_phone'] = $clean_phone; // Store without leading 0
        $_SESSION['address'] = $address;
        $_SESSION['province_id'] = (int)$province;
        $_SESSION['district_id'] = (int)$district;
        $_SESSION['wards_id'] = (int)$wards;

        // Debug session data
        error_log("Session data set - fullname: " . $_SESSION['fullname'] . ", phone: " . $_SESSION['number_phone'] . ", address: " . $_SESSION['address']);
        error_log("Full session: " . json_encode($_SESSION));

        header('Content-Type: application/json');
        echo json_encode(['status' => 'OK', 'message' => 'Lưu thông tin thành công']);
    } catch (Exception $e) {
        error_log("Error in set_info: " . $e->getMessage());
        header('Content-Type: application/json');
        http_response_code(400);
        echo json_encode(['status' => 'ERROR', 'message' => $e->getMessage()]);
    }
    break;
  default:
    http_response_code(404);
    echo 'Not found';
}


