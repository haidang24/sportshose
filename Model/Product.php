<?php
class Product
{
   // Phần sản phẩm

   // Lấy tất cả sản phẩm 
   function getAll_Product()
   {
      $API = new API();
      return $API->get_All("SELECT * FROM product");
   }

   // Lấy sản phẩm theo ID
   function get_product_by_id($id)
   {
      $API = new API();
      return $API->get_one("SELECT * FROM product WHERE id = $id");
   }

   // Lấy sản phẩm theo tên
   function get_product_by_name($name)
   {
      $API = new API();
      return $API->get_one("SELECT * FROM product WHERE name = '$name'");
   }

   // Lấy size theo tên
   function get_size_by_name($size_name)
   {
      $API = new API();
      return $API->get_one("SELECT * FROM size WHERE size = '$size_name'");
   }

   // Lấy sản phẩm theo tên, giá, giảm giá
   function getProduct_ByNamePriceDiscount()
   {
      $API = new API();
      return $API->get_All("SELECT 
         sp.id, 
         sp.shoes_type_id, 
         sp.brand_id, 
         sp.img, 
         sp.name, 
         MIN(ctsp.price) AS price,
         MIN(ctsp.discount) AS discount
     FROM 
         product AS sp
     INNER JOIN 
         details_product AS ctsp ON sp.id = ctsp.product_id
      WHERE 
         sp.hidden = 0
     GROUP BY 
         sp.name;
     ");
   }

   // Lấy ra img, name, price, discount bằng size
   function getProduct_BySize($size_id, $id)
   {
      $API = new API();
      return $API->get_one("SELECT p.id, p.name, p.img, ctsp.price, ctsp.discount
      FROM product AS p JOIN details_product AS ctsp ON p.id = ctsp.product_id 
      WHERE ctsp.size_id = $size_id AND p.id = $id");
   }


   // Lấy sản phẩm theo LIMIT
   function getProduct_ByNamePriceDiscountLimit($start, $end)
   {
      $API = new API();
      return $API->get_All("SELECT sp.id, sp.shoes_type_id, sp.brand_id, sp.img, sp.name, MIN(ctsp.price) AS price, MIN(ctsp.discount) AS discount 
      FROM product AS sp INNER JOIN details_product AS ctsp ON sp.id = ctsp.product_id WHERE 
      sp.hidden = 0
      GROUP BY sp.name LIMIT $start, $end");
   }

   // Lấy chi tiết sản phẩm bảng product và product_id
   function getOne_DetailProduct($id)
   {
      $API = new API();
      return $API->get_one("SELECT DISTINCT sp.id, sp.name as tensp, shoes_type.name as tenloai, brand.name_brand, sp.descriptions, sp.img, ctsp.img1, ctsp.img2, ctsp.img3, ctsp.price, ctsp.discount 
         FROM product as sp, details_product as ctsp , brand, shoes_type 
         WHERE sp.id = ctsp.product_id AND sp.brand_id = brand.id AND sp.shoes_type_id = shoes_type.id AND sp.id=$id");
   }

   // Lấy sản phẩm bằng ID 
   function getByID_Product($id)
   {
      $API = new API();
      return $API->get_one("SELECT * FROM product WHERE id=$id");
   }
   function add_Product($name_product, $shoes_type_id, $brand_id, $description, $img)
   {
      $API = new API();
      $API->add_delete_update(
         "INSERT INTO `product`(`name`, `shoes_type_id`, `brand_id`, `descriptions`, `img`) VALUES ('$name_product','$shoes_type_id','$brand_id','$description','$img')"
      );
   }

   // Kiểm tra sản phẩm trùng
   function get_ProductBy($name, $shoes_type_id, $brand_id)
   {
      $API = new API();
      return $API->get_one("SELECT pro.name, pro.shoes_type_id, pro.brand_id FROM product as pro 
         WHERE pro.name='$name' AND pro.shoes_type_id=$shoes_type_id AND pro.brand_id=$brand_id");
   }

   // Get product by name, brand's name, shoes's name
   function get_ProductByNBS()
   {
      $API = new API();
      return $API->get_All("SELECT product.name , product.id AS id,brand.name_brand AS brand_name, shoes_type.name AS shoes_type_name 
         FROM product JOIN brand ON product.brand_id = brand.id 
         JOIN shoes_type ON product.shoes_type_id = shoes_type.id");
   }

   // Chỉnh sửa sản phẩm bằng ID
   function update_Product($id, $name, $shoes_type_id, $brand_id, $descriptions, $img)
   {
      $API = new API();
      return $API->add_delete_update("UPDATE `product` 
         SET `name` = '$name', `shoes_type_id` = $shoes_type_id, `brand_id` = $brand_id, `descriptions` = '$descriptions', `img` = '$img'
         WHERE `id` = $id;");
   }

   // Xóa sản phẩm 
   function delete_Product($id)
   {
      $API = new API();
      return $API->add_delete_update("DELETE FROM `product` WHERE id='$id'");
   }
   // và chi tiêt của sản phẩm đó
   function delete_DetailsOfProduct($id)
   {
      $API = new API();
      return $API->add_delete_update("DELETE FROM `details_product` WHERE product_id='$id'");
   }

   // Phần chi tiết sản phẩm
   // lấy chi tiết sản phẩm theo id
   function get_ProductDetailsByID($id)
   {
      $API = new API();
      return $API->get_All("SELECT ctsp.id, ctsp.product_id, s.size,ctsp.price, ctsp.discount, ctsp.quantity, ctsp.img1, ctsp.img2, ctsp.img3 FROM details_product as ctsp,size as s WHERE ctsp.size_id = s.id AND ctsp.product_id='$id'");
   }

   // Get product name, brand's name, shoes's name by ID
   function get_ProductByID($id)
   {
      $API = new API();
      return $API->get_one("SELECT product.name , product.id AS id,brand.name_brand AS brand_name, shoes_type.name AS shoes_type_name 
         FROM product JOIN brand ON product.brand_id = brand.id JOIN shoes_type ON product.shoes_type_id = shoes_type.id 
         WHERE product.id=$id");
   }
   function add_ProductDetails($product_id, $size_id, $price, $discount, $quantity, $img1, $img2, $img3)
   {
      $API = new API();
      $API->add_delete_update(
         "INSERT INTO `details_product`(`product_id`, `size_id`, `price`, `discount`, `quantity`, `img1`, `img2`, `img3`) VALUES ($product_id,$size_id,$price,$discount,$quantity, '$img1', '$img2', '$img3')"
      );
   }

   // Lấy chi tiết sản phẩm với tên size bằng ID
   function get_ProductDetailsBySize($id)
   {
      $API = new API();
      return $API->get_one("SELECT ctsp.id, ctsp.product_id, ctsp.price, ctsp.discount, ctsp.quantity, ctsp.img1, ctsp.img2, ctsp.img3, s.size FROM details_product as ctsp, size as s WHERE ctsp.size_id = s.id AND ctsp.id=$id");
   }

   function delete_ProductDetails($id)
   {
      $API = new API();
      return $API->add_delete_update("DELETE FROM details_product WHERE id=$id");
   }

   // Chỉnh sửa chi tiết sản phẩm 
   function update_ProductDetails($price, $discount, $quantity, $img1, $img2, $img3, $id)
   {
      $API = new API();
      return $API->add_delete_update("UPDATE details_product SET `price`='$price',`discount`='$discount',`quantity`='$quantity',`img1`='$img1',`img2`='$img2',`img3`='$img3' WHERE id=$id");
   }

   // Lấy ra tất cả giày futsal
   function getAll_ShoesFutsal()
   {
      $API = new API();
      return $API->get_All('SELECT DISTINCT sp.id, sp.img, sp.name, ctsp.price, ctsp.discount 
      FROM product as sp, details_product as ctsp 
      WHERE sp.hidden = 0 AND sp.shoes_type_id=5 AND sp.id = ctsp.product_id');
   }

   // Lấy ra tất cả giày cỏ nhân tạo
   function getAll_ShoesFootball()
   {
      $API = new API();
      return $API->get_All('SELECT DISTINCT sp.id, sp.img, sp.name, ctsp.price, ctsp.discount 
      FROM product as sp, details_product as ctsp 
      WHERE sp.hidden = 0 AND sp.shoes_type_id=4 AND sp.id = ctsp.product_id');
   }

   // Sắp xếp theo giá giảm dần
   function getPrice_Decrease()
   {
      $API = new API();
      return $API->get_All('SELECT 
      sp.id, 
      sp.shoes_type_id, 
      sp.brand_id, 
      sp.img, 
      sp.name, 
      MIN(ctsp.price) AS price, 
      MIN(ctsp.discount) AS discount 
  FROM 
      product AS sp 
  INNER JOIN 
      details_product AS ctsp 
  ON 
      sp.id = ctsp.product_id 
  WHERE 
      sp.hidden = 0
  GROUP BY 
      sp.id, sp.shoes_type_id, sp.brand_id, sp.img, sp.name 
  ORDER BY  
      price DESC;
  ');
   }
   // Sắp xếp theo giá giảm dần theo Limit()
   function getPrice_DecreaseLimit($start, $end)
   {
      $API = new API();
      return $API->get_All("SELECT sp.id, sp.shoes_type_id, sp.brand_id, sp.img, sp.name, MIN(ctsp.price) AS price, MIN(ctsp.discount) AS discount 
      FROM product AS sp INNER JOIN details_product AS ctsp ON sp.id = ctsp.product_id WHERE 
      sp.hidden = 0 GROUP BY sp.name ORDER BY price DESC LIMIT $start,$end");
   }


   // Sắp xếp theo giá tăng dần
   function getPrice_Ascending()
   {
      $API = new API();
      return $API->get_All('SELECT sp.id, sp.shoes_type_id, sp.brand_id, sp.img, sp.name, MIN(ctsp.price) AS price, MIN(ctsp.discount) AS discount 
      FROM product AS sp INNER JOIN details_product AS ctsp ON sp.id = ctsp.product_id WHERE 
      sp.hidden = 0 GROUP BY sp.name ORDER BY price ASC');
   }

   // Sắp xếp theo giá tăng dần theo limit
   function getPrice_AscendingLimit($start, $end)
   {
      $API = new API();
      return $API->get_All("SELECT sp.id, sp.shoes_type_id, sp.brand_id, sp.img, sp.name, MIN(ctsp.price) AS price, MIN(ctsp.discount) AS discount 
      FROM product AS sp INNER JOIN details_product AS ctsp ON sp.id = ctsp.product_id WHERE 
      sp.hidden = 0 GROUP BY sp.name ORDER BY price ASC LIMIT $start, $end");
   }



   // Trừ số lượng tồn trong chi tiết sản phẩm theo tên, size
   function decrease_quantity($product_name, $size, $quantity)
   {
      $API = new API();
      return $API->add_delete_update("UPDATE details_product AS ctsp
         JOIN product AS sp ON sp.id = ctsp.product_id
         JOIN size ON ctsp.size_id = size.id
         SET ctsp.quantity = ctsp.quantity - $quantity
         WHERE sp.name = '$product_name' AND size.size = $size;
         ");
   }

   // Cộng số lượng tồn trong chi tiết sản phẩm theo tên, size (khi hủy đơn)
   function increase_quantity($product_name, $size, $quantity)
   {
      $API = new API();
      return $API->add_delete_update("UPDATE details_product AS ctsp
         JOIN product AS sp ON sp.id = ctsp.product_id
         JOIN size ON ctsp.size_id = size.id
         SET ctsp.quantity = ctsp.quantity + $quantity
         WHERE sp.name = '$product_name' AND size.size = $size;
         ");
   }

   // Lấy ra số lượng tồn bằng tên và size 
   function getQuantity_ByNameSize($product_name, $size)
   {
      $API = new API();
      return $API->get_one("SELECT sp.id, sp.name, ctsp.size_id, size.size, ctsp.quantity 
         FROM product AS sp JOIN details_product AS ctsp ON sp.id = ctsp.product_id 
         JOIN size ON ctsp.size_id = size.id 
         WHERE sp.name = '$product_name' AND size.size = $size");
   }

   // Lấy tổng số lượng tồn của từng sản phẩm
   function getAll_Quantity($id)
   {
      $API = new API();
      return $API->get_All("SELECT SUM(ctsp.quantity) as count
         FROM product as sp, details_product as ctsp 
         WHERE sp.id = ctsp.product_id AND sp.id = $id");
   }

   // Lấy tổng số lượng tồn của từng size theo sản phẩm
   function getSize_Quantity($id, $size_id)
   {
      $API = new API();
      return $API->get_All("SELECT SUM(ctsp.quantity) as count 
         FROM product as sp, details_product as ctsp 
         WHERE sp.id = ctsp.product_id AND sp.id=$id AND ctsp.size_id=$size_id");
   }

   // Lấy ra chi tiết sản phẩm bằng id sản phẩm và size_id
   function getDetailsProduct_ByNameSizeID($id, $size_id)
   {
      $API = new API();
      return $API->get_one("SELECT sp.name, ctsp.size_id FROM product as sp, details_product as ctsp WHERE sp.id = ctsp.product_id AND ctsp.size_id = $size_id AND sp.id=$id");
   }

   // Lấy ra chi tiết sản phẩm bằng tên sản phẩm và size_id
   function getProduct_ByNameSizeID($name, $size_id)
   {
      $API = new API();
      return $API->get_one("SELECT sp.name, ctsp.size_id, ctsp.price, ctsp.discount 
      FROM product as sp, details_product as ctsp 
      WHERE sp.id = ctsp.product_id AND ctsp.size_id = $size_id AND sp.name= '$name'");
   }

   // ẩn sản phẩm
   function hidden_product($product_id)
   {
      $API = new API();
      return $API->add_delete_update("UPDATE `product` SET hidden = 1 WHERE id='$product_id'");
   }

   // Hiện sản phẩm
   function show_product($product_id)
   {
      $API = new API();
      return $API->add_delete_update("UPDATE `product` SET hidden = 0 WHERE id='$product_id'");
   }

   // Lấy 10 sản phẩm giảm giá nhiều nhất
   function getTopDiscountProducts($limit = 10)
   {
      $API = new API();
      return $API->get_All("SELECT 
         sp.id, 
         sp.shoes_type_id, 
         sp.brand_id, 
         sp.img, 
         sp.name, 
         MIN(ctsp.price) AS price,
         MIN(ctsp.discount) AS discount,
         CASE 
            WHEN MIN(ctsp.discount) > 0 THEN 
               ROUND(((MIN(ctsp.price) - MIN(ctsp.discount)) / MIN(ctsp.price)) * 100, 0)
            ELSE 0 
         END AS discount_percentage
      FROM 
         product AS sp
      INNER JOIN 
         details_product AS ctsp ON sp.id = ctsp.product_id
      WHERE 
         sp.hidden = 0 AND ctsp.discount > 0
      GROUP BY 
         sp.id, sp.shoes_type_id, sp.brand_id, sp.img, sp.name
      HAVING 
         discount_percentage > 0
      ORDER BY 
         discount_percentage DESC
      LIMIT $limit");
   }

   // Get stock quantity by size and product name
   function getStockBySizeAndProduct($size_value, $name_product)
   {
      $API = new API();
      $connect = new connect();
      $name_product = $connect->db->quote($name_product);
      $size_value = $connect->db->quote($size_value);
      $result = $API->get_One("SELECT ctsp.quantity 
                              FROM details_product AS ctsp
                              INNER JOIN product AS sp ON ctsp.product_id = sp.id
                              INNER JOIN size AS sz ON ctsp.size_id = sz.id
                              WHERE sz.size = $size_value AND sp.name = $name_product
                              LIMIT 1");
      
      // Return the quantity value or 0 if not found
      if ($result && isset($result['quantity'])) {
         return intval($result['quantity']);
      }
      return 0;
   }

   // Đếm tổng số sản phẩm
   function count_products()
   {
      $API = new API();
      $result = $API->get_one("SELECT COUNT(*) as dem FROM product");
      return $result;
   }
}
