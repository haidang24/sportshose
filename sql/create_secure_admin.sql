-- Create/replace a secure admin using salted SHA-256
-- Edit @username and @password as desired before running

SET @username = 'admin';
SET @password = 'Admin@12345';

-- Fallback salt generation for environments without RANDOM_BYTES
-- Produces 32-hex-char salt from SHA2(UUID() + NOW() + RAND())
SET @salt = SUBSTRING(HEX(SHA2(CONCAT(UUID(), NOW(), RAND()), 256)), 1, 32);
SET @hash = SHA2(CONCAT(@salt, @password), 256);

-- Replace existing admin with same username
DELETE FROM admin WHERE username = @username;

-- Grant all permissions expected by admin.php checks
SET @feature = 'Xem chi tiết-Thêm sản phẩm-Chỉnh sửa chi tiết sản phẩm-Chỉnh sửa sản phẩm-Xem chi tiết sản phẩm-Xem sản phẩm-Khôi phục khách hàng-Xem doanh thu-Xem thông tin nhân viên-Liên hệ-Xem đơn hàng-Xem đơn hàng đã giao-Xem đơn hàng đã hủy-Xem thông tin khách hàng';

INSERT INTO admin(fullname, username, password, salt, number_phone, start_date, position, feature)
VALUES ('Super Admin', @username, @hash, @salt, '0000000000', CURDATE(), 'superadmin', @feature);


