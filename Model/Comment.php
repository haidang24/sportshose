<?php
class Comment
{
   function get_comment($product_id)
   {
      $API = new API();
      return $API->get_All("SELECT 
         cmt.id, 
         cmt.user_id, 
         cmt.content, 
         cmt.img, 
         cmt.created_at, 
         u.firstname, 
         u.lastname, 
         img.avatar
     FROM 
         comment AS cmt
     JOIN 
         user AS u ON cmt.user_id = u.id
     LEFT JOIN 
         user_avatar AS img ON u.id = img.user_id
     WHERE 
         cmt.product_id = '$product_id'
     ORDER BY 
         cmt.id DESC;");
   }

   function get_comment_id($id)
   {
      $API = new API();
      return $API->get_one("SELECT * FROM comment WHERE id=$id");
   }

   function add_comment($content, $img, $user_id, $product_id)
   {
      $API = new API();
      return $API->add_delete_update("INSERT INTO `comment`(`content`,`img` ,`user_id`, `product_id`) 
         VALUES ('$content','$img' ,'$user_id','$product_id')");
   }

   function update_comment($id, $content) {
      $API = new API();
      return $API->add_delete_update("UPDATE `comment` SET `content`='$content' WHERE id=$id");
   } 

   function delete_comment($id)
   {
      $API = new API();
      return $API->add_delete_update("DELETE FROM comment WHERE id=$id");
   }

   // Lấy avatar của người comment theo user_id
   function get_avatar($user_id)
   {
      $API = new API();
      return $API->get_one("SELECT * FROM user_avatar WHERE user_id = '$user_id'");
   }

   // Xóa hình ảnh trong chỉnh sửa cmt
   function delete_img_comment($id) {
      $API = new API();
      return $API->add_delete_update("UPDATE `comment` SET `img`= NULL WHERE id=$id");
   }  

}
