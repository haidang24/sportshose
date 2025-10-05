$(document).ready(() => {
   // Hiện thị mật khẩu
   $(document).on('click', '#show_password', function () {
      $('#password_old').val();
      $('#password_new').val();
      $('#confirm_password_new').val();
      var inputType1 = $('#password_old').attr('type');
      var inputType2 = $('#password_new').attr('type');
      var inputType3 = $('#confirm_password_new').attr('type');
      (inputType1 === 'password') ? $('#password_old').attr('type', 'text') : $('#password_old').attr('type', 'password');
      (inputType2 === 'password') ? $('#password_new').attr('type', 'text') : $('#password_new').attr('type', 'password');
      (inputType3 === 'password') ? $('#confirm_password_new').attr('type', 'text') : $('#confirm_password_new').attr('type', 'password');
   })

   // Đổi mật khẩu trang admin
   $(document).on('submit', '#form_change_password1', function (event) {
      event.preventDefault();
      result_password_old = check_empty('#password_old')
      result_password_new = check_empty('#password_new')
      result_confirm_password = check_empty('#confirm_password')

      admin_id = $('#admin_id').val();

      if (result_password_old == false && result_password_new == false && result_confirm_password == false) {
         var form_change_password1 = new FormData(this)
         $.ajax({
            url: 'Controller/change_password.php?act=update_password_admin',
            method: 'POST',
            data: form_change_password1,
            contentType: false,
            processData: false,
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
               } else if (res.status == 404) {
                  $('#password_old_error').text(res.message)
               } else if (res.status == 403) {
                  $('#password_new_error').text(res.message)
               } else {
                  Swal.fire({
                     icon: "error",
                     title: "Trùng...",
                     text: res.message,
                  });
               }
            }, error: (error) => console.log(error)
         })
      }
   })

   // Đổi mật khẩu trang người dùng
   $(document).on('submit', '#form_change_password', function (event) {
      event.preventDefault();
      // Kiểm tra trống
      result_empty = check_empty('#password_old', '#password_new', '#confirm_password_new');

      user_id = $('#user_id').val();
      if (result_empty == false) {

         var form_change_password = new FormData(this)

         $.ajax({
            url: 'Controller/change_password.php?act=update_password',
            method: 'POST',
            data: form_change_password,
            contentType: false,
            processData: false,
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
               } else if (res.status == 404) {
                  $('#password_old_error').text(res.message)
               } else if (res.status == 403) {
                  $('#password_new_error').text(res.message)
               } else {
                  Swal.fire({
                     icon: "error",
                     title: "Trùng...",
                     text: res.message,
                  });
               }
            }, error: (error) => console.log(error)
         })
      }
   })
})