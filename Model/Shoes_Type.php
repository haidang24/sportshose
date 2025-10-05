<?php 
   class Shoes_Type {
      function getAll_Shoes_Type() {
         $api = new API();
         return $api->get_All("SELECT * FROM shoes_type");
      }

      function get_Shoes_TypeByName($name) {
         $api = new API();
         return $api->get_one("SELECT * FROM shoes_type WHERE name='$name'");
      }
      function add_Shoes_Type($name) {
         $api = new API();
         $api->add_delete_update("INSERT INTO shoes_type(name) VALUES ('$name')");
      }

      function delete_Shoes_Type($shoes_type_id) {
         $api = new API();
         return $api->add_delete_update("DELETE FROM shoes_type WHERE id=$shoes_type_id");
      }
   }