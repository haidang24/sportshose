<?php 
   class Address_Order {
      function getAll_Province() {
         $API = new API();
         return $API->get_All('SELECT * FROM province');
      }

      function getAll_District($id) {
         $API = new API();
         return $API->get_All("SELECT * FROM district WHERE province_id=$id");
      }

      function getAll_Wards($id) {
         $API = new API();
         return $API->get_All("SELECT * FROM wards WHERE district_id=$id");
      }
   }