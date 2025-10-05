<?php
header('Content-Type: text/html; charset=utf-8');
include "./Model/DBConfig.php";
include "./Model/API.php";
include "./Model/Brand.php";
include "./Model/Shoes_Type.php";
include "./Model/Size.php";
include "./Model/Product.php";
include "./Model/User.php";
include "./Model/Order.php";
include "./Model/Contact.php";
include "./Model/Status.php";
include "./Model/Statistical.php";
include "./Model/Admin.php";
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin shop giày</title>

    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/8tibevqzcyx0osfvfv6bxnzs7jmyqxoccp7ylzezhp6388fj/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>

    <!-- jQuery (Ensure it's loaded if you use it) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

    <!-- Popper.js (for Bootstrap 5) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>

    <!-- Bootstrap 5 JS (Bundle includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://unpkg.com/sweetalert2@11"></script>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="./View/assets/css/Tour.css" />

    <!-- Datetimepicker css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        function showPermissionAlert1() {
            Swal.fire({
                icon: 'error',
                text: 'Bạn không có quyền sử dụng tính năng này!',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.history.back();
                }
            });
        }
    </script>
</head>

<body>
    <!-- Thanh header tạo menu -->
    <?php
    if (isset($_SESSION['username']) && $_SESSION['password']) {
        include_once "View/admin/header.php";
    }
    ?>
    <div class="container-fluid">
        <div class="row">
            <?php
            $ctrl = "login";
            if (isset($_GET['action'])) {
                if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
                    $feature = [];
                    $admin = new admin();
                    $get_admin = $admin->get_admin_id($_SESSION['admin_id']);
                    // Đổ các chức năng theo từng tài khoản
                    while ($set = $get_admin->fetch(PDO::FETCH_ASSOC)) {
                        $feature = explode('-', $set['feature']);
                    }

                    // Lấy action theo url
                    $action = $_GET['action'];
                    // echo $action;
                    // Lấy act theo url
                    $act = isset($_GET['act']) ? $_GET['act'] : null;
                    // echo $act;exit;
                    $permission = false;

                    // Xác định quyền truy cập dựa trên action và act
                    if ($action == 'product' && $act) {
                        switch ($act) {
                            case 'product_detailss':
                                $permission = in_array('Xem chi tiết', $feature);
                                break;
                            case 'add_product':
                                $permission = in_array('Thêm sản phẩm', $feature);
                                break;
                            case 'update_product_details':
                                $permission = in_array('Chỉnh sửa chi tiết sản phẩm', $feature);
                                break;
                            case 'update_Product':
                                $permission = in_array('Chỉnh sửa sản phẩm', $feature);
                                break;
                            case 'product_details':
                                $permission = in_array('Xem chi tiết sản phẩm', $feature);
                                break;
                            default:
                                $permission = in_array('Xem sản phẩm', $feature);
                                break;
                        }
                    } else if ($action == 'user' && $act) {
                        switch ($act) {
                            case 'khoiphuc':
                                $permission = in_array('Khôi phục khách hàng', $feature);
                                break;
                        }
                    } else {
                        switch ($action) {
                            case 'statistical':
                                $permission = in_array('Xem doanh thu', $feature);
                                break;
                            case 'admin':
                                $permission = in_array('Xem thông tin nhân viên', $feature);
                                break;
                            case 'contact':
                                $permission = in_array('Liên hệ', $feature);
                                break;
                            case 'order':
                                $permission = in_array('Xem đơn hàng', $feature);
                                break;
                            case 'order_deliveried':
                                $permission = in_array('Xem đơn hàng đã giao', $feature);
                                break;
                            case 'order_cancel':
                                $permission = in_array('Xem đơn hàng đã hủy', $feature);
                                break;
                            case 'user':
                                $permission = in_array('Xem thông tin khách hàng', $feature);
                                break;
                            default:
                                $permission = true; // Mặc định cho phép truy cập nếu không cần kiểm tra quyền
                                break;
                        }
                    }

                    // Kiểm tra quyền và bao gồm tệp điều khiển nếu có quyền
                    if ($permission) {
                        if ($action == 'product' && $act) {
                            switch ($act) {
                                case 'add_product':
                                    include_once './View/admin/addproduct.php';
                                    break;
                                case 'product_detailss':
                                    include_once './View/Admin/themchitiet.php';
                                    break;
                                case 'update_product_details':
                                    include_once './View/Admin/update_product_details.php';
                                    break;
                                case 'update_Product':
                                    include_once './View/Admin/Update_Product.php';
                                    break;
                                case 'product_details':
                                    include_once './View/Admin/Product_Details.php';
                                    break;
                                default:
                                    include_once './View/admin/Product.php';
                                    break;
                            }
                        } else if ($action == 'user' && $act) {
                            switch ($act) {
                                case 'khoiphuc':
                                    include_once './View/admin/restore_user.php';
                                    break;
                                // default:
                                //     include_once './View/admin/User.php';
                                //     break;
                            }
                        } else {
                            switch ($action) {
                                case 'statistical':
                                    include_once './View/admin/Statistical.php';
                                    break;
                                case 'admin':
                                    include_once './View/admin/Admin.php';
                                    break;
                                case 'contact':
                                    include_once './View/admin/Contact.php';
                                    break;
                                case 'order':
                                    include_once './View/admin/Order.php';
                                    break;
                                case 'order_deliveried':
                                    include_once './View/admin/Order_Deliveried.php';
                                    break;
                                case 'order_cancel':
                                    include_once './View/admin/Order_Cancel.php';
                                    break;
                                case 'user':
                                    include_once './View/admin/User.php';
                                    break;
                                default:
                                    include_once './View/admin/Product.php';
                                    break;
                            }
                        }
                    } else {
                        echo "<script>showPermissionAlert1()</script>";
                    }
                } else {
                    include_once './View/admin/login.php';
                }
            } else {
                include_once './View/admin/login.php';
            }
            ?>
        </div>
    </div>
    <input type="hidden" id="admin_id" value="<?php echo isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : ''; ?>">


    <script src="ajax/Product.js"></script>
    <script src="ajax/User.js"></script>
    <script src="ajax/login.js"></script>
    <script src="ajax/Contact.js"></script>
    <script src="ajax/Order.js"></script>
    <script src="./View/assets/ajax/upload_img1.js"></script>
    <script src="./View/assets/ajax/upload_img.js"></script>
    <script src="ajax/validate.js"></script>
    <script src="ajax/Info_user.js"></script>
    <script src="ajax/admin.js"></script>
    <script src="ajax/authorization.js"></script>
    <script src="ajax/feature.js"></script>
    <script src="ajax/change_password.js"></script>
</body>

</html>