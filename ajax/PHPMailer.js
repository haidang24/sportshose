$(document).ready(() => {
   $('#Form_Mail').on('submit', function (event) {
      event.preventDefault();
      mail = $('#confirm_email').val();


      flag = false;
      const emailPattern = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;
      if (mail.trim() == '') {
         $('#confirm_email_error').text('Email không để trống')
         flag = true;
      } else if (!emailPattern.test(mail)) {
         $('#confirm_email_error').text('Email không đúng định dạng')
         flag = true;
      } else {
         $('#confirm_email_error').text('')
      }

      if (flag == false) {
         $('#confirm_email_success').text('Đang gửi mail...');
         $.ajax({
            url: 'Controller/PHPMailer.php?act=PHPMailer',
            method: 'post',
            data: { mail: mail },
            dataType: 'json',
            success: function (res) {
               if (res['status'] == 200) {
                  window.location.href = 'index.php?action=user&act=confirm_code';
                  $('#confirm_email_success').text('');
               } else {
                  $('#confirm_email_success').text('');
                  setTimeout(function () {
                     $('#confirm_email_error').text('Email không tồn tại');
                  }, 100);
               }
            }
         });
      }
   })

   // Xác nhận code
   $('#Form_ConfirmCode').on('submit', function (event) {
      event.preventDefault();
      code = $('#code').val();
      $.ajax({
         url: 'Controller/PHPMailer.php?act=confirm_code',
         method: 'post',
         data: { code: code },
         dataType: 'json',
         success: (res) => {
            if (res.status == 404) {
               $('#code_error').text('Mã không hợp lệ')
               if (res.count > 2) {
                  alert('Hết lượt nhập');
                  window.location.href = 'index.php?action=user&act=login';
               }
            } else {
               Swal.fire({
                  position: "top-center",
                  icon: "success",
                  title: "Mã hợp lệ",
                  showConfirmButton: false,
                  timer: 1500
               });
               setTimeout(() => {
                  window.location.href = 'index.php?action=user&act=reset_pass';
               }, 1500);
            }
         }
      })
   })

   // Đổi mật khẩu sau khi nhập code hợp lệ
   $('#Form_ChangePass').on('submit', function (event) {
      event.preventDefault();
      newpass = $('#newpass').val();
      changepass = $('#changepass').val();
      flag = false;
      if (newpass != changepass) {
         $('#password_error').text('Mật khẩu không khớp');
         flag = true;
      } else if (newpass.length < 6 || changepass.length < 6) {
         $('#password_error').text('Mật khẩu phải trên 6 ký tự');
         flag = true;
      }

      if (flag == false) {
         $.ajax({
            url: 'Controller/PHPMailer.php?act=changepass',
            method: 'post',
            data: { newpass: newpass },
            dataType: 'json',
            success: (res) => {
               console.log(res);
               if (res.status == 200) {
                  Swal.fire({
                     position: "top-center",
                     icon: "success",
                     title: "Thay đổi mật khẩu thành công",
                     showConfirmButton: false,
                     timer: 1500
                  });
                  setTimeout(() => {
                     window.location.href = 'index.php?action=user&act=login';
                  }, 1500);
               }
            },
            error: (error) => { console.log(error) }
         })
      }
   })
})