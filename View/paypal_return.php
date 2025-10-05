<?php
session_start();

// Handle PayPal return from success/cancel
$success = isset($_GET['success']) ? $_GET['success'] : false;
$cancelled = isset($_GET['cancelled']) ? $_GET['cancelled'] : false;
$error = isset($_GET['error']) ? $_GET['error'] : false;

if ($success) {
    // PayPal payment successful
    echo "<script>
        Swal.fire({
            title: 'Thanh toán thành công!',
            text: 'Cảm ơn bạn đã mua hàng. Chúng tôi sẽ giao hàng sớm nhất.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = 'index.php?action=order_success';
        });
    </script>";
} elseif ($cancelled) {
    // PayPal payment cancelled
    echo "<script>
        Swal.fire({
            title: 'Thanh toán bị hủy',
            text: 'Bạn đã hủy thanh toán PayPal. Vui lòng thử lại nếu muốn.',
            icon: 'warning',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = 'index.php?action=cart';
        });
    </script>";
} elseif ($error) {
    // PayPal payment error
    echo "<script>
        Swal.fire({
            title: 'Lỗi thanh toán',
            text: 'Có lỗi xảy ra khi thanh toán PayPal. Vui lòng thử lại.',
            icon: 'error',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = 'index.php?action=cart';
        });
    </script>";
} else {
    // Redirect to home if no parameters
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayPal Payment Result</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="text-center">
                    <h3>Đang xử lý kết quả thanh toán...</h3>
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
