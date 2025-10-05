<?php 
   class Brand {
      function getAll_Brand() {
         $api = new API();
         return $api->get_All("SELECT * FROM Brand");
      }

      function get_BrandByName($name) {
         $api = new API();
         return $api->get_one("SELECT * FROM Brand WHERE name_brand='$name'");
      }
      function add_Brand($name_brand) {
         $api = new API();
         $api->add_delete_update("INSERT INTO brand(name_brand) VALUES ('$name_brand')");
      }

      function delete_Brand($brand_id) {
         $api = new API();
         return $api->add_delete_update("DELETE FROM brand WHERE id=$brand_id");
      }
   }