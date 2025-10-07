-- ===== TẠO ADMIN USERS MỚI =====
-- File: create_admin_users.sql
-- Mô tả: Tạo các tài khoản admin mới cho hệ thống

-- Xóa các admin cũ nếu cần (uncomment nếu muốn reset)
-- DELETE FROM `admin` WHERE `admin_id` > 0;

-- Tạo admin users mới
INSERT INTO `admin` (
    `admin_id`, 
    `fullname`, 
    `username`, 
    `password`, 
    `number_phone`, 
    `email`, 
    `address`, 
    `start_date`, 
    `date_of_birth`, 
    `gender`, 
    `profile_picture`, 
    `position`, 
    `feature`, 
    `updated`
) VALUES

-- Admin chính - Quản trị viên cấp cao
(100, 'Nguyễn Văn Admin', 'admin_main', 'admin123', 987654321, 'admin@sportshoes.com', '123 Đường ABC, Quận 1, TP.HCM', '2024-01-01', '1990-01-15', 'nam', NULL, 'Quản trị viên cấp cao', 
'Xem thông tin khách hàng-Xem thông tin nhân viên-Xóa nhân viên-Chỉnh sửa mật khẩu-Liên hệ-Khôi phục khách hàng-Ẩn khách hàng-Xóa khách hàng-Xem chi tiết sản phẩm-Thêm chi tiết sản phẩm-Chỉnh sửa chi tiết sản phẩm-Xóa chi tiết sản phẩm-Thêm, xóa thương hiệu-Thêm, xóa loại giày-Thêm, xóa size-Thêm sản phẩm-Xem chi tiết-Chỉnh sửa sản phẩm-Xóa sản phẩm-Xem doanh thu-Xem đơn hàng-Xem chi tiết đơn hàng-Xem đơn hàng đã giao-Cập nhật tình trạng đơn hàng-Xem đơn hàng đã hủy', b'1'),

-- Admin kho - Quản lý sản phẩm
(101, 'Trần Thị Kho', 'admin_kho', 'kho123', 912345678, 'kho@sportshoes.com', '456 Đường DEF, Quận 2, TP.HCM', '2024-01-01', '1985-05-20', 'nữ', NULL, 'Quản lý kho', 
'Xem chi tiết sản phẩm-Thêm chi tiết sản phẩm-Chỉnh sửa chi tiết sản phẩm-Xóa chi tiết sản phẩm-Thêm, xóa thương hiệu-Thêm, xóa loại giày-Thêm, xóa size-Ẩn hiện sản phẩm-Thêm sản phẩm-Xem chi tiết-Chỉnh sửa sản phẩm-Xóa sản phẩm', b'1'),

-- Admin đơn hàng - Quản lý đơn hàng
(102, 'Lê Văn Đơn Hàng', 'admin_order', 'order123', 923456789, 'order@sportshoes.com', '789 Đường GHI, Quận 3, TP.HCM', '2024-01-01', '1988-08-10', 'nam', NULL, 'Quản lý đơn hàng', 
'Xem đơn hàng-Xem chi tiết đơn hàng-Xem đơn hàng đã giao-Cập nhật tình trạng đơn hàng-Xem đơn hàng đã hủy-Xem doanh thu', b'1'),

-- Admin khách hàng - Quản lý khách hàng
(103, 'Phạm Thị Khách Hàng', 'admin_customer', 'customer123', 934567890, 'customer@sportshoes.com', '321 Đường JKL, Quận 4, TP.HCM', '2024-01-01', '1992-12-25', 'nữ', NULL, 'Quản lý khách hàng', 
'Xem thông tin khách hàng-Khôi phục khách hàng-Ẩn khách hàng-Xóa khách hàng-Liên hệ', b'1'),

-- Admin nhân viên - Quản lý nhân viên
(104, 'Hoàng Văn Nhân Viên', 'admin_staff', 'staff123', 945678901, 'staff@sportshoes.com', '654 Đường MNO, Quận 5, TP.HCM', '2024-01-01', '1987-03-18', 'nam', NULL, 'Quản lý nhân viên', 
'Xem thông tin nhân viên-Xóa nhân viên-Chỉnh sửa mật khẩu', b'1'),

-- Admin báo cáo - Quản lý báo cáo
(105, 'Võ Thị Báo Cáo', 'admin_report', 'report123', 956789012, 'report@sportshoes.com', '987 Đường PQR, Quận 6, TP.HCM', '2024-01-01', '1991-07-30', 'nữ', NULL, 'Quản lý báo cáo', 
'Xem doanh thu-Xem đơn hàng-Xem chi tiết đơn hàng-Xem đơn hàng đã giao-Xem đơn hàng đã hủy', b'1');

-- ===== THÔNG TIN ĐĂNG NHẬP =====
-- 
-- 1. Admin chính:
--    Username: admin_main
--    Password: admin123
--    Quyền: Tất cả
--
-- 2. Admin kho:
--    Username: admin_kho  
--    Password: kho123
--    Quyền: Quản lý sản phẩm, kho
--
-- 3. Admin đơn hàng:
--    Username: admin_order
--    Password: order123
--    Quyền: Quản lý đơn hàng, doanh thu
--
-- 4. Admin khách hàng:
--    Username: admin_customer
--    Password: customer123
--    Quyền: Quản lý khách hàng
--
-- 5. Admin nhân viên:
--    Username: admin_staff
--    Password: staff123
--    Quyền: Quản lý nhân viên
--
-- 6. Admin báo cáo:
--    Username: admin_report
--    Password: report123
--    Quyền: Xem báo cáo, doanh thu
--
-- ===== LƯU Ý =====
-- - Tất cả mật khẩu đều được mã hóa (có thể cần hash MD5/SHA1)
-- - Số điện thoại: 9 chữ số (format Việt Nam)
-- - Email: theo format chuẩn
-- - Địa chỉ: TP.HCM
-- - Ngày sinh: format YYYY-MM-DD
-- - Giới tính: 'nam' hoặc 'nữ'
-- - Position: mô tả chức vụ
-- - Feature: danh sách quyền hạn (phân cách bằng dấu -)
