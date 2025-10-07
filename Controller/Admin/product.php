<?php
$error_message = "";
$act = "product";
if (isset($_GET['act'])) {
   $act = $_GET['act'];
}

switch ($act) {
   case 'product':
      include_once "./View/Admin/Product.php";
      break;
   // Link tới trang thêm sản phẩm, chi tiết
   case 'add_product':
      include_once './View/Admin/addproduct.php';
      break;
   // Link tới trang chi tiết sản phẩm
   case 'product_details':
      include_once './View/Admin/Product_Details.php';
      break;
   // Link tới trang sửa chi tiết sản phẩm
   case 'update_product_details':
      include_once './View/Admin/update_product_details.php';
      break;
   // Thực hiện việc chỉnh sửa chi tiết sản phẩm
   case 'update_action':
      $id = $_POST['id'];
      $price = $_POST['price'];
      $discount = $_POST['discount'];
      $quantity = $_POST['quantity'];
      $size = $_POST['size'];
      $img1 = $_POST['hinh1'];
      $img2 = $_POST['hinh2'];
      $img3 = $_POST['hinh3'];

      // Kiểm tra các trường hình ảnh
      $flag = false;

      // Xử lý logic cập nhật sản phẩm ở đây
      include_once ('../../Model/DBConfig.php');
      include_once ('../../Model/API.php');
      include_once ('../../Model/Product.php');
      $connect = new connect();
      $API = new API();
      $Product = new Product();
      $Product->update_ProductDetails($price, $discount, $quantity, $img1, $img2, $img3, $id);
      // Gửi phản hồi về client
      if ($flag == false) {
         $res = [
            'status' => 200,
         ];
      } else {
         $res = [
            'status' => 404,
            'message' => 'Đây không phải là tệp hình ảnh',
         ];
      }

      // Trả về kết quả
      echo json_encode($res);
      break;
   case 'get_all_product': 
      include_once ('../../Model/DBConfig.php');
      include_once ('../../Model/API.php');
      include_once ('../../Model/Product.php');
      $connect = new connect();
      $API = new API();
      $product = new Product();
      $result = $product->getAll_Product()->fetchAll(PDO::FETCH_ASSOC);
      echo json_encode($result);
      break;
   // Link tới trang thêm chi tiết sản phẩm
   case 'add_product_details':
      include_once './View/Admin/Add_Product_Details.php';
      break;
   // Thực hiện việc thêm chi tiết sản phẩm
   case 'add_product_details_action':
      include_once ('../../Model/DBConfig.php');
      include_once ('../../Model/API.php');
      include_once ('../../Model/Product.php');
      $connect = new connect();
      $API = new API();
      $product = new Product();
      $id = $_POST['product_id'];
      $price = str_replace('.', '', $_POST['price']); // Xóa bỏ . của tiền VNĐ
      $discount = preg_replace('/\./', '', $_POST['discount']);// Xóa bỏ . của tiền VNĐ
      $quantity = $_POST['quantity'];
      $size_id = $_POST['size_id'];
      $img1 = $_FILES['img1']['name'];
      $img2 = $_FILES['img2']['name'];
      $img3 = $_FILES['img3']['name'];

      //Kiểm tra sản phẩm đã tồn tại chưa = size và tên
      $check_product = $product->getDetailsProduct_ByNameSizeID($id, $size_id);
      if ($check_product) {
         $res = [
            'status' => 404,
            'message' => 'Size này đã tồn tại'
         ];
      } else {
         $product->add_ProductDetails($id, $size_id, $price, $discount, $quantity, $img1, $img2, $img3);
         $res = [
            'status' => 200,
            'message' => 'Thêm chi tiết sản phẩm thành công',
         ];
      }
      echo json_encode($res);
      break;
   // Thực hiện việc xóa chi tiết sản phẩm
   case 'delete_ProductDetails':     
      include_once ('../../Model/DBConfig.php');
      include_once ('../../Model/API.php');
      include_once ('../../Model/Product.php');
      $connect = new connect();
      $API = new API();
      $product = new Product();
      $product_details_id = $_POST['product_details_id'];
      $result = $product->delete_ProductDetails($product_details_id);
      $res = [
         'status' => 200,
         'message' => 'Đã xóa thành công',
      ];
      echo json_encode($res);
      break;
   // Link tới trang chỉnh sửa sản phẩm
   case 'update_Product':
      include_once "./View/Admin/Update_Product.php";
      break;
   // Thực hiện việc chỉnh sửa sản phẩm
   case 'update_actionPro':
      $id = $_POST['id'];
      $name = $_POST['name'];
      $shoes_type_id = $_POST['shoes_type_id'];
      $brand_id = $_POST['brand_id'];
      $descriptions = $_POST['descriptions'];
      $img = $_POST['img'];
      include_once ('../../Model/DBConfig.php');
      include_once ('../../Model/API.php');
      include_once ('../../Model/Product.php');
      $connect = new connect();
      $API = new API();
      $Product = new Product();
      $result = $Product->update_Product($id, $name, $shoes_type_id, $brand_id, $descriptions, $img);
      if ($result) {
         $res = [
            'status' => 200,
            'message' => 'Thành công',
         ];
      } else {
         $res = [
            'status' => 400,
            'message' => 'Hãy thay đổi',
         ];
      }
      echo json_encode($res);
      break;
   // Thực hiện việc thêm sản phẩm
   case 'add_action':
      include_once ('../../Model/DBConfig.php');
      include_once ('../../Model/API.php');
      include_once ('../../Model/Product.php');
      $connect = new connect();
      $API = new API();
      $product = new Product();
      $name_product = $_POST['name_product'];
      $shoes_type_id = $_POST['shoes_type_id'];
      $brand_id = $_POST['brand_id'];
      $descriptions = $_POST['descriptions'];
      $img = $_FILES['img']['name'];
      $check_product = $product->get_ProductBy($name_product, $shoes_type_id, $brand_id);
      if ($check_product) {
         $res = [
            'status' => 404,
            'message' => 'Sản phẩm đã tồn tại'
         ];
      } else {
         $product->add_Product($name_product, $shoes_type_id, $brand_id, $descriptions, $img);
         $res = [
            'status' => 200,
            'message' => 'Thêm sản phẩm thành công',
         ];
      }
      echo json_encode($res);
      break;
   // Thực hiện việc xóa sản phẩm
   case 'delete_product':
      include_once ('../../Model/DBConfig.php');
      include_once ('../../Model/API.php');
      include_once ('../../Model/product.php');
      $connect = new connect();
      $API = new API();
      $product = new Product();
      $product_id = $_POST['product_id'];
      $result_product = $product->delete_Product($product_id);
      if($result_product) {
         $product->delete_DetailsOfProduct($product_id);
         $res = [
            'status' => 200,
            'message' => 'Xóa sản phẩm thành công',
         ];
      }
      echo json_encode($res);
      break;
   // Link tới trang chi tiết
   case 'product_detailss':
      include_once "./View/admin/themchitiet.php";
      break;
   // Đổ sản phẩm Brand
   case 'getAll_Brand':
      include_once ('../../Model/DBConfig.php');
      include_once ('../../Model/API.php');
      include_once ('../../Model/Brand.php');
      $connect = new connect();
      $API = new API();
      $brand = new Brand();
      $result_brand = $brand->getAll_Brand()->fetchAll(PDO::FETCH_ASSOC);
      echo json_encode($result_brand);
      break;
   // Thêm xóa phần brand
   case 'add_brand':
      include_once ('../../Model/DBConfig.php');
      include_once ('../../Model/API.php');
      include_once ('../../Model/Brand.php');
      $connect = new connect();
      $API = new API();
      $brand = new Brand();
      $name_brand = $_POST['name_brand'];
      // Kiểm tra xem tên thương hiệu đã tồn tại trong cơ sở dữ liệu hay chưa
      $existing_brand = $brand->get_BrandByName($name_brand);
      if ($existing_brand) {
         $res = [
            'status' => 403,
            'message' => 'Tên thương hiệu đã tồn tại',
         ];
      } else {
         $brand->add_Brand($name_brand);
         $res = [
            'status' => 200,
            'message' => 'Thêm thương hiệu thành công',
         ];
      }
      echo json_encode($res);
      break;
   case 'delete_brand':
      include_once ('../../Model/DBConfig.php');
      include_once ('../../Model/API.php');
      include_once ('../../Model/Brand.php');
      $connect = new connect();
      $API = new API();
      $brand = new Brand();
      $brand_id = $_POST['brand_id'];
      $result = $brand->delete_Brand($brand_id);
      if ($result) {
         $res = [
            'status' => 200,
            'message' => 'Đã xóa size thành công',
         ];
      }
      echo json_encode($res);
      break;
   // Đổ sản phẩm Brand
   case 'getAll_ShoesType':
      include_once ('../../Model/DBConfig.php');
      include_once ('../../Model/API.php');
      include_once ('../../Model/Shoes_Type.php');
      $connect = new connect();
      $API = new API();
      $shoes_type = new shoes_type();
      $result_shoes_type = $shoes_type->getAll_Shoes_Type()->fetchAll(PDO::FETCH_ASSOC);
      echo json_encode($result_shoes_type);
      break;
   // Thêm xóa phần loại giày
   case 'add_shoes_type':
      include_once ('../../Model/DBConfig.php');
      include_once ('../../Model/API.php');
      include_once ('../../Model/shoes_type.php');
      $connect = new connect();
      $API = new API();
      $shoes_type = new shoes_type();
      $name_shoes_type = $_POST['name_shoes_type'];
      // Kiểm tra xem đã tồn tại trong cơ sở dữ liệu hay chưa
      $existing_brand = $shoes_type->get_Shoes_TypeByName($name_shoes_type);
      if ($existing_brand) {
         $res = [
            'status' => 403,
            'message' => 'Tên loại giày đã tồn tại',
         ];
      } else {
         $shoes_type->add_Shoes_Type($name_shoes_type);
         $res = [
            'status' => 200,
            'message' => 'Thêm loại giày thành công',
         ];
      }
      echo json_encode($res);
      break;
   case 'delete_shoes_type':
      include_once ('../../Model/DBConfig.php');
      include_once ('../../Model/API.php');
      include_once ('../../Model/shoes_type.php');
      $connect = new connect();
      $API = new API();
      $shoes_type = new Shoes_Type();
      $shoes_type_id = $_POST['shoes_type_id'];
      $result = $shoes_type->delete_Shoes_Type($shoes_type_id);
      if ($result) {
         $res = [
            'status' => 200,
            'message' => 'Đã xóa size thành công',
         ];
      }
      echo json_encode($res);
      break;
   // Thêm xóa phần loại giày
   case 'getAll_Size':
      include_once ('../../Model/DBConfig.php');
      include_once ('../../Model/DBConfig.php');
      include_once ('../../Model/API.php');
      include_once ('../../Model/Size.php');
      $connect = new connect();
      $API = new API();
      $sizes = new size();
      $result_size = $sizes->getAll_size()->fetchAll(PDO::FETCH_ASSOC);
      echo json_encode($result_size);
      break;
   case 'add_size':
      include_once ('../../Model/DBConfig.php');
      include_once ('../../Model/API.php');
      include_once ('../../Model/Size.php');
      $connect = new connect();
      $API = new API();
      $sizes = new size();
      $size = $_POST['size'];
      $existing_brand = $sizes->get_sizeByName($size);
      if ($existing_brand) {
         $res = [
            'status' => 403,
            'message' => 'Tên size đã tồn tại',
         ];
      } else {
         $sizes->add_size($size);
         $res = [
            'status' => 200,
            'message' => 'Thêm size thành công',
         ];
      }
      echo json_encode($res);

      break;
   case 'delete_size':
      include_once ('../../Model/DBConfig.php');
      include_once ('../../Model/API.php');
      include_once ('../../Model/size.php');
      $connect = new connect();
      $API = new API();
      $sizes = new size();
      $size_id = $_POST['size_id'];
      $result = $sizes->delete_size($size_id);
      if ($result) {
         $res = [
            'status' => 200,
            'message' => 'Đã xóa size thành công',
         ];
      }
      echo json_encode($res);
      break;
   // Ẩn hiện sản phẩm
   case 'hidden_product':
      include_once ('../../Model/DBConfig.php');
      include_once ('../../Model/API.php');
      include_once ('../../Model/Product.php');
      $connect = new connect();
      $API = new API();
      $product = new Product();
      $product_id = $_POST['product_id'];
      $hidden = $_POST['hidden'];
      if($hidden == 0) {
         $product->hidden_product($product_id);
         $res = [
            'status' => 'hidden',
            'message'=> 'Ẩn sản phẩm thành công'
         ];
      }else {
         $product->show_product($product_id);
         $res = [
            'status' => 'show',
            'message'=> 'Hiện sản phẩm thành công'
         ];
      }
      echo json_encode($res);
      break;
   // Lấy dữ liệu sản phẩm theo ID để edit
   case 'get_product_by_id':
      $id = $_GET['id'];
      include_once ('../../Model/DBConfig.php');
      include_once ('../../Model/API.php');
      include_once ('../../Model/Product.php');
      $connect = new connect();
      $API = new API();
      $Product = new Product();
      $result = $Product->get_product_by_id($id);
      if ($result) {
         $product_data = $result->fetch(PDO::FETCH_ASSOC);
         echo json_encode([
            'status' => 200,
            'data' => $product_data
         ]);
      } else {
         echo json_encode([
            'status' => 404,
            'message' => 'Không tìm thấy sản phẩm'
         ]);
      }
      break;
}
