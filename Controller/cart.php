<?php
$act = 'cart';
if (isset($_GET['act'])) {
   $act = $_GET['act'];
}

switch ($act) {
   case 'cart':
      include_once "./View/cart.php";
      break;
   case 'get_district_province':
      include "../Model/DBConfig.php";
      include "../Model/API.php";
      include "../Model/Address_Order.php";
      $connect = new connect();
      $API = new API();
      $Address = new Address_Order();
      $province_id = $_POST['province_id'];
      $result = $Address->getAll_District($province_id)->fetchAll();
      echo json_encode($result);
      break;
   case 'get_wards_district':
      include "../Model/DBConfig.php";
      include "../Model/API.php";
      include "../Model/Address_Order.php";
      $connect = new connect();
      $API = new API();
      $Address = new Address_Order();
      $district_id = $_POST['district_id'];
      $ward_result = $Address->getAll_Wards($district_id)->fetchAll();
      echo json_encode($ward_result);
      break;
   case 'update_Quantity_Cart':
      session_start();
      $count = 0;
      if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
         // Đếm số lượng sản phẩm trong giỏ hàng
         foreach ($_SESSION['cart'] as $item) {
            if (isset($item['quantity'])) {
               $count += $item['quantity'];
            }
         }
      } else {
         $count = 0;
      }

      echo json_encode($count);
      break;
   case 'increase_cart':
      session_start();
      $sp_id = $_POST['sp_id'];
      if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
         foreach ($_SESSION['cart'] as &$item) {
            if ($item['idsp'] == $sp_id) {
               $item['quantity'] += 1;
               $response = array(
                  'quantity' => $item['quantity'],
               );
               echo json_encode($response);
               break;
            }
         }
         unset($item); // Hủy tham chiếu sau khi vòng lặp kết thúc
      }
      break;
   case 'decrease_cart':
      session_start();
      $sp_id = $_POST['sp_id'];
      if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
         foreach ($_SESSION['cart'] as &$item) {
            if ($item['idsp'] == $sp_id) {
               if ($item['quantity'] == 1) {
                  $response = [
                     'quantity' => 1
                  ];
               } else {
                  $item['quantity'] -= 1;
                  $response = array(
                     'quantity' => $item['quantity'],
                  );
               }
               echo json_encode($response);
               break;
            }
         }
         unset($item); // Hủy tham chiếu sau khi vòng lặp kết thúc
      }

      break;
   case 'check_quantity':
      session_start();
      // Nhận dữ liệu mảng từ AJAX
      $productPositions = json_decode($_POST['productPositions']);

      include "../Model/DBConfig.php";
      include "../Model/API.php";
      include "../Model/Product.php";
      $connect = new connect();
      $API = new API();
      $Product = new Product();

      $results = []; // Tạo một mảng kết quả

      foreach ($_SESSION['cart'] as $item) {
         $position = $item['idsp']; // Lấy vị trí của sản phẩm
         if (in_array($position, $productPositions)) { // Kiểm tra xem vị trí có trong mảng productPositions không
            $result_product = $Product->getQuantity_ByNameSize($item['name'], $item['size']);

            if ($item['quantity'] > $result_product['quantity']) {
               $res = [
                  'status' => 'false',
                  'index' => $position,
                  'message' => 'Sản phẩm không đủ hàng.',
               ];
               // Thêm mảng dữ liệu vào mảng kết quả
               $results[] = $res;
            }
         }
      }
      echo json_encode($results);
      break;
   case 'repository':
      $product_id = $_POST['product_id'];
      include "../Model/DBConfig.php";
      include "../Model/API.php";
      include "../Model/Product.php";
      $connect = new connect();
      $API = new API();
      $Product = new Product();

      $result_product = $Product->getAll_Quantity($product_id)->fetch();
      echo json_encode($result_product['count']);
      break;
   case 'repository_Size':
      $size_id = $_POST['size_id'];
      $product_id = $_POST['product_id'];
      include "../Model/DBConfig.php";
      include "../Model/API.php";
      include "../Model/Product.php";
      $connect = new connect();
      $API = new API();
      $Product = new Product();

      $result_product = $Product->getSize_Quantity($product_id, $size_id)->fetch();
      echo json_encode($result_product['count']);
      break;
   // Lấy số lượng tồn kho trong giỏ hàng 
   case 'repo_Cart':
      session_start();
      $productPositions = json_decode($_POST['productPositions']);
      include "../Model/DBConfig.php";
      include "../Model/API.php";
      include "../Model/Product.php";
      $connect = new connect();
      $API = new API();
      $Product = new Product();

      $results = []; // Tạo một mảng kết quả
      foreach ($_SESSION['cart'] as $item) {
         $position = $item['idsp']; // Lấy vị trí của sản phẩm
         if (in_array($position, $productPositions)) { // Kiểm tra xem vị trí có trong mảng productPositions không
            $result_product = $Product->getQuantity_ByNameSize($item['name'], $item['size']);
            $res = [
               'status' => 200,
               'index' => $position,
               'quantity' => $result_product['quantity']
            ];
            $results[] = $res;
         }
      }
      echo json_encode($results);
      break;
   // Lấy sản phẩm bằng tên và id_size
   case 'getDetailsProduct_NameSizeID':
      include "../Model/DBConfig.php";
      include "../Model/API.php";
      include "../Model/Product.php";
      $connect = new connect();
      $API = new API();
      $Product = new Product();

      $name_product = $_POST['name_product'];
      $size_id = $_POST['size_id'];
      $product_result = $Product->getProduct_ByNameSizeID($name_product, $size_id);
      if ($product_result) {
         $res = [
            'status' => 200,
            'price' => $product_result['price'],
            'discount' => $product_result['discount'],
         ];
      }
      echo json_encode($res);
      break;
   // Lấy ra tổng tiền trong giỏ hàng
   case 'get_totalPrice_cart':
      session_start();
      $sum = 0;
      foreach ($_SESSION['cart'] as $cart) {
         $sum += $cart['price'] * $cart['quantity'];
      }
      echo json_encode($sum);
      break;
   case 'get_totalPrice_item':
      session_start();
      $result = [];
      foreach ($_SESSION['cart'] as $cart) {
         $result[] = [
            'idsp' => $cart['idsp'],
            'total_price' => $cart['price'] * $cart['quantity']
         ];
      }
      echo json_encode($result);
      break;
   case 'get_totalCart':
      session_start();
      $sum = 0;
      foreach ($_SESSION['cart'] as $cart) {
         $sum += $cart['quantity'];
      }
      echo json_encode($sum);
      break;
   case 'get_stock_by_size':
      include "../Model/DBConfig.php";
      include "../Model/API.php";
      include "../Model/Product.php";
      
      $connect = new connect();
      $API = new API();
      $product = new Product();
      
      $size_id = $_POST['size_id'];
      $name_product = $_POST['name_product'];
      
      $result = $product->getStockBySizeAndProduct($size_id, $name_product);
      $stock_quantity = $result ? $result : 0;
      
      // Calculate quantity already in cart for this product and size
      session_start();
      $cart_quantity = 0;
      if (isset($_SESSION['cart'])) {
         foreach ($_SESSION['cart'] as $item) {
            // Convert both to string for comparison to avoid type mismatch
            if ($item['name'] == $name_product && (string)$item['size'] == (string)$size_id) {
               $cart_quantity += $item['quantity'];
            }
         }
      }
      
      // With new business logic: stock is always available until payment
      // Only show warning if total stock is less than cart quantity
      $available_stock = $stock_quantity;
      
      echo json_encode([
         'stock' => $stock_quantity,
         'available' => $available_stock,
         'in_cart' => $cart_quantity,
         'warning' => ($cart_quantity > $stock_quantity) ? 'Không đủ hàng trong kho' : null
      ]);
      break;

   case 'clear_cart':
      session_start();
      $_SESSION['cart'] = [];
      echo json_encode(['status' => 'OK', 'message' => 'Cart cleared successfully']);
      break;

}