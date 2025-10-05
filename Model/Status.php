<?php 
   class status {
      function getAll_Status() {
         $API = new API();
         return $API->get_All('SELECT * FROM status');
      }

      // Chuyển đơn hàng về trạng thái đang giao
      function delivery_status($status_id, $order_id) {
         $API = new API();
         return $API->add_delete_update("UPDATE orders 
         SET status='$status_id', delivery_time = CURRENT_TIMESTAMP 
         WHERE order_id='$order_id'");
      }

      // Chuyển đơn hàng về trạng thái đã giao
      function deliveried_status($status_id, $order_id) {
         $API = new API();
         return $API->add_delete_update("UPDATE orders SET status='$status_id', delivered_time = CURRENT_TIMESTAMP 
         WHERE order_id='$order_id'");
      }
   }