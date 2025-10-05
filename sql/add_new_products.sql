-- Script để thêm nhiều sản phẩm mới với ảnh đẹp
-- Chạy script này để thêm sản phẩm vào database

-- Thêm thương hiệu mới
INSERT INTO brand (name_brand) VALUES 
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

-- Thêm loại giày mới
INSERT INTO shoes_type (name) VALUES 
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

-- Thêm size mới
INSERT INTO size (size) VALUES 
(35), (36), (37), (38), (39), (40), (41), (42), (43), (44), (45), (46), (47), (48);

-- Thêm sản phẩm Nike
INSERT INTO product (name, shoes_type_id, brand_id, descriptions, img, hidden) VALUES 
('Nike Air Max 270', 3, 1, 'Giày chạy bộ với công nghệ Air Max tiên tiến, thiết kế hiện đại và thoải mái tối đa', 'nike_air_max_270.jpg', 0),
('Nike Mercurial Vapor 14', 1, 1, 'Giày bóng đá cao cấp với công nghệ Flyknit và đế FG chuyên nghiệp', 'nike_mercurial_vapor_14.jpg', 0),
('Nike React Infinity Run', 3, 1, 'Giày chạy bộ với công nghệ React foam, giảm chấn thương và tăng hiệu suất', 'nike_react_infinity.jpg', 0),
('Nike Air Force 1', 6, 1, 'Giày lifestyle cổ điển với thiết kế timeless, phù hợp mọi phong cách', 'nike_air_force_1.jpg', 0),
('Nike Zoom Freak 3', 5, 1, 'Giày basketball chuyên nghiệp với công nghệ Zoom Air và thiết kế động lực', 'nike_zoom_freak_3.jpg', 0);

-- Thêm sản phẩm Adidas
INSERT INTO product (name, shoes_type_id, brand_id, descriptions, img, hidden) VALUES 
('Adidas Ultraboost 22', 3, 2, 'Giày chạy bộ với Boost foam và Primeknit upper, hiệu suất vượt trội', 'adidas_ultraboost_22.jpg', 0),
('Adidas Predator Edge', 1, 2, 'Giày bóng đá với công nghệ Demonskin và đế FG chuyên nghiệp', 'adidas_predator_edge.jpg', 0),
('Adidas Stan Smith', 6, 2, 'Giày lifestyle cổ điển với thiết kế minimal và chất liệu da cao cấp', 'adidas_stan_smith.jpg', 0),
('Adidas Harden Vol 6', 5, 2, 'Giày basketball với Lightstrike foam và thiết kế hiện đại', 'adidas_harden_vol_6.jpg', 0),
('Adidas Copa Sense', 1, 2, 'Giày bóng đá với K-leather và công nghệ Touch Pods', 'adidas_copa_sense.jpg', 0);

-- Thêm sản phẩm Puma
INSERT INTO product (name, shoes_type_id, brand_id, descriptions, img, hidden) VALUES 
('Puma Future Z 4.3', 1, 3, 'Giày bóng đá với FUZIONFIT+ và đế FG chuyên nghiệp', 'puma_future_z_4.3.jpg', 0),
('Puma RS-X Reinvention', 6, 3, 'Giày lifestyle với thiết kế retro-futuristic và RS technology', 'puma_rs_x_reinvention.jpg', 0),
('Puma Deviate Nitro', 3, 3, 'Giày chạy bộ với NITRO foam và PWRPLATE carbon fiber', 'puma_deviate_nitro.jpg', 0),
('Puma Suede Classic', 6, 3, 'Giày lifestyle cổ điển với thiết kế timeless và chất liệu suede', 'puma_suede_classic.jpg', 0),
('Puma Court Rider', 4, 3, 'Giày tennis với ProFoam midsole và thiết kế hiện đại', 'puma_court_rider.jpg', 0);

-- Thêm sản phẩm New Balance
INSERT INTO product (name, shoes_type_id, brand_id, descriptions, img, hidden) VALUES 
('New Balance 990v5', 3, 4, 'Giày chạy bộ với ENCAP midsole và thiết kế Made in USA', 'new_balance_990v5.jpg', 0),
('New Balance 327', 6, 4, 'Giày lifestyle với thiết kế retro và N logo đặc trưng', 'new_balance_327.jpg', 0),
('New Balance 550', 6, 4, 'Giày lifestyle với thiết kế basketball cổ điển', 'new_balance_550.jpg', 0),
('New Balance FuelCell Rebel v2', 3, 4, 'Giày chạy bộ với FuelCell foam và thiết kế lightweight', 'new_balance_fuelcell_rebel.jpg', 0),
('New Balance 2002R', 6, 4, 'Giày lifestyle với ABZORB midsole và thiết kế hiện đại', 'new_balance_2002r.jpg', 0);

-- Thêm sản phẩm Under Armour
INSERT INTO product (name, shoes_type_id, brand_id, descriptions, img, hidden) VALUES 
('Under Armour Curry 9', 5, 5, 'Giày basketball với UA Flow và thiết kế signature của Stephen Curry', 'under_armour_curry_9.jpg', 0),
('Under Armour HOVR Sonic 4', 3, 5, 'Giày chạy bộ với HOVR foam và UA Record Sensor', 'under_armour_hovr_sonic_4.jpg', 0),
('Under Armour Project Rock 4', 7, 5, 'Giày training với UA HOVR và thiết kế của Dwayne Johnson', 'under_armour_project_rock_4.jpg', 0),
('Under Armour Charged Assert 9', 3, 5, 'Giày chạy bộ với Charged Cushioning và thiết kế breathable', 'under_armour_charged_assert_9.jpg', 0),
('Under Armour Spawn 3', 5, 5, 'Giày basketball với Micro G foam và thiết kế hiện đại', 'under_armour_spawn_3.jpg', 0);

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

-- Thêm chi tiết sản phẩm cho Adidas Ultraboost 22
INSERT INTO details_product (product_id, size_id, price, discount, quantity, img1, img2, img3) VALUES 
(6, 1, 4200000, 0, 40, 'adidas_ultraboost_22_1.jpg', 'adidas_ultraboost_22_2.jpg', 'adidas_ultraboost_22_3.jpg'),
(6, 2, 4200000, 0, 45, 'adidas_ultraboost_22_1.jpg', 'adidas_ultraboost_22_2.jpg', 'adidas_ultraboost_22_3.jpg'),
(6, 3, 4200000, 0, 50, 'adidas_ultraboost_22_1.jpg', 'adidas_ultraboost_22_2.jpg', 'adidas_ultraboost_22_3.jpg'),
(6, 4, 4200000, 0, 35, 'adidas_ultraboost_22_1.jpg', 'adidas_ultraboost_22_2.jpg', 'adidas_ultraboost_22_3.jpg'),
(6, 5, 4200000, 0, 30, 'adidas_ultraboost_22_1.jpg', 'adidas_ultraboost_22_2.jpg', 'adidas_ultraboost_22_3.jpg');

-- Thêm chi tiết sản phẩm cho Adidas Predator Edge
INSERT INTO details_product (product_id, size_id, price, discount, quantity, img1, img2, img3) VALUES 
(7, 1, 4800000, 4200000, 20, 'adidas_predator_edge_1.jpg', 'adidas_predator_edge_2.jpg', 'adidas_predator_edge_3.jpg'),
(7, 2, 4800000, 4200000, 25, 'adidas_predator_edge_1.jpg', 'adidas_predator_edge_2.jpg', 'adidas_predator_edge_3.jpg'),
(7, 3, 4800000, 4200000, 30, 'adidas_predator_edge_1.jpg', 'adidas_predator_edge_2.jpg', 'adidas_predator_edge_3.jpg'),
(7, 4, 4800000, 4200000, 35, 'adidas_predator_edge_1.jpg', 'adidas_predator_edge_2.jpg', 'adidas_predator_edge_3.jpg'),
(7, 5, 4800000, 4200000, 40, 'adidas_predator_edge_1.jpg', 'adidas_predator_edge_2.jpg', 'adidas_predator_edge_3.jpg');

-- Thêm chi tiết sản phẩm cho Puma Future Z 4.3
INSERT INTO details_product (product_id, size_id, price, discount, quantity, img1, img2, img3) VALUES 
(11, 1, 3800000, 0, 30, 'puma_future_z_4.3_1.jpg', 'puma_future_z_4.3_2.jpg', 'puma_future_z_4.3_3.jpg'),
(11, 2, 3800000, 0, 35, 'puma_future_z_4.3_1.jpg', 'puma_future_z_4.3_2.jpg', 'puma_future_z_4.3_3.jpg'),
(11, 3, 3800000, 0, 40, 'puma_future_z_4.3_1.jpg', 'puma_future_z_4.3_2.jpg', 'puma_future_z_4.3_3.jpg'),
(11, 4, 3800000, 0, 25, 'puma_future_z_4.3_1.jpg', 'puma_future_z_4.3_2.jpg', 'puma_future_z_4.3_3.jpg'),
(11, 5, 3800000, 0, 20, 'puma_future_z_4.3_1.jpg', 'puma_future_z_4.3_2.jpg', 'puma_future_z_4.3_3.jpg');

-- Thêm chi tiết sản phẩm cho New Balance 990v5
INSERT INTO details_product (product_id, size_id, price, discount, quantity, img1, img2, img3) VALUES 
(16, 1, 5200000, 0, 15, 'new_balance_990v5_1.jpg', 'new_balance_990v5_2.jpg', 'new_balance_990v5_3.jpg'),
(16, 2, 5200000, 0, 20, 'new_balance_990v5_1.jpg', 'new_balance_990v5_2.jpg', 'new_balance_990v5_3.jpg'),
(16, 3, 5200000, 0, 25, 'new_balance_990v5_1.jpg', 'new_balance_990v5_2.jpg', 'new_balance_990v5_3.jpg'),
(16, 4, 5200000, 0, 30, 'new_balance_990v5_1.jpg', 'new_balance_990v5_2.jpg', 'new_balance_990v5_3.jpg'),
(16, 5, 5200000, 0, 35, 'new_balance_990v5_1.jpg', 'new_balance_990v5_2.jpg', 'new_balance_990v5_3.jpg');

-- Thêm chi tiết sản phẩm cho Under Armour Curry 9
INSERT INTO details_product (product_id, size_id, price, discount, quantity, img1, img2, img3) VALUES 
(21, 1, 4600000, 4000000, 10, 'under_armour_curry_9_1.jpg', 'under_armour_curry_9_2.jpg', 'under_armour_curry_9_3.jpg'),
(21, 2, 4600000, 4000000, 15, 'under_armour_curry_9_1.jpg', 'under_armour_curry_9_2.jpg', 'under_armour_curry_9_3.jpg'),
(21, 3, 4600000, 4000000, 20, 'under_armour_curry_9_1.jpg', 'under_armour_curry_9_2.jpg', 'under_armour_curry_9_3.jpg'),
(21, 4, 4600000, 4000000, 25, 'under_armour_curry_9_1.jpg', 'under_armour_curry_9_2.jpg', 'under_armour_curry_9_3.jpg'),
(21, 5, 4600000, 4000000, 30, 'under_armour_curry_9_1.jpg', 'under_armour_curry_9_2.jpg', 'under_armour_curry_9_3.jpg');

-- Thêm thêm một số sản phẩm khác với giá và giảm giá khác nhau
INSERT INTO product (name, shoes_type_id, brand_id, descriptions, img, hidden) VALUES 
('Nike Dunk Low', 6, 1, 'Giày lifestyle với thiết kế cổ điển và màu sắc đa dạng', 'nike_dunk_low.jpg', 0),
('Adidas Yeezy Boost 350', 6, 2, 'Giày lifestyle với Boost foam và thiết kế futuristic', 'adidas_yeezy_boost_350.jpg', 0),
('Puma Cali Sport', 6, 3, 'Giày lifestyle với thiết kế retro và chất liệu cao cấp', 'puma_cali_sport.jpg', 0),
('New Balance 574', 6, 4, 'Giày lifestyle cổ điển với ENCAP midsole', 'new_balance_574.jpg', 0),
('Under Armour Charged Bandit 6', 3, 5, 'Giày chạy bộ với Charged Cushioning và thiết kế breathable', 'under_armour_charged_bandit_6.jpg', 0);

-- Thêm chi tiết cho các sản phẩm mới
INSERT INTO details_product (product_id, size_id, price, discount, quantity, img1, img2, img3) VALUES 
-- Nike Dunk Low
(26, 1, 2800000, 2400000, 20, 'nike_dunk_low_1.jpg', 'nike_dunk_low_2.jpg', 'nike_dunk_low_3.jpg'),
(26, 2, 2800000, 2400000, 25, 'nike_dunk_low_1.jpg', 'nike_dunk_low_2.jpg', 'nike_dunk_low_3.jpg'),
(26, 3, 2800000, 2400000, 30, 'nike_dunk_low_1.jpg', 'nike_dunk_low_2.jpg', 'nike_dunk_low_3.jpg'),
(26, 4, 2800000, 2400000, 35, 'nike_dunk_low_1.jpg', 'nike_dunk_low_2.jpg', 'nike_dunk_low_3.jpg'),
(26, 5, 2800000, 2400000, 40, 'nike_dunk_low_1.jpg', 'nike_dunk_low_2.jpg', 'nike_dunk_low_3.jpg'),

-- Adidas Yeezy Boost 350
(27, 1, 6500000, 0, 5, 'adidas_yeezy_boost_350_1.jpg', 'adidas_yeezy_boost_350_2.jpg', 'adidas_yeezy_boost_350_3.jpg'),
(27, 2, 6500000, 0, 8, 'adidas_yeezy_boost_350_1.jpg', 'adidas_yeezy_boost_350_2.jpg', 'adidas_yeezy_boost_350_3.jpg'),
(27, 3, 6500000, 0, 10, 'adidas_yeezy_boost_350_1.jpg', 'adidas_yeezy_boost_350_2.jpg', 'adidas_yeezy_boost_350_3.jpg'),
(27, 4, 6500000, 0, 12, 'adidas_yeezy_boost_350_1.jpg', 'adidas_yeezy_boost_350_2.jpg', 'adidas_yeezy_boost_350_3.jpg'),
(27, 5, 6500000, 0, 15, 'adidas_yeezy_boost_350_1.jpg', 'adidas_yeezy_boost_350_2.jpg', 'adidas_yeezy_boost_350_3.jpg'),

-- Puma Cali Sport
(28, 1, 2200000, 0, 25, 'puma_cali_sport_1.jpg', 'puma_cali_sport_2.jpg', 'puma_cali_sport_3.jpg'),
(28, 2, 2200000, 0, 30, 'puma_cali_sport_1.jpg', 'puma_cali_sport_2.jpg', 'puma_cali_sport_3.jpg'),
(28, 3, 2200000, 0, 35, 'puma_cali_sport_1.jpg', 'puma_cali_sport_2.jpg', 'puma_cali_sport_3.jpg'),
(28, 4, 2200000, 0, 40, 'puma_cali_sport_1.jpg', 'puma_cali_sport_2.jpg', 'puma_cali_sport_3.jpg'),
(28, 5, 2200000, 0, 45, 'puma_cali_sport_1.jpg', 'puma_cali_sport_2.jpg', 'puma_cali_sport_3.jpg'),

-- New Balance 574
(29, 1, 1800000, 0, 30, 'new_balance_574_1.jpg', 'new_balance_574_2.jpg', 'new_balance_574_3.jpg'),
(29, 2, 1800000, 0, 35, 'new_balance_574_1.jpg', 'new_balance_574_2.jpg', 'new_balance_574_3.jpg'),
(29, 3, 1800000, 0, 40, 'new_balance_574_1.jpg', 'new_balance_574_2.jpg', 'new_balance_574_3.jpg'),
(29, 4, 1800000, 0, 45, 'new_balance_574_1.jpg', 'new_balance_574_2.jpg', 'new_balance_574_3.jpg'),
(29, 5, 1800000, 0, 50, 'new_balance_574_1.jpg', 'new_balance_574_2.jpg', 'new_balance_574_3.jpg'),

-- Under Armour Charged Bandit 6
(30, 1, 2600000, 2200000, 20, 'under_armour_charged_bandit_6_1.jpg', 'under_armour_charged_bandit_6_2.jpg', 'under_armour_charged_bandit_6_3.jpg'),
(30, 2, 2600000, 2200000, 25, 'under_armour_charged_bandit_6_1.jpg', 'under_armour_charged_bandit_6_2.jpg', 'under_armour_charged_bandit_6_3.jpg'),
(30, 3, 2600000, 2200000, 30, 'under_armour_charged_bandit_6_1.jpg', 'under_armour_charged_bandit_6_2.jpg', 'under_armour_charged_bandit_6_3.jpg'),
(30, 4, 2600000, 2200000, 35, 'under_armour_charged_bandit_6_1.jpg', 'under_armour_charged_bandit_6_2.jpg', 'under_armour_charged_bandit_6_3.jpg'),
(30, 5, 2600000, 2200000, 40, 'under_armour_charged_bandit_6_1.jpg', 'under_armour_charged_bandit_6_2.jpg', 'under_armour_charged_bandit_6_3.jpg');
