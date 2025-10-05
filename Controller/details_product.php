<?php
$act = 'details_product';
if (isset($_GET['act'])) {
   $act = $_GET['act'];
}

switch ($act) {
   case 'details_product':
      include_once "./View/details_product.php";
      break;
   case 'addCart':
      session_start();
      $idsp = $_POST['id_product'];
      $name = $_POST['name_product'];
      $img = $_POST['img'];
      $shoes_type = $_POST['shoes_type'];
      $brand = $_POST['brand'];
      $quantity = $_POST['quantity'];
      $price = $_POST['price'];
      $size = $_POST['size'];
      // Tạo ra mảng
      // Tạo một mảng biểu diễn sản phẩm
      $item = array(
         // mỗi lần thêm sản phẩm nó tự random 1 số 
         // dùng để làm chức năng xóa
         'idsp' => rand(1, 100),
         'name' => $name,
         'img' => $img,
         'shoes_type' => $shoes_type,
         'brand' => $brand,
         'quantity' => $quantity,
         'price' => $price,
         'size' => $size
      );
      //Tạo ra session
      if (!isset($_SESSION['cart'])) {
         $_SESSION['cart'] = array();
      }

      include "../Model/DBConfig.php";
      include "../Model/Product.php";
      include "../Model/API.php";
      $connect = new connect();
      $API = new API();
      $product = new Product();
      $result_product = $product->getQuantity_ByNameSize($name, $size);
      if($quantity > $result_product['quantity']) {
         $res = [
            'status' => 201,
            'message' => 'Sản phẩm không đủ hàng',
         ];
      }else if ($result_product['quantity'] > 0) {
         // Kiểm tra xem SESSION của tên và size có tồn tại chưa
         // Nếu chưa thì flag = false
         $flag = false;
         foreach ($_SESSION['cart'] as $key => $value) {
            if ($value['name'] == $name && $value['size'] == $size) {
               $flag = true;
               // Nếu sản phẩm đã tồn tại, tăng số lượng của nó
               $_SESSION['cart'][$key]['quantity'] += $quantity;
               break;
            }
         }
         // Nếu chưa thì thêm sản phẩm
         if (!$flag) {
            $_SESSION['cart'][] = $item; // Thêm sản phẩm vào cuối giỏ hàng
         }

        $res = [
            'status' => 200
        ]; 
      }
      echo json_encode($res);
      break;
   // Xóa mỗi item trong cart
   case 'delete_ItemCart':
      session_start();
      $id_item = $_POST['id_item'];
      foreach ($_SESSION['cart'] as $key => $item) {
         if ($item['idsp'] == $id_item) {
            unset($_SESSION['cart'][$key]); // Xóa phần tử khỏi mảng
            break; // Kết thúc vòng lặp sau khi xóa phần tử đầu tiên tìm thấy
         }
      }
      echo json_encode('Thành công');
      break;
   // Lấy ra số lượng tồn của sản phẩm đó bằng size và id
   case 'get_quantity_product':
      $product_id = $_POST['product_id'];
      $size = $_POST['size'];
      include "../Model/DBConfig.php";
      include "../Model/Product.php";
      include "../Model/API.php";
      $connect = new connect();
      $API = new API();
      $product = new Product();
      $result = $product->getSize_Quantity($product_id, $size)->fetch(PDO::FETCH_ASSOC);
      if($result) {
         $res = [
            'status' => 200,
            'message' => $result['count']
         ];
      }else {
         $res = [
            'status' => 404,
            'message' => 'Lỗi hệ thống'
         ];
      }
      echo json_encode($res);
      break;
   // Đổ sản phẩm khi người dùng đã chọn
   case 'get_product_sizeid':
      $product_id = $_POST['product_id'];
      $size = $_POST['size'];
      include "../Model/DBConfig.php";
      include "../Model/Product.php";
      include "../Model/API.php";
      $connect = new connect();
      $API = new API();
      $product = new Product();
      $result = $product->getProduct_BySize($size, $product_id);
      if($result) {
         $res = [
            'status' => 200,
            'message' => $result
         ];
      }else {
         $res = [
            'status' => 404,
            'message' => 'Lỗi hệ thống'
         ];
      }
      echo json_encode($res);
      break;
}