<nav class="shadow-sm navbar navbar-expand-sm bg-light navbar-light">
    <!-- Brand -->
    <a class="navbar-brand fw-bolder text-success mx-3" href="admin.php?action=user">Zay Shop</a>

    <!-- Links -->
    <ul class="navbar-nav">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle <?php echo (isset($_GET['action']) && $_GET['action'] == 'user' || $_GET['action'] == 'admin' || $_GET['action'] == 'contact')?"text-success":''?>" 
            href="#" id="navbardrop1" data-bs-toggle="dropdown">Quản Trị Người
                Dùng</a>
            <div class="dropdown-menu" style="width: 100px;">
                <a class="dropdown-item fs-14 admin-link" href="admin.php?action=admin">Nhân Viên</a>
                <a class="dropdown-item fs-14 admin-link" href="admin.php?action=user">Khách hàng</a>
                <a class="dropdown-item fs-14 admin-link" href="admin.php?action=contact">Liên hệ<span
                        class="rounded-border mx-1">
                        <?php
                        $contact = new Contact();
                        $sum_contact = $contact->count_contact();
                        echo $sum_contact['dem'];
                        ?>
                    </span></a>
                <a class="dropdown-item fs-14 admin-link" href="admin.php?action=user&act=khoiphuc">Khôi phục</a>
            </div>
        </li>

        <!-- Quản trị Doanh Mục -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle <?php echo (isset($_GET['action']) && $_GET['action'] == 'product')?"text-success":''?>" 
            href="#" id="navbardrop2" data-bs-toggle="dropdown">
                Quản Trị Doanh Mục
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item fs-14 repo-link" href="admin.php?action=product&act=add_product">Thêm sản
                    phẩm</a>
                <a class="dropdown-item fs-14 repo-link" href="admin.php?action=product&act=product_detailss">Thêm chi
                    tiết</a>
                <a class="dropdown-item fs-14" href="admin.php?action=product">Sản Phẩm</a>
            </div>
        </li>
        <!-- Doanh thu -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle <?php echo (isset($_GET['action']) && $_GET['action'] == 'statistical')?"text-success":''?>" 
            href="#" id="navbardrop3" data-bs-toggle="dropdown">
                Quản trị thống kê
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item fs-14 accountant-link" href="admin.php?action=statistical">Doanh thu</a>
            </div>
        </li>
        <!-- Báo cáo -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle <?php echo (isset($_GET['action']) && $_GET['action'] == 'order' || $_GET['action'] == 'order_cancel' || $_GET['action'] == 'order_deliveried')?"text-success":''?>" 
            href="#" id="navbardrop4" data-bs-toggle="dropdown">
                Quản trị đơn hàng
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item fs-14" href="admin.php?action=order">Đơn hàng<span class="rounded-border mx-1"
                        id="count_order_wating1"></span></a>
                <a class="dropdown-item fs-14" href="admin.php?action=order_deliveried">Đã giao</a>
                <a class="dropdown-item fs-14" href="admin.php?action=order_cancel">Đã hủy</a>
            </div>
        </li>

        <li class="nav-item">
            <div class="dropdown">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"
                    href="admin.php?action=login&act=dangxuat"><i class="bi bi-person-square"></i></a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item fs-14 info-admin" data-admin_id="<?php echo $_SESSION['admin_id'] ?>"
                            style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modal_infor_admin">Thông
                            tin cá nhân</a></li>
                    <li><a class="dropdown-item fs-14" style="cursor: pointer;" data-bs-toggle="modal"
                            data-bs-target="#modal_change_password">Đổi mật khẩu</a></li>
                    <li><a class="dropdown-item fs-14" id="log_out">Đăng xuất</a></li>
                </ul>
            </div>
        </li>
    </ul>
</nav>

<!-- Modal thông tin cá nhân admin -->
<div class="modal fade bg-secondary" id="modal_infor_admin" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <h1 class="text-center text-success fw-bold">THÔNG TIN CÁ NHÂN</h1>
                <input type="hidden" value="<?php echo $_SESSION['admin_id'] ?>" id="admin_id">
                <div class="text-center">
                    <label for="file-input">
                        <img src="" style="width: 200px; height: 200px; cursor: pointer;" alt="Avatar"
                            id="preview_avatar_admin" class="rounded-circle">
                    </label>
                    <input type="file" class="d-none" id="file-input" />
                    <small id="file-input_error" class="badge text-danger"></small>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="username" class="form-label">Họ tên</label>
                                <input disabled type="text" class="form-control bg-success-subtle" id="fullname"
                                    value="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input placeholder="Cập nhật email" type="text" class="form-control" id="email_admin">
                                <small id="email_admin_error" class="badge text-danger"></small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="username" class="form-label">Số điện thoại</label>
                                <input disabled type="text" class="form-control bg-success-subtle"
                                    id="number_phone_admin">
                                <small id="number_phone_admin_error" class="badge text-danger"></small>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <div class="mb-3">
                                    <label for="dob" class="form-label">Ngày tháng năm sinh</label>
                                    <input type="text" class="form-control" id="dob" placeholder="Chọn ngày sinh">
                                    <small id="dob_error" class="badge text-danger"></small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="username" class="form-label">Giới tính:</label> <br>
                                <div class="d-flex justify-content-around">
                                    <label class="gender-label">
                                        <input type="radio" name="gender" value="nam"> Nam
                                    </label>
                                    <label class="gender-label">
                                        <input type="radio" name="gender" value="nữ"> Nữ
                                    </label>
                                </div>
                                <small id="gender_error" class="badge text-danger"></small>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="email" class="form-label ">Ngày bắt đầu làm</label>
                                <input disabled type="text" class="form-control bg-success-subtle" id="start_date"
                                    value="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <label for="">Địa chỉ</label>
                            <input placeholder="Cập nhật địa chỉ" type="text" class="form-control" id="address_admin">
                            <small id="address_admin_error" class="badge text-danger"></small>
                        </div>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" id="update_info_admin" class="btn btn-outline-success">Cập nhật</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal thay đổi mật khẩu -->
<div class="modal fade" id="modal_change_password" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title text-center fs-5 text-success fw-bold" id="exampleModalLabel">Đổi mật khẩu</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form_change_password1">
                    <input type="hidden" name="admin_id" id="admin_id" value="<?php echo $_SESSION['admin_id'] ?>">
                    <div class="form-group">
                        <label class="form-label">Mật khẩu cũ</label> <Br>
                        <small id="password_old_error" class="badge text-danger"></small>
                        <input type="password" name="password_old" id="password_old" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Mật khẩu mới</label> <Br>
                        <small id="password_new_error" class="badge text-danger"></small>
                        <input type="password" name="password_new" id="password_new" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Xác nhận mật khẩu</label> <Br>
                        <small id="confirm_password_error" class="badge text-danger"></small>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control">
                    </div>
                    <div class="mb-3 form-check">
                        <input style="cursor: pointer" type="checkbox" class="form-check-input" id="show_password">
                        <label class="form-check-label fs-6">Hiển mật khẩu</label>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-success">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<style>
    .rounded-border {
        display: inline-block;
        padding-left: 6px;
        width: 20px;
        height: 20px;
        border: 1px solid #666;
        /* Màu và kích thước của đường viền */
        background-color: green;
        color: white;
        border-radius: 10px;
        /* Độ cong của đường viền để tạo hình tròn */
    }

    .fs-14 {
        font-size: 14px;
    }
</style>



<script>
    flatpickr("#dob", {
        dateFormat: "d-m-Y",
        maxDate: "today",
        // defaultDate: "01-01-2000",
    });
</script>