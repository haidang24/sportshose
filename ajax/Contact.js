$(document).ready(() => {
   // Gửi form đi
   $('#Form_Contact').on('submit', function (event) {
      event.preventDefault();

      fullname = $('#fullname').val();
      email = $('#email').val();
      number_phone = $('#number_phone').val();
      content = $('#content').val();
      // Kiểm tra họ tên
      result_name = check_name('#fullname');
      // Kiểm tra số điện thoại 
      result_phone = check_number_phone('#number_phone')
      // Kiểm tra email
      result_email = check_email('#email');
      // Kiểm tra content trống
      result_empty = check_empty('#content');

      if (result_name == false && result_phone == false && result_email == false && result_empty == false) {
         $.ajax({
            url: 'Controller/contact.php?act=form_Contact',
            method: 'post',
            data: {
               fullname: fullname,
               email: email,
               number_phone: number_phone,
               content: content
            },
            dataType: 'json',
            success: (res) => {
               if (res.status == 200) {
                  Swal.fire({
                     position: "top-center",
                     icon: "success",
                     title: res.message,
                     showConfirmButton: false,
                     timer: 1500
                  });
                  $('#fullname').val('');
                  $('#email').val('');
                  $('#number_phone').val('');
                  $('#content').val('');
               }
            }
         })
      }
   })


   // Chức năng đánh dấu đã đọc
   $(document).on('click', '#read_contact', function () {
      contact_id = $(this).val();
      var $checkbox = $(this); // Lưu lại context của `this` để sử dụng sau
      Swal.fire({
         title: "Bạn đã đọc kỹ chưa?",
         text: "Hành động này không thể hoàn tác",
         icon: "warning",
         showCancelButton: true,
         confirmButtonColor: "#3085d6",
         cancelButtonColor: "#d33",
         confirmButtonText: "Rồi!",
         cancelButtonText: "Hủy!"
      }).then((result) => {
         if (result.isConfirmed) {
            $.ajax({
               url: 'Controller/Admin/contact.php?act=read_contact',
               method: 'POST',
               data: { contact_id },
               dataType: 'json',
               success: () => {
                  $checkbox.prop('disabled', true); // Sử dụng prop để disable checkbox
               },
               error: (error) => console.log(error)
            })
         }else {
            $checkbox.prop('checked', false); // Nếu người dùng chọn "Hủy", bỏ tích checkbox
         }
      });
   })
})