<?php 
   class Order {
      // Lấy đơn hàng theo user_id
      function get_all_order($user_id) {
         $API = new API();
         $user_id = (int)$user_id;
         return $API->get_All("SELECT o.id, o.fullname, o.number_phone, o.address,
            p.name AS province, dist.name AS district, w.name AS wards,
            o.status, o.user_id, o.order_id, o.create_at, o.delivery_time, o.delivered_time, o.deleted_at,
            COALESCE(o.payment_method, 'COD') AS payment_method,
            COALESCE(SUM(d.total_price), 0) AS total_amount
            FROM orders AS o
            LEFT JOIN province AS p ON o.province = p.province_id
            LEFT JOIN district AS dist ON o.district = dist.district_id
            LEFT JOIN wards AS w ON o.wards = w.wards_id
            LEFT JOIN details_order AS d ON o.order_id = d.order_id AND d.deleted_at IS NULL
            WHERE o.user_id = $user_id
            GROUP BY o.id, o.fullname, o.number_phone, o.address,
                     p.name, dist.name, w.name, o.status, o.user_id, o.order_id, 
                     o.create_at, o.delivery_time, o.delivered_time, o.payment_method, o.deleted_at
            ORDER BY o.create_at DESC");
      }

      // Lấy chi tiết đơn hàng theo order_id


      // Lấy tất cả đơn hàng (bao gồm tất cả trạng thái)
      function getAll_Order() {
         $API = new API();
         return $API->get_All('SELECT orders.id, orders.fullname, orders.number_phone, orders.address, 
            province.name as province, district.name as district, wards.name as wards,
            orders.status, orders.order_id, orders.create_at, orders.delivery_time, orders.delivered_time, orders.deleted_at,
            COALESCE(orders.payment_method, "COD") AS payment_method,
            COALESCE(SUM(details_order.total_price), 0) AS total_amount
            FROM orders 
            LEFT JOIN province ON orders.province = province.province_id 
            LEFT JOIN district ON orders.district = district.district_id 
            LEFT JOIN wards ON orders.wards = wards.wards_id
            LEFT JOIN details_order ON orders.order_id = details_order.order_id AND details_order.deleted_at IS NULL
            WHERE orders.deleted_at IS NULL 
            GROUP BY orders.id, orders.fullname, orders.number_phone, orders.address, 
                     province.name, district.name, wards.name, orders.status, orders.order_id, 
                     orders.create_at, orders.delivery_time, orders.delivered_time, orders.payment_method
            ORDER BY orders.create_at DESC');
      }
      // Lấy tất cả đơn hàng đã giao
      function getAll_Order1() {
         $API = new API();
         return $API->get_All('SELECT orders.id, orders.fullname, orders.number_phone, orders.address, province.name as province, district.name as district, wards.name as wards,orders.status ,orders.order_id, orders.create_at, orders.delivery_time, orders.delivered_time  
         FROM orders, province, district, wards 
         WHERE orders.province = province.province_id AND orders.district = district.district_id AND orders.wards = wards.wards_id AND status = 3 ORDER BY orders.id DESC');
      }

      // Lấy tất cả đơn hàng đã giao theo limit
      function getAll_OrderedLimit($start, $end) {
         $API = new API();
         return $API->get_All("SELECT orders.id, orders.fullname, orders.number_phone, orders.address, province.name as province, district.name as district, wards.name as wards,orders.status ,orders.order_id, orders.create_at, orders.delivery_time, orders.delivered_time  
         FROM orders, province, district, wards 
         WHERE orders.province = province.province_id AND orders.district = district.district_id AND orders.wards = wards.wards_id AND status = 3 ORDER BY orders.id DESC LIMIT $start, $end");
      }

      // Kiểm tra đơn đã tồn tại theo order_id
      function exists_OrderId($order_id) {
         $API = new API();
         return $API->get_one("SELECT COUNT(*) AS cnt FROM orders WHERE order_id='$order_id'");
      }
      function add_Order($fullname, $number_phone, $address, $province, $district, $wards,$order_id ,$user_id, $status = 1) {
         try {
            $API = new API();
            
            // Debug input parameters
            error_log("add_Order called with: " . json_encode([
               'fullname' => $fullname,
               'number_phone' => $number_phone,
               'address' => $address,
               'province' => $province,
               'district' => $district,
               'wards' => $wards,
               'order_id' => $order_id,
               'user_id' => $user_id,
               'status' => $status
            ]));
            
            // Cho phép NULL khi thiếu dữ liệu địa chỉ (tránh fail insert)
            $provinceVal = ($province && $province != 0) ? (int)$province : 'NULL';
            $districtVal = ($district && $district != 0) ? (int)$district : 'NULL';
            $wardsVal    = ($wards && $wards != 0) ? (int)$wards : 'NULL';
            $userVal     = ($user_id && $user_id != 0) ? (int)$user_id : 'NULL';
            
            // Escape strings để tránh SQL injection
            $fullname = addslashes($fullname);
            $number_phone = addslashes($number_phone);
            $address = addslashes($address);
            $order_id = addslashes($order_id);
            
            // Ensure user_id is properly set
            if (!$user_id || $user_id == 0) {
                error_log("Warning: user_id is empty or 0, setting to 0");
                $userVal = '0';
            }
            
            // Determine payment method based on status
            $payment_method = ($status == 2) ? 'PayPal' : (strpos($order_id, 'COD-') === 0 ? 'COD' : (strpos($order_id, 'VNPAY-') === 0 ? 'VNPay' : 'COD'));
            
            $sql = "INSERT INTO orders(fullname, number_phone, address, province, district, wards, order_id, user_id, status, payment_method, create_at)
                    VALUES ('$fullname', '$number_phone', '$address', $provinceVal, $districtVal, $wardsVal, '$order_id', $userVal, $status, '$payment_method', CURRENT_TIMESTAMP)";
            
            error_log("Executing SQL: " . $sql);
            
            $result = $API->add_delete_update($sql);
            
            error_log("SQL result: " . var_export($result, true));
            
            if ($result === false || $result === 0) {
                error_log("Failed to add order - SQL: " . $sql);
                throw new Exception("Không thể tạo đơn hàng trong database");
            }
            
            error_log("Order added successfully with result: " . $result);
            return $result;
            
         } catch (Exception $e) {
            error_log("Exception in add_Order: " . $e->getMessage());
            throw $e;
         }
      }

      function add_DetailsOrder($name_product,$size ,$quantity, $img, $price, $total_price, $order_id) {
         $API = new API();
         
         // Escape strings để tránh SQL injection
         $name_product = addslashes($name_product);
         $size = addslashes($size);
         $img = addslashes($img);
         $order_id = addslashes($order_id);
         
         $sql = "INSERT INTO details_order(name_product,size, quantity, img, price,total_price ,order_id) VALUES ('$name_product','$size','$quantity','$img','$price','$total_price', '$order_id')";
         
         $result = $API->add_delete_update($sql);
         if ($result === false || $result === 0) {
             error_log("Failed to add order details: " . $sql);
             throw new Exception("Không thể tạo chi tiết đơn hàng");
         }
         return $result;
      }

      function getAll_DetailsOrderByID($order_id) {
         $API = new API();
         return $API->get_All("SELECT * FROM details_order 
            WHERE order_id='$order_id' AND deleted_at IS NULL
            ORDER BY id");
      }

      // Lấy ra tổng đơn hàng chờ xử lý 
      function getAll_WaitOrder() {
         $API = new API();
         return $API->get_one("SELECT count(status) as total_orders FROM orders WHERE status=1 AND orders.deleted_at IS NULL");
      }

      // Hủy đơn hàng bằng order_id
      function delete_Order($id) {
         $API = new API();
         return $API->add_delete_update("UPDATE orders SET deleted_at=CURRENT_TIMESTAMP WHERE order_id='$id'");
      }

      // Hủy chi tiết đơn hàng bằng order_id
      function delete_Details_Order($id) {
         $API = new API();
         return $API->add_delete_update("DELETE FROM details_order WHERE order_id='$id'");
      }

      // Lấy ra các đơn đã hủy 
      function get_cancel_order() {
         $API = new API();
         return $API->get_All("SELECT orders.id, orders.fullname, orders.number_phone, orders.address, province.name as province, district.name as district, wards.name as wards,orders.status ,orders.order_id, orders.create_at, orders.deleted_at 
         FROM orders, province, district, wards 
         WHERE orders.province = province.province_id AND orders.district = district.district_id AND orders.wards = wards.wards_id AND orders.deleted_at IS NOT NULL");
      }

      // Lấy ra các sản phẩm từ order_id
      function getDetailsProduct_ByOrderID($id) {
         $API = new API();
         return $API->get_All("SELECT ctsp.name_product, ctsp.size, ctsp.quantity FROM details_order as ctsp WHERE order_id='$id'");
      }

      // Cộng lại số lượng cho sản phẩm theo tên và size
      function increase_DetailsProduct($name_product, $size, $quantity) {
         $API = new API();
         return $API->add_delete_update("UPDATE details_product AS ctsp 
         JOIN product AS sp ON sp.id = ctsp.product_id JOIN size ON ctsp.size_id = size.id 
         SET ctsp.quantity = ctsp.quantity + $quantity WHERE size.size = '$size' AND sp.name = '$name_product'");
      }

      // Trừ lại số lượng trong bảng goods_sold theo tên và size
      function decrease_Goods_Sold($name_product, $size, $quantity) {
         $API = new API();
         return $API->add_delete_update("UPDATE goods_sold SET quantity_sold = quantity_sold-$quantity
         WHERE product_name='$name_product' AND size='$size'");
      }

      // Lấy ra lịch sử đơn hàng theo user_id
      function order_history_id($user_id) {
         $API = new API();
         return $API->get_All("SELECT c.order_id, c.name_product, c.size, c.quantity, c.img, c.price,
            o.status, o.create_at, o.delivered_time
            FROM orders AS o
            JOIN details_order AS c ON o.order_id = c.order_id
            WHERE o.user_id = $user_id AND o.deleted_at IS NULL
            ORDER BY o.create_at DESC");
      }

      // Lấy ra tổng tiền của các đơn hàng đã bán được (được giao)
      function sum_order_deliveried() {
         $API = new API();
         return $API->get_one("SELECT SUM(total_price) as total_money FROM details_order as ctdh, orders as dh WHERE ctdh.order_id = dh.order_id AND dh.status = 3");
      }

      // Đếm tổng số đơn hàng
      function count_orders()
      {
         $API = new API();
         $result = $API->get_one("SELECT COUNT(*) as dem FROM orders WHERE deleted_at IS NULL");
         return $result;
      }

      // Đếm đơn hàng theo trạng thái
      function count_orders_by_status($status) {
         $API = new API();
         $result = $API->get_one("SELECT COUNT(*) as dem FROM orders WHERE status = $status AND deleted_at IS NULL");
         return $result;
      }

      // Đếm đơn hàng chờ xử lý
      function count_pending_orders() {
         return $this->count_orders_by_status(1);
      }

      // Đếm đơn hàng đang giao
      function count_shipping_orders() {
         return $this->count_orders_by_status(2);
      }

      // Đếm đơn hàng đã giao
      function count_delivered_orders() {
         return $this->count_orders_by_status(3);
      }

      // Đếm đơn hàng đã hủy
      function count_cancelled_orders() {
         return $this->count_orders_by_status(4);
      }

      // Lấy chi tiết đơn hàng theo order_id
      function getOrderDetails($order_id) {
         $API = new API();
         $result = $API->get_one("SELECT orders.id, orders.fullname, orders.number_phone, orders.address, 
            province.name as province, district.name as district, wards.name as wards,
            orders.status, orders.order_id, orders.create_at, orders.delivery_time, orders.delivered_time, 
            orders.payment_method, orders.email,
            COALESCE(SUM(details_order.total_price), 0) AS total_amount
            FROM orders 
            LEFT JOIN province ON orders.province = province.province_id 
            LEFT JOIN district ON orders.district = district.district_id 
            LEFT JOIN wards ON orders.wards = wards.wards_id
            LEFT JOIN details_order ON orders.order_id = details_order.order_id AND details_order.deleted_at IS NULL
            WHERE orders.order_id = '$order_id' AND orders.deleted_at IS NULL
            GROUP BY orders.id, orders.fullname, orders.number_phone, orders.address, 
                     province.name, district.name, wards.name, orders.status, orders.order_id, 
                     orders.create_at, orders.delivery_time, orders.delivered_time, orders.payment_method, orders.email");
         return $result;
      }

      // Lấy danh sách sản phẩm trong đơn hàng
      function getOrderItems($order_id) {
         $API = new API();
         $result = $API->get_All("SELECT details_order.*, product.name as product_name, product.image
            FROM details_order 
            LEFT JOIN product ON details_order.product_id = product.id
            WHERE details_order.order_id = '$order_id' AND details_order.deleted_at IS NULL
            ORDER BY details_order.id");
         return $result->fetchAll(PDO::FETCH_ASSOC);
      }

      // Cập nhật trạng thái đơn hàng
      function updateOrderStatus($order_id, $status) {
         $API = new API();
         return $API->add_delete_update("UPDATE orders SET status = $status WHERE order_id = '$order_id' AND deleted_at IS NULL");
      }

      // Lấy trạng thái hiện tại của đơn hàng
      function getOrderStatus($order_id) {
         $API = new API();
         $result = $API->get_one("SELECT status FROM orders WHERE order_id = '$order_id' AND deleted_at IS NULL");
         return $result ? $result['status'] : null;
      }

      // Lấy phương thức thanh toán của đơn hàng
      function getOrderPaymentMethod($order_id) {
         $API = new API();
         $result = $API->get_one("SELECT payment_method FROM orders WHERE order_id = '$order_id' AND deleted_at IS NULL");
         return $result ? ($result['payment_method'] ?: 'COD') : 'COD';
      }

      // Kiểm tra quy trình chuyển đổi trạng thái có hợp lệ không
      function isValidStatusTransition($currentStatus, $newStatus, $paymentMethod = 'COD') {
         $current = (int)$currentStatus;
         $next = (int)$newStatus;
         
         // Không thể chuyển sang cùng trạng thái
         if ($current === $next) return false;
         
         // Quy trình hợp lệ:
         // 1 (Chờ xử lý) → 2 (Đang giao) hoặc 4 (Đã hủy) - CHỈ KHI COD
         // 2 (Đang giao) → 3 (Đã giao)
         // 3 (Đã giao) → không thể chuyển
         // 4 (Đã hủy) → không thể chuyển
         
         switch($current) {
            case 1: // Chờ xử lý
               if ($next === 2) return true; // Luôn có thể chuyển sang "Đang giao"
               if ($next === 4) return $paymentMethod === 'COD'; // Chỉ hủy được khi COD
               return false;
            case 2: // Đang giao
               return $next === 3;
            case 3: // Đã giao
               return false; // Không thể chuyển từ đã giao
            case 4: // Đã hủy
               return false; // Không thể chuyển từ đã hủy
            default:
               return false;
         }
      }
   }