<?php 
   class Statistical {
      function total_Money() {
         $API = new API();
         return $API->get_one("SELECT SUM(total_price) as total_money FROM goods_sold");
      }

      function total_Goods_Sold() {
         $API = new API();
         return $API->get_one("SELECT COUNT(id) as goods_sold FROM orders WHERE status=3");
      }

      function total_User() {
         $API = new API();
         return $API->get_one("SELECT COUNT(id) as total_user FROM user WHERE delete_at is null");
      }

      // Lấy ra TOP 3 sản phẩm bán nhiều nhất
      function getProduct_BestSale() {
         $API = new API();
         return $API->get_All("SELECT product_name, SUM(quantity_sold) AS total_sold 
         FROM goods_sold GROUP BY product_name ORDER BY total_sold DESC 
         LIMIT 3");
      }

      // Liệt kê số lượng đơn hàng theo tháng
      function getOrder_ByMonth() {
         $API = new API();
         return $API->get_All("SELECT DATE_FORMAT(delivered_time, '%Y-%m') AS month, COUNT(*) AS total_orders FROM orders WHERE delivered_time IS NOT NULL and status= 3 GROUP BY month");
      }

      // Liệt kê số lượng đơn hàng theo ngày
      function getOrder_ByDay() {
         $API = new API();
         return $API->get_All("SELECT DATE(delivered_time) AS day, COUNT(*) AS total_orders 
         FROM orders 
         WHERE delivered_time IS NOT NULL
         GROUP BY day;;
         ");
      }
   }