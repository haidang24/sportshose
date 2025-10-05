-- Script thêm sản phẩm an toàn
-- Chạy sau khi đã chạy check_and_fix_database.sql

-- 1. Thêm sản phẩm Nike
INSERT INTO product (name, shoes_type_id, brand_id, descriptions, img, hidden) VALUES 
('Nike Air Max 270', 
 (SELECT id FROM shoes_type WHERE name = 'Giày Chạy Bộ' LIMIT 1),
 (SELECT id FROM brand WHERE name_brand = 'Nike' LIMIT 1),
 'Giày chạy bộ với công nghệ Air Max tiên tiến, thiết kế hiện đại và thoải mái tối đa', 
 'nike_air_max_270.jpg', 0),

('Nike Mercurial Vapor 14', 
 (SELECT id FROM shoes_type WHERE name = 'Giày Bóng Đá' LIMIT 1),
 (SELECT id FROM brand WHERE name_brand = 'Nike' LIMIT 1),
 'Giày bóng đá cao cấp với công nghệ Flyknit và đế FG chuyên nghiệp', 
 'nike_mercurial_vapor_14.jpg', 0),

('Nike Air Force 1', 
 (SELECT id FROM shoes_type WHERE name = 'Giày Lifestyle' LIMIT 1),
 (SELECT id FROM brand WHERE name_brand = 'Nike' LIMIT 1),
 'Giày lifestyle cổ điển với thiết kế timeless, phù hợp mọi phong cách', 
 'nike_air_force_1.jpg', 0),

('Nike Zoom Freak 3', 
 (SELECT id FROM shoes_type WHERE name = 'Giày Basketball' LIMIT 1),
 (SELECT id FROM brand WHERE name_brand = 'Nike' LIMIT 1),
 'Giày basketball chuyên nghiệp với công nghệ Zoom Air và thiết kế động lực', 
 'nike_zoom_freak_3.jpg', 0),

('Nike Dunk Low', 
 (SELECT id FROM shoes_type WHERE name = 'Giày Lifestyle' LIMIT 1),
 (SELECT id FROM brand WHERE name_brand = 'Nike' LIMIT 1),
 'Giày lifestyle với thiết kế cổ điển và màu sắc đa dạng', 
 'nike_dunk_low.jpg', 0);

-- 2. Thêm sản phẩm Adidas
INSERT INTO product (name, shoes_type_id, brand_id, descriptions, img, hidden) VALUES 
('Adidas Ultraboost 22', 
 (SELECT id FROM shoes_type WHERE name = 'Giày Chạy Bộ' LIMIT 1),
 (SELECT id FROM brand WHERE name_brand = 'Adidas' LIMIT 1),
 'Giày chạy bộ với Boost foam và Primeknit upper, hiệu suất vượt trội', 
 'adidas_ultraboost_22.jpg', 0),

('Adidas Stan Smith', 
 (SELECT id FROM shoes_type WHERE name = 'Giày Lifestyle' LIMIT 1),
 (SELECT id FROM brand WHERE name_brand = 'Adidas' LIMIT 1),
 'Giày lifestyle cổ điển với thiết kế minimal và chất liệu da cao cấp', 
 'adidas_stan_smith.jpg', 0),

('Adidas Copa Sense', 
 (SELECT id FROM shoes_type WHERE name = 'Giày Bóng Đá' LIMIT 1),
 (SELECT id FROM brand WHERE name_brand = 'Adidas' LIMIT 1),
 'Giày bóng đá với K-leather và công nghệ Touch Pods', 
 'adidas_copa_sense.jpg', 0);

-- 3. Thêm sản phẩm New Balance
INSERT INTO product (name, shoes_type_id, brand_id, descriptions, img, hidden) VALUES 
('New Balance 990v5', 
 (SELECT id FROM shoes_type WHERE name = 'Giày Chạy Bộ' LIMIT 1),
 (SELECT id FROM brand WHERE name_brand = 'New Balance' LIMIT 1),
 'Giày chạy bộ với ENCAP midsole và thiết kế Made in USA', 
 'new_balance_990v5.jpg', 0),

('New Balance 2002R', 
 (SELECT id FROM shoes_type WHERE name = 'Giày Lifestyle' LIMIT 1),
 (SELECT id FROM brand WHERE name_brand = 'New Balance' LIMIT 1),
 'Giày lifestyle với ABZORB midsole và thiết kế hiện đại', 
 'new_balance_2002r.jpg', 0);

-- 4. Kiểm tra sản phẩm đã thêm
SELECT '=== SẢN PHẨM ĐÃ THÊM ===' as info;
SELECT p.id, p.name, b.name_brand, st.name as shoes_type, p.img 
FROM product p 
JOIN brand b ON p.brand_id = b.id 
JOIN shoes_type st ON p.shoes_type_id = st.id 
WHERE p.name LIKE 'Nike%' OR p.name LIKE 'Adidas%' OR p.name LIKE 'New Balance%'
ORDER BY p.id DESC;
