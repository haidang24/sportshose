$(document).ready(function (){
   // Toggle Password Visibility for User Login
   $(document).on('click', '#show_password', function() {
      const passwordInput = $('#password');
      const icon = $(this).find('i');

      if (passwordInput.attr('type') === 'password') {
         passwordInput.attr('type', 'text');
         icon.removeClass('fa-eye').addClass('fa-eye-slash');
      } else {
         passwordInput.attr('type', 'password');
         icon.removeClass('fa-eye-slash').addClass('fa-eye');
      }
   });

   // Toggle Confirm Password Visibility for Registration
   $(document).on('click', '#show_confirm_password', function() {
      const passwordInput = $('#confirm_password');
      const icon = $(this).find('i');

      if (passwordInput.attr('type') === 'password') {
         passwordInput.attr('type', 'text');
         icon.removeClass('fa-eye').addClass('fa-eye-slash');
      } else {
         passwordInput.attr('type', 'password');
         icon.removeClass('fa-eye-slash').addClass('fa-eye');
      }
   });

   // Toggle Password Visibility for Admin Login
   $(document).on('click', '#togglePassword', function() {
      const passwordInput = $('#password');
      const icon = $(this).find('i');

      if (passwordInput.attr('type') === 'password') {
         passwordInput.attr('type', 'text');
         icon.removeClass('bi-eye-fill').addClass('bi-eye-slash-fill');
      } else {
         passwordInput.attr('type', 'password');
         icon.removeClass('bi-eye-slash-fill').addClass('bi-eye-fill');
      }
   });

   // User MetaMask Login
   $(document).on('click', '#userMetaMaskLogin', async function() {
      if (typeof window.ethereum !== 'undefined') {
         try {
            $(this).addClass('loading');

            // Request account access
            const accounts = await window.ethereum.request({ method: 'eth_requestAccounts' });
            const account = accounts[0];

            // Get signature for authentication
            const message = 'Sign this message to authenticate with your MetaMask wallet';
            const signature = await window.ethereum.request({
               method: 'personal_sign',
               params: [message, account]
            });

            // Send to backend for verification
            $.ajax({
               url: "Controller/User.php?act=metamask_login",
               method: 'POST',
               data: {
                  address: account,
                  signature: signature,
                  message: message
               },
               dataType: "json",
               success: (res) => {
                  $(this).removeClass('loading');
                  if(res.status == 200) {
                     Swal.fire({
                        position: "top-center",
                        icon: "success",
                        title: "Đăng nhập MetaMask thành công!",
                        showConfirmButton: false,
                        timer: 1500
                     });
                     setTimeout(() => {
                        window.location.href = 'index.php';
                     }, 1500);
                  } else {
                     Swal.fire({
                        icon: "error",
                        title: "Xác thực thất bại",
                        text: res.message || "Đăng nhập MetaMask thất bại",
                     });
                  }
               },
               error: () => {
                  $(this).removeClass('loading');
                  Swal.fire({
                     icon: "error",
                     title: "Lỗi kết nối",
                     text: "Không thể kết nối đến server",
                  });
               }
            });
         } catch (error) {
            $(this).removeClass('loading');
            Swal.fire({
               icon: "error",
               title: "Lỗi MetaMask",
               text: error.message || "Không thể kết nối với MetaMask",
            });
         }
      } else {
         Swal.fire({
            icon: "warning",
            title: "MetaMask không tìm thấy",
            text: "Vui lòng cài đặt extension MetaMask để sử dụng tính năng này",
            footer: '<a href="https://metamask.io/download/" target="_blank">Tải MetaMask</a>'
         });
      }
   });

   // User Login Form
   $(document).on('submit', '#formLogin_User', function(event) {
      event.preventDefault();
      
      const email = $('#email').val().trim();
      const password = $('#password').val().trim();
      
      if (email === '' || password === '') {
         Swal.fire({
            icon: "warning",
            title: "Thông báo",
            text: "Vui lòng nhập đầy đủ email và mật khẩu"
         });
         return;
      }

      const submitBtn = $(this).find('button[type="submit"]');
      submitBtn.addClass('loading');

      $.ajax({
         url: "Controller/User.php?act=login_action",
         method: 'POST',
         data: { email, password },
         dataType: "json",
         success: (res) => {
            submitBtn.removeClass('loading');
            if (res.status == 200) {
               Swal.fire({
                  position: "top-center",
                  icon: "success",
                  title: "Đăng nhập thành công!",
                  showConfirmButton: false,
                  timer: 1500
               });
               setTimeout(() => {
                  window.location.href = 'index.php';
               }, 1500);
            } else {
               Swal.fire({
                  icon: "error",
                  title: "Đăng nhập thất bại",
                  text: res.message || "Email hoặc mật khẩu không đúng"
               });
            }
         },
         error: () => {
            submitBtn.removeClass('loading');
            Swal.fire({
               icon: "error",
               title: "Lỗi kết nối",
               text: "Không thể kết nối đến server"
            });
         }
      });
   });

   // User Registration Form
   $(document).on('submit', '#register', function(event) {
      event.preventDefault();
      
      const firstname = $('#firstname').val().trim();
      const lastname = $('#lastname').val().trim();
      const email = $('#email').val().trim();
      const password = $('#password').val().trim();
      const confirm_password = $('#confirm_password').val().trim();
      
      // Clear previous errors
      $('.error-message').text('');
      
      let hasError = false;
      
      if (firstname === '') {
         $('#firstname_error').text('Vui lòng nhập họ');
         hasError = true;
      }
      
      if (lastname === '') {
         $('#lastname_error').text('Vui lòng nhập tên');
         hasError = true;
      }
      
      if (email === '') {
         $('#email_error').text('Vui lòng nhập email');
         hasError = true;
      } else if (!isValidEmail(email)) {
         $('#email_error').text('Email không hợp lệ');
         hasError = true;
      }
      
      if (password === '') {
         $('#password_error').text('Vui lòng nhập mật khẩu');
         hasError = true;
      } else if (password.length < 6) {
         $('#password_error').text('Mật khẩu phải có ít nhất 6 ký tự');
         hasError = true;
      }
      
      if (confirm_password === '') {
         $('#confirm_password_error').text('Vui lòng xác nhận mật khẩu');
         hasError = true;
      } else if (password !== confirm_password) {
         $('#confirm_password_error').text('Mật khẩu xác nhận không khớp');
         hasError = true;
      }
      
      if (hasError) {
         return;
      }

      const submitBtn = $(this).find('button[type="submit"]');
      submitBtn.addClass('loading');

      $.ajax({
         url: "Controller/User.php?act=register_action",
         method: 'POST',
         data: { firstname, lastname, email, password },
         dataType: "json",
         success: (res) => {
            submitBtn.removeClass('loading');
            if (res.status == 200) {
               Swal.fire({
                  position: "top-center",
                  icon: "success",
                  title: "Đăng ký thành công!",
                  text: res.message,
                  showConfirmButton: false,
                  timer: 2000
               });
               setTimeout(() => {
                  window.location.href = 'index.php?action=user&act=login';
               }, 2000);
            } else {
               Swal.fire({
                  icon: "error",
                  title: "Đăng ký thất bại",
                  text: res.message || "Có lỗi xảy ra khi đăng ký"
               });
            }
         },
         error: () => {
            submitBtn.removeClass('loading');
            Swal.fire({
               icon: "error",
               title: "Lỗi kết nối",
               text: "Không thể kết nối đến server"
            });
         }
      });
   });

   // Forgot Password Form
   $(document).on('submit', '#Form_Mail', function(event) {
      event.preventDefault();
      
      const email = $('#confirm_email').val().trim();
      
      if (email === '') {
         $('#confirm_email_error').text('Vui lòng nhập email');
         return;
      }
      
      if (!isValidEmail(email)) {
         $('#confirm_email_error').text('Email không hợp lệ');
         return;
      }
      
      const submitBtn = $(this).find('button[type="submit"]');
      submitBtn.addClass('loading');
      
      // This would need to be implemented in the backend
      $.ajax({
         url: "Controller/User.php?act=forgot_password",
         method: 'POST',
         data: { email },
         dataType: "json",
         success: (res) => {
            submitBtn.removeClass('loading');
            if (res.status == 200) {
               $('#confirm_email_success').text('Email khôi phục đã được gửi!');
               $('#confirm_email_error').text('');
               setTimeout(() => {
                  $('#exampleModal').modal('hide');
               }, 2000);
            } else {
               $('#confirm_email_error').text(res.message || 'Có lỗi xảy ra');
            }
         },
         error: () => {
            submitBtn.removeClass('loading');
            $('#confirm_email_error').text('Không thể kết nối đến server');
         }
      });
   });

   // Email validation function
   function isValidEmail(email) {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailRegex.test(email);
   }

   // MetaMask Login for Admin
   $(document).on('click', '#metamaskLogin', async function() {
      if (typeof window.ethereum !== 'undefined') {
         try {
            $(this).addClass('loading');

            // Request account access
            const accounts = await window.ethereum.request({ method: 'eth_requestAccounts' });
            const account = accounts[0];

            // Get signature for authentication
            const message = 'Sign this message to authenticate with your MetaMask wallet';
            const signature = await window.ethereum.request({
               method: 'personal_sign',
               params: [message, account]
            });

            // Send to backend for verification
            $.ajax({
               url: "Controller/Admin/login.php?act=metamask_login",
               method: 'POST',
               data: {
                  address: account,
                  signature: signature,
                  message: message
               },
               dataType: "json",
               success: (res) => {
                  $(this).removeClass('loading');
                  if(res.status == 200) {
                     Swal.fire({
                        position: "top-center",
                        icon: "success",
                        title: "MetaMask login successful!",
                        showConfirmButton: false,
                        timer: 1500
                     });
                     setTimeout(() => {
                        window.location.href = 'admin.php?action=product';
                     }, 1500);
                  } else {
                     Swal.fire({
                        icon: "error",
                        title: "Authentication failed",
                        text: res.message || "MetaMask login failed",
                     });
                  }
               },
               error: () => {
                  $(this).removeClass('loading');
                  Swal.fire({
                     icon: "error",
                     title: "Connection error",
                     text: "Could not connect to server",
                  });
               }
            });
         } catch (error) {
            $(this).removeClass('loading');
            Swal.fire({
               icon: "error",
               title: "MetaMask error",
               text: error.message || "Failed to connect with MetaMask",
            });
         }
      } else {
         Swal.fire({
            icon: "warning",
            title: "MetaMask not found",
            text: "Please install MetaMask extension to use this feature",
            footer: '<a href="https://metamask.io/download/" target="_blank">Download MetaMask</a>'
         });
      }
   });

   // Google Login (Placeholder - requires Google OAuth setup)
   $(document).on('click', '.btn-google, .btn-user-google', function() {
      Swal.fire({
         icon: "info",
         title: "Google Login",
         text: "Google OAuth integration coming soon!",
      });
   });

   // Facebook Login (Placeholder - requires Facebook SDK setup)
   $(document).on('click', '.btn-facebook, .btn-user-facebook', function() {
      Swal.fire({
         icon: "info",
         title: "Facebook Login",
         text: "Facebook login integration coming soon!",
      });
   });

   // Traditional Login
   $(document).on('submit','#formLogin',function(event) {
       event.preventDefault();
       var username = $('#username').val();
       var password = $('#password').val();
       if(username.trim() == '' || password.trim() == '') {
           Swal.fire("Please enter username and password");
           return;
       }

       const submitBtn = $(this).find('button[type="submit"]');
       submitBtn.addClass('loading');

       $.ajax({
         url: "Controller/Admin/login.php?act=login_action",
         method: 'POST',
         data: {username, password},
         dataType: "json",
         success: (res) => {
            submitBtn.removeClass('loading');
            if(res.status == 200) {
               Swal.fire({
                  position: "top-center",
                  icon: "success",
                  title: "Login successful!",
                  showConfirmButton: false,
                  timer: 1500
               });
               setTimeout(() => {
                  window.location.href = 'admin.php?action=product';
               }, 1500)
            }else {
               Swal.fire({
                  icon: "error",
                  title: "Login failed",
                  text: "Invalid username or password",
               });
            }
         },
         error: () => {
            submitBtn.removeClass('loading');
            Swal.fire({
               icon: "error",
               title: "Connection error",
               text: "Could not connect to server",
            });
         }
       })
   })

   // Đăng xuất
   $(document).on('click', '#log_out', function() {
      $.ajax({
         url: 'Controller/Admin/login.php?act=log_out',
         method: 'GET',
         dataType: 'json',
         success: (res) => {
            console.log(res);
            if(res.status == 200) {
               window.location.href = "admin.php?action=login";
            }
         }
      })
   })
});