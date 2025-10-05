<?php
$act = 'comment';
if (isset($_GET['act'])) {
   $act = $_GET['act'];
}

switch ($act) {
   case 'get_comment':
      include "../Model/DBConfig.php";
      include "../Model/API.php";
      include "../Model/Comment.php";
      $connect = new connect();
      $API = new API();
      $Comment = new Comment();
      
      $product_id = $_POST['product_id'] ?? $_GET['product_id'] ?? null;
      if (!$product_id) {
         echo json_encode(['error' => 'Missing product_id']);
         exit;
      }
      
      $result = $Comment->get_comment($product_id)->fetchAll(PDO::FETCH_ASSOC);
      echo json_encode($result);
      break;
   case 'get_comment_id':
      include "../Model/DBConfig.php";
      include "../Model/API.php";
      include "../Model/Comment.php";
      $connect = new connect();
      $API = new API();
      $Comment = new Comment();
      
      $comment_id = $_POST['comment_id'] ?? $_GET['comment_id'] ?? null;
      if (!$comment_id) {
         echo json_encode(['error' => 'Missing comment_id']);
         exit;
      }
      
      $result = $Comment->get_comment_id($comment_id);
      echo json_encode($result);
      break;
   case 'add_comment':
      include "../Model/DBConfig.php";
      include "../Model/API.php";
      include "../Model/Comment.php";
      $connect = new connect();
      $API = new API();
      $Comment = new Comment();

      $content = $_POST['content'];
      $img = $_POST['comment_image'];
      $user_id = $_POST['user_id'];
      $product_id = $_POST['product_id'];
      $result_comment = $Comment->add_comment($content, $img, $user_id, $product_id);
      if ($result_comment) {
         $res = [
            'status' => 200,
         ];
      } else {
         $res = [
            'status' => 403,
            'message' => 'Lỗi hệ thống'
         ];
      }
      echo json_encode($res);
      break;
   case 'update_comment':
      include "../Model/DBConfig.php";
      include "../Model/API.php";
      include "../Model/Comment.php";
      $connect = new connect();
      $API = new API();
      $comment = new comment();
      $comment_id = $_POST['comment_id'];
      $content = $_POST['content'];
      $result_comment = $comment->update_comment($comment_id, $content);
      if ($result_comment) {
         $res = [
            'status' => 200,
            'message' => 'Thay đổi thành công'
         ];
      } else {
         $res = [
            'status' => 403,
            'message' => 'Hãy thay đổi nội dung'
         ];
      }
      echo json_encode($res);
      break;
   case 'delete_comment':
      include "../Model/DBConfig.php";
      include "../Model/API.php";
      include "../Model/Comment.php";
      $connect = new connect();
      $API = new API();
      $comment = new comment();

      $comment_id = $_POST['comment_id'];
      $result_comment = $comment->delete_comment($comment_id);
      if ($result_comment) {
         $res = [
            'status' => 200,
         ];
      } else {
         $res = [
            'status' => 403,
            'message' => 'Lỗi hệ thống'
         ];
      }
      echo json_encode($res);
      break;
   // Xóa hình ảnh trong chỉnh sửa
   case 'delete_img_comment':
      include "../Model/DBConfig.php";
      include "../Model/API.php";
      include "../Model/Comment.php";
      $connect = new connect();
      $API = new API();
      $comment = new comment();
      $comment_id = $_POST['comment_id'];
      $result = $comment->delete_img_comment($comment_id);
      if($result) {
         $res = [
            'status' => 200
         ];
      }
      echo json_encode($res);
      break;
}