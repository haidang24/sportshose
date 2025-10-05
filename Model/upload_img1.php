<?php 
   if(!empty($_FILES['file'])) {
      // đường link chứa ảnh
      $target_dir = "../View/assets/img/upload/";
      // lấy tên hình
      $target_file = $target_dir . basename($_FILES['file']['name']);

      // biến phần mở rộng của file thành chữ thường
      $imageFileType = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));

      $type_fileAllow = array('png', 'jpg', 'jpeg', 'gif', 'webp');

      if(file_exists($target_file)) {
         $res = [
            'status' => 200,
            'message' => 'Upload thành công!!!',
            'data' => './View/assets/img/upload/' . $_FILES['file']['name'],
         ];
         echo json_encode($res);
      }else {
         if(move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
            $res = [
               'status' => 200,
               'message' => 'Upload thành công!!!',
               'data' => './View/assets/img/upload/' . $_FILES['file']['name'],
            ];
            echo json_encode($res);
         }
      }
   }