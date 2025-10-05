<?php 
   class API {
      function get_All($select) {
         $db = new connect();
         // $query = $select;
         $result = $db->getList($select);
         return $result;
      }

      function get_one($select) {
         $db = new connect();
         // $query = $select;
         $result = $db->getInstance($select);
         return $result;
      }

      function add_delete_update($select) {
         $db = new connect();
         // $query = $select;
         $result = $db->exec($select);
         return $result;
      }
   }