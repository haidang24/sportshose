-- Script kiểm tra và sửa lỗi database
-- Chạy từng phần một

-- 1. Kiểm tra dữ liệu hiện tại
SELECT '=== KIỂM TRA BRAND ===' as info;
SELECT * FROM brand ORDER BY id;

SELECT '=== KIỂM TRA SHOES_TYPE ===' as info;
SELECT * FROM shoes_type ORDER BY id;

SELECT '=== KIỂM TRA SIZE ===' as info;
SELECT * FROM size ORDER BY id;

-- 2. Thêm dữ liệu cơ bản nếu chưa có
INSERT IGNORE INTO brand (name_brand) VALUES 
('Nike'),
('Adidas'),
('Puma'),
('New Balance'),
('Under Armour');

INSERT IGNORE INTO shoes_type (name) VALUES 
('Giày Bóng Đá'),
('Giày Futsal'),
('Giày Chạy Bộ'),
('Giày Tennis'),
('Giày Basketball'),
('Giày Lifestyle');

INSERT IGNORE INTO size (size) VALUES 
(35), (36), (37), (38), (39), (40), (41), (42), (43), (44), (45), (46), (47), (48);

-- 3. Kiểm tra lại sau khi thêm
SELECT '=== SAU KHI THÊM BRAND ===' as info;
SELECT * FROM brand ORDER BY id;

SELECT '=== SAU KHI THÊM SHOES_TYPE ===' as info;
SELECT * FROM shoes_type ORDER BY id;

SELECT '=== SAU KHI THÊM SIZE ===' as info;
SELECT * FROM size ORDER BY id;
