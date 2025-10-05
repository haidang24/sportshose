$(document).ready(() => {
   var product_id = $('#comment_product_id').val();

   // Lấy tất cả bình luận theo product_id
   function get_comment() {
      var product_id = $('#comment_product_id').val();
      var user_id = $('#user_id').val();
      $.ajax({
         url: 'Controller/comment.php?act=get_comment',
         method: 'POST',
         data: { product_id },
         dataType: 'json',
         success: (res) => {

            $('.table_comment').empty();
            res.forEach(item => {
               // console.log(item);
               const table_comment = `
                      <div class="col-lg-10">
                          <div class="d-flex">
                              <img style="width: 50px; height: 50px; border-radius: 50px;" src="./View/assets/img/avatar/${(item.avatar) ? item.avatar : 'avatar-trang-4.jpg'}" alt="">
                              <div class="mx-4">
                                  <b class="fs-6">${item.firstname} ${item.lastname}</b>
                                  <div class="d-flex">
                                      <i class="bi bi-star-fill text-warning mx-1" style="font-size: 10px;"></i>
                                      <i class="bi bi-star-fill text-warning mx-1" style="font-size: 10px;"></i>
                                      <i class="bi bi-star-fill text-warning mx-1" style="font-size: 10px;"></i>
                                      <i class="bi bi-star-fill text-warning mx-1" style="font-size: 10px;"></i>
                                      <i class="bi bi-star-fill text-warning mx-1" style="font-size: 10px;"></i>
                                      <div class="mx-3" style="border-left: 1px solid #666"></div>
                                      <span style="font-size: 13px;">${item.created_at}</span>
                                  </div>
                                  <p class="pt-3 fw-bolder" style="white-space: pre-wrap;">${item.content}</p>

                                  ${(item.img) ? `<img class="mb-3" style="width: 100px; height: 100px; margin-left: 10px;" src="./View/assets/img/avatar/${item.img}" alt="">` : ''}

                                  ${item.user_id == user_id ? `
                                  <div class='d-flex justify-content-end'>
                                      <span data-comment_id='${item.id}' id='update_comment' style="cursor: pointer; font-size: 17px;" class="text-secondary">chỉnh sửa</span>
                                      <div class="mx-3" style="border-left: 1px solid #666"></div>
                                      <span data-comment_id='${item.id}' id='delete_comment' style="cursor: pointer; font-size: 17px;" class="text-secondary">xóa</span>
                                  </div>
                                  ` : ''}

                              </div>
                          </div>
                          <hr style="width: 100%">
                      </div>`;

               $('.table_comment').append(table_comment);
            });
         }
      });
   }

   // Hiển thị modal chỉnh sửa bình luận
   $(document).on('click', '#update_comment', function() {
      comment_id = $(this).data('comment_id')
      $('#model_update_comment_id').val(comment_id)
      $('#delete_img_comment').data('comment_id', comment_id);
      $('#model_update_comment').modal('show');
   })

   get_comment();

   $(document).on('click', '#send_comment', function () {
      content = $('#content_comment').val();
      product_id = $('#comment_product_id').val()
      user_id = $('#comment_user_id').val();
      comment_image = $('#comment_image').val().split('\\').pop();
      flag = false;
      if (content.trim() == '') {
         flag = true;
      }

      if (flag == false) {
         $.ajax({
            url: 'Controller/comment.php?act=add_comment',
            method: 'POST',
            data: { content, comment_image, product_id, user_id },
            dataType: 'json',
            success: (res) => {
               if (res.status == 200) {
                  get_comment();
                  // reset lại ô nhập thành rỗng
                  $('#content_comment').val('');
                  $('#preview_comment_image').addClass('d-none');

               } else {
                  Swal.fire({
                     icon: "error",
                     text: res.message,
                  });
               }
            }
         })
      }
   })

   // Update comment (đổ dữ liệu)
   $(document).on('click', '#update_comment', function () {
      comment_id = $(this).data('comment_id');
      $.ajax({
         url: 'Controller/comment.php?act=get_comment_id',
         method: 'POST',
         data: { comment_id },
         dataType: 'json',
         success: (res) => {
            console.log(res.img);
            $('#update_content_comment').val(res.content);
            (res.img.length > 0) ? $('#update_img_comment').removeClass('d-none') : $('#update_img_comment').addClass('d-none');
            (res.img.length > 0) ? $('#delete_img_comment').removeClass('d-none') : $('#delete_img_comment').addClass('d-none');
            $('#update_img_comment').attr('src', `./View/assets/img/avatar/${res.img}`);
         }
      })
   })

   // thực hiện việc update
   $(document).on('click', '#update_comment_action', function () {
      comment_id = $('#model_update_comment_id').val();
      content = $('#update_content_comment').val();
      $.ajax({
         url: 'Controller/comment.php?act=update_comment',
         method: 'POST',
         data: { comment_id, content },
         dataType: 'json',
         success: (res) => {
            if (res.status == 200) {
               Swal.fire({
                  position: "top-center",
                  icon: "success",
                  title: res.message,
                  showConfirmButton: false,
                  timer: 1500
               })
               get_comment();
               $('#model_update_comment').modal('hide')
            } else {
               Swal.fire({
                  position: "top-center",
                  icon: "success",
                  title: res.message,
                  showConfirmButton: false,
                  timer: 1500
               })
               $('#model_update_comment').modal('hide')
            }
         }
      })
   })
   // ---- 

   // Xóa hình ảnh trong chỉnh sửa
   $(document).on('click', '#delete_img_comment', function () {
      comment_id = $(this).data('comment_id');
      $.ajax({
         url: 'Controller/comment.php?act=delete_img_comment',
         method: 'POST',
         data: { comment_id },
         dataType: 'json',
         success: (res) => {
            if (res.status == 200) {
               // Bỏ hình ảnh 
               $('#update_img_comment').attr('src', '');
               // ẩn hình ảnh 
               $('#update_img_comment').addClass('d-none');
               // ẩn button X
               $('#delete_img_comment').addClass('d-none');
            }
         }
      })
   })

   //Xóa comment
   $(document).on('click', '#delete_comment', function () {
      comment_id = $(this).data('comment_id');
      Swal.fire({
         title: "Bạn có chắc chắn xóa?",
         icon: "warning",
         showCancelButton: true,
         confirmButtonColor: "#3085d6",
         cancelButtonColor: "#d33",
         confirmButtonText: "Xóa!",
         cancelButtonText: "Hủy!"
      }).then((result) => {
         if (result.isConfirmed) {
            $.ajax({
               url: 'Controller/comment.php?act=delete_comment',
               method: 'POST',
               data: { comment_id },
               dataType: 'json',
               success: (res) => {
                  if (res.status == 200) {
                     get_comment();
                  } else {
                     Swal.fire({
                        icon: "error",
                        text: res.message,
                     });
                  }
               }
            })
         }
      });
   })
})