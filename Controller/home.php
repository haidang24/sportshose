<?php
$act = 'home';
if (isset($_GET['act'])) {
   $act = $_GET['act'];
}

switch ($act) {
   case 'home':
      include_once './View/home.php';
      break;
   case 'futsal':
      include_once './View/home.php';
      break;
   case 'football':
      include_once './View/home.php';
      break;
   case 'decrease':
      include_once './View/home.php';
      break;
   case 'ascending':
      include_once './View/home.php';
      break;

}