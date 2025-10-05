// Chỗ để bấm submit
// var arrayImg = ['#upload_img1', '#upload_img2', '#upload_img3'];
// Lấy ID file input
var fileImg = ['#avatar', '#comment_image', '#file-input'];
// Phần gán hiển thị cho ảnh 
var showImg = ['#preview_avatar', '#preview_comment_image' , '#preview_avatar_admin'];
// Thẻ small báo lỗi    
var showError = ['#avatar_error', '#preview_comment_error', '#avatar_admin_error'];
// Kiểm tra đúng sai để cho vào submit
var isValid = [false, false, false];

//Validate hình ảnh
fileImg.forEach((fileInput, index) => {
   $(document).on('change', fileInput, function () {
       var file_data = $(this).prop('files')[0];
       if (!file_data || file_data.length === 0) {
           $(showError[index]).text('Vui lòng chọn ảnh!');
           isValid[index] = false;
           return;
       }

       var type = file_data.type;
       var match = ["image/gif", "image/png", "image/jpg", "image/jpeg", "image/webp"];
       if (match.includes(type)) {
           var form_data = new FormData();
           form_data.append('file', file_data);
           $.ajax({
               url: 'Model/upload_img.php',
               contentType: false,
               processData: false,
               data: form_data,
               type: 'post',
               success: function (res) {
                   var data = JSON.parse(res);
                   if (data.status == 200) {
                        console.log(showImg[index]);
                       $(showImg[index]).attr('src', data.data);
                    //    $('#prevent_img').removeClass('hide');
                       $('#preview_comment_image').removeClass('d-none');
                       $(showError[index]).text('');
                       isValid[index] = true;
                   } else {
                       $(showError[index]).text(data.message);
                       isValid[index] = false;
                   }
               },
               error: function () {
                   $(showError[index]).text('Đã xảy ra lỗi khi upload ảnh.');
                   isValid[index] = false;
               }
           });
       } else {
           $(showError[index]).text('Chỉ được upload file ảnh');
           $(fileInput).val('');
           isValid[index] = false;
       }
   });
});
