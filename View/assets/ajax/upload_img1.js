var fileImg1 = ['#img', '#img1', '#img2', '#img3'];
// Phần gán hiển thị cho ảnh 
var showImg1 = ['#preview_img', '#preview_img1' , '#preview_img2', '#preview_img3'];
// Thẻ small báo lỗi    
var showError1 = ['#img_error', '#img1_error', '#img2_error', '#img3_error',];
// Kiểm tra đúng sai để cho vào submit
var isValid = [false, false, false, false];


//Validate hình ảnh
fileImg1.forEach((fileInput, index) => {
   $(document).on('change', fileInput, function () {
       var file_data = $(this).prop('files')[0];
       if (!file_data || file_data.length === 0) {
           $(showError1[index]).text('Vui lòng chọn ảnh!');
           isValid[index] = false;
           return;
       }

       var type = file_data.type;
       var match = ["image/gif", "image/png", "image/jpg", "image/jpeg", "image/webp"];
       if (match.includes(type)) {
           var form_data = new FormData();
           form_data.append('file', file_data);
           $.ajax({
               url: 'Model/upload_img1.php',
               contentType: false,
               processData: false,
               data: form_data,
               type: 'post',
               success: function (res) {
                   var data = JSON.parse(res);
                   if (data.status == 200) {
                       $(showImg1[index]).attr('src', data.data);
                       $(showImg1[index]).removeClass('d-none');
                       $(showError1[index]).text('');
                       isValid[index] = true;
                   } else {
                       $(showError1[index]).text(data.message);
                       isValid[index] = false;
                   }
               },
               error: function () {
                   $(showError1[index]).text('Đã xảy ra lỗi khi upload ảnh.');
                   isValid[index] = false;
               }
           });
       } else {
           $(showError1[index]).text('Chỉ được upload file ảnh');
           $(fileInput).val('');
           isValid[index] = false;
       }
   });
});
