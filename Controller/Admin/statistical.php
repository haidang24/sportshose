<?php 
   $act = 'statistical';
   if(isset($_GET['act'])) {
      $act = $_GET['act'];
   }

   switch($act) {
      case 'statistical':
         include_once 'View/Admin/Statistical.php';
         break;
   }