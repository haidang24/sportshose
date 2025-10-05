-- Script sửa lỗi database và thêm sản phẩm mới
-- Chạy từng phần một cách cẩn thận

-- 1. Kiểm tra và thêm thương hiệu (nếu chưa có)
INSERT IGNORE INTO brand (id, name_brand) VALUES 
(1, 'Nike'),
(2, 'Adidas'),
(3, 'Puma'),
(4, 'New Balance'),
(5, 'Under Armour'),
(6, 'Reebok'),
(7, 'Converse'),
(8, 'Vans'),
(9, 'Jordan'),
(10, 'Asics');

-- 2. Kiểm tra và thêm loại giày (nếu chưa có)
INSERT IGNORE INTO shoes_type (id, name) VALUES 
(1, 'Giày Bóng Đá'),
(2, 'Giày Futsal'),
(3, 'Giày Chạy Bộ'),
(4, 'Giày Tennis'),
(5, 'Giày Basketball'),
(6, 'Giày Lifestyle'),
(7, 'Giày Training'),
(8, 'Giày Hiking'),
(9, 'Giày Skateboard'),
(10, 'Giày Golf');

-- 3. Kiểm tra và thêm size (nếu chưa có)
INSERT IGNORE INTO size (id, size) VALUES 
(1, 35), (2, 36), (3, 37), (4, 38), (5, 39), 
(6, 40), (7, 41), (8, 42), (9, 43), (10, 44), 
(11, 45), (12, 46), (13, 47), (14, 48);

-- 4. Thêm sản phẩm Nike (có ảnh)
INSERT INTO product (name, shoes_type_id, brand_id, descriptions, img, hidden) VALUES 
('Nike Air Max 270', 3, 1, 'Giày chạy bộ với công nghệ Air Max tiên tiến, thiết kế hiện đại và thoải mái tối đa', 'nike_air_max_270.jpg', 0),
('Nike Mercurial Vapor 14', 1, 1, 'Giày bóng đá cao cấp với công nghệ Flyknit và đế FG chuyên nghiệp', 'nike_mercurial_vapor_14.jpg', 0),
('Nike Air Force 1', 6, 1, 'Giày lifestyle cổ điển với thiết kế timeless, phù hợp mọi phong cách', 'nike_air_force_1.jpg', 0),
('Nike Zoom Freak 3', 5, 1, 'Giày basketball chuyên nghiệp với công nghệ Zoom Air và thiết kế động lực', 'nike_zoom_freak_3.jpg', 0),
('Nike Dunk Low', 6, 1, 'Giày lifestyle với thiết kế cổ điển và màu sắc đa dạng', 'nike_dunk_low.jpg', 0);

-- 5. Thêm sản phẩm Adidas (có ảnh)
INSERT INTO product (name, shoes_type_id, brand_id, descriptions, img, hidden) VALUES 
('Adidas Ultraboost 22', 3, 2, 'Giày chạy bộ với Boost foam và Primeknit upper, hiệu suất vượt trội', 'adidas_ultraboost_22.jpg', 0),
('Adidas Stan Smith', 6, 2, 'Giày lifestyle cổ điển với thiết kế minimal và chất liệu da cao cấp', 'adidas_stan_smith.jpg', 0),
('Adidas Copa Sense', 1, 2, 'Giày bóng đá với K-leather và công nghệ Touch Pods', 'adidas_copa_sense.jpg', 0);

-- 6. Thêm sản phẩm New Balance (có ảnh)
INSERT INTO product (name, shoes_type_id, brand_id, descriptions, img, hidden) VALUES 
('New Balance 990v5', 3, 4, 'Giày chạy bộ với ENCAP midsole và thiết kế Made in USA', 'new_balance_990v5.jpg', 0),
('New Balance 2002R', 6, 4, 'Giày lifestyle với ABZORB midsole và thiết kế hiện đại', 'new_balance_2002r.jpg', 0);

-- 7. Lấy ID của sản phẩm vừa thêm để thêm chi tiết
-- (Chạy query này để xem ID của sản phẩm mới)
SELECT id, name FROM product WHERE name LIKE 'Nike%' OR name LIKE 'Adidas%' OR name LIKE 'New Balance%' ORDER BY id DESC LIMIT 10;

-- 8. Thêm chi tiết sản phẩm (thay thế product_id bằng ID thực tế từ query trên)
-- Ví dụ: nếu Nike Air Max 270 có ID = 100, thì thay product_id = 100

-- Nike Air Max 270 (thay product_id = ?)
INSERT INTO details_product (product_id, size_id, price, discount, quantity, img1, img2, img3) VALUES 
((SELECT id FROM product WHERE name = 'Nike Air Max 270'), 1, 3500000, 0, 50, 'nike_air_max_270_1.jpg', 'nike_air_max_270_2.jpg', 'nike_air_max_270_3.jpg'),
((SELECT id FROM product WHERE name = 'Nike Air Max 270'), 2, 3500000, 0, 45, 'nike_air_max_270_1.jpg', 'nike_air_max_270_2.jpg', 'nike_air_max_270_3.jpg'),
((SELECT id FROM product WHERE name = 'Nike Air Max 270'), 3, 3500000, 0, 40, 'nike_air_max_270_1.jpg', 'nike_air_max_270_2.jpg', 'nike_air_max_270_3.jpg'),
((SELECT id FROM product WHERE name = 'Nike Air Max 270'), 4, 3500000, 0, 35, 'nike_air_max_270_1.jpg', 'nike_air_max_270_2.jpg', 'nike_air_max_270_3.jpg'),
((SELECT id FROM product WHERE name = 'Nike Air Max 270'), 5, 3500000, 0, 30, 'nike_air_max_270_1.jpg', 'nike_air_max_270_2.jpg', 'nike_air_max_270_3.jpg');

-- Nike Mercurial Vapor 14
INSERT INTO details_product (product_id, size_id, price, discount, quantity, img1, img2, img3) VALUES 
((SELECT id FROM product WHERE name = 'Nike Mercurial Vapor 14'), 1, 4500000, 4000000, 25, 'nike_mercurial_vapor_14_1.jpg', 'nike_mercurial_vapor_14_2.jpg', 'nike_mercurial_vapor_14_3.jpg'),
((SELECT id FROM product WHERE name = 'Nike Mercurial Vapor 14'), 2, 4500000, 4000000, 30, 'nike_mercurial_vapor_14_1.jpg', 'nike_mercurial_vapor_14_2.jpg', 'nike_mercurial_vapor_14_3.jpg'),
((SELECT id FROM product WHERE name = 'Nike Mercurial Vapor 14'), 3, 4500000, 4000000, 35, 'nike_mercurial_vapor_14_1.jpg', 'nike_mercurial_vapor_14_2.jpg', 'nike_mercurial_vapor_14_3.jpg'),
((SELECT id FROM product WHERE name = 'Nike Mercurial Vapor 14'), 4, 4500000, 4000000, 40, 'nike_mercurial_vapor_14_1.jpg', 'nike_mercurial_vapor_14_2.jpg', 'nike_mercurial_vapor_14_3.jpg'),
((SELECT id FROM product WHERE name = 'Nike Mercurial Vapor 14'), 5, 4500000, 4000000, 45, 'nike_mercurial_vapor_14_1.jpg', 'nike_mercurial_vapor_14_2.jpg', 'nike_mercurial_vapor_14_3.jpg');

-- Nike Air Force 1
INSERT INTO details_product (product_id, size_id, price, discount, quantity, img1, img2, img3) VALUES 
((SELECT id FROM product WHERE name = 'Nike Air Force 1'), 1, 2800000, 0, 40, 'nike_air_force_1_1.jpg', 'nike_air_force_1_2.jpg', 'nike_air_force_1_3.jpg'),
((SELECT id FROM product WHERE name = 'Nike Air Force 1'), 2, 2800000, 0, 45, 'nike_air_force_1_1.jpg', 'nike_air_force_1_2.jpg', 'nike_air_force_1_3.jpg'),
((SELECT id FROM product WHERE name = 'Nike Air Force 1'), 3, 2800000, 0, 50, 'nike_air_force_1_1.jpg', 'nike_air_force_1_2.jpg', 'nike_air_force_1_3.jpg'),
((SELECT id FROM product WHERE name = 'Nike Air Force 1'), 4, 2800000, 0, 35, 'nike_air_force_1_1.jpg', 'nike_air_force_1_2.jpg', 'nike_air_force_1_3.jpg'),
((SELECT id FROM product WHERE name = 'Nike Air Force 1'), 5, 2800000, 0, 30, 'nike_air_force_1_1.jpg', 'nike_air_force_1_2.jpg', 'nike_air_force_1_3.jpg');

-- Nike Zoom Freak 3
INSERT INTO details_product (product_id, size_id, price, discount, quantity, img1, img2, img3) VALUES 
((SELECT id FROM product WHERE name = 'Nike Zoom Freak 3'), 1, 4200000, 0, 20, 'nike_zoom_freak_3_1.jpg', 'nike_zoom_freak_3_2.jpg', 'nike_zoom_freak_3_3.jpg'),
((SELECT id FROM product WHERE name = 'Nike Zoom Freak 3'), 2, 4200000, 0, 25, 'nike_zoom_freak_3_1.jpg', 'nike_zoom_freak_3_2.jpg', 'nike_zoom_freak_3_3.jpg'),
((SELECT id FROM product WHERE name = 'Nike Zoom Freak 3'), 3, 4200000, 0, 30, 'nike_zoom_freak_3_1.jpg', 'nike_zoom_freak_3_2.jpg', 'nike_zoom_freak_3_3.jpg'),
((SELECT id FROM product WHERE name = 'Nike Zoom Freak 3'), 4, 4200000, 0, 35, 'nike_zoom_freak_3_1.jpg', 'nike_zoom_freak_3_2.jpg', 'nike_zoom_freak_3_3.jpg'),
((SELECT id FROM product WHERE name = 'Nike Zoom Freak 3'), 5, 4200000, 0, 40, 'nike_zoom_freak_3_1.jpg', 'nike_zoom_freak_3_2.jpg', 'nike_zoom_freak_3_3.jpg');

-- Nike Dunk Low
INSERT INTO details_product (product_id, size_id, price, discount, quantity, img1, img2, img3) VALUES 
((SELECT id FROM product WHERE name = 'Nike Dunk Low'), 1, 2800000, 2400000, 20, 'nike_dunk_low_1.jpg', 'nike_dunk_low_2.jpg', 'nike_dunk_low_3.jpg'),
((SELECT id FROM product WHERE name = 'Nike Dunk Low'), 2, 2800000, 2400000, 25, 'nike_dunk_low_1.jpg', 'nike_dunk_low_2.jpg', 'nike_dunk_low_3.jpg'),
((SELECT id FROM product WHERE name = 'Nike Dunk Low'), 3, 2800000, 2400000, 30, 'nike_dunk_low_1.jpg', 'nike_dunk_low_2.jpg', 'nike_dunk_low_3.jpg'),
((SELECT id FROM product WHERE name = 'Nike Dunk Low'), 4, 2800000, 2400000, 35, 'nike_dunk_low_1.jpg', 'nike_dunk_low_2.jpg', 'nike_dunk_low_3.jpg'),
((SELECT id FROM product WHERE name = 'Nike Dunk Low'), 5, 2800000, 2400000, 40, 'nike_dunk_low_1.jpg', 'nike_dunk_low_2.jpg', 'nike_dunk_low_3.jpg');

-- Adidas Ultraboost 22
INSERT INTO details_product (product_id, size_id, price, discount, quantity, img1, img2, img3) VALUES 
((SELECT id FROM product WHERE name = 'Adidas Ultraboost 22'), 1, 4200000, 0, 40, 'adidas_ultraboost_22_1.jpg', 'adidas_ultraboost_22_2.jpg', 'adidas_ultraboost_22_3.jpg'),
((SELECT id FROM product WHERE name = 'Adidas Ultraboost 22'), 2, 4200000, 0, 45, 'adidas_ultraboost_22_1.jpg', 'adidas_ultraboost_22_2.jpg', 'adidas_ultraboost_22_3.jpg'),
((SELECT id FROM product WHERE name = 'Adidas Ultraboost 22'), 3, 4200000, 0, 50, 'adidas_ultraboost_22_1.jpg', 'adidas_ultraboost_22_2.jpg', 'adidas_ultraboost_22_3.jpg'),
((SELECT id FROM product WHERE name = 'Adidas Ultraboost 22'), 4, 4200000, 0, 35, 'adidas_ultraboost_22_1.jpg', 'adidas_ultraboost_22_2.jpg', 'adidas_ultraboost_22_3.jpg'),
((SELECT id FROM product WHERE name = 'Adidas Ultraboost 22'), 5, 4200000, 0, 30, 'adidas_ultraboost_22_1.jpg', 'adidas_ultraboost_22_2.jpg', 'adidas_ultraboost_22_3.jpg');

-- Adidas Stan Smith
INSERT INTO details_product (product_id, size_id, price, discount, quantity, img1, img2, img3) VALUES 
((SELECT id FROM product WHERE name = 'Adidas Stan Smith'), 1, 2500000, 0, 30, 'adidas_stan_smith_1.jpg', 'adidas_stan_smith_2.jpg', 'adidas_stan_smith_3.jpg'),
((SELECT id FROM product WHERE name = 'Adidas Stan Smith'), 2, 2500000, 0, 35, 'adidas_stan_smith_1.jpg', 'adidas_stan_smith_2.jpg', 'adidas_stan_smith_3.jpg'),
((SELECT id FROM product WHERE name = 'Adidas Stan Smith'), 3, 2500000, 0, 40, 'adidas_stan_smith_1.jpg', 'adidas_stan_smith_2.jpg', 'adidas_stan_smith_3.jpg'),
((SELECT id FROM product WHERE name = 'Adidas Stan Smith'), 4, 2500000, 0, 25, 'adidas_stan_smith_1.jpg', 'adidas_stan_smith_2.jpg', 'adidas_stan_smith_3.jpg'),
((SELECT id FROM product WHERE name = 'Adidas Stan Smith'), 5, 2500000, 0, 20, 'adidas_stan_smith_1.jpg', 'adidas_stan_smith_2.jpg', 'adidas_stan_smith_3.jpg');

-- Adidas Copa Sense
INSERT INTO details_product (product_id, size_id, price, discount, quantity, img1, img2, img3) VALUES 
((SELECT id FROM product WHERE name = 'Adidas Copa Sense'), 1, 3500000, 0, 25, 'adidas_copa_sense_1.jpg', 'adidas_copa_sense_2.jpg', 'adidas_copa_sense_3.jpg'),
((SELECT id FROM product WHERE name = 'Adidas Copa Sense'), 2, 3500000, 0, 30, 'adidas_copa_sense_1.jpg', 'adidas_copa_sense_2.jpg', 'adidas_copa_sense_3.jpg'),
((SELECT id FROM product WHERE name = 'Adidas Copa Sense'), 3, 3500000, 0, 35, 'adidas_copa_sense_1.jpg', 'adidas_copa_sense_2.jpg', 'adidas_copa_sense_3.jpg'),
((SELECT id FROM product WHERE name = 'Adidas Copa Sense'), 4, 3500000, 0, 40, 'adidas_copa_sense_1.jpg', 'adidas_copa_sense_2.jpg', 'adidas_copa_sense_3.jpg'),
((SELECT id FROM product WHERE name = 'Adidas Copa Sense'), 5, 3500000, 0, 45, 'adidas_copa_sense_1.jpg', 'adidas_copa_sense_2.jpg', 'adidas_copa_sense_3.jpg');

-- New Balance 990v5
INSERT INTO details_product (product_id, size_id, price, discount, quantity, img1, img2, img3) VALUES 
((SELECT id FROM product WHERE name = 'New Balance 990v5'), 1, 5200000, 0, 15, 'new_balance_990v5_1.jpg', 'new_balance_990v5_2.jpg', 'new_balance_990v5_3.jpg'),
((SELECT id FROM product WHERE name = 'New Balance 990v5'), 2, 5200000, 0, 20, 'new_balance_990v5_1.jpg', 'new_balance_990v5_2.jpg', 'new_balance_990v5_3.jpg'),
((SELECT id FROM product WHERE name = 'New Balance 990v5'), 3, 5200000, 0, 25, 'new_balance_990v5_1.jpg', 'new_balance_990v5_2.jpg', 'new_balance_990v5_3.jpg'),
((SELECT id FROM product WHERE name = 'New Balance 990v5'), 4, 5200000, 0, 30, 'new_balance_990v5_1.jpg', 'new_balance_990v5_2.jpg', 'new_balance_990v5_3.jpg'),
((SELECT id FROM product WHERE name = 'New Balance 990v5'), 5, 5200000, 0, 35, 'new_balance_990v5_1.jpg', 'new_balance_990v5_2.jpg', 'new_balance_990v5_3.jpg');

-- New Balance 2002R
INSERT INTO details_product (product_id, size_id, price, discount, quantity, img1, img2, img3) VALUES 
((SELECT id FROM product WHERE name = 'New Balance 2002R'), 1, 3200000, 0, 20, 'new_balance_2002r_1.jpg', 'new_balance_2002r_2.jpg', 'new_balance_2002r_3.jpg'),
((SELECT id FROM product WHERE name = 'New Balance 2002R'), 2, 3200000, 0, 25, 'new_balance_2002r_1.jpg', 'new_balance_2002r_2.jpg', 'new_balance_2002r_3.jpg'),
((SELECT id FROM product WHERE name = 'New Balance 2002R'), 3, 3200000, 0, 30, 'new_balance_2002r_1.jpg', 'new_balance_2002r_2.jpg', 'new_balance_2002r_3.jpg'),
((SELECT id FROM product WHERE name = 'New Balance 2002R'), 4, 3200000, 0, 35, 'new_balance_2002r_1.jpg', 'new_balance_2002r_2.jpg', 'new_balance_2002r_3.jpg'),
((SELECT id FROM product WHERE name = 'New Balance 2002R'), 5, 3200000, 0, 40, 'new_balance_2002r_1.jpg', 'new_balance_2002r_2.jpg', 'new_balance_2002r_3.jpg');
