-- Script để thêm sản phẩm có ảnh sẵn có
-- Chạy script này để thêm sản phẩm vào database

-- Thêm thương hiệu mới (nếu chưa có)
INSERT IGNORE INTO brand (name_brand) VALUES 
('Nike'),
('Adidas'),
('Puma'),
('New Balance'),
('Under Armour'),
('Reebok'),
('Converse'),
('Vans'),
('Jordan'),
('Asics');

-- Thêm loại giày mới (nếu chưa có)
INSERT IGNORE INTO shoes_type (name) VALUES 
('Giày Bóng Đá'),
('Giày Futsal'),
('Giày Chạy Bộ'),
('Giày Tennis'),
('Giày Basketball'),
('Giày Lifestyle'),
('Giày Training'),
('Giày Hiking'),
('Giày Skateboard'),
('Giày Golf');

-- Thêm size mới (nếu chưa có)
INSERT IGNORE INTO size (size) VALUES 
(35), (36), (37), (38), (39), (40), (41), (42), (43), (44), (45), (46), (47), (48);

-- Thêm sản phẩm Nike (có ảnh)
INSERT INTO product (name, shoes_type_id, brand_id, descriptions, img, hidden) VALUES 
('Nike Air Max 270', 3, 1, 'Giày chạy bộ với công nghệ Air Max tiên tiến, thiết kế hiện đại và thoải mái tối đa', 'nike_air_max_270.jpg', 0),
('Nike Mercurial Vapor 14', 1, 1, 'Giày bóng đá cao cấp với công nghệ Flyknit và đế FG chuyên nghiệp', 'nike_mercurial_vapor_14.jpg', 0),
('Nike Air Force 1', 6, 1, 'Giày lifestyle cổ điển với thiết kế timeless, phù hợp mọi phong cách', 'nike_air_force_1.jpg', 0),
('Nike Zoom Freak 3', 5, 1, 'Giày basketball chuyên nghiệp với công nghệ Zoom Air và thiết kế động lực', 'nike_zoom_freak_3.jpg', 0),
('Nike Dunk Low', 6, 1, 'Giày lifestyle với thiết kế cổ điển và màu sắc đa dạng', 'nike_dunk_low.jpg', 0);

-- Thêm sản phẩm Adidas (có ảnh)
INSERT INTO product (name, shoes_type_id, brand_id, descriptions, img, hidden) VALUES 
('Adidas Ultraboost 22', 3, 2, 'Giày chạy bộ với Boost foam và Primeknit upper, hiệu suất vượt trội', 'adidas_ultraboost_22.jpg', 0),
('Adidas Stan Smith', 6, 2, 'Giày lifestyle cổ điển với thiết kế minimal và chất liệu da cao cấp', 'adidas_stan_smith.jpg', 0),
('Adidas Copa Sense', 1, 2, 'Giày bóng đá với K-leather và công nghệ Touch Pods', 'adidas_copa_sense.jpg', 0);

-- Thêm sản phẩm New Balance (có ảnh)
INSERT INTO product (name, shoes_type_id, brand_id, descriptions, img, hidden) VALUES 
('New Balance 990v5', 3, 4, 'Giày chạy bộ với ENCAP midsole và thiết kế Made in USA', 'new_balance_990v5.jpg', 0),
('New Balance 2002R', 6, 4, 'Giày lifestyle với ABZORB midsole và thiết kế hiện đại', 'new_balance_2002r.jpg', 0);

-- Thêm chi tiết sản phẩm cho Nike Air Max 270
INSERT INTO details_product (product_id, size_id, price, discount, quantity, img1, img2, img3) VALUES 
(1, 1, 3500000, 0, 50, 'nike_air_max_270_1.jpg', 'nike_air_max_270_2.jpg', 'nike_air_max_270_3.jpg'),
(1, 2, 3500000, 0, 45, 'nike_air_max_270_1.jpg', 'nike_air_max_270_2.jpg', 'nike_air_max_270_3.jpg'),
(1, 3, 3500000, 0, 40, 'nike_air_max_270_1.jpg', 'nike_air_max_270_2.jpg', 'nike_air_max_270_3.jpg'),
(1, 4, 3500000, 0, 35, 'nike_air_max_270_1.jpg', 'nike_air_max_270_2.jpg', 'nike_air_max_270_3.jpg'),
(1, 5, 3500000, 0, 30, 'nike_air_max_270_1.jpg', 'nike_air_max_270_2.jpg', 'nike_air_max_270_3.jpg');

-- Thêm chi tiết sản phẩm cho Nike Mercurial Vapor 14
INSERT INTO details_product (product_id, size_id, price, discount, quantity, img1, img2, img3) VALUES 
(2, 1, 4500000, 4000000, 25, 'nike_mercurial_vapor_14_1.jpg', 'nike_mercurial_vapor_14_2.jpg', 'nike_mercurial_vapor_14_3.jpg'),
(2, 2, 4500000, 4000000, 30, 'nike_mercurial_vapor_14_1.jpg', 'nike_mercurial_vapor_14_2.jpg', 'nike_mercurial_vapor_14_3.jpg'),
(2, 3, 4500000, 4000000, 35, 'nike_mercurial_vapor_14_1.jpg', 'nike_mercurial_vapor_14_2.jpg', 'nike_mercurial_vapor_14_3.jpg'),
(2, 4, 4500000, 4000000, 40, 'nike_mercurial_vapor_14_1.jpg', 'nike_mercurial_vapor_14_2.jpg', 'nike_mercurial_vapor_14_3.jpg'),
(2, 5, 4500000, 4000000, 45, 'nike_mercurial_vapor_14_1.jpg', 'nike_mercurial_vapor_14_2.jpg', 'nike_mercurial_vapor_14_3.jpg');

-- Thêm chi tiết sản phẩm cho Nike Air Force 1
INSERT INTO details_product (product_id, size_id, price, discount, quantity, img1, img2, img3) VALUES 
(3, 1, 2800000, 0, 40, 'nike_air_force_1_1.jpg', 'nike_air_force_1_2.jpg', 'nike_air_force_1_3.jpg'),
(3, 2, 2800000, 0, 45, 'nike_air_force_1_1.jpg', 'nike_air_force_1_2.jpg', 'nike_air_force_1_3.jpg'),
(3, 3, 2800000, 0, 50, 'nike_air_force_1_1.jpg', 'nike_air_force_1_2.jpg', 'nike_air_force_1_3.jpg'),
(3, 4, 2800000, 0, 35, 'nike_air_force_1_1.jpg', 'nike_air_force_1_2.jpg', 'nike_air_force_1_3.jpg'),
(3, 5, 2800000, 0, 30, 'nike_air_force_1_1.jpg', 'nike_air_force_1_2.jpg', 'nike_air_force_1_3.jpg');

-- Thêm chi tiết sản phẩm cho Nike Zoom Freak 3
INSERT INTO details_product (product_id, size_id, price, discount, quantity, img1, img2, img3) VALUES 
(4, 1, 4200000, 0, 20, 'nike_zoom_freak_3_1.jpg', 'nike_zoom_freak_3_2.jpg', 'nike_zoom_freak_3_3.jpg'),
(4, 2, 4200000, 0, 25, 'nike_zoom_freak_3_1.jpg', 'nike_zoom_freak_3_2.jpg', 'nike_zoom_freak_3_3.jpg'),
(4, 3, 4200000, 0, 30, 'nike_zoom_freak_3_1.jpg', 'nike_zoom_freak_3_2.jpg', 'nike_zoom_freak_3_3.jpg'),
(4, 4, 4200000, 0, 35, 'nike_zoom_freak_3_1.jpg', 'nike_zoom_freak_3_2.jpg', 'nike_zoom_freak_3_3.jpg'),
(4, 5, 4200000, 0, 40, 'nike_zoom_freak_3_1.jpg', 'nike_zoom_freak_3_2.jpg', 'nike_zoom_freak_3_3.jpg');

-- Thêm chi tiết sản phẩm cho Nike Dunk Low
INSERT INTO details_product (product_id, size_id, price, discount, quantity, img1, img2, img3) VALUES 
(5, 1, 2800000, 2400000, 20, 'nike_dunk_low_1.jpg', 'nike_dunk_low_2.jpg', 'nike_dunk_low_3.jpg'),
(5, 2, 2800000, 2400000, 25, 'nike_dunk_low_1.jpg', 'nike_dunk_low_2.jpg', 'nike_dunk_low_3.jpg'),
(5, 3, 2800000, 2400000, 30, 'nike_dunk_low_1.jpg', 'nike_dunk_low_2.jpg', 'nike_dunk_low_3.jpg'),
(5, 4, 2800000, 2400000, 35, 'nike_dunk_low_1.jpg', 'nike_dunk_low_2.jpg', 'nike_dunk_low_3.jpg'),
(5, 5, 2800000, 2400000, 40, 'nike_dunk_low_1.jpg', 'nike_dunk_low_2.jpg', 'nike_dunk_low_3.jpg');

-- Thêm chi tiết sản phẩm cho Adidas Ultraboost 22
INSERT INTO details_product (product_id, size_id, price, discount, quantity, img1, img2, img3) VALUES 
(6, 1, 4200000, 0, 40, 'adidas_ultraboost_22_1.jpg', 'adidas_ultraboost_22_2.jpg', 'adidas_ultraboost_22_3.jpg'),
(6, 2, 4200000, 0, 45, 'adidas_ultraboost_22_1.jpg', 'adidas_ultraboost_22_2.jpg', 'adidas_ultraboost_22_3.jpg'),
(6, 3, 4200000, 0, 50, 'adidas_ultraboost_22_1.jpg', 'adidas_ultraboost_22_2.jpg', 'adidas_ultraboost_22_3.jpg'),
(6, 4, 4200000, 0, 35, 'adidas_ultraboost_22_1.jpg', 'adidas_ultraboost_22_2.jpg', 'adidas_ultraboost_22_3.jpg'),
(6, 5, 4200000, 0, 30, 'adidas_ultraboost_22_1.jpg', 'adidas_ultraboost_22_2.jpg', 'adidas_ultraboost_22_3.jpg');

-- Thêm chi tiết sản phẩm cho Adidas Stan Smith
INSERT INTO details_product (product_id, size_id, price, discount, quantity, img1, img2, img3) VALUES 
(7, 1, 2500000, 0, 30, 'adidas_stan_smith_1.jpg', 'adidas_stan_smith_2.jpg', 'adidas_stan_smith_3.jpg'),
(7, 2, 2500000, 0, 35, 'adidas_stan_smith_1.jpg', 'adidas_stan_smith_2.jpg', 'adidas_stan_smith_3.jpg'),
(7, 3, 2500000, 0, 40, 'adidas_stan_smith_1.jpg', 'adidas_stan_smith_2.jpg', 'adidas_stan_smith_3.jpg'),
(7, 4, 2500000, 0, 25, 'adidas_stan_smith_1.jpg', 'adidas_stan_smith_2.jpg', 'adidas_stan_smith_3.jpg'),
(7, 5, 2500000, 0, 20, 'adidas_stan_smith_1.jpg', 'adidas_stan_smith_2.jpg', 'adidas_stan_smith_3.jpg');

-- Thêm chi tiết sản phẩm cho Adidas Copa Sense
INSERT INTO details_product (product_id, size_id, price, discount, quantity, img1, img2, img3) VALUES 
(8, 1, 3500000, 0, 25, 'adidas_copa_sense_1.jpg', 'adidas_copa_sense_2.jpg', 'adidas_copa_sense_3.jpg'),
(8, 2, 3500000, 0, 30, 'adidas_copa_sense_1.jpg', 'adidas_copa_sense_2.jpg', 'adidas_copa_sense_3.jpg'),
(8, 3, 3500000, 0, 35, 'adidas_copa_sense_1.jpg', 'adidas_copa_sense_2.jpg', 'adidas_copa_sense_3.jpg'),
(8, 4, 3500000, 0, 40, 'adidas_copa_sense_1.jpg', 'adidas_copa_sense_2.jpg', 'adidas_copa_sense_3.jpg'),
(8, 5, 3500000, 0, 45, 'adidas_copa_sense_1.jpg', 'adidas_copa_sense_2.jpg', 'adidas_copa_sense_3.jpg');

-- Thêm chi tiết sản phẩm cho New Balance 990v5
INSERT INTO details_product (product_id, size_id, price, discount, quantity, img1, img2, img3) VALUES 
(9, 1, 5200000, 0, 15, 'new_balance_990v5_1.jpg', 'new_balance_990v5_2.jpg', 'new_balance_990v5_3.jpg'),
(9, 2, 5200000, 0, 20, 'new_balance_990v5_1.jpg', 'new_balance_990v5_2.jpg', 'new_balance_990v5_3.jpg'),
(9, 3, 5200000, 0, 25, 'new_balance_990v5_1.jpg', 'new_balance_990v5_2.jpg', 'new_balance_990v5_3.jpg'),
(9, 4, 5200000, 0, 30, 'new_balance_990v5_1.jpg', 'new_balance_990v5_2.jpg', 'new_balance_990v5_3.jpg'),
(9, 5, 5200000, 0, 35, 'new_balance_990v5_1.jpg', 'new_balance_990v5_2.jpg', 'new_balance_990v5_3.jpg');

-- Thêm chi tiết sản phẩm cho New Balance 2002R
INSERT INTO details_product (product_id, size_id, price, discount, quantity, img1, img2, img3) VALUES 
(10, 1, 3200000, 0, 20, 'new_balance_2002r_1.jpg', 'new_balance_2002r_2.jpg', 'new_balance_2002r_3.jpg'),
(10, 2, 3200000, 0, 25, 'new_balance_2002r_1.jpg', 'new_balance_2002r_2.jpg', 'new_balance_2002r_3.jpg'),
(10, 3, 3200000, 0, 30, 'new_balance_2002r_1.jpg', 'new_balance_2002r_2.jpg', 'new_balance_2002r_3.jpg'),
(10, 4, 3200000, 0, 35, 'new_balance_2002r_1.jpg', 'new_balance_2002r_2.jpg', 'new_balance_2002r_3.jpg'),
(10, 5, 3200000, 0, 40, 'new_balance_2002r_1.jpg', 'new_balance_2002r_2.jpg', 'new_balance_2002r_3.jpg');
